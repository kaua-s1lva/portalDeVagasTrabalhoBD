<?php
namespace app\controller\egresso;

use app\controller\ControllerComHtml;
use app\dao\AlunoDAO;
use app\dao\CandidaturaDAO;
use app\dao\EgressoDAO;
use app\dao\EmpresaDAO;
use app\dao\IndicacaoDAO;
use app\dao\VagaDAO;
use app\model\Aluno;
use app\model\Egresso;
use app\model\Empresa;
use app\model\Indicacao;
use app\service\AutenticacaoService;
use app\singleton\SessaoUsuarioSingleton;
use AwesomePackages\AwesomeRoutes\Core\Controller;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Core\Response;
use AwesomePackages\AwesomeRoutes\Enum\StatusCode;

class EgressoController extends ControllerComHtml implements Controller
{

      public function index(Request $request,Response $response) : Response
      {
        $this->verificaSessao();
    
        $id_usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario()->getIdUsuario();
        $egressoDAO = new EgressoDAO();
        $idEmpresa = $egressoDAO->findById($id_usuario_logado)->getIdEmpresa();

        $vagaDAO = new VagaDAO();
        $dados = $vagaDAO->findAllByIdEmpresa($idEmpresa);
        
        echo $this->renderizaHtml('lista_indicacoes_egresso.php', [
                        'dados' => $dados
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
        $email     = isset($_POST['emailAluno']) ? $_POST['emailAluno'] : '';
        $alunoDAO = new AlunoDAO();
        $aluno = $alunoDAO->findByEmail($email);

        if ($aluno != null) {
            $idVaga    = isset($_POST['idvaga']) ? $_POST['idvaga'] : '';
    
            $idEgresso = SessaoUsuarioSingleton::getInstance()->getUsuario()->getIdUsuario();
    
            $indicacaoDAO = new IndicacaoDAO();
            $indicacaoDAO->insert(new Indicacao($aluno->getIdAluno(), $idEgresso, $idVaga, 1));

        } else {
            echo "<script> alert('Aluno não encontrado'); window.location.href = '/egresso'; </script>";
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
        if (SessaoUsuarioSingleton::getInstance()->getTipoUsuario() !== 'egresso') {
            die("Acesso negado.");
        }
    }

}