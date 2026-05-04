---
document: 06 — Data Visualization
project: Web Shield
version: 1.0
status: Draft
audience: Developers, Designers
---

# 📊 الرسوم البيانية والإحصائيات (Data Visualization)

> الرسوم البيانية في لوحات الأمن ليست زينة — إنها أدوات قرار. هذه الوثيقة تحكم كيف نرسمها.

المشروع يستخدم **Chart.js** حالياً. سنبقى عليه، لكن نُخصصه ليتناسق مع نظامنا.

---

## 1. الفلسفة العامة للرسوم في Web Shield

| المبدأ | التطبيق |
|--------|---------|
| **الوضوح أولاً** | البيانات أهم من الجمال. لا تأثيرات 3D. |
| **التباين الذكي** | لون واحد بارز للتركيز، بقية الألوان أخف. |
| **Tabular Numerics** | أي رقم على المحاور بخط Mono. |
| **Empty State متناسق** | لا تترك المساحة فارغة بيضاء. |
| **Tooltip غني** | عند Hover، تفاصيل كاملة (وقت، نوع، عدد). |
| **خطوط Grid خفيفة** | بشفافية 5% فقط، تُرى بالكاد. |

---

## 2. Chart.js Global Defaults

نُعرّف إعدادات Chart.js مرة واحدة في ملف `assets/js/shield/charts-defaults.js`:

```javascript
// Shield Chart.js Defaults — يُحمَّل بعد chart.min.js
(function () {
  if (typeof Chart === 'undefined') return;

  // قراءة الـ Tokens من CSS Variables
  const css = getComputedStyle(document.documentElement);
  const T = {
    textPrimary:   css.getPropertyValue('--text-primary').trim(),
    textSecondary: css.getPropertyValue('--text-secondary').trim(),
    textTertiary:  css.getPropertyValue('--text-tertiary').trim(),
    border:        css.getPropertyValue('--border-subtle').trim(),
    surface1:      css.getPropertyValue('--bg-surface-1').trim(),
    surface2:      css.getPropertyValue('--bg-surface-2').trim(),
    brand:         css.getPropertyValue('--color-brand-500').trim(),
    success:       css.getPropertyValue('--color-success').trim(),
    warning:       css.getPropertyValue('--color-warning').trim(),
    critical:      css.getPropertyValue('--color-critical').trim(),
    info:          css.getPropertyValue('--color-info').trim(),
  };

  // الخطوط
  Chart.defaults.font.family = "'IBM Plex Sans Arabic', system-ui, sans-serif";
  Chart.defaults.font.size = 11;
  Chart.defaults.color = T.textSecondary;

  // Animation
  Chart.defaults.animation.duration = 600;
  Chart.defaults.animation.easing = 'easeOutCubic';

  // Tooltip
  Chart.defaults.plugins.tooltip = {
    ...Chart.defaults.plugins.tooltip,
    backgroundColor: T.surface2,
    titleColor: T.textPrimary,
    bodyColor: T.textSecondary,
    borderColor: T.border,
    borderWidth: 1,
    titleFont: { weight: 600, size: 12, family: "'IBM Plex Sans Arabic'" },
    bodyFont: { size: 11, family: "'JetBrains Mono', monospace" },
    padding: 10,
    cornerRadius: 6,
    displayColors: true,
    boxWidth: 8, boxHeight: 8, boxPadding: 6,
    rtl: true,
    textDirection: 'rtl',
  };

  // Legend
  Chart.defaults.plugins.legend = {
    ...Chart.defaults.plugins.legend,
    position: 'bottom',
    align: 'start',
    labels: {
      color: T.textSecondary,
      font: { size: 11, family: "'IBM Plex Sans Arabic'" },
      boxWidth: 8, boxHeight: 8,
      padding: 12,
      usePointStyle: true,
      pointStyle: 'circle',
    },
  };

  // Scales
  Chart.defaults.scale.grid = {
    color: T.border,
    drawBorder: false,
    drawTicks: false,
    lineWidth: 1,
  };
  Chart.defaults.scale.ticks = {
    color: T.textTertiary,
    font: { size: 10, family: "'JetBrains Mono', monospace" },
    padding: 8,
  };

  // Element defaults
  Chart.defaults.elements.line.borderWidth = 2;
  Chart.defaults.elements.line.tension = 0.35;
  Chart.defaults.elements.point.radius = 0;
  Chart.defaults.elements.point.hoverRadius = 5;
  Chart.defaults.elements.bar.borderRadius = 4;
  Chart.defaults.elements.bar.borderSkipped = false;

  // export palette helpers
  window.ShieldChartTokens = T;
  window.ShieldChartPalette = [T.brand, T.critical, T.warning, T.success, T.info, '#A78BFA', '#F472B6'];
})();
```

> **يُستدعى مرة واحدة بعد `chart.min.js` في `core.php`.**

---

## 3. أنواع الرسوم وقواعدها

