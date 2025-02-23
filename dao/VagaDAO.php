<?php

class VagaDAO implements IDAO
{
    protected $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
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
        $stmt = $this->conexao->prepare("SELECT * FROM vagas WHERE id_vaga=? AND deleted_at IS NULL");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Vaga($row['id_vaga'], $row['etapa_id'], $row['cargo'], $row['empresa_id']) : null;
    }

    public function findAll()
    {
        $stmt = $this->conexao->query("SELECT * FROM vagas WHERE deleted_at IS NULL");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $vagas = [];
        foreach ($result as $row) {
            $vagas[] = new Vaga($row['id_vaga'], $row['etapa_id'], $row['cargo'], $row['empresa_id']);
        }
        return $vagas;
    }
}
