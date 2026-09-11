<?php

function getDatabaseConnection(): PDO {
 
    $dbPath = __DIR__ . '/livros.sqlite';

    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $query = "CREATE TABLE IF NOT EXISTS livros (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL UNIQUE,
        autor TEXT NOT NULL,
        categoria TEXT NOT NULL,
        status TEXT NOT NULL DEFAULT 'Nunca lido'
            CHECK (status IN ('Nunca lido', 'Em andamento', 'Lido'))
    )";

    $pdo->exec($query);

    return $pdo;
}