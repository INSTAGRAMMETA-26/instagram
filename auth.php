<?php
session_start();

$usersFile = 'users.json';
if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([]));
}

$users = json_decode(file_get_contents($usersFile), true);
$action = $_POST['action'] ?? 'login';

if ($action === 'register') {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = 'Todos los campos son obligatorios';
        header('Location: index.php?mode=register');
        exit;
    }
    
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $_SESSION['error'] = 'El usuario ya existe';
            header('Location: index.php?mode=register');
            exit;
        }
        if ($user['email'] === $email) {
            $_SESSION['error'] = 'El email ya está registrado';
            header('Location: index.php?mode=register');
            exit;
        }
    }
    
    $newUser = [
        'id' => count($users) + 1,
        'fullname' => $fullname,
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $users[] = $newUser;
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    
    $_SESSION['msg'] = '¡Registro exitoso! Ahora inicia sesión';
    header('Location: index.php?mode=login');
    exit;
    
} else {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $found = false;
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $found = true;
            $_SESSION['user'] = $user;
            break;
        }
    }
    
    if ($found) {
        $_SESSION['msg'] = '¡Bienvenido, ' . $user['fullname'] . '!';
    } else {
        $_SESSION['error'] = 'Usuario o contraseña incorrectos';
    }
    
    header('Location: index.php');
    exit;
}
?>
