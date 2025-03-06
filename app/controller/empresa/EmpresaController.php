<?php

namespace app\controller\empresa;

use app\controller\HtmlTemplateController;
use app\dao\CandidaturaDAO;
use app\dao\UsuarioDAO;
use app\dao\EgressoDAO;
use app\dao\EmpresaDAO;
use app\dao\EtapaDAO;
use app\dao\ICandidaturaDAO;
use app\dao\VagaDAO;
use app\model\Egresso;
use app\model\Empresa;
use app\model\Vaga;
use app\singleton\SessaoUsuarioSingleton;
use AwesomePackages\AwesomeRoutes\Core\Controller;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Core\Response;
use Exception;
use PDOException;

// Viola o SRP por alguns motivos bons (tempo de projeto).

class EmpresaController extends HtmlTemplateController implements Controller
{

    // ROTAS DE EMPRESA

    // ROTAS DE VISUALIZAÇÃO

    public function renderVagas(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();

        $empresa_id = $empresa->getIdUsuario();

        $vagaDAO = new VagaDAO();

        $vagas = $vagaDAO->findAllFiltered($empresa_id);

        echo $this->renderizaHtml('lista_vagas_empresa.php', ['vagas' => $vagas]);
        return $response;
    }

    public function renderPerfilEmpresa(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();

        echo $this->renderizaHtml('pag_crud_empresa.php', ['empresa' => $empresa]);
        return $response;
    }

    public function renderEgressos(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();

        $empresa_id = $usuario_logado->getIdUsuario();
        $egressoDAO = new EgressoDAO();
        try {
            $egressos = $egressoDAO->findAllByIdEmpresa($empresa_id);
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }

        echo $this->renderizaHtml('lista_edicao_perfil_egresso.php', ['egressos' => $egressos]);
        return $response;
    }


    // ROTAS DE PERFIL DE EMPRESA

