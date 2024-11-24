<?php 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// CARREGA O AUTOLOAD DO COMPOSER
require 'vendor/autoload.php';


if (isset($_POST['nome'])    &&
	isset($_POST['email'])   &&
    isset($_POST['assunto']) &&
    isset($_POST['mensagem'])) {
		
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$assunto = $_POST['assunto'];
	$mensagem = $_POST['mensagem'];

// FAZ A VALIDAÇÃO DE INFORMAÇÕES VINDAS DO FORMULÁRIO DE CONTATO
if (isset($_POST['nome']) && isset($_POST['email'])   && isset($_POST['assunto']) && isset($_POST['mensagem'])) {
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     	$em = "Formato inválido de e-mail.";
    }

    if (empty($nome) || empty($assunto) || empty($mensagem) ) {
    	$em = "Preencha todos os dados corretamente.";
    }

    // Cria uma nova instância
	$mail = new PHPMailer(true);

	try {
	    $mail->isSMTP();                               
	    $mail->Host = 'smtp.gmail.com'; 
	    $mail->SMTPAuth   = true;
	    //Meu Email
	    $mail->Username= 'projetobusca.animal@gmail.com';
	    //Senha do aplicativo (Google);
	    $mail->Password = 'kgbs wptr ujvr nmmt'; 
	    $mail->SMTPSecure = "ssl";          
	    $mail->Port       = 465;                                  
	    
        // Remetente
	    $mail->setFrom($email, $nome);  

	    // Destinatário
	    $mail->addAddress('projetobusca.animal@gmail.com'); 

	    //Conteúdo do e-mail
	    $mail->isHTML(true);                             
	    $mail->Subject = $assunto;
	    $mail->Body = "
			   <p><strong>Nome</strong>: $nome</p>
			   <p><strong>Email</strong>: $email</p>
			   <p><strong>Assunto</strong>: $assunto</p>
			   <p><strong>Mensagem</strong>: $mensagem</p>
	                     ";
	    $mail->send();
	    $sm= 'A mensagem foi enviada';
    } 
    catch (Exception $e) {
	    $em = "A mensagem não pode ser enviada. Mailer Error: {$mail->ErrorInfo}";
	}

	if($mail){
		header("Location: ../index.php");
	}

}

}