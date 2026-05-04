# وثيقة مرجعية وشاملة لمشروع "درع الويب" (Web Shield)

هذه الوثيقة موجهة لأي مطور أو نموذج ذكاء اصطناعي (AI Model) خارجي يحتاج إلى فهم المشروع بالكامل والبدء في تطويره والتعديل عليه، خاصة فيما يتعلق بالتصميم وهيكلة الواجهات.

---

## 1. فكرة المشروع
المشروع عبارة عن **نظام حماية وإدارة أمان لتطبيقات الويب (Web Application Firewall & Security Dashboard)**. 
يقوم النظام بمراقبة الزيارات، حظر الهجمات (مثل الحقن SQLi، البوتات الخبيثة Bad Bots، البروكسيات، والمزعجين Spammers)، ويوفر لوحة تحكم متكاملة لعرض الإحصائيات وإدارة القوائم السوداء (حظر IP، دول، أو نطاقات) والقوائم البيضاء.

---

## 2. التقنيات المستخدمة (Tech Stack)
* **الخلفية (Backend):** لغة PHP (كلاسيكية/Vanilla) مع قواعد بيانات MySQL (يتم الاتصال بها غالباً عبر `mysqli`).
* **الواجهات (Frontend):** HTML5, CSS3, JavaScript.
* **إطار عمل التصميم (Legacy):** Bootstrap 4 (نسخة تدعم اللغة العربية RTL) + قالب **AdminLTE 3**.
* **إطار عمل التصميم (Shield):** نظام تصميم مخصص بالكامل يعتمد على CSS Variables وGrids و Lucide Icons.
* **المكتبات الإضافية:** jQuery, FontAwesome, Chart.js, DataTables, Lucide Icons.

---

## 3. الهيكل العام للمشروع (Project Structure)

* **الملفات الجذرية (`d:/pro1/*.php`):** صفحات لوحة التحكم المختلفة.
* **`core.php`:** أهم ملف في الواجهات — يحتوي على `head()` و`footer()` والـ Sidebar والـ Navbar.
* **`config_settings.php`:** ملف الإعدادات العامة بما فيها `$settings['ui_engine']`.
* **`modules/`:** العمليات البرمجية الخلفية (لا يجب تعديلها أبدًا).
* **`assets/css/shield/`:** ملفات CSS الخاصة بنظام Shield UI Engine.
* **`includes/`:** مكونات Shield القابلة لإعادة الاستخدام (مثل `shield-dashboard-modules.php`).

---

## 4. نظام التصميم المزدوج (Dual UI Engine)

### المبدأ الأساسي
المشروع يدعم **وضعَين للواجهة** يمكن التبديل بينهما من `config_settings.php`:

```php
// للتفعيل
$settings['ui_engine'] = 'shield';

// للإلغاء (العودة للوضع القديم)
$settings['ui_engine'] = 'legacy'; // أو أي قيمة أخرى
```

### نمط الاستخدام (Pattern)
كل صفحة PHP تستخدم النمط التالي:

```php
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <!-- Shield UI Components -->
    <header class="shield-page-header">...</header>
    <div class="shield-card">...</div>
<?php else: ?>
    <!-- Legacy AdminLTE HTML -->
    <div class="content-header">...</div>
    <div class="card card-primary">...</div>
<?php endif; ?>
```

### مكونات Shield المعتمدة
| المكوّن | الكلاس | الوصف |
|---|---|---|
| رأس الصفحة | `shield-page-header` | عنوان + وصف + أزرار الإجراءات |
| البطاقة | `shield-card` + `shield-card__header` + `shield-card__body` | حاوية المحتوى |
| الشبكة | `shield-grid shield-grid--2/3` | تخطيط عمودين أو ثلاثة |
| الجدول | `shield-table` + `shield-table-wrapper` | جداول البيانات |
| الشارة | `shield-badge shield-badge--{success|critical|warning|info|neutral}` | حالات البيانات |
| الأزرار | `btn-shield-primary/secondary/warning/success` | أزرار الإجراءات |
| مفتاح التبديل | `shield-switch` | تفعيل/تعطيل الميزات |

