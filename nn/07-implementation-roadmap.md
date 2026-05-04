---
document: 07 — Implementation Roadmap
project: Web Shield
version: 1.0
status: Draft
audience: Project Owner, Lead Developer
---

# 🗺️ خطة التنفيذ المرحلية (Implementation Roadmap)

> هذه الخطة مقسمة إلى **6 مراحل** على مدى **3-5 أسابيع تقديرية** (لمطور واحد بدوام جزئي).
> 
> **المبدأ الحاكم:** لا توقف للمنتج. كل مرحلة قابلة للنشر، وقابلة للإيقاف بسطر واحد.

---

## 🛡️ القواعد الذهبية (Golden Rules) — اقرأ قبل أي شيء

هذه القواعد **غير قابلة للتفاوض** ولا يجوز تجاوزها تحت أي ظرف:

### ✅ مسموح
- إضافة ملفات CSS جديدة في `assets/css/shield/`.
- إضافة ملفات JS جديدة في `assets/js/shield/`.
- إضافة ملفات HTML/markup مُضمَّنة في `includes/` (للعرض فقط).
- إضافة classes جديدة على عناصر HTML الموجودة.
- إضافة wrappers (عناصر `<div>` خارجية) حول HTML الموجود.
- تعديل `config_settings.php` بإضافة سطرين فقط (`ui_engine`, `ui_theme`).
- إضافة استدعاءات `<link>` و `<script>` جديدة داخل `head()` بشكل مشروط.

### ❌ ممنوع منعاً باتاً
- تعديل أي ملف داخل `modules/`.
- تعديل أو حذف أي استعلام SQL.
- تغيير أسماء أي متغير PHP موجود.
- تعديل منطق التحقق، الحظر، أو معالجة الطلبات.
- إنشاء مجلدات `lib/` أو `api/` أو نقل المنطق إليها.
- تعديل `config.php` (ملف الاتصال بقاعدة البيانات).
- حذف classes قديمة من AdminLTE/Bootstrap (نضيف فوقها، لا نُزيلها).
- استبدال مكتبات Chart.js / DataTables / jQuery (نضبط إعداداتها فقط).
- تغيير schema قاعدة البيانات أو إضافة جداول.
- تعديل سلوك تسجيل الدخول، الجلسات، أو الصلاحيات.

### 🔄 مبدأ التحقق قبل أي تعديل
قبل تعديل أي ملف PHP موجود، اسأل نفسك ثلاثة أسئلة:
1. هل هذا التعديل **بصري بحت** (CSS/HTML/JS فقط)؟
2. هل سيعمل النظام **كما كان تماماً** لو تم إيقاف `ui_engine = legacy`؟
3. هل **أي متغير أو دالة** تم تغيير اسمها أو حذفها؟ إن نعم — **توقف**.

إن لم تكن متأكداً 100% من إجابة سؤال — **اسأل أو لا تنفذ**.

---

## 📊 نظرة عامة على المراحل

| المرحلة | الاسم | المدة | المخرج |
|--------|------|-------|--------|
| 0 | Pre-flight & Backup | يوم 1 | بنية ملفات + خطة طوارئ |
| 1 | Foundation Layer | 2-3 أيام | Tokens + الخطوط + Reset |
| 2 | Core Components | 4-5 أيام | الأزرار، الكروت، الجداول، الحقول |
| 3 | App Shell | 3-4 أيام | Sidebar + Topbar + Layout |
| 4 | Dashboard Pages | 5-7 أيام | الصفحة الرئيسية + Charts |
| 5 | Feature Pages | 5-7 أيام | باقي الصفحات (Logs, Blacklist...) |
| 6 | Polish & QA | 3-4 أيام | تحسينات، اختبار، توثيق |

---

## 🚀 المرحلة 0 — التحضير (Pre-flight)

### الأهداف
- إنشاء البنية الجديدة بدون لمس الموجود.
- ضمان "خط رجعة" آمن.

### المهام

#### 0.1 نسخ احتياطي
```bash
# على الخادم
cp -r /pro1 /pro1.backup-$(date +%Y%m%d)
```

