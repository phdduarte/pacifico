<?php
// Fixing CORS for AMP
header("access-control-allow-credentials:true");
header("access-control-allow-headers:Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token");
header("access-control-allow-methods:POST, GET, OPTIONS");
header("access-control-allow-origin:".$_SERVER['HTTP_ORIGIN']);
header("access-control-expose-headers:AMP-Redirect-To,AMP-Access-Control-Allow-Source-Origin");
header("AMP-Access-Control-Allow-Source-Origin:".$_SERVER['HTTP_ORIGIN']);
header("Content-Type: application/json");

$name = $_POST["nome"];
$email = $_POST["email"];
$assunto = $_POST["assunto"];
$msg = $_POST["mensagem"];


// Load Composer's autoloader
require 'vendor/autoload.php';
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                      
    $mail->isSMTP();                                            
    $mail->Host       = 'email-ssl.com.br';  
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'ffigueiredo@pacificocontabilidade.com.br';                     
    $mail->Password   = 'k*z$Bb89';                              
    $mail->SMTPSecure = 'ssl';                                  
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom('ffigueiredo@pacificocontabilidade.com.br', 'SITE');
    $mail->addAddress('ffigueiredo@pacificocontabilidade.com.br', 'ffigueiredo@pacificocontabilidade.com.br');     // Add a recipient
    //$mail->addAddress('contato@pdwebdesign.com.br');               // Name is optional
    //$mail->addReplyTo('contato@pdwebdesign.com.br', 'Information');
    //$mail->addCC('contato@pdwebdesign.com.br');
    //$mail->addBCC('contato@pdwebdesign.com.br');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Lead recebido do SITE - ' . $name . ': '. $assunto;
    $mail->Body    = 'NOME: ' . $name . '<br>' . 'E-MAIL: ' . $email . '<br>' . 'Mensagem: ' . $msg;
    //$mail->AltBody = 'TELEFONE:';

    $mail->send();
    $msg = [];
    $msg['nome'] = $name;
    
    echo json_encode($msg);
} catch (Exception $e) {
    $msg = 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
    echo json_encode($msg);
}