### 3.1 Area Chart — لخط زمني (Threats Over Time)

**الاستخدام:** عرض التهديدات في آخر 24 ساعة / 7 أيام / 30 يوماً.

**القواعد:**
- لون التعبئة: `rgba(brand, 0.15)`.
- لون الخط: `var(--color-brand-500)`.
- بدون نقاط، إلا عند Hover.
- المحور Y يبدأ من 0 دائماً.
- المحور X: تواريخ بخط Mono، توجيه RTL.

```javascript
const gradient = ctx.createLinearGradient(0, 0, 0, 280);
gradient.addColorStop(0, 'rgba(0, 184, 230, 0.30)');
gradient.addColorStop(1, 'rgba(0, 184, 230, 0)');

new Chart(ctx, {
  type: 'line',
  data: {
    labels: timestamps,
    datasets: [{
      label: 'تهديدات محظورة',
      data: counts,
      backgroundColor: gradient,
      borderColor: ShieldChartTokens.brand,
      fill: true,
      tension: 0.35,
    }]
  },
  options: { /* defaults handle the rest */ }
});
```

### 3.2 Donut Chart — لتوزيع أنواع التهديدات

**الاستخدام:** نسبة SQLi / Bots / Spam / Proxy.

**القواعد:**
- `cutout: '70%'` (دائرة مفرغة).
- لكل قطعة لون من اللوحة الدلالية.
- في المنتصف: رقم إجمالي + label.
- Legend جانبي (يمين في RTL) مع نسب مئوية.

```javascript
new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['SQL Injection', 'Bad Bots', 'Spam', 'Proxy'],
    datasets: [{
      data: [42, 28, 18, 12],
      backgroundColor: [
        ShieldChartTokens.critical,
        ShieldChartTokens.warning,
        ShieldChartTokens.info,
        ShieldChartTokens.brand,
      ],
      borderWidth: 0,
      hoverOffset: 6,
    }]
  },
  options: {
    cutout: '70%',
    plugins: {
      legend: { position: 'right', align: 'center' },
    }
  }
});
```

**Center Label HTML (يُوضع فوق الـ Canvas):**
```html
<div class="donut-wrapper">
  <canvas id="threatTypes"></canvas>
  <div class="donut-center">
    <span class="num">100</span>
    <span class="txt-overline">إجمالي</span>
  </div>
</div>
```

### 3.3 Horizontal Bar — لـ Top Countries / Top IPs

**القواعد:**
- أعمدة أفقية (لأن أسماء الدول/IPs طويلة).
- لون موحد (`--color-brand-500`) مع شفافية متدرجة (الأطول = أغمق).
- بدون Y-axis (الأسماء على الـ axis).
- Bar height: 24px، Gap: 8px.

### 3.4 Sparkline — في الـ KPI Cards

رسم خط صغير 60×24px داخل كرت KPI، لعرض اتجاه آخر 60 ثانية / دقيقة.

**القواعد:**
- بدون محاور، بدون Grid.
- خط 1.5px فقط بلون الـ KPI.
- بدون tooltip (إنه dashboard glanceable).

```javascript
new Chart(sparkCtx, {
  type: 'line',
  data: { labels: arr.map((_,i)=>i), datasets: [{ data: arr, borderColor: T.success, fill: false }] },
  options: {
    responsive: false,
    maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip: { enabled: false } },
    scales: { x: { display: false }, y: { display: false } },
    elements: { point: { radius: 0 }, line: { tension: 0.4, borderWidth: 1.5 } },
  }
});
```

### 3.5 Heatmap — للساعات/الأيام

**الاستخدام:** متى تحدث الهجمات أكثر؟ (أيام × ساعات).

**القواعد:**
- شبكة 7×24 خلية.
- لون كل خلية تدرج من `--bg-surface-2` (لا هجمات) إلى `--color-critical` (الذروة).
- Hover: tooltip بالعدد الدقيق.

> Chart.js لا يدعم heatmap أصلاً. نستخدم **chartjs-chart-matrix plugin** أو نبنيه يدوياً بـ CSS Grid.

### 3.6 Stat Bar List — بدون مكتبة!

أحياناً قائمة بسيطة مع شريط تقدم أوضح من رسم بياني:

```html
<ul class="stat-bar-list">
  <li class="stat-bar-item">
    <span class="stat-bar-item__flag">🇺🇸</span>
    <span class="stat-bar-item__label">United States</span>
    <span class="stat-bar-item__bar">
      <span class="stat-bar-item__fill" style="--w: 78%"></span>
    </span>
    <span class="stat-bar-item__value num">3,421</span>
  </li>
  <!-- ... -->
</ul>
```

