<?php
namespace app\model;

use ArrayObject;

class Requisito
{
    private int $idRequisito;
    private string $nome;
    private string $duracao;
    private $vagas;

    // Construtor
    
    public function __construct(int $idRequisito, string $nome, string $duracao)
    {
        $this->idRequisito = $idRequisito;
        $this->nome = $nome;
        $this->duracao = $duracao;
        $this->vagas = new ArrayObject();
    }

    // Getters e Setters

    public function getIdRequisito(): int
    {
        return $this->idRequisito;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDuracao(): string
    {
        return $this->duracao;
    }

    public function getVagas()
    {
        return $this->vagas;
    }

    public function addVaga($vaga) {
        $this->vagas->append($vaga);  
    }

}

?>
