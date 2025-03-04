<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/styles/empresa_editar_egresso.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet" />
  <title>Editar Egresso</title>
</head>

<body>
  <aside>
    <div class="vagas-usu-img">
      <img src="/assets/ufes-logo.png" alt="" />
    </div>
    <div class="links">
      <a href="/empresa/egressos"><b>Egressos</b></a>
      <a href="/empresa/perfil">Perfil</a>
      <a href="/empresa/vagas">Vagas</a>
      <a href="/usuario/logout">Log Off</a>
    </div>
  </aside>
  <main>
    <section class="header">
      <h1>Dados Pessoais</h1>
    </section>
    <section class="container">
      <form id="loginForm" method="POST" action="/empresa/editaregresso">
        <div class="crud-form-input">
          <div class="inplbl">
            <label for="username">Nome:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($egresso->getNome()); ?>" required />
          </div>
          <div class="inplbl">
            <label for="password">E-mail:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($egresso->getEmail()); ?>" required />
          </div>
          <div class="inplbl">
            <label for="username">Senha:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($egresso->getSenha()); ?>" required />
          </div>
          <div class="inplbl">
            <label for="username">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($egresso->getCpf()); ?>" readonly required />
          </div>
        </div>
        <div class="crud-form-buttons">
          <button type="submit">Salvar novos dados</button>
        </div>
      </form>
    </section>
  </main>
</body>

</html>