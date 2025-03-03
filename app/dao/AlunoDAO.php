<?php
namespace app\dao;

use app\dao\UsuarioDAO;
use app\model\Aluno;
use PDO;

class AlunoDAO extends UsuarioDAO
{
    public function insert($aluno)
    {
        $idUsuario = parent::insert($aluno);
        $stmt = $this->conexao->prepare("INSERT INTO aluno (idAluno, cpf) VALUES (?, ?)");
        $stmt->execute([$idUsuario, $aluno->getCpf()]);
        return $stmt->rowCount() > 0; 
    }

    public function update($aluno)
    {
        parent::update($aluno);
        $stmt = $this->conexao->prepare("UPDATE aluno SET cpf=? WHERE idAluno=?");
        $stmt->execute([$aluno->getCpf(), $aluno->getIdUsuario()]);
        return $stmt->rowCount() > 0; 
    }

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM aluno WHERE idAluno=?");
        $stmt->execute([$id]);
        parent::delete($id);
        return $stmt->rowCount() > 0; 
    }

    public function findById($id) {
        $stmt = $this->conexao->prepare("SELECT * FROM usuario WHERE idUsuario = ?");
        $stmt->execute([$id]);
        $usuarioData = $stmt->fetch(PDO::FETCH_OBJ);

        if ($usuarioData) {

            $stmt = $this->conexao->prepare("SELECT * FROM aluno WHERE idAluno = ?");
            $stmt->execute([$id]);
            $alunoData = $stmt->fetch(PDO::FETCH_OBJ);

            if ($alunoData) {
       
                $aluno = new Aluno($usuarioData->nomeusuario, $usuarioData->emailusuario, $usuarioData->senhausuario, $alunoData->cpf);
                $aluno->setIdAluno($alunoData->idaluno);
                $aluno->setIdUsuario($usuarioData->idusuario);

                return $aluno;
            }
        }

        return null;
    }

    public function findByEmail($email) {
        $stmt = $this->conexao->prepare("SELECT u.*, a.idAluno, a.cpf FROM usuario u JOIN aluno a ON u.idUsuario = a.idAluno WHERE u.emailUsuario = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result) {

            $aluno = new Aluno($result->nomeusuario, $result->emailusuario, $result->senhausuario, $result->cpf);
            $aluno->setIdAluno($result->idaluno);
            $aluno->setIdUsuario($result->idaluno);
            return $aluno;
        }

        return null;
    }

    public function findAll() {
        $stmt = $this->conexao->prepare("SELECT u.*, a.idAluno FROM usuario u JOIN aluno a ON u.idUsuario = a.idAluno");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
