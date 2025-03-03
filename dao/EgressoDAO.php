<?php
class EgressoDAO extends UsuarioDAO
{
    public function insert($egresso)
    {
        $idUsuario = parent::insert($egresso);
        $stmt = $this->conexao->prepare("INSERT INTO egresso (idEgresso, idEmpresa, cpf) VALUES (?, ?, ?)");
        $stmt->execute([$idUsuario, $egresso->getIdEmpresa(), $egresso->getCpf()]);
        return $stmt->rowCount() > 0; 
    }

    public function update($egresso)
    {
        parent::update($egresso);
        $stmt = $this->conexao->prepare("UPDATE egresso SET cpf=? WHERE idEgresso=?");
        $stmt->execute([$egresso->getCpf(), $egresso->getIdUsuario()]);
        return $stmt->rowCount() > 0; 
    }

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM egresso WHERE idEgresso=?");
        $stmt->execute([$id]);
        parent::delete($id);
        return $stmt->rowCount() > 0; 
    }

    public function findById($id) {
        $stmt = $this->conexao->prepare("SELECT * FROM usuario WHERE idUsuario = ?");
        $stmt->execute([$id]);
        $usuarioData = $stmt->fetch(PDO::FETCH_OBJ);

        if ($usuarioData) {
            $stmt = $this->conexao->prepare("SELECT * FROM egresso WHERE idEgresso = ?");
            $stmt->execute([$id]);
            $egressoData = $stmt->fetch(PDO::FETCH_OBJ);

            if ($egressoData) {

                $egresso = new Egresso($usuarioData->nomeusuario, $usuarioData->emailusuario, $usuarioData->senhausuario, $egressoData->cpf, $egressoData->idempresa);
                $egresso->setIdEgresso($egressoData->idegresso);
                $egresso->setIdUsuario($usuarioData->idusuario);

                return $egresso;
            }
        }

        return null;
    }

    public function findByIdEmpresa($id) {
        $stmt = $this->conexao->prepare("SELECT u.*, e.idEgresso, e.cpf FROM usuario u JOIN egresso e ON u.idUsuario = e.idEgresso WHERE idEmpresa = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result) {
            $egresso = new Egresso($result->nomeusuario, $result->emailusuario, $result->senhausuario, $result->cpf, $id);
            $egresso->setIdEgresso($result->idegresso);
            $egresso->setIdUsuario($result->idegresso);
            return $egresso;
        }

        return null;
    }

    public function findByEmail($email) {
        $stmt = $this->conexao->prepare("SELECT u.*, e.idEgresso, e.cpf, e.idEmpresa FROM usuario u JOIN egresso e ON u.idUsuario = e.idEgresso WHERE u.emailUsuario = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result) {
            $egresso = new Egresso($result->nomeusuario, $result->emailusuario, $result->senhausuario, $result->cpf, $result->idempresa);
            $egresso->setIdEgresso($result->idegresso);
            $egresso->setIdUsuario($result->idegresso);
            return $egresso;
        }

        return null;
    }

    public function findAll() {
        $stmt = $this->conexao->prepare("SELECT u.*, e.idEgresso FROM usuario u JOIN egresso e ON u.idUsuario = e.idEgresso");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllByIdEmpresa($idEmpresa) {
        $stmt = $this->conexao->prepare("SELECT u.*, e.idEgresso FROM usuario u JOIN egresso e ON u.idUsuario = e.idEgresso WHERE idEmpresa = ?");
        $stmt->execute([$idEmpresa]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
