<?php
namespace app\dao;

use app\model\Requisito;
use app\singleton\ConexaoSingleton;
use PDO;


class RequisitoDAO implements IDAO
{
    protected $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    public function insert($requisito)
    {
        $stmt = $this->conexao->prepare("INSERT INTO requisito (nome, duracao) VALUES (?, ?)");
        $stmt->execute([$requisito->getNome(), $requisito->getDuracao()]);
    }

    public function update($requisito)
    {
        $stmt = $this->conexao->prepare("UPDATE requisito SET nome=?, duracao=? WHERE idRequisito=?");
        $stmt->execute([$requisito->getNome(), $requisito->getDuracao(), $requisito->getIdRequisito()]);
    }

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM requisito WHERE idRequisito=?");
        $stmt->execute([$id]);
    }

    public function findById($id)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM requisito WHERE idRequisito=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new Requisito($result['idRequisito'], $result['nome'], $result['duracao']) : null;
    }

    public function findAll()
    {
        $stmt = $this->conexao->query("SELECT * FROM requisito");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $requisitos = [];
        foreach ($result as $row) {
            $requisitos[] = new Requisito($row['idRequisito'], $row['nome'], $row['duracao']);
        }
        return $requisitos;
    }
}
