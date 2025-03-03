<?php
namespace app\model;
class Etapa
{
    private int $idEtapa;
    private string $nome;
    private string $descricao;

    public function __construct(int $idEtapa, string $nome, string $descricao)
    {
        $this->idEtapa = $idEtapa;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    public function getIdEtapa() : int
    {
        return $this->idEtapa;
    }
    public function getNome() : string
    {
        return $this->nome;
    }
    public function getDescricao() : string
    {
        return $this->descricao;
    }
}

?>