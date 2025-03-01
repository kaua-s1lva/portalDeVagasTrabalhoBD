<?php
require_once('../dao/UsuarioDAO.php');
require_once('../dao/EgressoDAO.php');
require_once('../singleton/SessaoUsuarioSingleton.php');

class AutenticadorEgresso implements IAutenticador
{
    public function autenticar($email, $password)
    {
        $daoEgresso = new EgressoDAO();
        $usuario = $daoEgresso->findByEmail($email);

        if ($usuario && password_verify($password, $usuario->getSenha())) {
            // Usando o UsuarioLogadoSingleton para gerenciar a sessão
            $usuarioLogado = SessaoUsuarioSingleton::getInstance();
            $usuarioLogado->setUsuario($usuario, 'egresso');
            return true;
        }
        return false;
    }
}
