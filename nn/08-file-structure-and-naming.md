---
document: 08 — File Structure & Naming Conventions
project: Web Shield
version: 1.0
status: Draft
audience: Developers
---

# 📁 بنية الملفات وتسميات الكلاسات (File Structure & Naming)

> الفوضى في التسميات تولد فوضى في التصميم. هذه الوثيقة تضع القواعد الحاسمة.

---

## 1. الشجرة الكاملة للملفات الجديدة

```
project-root/
│
├─ assets/
│  ├─ css/
│  │  ├─ psec.css                       ← (موجود حالياً، نُبقيه احتياطاً)
│  │  └─ shield/                        ← 🆕 كل التصميم الجديد
│  │     ├─ shield.css                  ← Master file (يستدعي البقية)
│  │     │
│  │     ├─ _tokens.css                 ← 🎨 المتغيرات (CSS Variables)
│  │     ├─ _base.css                   ← Reset + body defaults
│  │     ├─ _typography.css             ← قواعد الخطوط والنصوص
│  │     ├─ _utilities.css              ← كلاسات مساعدة (.txt-, .grid-, ...)
│  │     │
│  │     ├─ components/                 ← 🧩 المكونات
│  │     │  ├─ _buttons.css
│  │     │  ├─ _cards.css
│  │     │  ├─ _kpi.css
│  │     │  ├─ _tables.css
│  │     │  ├─ _badges.css
│  │     │  ├─ _forms.css
│  │     │  ├─ _modals.css
│  │     │  ├─ _toasts.css
│  │     │  ├─ _tooltips.css
│  │     │  ├─ _dropdowns.css
│  │     │  ├─ _skeleton.css
│  │     │  ├─ _stat-bar.css
│  │     │  ├─ _filter-chips.css
│  │     │  └─ _command-palette.css
│  │     │
│  │     ├─ layout/                     ← 🏗️ مكونات الهيكل
│  │     │  ├─ _sidebar.css
│  │     │  ├─ _topbar.css
│  │     │  ├─ _page-header.css
│  │     │  ├─ _grid.css
│  │     │  └─ _shell.css
│  │     │
│  │     ├─ patterns/                   ← 🎯 أنماط مركبة
│  │     │  ├─ _empty-state.css
│  │     │  ├─ _login-screen.css
│  │     │  └─ _dashboard-grid.css
│  │     │
│  │     └─ overrides/                  ← 🔧 تخصيصات لمكتبات خارجية
│  │        ├─ _adminlte.css
│  │        ├─ _bootstrap.css
│  │        ├─ _datatables.css
│  │        ├─ _select2.css
│  │        └─ _sweetalert.css
│  │
│  ├─ js/
│  │  └─ shield/                        ← 🆕
│  │     ├─ shield-ui.js                ← الـ entrypoint
│  │     ├─ theme-toggle.js
│  │     ├─ sidebar.js
│  │     ├─ command-palette.js
│  │     ├─ charts-defaults.js
│  │     ├─ live-updates.js
│  │     ├─ table-helpers.js
│  │     ├─ ip-hover-card.js
│  │     └─ utils.js
│  │
│  ├─ icons/
│  │  └─ custom/                        ← 🆕 أيقونات مشروع مخصصة (SVG)
│  │     ├─ shield-hex.svg
│  │     ├─ firewall.svg
│  │     ├─ threat-radar.svg
│  │     └─ geo-lock.svg
│  │
│  ├─ fonts/                             ← 🆕 (مرحلة 6: استبدال CDN)
│  │  ├─ ibm-plex-arabic/
│  │  └─ jetbrains-mono/
│  │
│  └─ images/                            ← (موجود)
│
├─ includes/                              ← 🆕 (اختياري ومحدود) ملفات HTML مُضمَّنة فقط
│  │                                        لا تحتوي أي استعلامات أو منطق برمجي.
│  │                                        الغرض: تجنب تكرار markup عبر الصفحات.
│  ├─ shield-sidebar.php                  ← markup الشريط الجانبي الجديد
│  ├─ shield-topbar.php                   ← markup الشريط العلوي الجديد
│  ├─ shield-page-header.php              ← دالة عرض ترويسة الصفحة
│  └─ shield-helpers.php                  ← دوال عرض بحتة (render فقط، لا DB)
│
│  ⚠️ ملاحظة: لا يُنشأ مجلد lib/ ولا api/. كل المنطق الخلفي يبقى
│     في مكانه الأصلي (modules/, config.php, إلخ). هدفنا التصميم فقط.
│
├─ core.php                                ← (موجود — تعديل بسيط لاستدعاء shield)
├─ config.php                              ← (موجود — لا يُمس)
├─ config_settings.php                     ← (موجود — إضافة سطر 'ui_engine' فقط)
├─ dashboard.php                           ← (موجود — تعديل HTML/CSS فقط)
├─ sql-injection.php                       ← (موجود — تعديل HTML/CSS فقط)
├─ badbots.php                             ← (موجود — تعديل HTML/CSS فقط)
├─ spam.php                                ← (موجود — تعديل HTML/CSS فقط)
├─ proxy.php                               ← (موجود — تعديل HTML/CSS فقط)
├─ all-logs.php                            ← (موجود — تعديل HTML/CSS فقط)
├─ index.php                               ← (موجود — تعديل HTML/CSS فقط)
├─ modules/                                ← (موجود — ❌ ممنوع منعاً باتاً المساس به)
└─ _design-showcase.php                    ← 🆕 صفحة معاينة المكونات (HTML بحت، بلا DB)
```

