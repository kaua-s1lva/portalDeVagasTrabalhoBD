<?php

class Situacao
{
    private int $idSituacao;
    private string $nome;
    private string $descricao;

    public function __construct($idSituacao, $nome, $descricao)
    {
        $this->idSituacao = $idSituacao;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    public function getIdSituacao(): int {
        return $this->idSituacao;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }
}