#### 0.2 إنشاء بنية المجلدات الجديدة
```
assets/
├── css/
│   └── shield/                    ← جديد
│       ├── _tokens.css
│       ├── _base.css
│       ├── _typography.css
│       ├── _utilities.css
│       ├── components/
│       │   ├── _buttons.css
│       │   ├── _cards.css
│       │   ├── _kpi.css
│       │   ├── _tables.css
│       │   ├── _badges.css
│       │   ├── _forms.css
│       │   ├── _modals.css
│       │   ├── _toasts.css
│       │   └── _skeleton.css
│       ├── layout/
│       │   ├── _sidebar.css
│       │   ├── _topbar.css
│       │   ├── _page-header.css
│       │   └── _grid.css
│       ├── overrides/
│       │   ├── _adminlte.css
│       │   ├── _bootstrap.css
│       │   └── _datatables.css
│       └── shield.css            ← الملف الرئيسي يستدعي البقية
├── js/
│   └── shield/                    ← جديد
│       ├── shield-ui.js
│       ├── theme-toggle.js
│       ├── command-palette.js
│       ├── charts-defaults.js
│       └── live-updates.js
├── icons/
│   └── custom/                   ← جديد
└── fonts/                         ← (مرحلة 6) جديد
```

#### 0.3 إعداد سويتش التفعيل
في `config_settings.php`، أضف:
```php
$settings['ui_engine'] = 'shield';   // 'legacy' للعودة السريعة
$settings['ui_theme'] = 'dark';      // 'dark' | 'light'
```

في `core.php`، **بدون حذف أو تعديل أي سطر موجود**، أضف هذه الأسطر فقط داخل دالة `head()` بجوار استدعاءات CSS الأخرى:
```php
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
  <link rel="stylesheet" href="assets/css/shield/shield.css">
  <script>
    document.documentElement.setAttribute('data-theme', '<?= htmlspecialchars($settings['ui_theme'] ?? 'dark') ?>');
    document.documentElement.setAttribute('data-ui-engine', 'shield');
  </script>
<?php endif; ?>
```

> ⚠️ **انتبه:** لا تكتب وسم `<html>` جديد داخل `head()` — ذلك يكسر بنية الصفحة. نستخدم JavaScript لإضافة attribute على `<html>` الموجود أصلاً.

> هذا يعني: تستطيع **تجربة التصميم الجديد على نسخة محلية**، وإن وجدت مشكلة، تغير قيمة واحدة وتعود للقديم.

### Definition of Done (DoD) للمرحلة
- [ ] نسخة احتياطية موجودة.
- [ ] المجلدات الجديدة منشأة (فارغة لكن منظمة).
- [ ] السويتش يعمل.
- [ ] الموقع يعمل بشكل طبيعي مع `ui_engine = 'legacy'`.
- [ ] الموقع لا يتعطل مع `ui_engine = 'shield'` (حتى لو بدون تنسيق).

---

## 🏗️ المرحلة 1 — طبقة الأساس (Foundation Layer)

### الأهداف
بناء الـ CSS variables والقواعد الأساسية. لا تغييرات بصرية كبيرة بعد.

### المهام

#### 1.1 ملء `_tokens.css`
انسخ كل المتغيرات من [`02-design-tokens.md`](./02-design-tokens.md).

#### 1.2 ملء `_base.css`
- Reset متوافق مع AdminLTE (لا تكسر شيء).
- إعادة تعيين `body` بـ Tokens الجديدة.
- تطبيق الخطوط.

```css
body {
  background: var(--bg-canvas);
  color: var(--text-primary);
  font-family: var(--font-body);
  font-size: var(--text-base);
  line-height: var(--leading-normal);
}
```

#### 1.3 تحميل الخطوط
في `core.php`، داخل `head()`، أضف روابط Google Fonts (انظر [`03-typography-and-iconography.md`](./03-typography-and-iconography.md)).

#### 1.4 إنشاء `shield.css` الرئيسي
```css
/* shield.css — Master file */
@import './_tokens.css';
@import './_base.css';
@import './_typography.css';
@import './_utilities.css';

/* Components */
@import './components/_buttons.css';
@import './components/_cards.css';
/* ... */

/* Layout */
@import './layout/_sidebar.css';
/* ... */

/* Overrides */
@import './overrides/_adminlte.css';
/* ... */
```

> 💡 **بديل أفضل للأداء:** استخدم أداة بناء بسيطة (PostCSS أو حتى cat بسيط) لدمج الملفات في `shield.bundle.min.css`. لاحقاً.

