<?php
namespace app\controller\aluno;

use app\controller\ControllerComHtml;
use app\dao\AlunoDAO;
use app\dao\CandidaturaDAO;
use app\dao\EmpresaDAO;
use app\dao\VagaDAO;
use app\model\Aluno;
use app\model\Empresa;
use app\service\AutenticacaoService;
use app\singleton\SessaoUsuarioSingleton;
use AwesomePackages\AwesomeRoutes\Core\Controller;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Core\Response;
use AwesomePackages\AwesomeRoutes\Enum\StatusCode;

class AlunoController extends ControllerComHtml implements Controller
{

      public function index(Request $request,Response $response) : Response
      {
        $this->verificaSessao();
    
        $vagaDAO = new VagaDAO();
        $dados = $vagaDAO->findAll();

        $candidaturaDAO = new CandidaturaDAO();
        $usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();
        $candidaturas = $candidaturaDAO->findByIdAluno($usuario_logado->getIdUsuario());
        
        echo $this->renderizaHtml('lista_vagas_aluno.php', [
                        'dados' => $dados, 
                        'candidaturas' => $candidaturas
                    ]);

          return $response;
      }
      
      public function show(Request $request,Response $response) : Response
      {
        $this->verificaSessao();
      
        $usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();

          echo $this->renderizaHtml('pag_crud_aluno.php', ['usuario_logado' => $usuario_logado]);
  
          return $response;
      }
      
    public function create(Request $request,Response $response) : Response
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
      
      public function update(Request $request,Response $response) : Response
      {
        $instancia = SessaoUsuarioSingleton::getInstance();
        $usuario_logado = $instancia->getUsuario();
        $dao = new AlunoDAO();
          // Resgata os dados enviados pelo formulário
        $nome      = isset($_POST['nome']) ? $_POST['nome'] : '';
        $email     = isset($_POST['email']) ? $_POST['email'] : '';
        $senha     = isset($_POST['senha']) ? $_POST['senha'] : '';
        $cpf       = isset($_POST['cpf']) ? $_POST['cpf'] : '';

        if (strlen($cpf) == 11) {
            $aluno = new Aluno($nome, $email, $senha, $cpf);
            $aluno->setIdAluno($usuario_logado->getIdAluno());
            $aluno->setIdUsuario($usuario_logado->getIdUsuario());

            if ($dao->update($aluno)) {
                echo "<script> alert('Dados do aluno atualizados com sucesso!'); window.location.href = '/aluno/visualizar'; </script>";
                exit();
            }
        } else {
            echo "CPF inválido";
        }
  
          return $response;
      }
      
      public function destroy(Request $request,Response $response) : Response
      {
        $dao = new AlunoDAO();
        $instancia = SessaoUsuarioSingleton::getInstance();
        $usuario_logado = $instancia->getUsuario();

        $dao->delete($usuario_logado->getIdUsuario());

        $instancia->logout();

        header("Location: /");
  
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
      
          return "Usuário não encontrado, e-mail ou senha inválidos.";
      }

    public function verificaSessao() {
        if (SessaoUsuarioSingleton::getInstance()->getTipoUsuario() !== 'aluno') {
            die("Acesso negado.");
        }
    }

}