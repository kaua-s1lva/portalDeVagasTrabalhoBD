<?php

namespace app\dao;

use app\singleton\ConexaoSingleton;

abstract class UsuarioDAO implements IUsuarioDAO
{
    protected $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoSingleton::getInstancia()->getConexao();
    }

    /**
     * @Override
     */
    public function insert($usuario)
    {
        $stmt = $this->conexao->prepare("INSERT INTO usuario (nomeUsuario, emailUsuario, senhaUsuario, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$usuario->getNome(), $usuario->getEmail(), $usuario->getSenha()]);
        return $this->conexao->lastInsertId();
    }

    /**
     * @Override
     */

    public function update($usuario)
    {
        $stmt = $this->conexao->prepare("UPDATE usuario SET nomeUsuario=?, emailUsuario=?, senhaUsuario=?, updated_At=NOW() WHERE idUsuario=?");
        $stmt->execute([$usuario->getNome(), $usuario->getEmail(), $usuario->getSenha(), $usuario->getIdUsuario()]);
    }

    /**
     * @Override
     */

    public function delete($id)
    {
        $stmt = $this->conexao->prepare("DELETE FROM usuario WHERE idUsuario=?");
        $stmt->execute([$id]);
    }

    public abstract function findById($id);

    public abstract function findByEmail($email);

    public abstract function findAll();
}
