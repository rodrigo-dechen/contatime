<?php
$contatoObj = new contato();

if($_GET['id'] == 'novo')
    $_GET['id'] = $contatoObj->inputNovo($_GET['contato']);

$input = $contatoObj->inputDados($_GET['id']);
?>
<p>
    <label>Tipo</label>
    <select id="input-tipo" name="input-tipo" >
        <option value="input"<?php echo $input['tipo'] == 'input'? ' selected': '';?>>Imput</option>
        <option value="textarea"<?php echo $input['tipo'] == 'textarea'? ' selected': '';?>>TextArea</option>
        <option value="button"<?php echo $input['tipo'] == 'button'? ' selected': '';?>>Botão</option>
    </select>
</p>
<p>
    <label>Nome</label>
    <input id="input-name" type="text" name="input-name" value="<?php echo $input['nome'];?>"/>
</p>
<p>
    <label>Pre Preenchimento</label>
    <input id="input-preenchimento" type="text" name="input-preenchimento" value="<?php echo $input['preenchimento'];?>"/>
</p>
<p>
    <label>Referencia</label>
    <input id="input-ref" type="text" name="input-ref" value="<?php echo $input['referencia'];?>" onclick="this.select();" readonly="readonly"/>
</p>
<p>
    <label>Clase</label>
    <input id="input-class" type="text" name="input-class" value="<?php echo $input['class'];?>"/>
</p>
<p>
    <span class="alinhadoADireita botao">
        <a  id="input-deletar">DELETAR</a>
    </span>
</p>

<script type="text/javascript">

    $('#input-name').bind('keyup focusout', function(){
        $('.listaDeCampos a.input-name-<?php echo $_GET['id'];?>').load('<?php echo $llAppOnServer, '&p=inputEditNome&id=', $_GET['id'], '&nome='?>' + $('#input-name').val().replace(/ /g, '+'));
    });
    
    $('#input-tipo').change(function (){
        $.get('<?php echo $llAppOnServer, '&p=inputEditTipo&id=', $_GET['id'], '&tipo='?>' + $(this).val());
    });
    
    $('#input-class').keyup(function (){
        $.get('<?php echo $llAppOnServer, '&p=inputEditClass&id=', $_GET['id'], '&class='?>' + $(this).val());
    });
    
	var bufferPreenchimento = 0;
	
    $('#input-preenchimento').bind('keyup focusout', function (event){
		var eu = this;
		if(event.type == 'keyup'){
			bufferPreenchimento = (bufferPreenchimento <= 0? 1: bufferPreenchimento + 1);
			setTimeout(function(){
				bufferPreenchimento = (bufferPreenchimento > 0? bufferPreenchimento - 1: bufferPreenchimento);
				if(bufferPreenchimento === 0){
					bufferPreenchimento = -1;
					$.get('<?php echo $llAppOnServer, '&p=inputEditPreenchimento&id=', $_GET['id'], '&preenchimento='?>' + $(eu).val());
				}
			}, 3000);
		}
		if(event.type == 'focusout'){
			bufferPreenchimento = -1;
			$.get('<?php echo $llAppOnServer, '&p=inputEditPreenchimento&id=', $_GET['id'], '&preenchimento='?>' + $(eu).val());
		}
    });
    
    $('#input-deletar').click(function (){
        $('.dadosInput').load('<?php echo $_ll['app']['onclient'], '&p=inputDeletar&id=', $_GET['id']?>');
        return false;
    });

</script>