<?php

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      // Resgata os dados enviados pelo formulário
      $nome      = isset($_POST['nome']) ? $_POST['nome'] : '';
      $email     = isset($_POST['email']) ? $_POST['email'] : '';
      $senha     = isset($_POST['senha']) ? $_POST['senha'] : '';
      $cpf_cnpj  = isset($_POST['cpf_cnpj']) ? $_POST['cpf_cnpj'] : '';
  
      // Exemplo de como utilizar os dados: exibindo-os
      echo "<h2>Dados Recebidos:</h2>";
      echo "<p>Nome: " . htmlspecialchars($nome) . "</p>";
      echo "<p>E-mail: " . htmlspecialchars($email) . "</p>";
      echo "<p>Senha: " . htmlspecialchars($senha) . "</p>";
      echo "<p>CPF / CNPJ: " . htmlspecialchars($cpf_cnpj) . "</p>";
  
      // Aqui você pode incluir a lógica para validar, processar e armazenar os dados em um banco de dados
  } else {
      echo "Método de requisição inválido.";
  }
  

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/css_reset.css" />
    <link rel="stylesheet" href="../styles/cadastro_usuario.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Cadastro de Usuário</title>
  </head>
  <body>
    <aside>
      <h1>Cadastro de Usuário</h1>
      <p>Insira seus dados para se cadastrar e utilizar o sistema</p>
      <img src="../assets/ufes-logo.png" alt="logo-ufes-cadastro" />
    </aside>
    <main>
      <h1>Dados Pessoais</h1>
      <form id="loginForm" action="processar_cadastro.php" method="POST">
        <label for="nome">Nome / Razão Social:</label>
        <input
          type="text"
          id="nome"
          name="nome"
          required
          placeholder="Nome / Razão Social"
        />

        <label for="email">E-mail:</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          placeholder="E-mail"
        />

        <label for="senha">Senha:</label>
        <input
          type="password"
          id="senha"
          name="senha"
          required
          placeholder="Senha"
        />

        <label for="cpf_cnpj">CPF / CNPJ:</label>
        <input
          type="text"
          id="cpf_cnpj"
          name="cpf_cnpj"
          required
          placeholder="CPF ou CNPJ"
        />

        <button type="submit">Enviar meus dados</button>
      </form>
    </main>
  </body>
</html>
