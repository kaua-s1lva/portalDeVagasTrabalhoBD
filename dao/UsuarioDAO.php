<?php

class UsuarioDAO implements IDAO {
    protected $conexao;
    
    public function __construct() {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }
    
    public function insert($usuario) {
        $stmt = $this->conexao->prepare("INSERT INTO usuario (nome, email, senha, tipo, createdAt) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$usuario->nome, $usuario->email, $usuario->senha, $usuario->tipo]);
        return $this->conexao->lastInsertId();
    }
    
    public function update($usuario) {
        $stmt = $this->conexao->prepare("UPDATE usuario SET nome=?, email=?, senha=?, updatedAt=NOW() WHERE idUsuario=?");
        $stmt->execute([$usuario->nome, $usuario->email, $usuario->senha, $usuario->idUsuario]);
    }
    
    public function delete($id) {
        $stmt = $this->conexao->prepare("DELETE usuario SET deletedAt=NOW() WHERE idUsuario=?");
        $stmt->execute([$id]);
    }
    
    public function findById($id) {
        $stmt = $this->conexao->prepare("SELECT * FROM usuario WHERE idUsuario=? AND deletedAt IS NULL");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new Usuario($result['idUsuario'], $result['nome'], $result['email'], $result['senha'], $result['tipo'], $result['createdAt'], $result['updatedAt'], $result['deletedAt']) : null;
    }
    
    public function findAll() {
        $stmt = $this->conexao->query("SELECT * FROM usuario WHERE deletedAt IS NULL");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $usuarios = [];
        foreach ($result as $row) {
            $usuarios[] = new Usuario($row['idUsuario'], $row['nome'], $row['email'], $row['senha'], $row['tipo'], $row['createdAt'], $row['updatedAt'], $row['deletedAt']);
        }
        return $usuarios;
    }
}


?>
