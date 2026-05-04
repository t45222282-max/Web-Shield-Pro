<?php
require "core.php";
head();
?>

<!-- Showcase Page -->
<div class="content-wrapper" style="padding: 20px;">
  <section class="content">
    <div class="container-fluid">
      <h1 class="txt-h1 mb-6">🎨 Design Showcase (Phase 2)</h1>

      <!-- Buttons -->
      <div class="shield-card">
        <div class="shield-card-header">
          <h3 class="shield-card-title">1. الأزرار (Buttons)</h3>
        </div>
        <div class="shield-card-body" style="display: flex; gap: 10px; flex-wrap: wrap;">
          <button class="btn-shield-primary">Primary Button</button>
          <button class="btn-shield-secondary">Secondary Button</button>
          <button class="btn-shield-outline">Outline Button</button>
          <button class="btn-shield-ghost">Ghost Button</button>
          <button class="btn-shield-danger">Danger Button</button>
          <button class="btn-shield-primary loading">Loading</button>
          <button class="btn-shield-primary" disabled>Disabled</button>
        </div>
      </div>

      <!-- KPI Cards -->
      <h3 class="txt-h2 mt-4 mb-4">2. كروت المؤشرات (KPI Cards)</h3>
      <div class="row">
        <div class="col-md-3">
          <div class="kpi-card kpi-card--success">
            <div class="kpi-card__head">
              <i data-lucide="shield-check" class="icon icon-sm icon-success"></i>
              <span class="txt-overline">طلبات آمنة</span>
              <span class="kpi-card__live"></span>
            </div>
            <div class="kpi-card__value num">142,853</div>
            <div class="kpi-card__delta kpi-card__delta--up">
              <i data-lucide="trending-up" class="icon icon-xs"></i>
              +14% اليوم
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="kpi-card kpi-card--critical">
            <div class="kpi-card__head">
              <i data-lucide="shield-alert" class="icon icon-sm icon-critical"></i>
              <span class="txt-overline">تهديدات محظورة</span>
            </div>
            <div class="kpi-card__value num">1,024</div>
            <div class="kpi-card__delta kpi-card__delta--down">
              <i data-lucide="trending-down" class="icon icon-xs"></i>
              -5% اليوم
            </div>
          </div>
        </div>
      </div>

      <!-- Badges & Inputs -->
      <div class="row">
        <div class="col-md-6">
          <div class="shield-card">
            <div class="shield-card-header">
              <h3 class="shield-card-title">3. مؤشرات الخطورة (Severity Pills)</h3>
            </div>
            <div class="shield-card-body" style="display: flex; gap: 10px; flex-wrap: wrap;">
              <span class="severity-pill severity-pill--critical">حرج (Critical)</span>
              <span class="severity-pill severity-pill--high">عالي (High)</span>
              <span class="severity-pill severity-pill--medium">متوسط (Medium)</span>
              <span class="severity-pill severity-pill--low">منخفض (Low)</span>
              <span class="severity-pill severity-pill--info">معلومات (Info)</span>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="shield-card">
            <div class="shield-card-header">
              <h3 class="shield-card-title">4. الحقول (Forms)</h3>
            </div>
            <div class="shield-card-body">
              <div class="shield-field">
                <label class="shield-field__label">عنوان IP</label>
                <input type="text" class="shield-input" placeholder="192.168.1.1">
              </div>
              <div class="shield-field">
                <label class="shield-field__label">نطاق مخصص</label>
                <select class="shield-input">
                  <option>الكل</option>
                  <option>محظور</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tables -->
      <div class="shield-table-wrapper">
        <div class="shield-table-toolbar">
          <h3 class="shield-card-title" style="margin-bottom:0">5. الجداول (Tables)</h3>
        </div>
        <table class="shield-table">
          <thead>
            <tr>
              <th class="col-num">#</th>
              <th class="col-ip">IP Address</th>
              <th>الدولة</th>
              <th>مستوى الخطورة</th>
              <th class="col-time">الوقت</th>
              <th class="col-actions"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="col-num">1</td>
              <td class="col-ip">192.168.1.105</td>
              <td>🇺🇸 US</td>
              <td><span class="severity-pill severity-pill--critical">حرج</span></td>
              <td class="col-time">14:32</td>
              <td class="col-actions"><i data-lucide="more-horizontal" class="icon icon-md"></i></td>
            </tr>
            <tr class="is-selected">
              <td class="col-num">2</td>
              <td class="col-ip">10.0.0.42</td>
              <td>🇩🇪 DE</td>
              <td><span class="severity-pill severity-pill--medium">متوسط</span></td>
              <td class="col-time">14:28</td>
              <td class="col-actions"><i data-lucide="more-horizontal" class="icon icon-md"></i></td>
            </tr>
            <tr>
              <td class="col-num">3</td>
              <td class="col-ip">172.16.2.8</td>
              <td>🇬🇧 UK</td>
              <td><span class="severity-pill severity-pill--low">منخفض</span></td>
              <td class="col-time">14:20</td>
              <td class="col-actions"><i data-lucide="more-horizontal" class="icon icon-md"></i></td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </section>
</div>

<?php
footer();
?>
