<?php

namespace app\dao;

use app\singleton\ConexaoSingleton;
use PDO;

class IndicacaoDAO implements IIndicacaoDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    /**
     * @Override
     */

    public function insert($indicacao)
    {
        $stmt = $this->conexao->prepare("INSERT INTO indicacao (idEgresso, idAluno, idVaga, idStatus) VALUES (?, ?, ?, ?)");
        $stmt->execute([$indicacao->getEgressoIdEgresso(), $indicacao->getAlunoIdAluno(), $indicacao->getVagaIdVaga(), $indicacao->getStatusIdStatus()]);
    }

    /**
     * @Override
     */

    public function update($indicacao)
    {
        $stmt = $this->conexao->prepare("UPDATE indicacao SET status_idStatus=?, updated_at=? WHERE egresso_idEgresso=? AND aluno_idAluno=? AND vaga_idVaga=?");
        $stmt->execute([$indicacao->status_idStatus, date('Y-m-d H:i:s'), $indicacao->egresso_idEgresso, $indicacao->aluno_idAluno, $indicacao->vaga_idVaga]);
    }

    /**
     * @Override
     */

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM indicacao WHERE egresso_idEgresso=?");
        $stmt->execute([$id]);
    }

    /**
     * @Override
     */

    public function findById($id)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM indicacao WHERE egresso_idEgresso=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @Override
     */

    public function findAll()
    {
        $stmt = $this->conexao->query("SELECT * FROM indicacao");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
