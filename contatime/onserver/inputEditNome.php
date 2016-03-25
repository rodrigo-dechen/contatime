<?php

$dados = $contato->atualizaNome($_GET['id'], $_GET['nome']);

echo $dados['nome'];

?>

<script type="text/javascript">
    $('#input-ref').val('<?php echo $dados['referencia'];?>');
</script>