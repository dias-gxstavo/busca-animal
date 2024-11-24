<?php
header('Content-Type: text/html; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviarEmail($destinatario, $assunto, $mensagem){

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configurações de servidor
    $mail->SMTPDebug = 0; 
    $mail->setLanguage('pt_br', 'phpmailer.lang-pt_br.php');
    $mail->CharSet = 'UTF-8';                    
    $mail->isSMTP();                                         
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                                 
    $mail->Username   = 'projeto.buscaanimal@gmail.com';                
    $mail->Password   = 'kgbs wptr ujvr nmmt';                              
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
    $mail->Port       = 465;                                    

    //Remetente e destinatário
    $mail->setFrom('projeto.buscaanimal@gmail.com', 'Projeto Busca Animal');
    $mail->addAddress("$destinatario");     

    /* 
    Para envio de fotos
    $mail->addAttachment('/var/tmp/file.tar.gz');         
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');

    */
       

    //Conteudo
    $mail->isHTML(true);                                  
    $mail->Subject = $assunto;
    $mail->Body    = $mensagem;
    $mail->send();

    if($mail->send()){
        header("Location: index.php");
    }
}
 catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}}

