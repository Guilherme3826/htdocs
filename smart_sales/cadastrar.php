<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = trim($_POST['preco']);

    if (!empty($nome) && !empty($preco)) {
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco) VALUES (:nome, :descricao, :preco)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        
        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            $erro = "Erro ao cadastrar o produto.";
        }
    } else {
        $erro = "Os campos Nome e Preço são obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastrar Novo Produto</h2>
        
        <?php if (isset($erro)): ?>
            <p style="color: red; text-align: center; margin-bottom: 15px;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST" action="cadastrar.php">
            <div class="form-group">
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao"></textarea>
            </div>
            
            <div class="form-group">
                <label for="preco">Preço (R$):</label>
                <input type="number" id="preco" name="preco" step="0.01" min="0" required>
            </div>
            
            <button type="submit" class="btn btn-submit">Salvar Produto</button>
        </form>
        <a href="index.php" class="link-voltar">Voltar para a Lista</a>
    </div>
</body>
</html>