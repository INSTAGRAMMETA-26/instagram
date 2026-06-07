<?php
session_start();
$usersFile = 'users.json';
if (!file_exists($usersFile)) file_put_contents($usersFile, json_encode([]));

$mode = isset($_GET['mode']) && $_GET['mode'] === 'register' ? 'register' : 'login';
$msg = $_SESSION['msg'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['msg'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $mode === 'register' ? 'Registrarte' : 'Iniciar sesión'; ?> • Instagram</title>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #fafafa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 350px;
        }
        .box {
            background: white;
            border: 1px solid #dbdbdb;
            border-radius: 1px;
            padding: 40px;
            width: 100%;
            margin-bottom: 10px;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-text {
            font-family: 'Billabong', cursive;
            font-size: 50px;
            font-weight: normal;
        }
        .input-group {
            margin-bottom: 6px;
            position: relative;
        }
        .input-group input {
            width: 100%;
            padding: 9px 8px;
            background: #fafafa;
            border: 1px solid #dbdbdb;
            border-radius: 3px;
            font-size: 12px;
            outline: none;
        }
        .input-group input:focus {
            border-color: #a8a8a8;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background: #0095f6;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            margin-top: 12px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        .btn-submit:hover { opacity: 1; }
        .btn-submit:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #dbdbdb;
        }
        .divider span {
            color: #8e8e8e;
            font-size: 13px;
            font-weight: 600;
            margin: 0 15px;
        }
        .fb-login {
            color: #385185;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            margin-bottom: 15px;
        }
        .forgot {
            color: #00376b;
            font-size: 12px;
            text-align: center;
            margin-top: 15px;
            cursor: pointer;
        }
        .signup-box {
            background: white;
            border: 1px solid #dbdbdb;
            padding: 20px;
            width: 100%;
            text-align: center;
        }
        .signup-box p {
            font-size: 14px;
            color: #262626;
        }
        .signup-box a {
            color: #0095f6;
            text-decoration: none;
            font-weight: 600;
        }
        .msg {
            text-align: center;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 14px;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .view-users {
            margin-top: 20px;
            text-align: center;
        }
        .view-users a {
            color: #8e8e8e;
            font-size: 12px;
            text-decoration: none;
        }
        .view-users a:hover { text-decoration: underline; }
        .show-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #262626;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }
        .get-app {
            text-align: center;
            margin-top: 20px;
        }
        .get-app p {
            color: #262626;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .app-stores {
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .app-stores img {
            height: 40px;
        }
        @media (max-width: 450px) {
            .box, .signup-box { border: none; background: transparent; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box">
            <div class="logo">
                <div class="logo-text">Instagram</div>
            </div>
            
            <?php if ($msg): ?>
                <div class="msg success"><?php echo htmlspecialchars($msg); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="msg error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="auth.php" method="POST" id="authForm">
                <input type="hidden" name="action" value="<?php echo $mode; ?>">
                
                <?php if ($mode === 'register'): ?>
                    <div class="input-group">
                        <input type="text" name="fullname" placeholder="Nombre completo" required>
                    </div>
                <?php endif; ?>
                
                <div class="input-group">
                    <input type="text" name="username" placeholder="Usuario" required>
                </div>
                
                <?php if ($mode === 'register'): ?>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Correo electrónico" required>
                    </div>
                <?php endif; ?>
                
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Contraseña" required minlength="6">
                    <?php if ($mode === 'login'): ?>
                        <button type="button" class="show-password" onclick="togglePassword()">Mostrar</button>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="btn-submit" id="submitBtn">
                    <?php echo $mode === 'register' ? 'Registrarte' : 'Iniciar sesión'; ?>
                </button>
            </form>
            
            <?php if ($mode === 'login'): ?>
                <div class="divider"><span>O</span></div>
                <div class="fb-login">Iniciar sesión con Facebook</div>
                <div class="forgot">¿Olvidaste tu contraseña?</div>
            <?php endif; ?>
        </div>
        
        <div class="signup-box">
            <?php if ($mode === 'login'): ?>
                <p>¿No tienes una cuenta? <a href="?mode=register">Regístrate</a></p>
            <?php else: ?>
                <p>¿Ya tienes una cuenta? <a href="?mode=login">Inicia sesión</a></p>
            <?php endif; ?>
        </div>
        
        <div class="get-app">
            <p>Descarga la app.</p>
            <div class="app-stores">
                <img src="https://www.instagram.com/static/images/appstore-install-badges/badge_ios_spanish_latinamerica.png/8cad87b4909e.png" alt="App Store">
                <img src="https://www.instagram.com/static/images/appstore-install-badges/badge_android_spanish_latinamerica.png/551a7d53183f.png" alt="Google Play">
            </div>
        </div>
        
        <div class="view-users">
            <a href="ver_usuarios.php">👁 Ver usuarios registrados</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.show-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = 'Ocultar';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = 'Mostrar';
            }
        }
        
        const form = document.getElementById('authForm');
        const submitBtn = document.getElementById('submitBtn');
        const inputs = form.querySelectorAll('input[required]');
        
        function validateForm() {
            let isValid = true;
            inputs.forEach(input => { if (!input.value.trim()) isValid = false; });
            submitBtn.disabled = !isValid;
            submitBtn.style.opacity = isValid ? '1' : '0.7';
        }
        
        inputs.forEach(input => input.addEventListener('input', validateForm));
        validateForm();
    </script>
</body>
</html>
