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

        // Verifica se o usuário existe e se a senha corresponde
        if ($usuario && $usuario->getSenha() == $password) {
            // Usando o UsuarioLogadoSingleton para gerenciar a sessão
            $usuarioLogado = SessaoUsuarioSingleton::getInstance();
            $usuarioLogado->setUsuario($usuario, 'empresa');
            return $usuario;
        }
        return null; // Se não autenticar
    }
}
