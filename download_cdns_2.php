<?php
// download_cdns_2.php
$cdns = [
    // CSS
    "https://cdn.jsdelivr.net/npm/switchery@0.8.2/switchery.min.css" => "assets/offline/css/switchery.min.css",
    "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" => "assets/offline/css/select2.min.css",
    
    // JS
    "https://cdn.jsdelivr.net/npm/switchery@0.8.2/switchery.min.js" => "assets/offline/js/switchery.min.js",
    "https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js" => "assets/offline/js/chart.min.js",
    "https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.3/js/jquery.overlayScrollbars.min.js" => "assets/offline/js/jquery.overlayScrollbars.min.js",
    "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js" => "assets/offline/js/select2.full.min.js",
    "https://cdn.jsdelivr.net/npm/pdfmake@0.2.12/build/pdfmake.min.js" => "assets/offline/js/pdfmake.min.js",
    "https://cdn.jsdelivr.net/npm/pdfmake@0.2.12/build/vfs_fonts.js" => "assets/offline/js/vfs_fonts.min.js"
];

foreach ($cdns as $url => $path) {
    echo "Downloading $url ...\n";
    $content = @file_get_contents($url);
    if ($content !== false) {
        file_put_contents($path, $content);
        echo "Saved to $path\n";
    } else {
        echo "FAILED to download $url\n";
    }
}
echo "Done.\n";
?>
