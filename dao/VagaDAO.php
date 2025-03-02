<?php

require_once('../singleton/ConexaoSingleton.php');

class VagaDAO implements IDAO
{
    protected $conexao;

    public function __construct( )
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    public function insert($vaga)
    {
        $stmt = $this->conexao->prepare("INSERT INTO vagas (etapa_id, cargo, empresa_id, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$vaga->getEtapaId(), $vaga->getCargo(), $vaga->getEmpresaId()]);
        return $this->conexao->lastInsertId();
    }

    public function update($vaga)
    {
        $stmt = $this->conexao->prepare("UPDATE vagas SET etapa_id=?, cargo=?, empresa_id=?, updated_at=NOW() WHERE id_vaga=?");
        $stmt->execute([$vaga->getEtapaId(), $vaga->getCargo(), $vaga->getEmpresaId(), $vaga->getIdVaga()]);
    }

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("UPDATE vagas SET deleted_at=NOW() WHERE id_vaga=?");
        $stmt->execute([$id]);
    }

    public function findById($id)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM vagas WHERE id_vaga=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Vaga($row['id_vaga'], $row['etapa_id'], $row['cargo'], $row['empresa_id']) : null;
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
}
