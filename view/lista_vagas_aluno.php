<?php
    session_start();
    if (!isset($_SESSION['usuario_id']) == true && !isset($_SESSION['tipo_usuario']) == 'aluno') {
        header('Location: login_screen.html');
    }

    require_once('../model/Usuario.php');
    require_once('../dao/UsuarioDAO.php');
    require_once('../dao/AlunoDAO.php');
    require_once('../model/Aluno.php');
        
    require_once('../singleton/SessaoUsuarioSingleton.php');

    $usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();

    require_once('../dao/IDAO.php');
    require_once('../dao/VagaDAO.php');
    require_once('../model/Vaga.php');
    $vagaDAO = new VagaDAO();
    $dados = $vagaDAO->findAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/lista_vagas_usuario.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Vagas disponíveis</title>
  </head>
  <body>
    <aside>

      <img src="../assets/ufes-logo.png" alt="" />
      <span></span>

      <div class="links">
        <a href="">Perfil</a>
        <a href="">Visualizar Vagas</a>
      </div>
    </aside>
    <main>
      <section class="header">
        <h1>Vagas disponíveis</h1>
        <button>Update</button>
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

            <?php foreach($dados as $dado) { ?>

            <tr>
              <td><?= $dado['vaga']['cargo'] ?></td>
              <td><?= $dado['usuario']['nome'] ?></td>
              <td class="buttons">
                <button>Candidatar-se</button>
              </td>
            </tr>
            
            <?php } ?>
            
          </tbody>
        </table>
      </section>
    </main>
  </body>
</html>
