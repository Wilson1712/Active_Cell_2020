<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'Library/Conexion2.php';
$nombre_usuario = $_POST['email'];

 //buscar
 /*
            $db = Db::getConnect();
            $select = $db->prepare("SELECT * FROM cliente  WHERE email='$referencia'");
            $select->execute();
            //asignarlo al objeto producto
            $usuarioDb = $select->fetch();
            $usuario = [
                'nombre' => $usuarioDb['nombre'],
                'email' => $usuarioDb['email'],
                'clave' => $usuarioDb['clave']
            ];
*/
				
		$db= new Conexion();
		$select=$db->prepare("SELECT * FROM user WHERE 
		email='$nombre_usuario'");
		$select->execute();
		//asignarlo al objeto usuario
		$usuarioDb=$select->fetch();	
		$clave_consultada=$usuarioDb['password'];

if($clave_consultada!="")
{
// // Variables de prueba
$cliente['nombre'] = "Active Cell";
$cliente['email'] = $_POST['email'];
$cliente['password']= $clave_consultada;

// Load Composer's autoloader

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Mailer = "smtp";
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    //$mail->Username   = 'trabajophp123456@gmail.com';                     // SMTP username
    $mail->Username   = 'juancamilo1143164715@gmail.com';                     // SMTP username
    $mail->Password   = '1143164715';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587; 
    $mail->IsHTML(true);                                   // TCP port to connect to
    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );
    //Recipients
    // $mail->From = 'juancamilo1143164715@gmail.com';
    
    $mail->SetFrom($cliente['email'],'Coding Cage');
    $mail->FromName = $cliente['name'];
    $mail->addAddress($cliente['email']);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('jeysonspt1996@gmail.com');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    ///$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Active Cell';
    $mail->Body    = 'Recuperacion de clave...  ' . $cliente['name'] . '<br> su clave es <strong>:' . $cliente['password'] . '</strong>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
    $mail->send();
	
    echo '<script> 
    alert("El mensaje se envió correctamente, puede verificar su correo.");
    window.history.go(-2)
</script> ';

} catch (Exception $e) {
    echo "Este mensaje no se pudo enviar: {$mail->ErrorInfo}";
}
}
else
{
	echo "El usuario consultado no se encuentra en la base de datos";
//M.toast({html: "I am a toast!", classes: "rounded"})
}
