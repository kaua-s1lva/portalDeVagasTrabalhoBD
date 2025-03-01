<?php
require_once('../chain/IAutenticador.php');
require_once('../chain/AutenticadorAluno.php');
require_once('../chain/AutenticadorEgresso.php');
require_once('../chain/AutenticadorEmpresa.php');
require_once('../model/Usuario.php');
require_once('../model/Aluno.php');
require_once('../model/Empresa.php');
require_once('../model/Egresso.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/AlunoDAO.php');
require_once('../dao/EmpresaDAO.php');
require_once('../dao/EgressoDAO.php');
require_once('../singleton/SessaoUsuarioSingleton.php');

class AutenticacaoService {
    private $autenticadores = [];

    public function __construct() {
        $this->autenticadores[] = new AutenticadorAluno();
        $this->autenticadores[] = new AutenticadorEgresso();
        $this->autenticadores[] = new AutenticadorEmpresa();
    }

    public function autenticar($username, $password) {
        foreach ($this->autenticadores as $autenticador) {
            $usuario = $autenticador->autenticar($username, $password);
            if ($usuario) {
                $sessaoUsuario = SessaoUsuarioSingleton::getInstance();

                // Salva o tipo de usuário na sessão
                $_SESSION['usuario_tipo'] = $sessaoUsuario->getTipoUsuario();  // Aluno, Egresso, Empresa
                $_SESSION['usuario_id'] = $usuario->getIdUsuario();
                $_SESSION['usuario_nome'] = $usuario->getNome();
                return $usuario; // Retorna o usuário autenticado
            }
        }
        return null; // Se não autenticar
    }
}
?>
