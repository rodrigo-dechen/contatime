<div class="boxCenter">

    <?php
    $navigi = new navigi();
    $navigi->tabela = PREFIXO. 'contato';
    $navigi->query = 'SELECT * FROM '.$navigi->tabela.' a ORDER BY a.nome ASC' ;
    $navigi->delete = true;
	$navigi->exibicao = 'lista';
    $navigi->config = array(
        'ico' => 'textos/sys/ico.png',
        'link' => $_ll['app']['home'] . '&p=contato&id='
    );
    
    $navigi->monta();
    ?>

</div>