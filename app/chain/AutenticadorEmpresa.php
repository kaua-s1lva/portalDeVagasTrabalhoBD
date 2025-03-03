<?php
namespace app\chain;

use app\dao\EmpresaDAO;

class AutenticadorEmpresa implements IAutenticador
{
    public function autenticar($email, $password)
    {
        $daoEmpresa = new EmpresaDAO();
        $usuario = $daoEmpresa->findByEmail($email);

        // Verifica se o usuário existe e se a senha corresponde
        if ($usuario && $usuario->getSenha() == $password) {
            // Usando o UsuarioLogadoSingleton para gerenciar a sessão
            $_SESSION['usuario_tipo'] = 'empresa'; 
            return $usuario;
        }
        return null; // Se não autenticar
    }
}