---

## 2. تسميات الملفات (File Naming)

### 2.1 ملفات CSS

| النوع | البادئة | مثال |
|------|--------|-----|
| ملف رئيسي | بدون بادئة | `shield.css` |
| Partial يُستدعى من ملف آخر | `_` (شرطة سفلية) | `_tokens.css`, `_buttons.css` |
| ملف مستقل قابل للاستدعاء | بدون بادئة | (نادر — لا نستخدمه عادة) |

> 💡 الشرطة السفلية اتفاقية شائعة من Sass: تعني "هذا ملف partial".

### 2.2 ملفات JavaScript

- `kebab-case` للأسماء: `command-palette.js` لا `commandPalette.js`.
- اسم وصفي: `theme-toggle.js` أفضل من `tt.js`.

### 2.3 ملفات SVG

- `kebab-case`.
- اسم وصفي: `shield-hex.svg`، `geo-lock.svg`.

---

## 3. تسميات كلاسات CSS — منهجية BEM-Lite

نستخدم **BEM المُبسَّطة** (Block-Element-Modifier) مع بادئة `shield-`:

### 3.1 القاعدة العامة

```
.shield-{block}                       → المكون نفسه
.shield-{block}__{element}            → جزء داخلي
.shield-{block}--{modifier}           → نسخة مختلفة من المكون
.shield-{block}.is-{state}            → حالة (فعلت بـ JS)
.shield-{block}.has-{feature}         → ميزة موجودة
```

### 3.2 أمثلة

```html
<!-- مكون كرت KPI -->
<div class="shield-kpi shield-kpi--success has-sparkline">
  <div class="shield-kpi__head">
    <span class="shield-kpi__label">طلبات محمية</span>
    <span class="shield-kpi__live"></span>
  </div>
  <div class="shield-kpi__value">128,492</div>
  <div class="shield-kpi__delta shield-kpi__delta--up">+12%</div>
</div>

<!-- جدول -->
<div class="shield-table-wrapper">
  <div class="shield-table-toolbar">...</div>
  <table class="shield-table">
    <thead>
      <tr>
        <th class="shield-table__head-cell">...</th>
      </tr>
    </thead>
    <tbody>
      <tr class="shield-table__row is-selected">
        <td class="shield-table__cell">...</td>
      </tr>
    </tbody>
  </table>
</div>
```

### 3.3 تبسيط مقبول

في بعض الأحيان، استخدام BEM الكامل يصبح ثقيلاً. نسمح بـ:

```html
<!-- بدلاً من -->
<button class="shield-btn shield-btn--primary shield-btn--sm">

<!-- نسمح بـ -->
<button class="btn-shield-primary btn-sm">
```

> القاعدة: **الوضوح > الالتزام الحرفي بـ BEM**. نحن نستخدمه دليلاً، لا قيداً.

### 3.4 الكلاسات المساعدة (Utilities)

ندعم utility classes محدودة (مستوحاة من Tailwind لكن أقل بكثير):

