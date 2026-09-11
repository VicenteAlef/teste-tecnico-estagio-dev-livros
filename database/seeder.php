<?php

function seedLivros(PDO $pdo): void {
    $livros = [
        [
            'titulo' => 'O Senhor dos Anéis - A Sociedade do Anel',
            'autor' =>  'J. R. R. Tolkien',
            'categoria' => 'Fantasia',
        ],
        [
            'titulo' => 'O Senhor dos Anéis - As Duas Torres',
            'autor' =>  'J. R. R. Tolkien',
            'categoria' => 'Fantasia',
        ],
        [
            'titulo' => 'O Senhor dos Anéis - O Retorno do Rei',
            'autor' =>  'J. R. R. Tolkien',
            'categoria' => 'Fantasia',
        ],
    ];

    $livroExiste = $pdo->prepare('SELECT 1 FROM livros WHERE titulo = :titulo LIMIT 1');

    $insertLivro = $pdo->prepare(
        'INSERT INTO livros (titulo, autor, categoria) VALUES (:titulo, :autor, :categoria)'
    );

    foreach ($livros as $livro) {
        $livroExiste->execute([':titulo' => $livro['titulo']]);
        if (!$livroExiste->fetch()) {
            $insertLivro->execute([
                ':titulo' => $livro['titulo'],
                ':autor' => $livro['autor'],
                ':categoria' => $livro['categoria'],
            ]);
        }
    }
}
