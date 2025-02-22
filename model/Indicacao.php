<?php

class Indicacao
{
    private int $aluno_idAluno;
    private int $egresso_idEgresso;
    private int $vaga_idVaga;
    private DateTime $created_at;
    private ?DateTime $updated_at;
    private ?DateTime $deleted_at;
    private int $status_idStatus;

    // Construtor

    public function __construct($aluno_idAluno, $egresso_idEgresso, $vaga_idVaga, $status_idStatus)
    {
        $this->aluno_idAluno = $aluno_idAluno;
        $this->egresso_idEgresso = $egresso_idEgresso;
        $this->vaga_idVaga = $vaga_idVaga;
        $this->created_at = new DateTime();
        $this->updated_at = null;
        $this->deleted_at = null;
        $this->status_idStatus = $status_idStatus;
    }

    // Getters e Setters

    public function getAlunoIdAluno() : int
    {
        return $this->aluno_idAluno;
    }

    public function setAlunoIdAluno($aluno_idAluno) : void
    {
        $this->aluno_idAluno = $aluno_idAluno;
    }

    public function getEgressoIdEgresso() : int
    {
        return $this->egresso_idEgresso;
    }

    public function setEgressoIdEgresso($egresso_idEgresso) : void
    {
        $this->egresso_idEgresso = $egresso_idEgresso;
    }

    public function getVagaIdVaga() : int
    {
        return $this->vaga_idVaga;
    }

    public function setVagaIdVaga($vaga_idVaga) : void
    {
        $this->vaga_idVaga = $vaga_idVaga;
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
        return $this->status_idStatus;
    }

    public function setStatusIdStatus($status_idStatus) : void
    {
        $this->status_idStatus = $status_idStatus;
    }
}