```css
/* Spacing utilities */
.mt-1 { margin-top: var(--space-1); }
.mt-2 { margin-top: var(--space-2); }
/* ... mt-1 إلى mt-12 */
.mb-, .mx-, .my-, .pt-, .pb-, .px-, .py-, .p-

/* Layout */
.flex { display: flex; }
.flex-col { flex-direction: column; }
.items-center { align-items: center; }
.justify-between { justify-content: space-between; }
.gap-2 { gap: var(--space-2); }

/* Text */
.txt-primary { color: var(--text-primary); }
.txt-secondary { color: var(--text-secondary); }
.txt-tertiary { color: var(--text-tertiary); }
.txt-success { color: var(--color-success); }
.txt-critical { color: var(--color-critical); }
.txt-mono { font-family: var(--font-mono); font-variant-numeric: tabular-nums; }
.txt-center { text-align: center; }

/* Common */
.hidden { display: none !important; }
.sr-only { /* visually hidden للقراءة الشاشية */ }
```

> ⚠️ **لا تتوسع في الـ Utilities**. الهدف ليس استبدال Tailwind، بل سدّ الثغرات الصغيرة فقط.

### 3.5 الكلاسات المحظورة

❌ **لا تستخدم:**
- `.red-button`, `.big-text` → استخدم BEM بدلاً.
- `.style1`, `.style2` → بلا معنى.
- `#myButton` (ID للـ styling) → ID فقط لـ JS hooks.
- `.MyButton` (PascalCase في CSS) → kebab-case فقط.
- `!important` → إلا في `_overrides/` فقط.

---

## 4. التسميات في PHP

### 4.1 الدوال

```php
// PascalCase ❌
function RenderKpiCard() { }

// camelCase ❌ (غير شائع في PHP)
function renderKpiCard() { }

// snake_case + بادئة shield ✅
function shield_render_kpi($label, $value, $icon = null) { }
function shield_severity_pill($level) { }
function shield_format_ip($ip) { }
function shield_time_ago($timestamp) { }
```

البادئة `shield_` تمنع التعارض مع دوال AdminLTE أو غيرها.

### 4.2 المتغيرات

```php
// snake_case
$kpi_value = 1247;
$threat_count = 0;
$user_role = 'admin';
```

### 4.3 الثوابت

```php
define('SHIELD_VERSION', '1.0.0');
define('SHIELD_THEME_DEFAULT', 'dark');
```

### 4.4 ملفات PHP المُضمَّنة

اسم الملف يصف ما يفعله:
```
sidebar.php           ← يطبع الـ sidebar
kpi-card.php          ← يحوي دالة shield_render_kpi
helpers.php           ← دوال متفرقة
```

---

## 5. تنظيم ترتيب الكود داخل ملف CSS

داخل أي ملف CSS، رتب الخصائص بالترتيب التالي (مأخوذ من معايير شائعة):

```css
.shield-card {
  /* 1. Positioning */
  position: relative;
  inset: 0;
  z-index: 1;

  /* 2. Display & Box Model */
  display: flex;
  flex-direction: column;
  width: 100%;
  height: auto;
  padding: var(--space-4);
  margin: 0;

  /* 3. Typography */
  font-family: var(--font-display);
  font-size: var(--text-base);
  font-weight: var(--weight-regular);
  line-height: var(--leading-normal);
  color: var(--text-primary);
  text-align: start;

  /* 4. Visual */
  background: var(--bg-surface-1);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);

  /* 5. Animation & Misc */
  transition: var(--transition-base);
  cursor: default;
}
```

> هذا الترتيب يجعل قراءة الـ CSS أسرع بكثير. (يمكن تشغيله تلقائياً بـ `stylelint-order`.)

---

## 6. التعليقات (Comments)

### 6.1 رأس كل ملف CSS

```css
/* ============================================================
 * Web Shield — Buttons
 * Component: .btn-shield-{primary,secondary,ghost,outline,danger,icon}
 * Last updated: 2026-04-26
 * ============================================================ */
```

### 6.2 أقسام داخل الملف

```css
/* --- Primary Button ----------------------------------------- */
.btn-shield-primary { ... }

/* --- Secondary Button --------------------------------------- */
.btn-shield-secondary { ... }
```

### 6.3 شرح قرار غير بديهي

```css
/* الـ z-index 200 لأن الـ topbar 300 — يجب أن يكون تحته */
.shield-sidebar { z-index: var(--z-sidebar); }
```

---

## 7. .gitignore المُوصى به

أضف لـ `.gitignore`:

