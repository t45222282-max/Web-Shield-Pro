<?php
require "core.php";
head();
$isShield = (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield');
$calloutClass = $isShield ? 'neon-host-card neon-border-info' : 'callout callout-default';
$badgeSuccess = $isShield ? 'shield-badge shield-badge--success' : 'badge badge-success';
$badgeDanger  = $isShield ? 'shield-badge shield-badge--critical' : 'badge badge-danger';
$badgeWarning = $isShield ? 'shield-badge shield-badge--warning' : 'badge badge-warning';
?>

session_name("WebsiteID");
?>
<div class="content-wrapper">

<!--حاوية المحتوى-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">فحص التكوين والأمان</h1>
            <p class="txt-body-sm txt-secondary">مراجعة إعدادات الخادم لضمان أقصى درجات الأمان.</p>
        </div>
    </header>
<?php else: ?>
<div class="content-header">
    
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fab fa-php"></i> مدقق تكوين PHP</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة الإدارة</a></li>
            <li class="breadcrumb-item active">مدقق تكوين PHP</li>
          </ol>
        </div>
      </div>
    </div>
</div>
<?php endif; ?>
    <!--محتوى الصفحة-->
    <!--===================================================-->
    <div class="content">
    <div class="container-fluid">

    <div class="row">
    <div class="col-md-12">
    
    <div class="shield-card">
            <div class="shield-card" data-card-widget="collapse">
                <h3 class="shield-card">معلومات PHP</h3>
                <div class="shield-card">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
            </div>
            <div class="shield-card">
                <div class="shield-table">
<?php
ob_start();
phpinfo();
$pinfo = ob_get_contents();
ob_end_clean();

$pinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);
echo $pinfo;
?>
                </div>
            </div>
    </div>
        
    <div class="shield-card">
            <div class="shield-card">
                <h3 class="shield-card">مدقق تكوين PHP</h3>
            </div>
            <div class="shield-card">
<?php
// رموز نتائج الاختبار
define("TEST_Critical", "حرج"); // تم العثور على مشكلة حرجة.
define("TEST_High", "عالي"); // تم العثور على مشكلة عالية.
define("TEST_Medium", "متوسط"); // متوسط. قد تكون هذه مشكلة.
define("TEST_Low", "منخفض"); // منخفض. تم العثور على مشكلة بسيطة.
define("TEST_Maybe", "محتمل"); // مخاطر أمنية محتملة. يرجى التحقق يدويًا.
define("TEST_Advice", "نصيحة"); // غريب، لكنه يستحق الذكر.
define("TEST_Okay", "جيد"); // كل شيء على ما يرام.
define("TEST_Skipped", "تم التخطي"); // ربما لا ينطبق هنا.

$all_result_codes = array(
TEST_Critical,
TEST_High,
TEST_Medium,
TEST_Low,
TEST_Maybe,
TEST_Advice,
TEST_Okay,
TEST_Skipped
);
$trbs = array(); // نتائج الاختبار حسب الشدة، مثل $trbs[TEST_Okay][...]
foreach ($all_result_codes as $v) {
$trbs[$v] = array();
}

// الكشف عن نظام التشغيل
$cfg['is_win'] = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

// الكشف عن CGI
$cfg['is_cgi'] = (substr(php_sapi_name(), 0, 3) === 'cgi');


// الدوال
function tdesc($name, $desc = NULL)
{
return array(
"name" => $name,
"desc" => $desc,
"result" => NULL,
"reason" => NULL,
"recommendation" => NULL
);
}

function tres($meta, $result, $reason = NULL, $recommendation = NULL)
{
global $trbs;
$res             = array_merge($meta, array(
"result" => $result,
"reason" => $reason,
"recommendation" => $recommendation
));
$trbs[$result][] = $res;
}

function ini_atol($val)
{
$ret = intval($val);
$val = strtoLower($val);
switch (substr($val, -1)) {
case 'g':
$ret *= 1024;
case 'm':
$ret *= 1024;
case 'k':
$ret *= 1024;
}
return $ret;
}

function ini_list($val)
{
if ($val == "") {
return NULL;
}
$ret = preg_split('/[, ]+/', $val);
if (count($ret) == 1 && $ret[0] == "") {
return NULL;
}
return $ret;
}

function is_writable_or_chmodable($fn)
{
if (!extension_loaded("posix")) {
return is_writable($fn);
}
$stat = @stat($fn);
if (!$stat) {
return false;
}
$myuid  = posix_getuid();
$mygids = posix_getgroups();
if ($myuid == 0 || $myuid == $stat['uid'] || in_array($stat['gid'], $mygids) && $stat['mode'] & 0020 || $stat['mode'] & 0002) {
return true;
}
return false;
}

function is_on($value)
{
if ($value == "0" || $value === "" || strtoLower($value) == "off") {
return 0;
}
return 1;
}


