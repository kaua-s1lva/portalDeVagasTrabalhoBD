<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/empresa_editar_vaga.css" />
    <link rel="stylesheet" href="../styles/modalEditarVagasEmpresa.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Controle de Vagas</title>
  </head>

  <body>
    <div id="modal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Editar os Dados da Vaga</h2>
        <p>Preencha os campos abaixo referentes à vaga que deseja editar:</p>
          <form id="uploadForm" action="../controller/crud_candidatura.php" enctype="multipart/form-data" method="POST">
            <div class="option-container">
              <p>Cargo:</p>
              <input type="hidden" name="idvaga" id="idvaga">
              <input
                type="text"
                id="emailAluno"
                name="emailAluno"
                placeholder="Ex: Desenvolvedor..."
                required
              />
              <p>Status da vaga:</p>
              <select name="selVaga" id="selVaga">
                <option value="aberto">Em aberto</option>
                <option value="fechado">Fechada</option>
                <option value="pausado">Pausada</option>
              </select>
              <button type="submit" id="confirmar" onclick="">Enviar</button>
          </form>
        </div>
      </div>
    </div>
    <aside>
      <div class="vagas-usu-img">
        <img src="../assets/ufes-logo.png" alt="" />
      </div>
      <div class="links">
        <a href="lista_edicao_perfil_egresso.php">Egressos</a>
        <a href="pag_crud_empresa.php">Perfil</a>
        <a href="lista_vagas_empresa.php">Vagas</a>
        <a href="../controller/logout.php">Log Off</a>
      </div>
    </aside>
    <main>
      <section class="header">
        <h1>Detalhes de Vaga</h1>
        <div class="header-buttons">
          <button>Editar Vaga</button>
        </div>
      </section>
      <section class="container">
        <section class="filtro-vaga">
          <div>
            <label for="cargoFiltro">Cargo:</label>
            <input type="text" id="cargoFiltro">
          </div>
          <div>
            <label for="etapaFiltro">Etapa:</label>
            <input type="text" id="etapaFiltro">
          </div>
        </section>
        <table>
          <thead>
            <tr>
              <th>Candidato</th>
              <th>Egresso</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Leoncio del Valle Liebner</td>
              <td>Josnei Hoffman</td>
              <td class="buttons">
                <button>Ver currículo</button>
              </td>
            </tr>
          </tbody>
        </table>
      </section>
    </main>
    <script src="/js/openModalEditarVagasEmpresa.js"></script>
  </body>
</html>
