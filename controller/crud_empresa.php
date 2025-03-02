<?php
require_once('../model/Usuario.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/EmpresaDAO.php');

require_once('../model/Empresa.php');

require_once('../singleton/SessaoUsuarioSingleton.php');

session_start();

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
        // Recuperar os dados do formulário
        // Atualizar os dados da empresa
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
            window.location.href = '../view/pag_crud_empresa.php';
        </script>";
        exit();
       
        } else {
            echo "<script>alert('Erro ao atualizar os dados da empresa.');</script>";
        }
    } else {
        // Excluir a empresa
        if ($empresaDAO->delete($empresa->getIdEmpresa())) {
            echo "<script>alert('Empresa excluída com sucesso!'); window.location.href = '../index.php';</script>";
            SessaoUsuarioSingleton::getInstance()->logout();
        } else {
            echo "<script>alert('Erro ao excluir a empresa.');</script>";
        }
    }
}
