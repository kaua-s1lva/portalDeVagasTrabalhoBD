<?php

namespace app\dao;

use app\dao\IDAO;
use app\model\Etapa;
use app\singleton\ConexaoSingleton;
use PDO;

class EtapaDAO implements IEtapaDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    /**
     * @Override
     */

    public function insert($etapa) {}

    /**
     * @Override
     */

    public function delete($idEtapa) {}

    /**
     * @Override
     */

    public function update($etapa) {}

    /**
     * @Override
     */

    public function findById($id)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM etapa WHERE idetapa=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Etapa($row['idetapa'], $row['nomeetapa'], $row['descricaoetapa']) : null;
    }

    /**
     * @Override
     */

    public function findAll() {}
}
