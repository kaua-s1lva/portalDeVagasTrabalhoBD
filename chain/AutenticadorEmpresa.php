<?php
require_once('../dao/UsuarioDAO.php');
require_once('../dao/EmpresaDAO.php');
require_once('../singleton/SessaoUsuarioSingleton.php');

class AutenticadorEmpresa implements IAutenticador
{
    public function autenticar($email, $password)
    {
        $daoEmpresa = new EmpresaDAO();
        $usuario = $daoEmpresa->findByEmail($email);

        if ($usuario && password_verify($password, $usuario->getSenha())) {
            // Usando o UsuarioLogadoSingleton para gerenciar a sessão
            $usuarioLogado = SessaoUsuarioSingleton::getInstance();
            $usuarioLogado->setUsuario($usuario, 'empresa');
            return true;
        }
        return false;
    }
}
