---
document: 04 — Component Library
project: Web Shield
version: 1.0
status: Draft
audience: Developers
---

# 🧩 مكتبة المكونات (Component Library)

> هذه الوثيقة تحدد **كل مكون** ستستخدمه الواجهة. لكل مكون: التشريح، الحالات، أمثلة الاستخدام.

كل المكونات تستخدم Tokens من [`02-design-tokens.md`](./02-design-tokens.md). لا قيم سحرية.

---

## 1. الأزرار (Buttons)

### 1.1 الأنواع

| النوع | الكلاس | الاستخدام |
|------|--------|-----------|
| **Primary** | `.btn-shield-primary` | الإجراء الأساسي في الصفحة (حظر، حفظ). |
| **Secondary** | `.btn-shield-secondary` | إجراء ثانوي (إلغاء، رجوع). |
| **Ghost** | `.btn-shield-ghost` | بدون خلفية، فقط نص (في الجداول). |
| **Outline** | `.btn-shield-outline` | حواف فقط، خلفية شفافة. |
| **Danger** | `.btn-shield-danger` | إجراءات تدميرية (حذف نهائي). |
| **Icon-only** | `.btn-shield-icon` | زر أيقونة فقط (Icon Button). |

### 1.2 الأحجام

| الحجم | الكلاس | الارتفاع | الـ Padding |
|------|--------|---------|------------|
| Small | `.btn-sm` | 28px | 8px / 12px |
| Default | (فارغ) | 36px | 10px / 16px |
| Large | `.btn-lg` | 44px | 12px / 20px |

### 1.3 الحالات

كل زر له 5 حالات: `default` · `hover` · `active` · `disabled` · `loading`.

### 1.4 مثال CSS

```css
.btn-shield-primary {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  height: 36px;
  padding: 0 var(--space-4);
  background: var(--color-brand-500);
  color: var(--text-inverse);
  border: 1px solid var(--color-brand-500);
  border-radius: var(--radius-md);
  font-family: var(--font-display);
  font-size: var(--text-sm);
  font-weight: var(--weight-medium);
  cursor: pointer;
  transition: var(--transition-base);
}
.btn-shield-primary:hover {
  background: var(--color-brand-400);
  border-color: var(--color-brand-400);
  box-shadow: var(--glow-brand);
}
.btn-shield-primary:active { transform: translateY(1px); }
.btn-shield-primary:disabled {
  opacity: 0.4; cursor: not-allowed; box-shadow: none;
}
.btn-shield-primary.loading { pointer-events: none; }
.btn-shield-primary.loading::after {
  content: '';
  width: 14px; height: 14px;
  border: 2px solid transparent;
  border-top-color: currentColor;
  border-radius: 50%;
  animation: shield-spin 0.6s linear infinite;
}
```

### 1.5 مثال HTML

```html
<button class="btn-shield-primary">
  <i data-lucide="shield-check" class="icon icon-sm"></i>
  حظر العنوان
</button>

<button class="btn-shield-danger btn-sm">
  <i data-lucide="trash-2" class="icon icon-xs"></i>
  حذف
</button>

<button class="btn-shield-icon" aria-label="إعدادات">
  <i data-lucide="settings" class="icon icon-md"></i>
</button>
```

---

## 2. الكروت (Cards)

### 2.1 المكونات الفرعية

```
.shield-card
├── .shield-card-header   (اختياري)
│   ├── .shield-card-title
│   ├── .shield-card-subtitle
│   └── .shield-card-actions
├── .shield-card-body
└── .shield-card-footer    (اختياري)
```

### 2.2 المتغيرات

| المتغير | الكلاس | الوصف |
|--------|--------|-------|
| Default | `.shield-card` | كرت عادي |
| Highlighted | `.shield-card.is-highlighted` | حواف نيون خفيفة |
| Critical | `.shield-card.is-critical` | حدود حمراء، للتحذيرات |
| Compact | `.shield-card.is-compact` | padding أقل |

### 2.3 CSS