```gitignore
# Build artifacts
assets/css/shield/*.bundle.min.css
assets/js/shield/*.bundle.min.js

# Local
.DS_Store
.vscode/
.idea/
*.log

# Backups
*.backup-*
*.bak
```

---

## 8. ملف Linting موصى به

### 8.1 Stylelint (`.stylelintrc.json`)

```json
{
  "extends": "stylelint-config-standard",
  "plugins": ["stylelint-order"],
  "rules": {
    "color-no-hex": [true, { "message": "استخدم var(--color-*) بدلاً من قيم hex" }],
    "declaration-no-important": [true, {
      "ignoreRegExp": "^.*overrides.*"
    }],
    "selector-class-pattern": [
      "^(shield-|btn-shield-|is-|has-|grid|flex|gap-|mt-|mb-|p-|txt-)[a-z0-9_-]*$",
      { "message": "اسم الكلاس يجب أن يبدأ بـ shield- أو يكون utility معروفاً" }
    ],
    "order/properties-order": [
      "position", "inset", "top", "right", "bottom", "left", "z-index",
      "display", "flex-direction", "align-items", "justify-content", "gap",
      "width", "height", "padding", "margin",
      "font-family", "font-size", "font-weight", "line-height", "color",
      "background", "border", "border-radius", "box-shadow",
      "transition", "cursor"
    ]
  }
}
```

### 8.2 ESLint (`.eslintrc.json`) — للـ JS

```json
{
  "env": { "browser": true, "es2021": true },
  "extends": "eslint:recommended",
  "rules": {
    "no-unused-vars": "warn",
    "no-console": ["warn", { "allow": ["warn", "error"] }],
    "prefer-const": "error",
    "semi": ["error", "always"]
  }
}
```

---

## 9. ملف توثيق المكونات (موصى به للمشروع الناضج)

أنشئ `assets/css/shield/COMPONENTS.md`:

```markdown
# Shield Components Reference

## Button

### .btn-shield-primary
Primary action button.

**Usage:**
```html
<button class="btn-shield-primary">Block IP</button>
```

**Modifiers:**
- `.btn-sm` — small size
- `.btn-lg` — large size
- `.loading` — loading state

**States:**
- `:hover` — لمعان نيون
- `:disabled` — opacity 0.4

**Don't:**
- استخدامه أكثر من مرة في الصفحة كـ primary.
```

> هذا التوثيق يساعد أي مطور جديد ينضم للمشروع، ويقلل أسئلة "كيف أستخدم هذا؟".

---

## 10. ملخص قواعد سريع (Cheatsheet)

| السؤال | الجواب |
|--------|-------|
| هل أستخدم `#000` مباشرة؟ | ❌ استخدم `var(--text-primary)` |
| كلاس يبدأ بـ `card-`؟ | ❌ ابدأ بـ `shield-card-` |
| `!important` مسموح؟ | ❌ إلا في `_overrides/` |
| ID للـ styling؟ | ❌ ID للـ JS فقط |
| ملف CSS بدون شرطة سفلية؟ | فقط للملفات الرئيسية (`shield.css`) |
| دالة PHP بدون بادئة؟ | ❌ ابدأ بـ `shield_` |
| `<br>` في HTML؟ | ❌ استخدم margin/padding |
| `style="..."` inline؟ | ❌ إلا للقيم الديناميكية فعلاً (`--w: 78%`) |
| Animations عبر `@keyframes`؟ | ✅ بشرط البادئة `shield-*` (`shield-pulse`) |

---

## 11. الخطوة التالية: التنفيذ!

✅ لقد قرأت الوثائق الثمانية كاملة. أنت الآن جاهز للبدء.

**ابدأ من المرحلة 0** في [`07-implementation-roadmap.md`](./07-implementation-roadmap.md):
1. خذ نسخة احتياطية.
2. أنشئ بنية المجلدات.
3. أضف سويتش `ui_engine` في `config_settings.php`.

**كل سطر CSS تكتبه — اسأل نفسك:**
- هل يستخدم Token؟
- هل اسم الكلاس يتبع BEM؟
- هل أضع التعليق المناسب؟

النتيجة بعد 5 أسابيع ستكون: **منتج أمن سيبراني يبدو احترافياً كـ CrowdStrike، يعمل بـ PHP وMySQL، وقابل للصيانة لسنوات.**

---

> *"الكود الذي يقرأه الآخرون أهم من الكود الذي يعمل."*

🛡️ **حظاً موفقاً في بناء Web Shield.**
