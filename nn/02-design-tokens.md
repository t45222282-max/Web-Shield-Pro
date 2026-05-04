---
document: 02 — Design Tokens (Source of Truth)
project: Web Shield
version: 1.0
status: Draft
audience: Developers, Designers
---

# 🎨 Design Tokens — مصدر الحقيقة الواحد

> **التعريف:** Design Tokens هي القيم الذرية (ألوان، خطوط، مسافات...) المُسَمّاة بأسماء معنوية، تُستخدم في كل الكود. تغيير قيمة الـ Token يغيّر المنتج كله. **لا قيم سحرية في الكود.**

---

## 1. كيف نُطبّق الـ Tokens؟

عبر **CSS Custom Properties** (متغيرات CSS) معرَّفة في ملف واحد:
`assets/css/shield/_tokens.css`

تُستدعى من ملف العرض الرئيسي `assets/css/shield/shield.css`، الذي يُضاف بعد AdminLTE في `core.php`.

```html
<!-- في core.php، بعد adminlte.min.css مباشرة -->
<link rel="stylesheet" href="assets/css/shield/shield.css">
```

ميزة هذا الأسلوب: لا نلمس Bootstrap ولا AdminLTE. مجرد طبقة فوقية.

---

## 2. الـ Tokens الكاملة

### 2.1 🎨 الألوان (Colors)

#### الـ Brand Colors (الهوية)
```css
:root {
  /* Primary Cyber Cyan — شعار، CTAs، الحالة الآمنة */
  --color-brand-50:  #E6FBFF;
  --color-brand-100: #B3F1FF;
  --color-brand-200: #80E6FF;
  --color-brand-300: #4DDBFF;
  --color-brand-400: #1AD0FF;
  --color-brand-500: #00B8E6;  /* ← اللون الرئيسي */
  --color-brand-600: #008FB3;
  --color-brand-700: #006680;
  --color-brand-800: #003D4D;
  --color-brand-900: #00141A;
}
```

#### الـ Semantic Colors (الدلالية)
```css
:root {
  /* Severity / Status */
  --color-critical: #FF3B5C;   /* تهديد حرج */
  --color-danger:   #FF6B47;   /* خطر */
  --color-warning:  #FFB020;   /* تحذير */
  --color-info:     #5B8FF9;   /* معلومات */
  --color-success:  #19C37D;   /* نجاح / آمن */
  --color-neutral:  #8B95A5;   /* محايد */

  /* لكل لون، نسخة بشفافية للخلفيات */
  --color-critical-bg: rgba(255, 59, 92, 0.10);
  --color-danger-bg:   rgba(255, 107, 71, 0.10);
  --color-warning-bg:  rgba(255, 176, 32, 0.10);
  --color-info-bg:     rgba(91, 143, 249, 0.10);
  --color-success-bg:  rgba(25, 195, 125, 0.10);
}
```

#### الـ Surface Colors — Dark Mode (الافتراضي)
```css
:root[data-theme="dark"] {
  --bg-canvas:     #0A0E1A;   /* الخلفية الكلية للصفحة */
  --bg-surface-1:  #111726;   /* الكروت، الـ Sidebar */
  --bg-surface-2:  #1A2236;   /* Modals، Dropdowns */
  --bg-surface-3:  #232C42;   /* Hover states */
  --bg-overlay:    rgba(10, 14, 26, 0.80);  /* خلفية الـ Modal */

  --border-subtle: rgba(255, 255, 255, 0.06);
  --border-default:rgba(255, 255, 255, 0.10);
  --border-strong: rgba(255, 255, 255, 0.16);

  --text-primary:   #E6EAF2;
  --text-secondary: #A3ACBD;
  --text-tertiary:  #6B7587;
  --text-disabled:  #4A5263;
  --text-inverse:   #0A0E1A;
}
```

#### الـ Surface Colors — Light Mode
```css
:root[data-theme="light"] {
  --bg-canvas:     #F5F7FB;
  --bg-surface-1:  #FFFFFF;
  --bg-surface-2:  #FAFBFD;
  --bg-surface-3:  #EEF1F6;
  --bg-overlay:    rgba(15, 23, 41, 0.50);

  --border-subtle: rgba(15, 23, 41, 0.06);
  --border-default:rgba(15, 23, 41, 0.12);
  --border-strong: rgba(15, 23, 41, 0.20);

  --text-primary:   #0F1729;
  --text-secondary: #4A5568;
  --text-tertiary:  #718096;
  --text-disabled:  #A0AEC0;
  --text-inverse:   #FFFFFF;

  /* في الوضع الفاتح، نخفض إشباع الألوان قليلاً */
  --color-brand-500: #0891B2;
}
```

---

### 2.2 ✏️ الخطوط (Typography)

