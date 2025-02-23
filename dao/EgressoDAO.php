<?php
    class EgressoDAO extends UsuarioDAO {
        public function insert($egresso) {
            $idUsuario = parent::insert($egresso);
            $stmt = $this->conexao->prepare("INSERT INTO egresso (idUsuario, idEmpresa, cpf) VALUES (?, ?, ?)");
            $stmt->execute([$idUsuario, $egresso->idEmpresa, $egresso->cpf]);
        }
        
        public function findById($id) {
            $usuario = parent::findById($id);
            if ($usuario) {
                $stmt = $this->conexao->prepare("SELECT * FROM egresso WHERE idUsuario=?");
                $stmt->execute([$id]);
                $egresso = $stmt->fetchAll(PDO::FETCH_OBJ);
                return array_merge($usuario, $egresso);
            }
            return [];
        }
    }
?>