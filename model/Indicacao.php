<?php

class Indicacao
{
    private int $idAluno;
    private int $idEgresso;
    private int $idVaga;
    private DateTime $created_at;
    private DateTime $updated_at;
    private DateTime $deleted_at;
    private int $idStatus;

    // Construtor

    public function __construct($idAluno, $idEgresso, $idVaga, $idStatus)
    {
        $this->idAluno = $idAluno;
        $this->idEgresso = $idEgresso;
        $this->idVaga = $idVaga;
        $this->created_at = new DateTime();
        $this->updated_at = null;
        $this->deleted_at = null;
        $this->idStatus = $idStatus;
    }

    // Getters e Setters

    public function getAlunoIdAluno() : int
    {
        return $this->idAluno;
    }

    public function setAlunoIdAluno($idAluno) : void
    {
        $this->idAluno = $idAluno;
    }

    public function getEgressoIdEgresso() : int
    {
        return $this->idEgresso;
    }

    public function setEgressoIdEgresso($idEgresso) : void
    {
        $this->idEgresso = $idEgresso;
    }

    public function getVagaIdVaga() : int
    {
        return $this->idVaga;
    }

    public function setVagaIdVaga($idVaga) : void
    {
        $this->idVaga = $idVaga;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?DateTime $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    public function getStatusIdStatus() : int
    {
        return $this->idStatus;
    }

    public function setStatusIdStatus($idStatus) : void
    {
        $this->idStatus = $idStatus;
    }
}
