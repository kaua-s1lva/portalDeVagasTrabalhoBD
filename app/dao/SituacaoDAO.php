<?php
namespace app\dao;

use app\singleton\ConexaoSingleton;
use PDO;

    class SituacaoDAO implements IDAO
    {
        private $conexao;

        public function __construct()
        {
            $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
        }

        public function insert($situacao)
        {
            $stmt = $this->conexao->prepare("INSERT INTO situacao (nome, descricao) VALUES (?, ?)");
            $stmt->execute([$situacao->nome, $situacao->descricao]);
        }

        public function update($situacao)
        {
            $stmt = $this->conexao->prepare("UPDATE situacao SET nome=?, descricao=? WHERE idSituacao=?");
            $stmt->execute([$situacao->nome, $situacao->descricao, $situacao->idSituacao]);
        }

        public function delete($id)
        {
            $stmt = $this->conexao->prepare("DELETE FROM situacao WHERE idSituacao=?");
            $stmt->execute([$id]);
        }

        public function findById($id)
        {
            $stmt = $this->conexao->prepare("SELECT * FROM situacao WHERE idSituacao=?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function findAll()
        {
            $stmt = $this->conexao->query("SELECT * FROM situacao");
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
}
