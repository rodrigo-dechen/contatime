<?php

class contato extends db{
    
    public function __construct() {
        parent::__construct(PREFIXO . 'contato');
    }
    
    public function contatoNovo(){
        parent::insert(array('nome' => 'Novo contato'));
    }
    
    public function contatoDados($id){
        $r = parent::select('SELECT * FROM '.$this.' a WHERE a.id = "'.parent::antiInjection($id).'" LIMIT 1');
        return $r[0];
    }
    
    public function contatoUpdate(array $dados){
        $dados = parent::antiInjection($dados);
        parent::update(array(
            'id'            => $dados['id'],
            'nome'          => $dados['nome'],
            'Host'          => $dados['Host'],
            'SMTPAuth'      => (isset($dados['SMTPAuth'])? $dados['SMTPAuth']: 'false'),
            'Port'          => (!empty($dados['Port'])? $dados['Port']: NULL),
            'SMTPSecure'    => ($dados['SMTPSecure'] != 'null' ? $dados['SMTPSecure']: NULL),
            'Username'      => $dados['Username'],
            'Password'      => $dados['Password'],
            'form'          => $dados['form'],
            'css'           => $dados['css']
        ),  'id="[id]"');
    }
    
    public function listaDeInputs($contatoId){
        $contatoId = parent::antiInjection($contatoId);
        global $_ll;
        $r = '';
        foreach (parent::select('SELECT a.id, a.nome FROM '.$this.'_input a WHERE a.contato = "'.$contatoId.'"') as $input){
           $r .= '<li><a class="input-name-'.$input['id'].'" href="'.$_ll['app']['onclient'].'&p=input&id='.$input['id'].'">'.$input['nome'].'</a></li>';
        }
        return $r;
    }
    
    public function inputDados($id){
        $r = parent::select('SELECT a.id, a.contato, a.nome, a.preenchimento, a.tipo, a.referencia, a.class FROM '.$this.'_input a WHERE a.id = "'.parent::antiInjection($id).'" LIMIT 1');
        return $r[0];
    }
    
    public function inputNovo($contatoId){
        $contatoId = parent::antiInjection($contatoId);
        parent::setTempPosFix('_input')->insert(array('contato' => $contatoId, 'nome' => 'Novo Input', 'referencia' => $this->referenciaLivre($contatoId, 'novo-input')));
        return parent::insert_id();
    }
    
    public function atualizaNome($id, $nomeNovo){
        $id = parent::antiInjection($id);
        $nomeNovo = parent::antiInjection($nomeNovo);
        parent::setTempPosFix('_input');
        $contato = parent::select('SELECT a.contato FROM '.$this.' a WHERE a.id = "'.$id.'"', TRUE);
        $referencia = $this->referenciaLivre($contato[0]['contato'], $nomeNovo, $id);
        $retorno = array('id' => $id, 'nome' => $nomeNovo, 'referencia' => $referencia);
        parent::update($retorno, 'id="[id]"');
        return $retorno;
    }

    private function referenciaLivre($contatoId, $referencia, $inputId = null, $id = 0){
        $procurar = '['. jf_urlformat($referencia). (++$id > 1? '-'.$id: ''). ']';
        $r = parent::select('SELECT COUNT(*) as total FROM '.$this.' a WHERE '.($inputId !== null? 'a.id != "'.$inputId.'" and ': '').'a.contato = "'.$contatoId.'" and a.referencia = "'.$procurar.'"', true);
        if(isset($r[0]['total']) and $r[0]['total'] >= 1){
            return $this->referenciaLivre($contatoId, $referencia, $inputId, $id);
        }else{
            return $procurar;
        }
	}
    
    public function atualizaPreenchimento($id, $preenchimento){
        $id = parent::antiInjection($id);
        $preenchimento = parent::antiInjection($preenchimento);
        parent::setTempPosFix('_input')->update(array('id' => $id, 'preenchimento' => $preenchimento), 'id="[id]"');
    }

    public function atualizaClass($id, $class){
        $id = parent::antiInjection($id);
        $nomeNovo = parent::antiInjection($nomeNovo);
        parent::setTempPosFix('_input')->update(array('id' => $id, 'class' => $class), 'id="[id]"');
    }

    public function atualizaTipo($id, $tipo){
        $id = parent::antiInjection($id);
        $nomeNovo = parent::antiInjection($nomeNovo);
        parent::setTempPosFix('_input')->update(array('id' =>$id, 'tipo' => $tipo), 'id="[id]"');
    }
    
    public function deletaInput($id){
        parent::setTempPosFix('_input')->delite(array('id' => parent::antiInjection($id)), 'id="[id]"');
    }
    
    public function emailLista($contatoId){
        $contatoId = parent::antiInjection($contatoId);
        global $_ll;
        $r = '';
        foreach (parent::select('SELECT a.id, a.asunto FROM '.$this.'_email a WHERE a.contato = "'.$contatoId.'"') as $email){
           $r .= '<li><a class="email-name-'.$email['id'].'" href="'.$_ll['app']['onclient'].'&p=email&id='.$email['id'].'">'.$email['asunto'].'</a></li>';
        }
        return $r;
    }
    
    public function emailNovo($contatoId){
        $contatoId = parent::antiInjection($contatoId);
        parent::setTempPosFix('_email')->insert(array('contato' => $contatoId, 'asunto' => 'Novo e-mail'));
        return parent::insert_id();
    }
    
    public function emailDados($id){
        $r = parent::select('SELECT * FROM '.$this.'_email a WHERE a.id = "'.parent::antiInjection($id).'" LIMIT 1');
        return $r[0];
    }
    
    public function emailDeleta($id){
        parent::setTempPosFix('_email')->delite(array('id' => parent::antiInjection($id)), 'id="[id]"');
    }
    
    public function emailUpdate(array $dados){
        $dados = parent::antiInjection($dados);
        parent::setTempPosFix('_email')->update(array(
            'id'                    => $dados['id'],
            'asunto'                => $dados['asunto'],
            'emisorNome'            => $dados['emisorNome'],
            'emisorEmail'           => $dados['emisorEmail'],
            'destinatarioNome'      => $dados['destinatarioNome'],
            'destinatarioEmail'     => $dados['destinatarioEmail'],
            'mensagem'              => $dados['mensagem']
        ),  'id="[id]"');
    }

}