```css
.shield-card {
  background: var(--bg-surface-1);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  overflow: hidden;
  transition: var(--transition-base);
}
.shield-card:hover {
  border-color: var(--border-default);
}
.shield-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: var(--space-4);
  border-bottom: 1px solid var(--border-subtle);
}
.shield-card-title {
  font-family: var(--font-display);
  font-size: var(--text-md);
  font-weight: var(--weight-semibold);
  color: var(--text-primary);
}
.shield-card-body { padding: var(--space-4); }

.shield-card.is-highlighted {
  border-color: var(--color-brand-500);
  box-shadow: var(--glow-brand);
}
.shield-card.is-critical {
  border-color: var(--color-critical);
}
```

---

## 3. كرت الـ KPI (KPI Card)

> أهم مكون في لوحة التحكم. يجب أن يكون مميزاً.

### 3.1 التشريح

```
┌─────────────────────────────────┐
│ [icon] LABEL                    │  ← 11px UPPERCASE Tertiary
│                                 │
│ 1,247                  [pulse●] │  ← 32px Mono Bold + Live indicator
│                                 │
│ ↑ 12% خلال 24 ساعة      [spark]│  ← 11px secondary + sparkline
└─────────────────────────────────┘
```

### 3.2 HTML

```html
<div class="kpi-card kpi-card--success">
  <div class="kpi-card__head">
    <i data-lucide="shield-check" class="icon icon-sm"></i>
    <span class="txt-overline">طلبات محمية</span>
    <span class="kpi-card__live"></span>
  </div>
  <div class="kpi-card__value num">128,492</div>
  <div class="kpi-card__delta kpi-card__delta--up">
    <i data-lucide="trending-up" class="icon icon-xs"></i>
    +12% آخر 24س
    <svg class="kpi-card__spark" viewBox="0 0 80 24"><!-- sparkline --></svg>
  </div>
</div>
```

### 3.3 CSS الأساسي

```css
.kpi-card {
  position: relative;
  background: var(--bg-surface-1);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: var(--space-4);
  overflow: hidden;
}
.kpi-card::before {
  /* خط نيون رفيع أعلى الكرت — يحدد النوع */
  content: '';
  position: absolute;
  top: 0; right: 0; left: 0;
  height: 2px;
  background: var(--color-brand-500);
  opacity: 0.6;
}
.kpi-card--success::before { background: var(--color-success); }
.kpi-card--warning::before { background: var(--color-warning); }
.kpi-card--critical::before { background: var(--color-critical); }

.kpi-card__head {
  display: flex; align-items: center; gap: var(--space-2);
  color: var(--text-tertiary);
  margin-bottom: var(--space-3);
}
.kpi-card__value {
  font-family: var(--font-mono);
  font-size: var(--text-3xl);
  font-weight: var(--weight-bold);
  color: var(--text-primary);
  font-variant-numeric: tabular-nums;
  line-height: 1;
  margin-bottom: var(--space-2);
}

/* مؤشر النبض الحي */
.kpi-card__live {
  position: relative;
  width: 6px; height: 6px;
  background: var(--color-success);
  border-radius: 50%;
  margin-inline-start: auto;
}
.kpi-card__live::after {
  content: '';
  position: absolute;
  inset: -4px;
  background: var(--color-success);
  border-radius: 50%;
  opacity: 0.4;
  animation: shield-pulse 2s infinite;
}
@keyframes shield-pulse {
  0% { transform: scale(0.8); opacity: 0.7; }
  100% { transform: scale(2.4); opacity: 0; }
}

/* Delta */
.kpi-card__delta {
  display: flex; align-items: center; gap: var(--space-1);
  font-size: var(--text-xs);
  color: var(--text-secondary);
}
.kpi-card__delta--up { color: var(--color-success); }
.kpi-card__delta--down { color: var(--color-critical); }
.kpi-card__spark { margin-inline-start: auto; height: 24px; width: 60px; }
```

---

## 4. الجداول (Tables) — التطوير الأهم

> الجداول هي قلب لوحة الأمن. هنا يحدث 70% من العمل.

### 4.1 التشريح المرئي

