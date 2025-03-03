<?php
namespace app\model;
class Indicacao
{
    private int $idAluno;
    private int $idEgresso;
    private int $idVaga;
    private int $idStatus;

    // Construtor

    public function __construct($idAluno, $idEgresso, $idVaga, $idStatus)
    {
        $this->idAluno = $idAluno;
        $this->idEgresso = $idEgresso;
        $this->idVaga = $idVaga;
        $this->idStatus = $idStatus;
    }

    // Getters e Setters

    public function getAlunoIdAluno() : int
    {
        return $this->idAluno;
    }

    public function getEgressoIdEgresso() : int
    {
        return $this->idEgresso;
    }

    public function getVagaIdVaga() : int
    {
        return $this->idVaga;
    }

    public function getStatusIdStatus() : int
    {
        return $this->idStatus;
    }

}

?>
