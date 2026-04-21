<?php
require_once 'conexao.php';

// Busca todos os produtos cadastrados no banco de dados
$stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Produtos</h1>
        
        <div class="header-actions">
            <span>Gerencie o estoque da sua loja</span>
            <a href="cadastrar.php" class="btn">Cadastrar Novo Produto</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($produtos) > 0): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?php echo $produto['id']; ?></td>
                            <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                            <td><?php echo htmlspecialchars($produto['descricao']); ?></td>
                            <td><?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                            <td class="acoes">
                                <a href="editar.php?id=<?php echo $produto['id']; ?>" class="btn btn-warning">Editar</a>
                                <a href="excluir.php?id=<?php echo $produto['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Nenhum produto cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>