```
┌──────────────────────────────────────────────────────────────────┐
│ Toolbar: [بحث] [فلاتر] [تصدير]              [تحديث] [إعدادات]    │
├──────────────────────────────────────────────────────────────────┤
│ # ▾  IP              ▾ الدولة     النوع        الوقت    الإجراء  │  ← Header
├──────────────────────────────────────────────────────────────────┤
│ 1  192.168.1.105  🇺🇸 US     [Critical]  14:32   [⋯]            │  ← Row
│ 2  10.0.0.42      🇩🇪 DE     [Warning]   14:28   [⋯]            │
│ ...                                                              │
├──────────────────────────────────────────────────────────────────┤
│  عرض 1-25 من 1,247                       [<] [1] 2 3 ... 50 [>]  │  ← Footer
└──────────────────────────────────────────────────────────────────┘
```

### 4.2 القواعد الذهبية

1. **ارتفاع الصف:** 40px ثابت.
2. **خط الفاصل:** 1px بلون `--border-subtle` فقط.
3. **Hover Row:** خلفية `--bg-surface-2` بانتقال 100ms.
4. **Header مثبت** (`position: sticky`) عند التمرير.
5. **العمود الأول (الترقيم):** بخط Mono، عرض ثابت 50px، لون `--text-tertiary`.
6. **عمود الوقت:** دائماً Mono، relative time + tooltip فيه التاريخ الكامل.
7. **عمود الإجراءات:** أيقونة `more-horizontal` تفتح dropdown.
8. **التصفح:** ليس بأسهم Bootstrap، بل بنمط Linear/Notion.

### 4.3 CSS

```css
.shield-table-wrapper {
  background: var(--bg-surface-1);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  overflow: hidden;
}
.shield-table-toolbar {
  display: flex;
  align-items: center;
  gap: var(--space-3);
  padding: var(--space-3) var(--space-4);
  border-bottom: 1px solid var(--border-subtle);
}
.shield-table {
  width: 100%;
  border-collapse: collapse;
  font-size: var(--text-sm);
}
.shield-table thead th {
  position: sticky; top: 0;
  background: var(--bg-surface-1);
  padding: var(--space-3) var(--space-4);
  text-align: start;
  font-size: var(--text-xs);
  font-weight: var(--weight-semibold);
  color: var(--text-tertiary);
  text-transform: uppercase;
  letter-spacing: var(--tracking-wider);
  border-bottom: 1px solid var(--border-default);
  z-index: 1;
}
.shield-table tbody td {
  padding: var(--space-2) var(--space-4);
  height: 40px;
  border-bottom: 1px solid var(--border-subtle);
  color: var(--text-primary);
  vertical-align: middle;
}
.shield-table tbody tr {
  transition: background var(--duration-fast) var(--ease-out);
}
.shield-table tbody tr:hover {
  background: var(--bg-surface-2);
}
.shield-table tbody tr.is-selected {
  background: var(--color-brand-900);
}

/* أعمدة خاصة */
.shield-table .col-num {
  width: 50px;
  font-family: var(--font-mono);
  color: var(--text-tertiary);
  text-align: center;
}
.shield-table .col-ip {
  font-family: var(--font-mono);
  font-size: var(--text-sm);
  direction: ltr;
}
.shield-table .col-time {
  font-family: var(--font-mono);
  color: var(--text-secondary);
  white-space: nowrap;
}
.shield-table .col-actions { width: 48px; text-align: center; }
```

### 4.4 توافق DataTables

المشروع يستخدم **DataTables**. سنُمرر CSS classes الخاصة بنا، وندع DataTables يعمل كالمعتاد. مع override لتحديد الـ pagination:

```css
.dataTables_wrapper .dataTables_paginate .paginate_button {
  border-radius: var(--radius-sm) !important;
  border: 1px solid var(--border-subtle) !important;
  background: transparent !important;
  color: var(--text-secondary) !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: var(--color-brand-500) !important;
  color: var(--text-inverse) !important;
  border-color: var(--color-brand-500) !important;
}
```

---

## 5. الـ Badges (Severity Pills)

