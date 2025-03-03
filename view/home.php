<?php
  require 'vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/css_reset.css" />
    <link rel="stylesheet" href="styles/login_screen.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Página de Login</title>
  </head>
  <body>
    <main>
      <section class="login-section">
        <div class="login-logo">
          <img src="assets/ufes-logo.png" alt="login-page-logo" />
        </div>
        <div class="login-form">
          <h1>Portal de Estágios UFES</h1>
          <form id="loginForm" action="/usuario/login" method="POST">
            <!-- <label for="username">E-mail:</label> -->
            <input
              type="text"
              id="username"
              name="username"
              required
              placeholder="E-mail"
            />
            <input
              type="password"
              id="password"
              name="password"
              required
              placeholder="Senha"
            />
            <button type="submit">Acessar</button>
          </form>
        </div>
        <span class="line"></span>
        <div class="registration">
          <p>Ainda não possui um cadastro?</p>
          <a href="./view/cadastro_usuario_screen.php">Registrar-se</a>
        </div>
      </section>
      <section class="op-art">
        <img src="assets/login_screen_image.png" alt="login-page-art" />
      </section>
    </main>
  </body>
</html>
