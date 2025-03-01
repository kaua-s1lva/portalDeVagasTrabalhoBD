<?php
namespace dao;


use IDAO;
use singleton\ConexaoSingleton;

abstract class UsuarioDAO implements IDAO {
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
    
    public abstract function findById($id);
    
    public abstract function findAll();
}


?>
