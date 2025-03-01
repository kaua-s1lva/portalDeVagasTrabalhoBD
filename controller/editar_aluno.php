<?php
session_start();

require_once('../model/Usuario.php');
require_once('../model/Aluno.php');
require_once('../model/Empresa.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/AlunoDAO.php');
require_once('../dao/EmpresaDAO.php');
require_once('../singleton/SessaoUsuarioSingleton.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Resgata os dados enviados pelo formulário
    $nome      = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email     = isset($_POST['email']) ? $_POST['email'] : '';
    $senha     = isset($_POST['senha']) ? $_POST['senha'] : '';
    $cpf       = isset($_POST['cpf']) ? $_POST['cpf'] : '';

    if (strlen($cpf) == 11) {
        $aluno = new Aluno($nome, $email, $senha, $cpf);
        $usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();
        $aluno->setIdAluno($usuario_logado->getIdAluno());
        $aluno->setIdUsuario($usuario_logado->getIdUsuario());

        $dao = new AlunoDAO();
        $dao->update($aluno);
        header("Location: ../view/pag_crud_aluno.php");
    } else {
        echo "CPF inválido";
    }
    
} else {
    echo "Método de requisição inválido.";
}
