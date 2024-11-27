<?php

session_start();

include ('lib/conexao.php'); // Arquivo de conexão ao banco de dados

// Variável para armazenar a mensagem de erro, se houver
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta para obter a senha hash e ID do usuário com o email fornecido
    $stmt = $conn->prepare("SELECT id, senha, is_admin FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $senha_hash, $is_admin);
    $stmt->store_result(); // Armazena o resultado para verificar se existe uma linha retornada
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $senha_hash, $is_admin);
        $stmt->fetch();
        
        // Verifica se a senha fornecida corresponde ao hash armazenado
        if (password_verify($senha, $senha_hash)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['is_admin'] = $is_admin;

            // Redirecione para a página principal ou qualquer outra página após o login bem-sucedido
            header("Location: index.php");
            exit;
            
        } else {
            $erro = "E-mail ou senha incorretos!";
        }
    } else {
        $erro = "E-mail ou senha incorretos!";
	    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Login | Busca Animal </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="icon" type="image/png" href="imagens/logotipo.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div id="logo-arrow-container">
        <a id="logo-link" href="index.php">
        <img id="site-logo" src="imagens/logotipo.png" alt="Logo do site" />
        </a>
        <a id="back-arrow" href="javascript:history.back();">&#8592;</a>
    </div>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="imagens/undraw_beach_day_cser.svg" alt="Imagem de  cachorro passeando na praia">
				</div>

				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title">
                        Login
					
					<p> Faça login para uma melhor experiência!</p>
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="email" placeholder="E-mail">
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="password" name="senha" placeholder="Senha" maxlength="8">
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<?php if ($erro): ?>
						<p class="error"><?php echo $erro; ?></p>
					<?php endif; ?>


					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							ENTRAR
						</button>
					</div>

					<div class="text-center p-t-12">
						<a class="txt2" href="resetar_senha.php">
                            Esqueceu sua senha?
                        </a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="cadastro_usuario.php">
                            Crie sua conta
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>