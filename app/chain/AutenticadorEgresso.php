<?php
namespace app\chain;

use app\dao\EgressoDAO;

class AutenticadorEgresso implements IAutenticador
{
    public function autenticar($email, $password)
    {
        $daoEgresso = new EgressoDAO();
        $usuario = $daoEgresso->findByEmail($email);

        // Verifica se o usuário existe e se a senha corresponde
        if ($usuario && $usuario->getSenha() == $password) {
            // Usando o UsuarioLogadoSingleton para gerenciar a sessão
            $_SESSION['usuario_tipo'] = 'egresso';  
            return $usuario;
        }
        return null; // Se não autenticar
    }
}