### الأيقونات
جميع الأيقونات تستخدم **Lucide Icons** حصريًا:
```html
<i data-lucide="shield" class="icon icon-sm text-brand"></i>
```

---

## 5. الصفحات المكتملة (Shield Integration Status)

### ✅ لوحة التحكم الرئيسية
| الملف | الحالة |
|---|---|
| `dashboard.php` | ✅ مكتمل |
| `visit-analytics.php` | ✅ مكتمل |

### ✅ صفحات السجلات
| الملف | الحالة |
|---|---|
| `all-logs.php` | ✅ مكتمل |
| `sqli-logs.php` | ✅ مكتمل |
| `badbot-logs.php` | ✅ مكتمل |
| `spammer-logs.php` | ✅ مكتمل |
| `proxy-logs.php` | ✅ مكتمل |
| `log-details.php` | ✅ مكتمل |

### ✅ صفحات إعدادات الحماية
| الملف | الحالة |
|---|---|
| `sql-injection.php` | ✅ مكتمل |
| `badbots.php` | ✅ مكتمل |
| `spam.php` | ✅ مكتمل |
| `proxy.php` | ✅ مكتمل |

### ✅ صفحات الحظر (Bans)
| الملف | الحالة |
|---|---|
| `bans-ip.php` | ✅ مكتمل |
| `bans-iprange.php` | ✅ مكتمل |
| `bans-country.php` | ✅ مكتمل |
| `bans-other.php` | ✅ مكتمل |

### ✅ صفحات النظام والأدوات
| الملف | الحالة |
|---|---|
| `settings.php` | ✅ مكتمل |
| `system-info.php` | ✅ مكتمل |
| `error-monitoring.php` | ✅ مكتمل |
| `ip-lookup.php` | ✅ مكتمل |

### ✅ صفحات المرور الحي والحساب
| الملف | الحالة |
|---|---|
| `live-traffic.php` | ✅ مكتمل |
| `visitor-details.php` | ✅ مكتمل |
| `account.php` | ✅ مكتمل |
| `login-history.php` | ✅ مكتمل |

### ⚙️ ملفات Backend فقط (لا تحتاج UI)
| الملف | الوصف |
|---|---|
| `project-security.php` | نقطة تضمين محرك الحماية — backend فقط |
| `modules/*.php` | منطق الحماية — **لا تعدّل هذه الملفات** |

---

## 6. قواعد التطوير (Development Rules)

> **⚠️ مبدأ "لا تدمير" (Non-Destructive):**
> - يجب الحفاظ على كود AdminLTE تحت `<?php else: ?>` في كل صفحة.
> - لا يُسمح بتعديل أي ملف داخل `modules/`.
> - لا يُسمح بتغيير أي استعلام SQL.
> - يجب أن تعمل كلا الواجهتين بشكل مستقل ومتوازٍ.

> **🎨 معايير Shield UI:**
> - استخدم CSS Variables فقط (لا hard-coded colors).
> - جميع الأيقونات من Lucide Icons.
> - ادعم الوضع الداكن والفاتح عبر CSS Variables.
> - استخدم `shield-grid` بدلاً من Bootstrap grid.

---

## 7. ملاحظات للمطور

للبدء بالعمل:
1. افتح `config_settings.php` وتحقق من قيمة `$settings['ui_engine']`.
2. افتح `core.php` لفهم كيف يتم تضمين CSS و JS الخاص بـ Shield.
3. افتح `assets/css/shield/shield.css` لفهم نظام التصميم (CSS Variables والمكونات).
4. عند إضافة صفحة جديدة، اتبع النمط المذكور في القسم 4.

**ملاحظة:** `project-security.php` هو ملف backend خالص يتم تضمينه في كل صفحة محمية — لا يحتوي على أي HTML ولا يحتاج لأي تعديل في الواجهة.
