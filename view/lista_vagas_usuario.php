<?php
  session_start();
  if (!isset($_SESSION['usuario_id']) == true && !isset($_SESSION['tipo_usuario']) == 'aluno') {
    header('Location: login_screen.html');
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/lista_vagas_usuario.css" />
    <title>Vagas disponíveis</title>
  </head>
  <body>
    <aside>
      <img src="../assets/ufes-logo.png" alt="" />
      <a href="">Perfil</a>
      <span></span>
      <?php
        require_once('../model/Usuario.php');
        require_once('../dao/UsuarioDAO.php');
        require_once('../dao/AlunoDAO.php');
        require_once('../model/Aluno.php');
        
        require_once('../singleton/SessaoUsuarioSingleton.php');

        $usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();
        print_r($usuario_logado->getNome());
        

      ?>
      <a href="">Gerência de Vagas</a>
    </aside>
    <main>
      <section>
        <h1>Vagas disponíveis</h1>
        <button>Refresh</button>
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
                <button>Candidatar-se</button>
                <button>Salvar Vaga</button>
              </td>
            </tr>
            <tr>
              <td>Analista De Dados Junior</td>
              <td>Unreal Data</td>
              <td class="buttons">
                <button>Candidatar-se</button>
                <button>Salvar Vaga</button>
              </td>
            </tr>
          </tbody>
        </table>
      </section>
    </main>
  </body>
</html>
