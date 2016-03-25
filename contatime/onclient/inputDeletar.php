<?php

$dados = $contato->inputDados($_GET['id']);
$contato->deletaInput($_GET['id']);

require_once $_ll['app']['pasta'].'onclient/inputTextoInicial.php';

?>

<script type="text/javascript">
    $('.listaDeCampos').load('<?php echo $_ll['app']['onclient'], '&p=inputLista&id=', $dados['contato'];?>');
</script>