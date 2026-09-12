<?php
require_once __DIR__ . '/database/db.php';

$pdo = getDatabaseConnection();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$editMode = !empty($id);

$livro = [
    'id' => '',
    'titulo' => '',
    'autor' => '',
    'categoria' => '',
    'status' => 'Nunca lido'
];
$erros = [];

$categoriasPermitidas = ['Ação', 'Comédia', 'Drama', 'Ficção Científica', 'Terror', 'Suspense', 'Fantasia', 'Auto-ajuda', 'Outros'];
$statusPermitidos = ['Nunca lido', 'Em andamento', 'Lido'];

if ($editMode && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM livros WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $registro = $stmt->fetch();

    if ($registro) {
        $livro = $registro;
    } else {
        header('Location: index.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $livro['id'] = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $livro['titulo'] = trim($_POST['titulo'] ?? '');
    $livro['autor'] = trim($_POST['autor'] ?? '');
    $livro['categoria'] = trim($_POST['categoria'] ?? '');
    $livro['status'] = trim($_POST['status'] ?? '');

    if (empty($livro['titulo']) || mb_strlen($livro['titulo']) < 2) {
        $erros[] = "O campo Título é obrigatório e deve ter no mínimo 2 caracteres.";
    }

    if (empty($livro['autor']) || mb_strlen($livro['autor']) < 2) {
        $erros[] = "O campo autor é obrigatório e deve ter no mínimo 2 caracteres.";
    }

    if (!in_array($livro['categoria'], $categoriasPermitidas, true)) {
        $erros[] = "A Categoria selecionada é inválida.";
    }

    if (!in_array($livro['status'], $statusPermitidos, true)) {
        $erros[] = "O Status selecionado é inválido.";
    }

    if (empty($erros)) {
        if (!empty($livro['id'])) {
            // Update
            $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, categoria = :categoria, status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo' => $livro['titulo'],
                ':autor' => $livro['autor'],
                ':categoria' => $livro['categoria'],
                ':status' => $livro['status'],
                ':id' => $livro['id']
            ]);
            header('Location: index.php?msg=updated');
            exit;
        } else {
            // Post
            $sql = "INSERT INTO livros (titulo, autor, categoria, status) VALUES (:titulo, :autor, :categoria, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo' => $livro['titulo'],
                ':autor' => $livro['autor'],
                ':categoria' => $livro['categoria'],
                ':status' => $livro['status']
            ]);
        }
        header('Location: index.php?msg=created');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $editMode ? 'Editar Livro' : 'Novo Livro' ?></title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
    <div class="container" style="max-width: 600px;">
        <header class="header">
            <h1><?= $editMode ? 'Editar Livro' : 'Cadastrar Livro' ?></h1>
        </header>

        <?php if (!empty($erros)): ?>
            <div class="alert alert-danger">
                <strong>Atenção:</strong>
                <ul style="margin-left: 1.2rem; margin-top: 0.5rem;">
                    <?php foreach ($erros as $erro): ?>
                        <li><?= htmlspecialchars($erro) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card">
            <form id="livroForm" action="save.php" method="POST" novalidate>
                <input type="hidden" name="id" value="<?= htmlspecialchars($livro['id']) ?>">

                <div class="form-group">
                    <label for="titulo">Título do livro</label>
                    <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($livro['titulo']) ?>" placeholder="Ex: O Hobbit">
                    <span id="tituloError" class="client-error"></span>
                </div>

                <div class="form-group">
                    <label for="autor">Autor</label>
                    <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($livro['autor']) ?>" placeholder="Ex: J. R. R. Tolkien">
                    <span id="autorError" class="client-error"></span>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria">
                        <option value="">Selecione uma categoria...</option>
                        <?php foreach ($categoriasPermitidas as $cat): ?>
                            <option value="<?= $cat ?>" <?= ($livro['categoria'] === $cat) ? 'selected' : '' ?>>
                                <?= $cat ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span id="categoriaError" class="client-error"></span>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <?php foreach ($statusPermitidos as $st): ?>
                            <option value="<?= $st ?>" <?= ($livro['status'] === $st) ? 'selected' : '' ?>>
                                <?= $st ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span id="statusError" class="client-error"></span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?= $editMode ? 'Salvar Alterações' : 'Cadastrar Livro' ?></button>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/scripts.js"></script>
</body>

</html>