/**
 * PC Budget Calculator — Alpine.js component.
 *
 * Markup lives in page-pc-budget-calculator.php (server-rendered for SEO).
 * Config is passed via `data-config` JSON on the x-data element.
 *
 * Features: live totals, SVG donut chart (no library), budget bar,
 * custom parts, localStorage persistence and shareable URLs.
 */

const STORAGE_KEY = 'hx_pc_budget_v1';
const MAX_DIGITS = 10; // up to 9,999,999,999
const MAX_CUSTOM = 10;
const PALETTE_SIZE = 12;
const RADIUS = 80;
const CIRC = 2 * Math.PI * RADIUS;
const SVG_NS = 'http://www.w3.org/2000/svg';

const colorVar = (idx) => `var(--color-part-${(idx % PALETTE_SIZE) + 1})`;
const toInt = (v) => {
	const n = parseInt(String(v ?? '').replace(/\D/g, '').slice(0, MAX_DIGITS), 10);
	return Number.isFinite(n) && n > 0 ? n : 0;
};

export default function pcBudgetCalc() {
	// Non-reactive helpers (kept out of Alpine's proxy on purpose:
	// Intl objects and DOM maps break when wrapped in a Proxy).
	let formatter = new Intl.NumberFormat('en-LK', { maximumFractionDigits: 0 });
	const circles = new Map();
	let defaults = {};
	let copiedTimer = null;

	return {
		currency: 'LKR',
		budget: 0,
		parts: {},
		order: [],
		customParts: [],
		nextCustomId: 1,
		activeKey: null,
		copied: false,
		maxCustom: MAX_CUSTOM,
		showExtras: false,

		init() {
			let cfg = {};
			try {
				cfg = JSON.parse(this.$el.dataset.config || '{}');
			} catch (e) {
				cfg = {};
			}

			this.currency = cfg.currency || 'LKR';
			try {
				formatter = new Intl.NumberFormat(cfg.locale || 'en-LK', { maximumFractionDigits: 0 });
			} catch (e) {
				/* keep fallback formatter */
			}

			(cfg.parts || []).forEach((p, i) => {
				this.parts[p.key] = { key: p.key, label: p.label, price: 0, enabled: !!p.enabled, color: i, group: p.group || 'core' };
				this.order.push(p.key);
				defaults[p.key] = !!p.enabled;
			});

			if (!this.loadFromUrl()) {
				this.loadFromStorage();
			}

			// Automatically reveal extras if user has priced any extra or added custom parts
			const hasPricedExtras = this.order.some((k) => this.parts[k]?.group === 'extra' && this.parts[k]?.price > 0);
			if (hasPricedExtras || this.customParts.length > 0) {
				this.showExtras = true;
			}

			this.$watch('snapshot', (value) => {
				this.save(value);
				this.renderChart();
			});
			this.$watch('activeKey', () => this.applyActive());

			this.$nextTick(() => this.renderChart());
		},

		/* ---------- Derived state ---------- */

		get items() {
			const std = this.order
				.map((k) => this.parts[k])
				.filter((p) => p.enabled && p.price > 0)
				.map((p) => ({ key: p.key, label: p.label, price: p.price, color: p.color }));

			const custom = this.customParts
				.filter((c) => c.price > 0)
				.map((c) => ({
					key: `c${c.id}`,
					label: c.name.trim() || 'Custom part',
					price: c.price,
					color: c.color,
				}));

			return [...std, ...custom];
		},

		get total() {
			return this.items.reduce((sum, i) => sum + i.price, 0);
		},

		get hasBudget() {
			return this.budget > 0;
		},

		get remaining() {
			return this.budget - this.total;
		},

		get overBudget() {
			return this.hasBudget && this.total > this.budget;
		},

		/** Value the chart represents 100% of. */
		get base() {
			return this.hasBudget ? Math.max(this.budget, this.total) : this.total;
		},

		get usedPercent() {
			return this.hasBudget ? (this.total / this.budget) * 100 : 0;
		},

		get segments() {
			if (!this.base) return [];
			const segs = this.items.map((i) => ({ ...i, pct: (i.price / this.base) * 100, isRemaining: false }));
			if (this.hasBudget && this.remaining > 0) {
				segs.push({
					key: 'remaining',
					label: 'Unallocated',
					price: this.remaining,
					pct: (this.remaining / this.base) * 100,
					color: null,
					isRemaining: true,
				});
			}
			return segs;
		},

		get biggest() {
			return this.items.reduce((max, i) => (!max || i.price > max.price ? i : max), null);
		},

		get enabledCount() {
			return this.order.filter((k) => this.parts[k].enabled).length + this.customParts.length;
		},

		get pricedCount() {
			return this.items.length;
		},

		get chartLabel() {
			if (!this.total) return 'Budget split chart. No part prices entered yet.';
			const list = this.segments.map((s) => `${s.label} ${this.pct(s.pct)}`).join(', ');
			return `Budget split chart. Total ${this.money(this.total)}. ${list}.`;
		},

		/** Serialized state — watched to persist & redraw. */
		get snapshot() {
			return JSON.stringify({
				b: this.budget,
				p: this.order.map((k) => [k, this.parts[k].price, this.parts[k].enabled ? 1 : 0]),
				c: this.customParts.map((c) => [c.id, c.name, c.price, c.color]),
			});
		},

		/* ---------- Formatting ---------- */

		fmt(n) {
			return formatter.format(Math.round(n || 0));
		},

		money(n) {
			const sign = n < 0 ? '-' : '';
			return `${sign}${this.currency} ${this.fmt(Math.abs(n))}`;
		},

		fmtInput(n) {
			return n > 0 ? this.fmt(n) : '';
		},

		pct(n) {
			if (!n) return '0%';
			return n < 10 ? `${n.toFixed(1)}%` : `${Math.round(n)}%`;
		},

		color(idx) {
			return idx === null ? 'var(--color-part-remaining)' : colorVar(idx);
		},

		/* ---------- Input handling ---------- */

		/**
		 * Parse a money input, reformat with thousand separators and keep the caret
		 * in the same logical position.
		 */
		readMoney(event) {
			const el = event.target;
			const caret = el.selectionStart ?? el.value.length;
			const digitsBefore = el.value.slice(0, caret).replace(/\D/g, '').length;
			const value = toInt(el.value);
			const formatted = this.fmtInput(value);

			if (el.value !== formatted) {
				el.value = formatted;
				let pos = 0;
				let seen = 0;
				while (pos < formatted.length && seen < digitsBefore) {
					if (/\d/.test(formatted[pos])) seen++;
					pos++;
				}
				try {
					el.setSelectionRange(pos, pos);
				} catch (e) {
					/* not focusable / unsupported */
				}
			}
			return value;
		},

		setBudget(event) {
			this.budget = this.readMoney(event);
		},

		setBudgetPreset(amt) {
			this.applyPreset(amt);
		},

		applyPreset(amt) {
			const n = toInt(amt);
			if (!n) {
				this.budget = 0;
				const budgetEl = document.getElementById('hx-pcbc-budget');
				if (budgetEl) budgetEl.value = '';
				return;
			}

			// Realistic Sri Lankan hardware market allocations (accounting for current GPU & RAM import pricing)
			const presetAllocations = {
				150000: { cpu: 32000, motherboard: 28000, ram: 15000, gpu: 50000, storage: 10000, psu: 8000, case: 7000 },
				250000: { cpu: 42000, motherboard: 32000, ram: 20000, gpu: 110000, storage: 16000, psu: 17000, case: 13000 },
				350000: { cpu: 65000, motherboard: 46000, ram: 35000, gpu: 155000, storage: 18000, psu: 18000, case: 13000 },
				500000: { cpu: 90000, motherboard: 62000, ram: 45000, gpu: 230000, storage: 25000, psu: 26000, case: 22000 },
			};

			this.budget = n;
			const budgetEl = document.getElementById('hx-pcbc-budget');
			if (budgetEl) {
				budgetEl.value = this.fmtInput(n);
			}

			const alloc = presetAllocations[n];
			if (alloc) {
				this.order.forEach((k) => {
					if (alloc[k] !== undefined) {
						this.parts[k].price = alloc[k];
						this.parts[k].enabled = true;
					} else {
						this.parts[k].price = 0;
						if (this.parts[k].group === 'extra') {
							this.parts[k].enabled = false;
						}
					}
					const inputEl = document.getElementById(`hx-part-${k}`);
					if (inputEl) {
						inputEl.value = this.fmtInput(this.parts[k].price);
					}
				});
			}

			this.$nextTick(() => {
				this.renderChart();
			});
		},

		setPartPrice(key, event) {
			const value = this.readMoney(event);
			this.parts[key].price = value;
			if (value > 0) this.parts[key].enabled = true;
		},

		setCustomPrice(part, event) {
			part.price = this.readMoney(event);
		},

		nextColor() {
			const used = new Set([
				...this.order.filter((k) => this.parts[k].enabled).map((k) => this.parts[k].color % PALETTE_SIZE),
				...this.customParts.map((c) => c.color % PALETTE_SIZE),
			]);
			for (let i = 0; i < PALETTE_SIZE; i++) {
				if (!used.has(i)) return i;
			}
			return (this.order.length + this.customParts.length) % PALETTE_SIZE;
		},

		addCustom() {
			if (this.customParts.length >= MAX_CUSTOM) return;
			const id = this.nextCustomId++;
			this.customParts.push({ id, name: '', price: 0, color: this.nextColor() });
			this.$nextTick(() => document.getElementById(`hx-pcbc-custom-name-${id}`)?.focus());
		},

		removeCustom(id) {
			this.customParts = this.customParts.filter((c) => c.id !== id);
			if (this.activeKey === `c${id}`) this.activeKey = null;
		},

		reset() {
			this.budget = 0;
			this.order.forEach((k) => {
				this.parts[k].price = 0;
				this.parts[k].enabled = defaults[k];
			});
			this.customParts = [];
			this.nextCustomId = 1;
			this.activeKey = null;
			try {
				localStorage.removeItem(STORAGE_KEY);
			} catch (e) {
				/* storage unavailable */
			}
			this.$nextTick(() => document.getElementById('hx-pcbc-budget')?.focus());
		},

		/* ---------- Persistence & sharing ---------- */

		save(value) {
			try {
				localStorage.setItem(STORAGE_KEY, value || this.snapshot);
			} catch (e) {
				/* storage full / private mode */
			}
		},

		loadFromStorage() {
			let data;
			try {
				data = JSON.parse(localStorage.getItem(STORAGE_KEY) || 'null');
			} catch (e) {
				return false;
			}
			if (!data || typeof data !== 'object') return false;

			this.budget = toInt(data.b);
			(Array.isArray(data.p) ? data.p : []).forEach((row) => {
				if (!Array.isArray(row) || !this.parts[row[0]]) return;
				this.parts[row[0]].price = toInt(row[1]);
				this.parts[row[0]].enabled = !!row[2];
			});
			this.customParts = (Array.isArray(data.c) ? data.c : [])
				.slice(0, MAX_CUSTOM)
				.filter((row) => Array.isArray(row))
				.map((row, i) => ({
					id: i + 1,
					name: String(row[1] ?? '').slice(0, 40),
					price: toInt(row[2]),
					color: Number.isInteger(row[3]) ? row[3] : this.nextColor(),
				}));
			this.nextCustomId = this.customParts.length + 1;
			return true;
		},

		loadFromUrl() {
			const params = new URLSearchParams(window.location.search);
			const known = ['b', 'x', ...this.order];
			if (!known.some((k) => params.has(k))) return false;

			this.budget = toInt(params.get('b'));
			this.order.forEach((k) => {
				const price = toInt(params.get(k));
				this.parts[k].price = price;
				this.parts[k].enabled = price > 0;
			});

			this.customParts = [];
			(params.get('x') || '')
				.split('|')
				.filter(Boolean)
				.slice(0, MAX_CUSTOM)
				.forEach((chunk, i) => {
					const [name, price] = chunk.split('~');
					this.customParts.push({
						id: i + 1,
						name: String(name || '').slice(0, 40),
						price: toInt(price),
						color: this.nextColor(),
					});
				});
			this.nextCustomId = this.customParts.length + 1;

			// Clean the address bar — canonical stays the plain page URL.
			try {
				window.history.replaceState(null, '', window.location.pathname + window.location.hash);
			} catch (e) {
				/* ignore */
			}
			return true;
		},

		shareUrl() {
			const url = new URL(window.location.origin + window.location.pathname);
			if (this.budget) url.searchParams.set('b', this.budget);
			this.order.forEach((k) => {
				const p = this.parts[k];
				if (p.enabled && p.price > 0) url.searchParams.set(k, p.price);
			});
			const custom = this.customParts
				.filter((c) => c.price > 0)
				.map((c) => `${(c.name.trim() || 'Custom').replace(/[~|]/g, ' ').slice(0, 40)}~${c.price}`);
			if (custom.length) url.searchParams.set('x', custom.join('|'));
			return url.toString();
		},

		async copyShare() {
			const url = this.shareUrl();
			try {
				await navigator.clipboard.writeText(url);
				this.copied = true;
				clearTimeout(copiedTimer);
				copiedTimer = setTimeout(() => (this.copied = false), 2500);
			} catch (e) {
				window.prompt('Copy this link to share your build budget:', url);
			}
		},

		/* ---------- Chart ---------- */

		renderChart() {
			const group = this.$refs.donut;
			if (!group) return;

			const segs = this.segments;
			const gap = segs.length > 1 ? 1.25 : 0;
			const seen = new Set();
			let offset = 0;

			segs.forEach((s) => {
				seen.add(s.key);
				const len = (s.pct / 100) * CIRC;
				let el = circles.get(s.key);

				if (!el) {
					el = document.createElementNS(SVG_NS, 'circle');
					el.setAttribute('cx', '100');
					el.setAttribute('cy', '100');
					el.setAttribute('r', String(RADIUS));
					el.setAttribute('fill', 'none');
					el.setAttribute('class', 'hx-donut-seg');
					// Start collapsed at its position so it grows in.
					el.style.strokeDasharray = `0 ${CIRC}`;
					el.style.strokeDashoffset = String(-offset);
					const key = s.key;
					el.addEventListener('mouseenter', () => (this.activeKey = key));
					el.addEventListener('mouseleave', () => (this.activeKey = null));
					group.appendChild(el);
					el.getBoundingClientRect(); // force reflow so the transition runs
					circles.set(key, el);
				}

				el.style.stroke = this.color(s.isRemaining ? null : s.color);
				el.style.strokeDasharray = `${Math.max(len - gap, 0.01)} ${CIRC}`;
				el.style.strokeDashoffset = String(-offset);
				el.dataset.key = s.key;
				el.classList.toggle('is-remaining', s.isRemaining);
				offset += len;
			});

			circles.forEach((el, key) => {
				if (!seen.has(key)) {
					el.remove();
					circles.delete(key);
				}
			});

			this.applyActive();
		},

		applyActive() {
			circles.forEach((el, key) => {
				el.classList.toggle('is-active', this.activeKey === key);
				el.classList.toggle('is-dimmed', !!this.activeKey && this.activeKey !== key);
			});
		},

		activeSegment() {
			return this.segments.find((s) => s.key === this.activeKey) || null;
		},
	};
}
