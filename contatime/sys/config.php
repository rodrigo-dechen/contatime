<?php

//require as classes da pasta classes
require_once dirname(__FILE__) . '/../classes/db.php';
require_once dirname(__FILE__) . '/../classes/contato.php';

//configura o db para a conexao corrente.
db::conectar($conexao);