### DoD
- [ ] فتح أي صفحة → ترى الخلفية الداكنة الجديدة.
- [ ] الخطوط Plex Arabic + JetBrains Mono تظهر بشكل صحيح.
- [ ] لا أخطاء في Console.
- [ ] تبديل `data-theme="light"` يعكس الألوان فعلاً.

---

## 🧱 المرحلة 2 — مكونات أساسية (Core Components)

### الأهداف
بناء كل المكونات في [`04-component-library.md`](./04-component-library.md).

### المهام (بالترتيب)

| اليوم | المهمة | الملف |
|------|-------|------|
| 1 | الأزرار (6 أنواع × 3 أحجام × 5 حالات) | `_buttons.css` |
| 1 | الحقول (input, select, textarea, checkbox, switch) | `_forms.css` |
| 2 | الكروت (default, highlighted, critical, compact) | `_cards.css` |
| 2 | الـ KPI Cards (مع sparkline + live indicator) | `_kpi.css` |
| 3 | الجداول (header, rows, pagination, toolbar) | `_tables.css` |
| 3 | الـ Badges/Severity Pills | `_badges.css` |
| 4 | Modals + Toasts + Tooltips | `_modals.css`, `_toasts.css` |
| 4 | Skeleton Loaders | `_skeleton.css` |
| 5 | Override AdminLTE Components | `_adminlte.css` |

### مهم: ملف Showcase للاختبار

أنشئ صفحة `_design-showcase.php` (محمية بكلمة سر):
```html
<!-- صفحة تعرض كل المكونات بكل حالاتها -->
<h2>الأزرار</h2>
<button class="btn-shield-primary">Primary</button>
<button class="btn-shield-primary loading">Loading</button>
<button class="btn-shield-primary" disabled>Disabled</button>
<!-- ... كل البقية -->
```

هذه الصفحة:
- تختصر تصحيح الأخطاء بـ 80%.
- تعطيك نظرة شاملة قبل دمج المكونات في الصفحات الفعلية.
- تبقى مرجعاً دائماً للتطوير.

### DoD
- [ ] الـ Showcase Page يعرض كل المكونات.
- [ ] كل مكون يعمل في الوضعين Dark + Light.
- [ ] لا تعارض مع AdminLTE الموجودة.
- [ ] الصفحات الحالية لم تتعطل (تبدو غريبة قليلاً، ولكن تعمل).

---

## 🏛️ المرحلة 3 — هيكل التطبيق (App Shell)

### الأهداف
استبدال الـ Sidebar والـ Topbar من AdminLTE بنسختنا الجديدة.

### المهام

#### 3.1 Sidebar الجديد
- **نسخ** كود الـ Sidebar من `core.php` (دون حذف الأصلي مباشرة).
- وضعه في `includes/shield-sidebar.php` كـ markup HTML بحت.
- إعادة بنائه بكلاسات `shield-sidebar` (انظر [`05-layout-and-navigation.md`](./05-layout-and-navigation.md)).
- إضافة الـ Active State الذكي بناءً على `$_SERVER['REQUEST_URI']` (متاح بدون أي استعلام).
- Status Dots: **تصميم بصري فقط** (CSS). إن كانت توجد متغيرات حالة في الكود الأصلي فاستخدمها، وإلا اعرض دوائر ثابتة دون قراءة من DB.

#### 3.2 Topbar الجديد
- **نسخ** كود الـ Navbar من `core.php` (الأصلي يبقى مرجعاً حتى نهاية المرحلة).
- وضعه في `includes/shield-topbar.php` كـ markup HTML بحت.
- إضافة Breadcrumb (يمكن تمريره من كل صفحة عبر متغير `$page_breadcrumb`).
- إضافة Theme Toggle (يستدعي `shield-ui.js` فقط — JavaScript بحت، لا تخزين في DB).
- إضافة Command Palette Trigger (وظيفة فعلية في المرحلة 6).

#### 3.3 Page Header موحد
دالة PHP مساعدة:
```php
function shield_page_header($title, $subtitle = '', $actions = '') {
  echo "<header class='page-header'>...</header>";
}
```

