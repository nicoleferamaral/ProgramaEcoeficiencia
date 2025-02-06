<?php
session_start();
require_once 'DAO/UsuarioDAO.php';
use PHP\Modelo\DAO\UsuarioDAO;

$erro = null;
$sucesso = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nome']) && !empty($_POST['senha']) && !empty($_POST['email'])) {
        $usuarioDAO = new UsuarioDAO();
        
        $nome = trim($_POST['nome']);
        $senha = trim($_POST['senha']);
        $email = trim($_POST['email']);
        
        // Validações básicas
        if (strlen($senha) < 6) {
            $erro = "A senha deve ter pelo menos 6 caracteres.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = "Email inválido.";
        } else {
            if ($usuarioDAO->cadastrar($nome, $senha, $email)) {
                $sucesso = "Usuário cadastrado com sucesso! <a href='login.php'>Faça login</a>";
            } else {
                $erro = "Nome de usuário ou email já existe.";
            }
        }
    } else {
        $erro = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema de Reciclagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: rgb(203,255,171);
            background: radial-gradient(circle, rgba(203,255,171,1) 32%, rgba(9,121,14,1) 95%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .cadastro-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
        }
        .btn-primary {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .btn-primary:hover {
            background-color: #45a049;
            border-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cadastro-container">
            <h2 class="text-center mb-4">Cadastro de Usuário</h2>
            
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <?php if ($sucesso): ?>
                <div class="alert alert-success"><?php echo $sucesso; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome de Usuário</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                    <div class="form-text">A senha deve ter pelo menos 6 caracteres.</div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                
                <div class="text-center mt-3">
                    <a href="login.php">Já tem uma conta? Faça login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>