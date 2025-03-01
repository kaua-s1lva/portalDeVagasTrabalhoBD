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

        // Verifica se o usuário existe e se a senha corresponde
        if ($usuario && $usuario->getSenha() == $password) {
            // Usando o UsuarioLogadoSingleton para gerenciar a sessão
            $usuarioLogado = SessaoUsuarioSingleton::getInstance();
            $usuarioLogado->setUsuario($usuario, 'aluno');
            return $usuario;
        }
        return null; // Se não autenticar
    }
}
