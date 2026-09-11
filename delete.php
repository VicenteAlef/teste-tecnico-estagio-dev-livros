<?php
require_once __DIR__ . '/database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    
    if ($id) {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("DELETE FROM livros WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
    
    header('Location: index.php?msg=deleted');
    exit;
}

header('Location: index.php');
exit;