function test_all_ini_entries()
{
global $cfg;
$helptext = array(
"display_errors" => "رسائل الأخطاء قد تكشف عن معلومات حول الآلية الداخلية للتطبيق وقد تتضمن بيانات حساسة مثل معرف الجلسة، المعلومات الشخصية، هياكل قواعد البيانات، وأجزاء من الشيفرة المصدرية. يُوصى بتسجيل الأخطاء بدلاً من عرضها في الأنظمة الحية.",
'log_errors' => "على الرغم من أن تجنب التسجيل قد يكون مفضلاً من منظور الخصوصية، فإن مراقبة سجلات الأخطاء يمكن أن تساعد في اكتشاف الهجمات، أخطاء البرمجة، وأخطاء التكوين.",
'expose_php' => "كشف إصدار PHP الدقيق - بما في ذلك مستوى التصحيح ونظام التشغيل أحيانًا - يمكن أن يكون نقطة انطلاق لأدوات الهجوم الآلية. من الأفضل عدم مشاركة هذه المعلومات.",
'max_execution_time' => "لمنع هجمات الحرمان من الخدمة التي تحاول إبقاء وحدة المعالجة المركزية مشغولة، يجب ضبط هذه القيمة على أقل قيمة ممكنة، مثل 30 (ثانية).",
'max_input_time' => "قد يكون من المفيد تحديد الوقت المسموح لتحليل المدخلات. يجب ضبط هذا بناءً على احتياجات التطبيق.",
'max_input_nesting_level' => "التعشيش العميق للمدخلات نادر الحاجة وقد يؤدي إلى استنفاد الموارد بشكل غير متوقع.",
'memory_limit' => "حد ذاكرة مرتفع قد يؤدي بسهولة إلى استنفاد الموارد، مما يجعل التطبيق عرضة لهجمات الحرمان من الخدمة. يُوصى بضبط هذه القيمة بحوالي 20% أعلى من الحد الأقصى لمتطلبات الذاكرة المحددة تجريبيًا.",
'post_max_size' => "ضبط الحد الأقصى لـ POST على قيمة عالية قد يؤدي إلى الحرمان من الخدمة نتيجة استنفاد الذاكرة. إذا لم يكن التطبيق بحاجة إلى رفع ملفات كبيرة، فكر في ضبط هذا على قيمة أقل. ملاحظة: رفع الملفات يجب أن يغطيه هذا الإعداد أيضًا.",
'post_max_size>memory_limit' => "يجب أن يكون post_max_size أقل من memory_limit. وإلا، قد يتسبب طلب POST بسيط في وصول PHP إلى حد الذاكرة وتوقف التنفيذ. هذا قد يؤدي إلى الحرمان من الخدمة أو تنفيذ جزئي للبرنامج.",
'upload_max_filesize' => "يجب أن تتطابق هذه القيمة مع حجم الملف المطلوب فعليًا للتطبيق.",
'max_file_uploads' => "يجب أن تتطابق هذه القيمة مع الحد الأقصى لعدد رفع الملفات المتزامنة. (الأقل هو الأفضل)",
'allow_url_fopen' => "قم بتعطيل هذا الخيار إذا أمكن. السماح بفتح العناوين في fopen() قد يؤدي إلى تأثيرات جانبية غير متوقعة للمطورين غير المتمرسين. حتى عند التعطيل، يمكن استرداد المحتوى من العناوين باستخدام أدوات مثل curl.",
'allow_url_include' => "يجب تعطيل هذا الخيار لأسباب أمنية.",
'magic_quotes' => "يجب تعطيل هذا الخيار. بدلاً من ذلك، يجب معالجة مدخلات المستخدم بشكل آمن عند بناء استعلامات قاعدة البيانات. يُعتبر استخدام magic quotes أو السلوكيات المماثلة غير مستحسن بشدة. إصدارات PHP الحالية لا تدعم هذه الميزة بعد الآن.",
'enable_dl' => "قم بتعطيل هذا الخيار لمنع تحميل شيفرة عشوائية أثناء التشغيل (انظر dl()).",
'disable_functions' => "يجب تعطيل الدوال الخطرة المحتملة وغير المستخدمة، مثل system().",
'request_order' => "يُوصى باستخدام GP لتسجيل GET و POST مع REQUEST.",
'variables_order' => "تغيير هذا الإعداد عادةً غير ضروري؛ ومع ذلك، نادرًا ما تُستخدم متغيرات ENV.",
'auto_globals_jit' => "ما لم يتم الوصول إلى هذه المتغيرات من خلال متغيرات متغيرة، يمكن أن يظل هذا الخيار مفعلاً.",
'register_globals' => "هذا الإرث من الماضي غير متوفر في إصدارات PHP الحالية. إذا كان موجودًا، احتفظ به معطلًا.",
'file_uploads' => "إذا لم يتطلب التطبيق رفع ملفات HTTP، يجب تعطيل هذا الإعداد.",
'filter.default' => "يجب ضبط هذا فقط إذا كان التطبيق مصممًا خصيصًا للتعامل مع القيم المفلترة. عادةً، يُعتبر تصفية جميع مدخلات المستخدم في مكان واحد ممارسة سيئة. بدلاً من ذلك، يجب التحقق من صحة كل مدخل وتشفيره/ترميزه وفقًا لسياقه.",
'open_basedir' => "من الأفضل تقييد الوصول إلى نظام الملفات إلى الدلائل المتعلقة بالتطبيق، مثل الجذر الوثائقي.",
'session.save_path' => "يجب ضبط هذا المسار إلى دليل فريد لتطبيقك، خارج الجذر الوثائقي، مثل /opt/php_sessions/application_1. إذا كان التطبيق الوحيد على الخادم، أو تم تنفيذ آلية تخزين مخصصة للجلسات، أو لا حاجة للجلسات، فالإعداد الافتراضي مناسب.",
'session.cookie_httponly' => "يتحكم هذا الخيار في ما إذا كانت ملفات تعريف الارتباط موسومة بـ httpOnly، مما يجعلها متاحة فقط عبر HTTP وليس JavaScript. هذا يقلل من مخاطر اختطاف الجلسة. يجب تفعيله هنا أو في التطبيق باستخدام session_set_cookie_params().",
'session.cookie_secure' => "يتحكم هذا الخيار في ما إذا كانت ملفات تعريف الارتباط موسومة كآمنة، ليتم إرسالها عبر اتصالات SSL فقط. يجب تفعيله هنا أو في التطبيق باستخدام session_set_cookie_params().",
'session.cookie_lifetime' => "عدم تحديد عمر ملف تعريف الارتباط يزيد من فرص سرقته. يجب ضبط هذه القيمة على قيمة معقولة بناءً على التطبيق، إما هنا أو باستخدام session_set_cookie_params().",
'session.cookie_samesite' => "اضبط SameSite على `Lax` أو `Strict` لحماية أفضل ضد هجمات CSRF.",
'session.referer_check' => "يمكن لـ PHP إبطال معرف الجلسة إذا لم يحتوي المرجع HTTP على سلسلة فرعية مكونة. قد يمنع بعض حالات هجمات CSRF، لكن يمكن للمهاجم التحكم في المرجع بواسطة عملاء/متصفحات مخصصة.",
'session.use_strict_mode' => "عند التفعيل، يُنشئ PHP معرفات جلسة جديدة للمعرفات غير المعروفة، مما يقاوم هجمات تثبيت الجلسة بفعالية.",
'session.use_cookies' => "عند التفعيل، يخزن PHP معرف الجلسة في ملف تعريف ارتباط على جانب العميل. هذا موصى به.",
'session.use_only_cookies' => "يرسل PHP معرف الجلسة فقط عبر ملف تعريف الارتباط، وليس في عنوان URL. يُرجى التفعيل.",
'session.name' => "اسم الجلسة الافتراضي. لماذا لا تغيره إلى شيء أكثر ملاءمة لتطبيقك؟",
'session.use_trans_sid' => "السماح بتخزين معرف الجلسة ضمن عنوان URL يجعل اختطاف الجلسة مخاطرة أمنية. يتم تسجيل عناوين URL في ملفات السجل ويمكن نسخها بسهولة. يجب تعطيل هذا الخيار.",
'always_populate_raw_post_data' => "في الاستضافة المشتركة، لا ينبغي السماح للمستخدم بتحليل بيانات POST الخام. يجب استخدام هذا الخيار فقط إذا كان الوصول إلى بيانات POST الخام مطلوبًا فعليًا.",
'arg_separator' => "فاصل الحجج القياسي لتحليل سلسلة الاستعلام هو '&'. فواصل مخصصة قد تؤدي إلى سلوك غير متوقع مع المكتبات القياسية. يجب تكوين المحللين الإضافيين (مثل WAF أو محللي السجل) وفقًا لذلك.",
'assert.active' => "assert() يقوم بتقييم الشيفرة مثل eval(). ما لم تكن مطلوبة في بيئة حية، يجب تعطيل هذه الميزة.",
'assert.callback' => "الادعاءات الفاشلة تستدعي دالة مستخدم. قد يكون هذا مفيدًا للاختبار، لكنه لا يجب استخدامه في الإنتاج. قد يحاول المهاجم تجاوز هذه القيمة. إذا أمكن، قم بتعطيل assert تمامًا.",
'zend.assertions' => "assert() قادر على تقييم الشيفرة. يُرجى تعطيل هذه الميزة في بيئات الإنتاج بضبط zend.assertions=-1.",
'auto_append_file' => "يقوم PHP بتنفيذ نص إضافي لكل طلب. قد يكون المهاجم قد زرعه هناك. إذا كان هذا غير متوقع، قم

 بتعطيله.",
'cli.pager' => "يقوم PHP بتنفيذ نص إضافي لمعالجة مخرجات CLI. قد يكون المهاجم قد زرعه هناك. إذا كان هذا غير متوقع، قم بتعطيله.",
'cli.prompt' => "مؤشر CLI طويل جدًا قد يشير إلى تكوين غير صحيح. يُرجى التحقق يدويًا.",
'docref_*' => "قد يكشف هذا الإعداد عن موارد داخلية، مثل أسماء الخوادم الداخلية. ضبط docref_root أو docref_ext يعني إخراج HTML لرسائل الأخطاء، وهي ممارسة سيئة في الإنتاج وقد تكشف معلومات مفيدة للمهاجم.",
'default_charset=empty' => "عدم ضبط الترميز الافتراضي يجعل التطبيق عرضة لهجمات الحقن بناءً على تفسير خاطئ لترميز البيانات. إذا لم تكن متأكدًا، اضبط هذا على 'UTF-8'. يجب أن يحتوي إخراج HTML على نفس القيمة، مثل <meta charset=\"utf-8\"/>. يمكن تكوين خادم الويب وفقًا لذلك، مثل 'AddDefaultCharset UTF-8' لـ Apache2.",
'default_charset=typo' => "قم بتغيير هذا إلى 'UTF-8' فورًا.",
'default_charset=iso-8859' => "لا مشكلة في ترميزات ISO8859، لكن طريقة تسليم المحتوى قد تسمح بأحرف متعددة البايت مثل يونيكود. بعض المتصفحات قد تستخدم ترميزًا متعدد البايت بغض النظر عن هذا الإعداد.",
'default_charset=custom' => "الترميز المخصص مقبول طالما أن سلسلة الترميز بأكملها تعرف به. يجب أن يكون التطبيق، اتصالات قاعدة البيانات، PHP، وخادم الويب بنفس الترميز أو يعرفون كيفية التحويل بشكل صحيح. يجب استدعاء دوال التشفير مثل htmlentities() و htmlspecialchars() بالترميز الصحيح.",
'default_mimetype' => "يُرجى ضبط نوع MIME افتراضي، مثل 'text/html' أو 'text/plain'. يجب أن يعكس نوع MIME المحتوى الفعلي. نوع MIME غير صحيح قد يؤدي إلى هجمات الحقن، مثل استخدام 'text/html' مع بيانات JSON قد يؤدي إلى XSS.",
'default_socket_timeout' => "من خلال تأخير إنشاء اتصال مقبس، قد يتمكن المهاجم من تنفيذ هجوم الحرمان من الخدمة. يُرجى ضبط هذه القيمة على قيمة صغيرة معقولة، مثل 10.",
'doc_root=empty' => "توصي وثائق PHP بشدة بضبط هذه القيمة عند استخدام CGI و cgi.force_redirect معطل.",
'error_append_string' => "يضيف PHP مخرجات إضافية إلى رسائل الأخطاء. إذا تم زرع هذه السلسلة بواسطة مهاجم، فقد تحتوي على محتوى نصي وتؤدي إلى XSS. يُرجى التحقق.",
'error_reporting' => "تقرير الأخطاء يمكن أن يوفر معلومات عن سوء التكوين، أخطاء البرمجة، والهجمات المحتملة. يُرجى التفكير في ضبط هذه القيمة.",
'exit_on_timeout' => "في Apache 1 mod_php، قد يواجه 'حالة غير متسقة'، وهو أمر سيء دائمًا. إذا أمكن، قم بتفعيل هذه الميزة.",
'filter.default' => "استخدام مرشح أو مطهر افتراضي لجميع مدخلات PHP ليس ممارسة جيدة. يجب التعامل مع كل مدخل بشكل فردي، مثل التحقق من الصحة، التنظيف، التصفية، ثم التشفير أو الترميز. القيمة الافتراضية هي 'unsafe_raw'.",
'highlight.*' => "قيمة اللون مشبوهة. قد يكون المهاجم قد حقن شيئًا هنا. يُرجى التحقق يدويًا.",
'iconv.internal_encoding!=empty' => "بدءًا من PHP 5.6، يتم اشتقاق هذه القيمة من 'default_charset' ويمكن تركها فارغة بأمان.",
'asp_tags' => "علامات نمط ASP غير شائعة في PHP. إذا لم تكن بحاجة إلى بدء كود PHP بـ <%، يجب تعطيل هذا الخيار.",
'ldap.max_links' => "لمنع هجمات الحرمان من الخدمة، يجب ضبط هذا الخيار على أقل عدد ممكن. إذا لم تكن LDAP مطلوبة، يجب عدم تحميل امتداد LDAP.",
'log_errors_max_len' => "قد يحاول المهاجم استنفاد الموارد مثل مساحة القرص وذاكرة RAM. إذا أمكن، قم بتحديد هذه القيمة إلى الحد الأدنى المعقول، مثل 1024.",
'mail.add_x_header' => "كشف المعلومات: عند إرسال رسائل بريد إلكتروني، يحتوي رأس 'X-PHP-Originating-Script' على اسم ملف النص البرمجي. في الإنتاج، يجب تعطيل هذه الميزة.",
'intl.use_exceptions' => "إذا لم يتم التعامل معها، قد تكون للاستثناءات آثار جانبية غير متوقعة. يُرجى التأكد من التعامل مع الاستثناءات المحتملة بشكل صحيح عند استدعاء دوال intl.",
'last_modified' => "سيتم إرسال رأس Last-Modified لنصوص PHP. هذا كشف طفيف للمعلومات.",
'zend.multibyte' => "هذا غير معتاد. إذا أمكن، تجنب الترميزات متعددة البايت في الملفات المصدر - مثل SJIS، BIG5 - واستخدم UTF-8. معظم حمايات XSS وغيرها ليست على دراية بالترميزات متعددة البايت أو قد تتشوش بسهولة. لاستخدام UTF-8، يمكن تعطيل هذا الخيار بأمان.",
'max_input_vars' => "قد يكون هذا الإعداد غير صحيح. ما لم يكن التطبيق بحاجة إلى عدد هائل من متغيرات الإدخال، يُرجى ضبط هذا على قيمة معقولة، مثل 1000.",
'phar.readonly' => "يجب تعطيل إنشاء وتعديل ملفات phar في الإنتاج.",
'phar.require_hash' => "يجب فرض التحقق من صحة التوقيع لأرشيفات phar. توقيعات Phar من نوع OpenSSL تزيد الأمان بشكل كبير.",
'ffi.enable' => "من وثائق PHP: 'FFI خطير، لأنه يسمح بالتفاعل مع النظام على مستوى منخفض جدًا. يجب استخدام امتداد FFI فقط من قبل المطورين ذوي المعرفة العملية بلغة C وواجهات C APIs.' هذا الامتداد تجريبي.",
'runkit.internal_override' => "يمكن لـ Runkit تعديل/إعادة تسمية/إزالة الدوال الداخلية. بما أن معظم ميزات الأمان تعتمد على الدوال الداخلية، فإن تفعيل هذا الإعداد يجعل جميع ميزات الأمان عديمة الفائدة. من الأفضل إزالة امتداد runkit تمامًا."
);
    
    // php.ini checks
    foreach (ini_get_all() as $k => $v) {
        $value = $v["local_value"]; // For compatibility with PHP <5.3.0 ini_get_all() is not called with the second 'detail' parameter.
        
        $meta           = tdesc("php.ini -> $k");
        $result         = NULL;
        $reason         = NULL;
        $recommendation = NULL;
        if (isset($helptext[$k])) {
            $recommendation = $helptext[$k];
        }
        $ignore = 0;
        
        switch ($k) {
            case 'display_errors':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "عرض الأخطاء مفعل."
                    );
                }
                break;
            case 'display_startup_errors':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "عرض أخطاء بدء التشغيل مفعل."
                    );
                    $recommendation = $helptext['display_errors'];
                }
                break;
            case 'log_errors':
                if (!is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Low,
                        "تسجيل الأخطاء غير مفعل."
                    );
                }
                break;
            case 'expose_php':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Low,
                        "PHP مكشوف في رؤوس HTTP."
                    );
                }
                break;
            case 'max_execution_time':
                if (intval($value) == 0) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "وقت التنفيذ غير محدود."
                    );
                } elseif (intval($value) >= 300) {
                    list($result, $reason) = array(
                        TEST_Low,
                        "حد وقت التنفيذ مرتفع نسبيًا."
                    );
                }
                break;
            case 'max_input_time':
                if ($value == "-1") {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "وقت تحليل المدخلات غير محدود."
                    );
                }
                break;
            case 'max_input_nesting_level':
                if (intval($value) > 128) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "مستوى تعشيش المدخلات مرتفع للغاية."
                    );
                } elseif (intval($value) > 64) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "مستوى تعشيش المدخلات أعلى من المعتاد."
                    );
                }
                break;
            case 'max_input_vars':
                if (intval($value) > 5000) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "عدد مرتفع للغاية."
                    );
                } elseif (intval($value) > 1000) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "عدد أعلى من المعتاد."
                    );
                }
                break;
            case 'memory_limit':
                $value = ini_atol($value);
                if ($value < 0) {
                    list($result, $reason) = array(
                        TEST_High,
                        "حد الذاكرة معطل."
                    );
                } elseif (ini_atol($value) >= 256 * 1024 * 1024) { // default value
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "حد الذاكرة 256 ميغابايت أو أكثر."
                    );
                }
                break;
            case 'post_max_size':
                $tmp = ini_atol(ini_get('memory_limit'));
                $value   = ini_atol($value);
                if ($tmp < 0) {
                    if ($value >= ini_atol('2G')) {
                        list($result, $reason) = array(
                            TEST_Maybe,
                            "post_max_size >= 2 غيغابايت."
                        );
                    }
                    break;
                }
                if ($value > $tmp) {
                    list($result, $reason) = array(
                        TEST_High,
                        "post_max_size أكبر من memory_limit."
                    );
                    $recommendation = $helptext['post_max_size>memory_limit'];
                }
                break;
            case 'upload_max_filesize':
                if ($value === "2M") {
                    list($result, $reason) = array(
                        TEST_Advice,
                        "القيمة الافتراضية."
                    );
                } elseif (ini_atol($value) >= ini_atol("2G")) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "القيمة مرتفعة نسبيًا."
                    );
                }
                break;
            case 'max_file_uploads':
                if (intval($value) > 30) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "القيمة مرتفعة نسبيًا."
                    );
                }
                break;
            case 'alLow_url_fopen':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_High,
                        "السماح لـ fopen() بفتح العناوين."
                    );
                }
                break;
            case 'allow_url_include':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_High,
                        "السماح لـ include/require() بتضمين العناوين."
                    );
                }
                break;
            case 'magic_quotes_gpc':
                if (get_magic_quotes_gpc()) {
                    list($result, $reason) = array(
                        TEST_High,
                        "magic quotes مفعلة."
                    );
                    $recommendation = $helptext['magic_quotes'];
                }
                break;
            case 'magic_quotes_runtime':
                if (get_magic_quotes_runtime()) {
                    list($result, $reason) = array(
                        TEST_High,
                        "magic quotes مفعلة."
                    );
                    $recommendation = $helptext['magic_quotes'];
                }
                break;
            case 'magic_quotes_sybase':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_High,
                        "magic quotes مفعلة."
                    );
                    $recommendation = $helptext['magic_quotes'];
                }
                break;
            case 'enable_dl':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_High,
                        "يمكن لـ PHP تحميل الامتدادات أثناء التشغيل."
                    );
                }
                break;
            case 'disable_functions':
                $value = ini_list($value);
                if (!$v) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "لم يتم تعطيل أي دوال."
                    );
                }
                break;
            case 'request_order':
                $value = strtoupper($value ?? '');
                if ($value === "GP") {
                    break;
                } // Ok
                if (strstr($value, 'C') !== FALSE) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "قيم ملفات تعريف الارتباط في $_REQUEST."
                    );
                }
                break;
            case 'variables_order':
                if ($value === "GPCS") {
                    break;
                }
                if ($value !== "EGPCS") {
                    list($result, $reason) = array(
                        TEST_Advice,
                        "ترتيب متغيرات مخصص."
                    );
                } else {
                    $result = TEST_Okay; // result set includes default helptext
                }
                break;
            case 'auto_globals_jit':
                $result = TEST_Okay;
                break;
            case 'register_globals':
                if ($value !== "" && $value !== "0") {
                    list($result, $reason) = array(
                        TEST_Critical,
                        "register_globals مفعل."
                    );
                }
                break;
            case 'file_uploads':
                if ($value == "1") {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "رفع الملفات مسموح."
                    );
                }
                break;
            case 'filter.default':
                if ($value !== "unsafe_raw") {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "تم ضبط مرشح إدخال افتراضي."
                    );
                }
                break;
            case 'open_basedir':
                if ($value == "") {
                    list($result, $reason) = array(
                        TEST_Low,
                        "open_basedir غير مضبوط."
                    );
                }
                break;
            case 'session.save_path':
                if ($value == "") {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "مسار حفظ الجلسة غير مضبوط."
                    );
                }
                break;
            case 'session.cookie_httponly':
                if (!is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "علم httpOnly لملف تعريف الارتباط للجلسة غير مضبوط ضمنيًا."
                    );
                }
                break;
            case 'session.cookie_secure':
                if (!is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "علم الآمان لملف تعريف الارتباط للجلسة غير مضبوط ضمنيًا."
                    );
                }
                break;
            case 'session.cookie_lifetime':
                if (!is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "عمر ملف تعريف الارتباط للجلسة غير مضبوط ضمنيًا."
                    );
                }
                break;
			case 'session.cookie_samesite':
				if ($value == "") {
					list($result, $reason) = array(
						TEST_Maybe, 
						"SameSite غير مضبوط."
					);
				} elseif ($value !== "Strict") {
					list($result, $reason) = array(
						TEST_Advice, 
						"SameSite ليس مضبوطًا على `Strict`. إذا كانت طلبات GET عبر المواقع إلى موقعك غير مرجحة، يجب ضبط هذا على `Strict`."
					);
				}
			break;
            case 'session.referer_check':
                if ($value === "") {
                    list($result, $reason) = array(
                        TEST_Advice,
                        "التحقق من المرجع غير مفعل."
                    );
                }
                break;
            case 'session.use_strict_mode':
                if (!is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "وضع الجلسة الصارم غير مفعل."
                    );
                }
                break;
            case 'session.use_cookies':
                if (!is_on($value)) {
                    list($result, $reason) = array(
                        TEST_High,
                        "معرف الجلسة لا يُخزن في ملف تعريف الارتباط."
                    );
                }
                break;
            case 'session.use_only_cookies':
                if (!is_on($value)) {
                    list($result, $reason) = array(
                        TEST_High,
                        "معرف الجلسة غير مقتصر على ملف تعريف الارتباط."
                    );
                }
                break;
            case 'session.name':
                if ($value == "PHPSESSID") {
                    list($result, $reason) = array(
                        TEST_Advice,
                        "اسم الجلسة الافتراضي."
                    );
                }
                break;
            case 'session.use_trans_sid':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_High,
                        "معرف الجلسة الشفاف مفعل."
                    );
                }
                break;
            case 'always_populate_raw_post_data':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Advice,
                        "HTTP_RAW_POST_DATA متاح."
                    );
                }
                break;
            case 'arg_separator.input':
            case 'arg_separator.output':
                if ($value !== "&") {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "فاصل حجج غير معتاد."
                    );
                    $recommendation = $helptext['arg_separator'];
                }
                break;
            case 'assert.active':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "assert مفعل."
                    );
                }
                break;
            case 'assert.callback':
                if (ini_get('assert.active') && $value !== "" && $value !== null) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "تم ضبط رد الاتصال لـ assert."
                    );
                }
                break;
            case 'zend.assertions':
                if (intval($value) > 0) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "assert مفعل."
                    );
                }
                break;
            case 'auto_append_file':
            case 'auto_prepend_file':
                if ($value !== NULL && $value !== "") {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "$k مضبوط."
                    );
                    $recommendation = $helptext['auto_append_file'];
                }
                break;
            case 'cli.pager':
                if ($value !== NULL && $value !== "") {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "تم ضبط CLI pager."
                    );
                }
                break;
            case 'cli.prompt':
                if ($value !== NULL && strlen($value) > 32) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "مؤشر CLI طويل جدًا (>32)."
                    );
                }
                break;
            case 'docref_root':
            case 'docref_ext':
                if ($value !== NULL && $value !== "") {
                    list($result, $reason) = array(
                        TEST_Low,
                        "docref مضبوط."
                    );
                    $recommendation = $helptext['docref_*'];
                }
                break;
            case 'default_charset':
                if ($value == "") {
                    list($result, $reason) = array(
                        TEST_High,
                        "الترميز الافتراضي غير مضبوط صراحةً."
                    );
                    $recommendation = $helptext['default_charset=empty'];
                } elseif (stripos($value, "iso-8859") === 0) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "ترميز بدون دعم متعدد البايت."
                    );
                    $recommendation = $helptext['default_charset=iso-8859'];
                } elseif (strtoLower($value) == "utf8") {
                    list($result, $reason) = array(
                        TEST_High,
                        "'UTF-8' مكتوب بشكل خاطئ (بدون واصلة)."
                    );
                    $recommendation = $helptext['default_charset=typo'];
                } elseif (strtoLower($value) == "utf-8") {
                    // Okay.
                } else {
                    list($result, $reason) = array(
                        TEST_Advice,
                        "ترميز مخصص."
                    );
                    $recommendation = $helptext['default_charset=custom'];
                }
                break;
            case 'default_mimetype':
                if ($value == "") {
                    list($result, $reason) = array(
                        TEST_High,
                        "نوع MIME الافتراضي غير مضبوط."
                    );
                }
                break;
            case 'default_socket_timeout':
                if (intval($value) > 60) {
                    list($result, $reason) = array(
                        TEST_Low,
                        "مهلة المقبس الافتراضية كبيرة نسبيًا."
                    );
                }
                break;
            case 'doc_root':
                if (!$cfg['is_cgi']) {
                    list($result, $reason) = array(
                        TEST_Skipped,
                        "لا توجد بيئة CGI."
                    );
                    break;
                }
                if (ini_get('cgi.force_redirect')) {
                    list($result, $reason) = array(
                        TEST_Skipped,
                        "cgi.force_redirect مفعل بدلاً من ذلك."
                    );
                    break;
                }
                if ($value == "") {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "doc_root غير مضبوط."
                    );
                    $recommendation = $helptext['doc_root=empty'];
                }
                break;
            case 'error_prepend_string':
            case 'error_append_string':
                if ($value !== NULL && $value !== "") {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "$k مضبوط."
                    );
                    $recommendation = $helptext['error_append_string'];
                }
                break;
            case 'error_reporting':
                if (error_reporting() == 0) {
                    list($result, $reason) = array(
                        TEST_Low,
                        "تقرير الأخطاء معطل."
                    );
                }
                break;
            case 'exit_on_timeout':
                if (!isset($_SERVER["SERVER_SOFTWARE"]) || strncmp($_SERVER["SERVER_SOFTWARE"], "Apache/1", strlen("Apache/1")) !== 0) {
                    list($result, $reason) = array(
                        TEST_Skipped,
                        "ذو صلة فقط بـ Apache 1."
                    );
                } elseif (!is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Low,
                        "غير مفعل."
                    );
                }
                break;
            case 'filter.default':
                if ($value !== "unsafe_raw") {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "تم ضبط مرشح إدخال عام."
                    );
                }
                break;
            case 'highlight.bg':
            case 'highlight.comment':
            case 'highlight.default':
            case 'highlight.html':
            case 'highlight.keyword':
            case 'highlight.string':
                if (extension_loaded('pcre') && preg_match('/[^#a-z0-9]/i', $value) || strlen($value) > 7 || strpos($value, '"') !== FALSE) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "قيمة لون مشبوهة."
                    );
                    $recommendation = $helptext['highlight.*'];
                }
                break;
            case 'iconv.internal_encoding':
            case 'iconv.input_encoding':
            case 'iconv.output_encoding':
                if (PHP_MAJOR_VERSION > 5 || (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION >= 6)) {
                    if ($value !== "") {
                        list($result, $reason) = array(
                            TEST_Advice,
                            "غير فارغ."
                        );
                        $recommendation = $helptext['iconv.internal_encoding!=empty'];
                    }
                } else {
                    list($result, $reason) = array(
                        TEST_Skipped,
                        "إصدار PHP أقدم من 5.6"
                    );
                }
                break;
            case 'asp_tags':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "علامات نمط ASP مفعلة."
                    );
                }
                break;
            case 'ldap.max_links':
                if (intval($value) == -1) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "عدد اتصالات LDAP غير محدود."
                    );
                } else if (intval($value) > 5) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "يُسمح بأكثر من 5 اتصالات LDAP."
                    );
                }
                break;
            case 'log_errors_max_len':
                $value = ini_atol($value);
                if ($value == 0 || $value > 4096) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "القيمة كبيرة جدًا أو غير محدودة."
                    );
                }
                break;
            case 'mail.add_x_header':
                if ($value) {
                    list($result, $reason) = array(
                        TEST_Medium,
                        "اسم الملف مكشوف."
                    );
                }
                break;
            case 'mail.force_extra_parameters':
                if ($value) {
                    list($result, $reason) = array(
                        TEST_Advice,
                        "غير فارغ."
                    );
                    $recommendation = "معلومة فقط.";
                }
                break;
            case 'intl.use_exceptions':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Maybe,
                        "دوال intl تُطلق استثناءات."
                    );
                }
                break;
            case 'last_modified':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_Low,
                        "مضبوط."
                    );
                }
                break;
            case 'zend.multibyte':
                if (is_on($value)) {
                    list($result, $reason) = array(
                        TEST_High,
                        "الترميزات متعددة البايت مفعلة."
                    );
                }
                break;
			case 'runkit.internal_override':
				if (is_on($value)) {
					list($result, $reason) = array(
						TEST_Critical, 
						"تجاوز الدوال الداخلية مفعل."
					);
				}
				break;
			case 'phar.readonly':
				if (!is_on($value)) {
					list($result, $reason) = array(
						TEST_Low, 
						"ملفات Phar ليست للقراءة فقط."
					);
				}
				break;
			case 'phar.require_hash':
				if (!is_on($value)) {
					list($result, $reason) = array(
						TEST_Low, 
						"التحقق من التوقيع لـ phar معطل."
					);
				}
				break;
			case 'ffi.enable':
				if (is_on($value)){
					list($result, $reason) = array(
						TEST_High, 
						"FFI مفعل."
					);
				}

			}
        
			if ($ignore) {
				continue;
			}
			
			if ($result === TEST_Skipped) {
				tres($meta, $result, $reason, $recommendation);
			} else {
				tres($meta, $result, $reason, $recommendation);
			}
	}
}
test_all_ini_entries();

