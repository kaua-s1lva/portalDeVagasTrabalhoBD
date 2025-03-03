<?php
namespace app\chain;

use app\dao\AlunoDAO;

class AutenticadorAluno implements IAutenticador
{
    public function autenticar($email, $password)
    {
        $daoAluno = new AlunoDAO();
        $usuario = $daoAluno->findByEmail($email);

        // Verifica se o usuário existe e se a senha corresponde
        if ($usuario && $usuario->getSenha() == $password) {
            // Usando o UsuarioLogadoSingleton para gerenciar a sessão
            $_SESSION['usuario_tipo'] = 'aluno';  
            return $usuario;
        }
        return null; // Se não autenticar
    }
}
