<?php
namespace PHP\Modelo\DAO;

class Consultar {
    public function consultarUsuarioIndividual($conexao, $nome, $senha) {
        try {
            $conn = $conexao->conectar(); // Obtém a conexão PDO
            $sql = "SELECT * FROM usuarios WHERE nome = ? AND senha = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nome, $senha]);
            
            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($usuario) {
                return $usuario; // Retorna os dados do usuário
            }
            return false;
        } catch(\PDOException $e) {
            error_log("Erro na consulta: " . $e->getMessage());
            return false;
        }
    }
}