// --- Other checks ---


// Old php version?
function test_old_php_version()
{
	$meta = tdesc("إصدار PHP", "يفحص ما إذا كان إصدار PHP الخاص بك غير مدعوم");
	if (version_compare(PHP_VERSION, '8.1') >= 0) {
		tres($meta, TEST_Okay, "إصدار PHP = " . PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION);
	} elseif (version_compare(PHP_VERSION, '8.0') >= 0) {
		tres($meta, TEST_High, "إصدار PHP أقدم من 8.1",
			"إصدارات PHP الأقدم من 8.1 وصلت إلى نهاية الدعم. قد يظل بعض الموزعين يحافظون على تحديثات أمنية. يُرجى التأكد من أن إصدارك يتلقى التصحيحات الأمنية أو قم بترقية PHP في أقرب وقت ممكن.");
	} else {
		tres($meta, TEST_Critical, "إصدار PHP أقدم من 8.0",
			"يُرجى ترقية PHP في أقرب وقت ممكن. الإصدارات القديمة غير مدعومة وقد تحتوي على ثغرات أمنية.");
	}
}
test_old_php_version();

// snuffleupagus installed?
function test_snuffleupagus_installed()
{
	$meta = tdesc("Snuffleupagus", "يفحص ما إذا كان امتداد Snuffleupagus محملًا");
	if (extension_loaded("snuffleupagus")) {
		tres($meta, TEST_Okay);
	} else if (PHP_MAJOR_VERSION < 7) {
		tres($meta, TEST_Skipped, "Snuffleupagus غير متوفر لـ PHP < 7");
	} else if (defined('HHVM_VERSION')) {
		tres($meta, TEST_Skipped, "Snuffleupagus غير متوفر لـ HHVM.");
	} else {
		tres($meta, TEST_Maybe, "امتداد Snuffleupagus غير محمل", "Snuffleupagus نظام حماية متقدم لـ PHP7+. يهدف إلى حماية الخوادم والمستخدمين من الثغرات المعروفة وغير المعروفة في تطبيقات PHP ونواة PHP. لمزيد من المعلومات، راجع https://snuffleupagus.rtfd.io");
	}
}
test_snuffleupagus_installed();

