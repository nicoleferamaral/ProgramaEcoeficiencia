<?php
namespace PHP\Modelo\DAO;

require_once 'Conexao.php';


class MaterialDAO {
    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function salvar(string $data, string $categoria, float $peso) {
        $conexao = new Conexao();
        $conn = $conexao->conectar();
        
        $stmt = $conn->prepare("INSERT INTO materiais (data, categoria, peso) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $data, $categoria, $peso);
        return $stmt->execute();
    }

    public function listarTodos() {
        $conexao = new Conexao();
        $conn = $conexao->conectar();
        
        $result = $conn->query("SELECT * FROM materiais");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function excluir(int $id) {
        $conexao = new Conexao();
        $conn = $conexao->conectar();
        
        $stmt = $conn->prepare("DELETE FROM materiais WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }



    public function buscarPorId($id) {
        $conn = $this->conexao->conectar();
        $stmt = $conn->prepare("SELECT * FROM materiais WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function atualizar($id, $data, $categoria, $peso) {
        $conn = $this->conexao->conectar();
        $stmt = $conn->prepare("UPDATE materiais SET data = ?, categoria = ?, peso = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $data, $categoria, $peso, $id);
        return $stmt->execute();
    }

    public function buscarComFiltros($data = null, $categoria = null) {
        $conexao = new Conexao();
        $conn = $conexao->conectar();
        
        $sql = "SELECT * FROM materiais WHERE 1=1";
        $params = [];
        $types = "";
        
        if ($data) {
            $sql .= " AND data = ?";
            $params[] = $data;
            $types .= "s";
        }
        
        if ($categoria) {
            $sql .= " AND categoria = ?";
            $params[] = $categoria;
            $types .= "s";
        }
        
        $sql .= " ORDER BY data DESC";
        
        $stmt = $conn->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>