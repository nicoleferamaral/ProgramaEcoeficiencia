<?php
require_once 'DAO/MaterialDAO.php';

$dao = new PHP\Modelo\DAO\MaterialDAO();


if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$material = $dao->buscarPorId($id);

if (!$material) {
    header("Location: index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = ($_POST['categoria'] === 'nova') ? $_POST['novaCategoria'] : $_POST['categoria'];
    $dao->atualizar($id, $_POST['data'], $categoria, (float)$_POST['peso']);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro - Sistema de Reciclagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Editar Registro</h5>
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control" id="data" name="data" 
                                   value="<?= $material['data'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria" name="categoria" required>
                                <option value="Reciclável" <?= $material['categoria'] === 'Reciclável' ? 'selected' : '' ?>>Reciclável</option>
                                <option value="Não Reciclável" <?= $material['categoria'] === 'Não Reciclável' ? 'selected' : '' ?>>Não Reciclável</option>
                                <option value="Óleo" <?= $material['categoria'] === 'Óleo' ? 'selected' : '' ?>>Óleo</option>
                                <option value="Tampinhas plásticas" <?= $material['categoria'] === 'Tampinhas plásticas' ? 'selected' : '' ?>>Tampinhas plásticas</option>
                                <option value="Lacres de alumínio" <?= $material['categoria'] === 'Lacres de alumínio' ? 'selected' : '' ?>>Lacres de alumínio</option>
                                <option value="Tecidos" <?= $material['categoria'] === 'Tecidos' ? 'selected' : '' ?>>Tecidos</option>
                                <option value="Meias" <?= $material['categoria'] === 'Meias' ? 'selected' : '' ?>>Meias</option>
                                <option value="Material de escrita" <?= $material['categoria'] === 'Material de escrita' ? 'selected' : '' ?>>Material de escrita</option>
                                <option value="Esponjas" <?= $material['categoria'] === 'Esponjas' ? 'selected' : '' ?>>Esponjas</option>
                                <option value="Eletrônicos" <?= $material['categoria'] === 'Eletrônicos' ? 'selected' : '' ?>>Eletrônicos</option>
                                <option value="Pilhas e baterias" <?= $material['categoria'] === 'Pilhas e baterias' ? 'selected' : '' ?>>Pilhas e baterias</option>
                                <option value="Infectante" <?= $material['categoria'] === 'Infectante' ? 'selected' : '' ?>>Infectante</option>
                                <option value="Químicos" <?= $material['categoria'] === 'Químicos' ? 'selected' : '' ?>>Químicos</option>
                                <option value="Óleo" <?= $material['categoria'] === 'Óleo' ? 'selected' : '' ?>>Óleo</option>
                                <option value="Lâmpada fluorescente" <?= $material['categoria'] === 'Lâmpada fluorescente' ? 'selected' : '' ?>>Lâmpada fluorescente</option>
                                <option value="Tonners de impressora" <?= $material['categoria'] === 'Tonners de impressora' ? 'selected' : '' ?>>Tonners de impressora</option>
                                <option value="Cosméticos" <?= $material['categoria'] === 'Cosméticos' ? 'selected' : '' ?>>Cosméticos</option>
                                <option value="Cartela de medicamentos" <?= $material['categoria'] === 'Cartela de medicamentos' ? 'selected' : '' ?>>Cartela de medicamentos</option>
                                
                              
                                <option value="nova">+ Adicionar Nova Categoria</option>
                            </select>
                            <input type="text" class="form-control mt-2" id="novaCategoria" 
                                   name="novaCategoria" placeholder="Nova Categoria" style="display: none;">
                        </div>
                        <div class="col-md-4">
                            <label for="peso" class="form-label">Peso (kg)</label>
                            <input type="number" step="0.001" class="form-control" id="peso" 
                                   name="peso" value="<?= $material['peso'] ?>" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('categoria').addEventListener('change', function() {
            document.getElementById('novaCategoria').style.display = 
                this.value === 'nova' ? 'block' : 'none';
        });
    </script>
</body>
</html>