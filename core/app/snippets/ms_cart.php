<?php
$ms2 = $modx->getService('minishop2');
$ms2->initialize('web');
$out = $ms2->cart->status();
$out['cart'] = $ms2->cart->get();
return $out;