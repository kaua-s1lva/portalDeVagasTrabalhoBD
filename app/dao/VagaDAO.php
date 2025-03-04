<?php
namespace app\dao;

use app\dao\IDAO;
use app\model\Vaga;
use app\singleton\ConexaoSingleton;
use PDO;

class VagaDAO implements IDAO
{
    protected $conexao;

    public function __construct( )
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    public function insert($vaga)
    {
        $stmt = $this->conexao->prepare("INSERT INTO vaga (idetapa, cargo, idempresa) VALUES (?, ?, ?)");
        $stmt->execute([$vaga->getEtapaId(), $vaga->getCargo(), $vaga->getEmpresaId()]);
        return $this->conexao->lastInsertId();
    }

    public function update($vaga)
    {
        $stmt = $this->conexao->prepare("UPDATE vaga SET idetapa=?, cargo=?, idempresa=?, updated_at=NOW() WHERE idvaga=?");
        $stmt->execute([$vaga->getEtapaId(), $vaga->getCargo(), $vaga->getEmpresaId(), $vaga->getIdVaga()]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM vaga WHERE idvaga=?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function findById($id)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM vaga WHERE idvaga=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Vaga($row['idvaga'], $row['idetapa'], $row['cargo'], $row['idempresa']) : null;
    }

    public function findAll()
    {
        $stmt = $this->conexao->query(" SELECT * FROM vaga 
                                        INNER JOIN empresa ON empresa.idempresa = vaga.idempresa
                                        INNER JOIN usuario ON usuario.idusuario = empresa.idempresa
                                    ");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dados = [];
        foreach ($result as $row) {
            $dados[] = [
                'vaga' => [
                    'idvaga' => $row['idvaga'],
                    'idetapa' => $row['idetapa'],
                    'cargo' => $row['cargo'],
                    'idempresa' => $row['idempresa']
                ],
                'empresa' => [
                    'idempresa' => $row['idempresa'],
                    'cnpj' => $row['cnpj']
                ],
                'usuario' => [
                    'idusuario' => $row['idusuario'],
                    'nomeusuario' => $row['nomeusuario'],
                    'emailusuario' => $row['emailusuario'],
                    'senhausuario' => $row['senhausuario']
                ]
            ];
        }
        return $dados;
    }

    public function findAllByIdEmpresa($id)
    {
        $stmt = $this->conexao->prepare("   SELECT * FROM vaga 
                                            INNER JOIN empresa ON empresa.idempresa = vaga.idempresa
                                            INNER JOIN usuario ON usuario.idusuario = empresa.idempresa
                                            WHERE empresa.idempresa = ?"
                                        );
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dados = [];
        foreach ($result as $row) {
            $dados[] = [
                'vaga' => [
                    'idvaga' => $row['idvaga'],
                    'idetapa' => $row['idetapa'],
                    'cargo' => $row['cargo'],
                    'idempresa' => $row['idempresa']
                ],
                'empresa' => [
                    'idempresa' => $row['idempresa'],
                    'cnpj' => $row['cnpj']
                ],
                'usuario' => [
                    'idusuario' => $row['idusuario'],
                    'nomeusuario' => $row['nomeusuario'],
                    'emailusuario' => $row['emailusuario'],
                    'senhausuario' => $row['senhausuario']
                ]
            ];
        }
        return $dados;
    }
}