```css
:root {
  /* خطوط — تُحمَّل من Google Fonts في core.php */
  --font-display: 'IBM Plex Sans Arabic', 'Tajawal', system-ui, sans-serif;
  --font-body:    'IBM Plex Sans Arabic', 'Tajawal', system-ui, sans-serif;
  --font-mono:    'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;

  /* أحجام الخطوط — نظام Modular Scale (Ratio 1.200) */
  --text-2xs:  10px;
  --text-xs:   11px;
  --text-sm:   12px;
  --text-base: 13px;   /* ← القاعدة الأساسية، أقل من 14 الشائع لزيادة الكثافة */
  --text-md:   14px;
  --text-lg:   16px;
  --text-xl:   18px;
  --text-2xl:  22px;
  --text-3xl:  28px;
  --text-4xl:  36px;
  --text-5xl:  48px;

  /* أوزان */
  --weight-light:    300;
  --weight-regular:  400;
  --weight-medium:   500;
  --weight-semibold: 600;
  --weight-bold:     700;

  /* ارتفاع السطر */
  --leading-tight:   1.2;
  --leading-snug:    1.4;
  --leading-normal:  1.5;
  --leading-relaxed: 1.7;

  /* Letter Spacing */
  --tracking-tight:  -0.01em;
  --tracking-normal:  0;
  --tracking-wide:    0.02em;
  --tracking-wider:   0.06em;  /* للـ Labels و Uppercase */
}
```

#### قواعد استخدام الخطوط

| الحالة | الخط | الحجم | الوزن |
|--------|------|------|------|
| عنوان صفحة (H1) | `display` | `--text-3xl` | `semibold` |
| عنوان كرت | `display` | `--text-md` | `semibold` |
| نص عادي | `body` | `--text-base` | `regular` |
| Label / Caption | `display` UPPERCASE | `--text-xs` | `medium` + `--tracking-wider` |
| رقم KPI | `mono` | `--text-3xl` | `bold` |
| IP / كود / Hash | `mono` | `--text-sm` | `regular` |
| زر | `display` | `--text-sm` | `medium` |
| رسالة الجدول الفارغ | `display` | `--text-md` | `regular` italic |

---

### 2.3 📏 المسافات (Spacing)

نظام مبني على وحدة 4px:

```css
:root {
  --space-0:   0;
  --space-px:  1px;
  --space-0_5: 2px;
  --space-1:   4px;
  --space-2:   8px;
  --space-3:   12px;
  --space-4:   16px;   /* ← الوحدة المرجعية */
  --space-5:   20px;
  --space-6:   24px;
  --space-8:   32px;
  --space-10:  40px;
  --space-12:  48px;
  --space-16:  64px;
  --space-20:  80px;
  --space-24:  96px;
}
```

**قواعد الاستخدام:**
- Padding داخلي للكرت: `--space-4` (16px).
- Gap بين الكروت: `--space-4` (16px).
- Padding الزر العمودي: `--space-2`، الأفقي: `--space-4`.
- مسافة بعد عنوان القسم: `--space-6`.
- ارتفاع صف الجدول: `40px` ثابت (لا token خاص لأنه سياقي).

---

### 2.4 🔲 الزوايا (Border Radius)

```css
:root {
  --radius-none: 0;
  --radius-xs:   2px;   /* بادجات صغيرة */
  --radius-sm:   4px;   /* أزرار، حقول إدخال */
  --radius-md:   6px;   /* الافتراضي */
  --radius-lg:   8px;   /* كروت */
  --radius-xl:   12px;  /* Modals */
  --radius-2xl:  16px;  /* Hero sections */
  --radius-full: 9999px;
}
```

> **مبدأ:** نتجنب الـ Rounded المبالغ فيه (24px+). التصميم الأمني يميل للزوايا المعتدلة 6-8px لإيحاء الدقة.

---

### 2.5 🌫️ الظلال (Shadows)

```css
:root[data-theme="dark"] {
  --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.30);
  --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.35);
  --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.40);
  --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.45);
  --shadow-xl: 0 16px 48px rgba(0, 0, 0, 0.50);

  /* Glow effects — للعناصر المميزة فقط */
  --glow-brand:    0 0 20px rgba(0, 184, 230, 0.25);
  --glow-critical: 0 0 16px rgba(255, 59, 92, 0.30);
  --glow-success:  0 0 16px rgba(25, 195, 125, 0.25);
}

:root[data-theme="light"] {
  --shadow-xs: 0 1px 2px rgba(15, 23, 41, 0.06);
  --shadow-sm: 0 2px 4px rgba(15, 23, 41, 0.08);
  --shadow-md: 0 4px 12px rgba(15, 23, 41, 0.10);
  --shadow-lg: 0 8px 24px rgba(15, 23, 41, 0.12);
  --shadow-xl: 0 16px 48px rgba(15, 23, 41, 0.16);

  --glow-brand:    0 0 0 3px rgba(8, 145, 178, 0.15);
  --glow-critical: 0 0 0 3px rgba(255, 59, 92, 0.20);
  --glow-success:  0 0 0 3px rgba(25, 195, 125, 0.15);
}
```

