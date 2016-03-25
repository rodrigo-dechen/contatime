<?php

if(!class_exists('db')){
	require_once realpath(dirname(__FILE__). '/..'). '/classes/db.php'; db::conectar($conexao);}

class contato extends db{
    
    private static $css = array();
    private $contatoId = null;

    public function __construct($contatoId){
        parent::__construct(PREFIXO.'contato');
        $this->contatoId = $contatoId;
        self::$css[] = $contatoId;
        //layout::addDocHeader('css:css/contato.css.php?ids='. $contatoId);
    }

    public function form($action){
        
        $inputs = parent::select('SELECT * FROM '.$this.'_input WHERE contato = "'.$this->contatoId.'"');
        $inputs = $this->geraImputs($inputs);
        
        $form = parent::select('SELECT form FROM '.$this.' WHERE id="'.$this->contatoId.'" LIMIT 1');
        $form = parent::fetch($form);
        
        return 
            '<form action="'.$action.'" method="post" enctype="multipart/form-data">' .
                '<input type="hidden" name="contato-form" value="'.$this->contatoId.'"/>' .
                parent::shortTagReplace($form['form'], $inputs) . 
            '</form>';
    }

    private function geraImputs($inputs) {
        $retorno = array();
        foreach ($inputs as $input)
            $retorno[substr($input['referencia'], 1, -1)] = $input['tipo'] = $this->{'INPUT_'.$input['tipo']}($input);
        return $retorno;
    }
    
    private function INPUT_input($input){
        return '<input class="'.$input['class'].'" type="text" name="'.substr($input['referencia'], 1, -1).'"'. (!empty($input['preenchimento'])?' placeholder="'. $input['preenchimento']. '"': ''). '/>';
    }
    
    private function INPUT_textarea($input){
        return '<textarea class="'.$input['class'].'" name="'.substr($input['referencia'], 1, -1).'"'. (!empty($input['preenchimento'])?' placeholder="'. $input['preenchimento']. '"': ''). '></textarea>';
    }
    
    private function INPUT_button($input){
        return '<button class="'.$input['class'].'" type="submit" name="'.substr($input['referencia'], 1, -1).'">'.$input['nome'].'</button>';
    }
    
    public function css(){
        $r = '';
        if(!empty(self::$css)){
            foreach (parent::select('SELECT css FROM '.$this.' WHERE id IN ('. implode(',', self::$css). ')') as $css){
                $r .= $css['css'];
            }
        }
        return $r;
    }
    
    public function emailDados(){
        $dados = parent::select('SELECT nome, Host, SMTPAuth, Port, SMTPSecure, Username, Password FROM '.$this.' WHERE id="'.$this->contatoId.'" LIMIT 1');
        $dados = $dados[0];
        $dados['emails'] = parent::select('SELECT asunto, emisorNome, emisorEmail, destinatarioNome, destinatarioEmail, mensagem FROM '.$this.'_email WHERE contato = "'.$this->contatoId.'"');
        return $dados;
    }
    
    public function procesarShortTegs($texto, $dados){
        return parent::shortTagReplace($texto, $dados);
    }
    
    public function disparar(){

        if(!empty($_POST) && isset($_POST['contato-form']) && $_POST['contato-form'] == $this->contatoId){

            unset($_POST['contato-form']);

            $configContato = $this->emailDados();
    
            require_once SISTEMA. '/api/phpmailer/inicio.php';

            $oks = array();

            foreach ($configContato['emails'] as $email){

                $email['emisorEmail']           = $this->procesarShortTegs($email['emisorEmail'], $_POST);
                $email['emisorNome']            = $this->procesarShortTegs($email['emisorNome'], $_POST);
                $email['destinatarioEmail']     = $this->procesarShortTegs($email['destinatarioEmail'], $_POST);
                $email['destinatarioNome']      = $this->procesarShortTegs($email['destinatarioNome'], $_POST);
                $email['asunto']                = $this->procesarShortTegs($email['asunto'], $_POST);
                $email['mensagem']              = $this->procesarShortTegs($email['mensagem'], $_POST);
                
                $email['destinatario'] = ($email['destinatarioNome']. ' <'. $email['destinatarioEmail']. '>');
                $email['header']['from'] = ($email['emisorNome']. ' <'. $email['emisorEmail']. '>');
                
                $r = pm_mail($email['destinatario'], $email['asunto'], $email['mensagem'], $email['header']);
                
                $oks[] = $r === true? true: false;

            }

            if (!in_array(FALSE, $oks))
                return 'email=ok';
            else
                return 'email=erro';
        
        }else{
            
            return FALSE;
            
        }
        
    }

}

