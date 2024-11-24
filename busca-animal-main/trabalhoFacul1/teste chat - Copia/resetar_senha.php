<?php
include('lib/conexao.php');
include('lib/generateRandomString.php');
include('lib/mail.php');


if(isset($_POST['email'])) {
    
    $email = $conn->escape_string($_POST['email']);
    $sql_query = $conn->query("SELECT id, nome FROM usuario WHERE email = '$email'");
    $result = $sql_query->fetch_assoc();

    if($result['id']) {

        $nova_senha = generateRandomString(6);
        $nova_senha_criptografada = password_hash($nova_senha, PASSWORD_DEFAULT);
        $id_usuario = $result['id'];
        $conn->query("UPDATE usuario SET senha = '$nova_senha_criptografada' WHERE id = '$id_usuario'");
        
        enviarEmail($email, "Sua nova senha foi criada", "
        <h1>Olá, usuario(a), </h1>
        <p>Uma nova senha foi definida para a sua conta.</p>
        <p><b>Nova senha:</b> $nova_senha</p>
        ");

    }
    die();
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Esqueceu sua senha? | Busca Animal </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="icon" type="image/png" href="imagens/logotipo.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/novasenha.css">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="imagens/undraw_passing_by_0un9.svg" alt="Imagem de  cachorro passeando na praia">
				</div>

				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title">
                        Esqueceu  <strong> sua senha? </strong>
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="email" placeholder="E-mail">
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							ENVIAR 
						</button>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="login.php">
                            VOLTAR
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