// Is debug build?
function test_debug_build()
{
    $meta = tdesc("تصحيح البناء", "يفحص ما إذا تم بناء PHP باستخدام --enable-debug");
    if (constant('PHP_DEBUG') || constant('ZEND_DEBUG_BUILD')) {
        tres($meta, TEST_Medium, "بناء تصحيح.", "استخدام بناء تصحيح لـ PHP يتيح تفعيل ميزات التصحيح، مما قد يكون مفيدًا للمهاجمين، مثل الحصول على رسائل أخطاء دقيقة أو تسهيل هجمات الحرمان من الخدمة. كما أن التصحيح قد يؤثر على الأداء. يُرجى إعادة تجميع PHP بدون التصحيح.");
    } else {
        tres($meta, TEST_Okay, "ليس بناء تصحيح.");
    }
}
test_debug_build();

// Got root?
function test_godmode()
{
    global $cfg;
    $meta = tdesc("اختبار الوصول الجذري على أنظمة غير Windows");
    if ($cfg['is_win']) {
        tres($meta, TEST_Skipped, "نظام التشغيل هو Windows."); // Maybe check for admin access. but how?
        return;
    }
    if (!extension_loaded("posix")) {
        tres($meta, TEST_Skipped, "امتداد Posix غير متوفر");
        return;
    }
    if (posix_getuid() == 0) {
        tres($meta, TEST_Critical, "لديك وصول جذري!", "تشغيل PHP كجذر نادرًا ما يكون ضروريًا.");
    } else {
        tres($meta, TEST_Okay, "ليس جذري");
    }
}
test_godmode();

