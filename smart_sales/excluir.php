<?php
require_once 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

header('Location: index.php');
exit;
?>