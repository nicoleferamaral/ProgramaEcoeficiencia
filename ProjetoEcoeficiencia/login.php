<?php
session_start();

require_once 'DAO/UsuarioDAO.php';
use PHP\Modelo\DAO\UsuarioDAO;

// Se já estiver logado, redireciona para index
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header('Location: index.php');
    exit();
}

$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nome']) && !empty($_POST['senha'])) {
        $usuarioDAO = new UsuarioDAO();
        
        $nome = trim($_POST['nome']);
        $senha = trim($_POST['senha']);

        $usuario = $usuarioDAO->autenticar($nome, $senha);

        if ($usuario) {
            $_SESSION['logado'] = true;
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['id_usuario'] = $usuario['id'];
            
            header('Location: index.php');
            exit();
        } else {
            $erro = "Usuário ou senha incorretos!";
        }
    } else {
        $erro = "Por favor, preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Reciclagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: rgb(203,255,171);
            background: radial-gradient(circle, rgba(203,255,171,1) 32%, rgba(9,121,14,1) 95%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
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
        <div class="login-container">
            <h2 class="text-center mb-4">Login</h2>
            
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?php echo $erro; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Usuário</label>
                    <input type="text" class="form-control" id="nome" name="nome" 
                           required autofocus>
                </div>
                
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" 
                           required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-3">Entrar</button>
                
                <div class="text-center">
                    <a href="cadastro.php" class="text-decoration-none">Não tem uma conta? Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>