// Test for xdebug extension
function test_xdebug()
{
    $meta = tdesc("xdebug", "اختبار امتداد xdebug المحمل");
    if (extension_loaded('xdebug')) {
        tres($meta, TEST_High, "امتداد xDebug محمل.", "امتداد xdebug يمكن أن يكشف الشيفرة والبيانات للمهاجم وقد يؤثر على أداء التطبيق. يُرجى تعطيل هذا الامتداد في بيئة الإنتاج.");
    } else {
        tres($meta, TEST_Okay, "غير محمل.");
    }
}
test_xdebug();

// test for vld extension
function test_vld()
{
	$meta = tdesc("vld", "اختبار امتداد vld المحمل");
	if (extension_loaded('vld')) {
		if (is_on(ini_get('vld.active'))) {
			tres($meta, TEST_Critical, "امتداد vld محمل ومفعل.", "امتداد vld يمكن أن يكشف الشيفرة والبيانات للمهاجم وقد يؤثر على أداء التطبيق. يُرجى إلغاء تحميل هذا الامتداد في بيئة الإنتاج.");
		}
		tres($meta, TEST_High, "امتداد vld محمل.", "امتداد vld يمكن أن يكشف الشيفرة والبيانات للمهاجم وقد يؤثر على أداء التطبيق. يُرجى إلغاء تحميل هذا الامتداد في بيئة الإنتاج.");
	} else {
		tres($meta, TEST_Okay, "غير محمل.");
	}
}
test_vld();

