<?php
session_start();
require_once('../service/AutenticacaoService.php');
require_once('../singleton/SessaoUsuarioSingleton.php');
require_once('../model/Usuario.php');
require_once('../model/Aluno.php');
require_once('../model/Empresa.php');
require_once('../model/Egresso.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/AlunoDAO.php');
require_once('../dao/EmpresaDAO.php');
require_once('../dao/EgressoDAO.php');

function verificarLogin($username, $password) {
    if (empty($username) || empty($password)) {
        return "Preencha todos os campos.";
    }

    // Criando o serviço de autenticação
    $autenticacaoService = new AutenticacaoService();

    // Verifica se a autenticação foi bem-sucedida
    $usuario = $autenticacaoService->autenticar($username, $password);
   // echo $usuario->getNome();
    if ($usuario) {
        return true;
    }

    return "Usuário ou senha inválidos.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Verifica o login
    $resultado = verificarLogin($username, $password);

    if ($resultado === true) {
        // Redireciona o usuário baseado no tipo de usuário
        if ($_SESSION['usuario_tipo'] == 'aluno') {
            header("Location: ../view/lista_vagas_usuario.html");  // Página para Aluno
        } elseif ($_SESSION['usuario_tipo'] == 'egresso') {
            header("Location: ../view/lista_indicacoes_egresso.html");  // Página para Egresso
        } elseif ($_SESSION['usuario_tipo'] == 'empresa') {
            header("Location: ../view/lista_vagas_empresa.html");  // Página para Empresa
        }
        exit;
    } else {
        echo "<p style='color: red;'>$resultado</p>";  // Exibe erro
    }
} else {
    echo "Método de requisição inválido.";
}
?>
