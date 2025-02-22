<?php
class Candidatura
{
    private int $idVaga;
    private int $alunoId;
    private $curriculo;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;
    private ?DateTime $deletedAt;
    private int $situacaoId;
    private $situacao;  // Status da candidatura (pode ser um Map associando status a detalhes)

    // Construtor
    
    public function __construct(
        int $idVaga,
        int $alunoId,
        $curriculo,
        DateTime   $createdAt,
        ?DateTime  $updatedAt = null,
        ?DateTime  $deletedAt = null,
        int $situacaoId
    ) {
        $this->idVaga = $idVaga;
        $this->alunoId = $alunoId;
        $this->curriculo = $curriculo;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->situacaoId = $situacaoId;
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

    public function getAlunoId(): int
    {
        return $this->alunoId;
    }

    public function setAlunoId(int $alunoId): void
    {
        $this->alunoId = $alunoId;
    }

    public function getCurriculo()
    {
        return $this->curriculo;
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

    public function getSituacaoId(): int
    {
        return $this->situacaoId;
    }

    public function setSituacaoId(int $situacaoId): void
    {
        $this->situacaoId = $situacaoId;
    }
}
