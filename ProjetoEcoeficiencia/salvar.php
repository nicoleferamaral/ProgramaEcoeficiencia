<?php
session_start();
require_once 'DAO/MaterialDAO.php';

if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = ($_POST['categoria'] === 'nova') ? $_POST['novaCategoria'] : $_POST['categoria'];
    
    $dao = new PHP\Modelo\DAO\MaterialDAO();
    $sucesso = $dao->salvar(
        $_POST['data'],
        $categoria,
        (float)$_POST['peso'],
        $_SESSION['usuario_id']
    );
    
    header("Location: principal.php");
    exit();
}