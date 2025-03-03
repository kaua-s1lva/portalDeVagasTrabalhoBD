<?php
namespace app\dao;

use app\singleton\ConexaoSingleton;
use PDO;

class CandidaturaDAO implements IDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    public function insert($candidatura)
    {
        $stmt = $this->conexao->prepare("INSERT INTO candidatura (idVaga, idAluno, curriculo, created_at, situacao) VALUES (?, ?, ?, NOW(), ?)");
        $stmt->execute([$candidatura->getIdVaga(), $candidatura->getIdAluno(), $candidatura->getIdCurriculo(), $candidatura->getIdSituacao()]);
    }

    public function update($candidatura)
    {
        $stmt = $this->conexao->prepare("UPDATE candidatura SET situacao=?, updated_at=NOW() WHERE idVaga=? AND idAluno=?");
        $stmt->execute([$candidatura->situacao, $candidatura->idVaga, $candidatura->idAluno]);
    }

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM candidatura SET deletedAt=NOW() WHERE idVaga=?");
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
