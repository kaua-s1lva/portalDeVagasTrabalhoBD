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
        $stmt = $this->conexao->prepare(
            "INSERT INTO candidatura (idVaga, idAluno, curriculo, created_at, idsituacao)
            VALUES (?, ?, ?, NOW(), ?)"
        );
        
        $stmt->bindValue(1, $candidatura->getIdVaga(), PDO::PARAM_INT);
        $stmt->bindValue(2, $candidatura->getIdAluno(), PDO::PARAM_INT);
        $stmt->bindValue(3, $candidatura->getCurriculo(), PDO::PARAM_LOB);
        $stmt->bindValue(4, $candidatura->getIdSituacao(), PDO::PARAM_INT);
        
        $stmt->execute();
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
