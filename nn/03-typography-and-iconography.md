---
document: 03 — Typography & Iconography
project: Web Shield
version: 1.0
status: Draft
audience: Designers, Developers
---

# ✏️ الخطوط والأيقونات (Typography & Iconography)

> الخطوط هي 95% من تجربة الواجهة قبل أن يلاحظها أحد. هذه الوثيقة تحدد كيف نستخدمها.

---

## 1. الخطوط (Typography)

### 1.1 الخطوط المختارة ولماذا

| الدور | الخط | المصدر | السبب |
|-------|------|--------|-------|
| **Display & UI** | `IBM Plex Sans Arabic` | Google Fonts | يدعم العربية بطبيعته، تقني/احترافي، مصمم خصيصاً من IBM للواجهات. |
| **Mono / Code** | `JetBrains Mono` | Google Fonts | الأكثر قابلية للقراءة في الأكواد والأرقام، يميّز `0` و `O`. |
| **Fallback عربي** | `Tajawal` | Google Fonts | احتياطي إن فشل تحميل IBM Plex. |
| **Fallback نظام** | `system-ui` | OS | للحالات الطارئة. |

### 1.2 طريقة التحميل

في `core.php`، داخل دالة `head()`:

```html
<!-- داخل <head> -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- IBM Plex Sans Arabic — أوزان: 300, 400, 500, 600, 700 -->
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- JetBrains Mono — أوزان: 400, 500, 600, 700 -->
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
```

> 💡 **توصية الأداء:** بعد تثبيت التصميم، نزّل ملفات الخطوط محلياً ضمن `assets/fonts/` لتجنب الاعتماد على CDN خارجي.

### 1.3 السلم الطباعي (Type Scale)

| الكلاس | الحجم | الوزن | الاستخدام |
|--------|------|------|-----------|
| `.txt-display-1` | 48px | 700 | شاشة Login، صفحات Hero |
| `.txt-h1` | 36px | 600 | عنوان صفحة |
| `.txt-h2` | 28px | 600 | عنوان قسم رئيسي |
| `.txt-h3` | 22px | 600 | عنوان قسم فرعي |
| `.txt-h4` | 18px | 600 | عنوان كرت / Modal |
| `.txt-h5` | 16px | 600 | عنوان داخلي |
| `.txt-h6` | 14px | 600 | عنوان صغير |
| `.txt-body-lg` | 16px | 400 | فقرة كبيرة |
| `.txt-body` | 13px | 400 | افتراضي |
| `.txt-body-sm` | 12px | 400 | نص ثانوي |
| `.txt-caption` | 11px | 500 | بيانات أسفل عنصر |
| `.txt-label` | 11px | 600 | UPPERCASE + tracking-wider |
| `.txt-overline` | 10px | 700 | UPPERCASE + tracking-wider — للترويسات الصغيرة |

### 1.4 الأرقام (Numerics) — قاعدة حاسمة

> **كل رقم في الواجهة يستخدم `font-variant-numeric: tabular-nums` — لمحاذاة الأرقام في الجداول.**

```css
.num,
table td,
.kpi-value,
.timestamp {
  font-feature-settings: "tnum";
  font-variant-numeric: tabular-nums;
}
```

**الأرقام التقنية (IPs, Hashes, IDs, Timestamps):**
- دائماً بخط `JetBrains Mono`.
- بحجم `--text-sm` (12px) في الجداول.
- بلون `--text-secondary` (تميل للرمادي) لإراحة العين.

**أرقام KPIs (الأعداد الكبيرة):**
- بخط `JetBrains Mono`.
- بحجم `--text-3xl` (28px) أو أكبر.
- وزن `bold`.
- اللون حسب السياق (نيون للنشط، أحمر للحرج).

### 1.5 قواعد العربية الخاصة

