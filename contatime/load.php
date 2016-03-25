<?php

require_once dirname(__FILE__) . '/sys/config.php';

$path = isset($path)? $path: 'header';
$page = isset($_GET['p'])? $_GET['p']: 'index';

if(!isset($contato)) $contato = new contato();

if(file_exists(($f = dirname(__FILE__).'/'.$path.'/'.$page.'.php'))) require_once $f;