#### 3.4 JavaScript للهيكل
ملف `assets/js/shield/shield-ui.js`:
```javascript
const ShieldUI = {
  init() {
    this.initSidebarToggle();
    this.initThemeToggle();
    this.initTopbarScroll();
    this.initDropdowns();
    this.initTooltips();
  },
  initSidebarToggle() {
    const btn = document.querySelector('[data-toggle="sidebar"]');
    btn?.addEventListener('click', () => {
      document.body.classList.toggle('sidebar-collapsed');
      localStorage.setItem('shield:sidebar', document.body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'expanded');
    });
    if (localStorage.getItem('shield:sidebar') === 'collapsed') {
      document.body.classList.add('sidebar-collapsed');
    }
  },
  initThemeToggle() { /* ... */ },
  initTopbarScroll() { /* ... */ },
  // ...
};
document.addEventListener('DOMContentLoaded', () => ShieldUI.init());
```

### DoD
- [ ] Sidebar الجديد يعمل في كل الصفحات.
- [ ] Topbar الجديد يعمل في كل الصفحات.
- [ ] التبديل بين Light/Dark يعمل.
- [ ] طي/توسيع Sidebar يعمل ويُحفظ.
- [ ] Sidebar في الجوال يفتح كـ Drawer.
- [ ] Active state يُبرز الصفحة الحالية.

---

## 📈 المرحلة 4 — لوحة التحكم الرئيسية

### الأهداف
بناء `dashboard.php` بالشكل الجديد كنموذج مرجعي.

### ⚠️ قاعدة ذهبية لهذه المرحلة
**ممنوع منعاً باتاً** تعديل أي استعلام SQL، أو تغيير أسماء المتغيرات الخلفية، أو نقل أي منطق برمجي. 
المتغيرات التي تُملأ من PHP (مثل `$total_blocked`, `$threats_today`) تبقى **كما هي بنفس الأسماء وفي نفس المواقع**. 
كل التعديل ينحصر في **HTML/CSS الذي يحيط بهذه المتغيرات**.

### المهام

#### 4.1 تغليف الـ HTML الموجود فقط
**النهج:** افتح `dashboard.php`، احتفظ بكل كود PHP كما هو حرفياً، واستبدل **markup العرض** فقط:

```php
<!-- قبل -->
<div class="card bg-info">
  <div class="card-body">
    <h3><?= $total_blocked ?></h3>
    <p>المحظورة</p>
  </div>
</div>

<!-- بعد (نفس المتغير، تصميم جديد) -->
<div class="shield-kpi-card shield-kpi--info">
  <div class="shield-kpi-value"><?= $total_blocked ?></div>
  <div class="shield-kpi-label">المحظورة</div>
</div>
```

#### 4.2 بناء KPIs الأربعة
كل KPI يحتاج:
- رقم رئيسي (من المتغير الموجود أصلاً).
- مقارنة (Δ vs الأمس) — **فقط إن كان المتغير موجوداً في الكود الأصلي**، وإلا تُحذف هذه الجزئية.
- Sparkline — **اختياري**، يُعرض فقط إذا توفرت بيانات في PHP بالفعل.
- مؤشر Live: عنصر CSS بحت (لا يحتاج باك-إند).

#### 4.3 بناء الـ Charts
استخدم نفس استدعاءات Chart.js الموجودة في الكود الأصلي، فقط استبدل **خيارات الألوان والخطوط** عبر `Chart.defaults` (موضح في الوثيقة 06).
- Threats Timeline (Area chart) — تستخدم نفس مصفوفة البيانات.
- Top Countries (Bar list) — نفس المصدر.
- Threat Types Distribution (Donut) — نفس المصدر.

#### 4.4 Live Activity Stream (إن وُجد أصلاً)
إذا كانت الصفحة الأصلية تحتوي بالفعل على تحديث AJAX، فقط أعد تنسيق الـ HTML المُعاد. 
**لا تنشئ endpoints جديدة. لا تعدل أي ملف PHP في `modules/` أو `api/`.**
إن لم يوجد تحديث حي أصلاً، تجاهل هذه الجزئية تماماً.

