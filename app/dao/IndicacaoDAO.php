<?php
namespace app\dao;

use app\singleton\ConexaoSingleton;
use PDO;

    class IndicacaoDAO 
    {
        private $conexao;

        public function __construct()
        {
            $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
        }

        public function insert($indicacao)
        {
            $stmt = $this->conexao->prepare("INSERT INTO indicacao (idEgresso, idAluno, idVaga, idStatus) VALUES (?, ?, ?, ?)");
            $stmt->execute([$indicacao->getEgressoIdEgresso(), $indicacao->getAlunoIdAluno(), $indicacao->getVagaIdVaga(), $indicacao->getStatusIdStatus()]);
        }

        public function update($indicacao)
        {
            $stmt = $this->conexao->prepare("UPDATE indicacao SET status_idStatus=?, updated_at=? WHERE egresso_idEgresso=? AND aluno_idAluno=? AND vaga_idVaga=?");
            $stmt->execute([$indicacao->status_idStatus, date('Y-m-d H:i:s'), $indicacao->egresso_idEgresso, $indicacao->aluno_idAluno, $indicacao->vaga_idVaga]);
        }

        public function delete($id)
        {
            $stmt = $this->conexao->prepare("DELETE FROM indicacao WHERE egresso_idEgresso=?");
            $stmt->execute([$id]);
        }

        public function findById($id)
        {
            $stmt = $this->conexao->prepare("SELECT * FROM indicacao WHERE egresso_idEgresso=?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function findAll()
        {
            $stmt = $this->conexao->query("SELECT * FROM indicacao");
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
}