// Output
function e($str)
{
    return htmlentities($str ?? '', ENT_QUOTES);
}
?>

	<table id="dt-basicphpconf" class="shield-table" width="100%">
	<thead class="<?php echo $thead; ?>">
	<tr>
		<th>المخاطر</th>
		<th>الاسم / الوصف</th>
		<th>السبب</th>
		<th>التوصية</th>
	</tr>
	</thead>
	<tbody>
	<?php
foreach ($all_result_codes as $sev) {
    foreach ($trbs[$sev] as $res):
?>
		<tr>
			<td class="text-center">
			<h5><span class="<?php echo $isShield ? 'shield-badge' : 'badge'; ?>
<?php
        if ($res['result'] == TEST_Critical) {
            echo $isShield ? ' shield-badge--critical' : ' badge-dark';
        }
        if ($res['result'] == TEST_High) {
            echo $isShield ? ' shield-badge--critical' : ' badge-danger';
        }
        if ($res['result'] == TEST_Medium) {
            echo $isShield ? ' shield-badge--warning' : ' badge-warning';
        }
        if ($res['result'] == TEST_Low) {
            echo $isShield ? ' shield-badge--primary' : ' badge-primary';
        }
        if ($res['result'] == TEST_Maybe) {
            echo $isShield ? ' shield-badge--info' : ' badge-info';
        }
        if ($res['result'] == TEST_Advice) {
            echo $isShield ? ' shield-badge--secondary' : ' badge-light';
        }
        if ($res['result'] == TEST_Okay) {
            echo $isShield ? ' shield-badge--success' : ' badge-success';
        }
        if ($res['result'] == TEST_Skipped) {
            echo $isShield ? ' shield-badge--secondary' : ' badge-secondary';
        }
?>
">
			<?php
        echo $res['result'];
?></span></h5></td>
			<td><?php
        echo e($res['name']);
?><?php
        if ($res['desc'] !== NULL) {
            echo "<br/>" . e($res['desc']);
        }
?></td>
			<td><?php
        echo e($res['reason']);
?></td>
			<td><?php
        echo e($res['recommendation']);
?></td>
		</tr>
		<?php
    endforeach;
}
?>
	</tbody>
	</table>
	
	<br />
	<h4 class="shield-card">إحصائيات النتائج</h4>
	
