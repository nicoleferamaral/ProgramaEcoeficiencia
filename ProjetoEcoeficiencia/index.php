<?php
require_once 'auth.php';

require_once 'DAO/MaterialDAO.php';


$dao = new PHP\Modelo\DAO\MaterialDAO();
$materiais = $dao->listarTodos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = ($_POST['categoria'] === 'nova') ? $_POST['novaCategoria'] : $_POST['categoria'];
    $dao->salvar($_POST['data'], $categoria, (float)$_POST['peso']);
    header("Location: index.php");
    exit();
}

if (isset($_GET['excluir'])) {
    $dao->excluir($_GET['excluir']);
    header("Location: index.php");
    exit();
}

if (isset($_GET['data_busca']) || isset($_GET['categoria_busca'])) {
    $data = !empty($_GET['data_busca']) ? $_GET['data_busca'] : null;
    $categoria = !empty($_GET['categoria_busca']) ? $_GET['categoria_busca'] : null;
    $materiais = $dao->buscarComFiltros($data, $categoria);
} else {
    $materiais = $dao->listarTodos();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Reciclagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #45a049;
        }

        body {
            background-color: #f0f4f7;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 5rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .main-container {
            padding: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        #bot{
            float: right;
        }

        .category-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .recyclable {
            background-color: #d4edda;
            color: #155724;
        }

        .non-recyclable {
            background-color: #f8d7da;
            color: #721c24;
        }

  

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
        }
    </style>

</head>
<body>
    <div class="main-container">
        <header class="mb-4">
            <h2>Registro de Pesagem</h2>
            <span class="me-3">Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?></span>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </header>
        <br><br>
        <!-- Adicione este código após o header e antes do card de "Novo Registro" -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Consulta Individual</h5>
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="data_busca" class="form-label">Data</label>
                <input type="date" class="form-control" id="data_busca" name="data_busca">
            </div>
            <div class="col-md-4">
                <label for="categoria_busca" class="form-label">Categoria</label>
                <select class="form-select" id="categoria_busca" name="categoria_busca">
                    <option value="">Todas as categorias</option>
                    <option value="Reciclável">Reciclável</option>
                    <option value="Não Reciclável">Não Reciclável</option>
                    <option value="Óleo">Óleo</option>
                    <!-- ... outras categorias ... -->
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <?php if(isset($_GET['data_busca']) || isset($_GET['categoria_busca'])): ?>
                    <a href="index.php" class="btn btn-secondary ms-2">Limpar Filtros</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Novo Registro</h5>
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>
                        <div class="col-md-4">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="category" name="categoria" required>
                                <option value="Reciclável">Reciclável</option>
                                <option value="Não Reciclável">Não Reciclável</option>
                                <option value="Óleo">Óleo</option>
                                <option value="Tampinhas plásticas">Tampinhas plásticas</option>
                                <option value="Lacres de alumínio">Lacres de alumínio</option>
                                <option value="Tecidos">Tecidos</option>
                                <option value="Meias">Meias</option>
                                <option value="Material de escrita">Material de escrita</option>
                                <option value="Esponjas">Esponjas</option>
                                <option value="Eletrônicos">Eletrônicos</option>
                                <option value="Pilhas e baterias">Pilhas e baterias</option>
                                <option value="Infectante">Infectante</option>
                                <option value="Químicos">Químicos</option>
                                <option value="Lâmpada fluorescente">Lâmpada fluorescente</option>
                                <option value="Tonners de impressora">Tonners de impressora</option>
                                <option value="Esmaltes">Esmaltes</option>
                                <option value="Cosméticos">Cosméticos</option>
                                <option value="Cartela de medicamentos">Cartela de medicamento</option>

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
                    <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Registros Anteriores</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Categoria</th>
                                <th>Peso (kg)</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($materiais as $material): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($material['data'])) ?></td>
                                <td>
                                    <span class="category-badge <?= $material['categoria'] === 'Reciclável' ? 'recyclable' : 'non-recyclable' ?>">
                                        <?= $material['categoria'] ?>
                                    </span>
                                </td>
                                <td><?= number_format($material['peso'], 3) ?> kg</td>
                                <td>
                                    <a href="editar.php?id=<?= $material['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="index.php?excluir=<?= $material['id'] ?>" class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('categoria').addEventListener('change', function() {
        const novaCategoriaInput = document.getElementById('novaCategoria');
        if (this.value === 'nova') {
            novaCategoriaInput.style.display = 'block';
            novaCategoriaInput.required = true;
        } else {
            novaCategoriaInput.style.display = 'none';
            novaCategoriaInput.required = false;
        }
    });
</script>
</body>
</html> 