    public function atualizarEmpresa(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        // Instanciar o DAO para acessar o banco de dados
        $empresaDAO = new EmpresaDAO();

        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['salvar'])) {
                $razao_social = $_POST['razao_social'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $cnpj = $_POST['cnpj'];

                $empresaAtualizada = new Empresa($razao_social, $email, $senha, $cnpj);
                $empresaAtualizada->setIdUsuario($empresa->getIdUsuario());
                $empresaAtualizada->setIdEmpresa($empresa->getIdEmpresa());

                if ($empresaDAO->update($empresaAtualizada)) {
                    echo "<script>
            alert('Dados da empresa atualizados com sucesso!');
            window.location.href = '/empresa/perfil';
        </script>";
                    exit();
                } else {
                    echo "<script>alert('Erro ao atualizar os dados da empresa.');</script>";
                }
            } else {

                // Excluir a empresa
                if ($empresaDAO->delete($empresa->getIdEmpresa())) {

                    echo "<script>
                    alert('Empresa excluída com sucesso!');
                    window.location.href = '/usuario/logout'; // Redireciona para a página inicial ou outra página desejada
                  </script>";
                    exit;
                } else {
                    echo "<script>alert('Erro ao excluir a empresa.');</script>";
                }
            }
        }
        return $response;
    }

    // ROTAS DE CONTROLE DE EGRESSOS

    public function renderCriarEgresso(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        echo $this->renderizaHtml('empresa_cadastro_egresso.php', []);
        return $response;
    }

    public function criarEgresso(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();
        $empresa_id = $usuario_logado->getIdUsuario();

        $egressoDAO = new EgressoDAO();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['username'];
            $email = $_POST['email'];
            $senha = $_POST['password'];
            $cpf = $_POST['cpf'];

            $egresso = $egressoDAO->findByEmail($email);

            if (!$egresso) {
                // Se não houver egresso cadastrado, é uma criação (inserção)
                $egressoCriado = new Egresso($nome, $email, $senha, $cpf, $empresa_id);

                if ($egressoDAO->insert($egressoCriado)) {
                    echo "<script>
                  alert('Egresso criado com sucesso!');
                  window.location.href = '/empresa/egressos';
              </script>";
                    exit();
                } else {
                    echo "<script>alert('Erro ao criar o egresso.');</script>";
                }
            } else {
                echo "<script>alert('Não é possível inserir um egresso já cadastrado.');</script>";
            }
        }
        return $response;
    }

    public function renderEditarEgresso(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $idEgresso = $request->id;
        $egressoDAO = new EgressoDAO();

        $egresso = $egressoDAO->findById($idEgresso);

        echo $this->renderizaHtml('empresa_editar_egresso.php', ['egresso' => $egresso]);
        return $response;
    }

    public function editarEgresso(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();

        $empresa_id = $usuario_logado->getIdUsuario();

        $egressoDAO = new EgressoDAO();

        // Se a operação for de edição
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['username'];
            $email = $_POST['email'];
            $senha = $_POST['password'];
            $cpf = $_POST['cpf'];

            $egresso = $egressoDAO->findByEmail($email);

            if ($egresso) {

                $egressoAtualizado = new Egresso($nome, $email, $senha, $cpf, $empresa_id);
                $egressoAtualizado->setIdUsuario($egresso->getIdUsuario());

                if ($egressoDAO->update($egressoAtualizado)) {
                    $idegresso = $egresso->getIdEgresso();
                    echo "<script>
                     alert('Dados do egresso atualizados com sucesso!');
                     window.location.href = '/empresa/editaregresso/{$idegresso}';
                 </script>";
                    exit();
                } else {
                    echo "<script>alert('Erro ao atualizar os dados do egresso.');</script>";
                }
            }
        }

        return $response;
    }

    public function removerEgresso(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $idEgresso = $request->id;
        $egressoDAO = new EgressoDAO();

        // Buscar o egresso pelo id da empresa
        $egresso = $egressoDAO->findById($idEgresso);

        try {
            $egressoDAO->delete($egresso->getIdUsuario());
            echo "<script>alert('Egresso excluído com sucesso!'); window.location.href = '/empresa/egressos';</script>";
            exit();
        } catch (PDOException $e) {
            die("Erro ao remover egresso: " . $e->getMessage());
        }

        return $response;
    }

    // ROTAS DE CONTROLE DE VAGAS

    public function renderVaga(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $idVaga = $request->id;
        $vagaDAO = new VagaDAO();
        $candidaturaDAO = new CandidaturaDAO();
        try {

            $vaga = $vagaDAO->findByIdFiltered($idVaga);

            $candidatos = $candidaturaDAO->findAllFiltered($idVaga);

            foreach ($candidatos as &$candidato) {
                if (!empty($candidato['curriculo'])) {
                    $candidato['curriculo_link'] = '/empresa/visualizar/curriculo';
                } else {
                    $candidato['curriculo_link'] = null;
                }
            }
        } catch (PDOException $e) {
            die("Erro ao buscar dados da vaga: " . $e->getMessage());
        }

        echo $this->renderizaHtml('empresa_editar_vaga.php', [
            'vaga' => $vaga,
            'candidatos' => $candidatos
        ]);
        return $response;
    }

    public function visualizarCurriculo(Request $request, Response $response)
    {

        $idAluno = $_POST['id_candidato'];
        $idVaga = $_POST['id_vaga'];

        if (!$idAluno || !$idVaga) {
            http_response_code(400);
            echo "Erro: ID do candidato não fornecido.";
            exit();
        }

        $candidaturaDAO = new CandidaturaDAO();

        try {

            $result = $candidaturaDAO->findCurriculoByIdAlunoVaga($idAluno, $idVaga);

            if (!$result || empty($result['curriculo'])) {
                http_response_code(404);  // Define o status HTTP 404
                echo "<script>
                    alert('Erro: Currículo não encontrado para o candidato com ID:  . $idAluno');
                  </script>";
                exit();
            }

            $curriculo = $result['curriculo'];

            if (is_resource($curriculo)) {
                $curriculo = stream_get_contents($curriculo);
            }

            if (substr($curriculo, 0, 4) !== "%PDF") {
                http_response_code(415);  // Tipo de mídia não suportado
                echo "<script>
                alert('Erro: O conteúdo do currículo não é um PDF válido.');
              </script>";
                exit();
            }

            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="curriculo_' . $idAluno . '.pdf"');
            header('Content-Length: ' . strlen($curriculo));

            // Exibe o conteúdo binário do currículo (em formato PDF)
            echo $curriculo;
        } catch (Exception $e) {
            http_response_code(500);  // Define o status HTTP 500
            echo "Erro interno: " . $e->getMessage();
        }
        return $response;
    }

    public function criarVaga(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();
        $vagaDAO = new VagaDAO();
        $cargo = $_POST['cargo'];
        $idEtapa = $_POST['selVaga'];
        $empresa_id = $empresa->getIdEmpresa();
        $vaga = new Vaga($idEtapa, $cargo, $empresa_id);
        $idVaga = $vagaDAO->insert($vaga);
        $vaga->setIdVaga($idVaga);
        if ($idVaga) {
            echo "<script>
            alert('Vaga criada com sucesso!');
            window.location.href = '/empresa/vagas';
        </script>";
            exit();
        } else {
            echo "<script>alert('Erro ao criar a vaga.');</script>";
        }

        return $response;
    }

    public function editarVaga(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();
        $etapaDAO = new EtapaDAO();
        $vagaDAO = new VagaDAO();

        $idVaga = $_POST['idvaga'];
        $cargo = $_POST['cargo'];
        $idEtapa = $_POST['etapaVaga'];

        $empresa_id = $empresa->getIdEmpresa();
        $etapa = $etapaDAO->findById($idEtapa);
        $etapa_id = $etapa->getIdEtapa();

        $vagaAtualizada = new Vaga($etapa_id, $cargo, $empresa_id);
        $vagaAtualizada->setIdVaga($idVaga);

        if ($vagaDAO->update($vagaAtualizada)) {
            echo "<script>
            alert('Dados da vaga atualizados com sucesso!');
            window.location.href = '/empresa/rendervaga/$idVaga';
        </script>";
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar os dados da vaga.');</script>";
        }

        return $response;
    }

    public function removerVaga(Request $request, Response $response): Response
    {
        $this->verificaSessao();

        $idVaga = $request->id;
        $vagaDAO = new VagaDAO();

        try {
            $vagaDAO->delete($idVaga);
            echo "<script>alert('Vaga excluída com sucesso!'); window.location.href = '/empresa/vagas';</script>";
            exit();
        } catch (PDOException $e) {
            die("Erro ao remover a vaga: " . $e->getMessage());
        }

        return $response;
    }

    public function verificaSessao()
    {
        if (SessaoUsuarioSingleton::getInstance()->getTipoUsuario() !== 'empresa') {
            die("Acesso negado.");
        }
    }

    public function index(Request $request, Response $response): Response
    {
        return $response;
    }

    public function show(Request $request, Response $response): Response
    {

        return $response;
    }

    public function destroy(Request $request, Response $response): Response
    {
        return $response;
    }

    public function create(Request $request, Response $response): Response
    {
        return $response;
    }

    public function update(Request $request, Response $response): Response
    {
        return $response;
    }
}
