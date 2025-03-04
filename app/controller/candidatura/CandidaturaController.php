<?php
namespace app\controller\candidatura;

use app\controller\ControllerComHtml;
use app\dao\AlunoDAO;
use app\dao\CandidaturaDAO;
use app\dao\EmpresaDAO;
use app\dao\VagaDAO;
use app\model\Aluno;
use app\model\Candidatura;
use app\model\Empresa;
use app\service\AutenticacaoService;
use app\singleton\SessaoUsuarioSingleton;
use AwesomePackages\AwesomeRoutes\Core\Controller;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Core\Response;
use AwesomePackages\AwesomeRoutes\Enum\StatusCode;

class CandidaturaController extends ControllerComHtml implements Controller
{

      public function index(Request $request,Response $response) : Response
      {
        if (!isset($_SESSION['usuario_id']) == true && !isset($_SESSION['usuario_tipo']) == 'aluno') {
            header('/');
        }
    
        $vagaDAO = new VagaDAO();
        $dados = $vagaDAO->findAll();
        echo $this->renderizaHtml('lista_vagas_aluno.php', ['dados' => $dados]);
          return $response;
      }
      
      public function show(Request $request,Response $response) : Response
      {

        if (!isset($_SESSION['usuario_id']) == true && !isset($_SESSION['usuario_tipo']) == 'aluno') {
            header('Location: ../index.php');
        }
      
        $usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();

          echo $this->renderizaHtml('pag_crud_aluno.php', ['usuario_logado' => $usuario_logado]);
  
          return $response;
      }


      public function create(Request $request, Response $response) : Response
      {
          if ($_FILES['curriculo']['error'] === UPLOAD_ERR_OK) {
              // Caminho temporário e informações do arquivo
              $fileTmpPath = $_FILES['curriculo']['tmp_name'];
              $fileName    = $_FILES['curriculo']['name'];
      
              $idvaga = isset($_POST['idvaga']) ? $_POST['idvaga'] : '';
      
              // Verifica a extensão do arquivo
              $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
              if ($fileExtension !== 'pdf') {
                  echo "<script>
                          alert('Apenas arquivos PDF são permitidos.');
                          window.history.back();
                        </script>";
                  exit;
              }
      
              // Lê o conteúdo do arquivo como string binária
              $fileContent = file_get_contents($fileTmpPath);
              if ($fileContent === false) {
                  echo "<script>
                          alert('Erro ao ler o arquivo.');
                          window.history.back();
                        </script>";
                  exit;
              }
      
              // Converte o conteúdo em binário para a representação de string binária
              $fileContentBinary = ($fileContent); 
      
              // Obtém o ID do usuário atual
              $idusuario = SessaoUsuarioSingleton::getInstance()->getUsuario()->getIdUsuario();
      
              // Cria a instância da DAO e insere os dados com o conteúdo binário
              $dao = new CandidaturaDAO();
              $dao->insert(new Candidatura($idvaga, $idusuario, $fileContentBinary, 1));
      
              // Redireciona para a página de aluno após o upload
              header("Location: /aluno");
          } else {
              echo "<script>
                      alert('Erro no upload do arquivo.');
                      window.history.back();
                    </script>";
          }
      
          return $response;
      }

    /*
    public function create(Request $request,Response $response) : Response
    {

        if ($_FILES['curriculo']['error'] === UPLOAD_ERR_OK) {
            // Caminho temporário e informações do arquivo
            $fileTmpPath = $_FILES['curriculo']['tmp_name'];
            $fileName    = $_FILES['curriculo']['name'];
    
            $idvaga         = isset($_POST['idvaga']) ? $_POST['idvaga'] : '';
            
            // Verifica a extensão do arquivo
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if ($fileExtension !== 'pdf') {
                echo "<script>
                        alert('Apenas arquivos PDF são permitidos.');
                        window.history.back();
                      </script>";
                exit;
            }
            
            // Lê o conteúdo do arquivo
            $fileContent = file_get_contents($fileTmpPath);
            if ($fileContent === false) {
                echo "<script>
                        alert('Erro ao ler o arquivo.');
                        window.history.back();
                      </script>";
                exit;
            }
    
            $idusuario = SessaoUsuarioSingleton::getInstance()->getUsuario()->getIdUsuario();
    
            $dao = new CandidaturaDAO();
            $dao->insert(new Candidatura($idvaga, $idusuario, $fileContent, 1));

            header("Location: /aluno");
            
            
        } else {
            echo "<script>
                    alert('Erro no upload do arquivo.');
                    window.history.back();
                  </script>";
        }
        
        return $response;
    }*/
      
      public function update(Request $request,Response $response) : Response
      {
          $id = $request->id;
          $body = $request->body;
      
          $response->setBody([
              'message' => 'User has been updated'
          ]);
          
          $response->setStatusCode(StatusCode::SUCCESS);
  
          return $response;
      }
      
      public function destroy(Request $request,Response $response) : Response
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
      
          return "Usuário não encontrado, e-mail ou senha inválidos.";
      }

      public function verificaSessao() {
        if (!isset($_SESSION['usuario_id']) == true && !isset($_SESSION['usuario_tipo']) == 'aluno') {
            header('Location: ../index.php');
        }
    }

}