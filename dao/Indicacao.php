<?php
    class IndicacaoDAO implements IDAO
    {
        private $conexao;

        public function __construct(PDO $conexao)
        {
            $this->conexao = $conexao;
        }

        public function insert($indicacao)
        {
            $stmt = $this->conexao->prepare("INSERT INTO indicacao (egresso_idEgresso, aluno_idAluno, vaga_idVaga, created_at, status_idStatus) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$indicacao->egresso_idEgresso, $indicacao->aluno_idAluno, $indicacao->vaga_idVaga, $indicacao->created_at->format('Y-m-d H:i:s'), $indicacao->status_idStatus]);
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
