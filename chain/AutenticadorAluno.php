<?php
require_once('../dao/UsuarioDAO.php');
require_once('../dao/AlunoDAO.php');
require_once('../singleton/SessaoUsuarioSingleton.php');

class AutenticadorAluno implements IAutenticador
{
    public function autenticar($email, $password)
    {
        $daoAluno = new AlunoDAO();
        $usuario = $daoAluno->findByEmail($email);

        if ($usuario && password_verify($password, $usuario->getSenha())) {
            // Usando o UsuarioLogadoSingleton para gerenciar a sessão
            $usuarioLogado = SessaoUsuarioSingleton::getInstance();
            $usuarioLogado->setUsuario($usuario, 'aluno');
            return true;
        }
        return false;
    }
}
