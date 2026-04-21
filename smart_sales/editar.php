<?php
require_once 'conexao.php';

// Verifica se foi passado um ID pela URL
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Lógica de atualização (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = trim($_POST['preco']);

    if (!empty($nome) && !empty($preco)) {
        $stmt = $pdo->prepare("UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            $erro = "Erro ao atualizar o produto.";
        }
    } else {
        $erro = "Os campos Nome e Preço são obrigatórios.";
    }
}

// Busca os dados atuais do produto para preencher o formulário
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Editar Produto</h2>
        
        <?php if (isset($erro)): ?>
            <p style="color: red; text-align: center; margin-bottom: 15px;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST" action="editar.php?id=<?php echo $produto['id']; ?>">
            <div class="form-group">
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="preco">Preço (R$):</label>
                <input type="number" id="preco" name="preco" step="0.01" min="0" value="<?php echo $produto['preco']; ?>" required>
            </div>
            
            <button type="submit" class="btn btn-submit">Atualizar Produto</button>
        </form>
        <a href="index.php" class="link-voltar">Voltar para a Lista</a>
    </div>
</body>
</html>