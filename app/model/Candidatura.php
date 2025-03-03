<?php
namespace app\model;
class Candidatura
{
    private int $idVaga;
    private int $idAluno;
    private $curriculo;
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

    public function getidSituacao(): int
    {
        return $this->idSituacao;
    }

    public function setidSituacao(int $idSituacao): void
    {
        $this->idSituacao = $idSituacao;
    }
}

?>
