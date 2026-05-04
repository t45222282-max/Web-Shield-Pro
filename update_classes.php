<?php
$file = 'D:/pro1/dashboard.php';
$content = file_get_contents($file);

// 1. Cards (BEM syntax as per _cards.css)
$content = str_replace('class="shield-card"', 'class="shield-card"', $content);
$content = str_replace('class="shield-card"', 'class="shield-card"', $content);
$content = str_replace('class="shield-card"', 'class="shield-card"', $content);
$content = str_replace('class="shield-card"', 'class="shield-card"', $content);
$content = str_replace('class="shield-card"', 'class="shield-card"', $content);
$content = str_replace('class="shield-card"', 'class="shield-card__header"', $content);
$content = str_replace('class="shield-card"', 'class="shield-card__title"', $content);
$content = str_replace('class="shield-card"', 'class="shield-card__body"', $content);

// 2. Small Boxes -> KPI Cards (BEM)
// We replace the outer wrapper
$content = str_replace('class="shield-kpi-card shield-kpi--info"', 'class="shield-kpi-card shield-kpi--info"', $content);
$content = str_replace('class="shield-kpi-card shield-kpi--info"', 'class="shield-kpi-card shield-kpi--critical"', $content);
$content = str_replace('class="shield-kpi-card shield-kpi--info"', 'class="shield-kpi-card shield-kpi--success"', $content);
$content = str_replace('class="shield-kpi-card shield-kpi--info"', 'class="shield-kpi-card shield-kpi--warning"', $content);

// And replace the internal structure classes of small boxes
$content = str_replace('class="shield-kpi__content"', 'class="shield-kpi__content"', $content);
// We can't safely replace h3 and p tags universally, but we can replace the icon wrapper
$content = str_replace('class="shield-kpi__icon"', 'class="shield-kpi__icon"', $content);
$content = str_replace('class="shield-kpi-card shield-kpi--info"', 'class="shield-kpi__action"', $content);

// 3. Tables
$content = str_replace('class="shield-table"', 'class="shield-table"', $content);
$content = str_replace('class="shield-table"', 'class="shield-table"', $content);

file_put_contents($file, $content);
echo "dashboard.php successfully updated.";
