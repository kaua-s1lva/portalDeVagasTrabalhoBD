<?php
namespace app\controller\egresso;

use app\controller\ControllerComHtml;
use app\dao\AlunoDAO;
use app\dao\EgressoDAO;
use app\dao\IndicacaoDAO;
use app\dao\VagaDAO;
use app\model\Aluno;
use app\model\Indicacao;
use app\singleton\SessaoUsuarioSingleton;
use AwesomePackages\AwesomeRoutes\Core\Controller;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Core\Response;

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

          echo $this->renderizaHtml('visualizar_dados_egresso.php', ['usuario_logado' => $usuario_logado]);
  
          return $response;
      }
      
      public function create(Request $request, Response $response): Response
      {
          $this->verificaSessao();
      
          $email = isset($_POST['emailAluno']) ? $_POST['emailAluno'] : '';
          $alunoDAO = new AlunoDAO();
          $aluno = $alunoDAO->findByEmail($email);
      
          if ($aluno != null) {
              $idVaga = isset($_POST['idvaga']) ? $_POST['idvaga'] : '';
              $idEgresso = SessaoUsuarioSingleton::getInstance()->getUsuario()->getIdUsuario();
      
              $indicacaoDAO = new IndicacaoDAO();
              try {
                  $indicacaoDAO->insert(new Indicacao($aluno->getIdAluno(), $idEgresso, $idVaga, 1));
                  echo "<script>
                          alert('Aluno indicado com sucesso');
                          window.location.href = '/egresso';
                        </script>";
              } catch (\PDOException $e) {
                  if ($e->getCode() === '23505') {
                      echo "<script>
                              alert('Este aluno já foi indicado.');
                              window.location.href = '/egresso';
                            </script>";
                  } else {
                      echo "<script>
                              alert('Erro ao indicar aluno: " . addslashes($e->getMessage()) . "');
                              window.location.href = '/egresso';
                            </script>";
                  }
              }
          } else {
              echo "<script>
                      alert('Aluno não encontrado');
                      window.location.href = '/egresso';
                    </script>";
          }
          return $response;
      }
      
      
      public function update(Request $request,Response $response) : Response
      {
        $this->verificaSessao();

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
        $this->verificaSessao();
        
        $dao = new AlunoDAO();
        $instancia = SessaoUsuarioSingleton::getInstance();
        $usuario_logado = $instancia->getUsuario();

        $dao->delete($usuario_logado->getIdUsuario());

        $instancia->logout();

        header("Location: /");
  
        return $response;
      }

    public function verificaSessao() {
        if (SessaoUsuarioSingleton::getInstance()->getTipoUsuario() !== 'egresso') {
            die("Acesso negado.");
        }
    }

}