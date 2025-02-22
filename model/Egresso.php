<?php

class Egresso extends Usuario
{
    private string $cpf;
    private int $idEmpresa;
    private $indicacoes;  // Lista de indicações feitas por este egresso

    // Construtor

    public function __construct(
        int $idUsuario,
        string $nome,
        string $email,
        string $senha,
        string $cpf,
        int $idEmpresa
    ) {
        parent::__construct($idUsuario, $nome, $email, $senha);
        $this->cpf = $cpf;
        $this->idEmpresa = $idEmpresa;
        $this->indicacoes = new ArrayObject();  // Lista de indicações feitas pelo egresso
    }

    // Getters e Setters

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function getIdEmpresa(): int
    {
        return $this->idEmpresa;
    }

    public function setIdEmpresa(int $idEmpresa): void
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function addIndicacao($indicacao)
    {
        $this->indicacoes->append($indicacao);  // Adiciona uma indicação
    }

    public function getIndicacoes()
    {
        return $this->indicacoes;
    }
}
