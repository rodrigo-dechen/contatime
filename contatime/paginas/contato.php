<?php $dados = $contato->contatoDados($_GET['id']);?>

<div id="contato" class="boxCenter">
    
    <form class="dados" action="<?php echo $llAppOnServer . '&p=salvar';?>">
        
        <input class="inputContato" type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        
        <fieldset>
            
            <h2>Dados</h2>
        
            <p>
                <span>
                    <label>Nome do Formulario</label>
                </span>
                <span>
                    <input class="inputContato" type="text" name="nome" value="<?php echo $dados['nome'];?>"/>
                </span>
            </p>
        
			<?php /*
        
            <p>
                <span>
                    <label>Host</label>
                </span>
                <span>
                    <input class="inputContato" type="text" name="Host" value="<?php echo $dados['Host'];?>"/>
                </span>
            </p>
        
            <p>
                <span>
                    <label>SMTPAuth</label>
                </span>
                <span>
                    <input class="inputContato" type="checkbox" name="SMTPAuth" value="true"<?php echo $dados['SMTPAuth'] == 'true'? ' checked': '';?>/>
                    <span class="coment">Altenticar via SMTP</span>
                </span>
            </p>
        
            <p>
                <span>
                    <label>Port</label>
                </span>
                <span>
                    <input class="inputContato" type="text" name="Port" value="<?php echo $dados['Port'];?>"/>
                </span>
            </p>
        
            <p>
                <span>
                    <label>SMTPSecure</label>
                </span>
                <span>
                    <select class="inputContato" name="SMTPSecure">
                        <option value="null"<?php echo ($dados['SMTPSecure'] == null? ' selected': '');?>> Sem SMTP Secure</option>
                        <option value="ssl"<?php echo ($dados['SMTPSecure'] == 'ssl'? ' selected': '');?>>SSL</option>
                        <option value="tls"<?php echo ($dados['SMTPSecure'] == 'tls'? ' selected': '');?>>TLS</option>
                    </select>
                </span>
            </p>
        
            <p>
                <span>
                    <label>Username</label>
                </span>
                <span>
                    <input class="inputContato" type="text" name="Username" value="<?php echo $dados['Username'];?>"/>
                </span>
            </p>
        
            <p>
                <span>
                    <label>Password</label>
                </span>
                <span>
                    <input class="inputContato" type="password" name="Password" value="<?php echo $dados['Password'];?>"/>
                </span>
            </p>

			*/?>
        
        </fieldset>
        
        <fieldset>
            
            <h2>Campos</h2>
        
            <ul class="lista listaDeCampos">
                <?php require_once $_ll['app']['pasta'].'onclient/inputLista.php';?>
            </ul>
            
            <div class="boxDados dadosInput">
                <?php require_once $_ll['app']['pasta'].'onclient/inputTextoInicial.php';?>
            </div>
        
        </fieldset>
        
        <fieldset>
            
            <h2>Formulario</h2>
        
            <p>
                <textarea class="inputContato" name="form"><?php echo $dados['form'];?></textarea>
            </p>
        
        </fieldset>
        
        <fieldset>
            
            <h2>CSS</h2>
        
            <p>
                <textarea class="inputContato" name="css"><?php echo $dados['css'];?></textarea>
            </p>
        
        </fieldset>
        
        <fieldset>
            
            <h2>E-mails</h2>
        
            <ul class="lista listaDeEmails">
                <?php require_once $_ll['app']['pasta'].'onclient/emailLista.php';?>
            </ul>
            
            <div class="boxDados dadosEmail">
                <?php require_once $_ll['app']['pasta'].'onclient/emailTextoInicial.php';?>
            </div>
        
        </fieldset>
        
    </form>
    
</div>

<script type="text/javascript">

    var contatoFaltaUpdate = false;
    var contatoBufferUpdate = 0;
    var contatoUpdateDelay = 3000;
    
    function contatoBufferisaUpdate(){
        contatoFaltaUpdate = true;
        contatoBufferUpdate++;
        setTimeout(contatoFinalmenteUpdate, contatoUpdateDelay);
    }
    
    function contatoFinalmenteUpdate(){
        if(contatoFaltaUpdate && contatoBufferUpdate > 0){
            contatoBufferUpdate--;
        }
        if(contatoFaltaUpdate && contatoBufferUpdate == 0){
            contatoRealmenteUpdate();
        }
    }
    
    function contatoRealmenteUpdate(){
        contatoFaltaUpdate = false;
        contatoBufferUpdate = 0;
        $.post('<?php echo $llAppOnServer, '&p=contatoUpdate';?>', $('.inputContato').serialize());
    }
    
    $('.inputContato').bind('keyup', function(){
        contatoBufferisaUpdate();
    }).bind('focusout', function(){
        contatoRealmenteUpdate();
    });

</script>

