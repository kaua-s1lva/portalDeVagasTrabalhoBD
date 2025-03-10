<?php

session_start();

// Se for um arquivo existente (CSS, JS, imagens, etc.), deixa o PHP servir normalmente
if (php_sapi_name() === 'cli-server') {
    $filePath = __DIR__ . '/' . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    if (is_file($filePath)) {
        return false;
    }
}

if ($_SERVER['REQUEST_URI'] === '/favicon.ico') {
    http_response_code(204); // Responde sem conteúdo
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use app\controller\aluno\AlunoController;
use app\controller\candidatura\CandidaturaController;
use app\controller\egresso\EgressoController;
use app\controller\usuario\UsuarioController;
use app\controller\empresa\EmpresaController;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Core\Response;
use AwesomePackages\AwesomeRoutes\Router;

$request = new Request($_POST, isset($_GET['id']) ? (int)$_GET['id'] : null);

$router = new Router();

// Defina suas rotas

$router->get('/', new UsuarioController(), 'renderHome');
$router->get('/usuario/novo', new UsuarioController(), 'renderCreate');

$router->post('/usuario/novo', new UsuarioController(), 'create');
$router->post('/usuario/login', new UsuarioController(), 'login');

$router->get('/usuario/logout', new UsuarioController(), 'logout');

//ROTAS DE ALUNO

$router->get('/aluno', new AlunoController(), 'index');
$router->get('/aluno/visualizar', new AlunoController(), 'show');
$router->post('/aluno/editar', new AlunoController(), 'update');
$router->post('/aluno/excluir', new AlunoController(), 'destroy');

$router->post('/aluno/candidatar', new CandidaturaController(), 'create');

//ROTAS DE EGRESSO

$router->get('/egresso', new EgressoController(), 'index');
$router->post('/egresso/indicar', new EgressoController(), 'create');
$router->get('/egresso/visualizar', new EgressoController(), 'show');

// ROTAS DE EMPRESA

// ROTAS DE VISUALIZAÇÃO

$router->get('/empresa/vagas', new EmpresaController(), 'renderVagas');
$router->get('/empresa/perfil', new EmpresaController(), 'renderPerfilEmpresa');
$router->get('/empresa/egressos', new EmpresaController(), 'renderEgressos');

// ROTAS DE PERFIL DE EMPRESA

$router->post('/empresa/atualizarempresa', new EmpresaController(), 'atualizarEmpresa');

// ROTAS DE CONTROLE DE EGRESSOS

$router->get('/empresa/criaregresso', new EmpresaController(), 'renderCriarEgresso');
$router->post('/empresa/salvaregresso', new EmpresaController(), 'criarEgresso');
$router->get('/empresa/editaregresso/:id', new EmpresaController(), 'renderEditarEgresso');
$router->post('/empresa/editaregresso', new EmpresaController(), 'editarEgresso');
$router->get('/empresa/removeregresso/:id', new EmpresaController(), 'removerEgresso');

// ROTAS DE CONTROLE DE VAGAS

$router->get('/empresa/rendervaga/:id', new EmpresaController(), 'renderVaga');
$router->post('/empresa/visualizar/curriculo', new EmpresaController(), 'visualizarCurriculo');
$router->post('/empresa/criarvaga', new EmpresaController(), 'criarVaga');
$router->post('/empresa/editarvaga', new EmpresaController(), 'editarVaga');
$router->get('/empresa/removervaga/:id', new EmpresaController(), 'removerVaga');

// Processa a requisição
try{
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    // Caso a rota não seja encontrada
    echo('Erro 404: Rota não encontrada.');
}