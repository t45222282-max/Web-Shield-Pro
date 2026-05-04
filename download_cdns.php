<?php
// download_cdns.php
$cdns = [
    // CSS
    "https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" => "assets/offline/css/ionicons.min.css",
    "https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" => "assets/offline/css/bootstrap-rtl.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" => "assets/offline/css/switchery.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" => "assets/offline/css/select2.min.css",
    "https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-html5-3.2.0/r-3.0.3/datatables.min.css" => "assets/offline/css/datatables.min.css",
    
    // JS
    "https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js" => "assets/offline/js/switchery.min.js",
    "https://code.jquery.com/jquery-3.7.1.min.js" => "assets/offline/js/jquery.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" => "assets/offline/js/chart.min.js",
    "https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" => "assets/offline/js/bootstrap.bundle.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.3/js/jquery.overlayScrollbars.min.js" => "assets/offline/js/jquery.overlayScrollbars.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" => "assets/offline/js/select2.full.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/pdfmake.min.js" => "assets/offline/js/pdfmake.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/vfs_fonts.min.js" => "assets/offline/js/vfs_fonts.min.js",
    "https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-html5-3.2.0/r-3.0.3/datatables.min.js" => "assets/offline/js/datatables.min.js"
];

if (!is_dir('assets/offline/css')) mkdir('assets/offline/css', 0777, true);
if (!is_dir('assets/offline/js')) mkdir('assets/offline/js', 0777, true);

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
