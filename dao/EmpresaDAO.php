<?php

    class EmpresaDAO extends UsuarioDAO
    {
        public function insert($empresa)
        {
            $idUsuario = parent::insert($empresa);
            $stmt = $this->conexao->prepare("INSERT INTO empresa (idEmpresa, cnpj) VALUES (?, ?)");
            $stmt->execute([$idUsuario, $empresa->getCnpj()]);
        }

        public function findById($id)
        {
            $usuario = parent::findById($id);
            $stmt = $this->conexao->prepare("SELECT * FROM empresa WHERE idUsuario=?");
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function findAll()
        {
            $stmt = $this->conexao->query("SELECT u.*, e.cnpj FROM usuario u JOIN empresa e ON u.idUsuario = e.idUsuario");
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

?>