```css
.stat-bar-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: var(--space-2); }
.stat-bar-item {
  display: grid;
  grid-template-columns: 24px 1fr 100px 60px;
  align-items: center;
  gap: var(--space-3);
  padding: var(--space-2) var(--space-3);
  border-radius: var(--radius-sm);
  font-size: var(--text-sm);
  transition: var(--transition-color);
}
.stat-bar-item:hover { background: var(--bg-surface-2); }
.stat-bar-item__bar {
  height: 6px;
  background: var(--bg-surface-3);
  border-radius: var(--radius-full);
  overflow: hidden;
}
.stat-bar-item__fill {
  display: block;
  height: 100%;
  width: var(--w);
  background: linear-gradient(90deg, var(--color-brand-700), var(--color-brand-500));
  border-radius: var(--radius-full);
}
.stat-bar-item__value {
  font-family: var(--font-mono);
  font-variant-numeric: tabular-nums;
  color: var(--text-secondary);
  text-align: end;
}
```

---

## 4. الـ Empty States للرسوم

عندما لا توجد بيانات:

```html
<div class="chart-empty">
  <i data-lucide="bar-chart-3" class="icon icon-2xl"></i>
  <h4>لا توجد بيانات في هذه الفترة</h4>
  <p>جرّب تغيير المدى الزمني أو إزالة الفلاتر.</p>
</div>
```

---

## 5. Live Data — التحديث الحي

### 5.1 المبدأ
بعض الرسوم (مثل Live Threats Stream) يجب أن تُحدَّث كل X ثوانٍ. هنا قواعد ذكية:

- **التحديث ناعم** — لا تُعد رسم الـ chart كاملاً، استخدم `chart.update('none')` لتجنب الانيميشن.
- **مؤشر "Live"** — نقطة نابضة (موجودة في `kpi-card__live`).
- **زر إيقاف Live** — للسماح للمستخدم بالتفحص.
- **Throttle** — لا تتجاوز التحديث مرة كل 3 ثوانٍ.

```javascript
let liveInterval = setInterval(() => {
  chart.data.labels.shift();
  chart.data.labels.push(newLabel);
  chart.data.datasets[0].data.shift();
  chart.data.datasets[0].data.push(newValue);
  chart.update('none');  // بدون animation
}, 3000);

// Toggle
document.getElementById('liveToggle').addEventListener('click', () => {
  if (liveInterval) { clearInterval(liveInterval); liveInterval = null; }
  else { liveInterval = setInterval(...); }
});
```

---

## 6. الخريطة الجغرافية (Threat Map) — اختياري للمرحلة 2

عرض النقاط على خريطة العالم. خيارات:

| المكتبة | الإيجابيات | السلبيات |
|--------|----------|---------|
| **amCharts 5** | جميل، احترافي، دعم WebGL | حجم كبير، ترخيص للاستخدام التجاري |
| **Datamaps.js** | خفيف، مبني على D3 | غير مُحدَّث |
| **Mapbox GL JS** | الأقوى، مجاني حتى حد | يحتاج token |
| **Leaflet + GeoJSON** | مجاني تماماً، خفيف | تخصيص أكثر يدوياً |

**التوصية:** ابدأ بـ Leaflet لتجنب التعقيد، وانقل لـ Mapbox عند الحاجة.

---

## 7. تصدير الرسوم (Export)

كل رسم يجب أن يدعم 3 خيارات تصدير:

```html
<div class="chart-actions">
  <button onclick="exportChart('png')">PNG</button>
  <button onclick="exportChart('csv')">CSV</button>
  <button onclick="exportChart('print')">طباعة</button>
</div>
```

```javascript
function exportChart(type) {
  if (type === 'png') {
    const url = chart.toBase64Image();
    const a = document.createElement('a');
    a.href = url; a.download = 'chart.png'; a.click();
  } else if (type === 'csv') {
    /* تحويل البيانات لـ CSV */
  }
}
```

---

## 8. ميزة الانتقال بين الـ Themes

عند تبديل المستخدم بين Dark / Light، **جميع الرسوم يجب أن تُحدَّث ألوانها**:

```javascript
function refreshAllCharts() {
  // إعادة قراءة الـ tokens
  ShieldChartTokens = readCSSTokens();
  // تحديث كل chart instance
  Object.values(Chart.instances).forEach(chart => {
    // تحديث ألوان الـ datasets يدوياً
    chart.update();
  });
}

document.addEventListener('shield:theme-change', refreshAllCharts);
```

---

## 9. ملخص قواعد سريعة

✅ **افعل:**
- استخدم `tabular-nums` لكل الأرقام.
- ابدأ المحور Y من 0.
- استخدم لون واحد بارز + ألوان مكملة خافتة.
- اجعل الـ tooltips غنية بالمعلومات.
- وفّر Empty State جميل.

❌ **تجنّب:**
- تأثيرات 3D.
- ظلال على الـ bars.
- Legend في الأعلى (يأخذ مساحة قيمة).
- ألوان متعددة في dataset واحد بدون معنى.
- Animation على التحديث الحي.

---

## 📎 الخطوة التالية

اقرأ الآن: [`07-implementation-roadmap.md`](./07-implementation-roadmap.md) — خطة التنفيذ الزمنية.
