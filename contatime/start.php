<?php

$botoes = array_merge(array(array('href' => $backReal, 'img' => 'imagens/icones/br_prev.png', 'title' => $backNome)), (isset($botoes)? $botoes: array()));
echo app_bar('Factory Forms', $botoes);

$path = 'paginas';
require dirname(__FILE__) . '/load.php';