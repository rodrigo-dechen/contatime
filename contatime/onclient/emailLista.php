<?php
echo $contato->emailLista($_GET['id']);
?>
<li class="novoCampo novoCampoEmail">
    <a href="<?php echo $_ll['app']['onclient'], '&p=email&id=novo&contato=', $_GET['id']?>"><img src="<?php echo $_ll['app']['pasta'], 'sys/new_e-mail.png';?>">NOVO E-MAIL</a>
</li>
<script type="text/javascript">
    $('.listaDeEmails li a').click(function(){
        $('.dadosEmail').load($(this).attr('href'));
        return false;
    });
    $('.listaDeEmails li.novoCampoEmail a').click(function(){
        $('.listaDeEmails').load('<?php echo $_ll['app']['onclient'], '&p=emailLista&id=', $_GET['id'];?>');
        return false;
    });
</script>
