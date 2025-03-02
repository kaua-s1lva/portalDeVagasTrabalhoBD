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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Verifica o login
    $resultado = verificarLogin($username, $password);

    if ($resultado === true) {
        // Redireciona o usuário baseado no tipo de usuário
        if ($_SESSION['usuario_tipo'] == 'aluno') {
            header("Location: ../view/lista_vagas_aluno.php");  // Página para Aluno
        } elseif ($_SESSION['usuario_tipo'] == 'egresso') {
            header("Location: ../view/lista_indicacoes_egresso.php");  // Página para Egresso
        } elseif ($_SESSION['usuario_tipo'] == 'empresa') {
            header("Location: ../view/lista_vagas_empresa.php");  // Página para Empresa
        }
        exit;
    } else {
        echo "<script>alert('$resultado'); window.location.href = '../index.php';</script>";
        exit;
    }
    header("Location: index.php");
} else {
    echo "Método de requisição inválido.";
}
