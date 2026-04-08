<?php

require_once 'Usuario.php';

class Gerente extends Usuario{

    private $numCodGerente;
    public function __construct($nome, $emailCorp, $senha, $numCodGerente) {
        parent::__construct($nome, $emailCorp, $senha); 
        $this->numCodGerente = $numCodGerente;
    }
	public function getNumCodGerente() {return $this->numCodGerente;}

	public function setNumCodGerente( $numCodGerente): void {$this->numCodGerente = $numCodGerente;}

    public function cadastrar() { echo "O gerente {$this->getNome()} está cadastrando<br>"; }
    public function logar() { echo "O gerente {$this->getNome()} está logando<br>"; }
    public function alterar() { echo "O gerente {$this->getNome()} está alterando o cadastro<br>"; }
    public function deletar() { echo "O gerente {$this->getNome()} está deletando o cadastro<br>"; }
    public function adicionar() { echo "O gerente {$this->getNome()} está adicionando o cadastro<br>"; }
    public function monitorar() { echo "O gerente {$this->getNome()} está monitorando<br>"; }

}