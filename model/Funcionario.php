<?php

require_once 'Usuario.php';

class Funcionario extends Usuario {

    private $numCodFunc;

    public function __construct($numCodFunc, $nome, $emailCorp, $senha) {
        parent::__construct($nome, $emailCorp, $senha);
        $this->numCodFunc = $numCodFunc;
    }

    public function getNumCodFunc() {
        return $this->numCodFunc;
    }

    public function setNumCodFunc($numCodFunc): void {
        $this->numCodFunc = $numCodFunc;
    }

    public function logar() { echo "O funcionario {$this->getNome()} está logando<br>"; }
    public function monitorar() { echo "O funcionario {$this->getNome()} está monitorando<br>"; }

}