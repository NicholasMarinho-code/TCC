<?php     
class Usuario {

    private $nome;      
    private $emailCorp;
    private $senha;
        
    public function __construct($nome, $emailCorp, $senha) {
            $this->nome = $nome;
            $this->emailCorp = $emailCorp;
            $this->senha = $senha;
    }
        
    public function getNome() { return $this->nome; }
    public function getEmailCorp() { return $this->emailCorp; }
    public function getSenha() { return $this->senha; }
        
    public function setNome($nome): void { $this->nome = $nome; }
    public function setEmailCorp($emailCorp): void { $this->emailCorp = $emailCorp; }
    public function setSenha($senha): void { $this->senha = $senha; }

    }