<?php
require "core.php";
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_bans-country` WHERE id='$id'");
}

if (isset($_GET['blacklist'])) {
    $settings['countryban_blacklist'] = 1;
	
	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}

if (isset($_GET['whitelist'])) {
    $settings['countryban_blacklist'] = 0;
	
	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}
?>
<div class="content-wrapper">

<!-- حاوية المحتوى -->
<!--===================================================-->
<div class="content-header">
	
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 "><i class="fas fa-globe"></i> حظر البلدان</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
					<li class="breadcrumb-item active">حظر البلدان</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<!-- محتوى الصفحة -->
<!--===================================================-->
<div class="content">
	<div class="container-fluid">
	
<?php
if (isset($_POST['add-country'])) {

$country  = $_POST['country'];  // البلد المُحدد
$redirect = $_POST['redirect'];  // هل سيتم إعادة التوجيه؟
$url      = strip_tags(addslashes($_POST['url']));  // عنوان URL إذا كان هناك إعادة توجيه

if ($redirect == 1 and $url == NULL) {
	echo '<br />
	<div class="callout callout-danger">
			<p><i class="fas fa-exclamation-triangle"></i> من فضلك أدخل رابط ستتم إعادة توجيه الزوار من البلد المحظور إليه.</p>
	</div>';
} else {
	$queryvalid = $mysqli->query("SELECT * FROM `psec_bans-country` WHERE country='$country' LIMIT 1");
	$validator  = mysqli_num_rows($queryvalid);
	if ($validator > "0") {
		echo '<br />
	<div class="callout callout-info">
			<p><i class="fas fa-info-circle"></i> هذا <strong>البلد</strong> تم إضافته بالفعل.</p>
	</div>';
	} else {
		$query = $mysqli->query("INSERT INTO `psec_bans-country` (country, redirect, url) VALUES('$country', '$redirect', '$url')");
	}
}
}
?>

		<div class="row">
			
		<div class="col-md-9">
<?php
if (isset($_GET['edit-id'])) {
$id = (int) $_GET["edit-id"];

$result = $mysqli->query("SELECT * FROM `psec_bans-country` WHERE id = '$id'");
$row    = mysqli_fetch_assoc($result);

if (empty($id) || mysqli_num_rows($result) == 0) {
	echo '<meta http-equiv="refresh" content="0; url=bans-country.php">';
	exit();
}

if (isset($_POST['edit-ban'])) {
	$country  = $_POST['country'];
	$redirect = $_POST['redirect'];
	$url      = strip_tags(addslashes($_POST['url']));
	
	if ($redirect == 1 and $url == NULL) {
		echo '<br />
		<div class="alert alert-danger">
				<p><i class="fas fa-exclamation-triangle"></i> من فضلك أدخل رابط ستتم إعادة توجيه الزوار من البلد المحظور إليه.</p>
		</div>';
	} else {
		$update = $mysqli->query("UPDATE `psec_bans-country` SET country='$country', redirect='$redirect', url='$url' WHERE id='$id'");
	}
}
?>
<form class="form-horizontal" action="" method="post">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">تعديل - حظر البلد</h3>
					</div>
					<div class="card-body">
						  <div class="form-group">
								<label class="control-label">البلد: </label>
<select class="form-control select2" class="width100" name="country" required> 
<option value="<?php
echo $row['country'];
?>" selected><?php
echo $row['country'];
?></option>
<option value="Afganistan">أفغانستان</option>
<option value="Albania">ألبانيا</option>
<option value="Algeria">الجزائر</option>
<!-- المزيد من الخيارات هنا -->
</select>
									</div>
									<div class="form-group">
										<label class="control-label">إعادة التوجيه إلى صفحة / موقع: </label>
<select name="redirect" class="form-control" required>
	<option value="0" <?php
if ($row['redirect'] == 0) {
	echo 'selected';
}
?>>لا</option>
	<option value="1" <?php
if ($row['redirect'] == 1) {
	echo 'selected';
}
?>>نعم</option>
</select>
									</div>
									<div class="form-group">
										<label class="control-label">رابط إعادة التوجيه: </label>
										<input name="url" class="form-control" type="url" value="<?php
echo $row['url'];
?>">
									</div>
					</div>
					<div class="card-footer row">
						<div class="col-md-12">
							<button class="btn btn-flat btn-success btn-block" name="edit-ban" type="submit">حفظ</button>
						</div>
					</div>
				 </div>
</form>
<?php
}
?>

				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">حظر البلدان</h3>
					</div>
					<div class="card-body">
						
					<div class="callout callout-info" role="alert">
						يمكن اختيار وضع حظر بلد واحد فقط. جدول البلدان مشترك بين وضعي الحظر.
						خيار إعادة التوجيه غير مستخدم عند اختيار وضع حظر البلدان المسموح بها.
					</div>
					وضع الحظر: 
					<a href="?blacklist" class="btn btn-md btn-rounded <?php
if ($settings['countryban_blacklist'] == 1) {
echo 'btn-danger';
} else {
echo 'btn-default';
}
?>">قائمة الحظر</a>
					<a href="?whitelist" class="btn btn-md btn-rounded <?php
if ($settings['countryban_blacklist'] == 0) {
echo 'btn-success';
} else {
echo 'btn-default';
}
?>">قائمة السماح</a> 
					<hr />
						
<table id="dt-basic2" class="table table-bordered table-hover table-sm" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-globe"></i> البلد</th>
										<th><i class="fas fa-share"></i> إعادة التوجيه</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$querybc = $mysqli->query("SELECT * FROM `psec_bans-country`");
while ($rowbc = $querybc->fetch_assoc()) {
echo '
									<tr>
										<td>' . $rowbc['country'] . '</td>
										<td>';
if ($rowbc['redirect'] == 1) {
	echo 'نعم';
} else {
	echo 'لا';
}
echo '</td>
										<td>
										<a href="?edit-id=' . $rowbc['id'] . '" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-edit"></i> تعديل</a>
										<a href="?delete-id=' . $rowbc['id'] . '" class="btn btn-flat btn-success btn-sm"><i class="fas fa-trash"></i> حذف</a>
										</td>
									</tr>
';
}
?>

									</tbody>
</table>
</div>
</div>
</div>

<div class="col-md-3">
   <div class="card card-primary card-outline">
      <div class="card-header">
         <h3 class="card-title">إضافة دولة</h3>
      </div>
      <div class="card-body">
         <form class="form-horizontal" action="" method="post">
            <div class="form-group">
               <label class="control-label">الدولة: </label>
               <select class="form-control select2" class="width100" name="country" required>
                  <option value="Afganistan">أفغانستان</option>
                  <option value="Albania">ألبانيا</option>
                  <option value="Algeria">الجزائر</option>
                  <option value="American Samoa">ساموا الأمريكية</option>
                  <option value="Andorra">أندورا</option>
                  <option value="Angola">أنغولا</option>
                  <option value="Anguilla">أنغويلا</option>
                  <option value="Antigua &amp; Barbuda">أنتيغوا وبربودا</option>
                  <option value="Argentina">الأرجنتين</option>
                  <option value="Armenia">أرمينيا</option>
                  <option value="Aruba">أروبا</option>
                  <option value="Australia">أستراليا</option>
                  <option value="Austria">النمسا</option>
                  <option value="Azerbaijan">أذربيجان</option>
                  <option value="Bahamas">باهاماس</option>
                  <option value="Bahrain">البحرين</option>
                  <option value="Bangladesh">بنغلاديش</option>
                  <option value="Barbados">بربادوس</option>
                  <option value="Belarus">بيلاروسيا</option>
                  <option value="Belgium">بلجيكا</option>
                  <option value="Belize">بليز</option>
                  <option value="Benin">بنين</option>
                  <option value="Bermuda">برمودا</option>
                  <option value="Bhutan">بوتان</option>
                  <option value="Bolivia">بوليفيا</option>
                  <option value="Bonaire">بونير</option>
                  <option value="Bosnia &amp; Herzegovina">البوسنة والهرسك</option>
                  <option value="Botswana">بوتسوانا</option>
                  <option value="Brazil">البرازيل</option>
                  <option value="British Indian Ocean Ter">أراضي المحيط الهندي البريطانية</option>
                  <option value="Brunei">بروناي</option>
                  <option value="Bulgaria">بلغاريا</option>
                  <option value="Burkina Faso">بوركينا فاسو</option>
                  <option value="Burundi">بوروندي</option>
                  <option value="Cambodia">كمبوديا</option>
                  <option value="Cameroon">الكاميرون</option>
                  <option value="Canada">كندا</option>
                  <option value="Canary Islands">جزر الكناري</option>
                  <option value="Cape Verde">الرأس الأخضر</option>
                  <option value="Cayman Islands">جزر كايمان</option>
                  <option value="Central African Republic">جمهورية أفريقيا الوسطى</option>
                  <option value="Chad">تشاد</option>
                  <option value="Channel Islands">جزر القنال</option>
                  <option value="Chile">تشيلي</option>
                  <option value="China">الصين</option>
                  <option value="Christmas Island">جزيرة عيد الميلاد</option>
                  <option value="Cocos Island">جزيرة كوكوس</option>
                  <option value="Colombia">كولومبيا</option>
                  <option value="Comoros">جزر القمر</option>
                  <option value="Congo">الكونغو</option>
                  <option value="Cook Islands">جزر كوك</option>
                  <option value="Costa Rica">كوستاريكا</option>
                  <option value="Cote DIvoire">كوت ديفوار</option>
                  <option value="Croatia">كرواتيا</option>
                  <option value="Cuba">كوبا</option>
                  <option value="Curaco">كوراساو</option>
                  <option value="Cyprus">قبرص</option>
                  <option value="Czech Republic">جمهورية التشيك</option>
                  <option value="Czechia">التشيك</option>
                  <option value="Denmark">الدنمارك</option>
                  <option value="Djibouti">جيبوتي</option>
                  <option value="Dominica">دومينيكا</option>
                  <option value="Dominican Republic">جمهورية الدومينيكان</option>
                  <option value="East Timor">تيمور الشرقية</option>
                  <option value="Ecuador">الإكوادور</option>
                  <option value="Egypt">مصر</option>
                  <option value="El Salvador">السلفادور</option>
                  <option value="Equatorial Guinea">غينيا الاستوائية</option>
                  <option value="Eritrea">إريتريا</option>
                  <option value="Estonia">إستونيا</option>
                  <option value="Ethiopia">إثيوبيا</option>
                  <option value="Falkland Islands">جزر فوكلاند</option>
                  <option value="Faroe Islands">جزر فارو</option>
                  <option value="Fiji">فيجي</option>
                  <option value="Finland">فنلندا</option>
                  <option value="France">فرنسا</option>
                  <option value="French Guiana">غويانا الفرنسية</option>
                  <option value="French Polynesia">بولينيزيا الفرنسية</option>
                  <option value="French Southern Ter">المناطق الفرنسية الجنوبية</option>
                  <option value="Gabon">الغابون</option>
                  <option value="Gambia">غامبيا</option>
                  <option value="Georgia">جورجيا</option>
                  <option value="Germany">ألمانيا</option>
                  <option value="Ghana">غانا</option>
                  <option value="Gibraltar">جبل طارق</option>
                  <option value="Great Britain">بريطانيا الكبرى</option>
                  <option value="Greece">اليونان</option>
                  <option value="Greenland">غرينلاند</option>
                  <option value="Grenada">غرينادا</option>
                  <option value="Guadeloupe">غوادلوب</option>
                  <option value="Guam">غوام</option>
                  <option value="Guatemala">غواتيمالا</option>
                  <option value="Guinea">غينيا</option>
                  <option value="Guyana">غيانا</option>
                  <option value="Haiti">هايتي</option>
                  <option value="Hawaii">هاواي</option>
                  <option value="Honduras">هندوراس</option>
                  <option value="Hong Kong">هونغ كونغ</option>
                  <option value="Hungary">هنغاريا</option>
                  <option value="Iceland">آيسلندا</option>
                  <option value="India">الهند</option>
                  <option value="Indonesia">إندونيسيا</option>
                  <option value="Iran">إيران</option>
                  <option value="Iraq">العراق</option>
                  <option value="Ireland">إيرلندا</option>
                  <option value="Isle of Man">جزيرة مان</option>
                  <option value="Israel">إسرائيل</option>
                  <option value="Italy">إيطاليا</option>
                  <option value="Jamaica">جامايكا</option>
                  <option value="Japan">اليابان</option>
                  <option value="Jordan">الأردن</option>
                  <option value="Kazakhstan">كازاخستان</option>
                  <option value="Kenya">كينيا</option>
                  <option value="Kiribati">كيريباتي</option>
                  <option value="Korea North">كوريا الشمالية</option>
                  <option value="Korea South">كوريا الجنوبية</option>
                  <option value="Kuwait">الكويت</option>
                  <option value="Kyrgyzstan">قيرغيزستان</option>
                  <option value="Laos">لاوس</option>
                  <option value="Latvia">لاتفيا</option>
                  <option value="Lebanon">لبنان</option>
                  <option value="Lesotho">ليسوتو</option>
                  <option value="Liberia">ليبيريا</option>
                  <option value="Libya">ليبيا</option>
                  <option value="Liechtenstein">ليختنشتاين</option>
                  <option value="Lithuania">ليتوانيا</option>
                  <option value="Luxembourg">لوكسمبورغ</option>
                  <option value="Macau">ماكاو</option>
                  <option value="Macedonia">مقدونيا</option>
                  <option value="Madagascar">مدغشقر</option>
                  <option value="Malaysia">ماليزيا</option>
                  <option value="Malawi">مالاوي</option>
                  <option value="Maldives">المالديف</option>
                  <option value="Mali">مالي</option>
                  <option value="Malta">مالطا</option>
                  <option value="Marshall Islands">جزر مارشال</option>
                  <option value="Martinique">مارتينيك</option>
                  <option value="Mauritania">موريتانيا</option>
                  <option value="Mauritius">موريشيوس</option>
                  <option value="Mayotte">مايوت</option>
                  <option value="Mexico">المكسيك</option>
                  <option value="Midway Islands">جزر ميدواي</option>
                  <option value="Moldova">مولدوفا</option>
                  <option value="Monaco">موناكو</option>
                  <option value="Mongolia">منغوليا</option>
                  <option value="Montserrat">مونتسرات</option>
                  <option value="Morocco">المغرب</option>
                  <option value="Mozambique">موزمبيق</option>
                  <option value="Myanmar">ميانمار</option>
                  <option value="Nambia">ناميبيا</option>
                  <option value="Nauru">ناورو</option>
                  <option value="Nepal">نيبال</option>
                  <option value="Netherland Antilles">جزر الهند الغربية الهولندية</option>
                  <option value="Netherlands">هولندا (أوروبا)</option>
                  <option value="Nevis">نيويس</option>
                  <option value="New Caledonia">كاليدونيا الجديدة</option>
                  <option value="New Zealand">نيوزيلندا</option>
                  <option value="Nicaragua">نيكاراغوا</option>
                  <option value="Niger">النيجر</option>
                  <option value="Nigeria">نيجيريا</option>
                  <option value="Niue">نيوي</option>
                  <option value="Norfolk Island">جزيرة نورفولك</option>
                  <option value="Norway">النرويج</option>
                  <option value="Oman">عمان</option>
                  <option value="Pakistan">باكستان</option>
                  <option value="Palau Island">جزيرة بالاو</option>
                  <option value="Palestine">فلسطين</option>
                  <option value="Panama">بنما</option>
                  <option value="Papua New Guinea">بابوا غينيا الجديدة</option>
                  <option value="Paraguay">باراغواي</option>
                  <option value="Peru">بيرو</option>
                  <option value="Philippines">الفلبين</option>
                  <option value="Pitcairn Island">جزيرة بيتكيرن</option>
                  <option value="Poland">بولندا</option>
                  <option value="Portugal">البرتغال</option>
                  <option value="Puerto Rico">بورتو ريكو</option>
                  <option value="Qatar">قطر</option>
                  <option value="Republic of Montenegro">جمهورية الجبل الأسود</option>
                  <option value="Republic of Serbia">جمهورية صربيا</option>
                  <option value="Reunion">ريونيون</option>
                  <option value="Romania">رومانيا</option>
                  <option value="Russia">روسيا</option>
                  <option value="Rwanda">رواندا</option>
                  <option value="St Barthelemy">سان بارتليمي</option>
                  <option value="St Eustatius">سانت أوستاتيوس</option>
                  <option value="St Helena">سانت هيلينا</option>
                  <option value="St Kitts-Nevis">سانت كيتس ونيفيس</option>
                  <option value="St Lucia">سانت لوسيا</option>
                  <option value="St Maarten">سانت مارتن</option>
                  <option value="St Pierre &amp; Miquelon">سانت بيير وميكلون</option>
                  <option value="St Vincent &amp; Grenadines">سانت فينسنت وغرينادين</option>
                  <option value="Saipan">سايبان</option>
                  <option value="Samoa">ساموا</option>
                  <option value="Samoa American">ساموا الأمريكية</option>
                  <option value="San Marino">سان مارينو</option>
                  <option value="Sao Tome &amp; Principe">ساو تومي وبرينسيب</option>
                  <option value="Saudi Arabia">المملكة العربية السعودية</option>
                  <option value="Senegal">السنغال</option>
                  <option value="Serbia">صربيا</option>
                  <option value="Seychelles">سيشيل</option>
                  <option value="Sierra Leone">سيراليون</option>
                  <option value="Singapore">سنغافورة</option>
                  <option value="Slovakia">سلوفاكيا</option>
                  <option value="Slovenia">سلوفينيا</option>
                  <option value="Solomon Islands">جزر سليمان</option>
                  <option value="Somalia">الصومال</option>
                  <option value="South Africa">جنوب أفريقيا</option>
                  <option value="Spain">إسبانيا</option>
                  <option value="Sri Lanka">سريلانكا</option>
                  <option value="Sudan">السودان</option>
                  <option value="Suriname">سورينام</option>
                  <option value="Swaziland">سوازيلاند</option>
                  <option value="Sweden">السويد</option>
                  <option value="Switzerland">سويسرا</option>
                  <option value="Syria">سوريا</option>
                  <option value="Tahiti">تاهيتي</option>
                  <option value="Taiwan">تايوان</option>
                  <option value="Tajikistan">طاجيكستان</option>
                  <option value="Tanzania">تنزانيا</option>
                  <option value="Thailand">تايلاند</option>
                  <option value="Togo">توغو</option>
                  <option value="Tokelau">توكيلاو</option>
                  <option value="Tonga">تونغا</option>
                  <option value="Trinidad &amp; Tobago">ترينيداد وتوباغو</option>
                  <option value="Tunisia">تونس</option>
                  <option value="Turkey">تركيا</option>
                  <option value="Turkmenistan">تركمانستان</option>
                  <option value="Turks &amp; Caicos Is">جزر تركس وكايكوس</option>
                  <option value="Tuvalu">توفالو</option>
                  <option value="Uganda">أوغندا</option>
                  <option value="Ukraine">أوكرانيا</option>
                  <option value="United Arab Erimates">الإمارات العربية المتحدة</option>
                  <option value="United Kingdom">المملكة المتحدة</option>
                  <option value="United States">الولايات المتحدة</option>
                  <option value="United States of America">الولايات المتحدة الأمريكية</option>
                  <option value="Uraguay">أوروغواي</option>
                  <option value="Uzbekistan">أوزبكستان</option>
                  <option value="Vanuatu">فانواتو</option>
                  <option value="Vatican City State">دولة الفاتيكان</option>
                  <option value="Venezuela">فنزويلا</option>
                  <option value="Vietnam">فيتنام</option>
                  <option value="Virgin Islands (Brit)">جزر فيرجن البريطانية</option>
                  <option value="Virgin Islands (USA)">جزر فيرجن الأمريكية</option>
                  <option value="Wallis &amp; Futuna">واليس وفوتونا</option>
                  <option value="Western Sahara">الصحراء الغربية</option>
                  <option value="Yemen">اليمن</option>
                  <option value="Zambia">زامبيا</option>
                  <option value="Zimbabwe">زيمبابوي</option>
               </select>
									</div>
<div class="form-group">
   <label class="control-label">التوجيه إلى صفحة / موقع: </label>
   <select name="redirect" class="form-control" required>
      <option value="0" selected>لا</option>
      <option value="1">نعم</option>
   </select>
</div>
<div class="form-group">
   <label class="control-label">رابط التوجيه: </label>
   <input name="url" class="form-control" type="url">
</div>
</div>
<div class="card-footer">
   <button class="btn btn-flat btn-danger btn-block" name="add-country" type="submit">إضافة</button>
</div>
</div>
</form>
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