### DoD
- [ ] الصفحة تعرض **نفس البيانات** بالضبط التي كانت تظهر قبل التعديل.
- [ ] لم يُحذف أو يُضف أي استعلام SQL.
- [ ] أسماء جميع متغيرات PHP محفوظة كما هي.
- [ ] كل الرسوم تعمل بدون أخطاء console.
- [ ] الصفحة تظهر بشكل مقبول على الجوال.
- [ ] أداء الصفحة (Lighthouse) ≥ 80.

---

## 📋 المرحلة 5 — صفحات الميزات

### الأهداف
تطبيق التصميم على باقي الصفحات.

### الترتيب المقترح (الأكثر تأثيراً أولاً)

| الترتيب | الصفحة | الوقت | ملاحظات |
|--------|--------|-------|---------|
| 1 | `all-logs.php` | 1 يوم | الأكثر استخداماً |
| 2 | `sql-injection.php` | 0.5 يوم | نفس النمط |
| 3 | `badbots.php` | 0.5 يوم | نفس النمط |
| 4 | `spam.php` | 0.5 يوم | نفس النمط |
| 5 | `proxy.php` | 0.5 يوم | نفس النمط |
| 6 | صفحات Blacklist/Whitelist | 1 يوم | فلترة + إضافة + حذف |
| 7 | الإعدادات | 1 يوم | حقول كثيرة، تنظيم بـ Tabs |
| 8 | `index.php` (Login) | 0.5 يوم | لمسة الإعجاب الأولى |

### قالب موحد لكل صفحة Logs (التعديل البصري فقط):
**قاعدة:** افتح ملف الصفحة الأصلي، احتفظ بكل كود PHP و SQL والمتغيرات كما هي حرفياً، واستبدل فقط **هيكل HTML** بالنمط أدناه:

```php
<?php
// ============================================
// كل الكود الأصلي يبقى كما هو دون تغيير:
// require_once 'core.php' (موجود مسبقاً)
// أي SQL queries موجودة تبقى كما هي
// كل المتغيرات تحتفظ بأسمائها
// ============================================
?>

<?php head(); ?>

<!-- الجديد: غلاف ترويسة الصفحة (HTML بحت، لا يحتاج باك-إند) -->
<?php shield_page_header('Bad Bots Protection', 'حظر البوتات الخبيثة'); ?>

<!-- KPIs: تستخدم نفس متغيرات PHP الموجودة أصلاً في الصفحة -->
<section class="shield-grid shield-grid--4">
  <div class="shield-kpi-card">
    <div class="shield-kpi-value"><?= $bots_blocked ?? 0 ?></div>
    <div class="shield-kpi-label">البوتات المحظورة</div>
  </div>
  <!-- بقية KPIs بنفس النمط، تستخدم متغيرات الصفحة الأصلية -->
</section>

<!-- الجدول: نفس <table> الأصلي مع إضافة class جديد فقط -->
<div class="shield-table-wrapper">
  <table class="shield-table" id="botsTable">
    <!-- نفس المحتوى الأصلي بالكامل (thead, tbody, PHP loops) -->
  </table>
</div>

<?php footer(); ?>
```

> ⚠️ **تذكير حاسم:** الدالة `shield_page_header()` و class `shield-*` كلها موجودة في ملفات CSS/JS الجديدة فقط. **لا يُسمح** بإنشاء ملفات `lib/` أو `api/` أو نقل أي استعلام SQL.

### DoD
- [ ] كل الصفحات تتبع نفس النمط.
- [ ] لا تكرار في كود HTML (استُخرج إلى includes أو دوال).
- [ ] DataTables تعمل بدون مشاكل.
- [ ] الفلاتر تعمل.

---

## ✨ المرحلة 6 — التلميع والـ QA

### الأهداف
نقل التصميم من "يعمل" إلى "احترافي".

### المهام

#### 6.1 Polish بصري
- [ ] مراجعة كل الـ paddings والـ margins.
- [ ] التأكد من الانتقالات (transitions) في كل التفاعلات.
- [ ] Empty states في كل صفحة.
- [ ] Skeleton loaders بدل spinners.
- [ ] Animations عند تحميل الصفحة (staggered fade-in للـ KPIs).

#### 6.2 Command Palette (`Ctrl+K`)
بناء مكون البحث السريع:
- بحث في الصفحات (`SQL Injection`, `Bad Bots`...).
- بحث في الإجراءات (`حظر IP`, `تصدير`...).
- نتائج fuzzy search.

