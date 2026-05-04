# 🛡️ Web Shield — Design System Documentation

<div align="center">

**نظام تصميم متكامل لمشروع "درع الويب"**
**A Cybersecurity-Grade Design System**

`Version 1.0` · `Cybersecurity Theme` · `RTL First` · `AdminLTE Compatible`

</div>

---

## 📖 نظرة عامة

هذه الوثائق تمثل **خطة تصميم احترافية متكاملة** لإعادة هيكلة الواجهة الرسومية لمشروع **Web Shield (درع الويب)**، مع الحفاظ التام على البنية الخلفية (PHP/MySQL) والمنطق التشغيلي للنظام.

الهدف ليس "تجميل" المشروع فقط، بل بناء **نظام تصميم (Design System) كامل** بمعايير الأمن السيبراني الاحترافية، يماثل الأنظمة المعروفة مثل: **CrowdStrike Falcon**, **Cloudflare Dashboard**, **Splunk**, **Wazuh**, **SentinelOne**, **Datadog Security**.

---

## 🎯 المبادئ الحاكمة (Design Principles)

| # | المبدأ | الشرح |
|---|---------|-------|
| 1 | **Zero Backend Impact** | لا نلمس ملف PHP واحد متعلق بالمنطق. كل التغييرات في طبقة العرض فقط. |
| 2 | **Threat-First Visual Language** | كل عنصر بصري يخدم سرعة اتخاذ القرار الأمني (تمييز التهديد، الخطورة، الحالة). |
| 3 | **Cohesive Token System** | ألوان وخطوط ومسافات وحوافٍ مُعرَّفة كـ CSS Variables، لا قيم سحرية. |
| 4 | **RTL Native** | التصميم مبني للعربية أصلاً، لا مُترجم لاحقاً. |
| 5 | **Progressive Enhancement** | يعمل فوق AdminLTE الموجود؛ يمكن إيقافه فوراً دون كسر النظام. |
| 6 | **Operator-Grade Density** | كثافة معلومات عالية (مثل لوحات SOC) دون فوضى. |

---

## 📚 خريطة الوثائق (Documentation Map)

تم تقسيم الخطة إلى **8 وثائق متخصصة**، كل وثيقة تركز على جانب واحد من نظام التصميم:

| الترتيب | الملف | الموضوع | الجمهور |
|--------|-------|---------|---------|
| 00 | [`00-README.md`](./00-README.md) | فهرس عام (هذا الملف) | الجميع |
| 01 | [`01-design-philosophy.md`](./01-design-philosophy.md) | الفلسفة والاتجاه البصري | المصمم / مدير المشروع |
| 02 | [`02-design-tokens.md`](./02-design-tokens.md) | نظام الـ Tokens (ألوان، خطوط، مسافات) | المطور / المصمم |
| 03 | [`03-typography-and-iconography.md`](./03-typography-and-iconography.md) | الخطوط والأيقونات | المصمم / المطور |
| 04 | [`04-component-library.md`](./04-component-library.md) | مكتبة المكونات (Cards, Tables, Forms…) | المطور |
| 05 | [`05-layout-and-navigation.md`](./05-layout-and-navigation.md) | الهيكل العام، الـ Sidebar، الـ Topbar | المطور |
| 06 | [`06-data-visualization.md`](./06-data-visualization.md) | الرسوم البيانية والإحصائيات | المطور |
| 07 | [`07-implementation-roadmap.md`](./07-implementation-roadmap.md) | خطة التنفيذ المرحلية | مدير المشروع / المطور |
| 08 | [`08-file-structure-and-naming.md`](./08-file-structure-and-naming.md) | بنية الملفات والتسميات | المطور |

---

## 🚀 من أين تبدأ؟

### إذا كنت **مدير المشروع** أو **صاحب القرار**:
1. اقرأ هذا الملف (`00-README.md`).
2. اقرأ [`01-design-philosophy.md`](./01-design-philosophy.md) لفهم الاتجاه البصري.
3. اقرأ [`07-implementation-roadmap.md`](./07-implementation-roadmap.md) لمعرفة الخطوات الزمنية.

### إذا كنت **المطور المنفِّذ**:
1. اقرأ هذا الملف.
2. اقرأ [`08-file-structure-and-naming.md`](./08-file-structure-and-naming.md) لتعرف ما الذي ستنشئه.
3. اقرأ [`02-design-tokens.md`](./02-design-tokens.md) لتعرف القيم.
4. اقرأ المكونات حسب الحاجة (`04`, `05`, `06`).
5. اتبع [`07-implementation-roadmap.md`](./07-implementation-roadmap.md) خطوة بخطوة.

### إذا كنت **مصمماً (UI/UX Designer)**:
1. اقرأ هذا الملف.
2. ركّز على: `01`, `02`, `03`, `04`.

---

## 🔗 الملفات المطلوبة من المطوّر للبدء الفعلي

عند البدء في التنفيذ، نوصي بطلب الملفات التالية من المالك للحصول على دقة أعلى:

| الملف | السبب |
|------|------|
| `core.php` | لفهم بنية `head()` و `footer()` ودمج التصميم الجديد. |
| `dashboard.php` | لرؤية كيف تُستهلك البيانات حالياً وتطويع الكروت لها. |
| `assets/css/psec.css` | لمعرفة ما تم تخصيصه مسبقاً وعدم تكراره. |
| `dist/css/custom.css` | لفهم تعديلات RTL الحالية. |
| لقطات شاشة من الواجهة الحالية | لتحديد نقاط الألم البصرية بدقة. |

> 💡 إن لم تتوفر هذه الملفات الآن، فالخطة مكتوبة بشكل **مستقل** ويمكن تنفيذها بمجرد البدء في الاطلاع على `core.php`.

---

## ⚙️ الفلسفة التقنية باختصار

```
┌─────────────────────────────────────────────────────────┐
│  Backend (PHP/MySQL)         ← لا يُمَس على الإطلاق     │
├─────────────────────────────────────────────────────────┤
│  Existing AdminLTE/Bootstrap  ← يبقى كأساس متوافق      │
├─────────────────────────────────────────────────────────┤
│  ✦ NEW: Design Token Layer    ← CSS Variables موحدة    │
│  ✦ NEW: Override Stylesheet   ← assets/css/shield.css  │
│  ✦ NEW: Component Patches     ← assets/css/components/ │
│  ✦ NEW: Theme Bridge JS       ← assets/js/shield-ui.js │
└─────────────────────────────────────────────────────────┘
```

النتيجة: **مظهر جديد بالكامل** يُوضع كطبقة فوق AdminLTE، يمكن **تفعيله أو إيقافه بسطر واحد** في `core.php` (أو حتى عبر إعداد في `config_settings.php`).

---

## 📝 ملاحظة ختامية

هذه الوثائق **مرجع حي (Living Documentation)** — حدّثها كلما تطور النظام. كل ملف يبدأ بـ Frontmatter يوضح: التاريخ، الإصدار، المسؤول، آخر مراجعة.

> *"التصميم الجيد للأمن السيبراني لا يُلفت الانتباه — بل يجعل الانتباه ممكناً."*