أهم badge في النظام: **مؤشر الخطورة**.

### 5.1 الأنواع

```html
<span class="severity-pill severity-pill--critical">حرج</span>
<span class="severity-pill severity-pill--high">عالي</span>
<span class="severity-pill severity-pill--medium">متوسط</span>
<span class="severity-pill severity-pill--low">منخفض</span>
<span class="severity-pill severity-pill--info">معلومات</span>
```

### 5.2 CSS

```css
.severity-pill {
  display: inline-flex;
  align-items: center;
  gap: var(--space-1);
  padding: 2px var(--space-2);
  height: 20px;
  border-radius: var(--radius-full);
  font-size: var(--text-xs);
  font-weight: var(--weight-medium);
  font-family: var(--font-display);
  letter-spacing: var(--tracking-wide);
  border: 1px solid transparent;
}
.severity-pill::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: currentColor;
}
.severity-pill--critical {
  color: var(--color-critical);
  background: var(--color-critical-bg);
  border-color: rgba(255, 59, 92, 0.20);
}
.severity-pill--high {
  color: var(--color-danger);
  background: var(--color-danger-bg);
}
.severity-pill--medium {
  color: var(--color-warning);
  background: var(--color-warning-bg);
}
.severity-pill--low {
  color: var(--color-info);
  background: var(--color-info-bg);
}
.severity-pill--info {
  color: var(--text-secondary);
  background: var(--bg-surface-3);
}
```

---

## 6. الحقول (Form Inputs)

### 6.1 المبدأ
- ارتفاع موحد: 36px (مثل الأزرار).
- حدود رفيعة 1px.
- Focus: حدود نيون + glow.
- Label فوق الحقل، 11px UPPERCASE.

### 6.2 CSS

```css
.shield-field {
  display: flex;
  flex-direction: column;
  gap: var(--space-1);
}
.shield-field__label {
  font-size: var(--text-xs);
  font-weight: var(--weight-semibold);
  color: var(--text-tertiary);
  text-transform: uppercase;
  letter-spacing: var(--tracking-wider);
}
.shield-input {
  height: 36px;
  padding: 0 var(--space-3);
  background: var(--bg-surface-2);
  border: 1px solid var(--border-default);
  border-radius: var(--radius-md);
  color: var(--text-primary);
  font-family: var(--font-display);
  font-size: var(--text-sm);
  transition: var(--transition-color);
}
.shield-input::placeholder { color: var(--text-tertiary); }
.shield-input:focus {
  outline: none;
  border-color: var(--color-brand-500);
  box-shadow: 0 0 0 3px rgba(0, 184, 230, 0.15);
}
.shield-input.is-error {
  border-color: var(--color-critical);
}
.shield-field__hint {
  font-size: var(--text-xs);
  color: var(--text-tertiary);
}
.shield-field__error {
  font-size: var(--text-xs);
  color: var(--color-critical);
}
```

---

## 7. القوائم المنسدلة (Dropdowns)

### 7.1 المبدأ
خلفية `--bg-surface-2`، حواف `--border-default`، ظل `--shadow-lg`، انتقال انزلاق + تلاشٍ 200ms.

```css
.shield-dropdown {
  position: absolute;
  min-width: 200px;
  background: var(--bg-surface-2);
  border: 1px solid var(--border-default);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-lg);
  padding: var(--space-1);
  z-index: var(--z-dropdown);
  opacity: 0;
  transform: translateY(-4px);
  transition: opacity var(--duration-base) var(--ease-emphasis),
              transform var(--duration-base) var(--ease-emphasis);
  pointer-events: none;
}
.shield-dropdown.is-open {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}
.shield-dropdown__item {
  display: flex; align-items: center; gap: var(--space-2);
  padding: var(--space-2) var(--space-3);
  border-radius: var(--radius-sm);
  font-size: var(--text-sm);
  color: var(--text-secondary);
  cursor: pointer;
  transition: var(--transition-color);
}
.shield-dropdown__item:hover {
  background: var(--bg-surface-3);
  color: var(--text-primary);
}
.shield-dropdown__divider {
  height: 1px;
  background: var(--border-subtle);
  margin: var(--space-1) 0;
}
```

