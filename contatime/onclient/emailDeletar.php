<?php

$dados = $contato->emailDados($_GET['id']);
$contato->emailDeleta($_GET['id']);

require_once $_ll['app']['pasta'].'onclient/emailTextoInicial.php';
?>

<script type="text/javascript">
    $('.listaDeEmails').load('<?php echo $_ll['app']['onclient'], '&p=emailLista&id=', $dados['contato'];?>');
</script>