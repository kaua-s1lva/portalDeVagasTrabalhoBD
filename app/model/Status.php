<?php
namespace app\model;
class Status
{
    private int $idStatus;
    private string $nome;
    private string $descricao;

    // Construtor
    
    public function __construct(int $idStatus, string $nome, string $descricao)
    {
        $this->idStatus = $idStatus;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    // Getters e Setters
    
    public function getIdStatus(): int
    {
        return $this->idStatus;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }
}

?>
