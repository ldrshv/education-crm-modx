<?php
$dir = MODX_BASE_PATH . 'dist/assets';
$files = scandir($dir) ?: [];

foreach ($files as $file) {
    if (stripos($file, 'index') !== false && stripos($file, '.js') !== false) {
        $modx->regClientStartupHTMLBlock("<script type='module' crossorigin src='/dist/assets/{$file}'></script>");
    }

    if (stripos($file, 'index') !== false && stripos($file, '.css') !== false) {
        $modx->regClientStartupHTMLBlock("<link rel='stylesheet' href='/dist/assets/{$file}'>");
    }
}

return null;