<?php
require_once('../dao/AlunoDAO.php');
require_once('../dao/EgressoDAO.php');
require_once('../dao/EmpresaDAO.php');

class SessaoUsuarioSingleton {
    private static $instance = null;
    private $usuario = null;

    // Construtor privado para evitar instâncias externas
    private function __construct() {
        if (isset($_SESSION['usuario_id'])) {
            // Verificar o tipo de usuário na sessão e buscar as informações no banco
            $this->loadUsuario($_SESSION['usuario_id'], $_SESSION['tipo_usuario']);
        }
    }

    // Retorna a instância única do Singleton
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new SessaoUsuarioSingleton();
        }
        return self::$instance;
    }

    // Carregar o usuário de acordo com o tipo
    private function loadUsuario($usuarioId, $tipoUsuario) {
        if ($tipoUsuario == 'aluno') {
            $dao = new AlunoDAO();
            $this->usuario = $dao->findById($usuarioId);
        } elseif ($tipoUsuario == 'egresso') {
            $dao = new EgressoDAO();
            $this->usuario = $dao->findById($usuarioId);
        } elseif ($tipoUsuario == 'empresa') {
            $dao = new EmpresaDAO();
            $this->usuario = $dao->findById($usuarioId);
        }
    }

    // Retorna o usuário logado
    public function getUsuario() {
        return $this->usuario;
    }

    // Define o usuário logado manualmente (útil para quando o login é feito)
    public function setUsuario($usuario, $tipoUsuario) {
        $this->usuario = $usuario;
        $_SESSION['usuario_id'] = $usuario->getId();
        $_SESSION['usuario_nome'] = $usuario->getNome();
        $_SESSION['tipo_usuario'] = $tipoUsuario;
    }

    // Destrói a sessão e o usuário logado
    public function logout() {
        session_unset();
        session_destroy();
        self::$instance = null;
    }
}
?>
