<?php
class EgressoDAO extends UsuarioDAO
{
    public function insert($egresso)
    {
        $idUsuario = parent::insert($egresso);
        $stmt = $this->conexao->prepare("INSERT INTO egresso (idEgresso, idEmpresa, cpf) VALUES (?, ?, ?)");
        $stmt->execute([$idUsuario, $egresso->idEmpresa, $egresso->cpf]);
    }

    public function update($egresso)
    {
        parent::update($egresso);
        $stmt = $this->conexao->prepare("UPDATE egresso SET cpf=? WHERE idEgresso=?");
        $stmt->execute([$egresso->cpf, $egresso->idUsuario]);
    }

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM egresso WHERE idEgresso=?");
        $stmt->execute([$id]);
        parent::delete($id);
    }

    public function findById($id)
    {
        $usuario = parent::findById($id);
        if ($usuario) {
            $stmt = $this->conexao->prepare("SELECT * FROM egresso WHERE idEgresso=?");
            $stmt->execute([$id]);
            $egresso = $stmt->fetchAll(PDO::FETCH_OBJ);
            return array_merge($usuario, $egresso);
        }
        return [];
    }

    public function findByEmail($email)
    {
        $stmt = $this->conexao->prepare("SELECT u.*, eg.registro FROM usuario u JOIN egresso eg ON u.idUsuario = eg.idEgresso WHERE u.email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new Egresso($result['idUsuario'], $result['nome'], $result['email'], $result['senha'], $result['cpf'], $result['idEmpresa']) : null;
    }

    public function findAll()
    {
        $stmt = $this->conexao->query("SELECT u.*, a.cpf FROM usuario u JOIN aluno a ON u.idUsuario = a.idUsuario");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $alunos = [];
        foreach ($result as $row) {
            $alunos[] = new Aluno($row['idUsuario'], $row['nome'], $row['email'], $row['senha'], $row['cpf']);
        }
        return $alunos;
    }
}
