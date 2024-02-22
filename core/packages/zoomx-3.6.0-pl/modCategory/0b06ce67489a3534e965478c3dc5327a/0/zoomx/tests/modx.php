<?php

if (isset($GLOBALS['modx'])) {
    return $GLOBALS['modx'];
}

require dirname(__DIR__, 5) . '/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';

putenv("APP_ENV=test");
define('MODX_API_MODE', true);

$GLOBALS['modx'] = $modx = new modX();
$modx->initialize('web');
$modx->getService('error', 'error.modError', '', '');

return $modx;