> **قاعدة ذهبية:** الظلال في الوضع الداكن **أعمق وأطول**؛ في الفاتح **أنعم وأصغر**.

---

### 2.6 ⏱️ الحركة (Motion)

```css
:root {
  /* مدة */
  --duration-instant: 50ms;
  --duration-fast:    100ms;
  --duration-base:    200ms;   /* الافتراضي */
  --duration-slow:    300ms;
  --duration-slower:  500ms;

  /* منحنيات */
  --ease-linear:    linear;
  --ease-in:        cubic-bezier(0.4, 0, 1, 1);
  --ease-out:       cubic-bezier(0, 0, 0.2, 1);
  --ease-in-out:    cubic-bezier(0.4, 0, 0.2, 1);
  --ease-emphasis:  cubic-bezier(0.16, 1, 0.3, 1);   /* ← التوقيع */

  /* Compound transitions */
  --transition-base: all var(--duration-base) var(--ease-emphasis);
  --transition-color: color var(--duration-fast) var(--ease-out),
                     background-color var(--duration-fast) var(--ease-out),
                     border-color var(--duration-fast) var(--ease-out);
}
```

#### قواعد الحركة
- **Hover** على الأزرار: 100ms (`fast`).
- **فتح/إغلاق Modal**: 200ms (`base`) مع `ease-emphasis`.
- **انزلاق Sidebar**: 300ms (`slow`).
- **تحديث الأرقام الحية**: لا انتقال لوني، بل مؤشر نبض منفصل.
- **Skeleton Loading**: انيميشن `shimmer` 1500ms لانهائي.

---

### 2.7 🪜 طبقات Z-index

نظام مرتب لتجنب الفوضى:

```css
:root {
  --z-base:        0;
  --z-content:     1;
  --z-sticky:      100;
  --z-sidebar:     200;
  --z-topbar:      300;
  --z-dropdown:    400;
  --z-modal-back:  500;
  --z-modal:       501;
  --z-toast:       600;
  --z-tooltip:     700;
  --z-cmdk:        800;   /* Command palette */
  --z-debug:       9999;
}
```

---

### 2.8 📐 نقاط الانكسار (Breakpoints)

متوافقة مع Bootstrap 4 لتجنب الصدامات:

```css
/* في CSS، نستخدمها في @media */
/* xs: < 576px      — هاتف */
/* sm: ≥ 576px      — هاتف أفقي */
/* md: ≥ 768px      — تابلت */
/* lg: ≥ 992px      — لابتوب صغير */
/* xl: ≥ 1200px     — ديسكتوب */
/* 2xl: ≥ 1536px    — شاشات كبيرة (مضاف من قبلنا) */
```

---

## 3. كيف نستخدمها عملياً؟

❌ **خطأ:**
```css
.threat-card {
  background: #111726;
  padding: 16px;
  border-radius: 8px;
  color: #E6EAF2;
}
```

✅ **صحيح:**
```css
.threat-card {
  background: var(--bg-surface-1);
  padding: var(--space-4);
  border-radius: var(--radius-lg);
  color: var(--text-primary);
  border: 1px solid var(--border-subtle);
  transition: var(--transition-base);
}
.threat-card:hover {
  background: var(--bg-surface-2);
  border-color: var(--border-default);
}
```

---

## 4. التوافق مع AdminLTE الحالي

نحن لا نلغي كلاسات AdminLTE (`.card`, `.btn-primary`, ...). نعيد تعريفها فقط:

```css
/* في shield.css */
.card {
  background: var(--bg-surface-1) !important;
  border: 1px solid var(--border-subtle) !important;
  border-radius: var(--radius-lg) !important;
  box-shadow: var(--shadow-sm) !important;
}

.btn-primary {
  background: var(--color-brand-500);
  border-color: var(--color-brand-500);
}
```

> **استخدام `!important` هنا مقبول استثنائياً** لأننا نتجاوز كلاسات إطار خارجي. لكن في كودنا الجديد، نمنع استخدامه نهائياً.

---

## 5. أداة الفحص الذاتي (Linting)

نوصي باستخدام `stylelint` مع قاعدة:
> "أي قيمة لون / ظل / حافة مكتوبة بشكل مباشر (hex, rgb) تُرفض. يجب استخدام `var(--token)`."

عينة `.stylelintrc.json` متوفرة في الوثيقة `08-file-structure-and-naming.md`.

---

## 📎 الخطوة التالية

اقرأ الآن: [`03-typography-and-iconography.md`](./03-typography-and-iconography.md) — تفاصيل الخطوط والأيقونات.
