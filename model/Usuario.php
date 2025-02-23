<?php

abstract class Usuario {
    private int $idUsuario;
    private string $nome;
    private string $email;
    private string $senha;
    private DateTime $created_at;
    private DateTime $updated_at;  
    private DateTime $deleted_at;  

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
        $this->created_at = new DateTime();  
        $this->updated_at = null;
        $this->deleted_at = null;
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

    public function getCreatedAt(): DateTime {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): DateTime {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at): void {
        $this->updated_at = $updated_at;
    }

    public function getDeletedAt(): ?DateTime {
        return $this->deleted_at;
    }

    public function setDeletedAt(DateTime $deleted_at): void {
        $this->deleted_at = $deleted_at;
    }
    
}

?>