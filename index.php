<?php

require_once 'database/db.php';

try {
    $pdo = getDatabaseConnection();

    echo "Conexão com o banco de dados realizada com sucesso.";
} catch (PDOException $e) {
    echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
}