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

        // Verifica se o usuário existe e se a senha corresponde
        if ($usuario && $usuario->getSenha() == $password) {
            // Usando o UsuarioLogadoSingleton para gerenciar a sessão
            $usuarioLogado = SessaoUsuarioSingleton::getInstance();
            $usuarioLogado->setUsuario($usuario, 'egresso');
            return $usuario;
        }
        return null; // Se não autenticar
    }
}
