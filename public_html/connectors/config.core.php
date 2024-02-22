<?php
/*
 * This file is managed by the installation process.  Any modifications to it may get overwritten.
 * Add customizations to the $config_options array in `core/config/config.inc.php`.
 *
 */
$root_path = explode('/public_html', __DIR__)[0];
define('MODX_CORE_PATH', $root_path . '/core/');
define('MODX_CONFIG_KEY', 'config');
?>