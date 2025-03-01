<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/lista_edicao_perfil_egresso.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet" />
  <title>Indicação de Vagas</title>
</head>

<body>
  <aside>
    <div class="vagas-usu-img">
      <img src="../assets/ufes-logo.png" alt="" />
    </div>
    <div class="links">
      <a href="pag_crud_empresa.php">Perfil</a>
      <a href="lista_edicao_perfil_egresso.php">Egressos</a>
      <a href="lista_vagas_empresa.php">Vagas</a>
      <a href="logout.php">Log Off</a>
    </div>
  </aside>
  <main>
    <section class="header">
      <h1>Egressos</h1>
      <div class="header-buttons">
        <button>Adicionar Novo Egresso</button>
        <button>Update</button>
      </div>
    </section>
    <section class="container">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Data de Cadastro</th>
            <th>Opções</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Kauã de Souza da Silva</td>
            <td>24/09/2023</td>
            <td class="buttons">
              <button>Editar Dados</button>
              <button>Remover Egresso</button>
            </td>
          </tr>
          <tr>
            <td>Gabriel Tetzner Menegueti</td>
            <td>15/02/2025</td>
            <td class="buttons">
              <button>Editar Dados</button>
              <button>Remover Egresso</button>
            </td>
          </tr>
          <tr>
            <td>Flávio Barreto Monteiro Moreira</td>
            <td>22/05/2024</td>
            <td class="buttons">
              <button>Editar Dados</button>
              <button>Remover Egresso</button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>
</body>

</html>