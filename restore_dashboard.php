<?php
$file = 'd:/pro1/dashboard.php';
$content = file_get_contents($file);

// Remove Block 1: Page Header
$content = preg_replace('/<\?php if \(!empty\(\$settings\[\'ui_engine\'\]\) && \$settings\[\'ui_engine\'\] === \'shield\'\): \?>.*?<\?php else: \?>/s', '', $content, 1);
$content = preg_replace('/<\?php endif; \?>\s*<!--Page content-->/', '<!--Page content-->', $content, 1);

// Remove Block 2: KPI Today
$content = preg_replace('/<\?php if \(!empty\(\$settings\[\'ui_engine\'\]\) && \$settings\[\'ui_engine\'\] === \'shield\'\): \?>\s*<\?php include "includes\/shield-kpi-today.php"; \?>\s*<\?php else: \?>/s', '', $content, 1);
$content = preg_replace('/<\/div>\s*<\?php endif; \?>\s*<br \/><h4 class="shield-card">الإحصائيات الشاملة<\/h4>/s', "</div>\n\n                <br /><h4 class=\"card-title\">الإحصائيات الشاملة</h4>", $content, 1);

// Remove Block 3: KPI Total
$content = preg_replace('/<\?php if \(!empty\(\$settings\[\'ui_engine\'\]\) && \$settings\[\'ui_engine\'\] === \'shield\'\): \?>\s*<\?php include \'includes\/shield-kpi-total.php\'; \?>\s*<\?php else: \?>/s', '', $content, 1);
$content = preg_replace('/<\/div>\s*<\?php endif; \?>\s*<\/div>\s*<\/div>\s*<\?php if \(!empty\(\$settings\[\'ui_engine\'\]\)/s', "</div>\n\t\t\t\t\t    </div>\n\t\t\t\t\t</div>\n\n<?php if (!empty(\$settings['ui_engine'])", $content, 1);

// Remove Block 4: Dashboard Modules
$content = preg_replace('/<\?php if \(!empty\(\$settings\[\'ui_engine\'\]\) && \$settings\[\'ui_engine\'\] === \'shield\'\): \?>\s*<\?php include \'includes\/shield-dashboard-modules.php\'; \?>\s*<\?php else: \?>/s', '', $content, 1);
$content = preg_replace('/<\/div>\s*<\?php endif; \?>\s*<\?php if \(!empty\(\$settings\[\'ui_engine\'\]\)/s', "</div>\n<?php if (!empty(\$settings['ui_engine'])", $content, 1);

// Remove Block 5: Dashboard Bottom
$content = preg_replace('/<\?php if \(!empty\(\$settings\[\'ui_engine\'\]\) && \$settings\[\'ui_engine\'\] === \'shield\'\): \?>\s*<\?php include \'includes\/shield-dashboard-bottom.php\'; \?>\s*<\?php else: \?>/s', '', $content, 1);
$content = preg_replace('/<!--END CONTENT CONTAINER-->\s*<\?php endif; \?>\s*<\/div>\s*<\?php\s*footer\(\);\s*\?>/s', "<!--END CONTENT CONTAINER-->\n</div>\n<?php\nfooter();\n?>", $content, 1);

file_put_contents('d:/pro1/dashboard_restored.php', $content);
echo "Restored file written to dashboard_restored.php";
