<?php
$query = $modx->newQuery('modTemplateVarResource', [
    'tmplvarid' => 5,
    'contentid' => $modx->resource->id,
]);
$query->select('value');
$blocks =  $modx->getValue($query->prepare());

if (!$page_blocks) {
    // получаем блоки шаблона
}

$blocks = json_decode($blocks, true) ?: [];

// foreach ($blocks as &$block) {
//     // подтягиваем из другого блока
//     if (!empty($block['get_from_other'])) {
//         $block_ids = explode('-', $block['get_from_other']);
        
//         $query = $modx->newQuery('modTemplateVarResource', [
//             'tmplvarid' => 97,
//             'contentid' => $block_ids[0],
//         ]);
//         $query->select('value');
//         $table =  $modx->getValue($query->prepare());

//         foreach (json_decode($table, true) as $row) {
//             if ($row['MIGX_id'] == $block_ids[1]) {
//                 $block = $row;
//             }
//         }
//     }
// }

return $blocks;