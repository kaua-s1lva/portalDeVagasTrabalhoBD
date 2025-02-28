<?php

abstract class Usuario {
    private int $idUsuario;
    private string $nome;
    private string $email;
    private string $senha;

    // Construtor

    public function __construct(
        int $idUsuario,
        string $nome,
        string $email,
        string $senha,
    ) {
        $this->idUsuario = $idUsuario;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    // Getters e Setters
    
    public function getIdUsuario(): int {
        return $this->idUsuario;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getSenha(): string {
        return $this->senha;
    }
    
}

?>