<div class="shield-table">
	<table class="shield-table">
	<thead class="<?php echo $thead; ?>">
	<tr>
	<?php
foreach ($all_result_codes as $sev) {
?>
		<td class="<?php
    echo $sev;
?>"><?php
    echo $sev;
?>:
<h5><span class="<?php echo $isShield ? 'shield-badge' : 'badge'; ?>  
<?php
    if ($sev == TEST_Critical) {
        echo $isShield ? ' shield-badge--critical' : ' badge-dark';
    }
    if ($sev == TEST_High) {
        echo $isShield ? ' shield-badge--critical' : ' badge-danger';
    }
    if ($sev == TEST_Medium) {
        echo $isShield ? ' shield-badge--warning' : ' badge-warning';
    }
    if ($sev == TEST_Low) {
        echo $isShield ? ' shield-badge--primary' : ' badge-primary';
    }
    if ($sev == TEST_Maybe) {
        echo $isShield ? ' shield-badge--info' : ' badge-info';
    }
    if ($sev == TEST_Advice) {
        echo $isShield ? ' shield-badge--secondary' : ' badge-light';
    }
    if ($sev == TEST_Okay) {
        echo $isShield ? ' shield-badge--success' : ' badge-success';
    }
    if ($sev == TEST_Skipped) {
        echo $isShield ? ' shield-badge--secondary' : ' badge-secondary';
    }
?>
">
<?php
    echo count($trbs[$sev]);
?></span></h5></td>
	<?php
}
?></tr>
</thead>
</table>
</div>
                        </div>
                     </div>
                    
				</div>
                    
				</div>
				</div>
				<!--===================================================-->
				<!--نهاية محتوى الصفحة-->

			</div>
			<!--===================================================-->
			<!--نهاية حاوية المحتوى-->
</div>
<?php
footer();
?>