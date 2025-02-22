<?php

class Empresa extends Usuario {
    private string $cnpj;
    private $usuarios;
    private $vagas;

    // Construtor
    
    public function __construct(
        int $idUsuario,
        string $nome,
        string $email,
        string $senha,
        string $cnpj,
    ) {
        parent::__construct($idUsuario, $nome, $email, $senha);
        $this->cnpj = $cnpj;
    }

    // Getters e Setters

    public function getCnpj(): string {
        return $this->cnpj;
    }

    public function getUsuarios() {
        return $this->usuarios;
    }

    public function getVagas() {
        return $this->vagas;
    }

    public function addUsuario($usuario) {
        $this->usuarios->append($usuario);  // Adiciona usuario na lista de usuarios da empresa
    }

    public function addVaga($vaga) {
        $this->vagas->append($vaga);  // Adiciona vaga na lista de vagas da empresa
    }

}

?>