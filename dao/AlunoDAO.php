<?php

class AlunoDAO extends UsuarioDAO
{
    public function insert($aluno)
    {
        $idUsuario = parent::insert($aluno);
        $stmt = $this->conexao->prepare("INSERT INTO aluno (idAluno, cpf) VALUES (?, ?)");
        $stmt->execute([$idUsuario, $aluno->getCpf()]);
    }

    public function update($aluno)
    {
        parent::update($aluno);
        $stmt = $this->conexao->prepare("UPDATE aluno SET cpf=? WHERE idAluno=?");
        $stmt->execute([$aluno->cpf, $aluno->idUsuario]);
    }

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM aluno WHERE idAluno=?");
        $stmt->execute([$id]);
        parent::delete($id);
    }

    public function findById($id)
    {
        $stmt = $this->conexao->prepare("SELECT u.*, a.cpf FROM usuario u JOIN aluno a ON u.idUsuario = a.idAluno WHERE u.idUsuario=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new Aluno($result['idUsuario'], $result['nome'], $result['email'], $result['senha'], $result['cpf']) : null;
    }

    public function findByEmail($email)
    {
        $stmt = $this->conexao->prepare("SELECT u.*, a.cpf FROM usuario u JOIN aluno a ON u.idUsuario = a.idAluno WHERE u.email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new Aluno($result['idUsuario'], $result['nome'], $result['email'], $result['senha'], $result['cpf']) : null;
    }

    public function findAll()
    {
        $stmt = $this->conexao->query("SELECT u.*, a.cpf FROM usuario u JOIN aluno a ON u.idUsuario = a.idAluno");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $alunos = [];
        foreach ($result as $row) {
            $alunos[] = new Aluno($row['idUsuario'], $row['nome'], $row['email'], $row['senha'], $row['cpf']);
        }
        return $alunos;
    }
}
