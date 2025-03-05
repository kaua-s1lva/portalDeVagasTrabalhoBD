<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/lista_edicao_perfil_egresso.css" />
    <link rel="stylesheet" href="../styles/tableScroll.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap"
      rel="stylesheet"
    />
    <title>Gestão de Egressos</title>
  </head>

  <body>
    <aside>
      <div class="vagas-usu-img">
        <img src="../assets/ufes-logo.png" alt="Logo UFES" />
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
        <h1>Gestão de Egressos</h1>
        <div class="header-buttons">
          <button onclick="window.location.href='/empresa/criaregresso'">
            Adicionar Novo Egresso
          </button>
        </div>
      </section>
      <section class="container">
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Nome</th>
                <th>Data de Cadastro</th>
                <th>Opções</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($egressos)) : ?>
              <?php foreach ($egressos as $egresso) : ?>
              <tr>
                <td><?php echo htmlspecialchars($egresso->nomeusuario); ?></td>
                <td><?= date("d/m/Y", strtotime($egresso->created_at)) ?></td>
                <td class="buttons">
                  <button
                    onclick="editarEgresso(<?php print_r($egresso->idegresso); ?>)"
                  >
                    Editar
                  </button>
                  <button
                    onclick="removerEgresso(<?php print_r($egresso->idegresso); ?>)"
                  >
                    Remover
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php else : ?>
              <tr>
                <td colspan="3">Nenhum egresso cadastrado.</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>

    <script>
      function editarEgresso(idEgresso) {
        window.location.href = "/empresa/editaregresso/" + idEgresso;
      }

      function removerEgresso(idEgresso) {
        if (confirm("Tem certeza que deseja remover este egresso?")) {
          window.location.href = "/empresa/removeregresso/" + idEgresso;
        }
      }
    </script>
  </body>
</html>
