<?php

namespace app\controller\empresa;

use app\controller\ControllerComHtml;
use app\dao\UsuarioDAO;
use app\dao\EgressoDAO;
use app\dao\EmpresaDAO;
use app\dao\EtapaDAO;
use app\dao\VagaDAO;
use app\model\Egresso;
use app\model\Empresa;
use app\model\Vaga;
use app\service\AutenticacaoService;
use app\singleton\ConexaoSingleton;
use app\singleton\SessaoUsuarioSingleton;
use AwesomePackages\AwesomeRoutes\Core\Controller;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Core\Response;
use AwesomePackages\AwesomeRoutes\Enum\StatusCode;
use PDO;
use PDOException;

class EmpresaController extends ControllerComHtml implements Controller
{

    public function renderHome(Request $request, Response $response): Response
    {
        echo $this->renderizaHtml('index.php', []);
        return $response;
    }

    public function renderCreateVagas(Request $request, Response $response): Response
    {
        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();

        $empresa_id = $empresa->getIdUsuario();

        try {
            $conexao = ConexaoSingleton::getInstancia()->getConexao();

            // Consulta as vagas, status da vaga e o total de inscrições (COUNT) para cada vaga
            $stmt = $conexao->prepare("
            SELECT 
                v.idvaga, 
                v.cargo, 
                e.nomeetapa AS nome_etapa,  -- Agora estamos pegando o status da tabela etapa
                COUNT(c.idvaga) AS total_inscricoes
            FROM vaga v
            LEFT JOIN candidatura c ON c.idvaga = v.idvaga
            LEFT JOIN etapa e ON e.idetapa = v.idetapa  -- Fazendo o JOIN correto com a tabela etapa
            WHERE v.idempresa = ?
            GROUP BY v.idvaga, e.idetapa
        ");
            $stmt->execute([$empresa_id]);

            $vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }

        echo $this->renderizaHtml('lista_vagas_empresa.php', ['vagas' => $vagas]);
        return $response;
    }

    public function renderVaga(Request $request, Response $response): Response
    {
        $idVaga = $request->id;
        $vagaDAO = new VagaDAO();
        $conexao = ConexaoSingleton::getInstancia()->getConexao();

        try {
            // Busca informações da vaga
            $stmtVaga = $conexao->prepare("
                SELECT v.idVaga AS idvaga, v.cargo, e.nomeEtapa AS nome_etapa
                FROM VAGA v
                INNER JOIN ETAPA e ON v.idEtapa = e.idEtapa
                WHERE v.idVaga = ?
            ");
            $stmtVaga->execute([$idVaga]);
            $vaga = $stmtVaga->fetch(PDO::FETCH_ASSOC);

            // Busca candidatos da vaga
            $stmtCandidatos = $conexao->prepare("
                SELECT 
                    u.idUsuario AS id_candidato,
                    u.nomeUsuario AS nome_candidato,
                    CASE WHEN i.idEgresso IS NOT NULL THEN 1 ELSE 0 END AS tem_indicacao,
                    eu.nomeUsuario AS nome_egresso_indicador,
                    s.nomeStatus AS status_candidatura,
                    c.curriculo AS curriculo
                FROM CANDIDATURA c
                INNER JOIN USUARIO u ON c.idAluno = u.idUsuario
                LEFT JOIN INDICACAO i ON c.idAluno = i.idAluno AND c.idVaga = i.idVaga
                LEFT JOIN USUARIO eu ON i.idEgresso = eu.idUsuario
                LEFT JOIN STATUS s ON i.idStatus = s.idStatus
                WHERE c.idVaga = ?
            ");
            $stmtCandidatos->execute([$idVaga]);
            $candidatos = $stmtCandidatos->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro ao buscar dados da vaga: " . $e->getMessage());
        }

        echo $this->renderizaHtml('empresa_editar_vaga.php', [
            'vaga' => $vaga,
            'candidatos' => $candidatos
        ]);
        return $response;
    }

    public function criarVaga(Request $request, Response $response): Response
    {
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
        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();
        $etapaDAO = new EtapaDAO();
        $vagaDAO = new VagaDAO();
       

        $idVaga = $_POST['idvaga'];
        $cargo = $_POST['cargo'];
        $idEtapa = $_POST['etapaVaga'];

        $empresa_id = $empresa->getIdEmpresa();
        $etapa = $etapaDAO->findById($idEtapa);
        $etapa_id = $etapa->getIdEtapa();
   
        $vagaAtualizada = new Vaga($idVaga, $etapa_id, $cargo, $empresa_id);

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
        $idVaga = $request->id;
        $vagaDAO = new VagaDAO();

        // Buscar o egresso pelo id da empresa
        $vaga = $vagaDAO->findById($idVaga);

        try {
            $vagaDAO->delete($vaga->getIdVaga());
            echo "<script>alert('Vaga excluída com sucesso!'); window.location.href = '/empresa/vagas';</script>";
            exit();
        } catch (PDOException $e) {
            die("Erro ao remover a vaga: " . $e->getMessage());
        }

        return $response;
    }

    public function renderCreatePerfilEmpresa(Request $request, Response $response): Response
    {
        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();

        // Verifica se o usuário é uma empresa
        if (SessaoUsuarioSingleton::getInstance()->getTipoUsuario() !== 'empresa') {
            die("Acesso negado.");
        }

        echo $this->renderizaHtml('pag_crud_empresa.php', ['empresa' => $empresa]);
        return $response;
    }


    public function renderCreateEgressos(Request $request, Response $response): Response
    {
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

    public function renderCreateCriarEgresso(Request $request, Response $response): Response
    {
        echo $this->renderizaHtml('empresa_editar_egresso.php', []);
        return $response;
    }


    public function renderCreateEditarEgresso(Request $request, Response $response): Response
    {
        $idEgresso = $request->id;
        $egressoDAO = new EgressoDAO();

        // Buscar o egresso pelo id da empresa
        $egresso = $egressoDAO->findById($idEgresso);

        echo $this->renderizaHtml('empresa_editar_egresso.php', ['egresso' => $egresso]);
        return $response;
    }


    public function editarEmpresa(Request $request, Response $response): Response
    {
        session_start();
        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();
        $empresa_id = $empresa->getIdUsuario();
        $empresaDAO = new EmpresaDAO();
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

        return $response;
    }


    public function excluirEmpresa(Request $request, Response $response): Response
    {
        $empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();
        $empresaDAO = new EmpresaDAO();

        // Excluir a empresa
        if ($empresaDAO->delete($empresa->getIdEmpresa())) {
            echo "<script>alert('Empresa excluída com sucesso!'); window.location.href = '/';</script>";
            SessaoUsuarioSingleton::getInstance()->logout();
        } else {
            echo "<script>alert('Erro ao excluir a empresa.');</script>";
        }

        return $response;
    }

    public function criarEgresso(Request $request, Response $response): Response
    {
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

    public function editarEgresso(Request $request, Response $response): Response
    {
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
                    window.location.href = '/empresa/editaregresso/$idegresso';
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

    public function atualizarEmpresa(Request $request, Response $response): Response
    {

        // Verificar se o usuário está logado como empresa
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'empresa') {
            header('Location: ../index.php'); // Redireciona se não estiver logado
            exit();
        }

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
                    echo "<script>alert('Empresa excluída com sucesso!'); window.location.href = '/';</script>";
                    SessaoUsuarioSingleton::getInstance()->logout();
                } else {
                    echo "<script>alert('Erro ao excluir a empresa.');</script>";
                }
            }
        }
        return $response;
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
