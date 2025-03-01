<?php
require_once('../model/Usuario.php');
require_once('../model/Aluno.php');
require_once('../model/Empresa.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/AlunoDAO.php');
require_once('../dao/EmpresaDAO.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Resgata os dados enviados pelo formulário
    $nome      = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email     = isset($_POST['email']) ? $_POST['email'] : '';
    $senha     = isset($_POST['senha']) ? $_POST['senha'] : '';
    $cpf_cnpj  = isset($_POST['cpf_cnpj']) ? $_POST['cpf_cnpj'] : '';

    if (strpos($email, "@edu.ufes.br") !== false) {
        $aluno = new Aluno($nome, $email, $senha, $cpf_cnpj);
        $dao = new AlunoDAO();
        $dao->insert($aluno);
    } else {
        $empresa = new Empresa($nome, $email, $senha, $cpf_cnpj);
        $dao = new EmpresaDAO();
        $dao->insert($empresa);
    }

    header("Location: ../view/login_screen.html");

    
/*
    // Exemplo de como utilizar os dados: exibindo-os
    echo "<h2>Dados Recebidos:</h2>";
    echo "<p>Nome: " . htmlspecialchars($nome) . "</p>";
    echo "<p>E-mail: " . htmlspecialchars($email) . "</p>";
    echo "<p>Senha: " . htmlspecialchars($senha) . "</p>";
    echo "<p>CPF / CNPJ: " . htmlspecialchars($cpf_cnpj) . "</p>";
*/
    // Aqui você pode incluir a lógica para validar, processar e armazenar os dados em um banco de dados
} else {
    echo "Método de requisição inválido.";
}
