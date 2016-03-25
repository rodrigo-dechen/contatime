<?php



if($_GET['id'] == 'novo')
    $_GET['id'] = $contato->emailNovo($_GET['contato']);

$email = $contato->emailDados($_GET['id']);
?>

<input id="email-emisorID" class="input-email" type="hidden" name="id" value="<?php echo $email['id'];?>"/>

<p>
    <label>Emisor nome</label>
    <input id="email-emisorNome" class="input-email" type="text" name="emisorNome" value="<?php echo $email['emisorNome'];?>"/>
</p>
<p>
    <label>Emisor email</label>
    <input id="email-emisorEmail" class="input-email" type="text" name="emisorEmail" value="<?php echo $email['emisorEmail'];?>"/>
</p>

<p>
    <label>Destinatario nome</label>
    <input id="email-destinatarioNome" class="input-email" type="text" name="destinatarioNome" value="<?php echo $email['destinatarioNome'];?>"/>
</p>
<p>
    <label>Destinatario email</label>
    <input id="email-destinatarioEmail" class="input-email" type="text" name="destinatarioEmail" value="<?php echo $email['destinatarioEmail'];?>"/>
</p>
<p>
    <label>Asunto</label>
    <input id="email-asunto" class="input-email" type="text" name="asunto" value="<?php echo $email['asunto'];?>"/>
</p>
<p>
    <label>Mensagem</label>
    <textarea id="email-mensagem" class="input-email" name="mensagem"><?php echo $email['mensagem'];?></textarea>
</p>
<p>
    <span class="alinhadoADireita botao">
        <a id="email-deletar">DELETAR</a>
    </span>
</p>

<script type="text/javascript">

    var emailFaltaUpdate = false;
    var emailBufferUpdate = 0;
    var emailUpdateDelay = 3000;
    
    function emailBufferisaUpdate(){
        emailFaltaUpdate = true;
        emailBufferUpdate++;
        setTimeout(emailFinalmenteUpdate, emailUpdateDelay);
    }
    
    function emailFinalmenteUpdate(){
        if(emailFaltaUpdate && emailBufferUpdate > 0){
            emailBufferUpdate--;
        }
        if(emailFaltaUpdate && emailBufferUpdate == 0){
            emailRealmenteUpdate();
        }
    }
    
    function emailRealmenteUpdate(){
        emailFaltaUpdate = false;
        emailBufferUpdate = 0;
        $.post('<?php echo $llAppOnServer, '&p=emailUpdate';?>', $('.input-email').serialize(), function (ret){
            console.log(ret);
        });
    }
    
    $('.input-email').bind('keyup', function(){
        emailBufferisaUpdate();
    }).bind('focusout', function(){
        emailRealmenteUpdate();
    });
    
    $('#email-asunto').bind('keyup focusout', function (){
        $('.email-name-<?php echo $email['id'];?>').html($(this).val());
    });
    
    $('#email-deletar').click(function (){
        $('.dadosEmail').load('<?php echo $_ll['app']['onclient'], '&p=emailDeletar&id=', $_GET['id']?>');
        return false;
    });

</script>