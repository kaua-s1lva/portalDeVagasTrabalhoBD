<?php

class Aluno extends Usuario {
    private string $cpf;

    // Construtor
    
    public function __construct(
        int $idUsuario,
        string $nome,
        string $email,
        string $senha,
        string $cpf,
    ) {
        parent::__construct($idUsuario, $nome, $email, $senha);
        $this->cpf = $cpf;
    }

    // Getters

    public function getCpf(): string {
        return $this->cpf;
    }
}

?>