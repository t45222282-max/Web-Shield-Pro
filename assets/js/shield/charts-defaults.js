/**
 * assets/js/shield/charts-defaults.js
 * Chart.js Global Defaults — Shield Design System
 * Reference: docs/06-data-visualization.md § 2
 * Load: AFTER chart.min.js, BEFORE any chart initialization
 */
(function () {
  if (typeof Chart === 'undefined') return;

  // Read Design Tokens from CSS Variables
  const css = getComputedStyle(document.documentElement);
  const T = {
    textPrimary:   css.getPropertyValue('--text-primary').trim()   || '#E2E8F4',
    textSecondary: css.getPropertyValue('--text-secondary').trim() || '#8A96A8',
    textTertiary:  css.getPropertyValue('--text-tertiary').trim()  || '#5A6478',
    border:        css.getPropertyValue('--border-subtle').trim()  || 'rgba(255,255,255,0.06)',
    surface1:      css.getPropertyValue('--bg-surface-1').trim()   || '#111726',
    surface2:      css.getPropertyValue('--bg-surface-2').trim()   || '#1A2236',
    brand:         css.getPropertyValue('--color-brand-500').trim()|| '#00B8E6',
    success:       css.getPropertyValue('--color-success').trim()  || '#22C55E',
    warning:       css.getPropertyValue('--color-warning').trim()  || '#F59E0B',
    critical:      css.getPropertyValue('--color-critical').trim() || '#EF4444',
    info:          css.getPropertyValue('--color-info').trim()     || '#38BDF8',
  };

  try {
    // ── Typography ──
    Chart.defaults.font.family = "'IBM Plex Sans Arabic', system-ui, sans-serif";
    Chart.defaults.font.size   = 11;
    Chart.defaults.color       = T.textSecondary;

    // ── Tooltips ──
    if (Chart.defaults.plugins && Chart.defaults.plugins.tooltip) {
        Chart.defaults.plugins.tooltip.backgroundColor = T.surface2;
        Chart.defaults.plugins.tooltip.titleColor = T.textPrimary;
        Chart.defaults.plugins.tooltip.bodyColor = T.textSecondary;
        Chart.defaults.plugins.tooltip.borderColor = T.border;
        Chart.defaults.plugins.tooltip.borderWidth = 1;
        Chart.defaults.plugins.tooltip.rtl = true;
        Chart.defaults.plugins.tooltip.textDirection = 'rtl';
    }

    // ── Export globals ──
    window.ShieldChartTokens  = T;
    window.ShieldChartPalette = [T.brand, T.critical, T.warning, T.success, T.info, '#A78BFA', '#F472B6'];

    // ── Theme change handler ──
    document.addEventListener('shield:theme-change', function () {
      const css2  = getComputedStyle(document.documentElement);
      const newT  = {
        textPrimary:   css2.getPropertyValue('--text-primary').trim(),
        textSecondary: css2.getPropertyValue('--text-secondary').trim(),
        border:        css2.getPropertyValue('--border-subtle').trim(),
        surface2:      css2.getPropertyValue('--bg-surface-2').trim(),
        brand:         css2.getPropertyValue('--color-brand-500').trim(),
        success:       css2.getPropertyValue('--color-success').trim(),
        warning:       css2.getPropertyValue('--color-warning').trim(),
        critical:      css2.getPropertyValue('--color-critical').trim(),
      };
      
      window.ShieldChartTokens = newT;
      Chart.defaults.color = newT.textSecondary;
      
      if (Chart.defaults.plugins && Chart.defaults.plugins.tooltip) {
          Chart.defaults.plugins.tooltip.backgroundColor = newT.surface2;
      }
      
      Object.values(Chart.instances).forEach(function(c) { 
        c.data.datasets.forEach(ds => {
            var colorHex = '';
            if (ds.label === 'SQLi') colorHex = newT.brand;
            if (ds.label === 'Bad Bot') colorHex = newT.critical;
            if (ds.label === 'Proxies') colorHex = newT.success;
            if (ds.label === 'Spammers') colorHex = newT.warning;

            if (colorHex) {
                if (c.config.type === 'line' && c.ctx) {
                    var hex = colorHex.replace('#', '');
                    if(hex.length === 3) hex = hex.split('').map(function(c) { return c + c; }).join('');
                    var r = parseInt(hex.substring(0, 2), 16) || 0;
                    var g = parseInt(hex.substring(2, 4), 16) || 0;
                    var b = parseInt(hex.substring(4, 6), 16) || 0;
                    var grad = c.ctx.createLinearGradient(0, 0, 0, 280);
                    grad.addColorStop(0, 'rgba(' + r + ',' + g + ',' + b + ', 0.30)');
                    grad.addColorStop(1, 'rgba(' + r + ',' + g + ',' + b + ', 0.0)');
                    ds.backgroundColor = grad;
                    ds.borderColor = colorHex;
                } else {
                    ds.backgroundColor = colorHex;
                }
            }
        });
        c.update(); 
      });
    });
  } catch(e) {
      console.warn("Shield chart defaults could not be applied:", e);
  }
})();
