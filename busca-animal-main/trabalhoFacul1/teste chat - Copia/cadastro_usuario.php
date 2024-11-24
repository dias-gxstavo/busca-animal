<?php
session_start();
include('lib/mail.php');
include('lib/conexao.php');


$erro = "";

if(isset($_POST['enviar'])){

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], algo: PASSWORD_DEFAULT);  // Criptografa a senha
    $telefone = $_POST['telefone'];
    
    $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, telefone) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $nome, $email, $senha,  $telefone);

    if ($stmt->execute()) {
      $usuario_id = $stmt->insert_id;

      // Cria a sessão para o novo usuário, como se ele tivesse feito login
      $_SESSION['usuario_id'] = $usuario_id;
      $_SESSION['usuario_nome'] = $nome;

      // Redireciona o usuário para a página index.php já logado
      header("Location: index.php");
      exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    //Efetua o envio de e-mail de boas vindas se o cadastro for efetuado com sucesso.
    if($stmt->execute()) {
      
    enviarEmail($email, "Cadastro de conta efetuado.", 
      "<h1> Prezado(a) dono, </h1>
        <p> 
          Lembre-se de que você não está sozinho nessa busca. 
          Existem muitas pessoas que entendem o que você está passando e estão dispostas a ajudar. 
          Continue a procurar, espalhe cartazes, converse com vizinhos e utilize as redes sociais para aumentar as chances de encontrá-lo. 
          Cada pequeno esforco pode fazer a diferença.
          <br>

          Estamos aqui para te apoiar, conte conosco. Juntos, podemos fazer essa jornada um pouco mais leve. <br>
        </p>

          " );
    }
    $stmt->close();
}}



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="imagens/logotipo.png" type="image/x-icon">
  <title>Cadastro | Busca Animal</title>
  <link rel="stylesheet" href="../teste chat - Copia/css/stylecadastro.css">
  </head>
<body>

  <main class="main-container">
  
  <div class="container">
     
  <header class="header-logo">
    <div class="logo-container">
      <a href="index.php">
        <img src="imagens/logotipo.png" alt="Logo">
      </a>
    </div>
  </header>  

  <div class="title">Cadastre-se</div>

      <div class="content">
      
        <?php if ($erro): ?>
						<p class="error"><?php echo $erro; ?></p>
				<?php endif; ?>

        <form action="" method="POST">
          <div class="user-details">
            
            <div class="input-box">
              <span class="details">Nome Completo</span>
              <input type="text"  name="nome" placeholder="Digite seu nome completo" required>
            </div>

            <div class="input-box">
              <span class="details">Email</span>
              <input type="email"  name="email" placeholder="Digite seu email" required>
            </div>

            <div class="input-box">
              <span class="details">Senha</span>
              <input type="password" name="senha" placeholder="Senha com até 8 caracteres" maxlength="8" required>
            </div>

            <div class="input-box">
              <span class="details">Confirmar Senha</span>
              <input type="password" name="confirma_senha" placeholder="Confirme sua senha" maxlength="8" required>
            </div>

            <div class="input-box">
              <span class="details">Telefone</span>
              <input type="text"  name="telefone" placeholder="(XX) XXXXX-XXXX" required>
            </div>
         
          <div class="button">
            <input type="submit" name="enviar" value="ENVIAR">
          </div>

          <div class="login-link">
            Já tem uma conta? <a href="index.php?login=true">Entre aqui</a>         
          </div>
        </form>
      </div>
    </div>

  </main>


</body>
</html>
