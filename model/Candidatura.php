<?php
class Candidatura
{
    private int $idVaga;
    private int $idAluno;
    private $curriculo;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private DateTime $deletedAt;
    private int $idSituacao;  

    // Construtor
    
    public function __construct(
        int $idVaga,
        int $idAluno,
        $curriculo,
        int $idSituacao
    ) {
        $this->idVaga = $idVaga;
        $this->idAluno = $idAluno;
        $this->curriculo = $curriculo;
        $this->createdAt = new DateTime();
        $this->updatedAt = null;
        $this->deletedAt = null;
        $this->idSituacao = $idSituacao;
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

    public function getidAluno(): int
    {
        return $this->idAluno;
    }

    public function setidAluno(int $idAluno): void
    {
        $this->idAluno = $idAluno;
    }

    public function getCurriculo()
    {
        return $this->curriculo;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getidSituacao(): int
    {
        return $this->idSituacao;
    }

    public function setidSituacao(int $idSituacao): void
    {
        $this->idSituacao = $idSituacao;
    }
}
