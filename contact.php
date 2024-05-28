<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = ["success" => false, "message" => "esto es un msg de error"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Construye el cuerpo del correo electrónico
    $email_message = "Nombre: $name\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Asunto: $subject\n";
    $email_message .= "Mensaje:\n$message\n";

    // Configura el destinatario y los encabezados del correo electrónico
    $to = 'dam.oscar.amigo@gmail.com';
    $headers = 'From: ' . $email . "\r\n" .
               'Reply-To: ' . $email . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Envía el correo electrónico
    
    if (mail($to, $subject, $email_message, $headers)) {
        $response["success"] = true;
        $response["message"] = "Tu mensaje ha sido enviado. ¡Gracias!";
    } else {
        $response["message"] = "Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde.";
    }
} else {
    $response["message"] = "Método de solicitud no válido.";
}

echo json_encode($response);
?>
