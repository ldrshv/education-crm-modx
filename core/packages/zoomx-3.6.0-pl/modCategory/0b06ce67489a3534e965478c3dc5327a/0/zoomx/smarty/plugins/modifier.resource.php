<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:    modifier.resource.php
 * Type:    modifier
 * Name:    resource
 * Purpose: Get a resource field.
 * -------------------------------------------------------------
 */
function smarty_modifier_resource($field, $defaultField = null)
{
    global $modx;

    if (!isset($modx->resource)) {
        return '';
    }
    $output = $modx->resource->get($field);
    if (empty($output) && $defaultField !== null) {
            $output = $modx->resource->get($defaultField);
    }

    return is_array($output) ? $output[1] : $output;
}