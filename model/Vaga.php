<?php

class Vaga
{
    private int $idVaga;
    private int $etapaId;
    private string $cargo;
    private int $empresaId;
    private $requisitos;  // Lista de requisitos para essa vaga
    private $candidaturas;  // Lista de candidaturas feitas para essa vaga

    // Construtor

    public function __construct(
        int $idVaga,
        int $etapaId,
        string $cargo,
        int $empresaId,
    ) {
        $this->idVaga = $idVaga;
        $this->etapaId = $etapaId;
        $this->cargo = $cargo;
        $this->empresaId = $empresaId;
    }

    // Getters e Setters

    public function getIdVaga(): int
    {
        return $this->idVaga;
    }

    public function getEtapaId(): int
    {
        return $this->etapaId;
    }

    public function getCargo(): string
    {
        return $this->cargo;
    }

    public function getEmpresaId(): int
    {
        return $this->empresaId;
    }

    public function addRequisito($requisito)
    {
        $this->requisitos->append($requisito);  // Adiciona requisito à vaga
    }

    public function addCandidatura($candidatura)
    {
        $this->candidaturas->append($candidatura);  // Adiciona candidatura à vaga
    }

    public function getRequisitos()
    {
        return $this->requisitos;
    }

    public function getCandidaturas()
    {
        return $this->candidaturas;
    }
}

?>