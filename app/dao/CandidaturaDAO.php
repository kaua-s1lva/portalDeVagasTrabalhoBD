<?php

namespace app\dao;

use app\singleton\ConexaoSingleton;
use PDO;

class CandidaturaDAO implements ICandidaturaDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    /**
     * @Override
     */

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

    /**
     * @Override
     */

    public function update($candidatura)
    {
        $stmt = $this->conexao->prepare("UPDATE candidatura SET situacao=?, updated_at=NOW() WHERE idVaga=? AND idAluno=?");
        $stmt->execute([$candidatura->situacao, $candidatura->idVaga, $candidatura->idAluno]);
    }

    /**
     * @Override
     */

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM candidatura SET deletedAt=NOW() WHERE idVaga=?");
        $stmt->execute([$id]);
    }

    /**
     * @Override
     */

    public function findById($idVaga, $idAluno)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM candidatura WHERE idVaga=? AND idAluno=?");
        $stmt->execute([$idVaga, $idAluno]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @Override
     */

    public function findByIdAluno($idAluno)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM candidatura WHERE idAluno=?");
        $stmt->execute([$idAluno]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findCurriculoByIdAlunoVaga($idCandidato, $idVaga)
    {
        $stmt = $this->conexao->prepare("SELECT curriculo FROM CANDIDATURA WHERE idAluno = ? AND idVaga = ?");
        $stmt->execute([$idCandidato, $idVaga]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @Override
     */

    public function findAll()
    {
        $stmt = $this->conexao->query("SELECT * FROM candidatura");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllFiltered($idVaga)
    {
        // Busca candidatos da vaga
        $stmtCandidatos = $this->conexao->prepare("
                SELECT 
                    u.idUsuario AS id_candidato,
                    u.nomeUsuario AS nome_candidato,
                    CASE WHEN i.idEgresso IS NOT NULL THEN 1 ELSE 0 END AS tem_indicacao,
                    eu.nomeUsuario AS nome_egresso_indicador,
                    s.nomeStatus AS status_candidatura,
                    c.curriculo AS curriculo
                FROM CANDIDATURA c
                INNER JOIN USUARIO u ON c.idAluno = u.idUsuario
                LEFT JOIN INDICACAO i ON c.idAluno = i.idAluno AND c.idVaga = i.idVaga
                LEFT JOIN USUARIO eu ON i.idEgresso = eu.idUsuario
                LEFT JOIN STATUS s ON i.idStatus = s.idStatus
                WHERE c.idVaga = ?
            ");
        $stmtCandidatos->execute([$idVaga]);
        $candidatos = $stmtCandidatos->fetchAll(PDO::FETCH_ASSOC);
        return $candidatos;
    }
}
