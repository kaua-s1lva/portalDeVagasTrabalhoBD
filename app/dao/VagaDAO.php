<?php

namespace app\dao;

use app\dao\IDAO;
use app\model\Vaga;
use app\singleton\ConexaoSingleton;
use PDO;
use PDOException;

class VagaDAO implements IVagaDAO
{
    protected $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    /**
     * @Override
     */

    public function insert($vaga)
    {
        $stmt = $this->conexao->prepare("INSERT INTO vaga (idetapa, cargo, idempresa) VALUES (?, ?, ?)");
        $stmt->execute([$vaga->getEtapaId(), $vaga->getCargo(), $vaga->getEmpresaId()]);
        return $this->conexao->lastInsertId();
    }

    /**
     * @Override
     */

    public function update($vaga)
    {
        $stmt = $this->conexao->prepare("UPDATE vaga SET idetapa=?, cargo=?, idempresa=?, updated_at=NOW() WHERE idvaga=?");
        $stmt->execute([$vaga->getEtapaId(), $vaga->getCargo(), $vaga->getEmpresaId(), $vaga->getIdVaga()]);
        return $stmt->rowCount() > 0;
    }

    /**
     * @Override
     */

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM vaga WHERE idvaga=?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * @Override
     */

    public function findById($id)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM vaga WHERE idvaga=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Vaga($row['idvaga'], $row['idetapa'], $row['cargo'], $row['idempresa']) : null;
    }

    public function findByIdFiltered($idVaga)
    {
        $stmtVaga = $this->conexao->prepare("
        SELECT v.idVaga AS idvaga, v.cargo, e.nomeEtapa AS nome_etapa
        FROM VAGA v
        INNER JOIN ETAPA e ON v.idEtapa = e.idEtapa
        WHERE v.idVaga = ?
    ");
        $stmtVaga->execute([$idVaga]);
        $vaga = $stmtVaga->fetch(PDO::FETCH_ASSOC);

        return $vaga;
    }


    /**
     * @Override
     */

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

    public function findAllFiltered($empresa_id)
    {
        try {
            // Consulta as vagas, status da vaga e o total de inscrições (COUNT) para cada vaga
            $stmt = $this->conexao->prepare("
            SELECT 
                v.idvaga, 
                v.cargo, 
                e.nomeetapa AS nome_etapa,  -- Agora estamos pegando o status da tabela etapa
                COUNT(c.idvaga) AS total_inscricoes
            FROM vaga v
            LEFT JOIN candidatura c ON c.idvaga = v.idvaga
            LEFT JOIN etapa e ON e.idetapa = v.idetapa  -- Fazendo o JOIN correto com a tabela etapa
            WHERE v.idempresa = ?
            GROUP BY v.idvaga, e.idetapa
        ");
            $stmt->execute([$empresa_id]);
            $vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
        return $vagas;
    }

    /**
     * @Override
     */

    public function findAllByIdEmpresa($id)
    {
        $stmt = $this->conexao->prepare(
            "   SELECT * FROM vaga 
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