```css
/* في shield.css، قسم RTL */
[dir="rtl"] {
  font-family: var(--font-display);
}

/* الأرقام في العربية تبقى لاتينية (لا أرقام هندية) */
[dir="rtl"] .num,
[dir="rtl"] table td,
[dir="rtl"] .kpi-value {
  direction: ltr;
  unicode-bidi: embed;
}

/* IPs و emails دائماً LTR حتى في سياق عربي */
.ip-address,
.email,
.url {
  direction: ltr;
  display: inline-block;
  unicode-bidi: embed;
}
```

### 1.6 ارتفاع السطر — قواعد دقيقة

| نوع النص | ارتفاع السطر |
|---------|------------|
| عناوين كبيرة (h1-h3) | 1.2 (`tight`) |
| عناوين صغيرة (h4-h6) | 1.3 |
| نص جسم | 1.5 (`normal`) |
| فقرات قراءة طويلة | 1.7 (`relaxed`) |
| داخل الجداول | 1.4 (`snug`) |

### 1.7 أمثلة استخدام صحيحة

```html
<!-- عنوان صفحة لوحة التحكم -->
<h1 class="txt-h1">لوحة المراقبة</h1>
<p class="txt-body-sm txt-secondary">آخر تحديث: قبل 12 ثانية</p>

<!-- KPI Card -->
<div class="kpi-card">
  <span class="txt-label txt-tertiary">التهديدات النشطة</span>
  <div class="kpi-value num">1,247</div>
  <span class="txt-caption txt-success">↑ 12% خلال 24 ساعة</span>
</div>

<!-- صف جدول -->
<tr>
  <td class="ip-address num">192.168.1.105</td>
  <td>Cloudflare LLC</td>
  <td><span class="badge badge-critical">حرج</span></td>
  <td class="num txt-tertiary">2026-04-26 14:32:18</td>
</tr>
```

---

## 2. الأيقونات (Iconography)

### 2.1 المكتبة المختارة: **Lucide Icons**

نستخدم **Lucide** (الإصدار الحديث من Feather Icons) لأنه:
- أكثر اتساقاً وحداثة من FontAwesome.
- مفتوح المصدر بترخيص ISC.
- أيقونات SVG قابلة للتلوين عبر CSS.
- 1500+ أيقونة بأسلوب موحد (stroke 1.5px).

> **لكن:** المشروع الحالي يستخدم FontAwesome. سنحتفظ بـ FontAwesome للملفات القديمة (لتجنب كسر شيء)، ونستخدم Lucide في الكود الجديد فقط.

### 2.2 طريقة التضمين

عبر CDN في `core.php`:
```html
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  // في footer():
  document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
```

الاستخدام:
```html
<i data-lucide="shield-check" class="icon icon-md"></i>
<i data-lucide="alert-triangle" class="icon icon-sm icon-warning"></i>
```

### 2.3 أحجام الأيقونات (موحدة)

```css
.icon { stroke-width: 1.5; flex-shrink: 0; }
.icon-xs { width: 12px; height: 12px; }
.icon-sm { width: 14px; height: 14px; }
.icon-md { width: 16px; height: 16px; }   /* الافتراضي */
.icon-lg { width: 20px; height: 20px; }
.icon-xl { width: 24px; height: 24px; }
.icon-2xl { width: 32px; height: 32px; }
```

### 2.4 خريطة الأيقونات الدلالية

كل وحدة وحالة في النظام لها أيقونة محددة (لتوحيد التجربة):

| الوحدة / الحالة | أيقونة Lucide |
|----------------|--------------|
| لوحة التحكم | `layout-dashboard` |
| SQL Injection | `database` |
| Bad Bots | `bug` |
| Spam | `mail-x` |
| Proxy | `shuffle` |
| كل السجلات | `list` |
| القائمة السوداء | `ban` |
| القائمة البيضاء | `check-circle-2` |
| الإعدادات | `settings` |
| الإحصائيات | `bar-chart-3` |
| تسجيل الخروج | `log-out` |
| البحث | `search` |
| التنبيهات | `bell` |
| المستخدم | `user-circle-2` |
| تحذير | `alert-triangle` |
| خطأ حرج | `shield-alert` |
| نجاح | `shield-check` |
| معلومات | `info` |
| تحميل البيانات | `loader-2` (مع animate-spin) |
| لا توجد بيانات | `inbox` |
| تصدير | `download` |
| استيراد | `upload` |
| تحديث | `refresh-cw` |
| فلتر | `filter` |
| المزيد | `more-horizontal` |

