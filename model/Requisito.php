<?php

class Requisito
{
    private int $idRequisito;
    private string $nome;
    private ?string $duracao;

    // Construtor
    
    public function __construct(int $idRequisito, string $nome, ?string $duracao = null)
    {
        $this->idRequisito = $idRequisito;
        $this->nome = $nome;
        $this->duracao = $duracao;
    }

    // Getters e Setters

    public function getIdRequisito(): int
    {
        return $this->idRequisito;
    }

    public function setIdRequisito(int $idRequisito): void
    {
        $this->idRequisito = $idRequisito;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDuracao(): ?string
    {
        return $this->duracao;
    }
}