#### 6.3 الأداء
- [ ] دمج كل ملفات CSS في `shield.bundle.min.css`.
- [ ] دمج كل ملفات JS في `shield.bundle.min.js`.
- [ ] تنزيل الخطوط محلياً (`assets/fonts/`) بدل CDN.
- [ ] Lazy load للـ Charts (initialize فقط عند الظهور في viewport).
- [ ] إضافة `defer` للـ JS غير الحرج.

#### 6.4 Accessibility (a11y)
- [ ] كل الأزرار التي تحوي أيقونات فقط لها `aria-label`.
- [ ] التباين اللوني ≥ 4.5:1 لكل النصوص.
- [ ] Focus visible واضح على كل عنصر تفاعلي.
- [ ] Keyboard navigation تعمل (Tab, Enter, Esc).
- [ ] ARIA attributes للـ Modals والـ Dropdowns.

#### 6.5 الاختبار
- [ ] Chrome, Firefox, Safari, Edge.
- [ ] Windows, Mac, iOS, Android.
- [ ] شاشات: 1920×1080, 1440×900, 1024×768, 375×812.
- [ ] Light + Dark mode.
- [ ] الأرقام تظهر بـ Tabular Numerics في كل الجداول.

#### 6.6 التوثيق النهائي
- [ ] تحديث الوثائق بأي تغييرات.
- [ ] إنشاء `CHANGELOG.md` بكل التغييرات.
- [ ] صور للتصميم القديم vs الجديد (Before/After).
- [ ] فيديو 60 ثانية يستعرض المنتج.

### DoD النهائي
- [ ] Lighthouse ≥ 90 في الأقسام الأربعة.
- [ ] لا أخطاء JS Console.
- [ ] لا تحذيرات CSS.
- [ ] جميع الصفحات تعمل في الوضعين.
- [ ] جميع الصفحات تعمل على الجوال.
- [ ] المالك راضٍ بصرياً ووظيفياً.

---

## 🛡️ خطة الطوارئ (Rollback Plan)

في أي مرحلة، إن ظهرت مشكلة حرجة:

### الخطوة 1: العودة السريعة
```php
// في config_settings.php
$settings['ui_engine'] = 'legacy';
```
خلال 5 ثوانٍ، الموقع يعود للتصميم القديم.

### الخطوة 2: التحقيق
- افحص Console errors.
- افحص PHP error logs.
- افحص آخر ملف عُدِّل (`git log` إن استُخدم).

### الخطوة 3: الإصلاح أو الـ Rollback الكامل
```bash
# في حالة كارثية
rm -rf /pro1
mv /pro1.backup-XXXXXXXX /pro1
```

> **توصية بالغة الأهمية:** استخدم **Git** من اليوم الأول. كل مرحلة = commit واحد على الأقل. كل ميزة = branch منفصل.

---

## 📅 جدولة مقترحة (للمطور بدوام جزئي 4 ساعات/يوم)

| الأسبوع | المراحل | الأيام |
|--------|--------|-------|
| 1 | المرحلة 0 + 1 | 5 أيام |
| 2 | المرحلة 2 (Components) | 5 أيام |
| 3 | المرحلة 3 + 4 | 5 أيام |
| 4 | المرحلة 5 (Feature Pages) | 5 أيام |
| 5 | المرحلة 6 (QA + Polish) | 5 أيام |

**المجموع: 5 أسابيع، تقريباً 100 ساعة عمل.**

> ⚡ **لمطور بدوام كامل:** يمكن إنجازها في 3 أسابيع.

---

## ✅ مؤشرات النجاح (Success Metrics)

عند الانتهاء، اقس النجاح بـ:

| المؤشر | الهدف |
|--------|------|
| Lighthouse Performance | ≥ 90 |
| Lighthouse Accessibility | ≥ 95 |
| Time to Interactive | ≤ 2s |
| First Contentful Paint | ≤ 1s |
| رضا المستخدم (NPS) | ≥ 8/10 |
| اكتشاف الأخطاء (Bugs) | ≤ 5 في الأسبوع الأول |

---

## 📎 الخطوة التالية

اقرأ الآن: [`08-file-structure-and-naming.md`](./08-file-structure-and-naming.md) — كل ما يخص بنية الملفات والتسميات.
