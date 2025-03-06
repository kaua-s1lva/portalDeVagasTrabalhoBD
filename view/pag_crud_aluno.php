<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/pag_crud_usuario.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Manter Aluno</title>
  </head>
  <body>
    <aside>
      <div class="vagas-usu-img">
        <img src="../assets/ufes-logo.png" alt="ufes-logo" />
      </div>
      <div class="links">
        <a href="/aluno/visualizar"><b>Perfil</b></a>
        <a href="/aluno">Visualizar Vagas</a>
        <a href="/usuario/logout">Log Off</a>
      </div>
    </aside>
    <main>
      <section class="header">
        <h1>Atualizar Dados Pessoais</h1>
      </section>
      <section class="container">
        <form id="loginForm" action="/aluno/editar" method="POST">
          <div class="crud-form-input">
            <div class="inplbl">
              <label for="nome">Nome:</label>
              <input type="text" id="nome" name="nome" value="<?= $usuario_logado->getNome() ?>" required />
            </div>
            <div class="inplbl">
              <label for="email">E-mail:</label>
              <input type="text" id="email" name="email" value="<?= $usuario_logado->getEmail() ?>" required readonly />
            </div>
            <div class="inplbl">
              <label for="senha">Senha:</label>
              <input type="text" id="senha" name="senha" value="<?= $usuario_logado->getSenha() ?>" required />
            </div>
            <div class="inplbl">
              <label for="cpf">CPF:</label>
              <input type="text" id="cpf" name="cpf" value="<?= $usuario_logado->getCpf() ?>" required readonly />
            </div>
          </div>
          <div class="crud-form-buttons">
            <button type="submit" id="salvar" name="salvar">Salvar</button>
            <button type="submit" id="excluir" name="excluir" onclick="this.form.action='/aluno/excluir'; return confirm('Tem certeza que deseja excluir seu perfil?');">Excluir</button>
          </div>
        </form>
      </section>
    </main>
  </body>
</html>
