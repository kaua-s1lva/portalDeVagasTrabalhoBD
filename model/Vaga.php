<?php

class Vaga
{
    private int $idVaga;
    private int $etapaId;
    private string $cargo;
    private int $empresaId;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;
    private ?DateTime $deletedAt;
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
        $this->createdAt = new DateTime();
        $this->updatedAt = null;
        $this->deletedAt = null;
    }

    // Getters e Setters

    public function getIdVaga(): int
    {
        return $this->idVaga;
    }

    public function setIdVaga(int $idVaga): void
    {
        $this->idVaga = $idVaga;
    }

    public function getEtapaId(): int
    {
        return $this->etapaId;
    }

    public function setEtapaId(int $etapaId): void
    {
        $this->etapaId = $etapaId;
    }

    public function getCargo(): string
    {
        return $this->cargo;
    }

    public function getEmpresaId(): int
    {
        return $this->empresaId;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
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