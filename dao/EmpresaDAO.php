<?php

class EmpresaDAO extends UsuarioDAO
{
    public function insert($empresa)
    {
        $idUsuario = parent::insert($empresa);
        $stmt = $this->conexao->prepare("INSERT INTO empresa (idEmpresa, cnpj) VALUES (?, ?)");
        $stmt->execute([$idUsuario, $empresa->getCnpj()]);
    }

    public function delete($idUsuario) {
        $stmt = $this->conexao->prepare("UPDATE usuario SET deleted_at = NOW() WHERE idUsuario = ?");
        return $stmt->execute([$idUsuario]);
    }

     // Método para atualizar os dados da empresa
     public function update($empresa)
     {
         // Atualizar dados da tabela 'usuario'
         $stmt = $this->conexao->prepare("UPDATE usuario SET nome = ?, email = ?, senha = ? WHERE idUsuario = ?");
         $stmt->execute([$empresa->getNome(), $empresa->getEmail(), $empresa->getSenha(), $empresa->getIdUsuario()]);
 
         // Atualizar dados da tabela 'empresa'
         $stmt = $this->conexao->prepare("UPDATE empresa SET cnpj = ? WHERE idEmpresa = ?");
         $stmt->execute([$empresa->getCnpj(), $empresa->getIdEmpresa()]);
 
         return $stmt->rowCount() > 0; // Retorna true se a atualização foi bem-sucedida
     }

    public function findById($id) {
        $stmt = $this->conexao->prepare("SELECT * FROM usuario WHERE idUsuario = ? and deleted_at IS NULL");
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
        $stmt = $this->conexao->prepare("SELECT u.*, e.idEmpresa, e.cnpj FROM usuario u JOIN empresa e ON u.idUsuario = e.idEmpresa WHERE u.email = ? and u.deleted_at IS NULL");
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
        $stmt = $this->conexao->prepare("SELECT u.*, e.cnpj FROM usuario u JOIN empresa e ON u.idUsuario = e.idEmpresa WHERE deleted_at IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
