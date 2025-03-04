<?php

namespace app\dao;

use app\dao\IDAO;
use app\model\Etapa;
use app\singleton\ConexaoSingleton;
use PDO;

class EtapaDAO implements IDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    public function insert($etapa) {}
    public function delete($idEtapa) {}
    public function update($etapa) {}

    public function findById($id)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM etapa WHERE idetapa=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Etapa($row['idetapa'], $row['nomeetapa'], $row['descricaoetapa']) : null;
    }

    public function findAll() {}
}