---

## 8. الـ Modals (الحوارات)

```css
.shield-modal-backdrop {
  position: fixed; inset: 0;
  background: var(--bg-overlay);
  backdrop-filter: blur(4px);
  z-index: var(--z-modal-back);
  opacity: 0;
  transition: opacity var(--duration-base) var(--ease-out);
}
.shield-modal-backdrop.is-open { opacity: 1; }

.shield-modal {
  position: fixed;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%) scale(0.96);
  width: min(560px, calc(100vw - 32px));
  max-height: calc(100vh - 64px);
  background: var(--bg-surface-2);
  border: 1px solid var(--border-default);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-xl);
  z-index: var(--z-modal);
  opacity: 0;
  transition: opacity var(--duration-base) var(--ease-emphasis),
              transform var(--duration-base) var(--ease-emphasis);
}
.shield-modal.is-open {
  opacity: 1;
  transform: translate(-50%, -50%) scale(1);
}
.shield-modal__header {
  padding: var(--space-4);
  border-bottom: 1px solid var(--border-subtle);
}
.shield-modal__body { padding: var(--space-4); overflow-y: auto; }
.shield-modal__footer {
  display: flex; justify-content: flex-end; gap: var(--space-2);
  padding: var(--space-4);
  border-top: 1px solid var(--border-subtle);
}
```

> **توافق:** يحل محل `bs-modal` تدريجياً، أو نُعيد تنسيق `.modal` Bootstrap بنفس القيم.

---

## 9. التنبيهات (Toasts)

```html
<div class="shield-toast shield-toast--success">
  <i data-lucide="check-circle-2" class="icon icon-md"></i>
  <div class="shield-toast__body">
    <div class="shield-toast__title">تم الحظر بنجاح</div>
    <div class="shield-toast__desc">192.168.1.1 — أُضيف إلى القائمة السوداء.</div>
  </div>
  <button class="btn-shield-icon shield-toast__close">
    <i data-lucide="x" class="icon icon-sm"></i>
  </button>
</div>
```

> **التوقيت:** يظهر من الأعلى (في RTL: أعلى يسار)، ينزل بانيميشن 300ms، يبقى 4 ثوانٍ، يختفي بانيميشن 200ms.

---

## 10. الـ Skeleton Loaders

بدل spinner تقليدي، نستخدم Skeletons تحاكي شكل المحتوى:

```css
.skeleton {
  display: block;
  background: linear-gradient(
    90deg,
    var(--bg-surface-2) 0%,
    var(--bg-surface-3) 50%,
    var(--bg-surface-2) 100%
  );
  background-size: 200% 100%;
  border-radius: var(--radius-sm);
  animation: shield-shimmer 1.5s infinite linear;
}
@keyframes shield-shimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}
.skeleton--text { height: 12px; width: 80%; }
.skeleton--title { height: 20px; width: 60%; }
.skeleton--circle { border-radius: 50%; width: 32px; height: 32px; }
```

---

## 11. مكونات إضافية مقترحة

| المكون | الوصف | الأولوية |
|--------|-------|---------|
| **Command Palette (`Ctrl+K`)** | بحث/تنقل سريع | متوسطة |
| **IP Hover Card** | بطاقة معلومات IP عند الـ hover | عالية |
| **Country Flag Cell** | علم + كود ISO | عالية |
| **Threat Map** | خريطة عالم بنقاط للتهديدات | منخفضة (مرحلة لاحقة) |
| **Activity Timeline** | خط زمني لأحداث | متوسطة |
| **Filter Drawer** | لوحة فلاتر جانبية تنزلق | عالية |
| **Code Block (Logs)** | كتلة كود لعرض raw logs | عالية |
| **Confirmation Dialog** | حوار تأكيد للإجراءات الخطرة | عالية |

---

## 📎 الخطوة التالية

اقرأ الآن: [`05-layout-and-navigation.md`](./05-layout-and-navigation.md) — الهيكل والتنقل.
