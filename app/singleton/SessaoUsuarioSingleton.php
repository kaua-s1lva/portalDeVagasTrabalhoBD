<?php
namespace app\singleton;
use app\dao\AlunoDAO;
use app\dao\EgressoDAO;
use app\dao\EmpresaDAO;
use Exception;

class SessaoUsuarioSingleton
{
    private static $instance = null;
    private $usuario;
    private $tipoUsuario;

    // Construtor privado para evitar instâncias externas
    private function __construct()
    {
        if (isset($_SESSION['usuario_id'])) {
            // Verificar o tipo de usuário na sessão e buscar as informações no banco
            $this->loadUsuario($_SESSION['usuario_id'], $_SESSION['usuario_tipo']);
        }
    }

    // Retorna a instância única do Singleton
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new SessaoUsuarioSingleton();
        }
        return self::$instance;
    }

    // Carregar o usuário de acordo com o tipo
    private function loadUsuario($usuarioId, $tipoUsuario)
    {
        if ($tipoUsuario == 'aluno') {
            $dao = new AlunoDAO();
            $this->usuario = $dao->findById($usuarioId);
            $this->tipoUsuario = 'aluno';
        }
        if ($tipoUsuario == 'egresso') {
            $dao = new EgressoDAO();
            $this->usuario = $dao->findById($usuarioId);
            $this->tipoUsuario = 'egresso';
        }
        if ($tipoUsuario == 'empresa') {
            $dao = new EmpresaDAO();
            $this->usuario = $dao->findById($usuarioId);
            $this->tipoUsuario = 'empresa';
        }

        // Verifica se o usuário foi carregado com sucesso
        if ($this->usuario === null) {
            $this->logout();  // Destrói a sessão se o usuário não for encontrado
            throw new Exception("Usuário não encontrado.");
        }
    }

    // Retorna o usuário logado
    public function getUsuario()
    {
        return $this->usuario;
    }

    // Retorna o tipo de usuário logado
    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
    }

    // Destrói a sessão e o usuário logado
    public function logout()
    {
        session_unset();  // Limpa todas as variáveis de sessão
        session_destroy();  // Destrói a sessão
        // Limpar os cookies da sessão
        setcookie(session_name(), '', time() - 3600, '/');
        self::$instance = null;
        header('Location: ../index.php');  // Redireciona para a tela de login
        exit();  // Garante que o script pare de executar após o redirecionamento
    }
}
