<?php
global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul.
 * This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

/**
 * Page "Books.php"
 */

session_start(); // Start the session

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require 'vendor/autoload.php';
require 'php/db_connect.php';

// Fetch all books with related author, series, and editor data
$stmt = $pdo->query("
    SELECT 
        books.*, 
        COALESCE(author.author_name, 'Pas de valeur') AS author_name, 
        COALESCE(series.series_name, 'Pas de valeur') AS series_name, 
        COALESCE(editor.editor_name, 'Pas de valeur') AS editor_name 
    FROM books 
    LEFT JOIN author ON books.book_author_id = author.id 
    LEFT JOIN series ON books.book_series_id = series.id 
    LEFT JOIN editor ON books.book_editor_id = editor.id
");
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Neodraco's Books | Mes livres</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <?php require 'php/favicon.php'; ?>
</head>

<?php require 'php/menu.php'; ?>

<body>
<main class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Liste des livres</h2>
        </div>
        <div class="card-body">
            <?php if (empty($books)): ?>
                <div class="alert alert-warning" role="alert">
                    Aucun livre n'est enregistré
                </div>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Titre du livre</th>
                        <th scope="col">Tome</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Série</th>
                        <th scope="col">Éditeur</th>
                        <th scope="col">Prix (€)</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Date de publication</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['book_name']) ?? 'Pas de valeur' ?></td>
                            <td><?= htmlspecialchars($book['book_nbe'])?></td>
                            <td><?= htmlspecialchars($book['author_name']) ?></td>
                            <td><?= htmlspecialchars($book['series_name']) ?></td>
                            <td><?= htmlspecialchars($book['editor_name']) ?></td>
                            <td><?= htmlspecialchars($book['book_price']) ?? 'Pas de valeur' ?></td>
                            <td>
                                <?php if (empty($book['book_ISBN'])): ?>
                                    <span class="badge bg-info">ISBN à ajouter</span>
                                <?php else: ?>
                                    <?= htmlspecialchars($book['book_ISBN']) ?>
                                <?php endif; ?>
                            </td>
                            <td><?= isset($book['book_date']) ? (new DateTime($book['book_date']))->format('d/m/Y') : 'Pas de valeur' ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require 'php/footer.php'; ?>
<?php require 'js/bootstrap_script.html'; ?>

</body>
</html>