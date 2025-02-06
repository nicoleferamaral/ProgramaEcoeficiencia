<?php
namespace PHP\Modelo\DAO;

require_once 'Conexao.php';

class UsuarioDAO {
    public function autenticar(string $nome, string $senha) {
        try {
            $conexao = new Conexao();
            $conn = $conexao->conectar();
            
            $stmt = $conn->prepare("SELECT id, nome, email FROM usuarios WHERE nome = ? AND senha = ?");
            $stmt->bind_param("ss", $nome, $senha);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $usuario = $result->fetch_assoc();
            
            $stmt->close();
            
            return $usuario ? $usuario : false;
        } catch(\Exception $e) {
            error_log("Erro na autenticação: " . $e->getMessage());
            return false;
        }
    }

    public function cadastrar(string $nome, string $senha, string $email) {
        try {
            $conexao = new Conexao();
            $conn = $conexao->conectar();
            
            // Verifica se o usuário já existe
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nome = ? OR email = ?");
            $stmt->bind_param("ss", $nome, $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->fetch_assoc()) {
                return false; // Usuário ou email já existe
            }
            
            // Cria o novo usuário
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, senha, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $senha, $email);
            $sucesso = $stmt->execute();
            
            $stmt->close();
            
            return $sucesso;
        } catch(\Exception $e) {
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return false;
        }
    }
}