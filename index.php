<?php
global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul.
 * This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

session_start(); // Démarrer la session

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require 'vendor/autoload.php';
require 'php/db_connect.php';

// Statistiques générales
$stmt = $pdo->query("SELECT COUNT(*) AS total_books, SUM(book_price) AS total_value FROM books");
$general_stats = $stmt->fetch();

$total_books = $general_stats['total_books'];
$total_value = $general_stats['total_value'];

// Nombre de livres par série
$stmt = $pdo->query("
    SELECT series.series_name, COUNT(books.id) AS book_count
    FROM series
    LEFT JOIN books ON series.id = books.book_series_id
    GROUP BY series.series_name
");
$books_by_series = $stmt->fetchAll();

// Nombre de livres par auteur
$stmt = $pdo->query("
    SELECT author.author_name, COUNT(books.id) AS book_count
    FROM author
    LEFT JOIN books ON author.id = books.book_author_id
    GROUP BY author.author_name
");
$books_by_author = $stmt->fetchAll();

// Nombre de livres par éditeur
$stmt = $pdo->query("
    SELECT editor.editor_name, COUNT(books.id) AS book_count
    FROM editor
    LEFT JOIN books ON editor.id = books.book_editor_id
    GROUP BY editor.editor_name
");
$books_by_editor = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Neodraco's Books</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <?php require 'php/favicon.php' ?>
</head>

<?php require 'php/menu.php' ?>

<body>
<main class="container mt-5">
    <div class="card mb-4">
        <div class="card-header">
            <h2>Statistiques Générales</h2>
        </div>
        <div class="card-body">
            <p><strong>Total des livres enregistrés :</strong> <?= $total_books ?></p>
            <p><strong>Valeur totale de la bibliothèque :</strong> <?= number_format($total_value, 2, ',', ' ') ?> €</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2>Nombre de livres par série</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Série</th>
                    <th>Nombre de livres</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($books_by_series as $series): ?>
                    <tr>
                        <td><?= htmlspecialchars($series['series_name']) ?></td>
                        <td><?= $series['book_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2>Nombre de livres par auteur</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Auteur</th>
                    <th>Nombre de livres</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($books_by_author as $author): ?>
                    <tr>
                        <td><?= htmlspecialchars($author['author_name']) ?></td>
                        <td><?= $author['book_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2>Nombre de livres par éditeur</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Éditeur</th>
                    <th>Nombre de livres</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($books_by_editor as $editor): ?>
                    <tr>
                        <td><?= htmlspecialchars($editor['editor_name']) ?></td>
                        <td><?= $editor['book_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require 'php/footer.php' ?>
<?php require 'js/bootstrap_script.html' ?>
</body>
</html>