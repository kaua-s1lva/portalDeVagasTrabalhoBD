<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/lista_vagas_empresa.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Controle de Vagas</title>
  </head>
  <body>
    <aside>
      <div class="vagas-usu-img">
        <img src="../assets/ufes-logo.png" alt="" />
      </div>
      <div class="links">
        <a href="">Perfil</a>
        <a href="">Egressos</a>
        <a href="">Vagas</a>
        <a href="">Log Off</a>
      </div>
    </aside>
    <main>
      <section class="header">
        <h1>Controle de Vagas</h1>
        <div class="header-buttons">
          <button>Criar Nova Vaga</button>
          <button>Update</button>
        </div>
      </section>
      <section class="container">
        <table>
          <thead>
            <tr>
              <th>Descrição</th>
              <th>Contratante</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Desenvolvedor Web Júnior</td>
              <td>Stacks LTDA</td>
              <td class="buttons">
                <button>Editar vaga</button>
                <button>Remover vaga</button>
              </td>
            </tr>
            <tr>
              <td>Analista De Dados Junior</td>
              <td>Unreal Data</td>
              <td class="buttons">
                <button>Editar vaga</button>
                <button>Remover vaga</button>
              </td>
            </tr>
          </tbody>
        </table>
      </section>
    </main>
  </body>
</html>
