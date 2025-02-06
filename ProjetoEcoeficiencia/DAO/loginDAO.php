<?php
session_start();
require_once 'PHP\Modelo\DAO\Conexao.php'; // Ajuste o caminho conforme sua estrutura
use PHP\Modelo\DAO\Conexao;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $conexao = new Conexao();
        $conn = $conexao->conectar();
        // Prevenir SQL Injection
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.html?error=Credenciais inválidas");
            exit();
        }
    } catch (\Exception $e) {
        error_log($e->getMessage()); // Registra o erro no log
        header("Location: login.html?error=Erro no servidor");
        exit();
    }
}
?>