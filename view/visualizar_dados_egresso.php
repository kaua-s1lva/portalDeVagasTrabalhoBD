<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/visualizar_dados_egresso.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Visualizar Egresso</title>
  </head>
  <body>
    <aside>
      <div class="cad-egresso-title">
        <img src="../assets/ufes-logo.png" alt="ufes-logo" />
      </div>
      <div class="links">
        <a href="">Perfil</a>
        <a href="">Indicação de vagas</a>
        <a href="../controller/logout.php">Log Off</a>
      </div>
    </aside>
    <main>
      <section class="header">
        <h1>Dados Pessoais</h1>
      </section>
      <section class="container">
        <form id="viewForm">
          <div class="crud-form-input">
            <div class="inplbl">
              <label for="username">Nome / Razão Social:</label>
              <input
                type="text"
                id="username"
                name="username"
                value="Gabriel Tetzner Menegueti"
                readonly
              />
            </div>
            <div class="inplbl">
              <label for="email">E-mail:</label>
              <input
                type="email"
                id="email"
                name="email"
                value="tetzner@email.com"
                readonly
              />
            </div>
            <div class="inplbl">
              <label for="password">Senha:</label>
              <input
                type="text"
                id="password"
                name="password"
                value="123456"
                readonly
              />
            </div>
            <div class="inplbl">
              <label for="cpf">CPF / CNPJ:</label>
              <input
                type="text"
                id="cpf"
                name="cpf"
                value="123.456.789-00"
                readonly
              />
            </div>
          </div>
        </form>
      </section>
    </main>
  </body>
</html>
