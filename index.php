<?php

require_once 'database/db.php';
require_once 'database/seeder.php';

$pdo = getDatabaseConnection();
seedLivros($pdo);

$stmt = $pdo->query("SELECT * FROM livros");
$livros = $stmt->fetchAll();

// try {
//     $pdo = getDatabaseConnection();

//     echo "Conexão com o banco de dados realizada com sucesso.";
// } catch (PDOException $e) {
//     echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
// }
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
    <main>
        <h1>Livros</h1>
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
                                <!-- htmlspecialchars evita vulnerabilidade XSS -->
                                <td><strong><?= htmlspecialchars($livro['titulo']) ?></strong></td>
                                <td><?= htmlspecialchars($livro['autor']) ?></td>
                                <td><?= htmlspecialchars($livro['categoria']) ?></td>
                                <td>
                                    <?php 
                                        $classeStatus = match($livro['status']) {
                                            'Assistido' => 'badge-assistido',
                                            'Quero Assistir' => 'badge-quero-assistir',
                                            default => 'badge-abandonado'
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