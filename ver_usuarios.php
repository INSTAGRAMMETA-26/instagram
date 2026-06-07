<?php
$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados - Instagram</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, sans-serif; }
        body { background: #fafafa; padding: 40px 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 40px; }
        .logo { font-family: 'Billabong', cursive; font-size: 42px; margin-bottom: 10px; }
        .stats {
            background: white;
            border: 1px solid #dbdbdb;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }
        .stats-number { font-size: 48px; font-weight: bold; color: #0095f6; }
        .stats-label { color: #8e8e8e; font-size: 16px; margin-top: 5px; }
        table {
            width: 100%;
            background: white;
            border: 1px solid #dbdbdb;
            border-radius: 8px;
            border-collapse: collapse;
            overflow: hidden;
        }
        th {
            background: #f5f5f5;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #262626;
            border-bottom: 1px solid #dbdbdb;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #efefef;
            color: #262626;
        }
        tr:hover { background: #fafafa; }
        .username { font-weight: bold; color: #0095f6; }
        .password {
            background: #ffe6e6;
            color: #ed4956;
            padding: 5px 10px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 13px;
        }
        .empty {
            text-align: center;
            padding: 60px;
            color: #8e8e8e;
            background: white;
            border: 1px solid #dbdbdb;
            border-radius: 8px;
        }
        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #0095f6;
            text-decoration: none;
            font-weight: 600;
        }
        .badge {
            background: #00b894;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Instagram</div>
            <a href="index.php" class="back">← Volver al Login</a>
        </div>
        
        <div class="stats">
            <div class="stats-number"><?php echo count($users); ?></div>
            <div class="stats-label">Usuarios registrados</div>
        </div>
        
        <?php if (empty($users)): ?>
            <div class="empty">
                <p>No hay usuarios registrados todavía.</p>
                <p><a href="index.php?mode=register" style="color: #0095f6;">Registrar el primer usuario</a></p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td>#<?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                        <td class="username">@<?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><span class="password"><?php echo htmlspecialchars($user['password']); ?></span></td>
                        <td><?php echo $user['created_at']; ?> <span class="badge">Nuevo</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
