<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar
    $nombre   = trim($_POST["nombre"] ?? '');
    $telefono = trim($_POST["telefono"] ?? '');
    $correo   = trim($_POST["correo"] ?? '');
    $mensaje  = trim($_POST["mensaje"] ?? '');

    // Validación simple
    if ($nombre === '' || $telefono === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL) || $mensaje === '') {
        header("Location: index.html?sent=0&msg=Datos%20inv%C3%A1lidos#contacto");
        exit;
    }

    // Destino
    $para   = "transparencia@estradacrow.com.ec";
    $asunto = "Nuevo mensaje desde la web de Estrada & Crow";

    // Cuerpo
    $cuerpo  = "Has recibido un nuevo mensaje desde el formulario de contacto:\n\n";
    $cuerpo .= "Nombre: $nombre\n";
    $cuerpo .= "Teléfono: $telefono\n";
    $cuerpo .= "Correo: $correo\n\n";
    $cuerpo .= "Mensaje:\n$mensaje\n\n";
    $cuerpo .= "Enviado el: " . date("d/m/Y H:i:s") . "\n";

    // Cabeceras (UTF-8)
    $headers  = "From: contacto@estradacrow.com.ec\r\n";
    $headers .= "Reply-To: $correo\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if (@mail($para, $asunto, $cuerpo, $headers)) {
        header("Location: index.html?sent=1&msg=Gracias%20por%20contactarnos#contacto");
        exit;
    } else {
        header("Location: index.html?sent=0&msg=No%20pudimos%20enviar%20tu%20mensaje#contacto");
        exit;
    }
}