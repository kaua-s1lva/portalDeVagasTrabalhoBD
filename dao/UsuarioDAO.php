<?php
    require_once('../singleton/ConexaoSingleton.php');
    require_once('IDAO.php');

abstract class UsuarioDAO implements IDAO {
    protected $conexao;
    
    public function __construct() {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }
    
    public function insert($usuario) {
        $stmt = $this->conexao->prepare("INSERT INTO usuario (nome, email, senha, created_At) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$usuario->getNome(), $usuario->getEmail(), $usuario->getSenha()]);
        return $this->conexao->lastInsertId();
    }
    
    public function update($usuario) {
        $stmt = $this->conexao->prepare("UPDATE usuario SET nome=?, email=?, senha=?, updated_At=NOW() WHERE idUsuario=?");
        $stmt->execute([$usuario->getNome(), $usuario->getEmail(), $usuario->getSenha(), $usuario->getIdUsuario()]);
    }
    
    public function delete($id) {
        print_r($id);
        $stmt = $this->conexao->prepare("DELETE FROM usuario WHERE idUsuario=?");
        $stmt->execute([$id]);
    }
    
    public abstract function findById($id);

    public abstract function findByEmail($email);
    
    public abstract function findAll();
}


?>
