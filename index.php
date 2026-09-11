<?php

require_once __DIR__ . '/database/db.php';

$pdo = getDatabaseConnection();
$message = $_GET['msg'] ?? '';

$stmt = $pdo->query("SELECT * FROM livros");
$livros = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Livros</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Livros</h1>
            <a href="save.php" class="btn btn-primary">+ Novo Livro</a>
        </header>
    </div>

    <main class="container">

        <?php if ($message === 'created'): ?>
            <div class="alert alert-success">Livro adicionado com sucesso!</div>
        <?php endif; ?>

        <div class="card">

            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Diretor</th>
                            <th>Categoria</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($livros as $livro): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($livro['titulo']) ?></strong></td>
                                <td><?= htmlspecialchars($livro['autor']) ?></td>
                                <td><?= htmlspecialchars($livro['categoria']) ?></td>
                                <td>
                                    <?php 
                                        $classeStatus = match($livro['status']) {
                                            'Lido' => 'badge-lido',
                                            'Em andamento' => 'badge-em-andamento',
                                            default => 'badge-nunca-lido'
                                            };
                                            ?>
                                    <span class="badge <?= $classeStatus ?>">
                                        <?= htmlspecialchars($livro['status']) ?>
                                    </span>
                                </td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>