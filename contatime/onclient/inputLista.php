<?php
$contatoObj = !isset($contatoObj)? new contato(): $contatoObj;
echo $contatoObj->listaDeInputs($_GET['id']);
?>
<li class="novoCampo novoCampoInput">
    <a href="<?php echo $_ll['app']['onclient'], '&p=input&id=novo&contato=', $_GET['id']?>"><img src="<?php echo $_ll['app']['pasta'], 'sys/new_input.png';?>">NOVO CAMPO</a>
</li>
<script type="text/javascript">
    $('.listaDeCampos li a').click(function(){
        $('.dadosInput').load($(this).attr('href'));
        return false;
    });
    $('.listaDeCampos li.novoCampoInput a').click(function(){
        $('.listaDeCampos').load('<?php echo $_ll['app']['onclient'], '&p=inputLista&id=', $_GET['id'];?>');
        return false;
    });
</script>
