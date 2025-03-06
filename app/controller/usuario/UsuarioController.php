<?php

namespace app\controller\usuario;

use app\controller\HtmlTemplateController;
use app\dao\AlunoDAO;
use app\dao\EmpresaDAO;
use app\model\Aluno;
use app\model\Empresa;
use app\service\AutenticacaoService;
use app\singleton\SessaoUsuarioSingleton;
use AwesomePackages\AwesomeRoutes\Core\Controller;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Core\Response;
use AwesomePackages\AwesomeRoutes\Enum\StatusCode;

class UsuarioController extends HtmlTemplateController implements Controller
{
    public function renderHome(Request $request, Response $response): Response
    {
        echo $this->renderizaHtml('home.php', []);
        return $response;
    }

    public function renderCreate(Request $request, Response $response): Response
    {
        echo $this->renderizaHtml('cadastro_usuario_screen.php', []);
        return $response;
    }

    public function login(Request $request, Response $response): Response
    {
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        // Verifica o login
        $resultado = $this->verificarLogin($username, $password);

        if ($resultado === true) {

            if ($_SESSION['usuario_tipo'] == 'aluno') {
                header("Location: /aluno");
            } elseif ($_SESSION['usuario_tipo'] == 'egresso') {
                header("Location: /egresso");
            } elseif ($_SESSION['usuario_tipo'] == 'empresa') {
                header('location: /empresa/vagas');
            }
            exit;
        } else {
            echo "<script>alert('$resultado'); window.location.href = '/';</script>";
            exit;
        }
        header("Location: /");
        return $response;
    }

    public function logout(Request $request, Response $response): Response
    {
        SessaoUsuarioSingleton::getInstance()->logout();
        return $response;
    }

    public function index(Request $request, Response $response): Response
    {
        $response->setBody([
            ['name' => 'Rhuan Gabriel', 'age' => 23],
            ['name' => 'Eloah Hadassa', 'age' => 13]
        ]);

        $response->setStatusCode(StatusCode::SUCCESS);
        echo $this->renderizaHtml('cadastro_usuario_screen.php', []);
        return $response;
    }

    public function show(Request $request, Response $response): Response
    {
        $id = $request->id;

        $response->setBody([
            'name' => 'Rhuan Gabriel',
            'age' => 23
        ]);

        $response->setStatusCode(StatusCode::SUCCESS);

        echo $this->renderizaHtml('cadastro_usuario_screen.php', []);

        return $response;
    }

    public function create(Request $request, Response $response): Response
    {
        $nome      = isset($_POST['nome']) ? $_POST['nome'] : '';
        $email     = isset($_POST['email']) ? $_POST['email'] : '';
        $senha     = isset($_POST['senha']) ? $_POST['senha'] : '';
        $cpf_cnpj  = isset($_POST['cpf_cnpj']) ? $_POST['cpf_cnpj'] : '';

        if (strpos($email, "@edu.ufes.br") !== false && strlen($cpf_cnpj) == 11) {
            $aluno = new Aluno($nome, $email, $senha, $cpf_cnpj);
            $dao = new AlunoDAO();
            $dao->insert($aluno);

            echo "<script>
                    alert('Cadastro realizado com sucesso!');
                    window.location.href = '/';
                </script>";
        } else if (strlen($cpf_cnpj) == 14) {
            $empresa = new Empresa($nome, $email, $senha, $cpf_cnpj);
            $dao = new EmpresaDAO();
            $dao->insert($empresa);

            echo "<script>
                    alert('Cadastro realizado com sucesso!');
                    window.location.href = '/';
                </script>";
        } else {
            echo "<script>
                    alert('CPF ou CNPJ inválido!');
                    window.history.back();
                </script>";
        }

        return $response;
    }

    public function update(Request $request, Response $response): Response
    {
        $id = $request->id;
        $body = $request->body;

        $response->setBody([
            'message' => 'User has been updated'
        ]);

        $response->setStatusCode(StatusCode::SUCCESS);

        return $response;
    }

    public function destroy(Request $request, Response $response): Response
    {
        $id = $request->id;

        $response->setBody([
            'message' => 'User has been deleted'
        ]);

        $response->setStatusCode(StatusCode::SUCCESS);

        return $response;
    }

    function verificarLogin($username, $password)
    {
        if (empty($username) || empty($password)) {
            return "Preencha todos os campos.";
        }

        // Criando o serviço de autenticação
        $autenticacaoService = new AutenticacaoService();

        // Verifica se a autenticação foi bem-sucedida
        $usuario = $autenticacaoService->autenticar($username, $password);

        if ($usuario) {
            return true;
        }

        return "Usuário não encontrado ou e-mail/senha inválidos.";
    }

    public function verificaSessao() {}
}
