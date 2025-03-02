<?php
session_start();
require_once('../model/Usuario.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/EmpresaDAO.php');
require_once('../model/Empresa.php');
require_once('../dao/EgressoDAO.php');
require_once('../model/Egresso.php');
require_once('../singleton/SessaoUsuarioSingleton.php');
require_once('../singleton/ConexaoSingleton.php');

// Verifica se o usuário está logado e é uma empresa
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'empresa') {
    header('Location: ../index.php');
    exit();
}

$usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();
$empresa_id = $usuario_logado->getIdUsuario();

$egressoDAO = new EgressoDAO();

// Buscar o egresso pelo id da empresa
$egresso = $egressoDAO->findByIdEmpresa($empresa_id);

// Se a operação for de remoção
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    try {
        // Remover o egresso do banco
        $egressoDAO->delete($egresso->getIdUsuario());
        echo "<script>alert('Egresso excluído com sucesso!'); window.location.href = '../view/lista_edicao_perfil_egresso.php';</script>";
        exit();
    } catch (PDOException $e) {
        die("Erro ao remover egresso: " . $e->getMessage());
    }
}

// Se a operação for de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['username'];
    $email = $_POST['email'];
    $senha = $_POST['password'];
    $cpf = $_POST['cpf'];

    // Verificar se o egresso existe antes de tentar atualizar
    if (!$egresso) {
        // Se não houver egresso cadastrado, é uma criação (inserção)
        $egressoCriado = new Egresso($nome, $email, $senha, $cpf, $empresa_id);

        if ($egressoDAO->insert($egressoCriado)) {
            echo "<script>
                 alert('Egresso criado com sucesso!');
                 window.location.href = '../view/lista_edicao_perfil_egresso.php';
             </script>";
            exit();
        } else {
            echo "<script>alert('Erro ao criar o egresso.');</script>";
        }
    } else {

        // Atualiza o egresso com os novos dados
        $egressoAtualizado = new Egresso($nome, $email, $senha, $cpf, $empresa_id);
        $egressoAtualizado->setIdUsuario($egresso->getIdUsuario());

        if ($egressoDAO->update($egressoAtualizado)) {
            echo "<script>
            alert('Dados do egresso atualizados com sucesso!');
            window.location.href = '../view/lista_edicao_perfil_egresso.php';
        </script>";
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar os dados do egresso.');</script>";
        }
    }
}
