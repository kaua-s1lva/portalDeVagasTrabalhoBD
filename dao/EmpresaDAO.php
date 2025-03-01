<?php

class EmpresaDAO extends UsuarioDAO
{
    public function insert($empresa)
    {
        $idUsuario = parent::insert($empresa);
        $stmt = $this->conexao->prepare("INSERT INTO empresa (idEmpresa, cnpj) VALUES (?, ?)");
        $stmt->execute([$idUsuario, $empresa->getCnpj()]);
    }

    public function findById($id) {
        $stmt = $this->conexao->prepare("SELECT * FROM usuario WHERE idUsuario = ?");
        $stmt->execute([$id]);
        $usuarioData = $stmt->fetch(PDO::FETCH_OBJ);

        if ($usuarioData) {
            $stmt = $this->conexao->prepare("SELECT * FROM empresa WHERE idEmpresa = ?");
            $stmt->execute([$id]);
            $empresaData = $stmt->fetch(PDO::FETCH_OBJ);

            if ($empresaData) {
                $empresa = new Empresa($usuarioData->nome, $usuarioData->email, $usuarioData->senha, $empresaData->cnpj);
                $empresa->setIdEmpresa($empresaData->idempresa);
                $empresa->setIdUsuario($usuarioData->idusuario);
            }

            return $empresa;
        }
        
        return null;
    }

    public function findByEmail($email) {
        $stmt = $this->conexao->prepare("SELECT u.*, e.idEmpresa, e.cnpj FROM usuario u JOIN empresa e ON u.idUsuario = e.idEmpresa WHERE u.email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result) {
            $empresa = new Empresa($result->nome, $result->email, $result->senha, $result->cnpj);
            $empresa->setIdEmpresa($result->idempresa);
            $empresa->setIdUsuario($result->idempresa);
            return $empresa;
        }

        return null;
    }

    public function findAll() {
        $stmt = $this->conexao->prepare("SELECT u.*, e.cnpj FROM usuario u JOIN empresa e ON u.idUsuario = e.idEmpresa");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
