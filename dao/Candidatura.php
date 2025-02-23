<?php

class CandidaturaDAO implements IDAO
{
    private $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function insert($candidatura)
    {
        $stmt = $this->conexao->prepare("INSERT INTO candidatura (idVaga, idAluno, curriculo, created_at, situacao) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$candidatura->idVaga, $candidatura->idAluno, $candidatura->curriculo, $candidatura->created_at->format('Y-m-d H:i:s'), $candidatura->situacao]);
    }

    public function update($candidatura)
    {
        $stmt = $this->conexao->prepare("UPDATE candidatura SET situacao=?, updated_at=? WHERE idVaga=? AND idAluno=?");
        $stmt->execute([$candidatura->situacao, date('Y-m-d H:i:s'), $candidatura->idVaga, $candidatura->idAluno]);
    }

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM candidatura WHERE idVaga=?");
        $stmt->execute([$id]);
    }

    public function findById($id)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM candidatura WHERE idVaga=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findAll()
    {
        $stmt = $this->conexao->query("SELECT * FROM candidatura");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
