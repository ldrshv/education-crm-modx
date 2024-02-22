<?php

$out = [];
$leftJoin = [];
$optionFilters = [];
$where = [];
$sortby = isset($sortby) ? $sortby : 'menuindex';
$sortdir = isset($sortdir) ? $sortdir : 'ASC';

$props = [];
foreach ($_REQUEST as $key => $val) {
    if (preg_match('/sort|page|min_|max_|filter_/i', $key)) {
        $props[$key] = $val;
        if (preg_match('/filter_/i', $key) && gettype($val) == 'string') {
    	    $props[$key] = explode(',', $val);
    	}
    }
}
array_multisort($props); // для кэша

$cache_name = "msp_{$modx->resource->id}_" . md5(json_encode($props));

$cache = $modx->cacheManager->get($cache_name, [\xPDO::OPT_CACHE_KEY => 'resource']);
if ($cache) {
    $cache['debug']['cache'] = $cache_name;
    return $cache;
}

foreach ($props as $key => $val) {
    if ($key == 'sort') {
        $s = explode('_', $val);
        if (isset($s[0])) {
            $sortby = $s[0];
            if (in_array($s[0], ['price'])) {
                $sortby = "Data.{$s[0]}";
            }
            if (isset($s[1]) && $s[1] == 'desc') {
                $sortdir = 'DESC';
            }
        }
    }
    if (preg_match('/min_|max_/i', $key)) {
        $keys = explode('_', $key);
        $c = $keys[0] == 'min' ? '>=' : '<=';
        if ($keys[1] == 'price') {
            $where[] = "Data.price {$c} " . (int)$val;
        } else {
            $leftJoin[$keys[1]] = [
                'class' => 'msProductOption',
                'alias' => $keys[1],
                'on' => "`{$keys[1]}`.product_id = Data.id AND `{$keys[1]}`.key = '{$keys[1]}'"
            ];
            $where[] = "(`{$keys[1]}`.value * 1) {$c} $val";
            if ($keys[0] == 'max') {
                $where[] = "`{$keys[1]}`.value != ''";
            }
        }
    }
    if (preg_match('/filter_/i', $key)) {
        $key = str_replace('filter_', '', $key);
        if ($key == 'vendor') {
            $tmp_val = [];
            foreach ($val as $v) {
                $tmp_val[] = "'{$v}'";
            }
            $val = implode(',', $tmp_val);
            $where[] = "Vendor.name IN ($val)";
        } else {
            $optionFilters["{$key}:IN"] = $val;
        }
    }
}

$params = array_merge([
    'element' => 'msProducts',
    'limit' => $limit ?? 12,
    'pageLimit' => 7,
    'return' => 'JSON',
    'setMeta' => 0, // без этого долго загружается
    'sortby' => $sortby,
    'sortdir' => $sortdir,
    'tvPrefix'=>'',
    'includeThumbs' => 'webp,small',

    'leftJoin' => !empty($leftJoin) ? $leftJoin : '',
    'optionFilters' => !empty($optionFilters) ? json_encode($optionFilters) : '',
	'where' => count($where) ? '["' . implode(' AND ', $where) . '"]' : '',

	'tplPage'=>'@INLINE <li><a class="" href="{$href}" data-page="{$pageNo}">{$pageNo}</a></li>',
    'tplPageActive'=>'@INLINE <li class="pagination-list-active">{$pageNo}</li>',
    'tplPageSkip' => '@INLINE <li class="pagination-list-skip">...</li>',
    'tplPageWrapper'=>'@INLINE <ul class="pagination-list">{$pages}</ul>',
], $scriptProperties);

$response = $modx->runSnippet('pdoPage', $params);

$out['debug'] = [
    'params' => $params,
    'props' => $props,
];
$out['page'] = (int)$modx->placeholders['page'];
$out['pages'] = (int)$modx->placeholders['pageCount'];
$out['pagination'] = $modx->placeholders['page.nav'];
$out['items'] = json_decode($response, true);

$modx->cacheManager->set($cache_name, $out, 0, [\xPDO::OPT_CACHE_KEY => 'resource']);

return $out;