### 2.5 ألوان الأيقونات

```css
.icon-primary   { color: var(--color-brand-500); }
.icon-secondary { color: var(--text-secondary); }
.icon-tertiary  { color: var(--text-tertiary); }
.icon-success   { color: var(--color-success); }
.icon-warning   { color: var(--color-warning); }
.icon-critical  { color: var(--color-critical); }
.icon-info      { color: var(--color-info); }
```

### 2.6 الأيقونات المخصصة (Custom SVG)

بعض المفاهيم تحتاج أيقونات لا توجد في Lucide. نخزنها في:
`assets/icons/custom/*.svg`

أمثلة مقترحة:
- `shield-hex.svg` — درع سداسي (الشعار).
- `firewall.svg` — جدار بنصف دائرة.
- `threat-radar.svg` — رادار للتهديدات.
- `geo-lock.svg` — قفل على خريطة.

كلها يجب أن تحترم:
- Stroke 1.5px.
- ViewBox 24×24.
- بدون ألوان مدمجة (تستخدم `currentColor`).

---

## 3. الشعار وعلامة المنتج (Logo & Brand Mark)

### 3.1 المقترح
- **الاسم الكامل (للسايدبار الموسع):** "Web Shield" بخط Display بوزن 600، حجم 18px.
- **الرمز فقط (للسايدبار المطوي):** أيقونة سداسية بسيطة `shield-hex` بلون `--color-brand-500`.
- **النسخة الاحتفالية (Login Screen):** الرمز السداسي بحجم 64px مع توهج خفيف `--glow-brand`.

### 3.2 الاستخدامات الممنوعة
- ❌ تشويه الشعار (تمدد، انضغاط).
- ❌ تطبيق ظلال مزدوجة.
- ❌ استخدامه على خلفية لا توفر تباين كافٍ (يجب توفر contrast ratio ≥ 4.5).

---

## 4. الـ Empty States — لمسة احترافية

عندما لا توجد بيانات، لا تكتفِ بنص "لا توجد نتائج". اعرض:

```
┌─────────────────────────────────┐
│                                 │
│         [أيقونة 48px]            │
│                                 │
│    لا تهديدات في هذه الفترة      │  ← 16px semibold
│                                 │
│  جميع الزيارات في آخر ساعة آمنة. │  ← 13px regular secondary
│                                 │
│      [زر: تحديث الفلتر]          │
│                                 │
└─────────────────────────────────┘
```

CSS:
```css
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: var(--space-12) var(--space-6);
  text-align: center;
  color: var(--text-secondary);
}
.empty-state .icon {
  width: 48px; height: 48px;
  color: var(--text-tertiary);
  margin-bottom: var(--space-4);
}
.empty-state h4 {
  color: var(--text-primary);
  margin-bottom: var(--space-2);
}
```

---

## 5. توصيات عامة

1. **لا تختلط الخطوط** — لا تستخدم خطاً ثالثاً غير الموجودين في الـ Tokens.
2. **لا تستخدم `text-align: justify`** — يكسر الإيقاع البصري في العربية.
3. **`font-feature-settings`** — فعّل `"ss01"` و `"cv11"` في IBM Plex لتحسين بعض الأحرف.
4. **حجم النص في الجوال أكبر** — كل النصوص تحت 13px تصبح 14px على شاشات `< 768px` لسهولة القراءة.

---

## 📎 الخطوة التالية

اقرأ الآن: [`04-component-library.md`](./04-component-library.md) — تفصيل كل مكون.
