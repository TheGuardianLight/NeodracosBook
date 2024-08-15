<?php
global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul.
 * This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

/**
 * Page "add_books.php"
 */

session_start(); // Start the session

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require 'vendor/autoload.php';
require 'php/db_connect.php';
require 'php/book_managment.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Neodraco's Books | Ajout de livre</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <?php require 'php/favicon.php'; ?>
</head>

<?php require 'php/menu.php'; ?>

<body>
<main class="container mt-5">
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Ajouter un livre</h2>
        </div>
        <div class="card-body">
            <form action="add_book.php" method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="book_name" class="form-label">Titre du livre</label>
                        <input type="text" class="form-control" id="book_name" name="book_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="book_author_id" class="form-label">Auteur</label>
                        <select class="form-select" id="book_author_id" name="book_author_id" required>
                            <option value="">Sélectionner un auteur</option>
                            <?php foreach ($authors as $author): ?>
                                <option value="<?= htmlspecialchars($author['id']) ?>"><?= htmlspecialchars($author['author_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="book_series_id" class="form-label">Série</label>
                        <select class="form-select" id="book_series_id" name="book_series_id" required>
                            <option value="">Sélectionner une série</option>
                            <?php foreach ($series as $serie): ?>
                                <option value="<?= htmlspecialchars($serie['id']) ?>"><?= htmlspecialchars($serie['series_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="book_editor_id" class="form-label">Éditeur</label>
                        <select class="form-select" id="book_editor_id" name="book_editor_id" required>
                            <option value="">Sélectionner un éditeur</option>
                            <?php foreach ($editors as $editor): ?>
                                <option value="<?= htmlspecialchars($editor['id']) ?>"><?= htmlspecialchars($editor['editor_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="book_nbe" class="form-label">Numéro de tome</label>
                        <input type="number" class="form-control" id="book_nbe" name="book_nbe" required>
                    </div>
                    <div class="col-md-4">
                        <label for="book_date" class="form-label">Date de publication</label>
                        <input type="date" class="form-control" id="book_date" name="book_date" required>
                    </div>
                    <div class="col-md-4">
                        <label for="book_price" class="form-label">Prix d'achat (€)</label>
                        <input type="number" step="0.01" class="form-control" id="book_price" name="book_price" required>
                    </div>
                </div>
                <button type="submit" name="add_book" class="btn btn-primary btn-block">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-secondary text-white">
            <h2 class="h4 mb-0">Liste des livres</h2>
        </div>
        <div class="card-body">
            <?php if (empty($books)): ?>
                <div class="alert alert-warning" role="alert">
                    Aucun livre n'est enregistré
                </div>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($books as $book): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= htmlspecialchars($book['book_name']) ?></strong> par <?= htmlspecialchars($book['author_name']) ?>
                                (<?= htmlspecialchars($book['series_name']) ?>, <?= htmlspecialchars($book['editor_name']) ?>)
                                <div class="text-muted">Tome: <?= htmlspecialchars($book['book_nbe']) ?> | Publié le: <?= htmlspecialchars($book['book_date']) ?> | Prix: €<?= htmlspecialchars($book['book_price']) ?></div>
                            </div>
                            <form action="add_book.php" method="post" class="m-0">
                                <input type="hidden" name="delete_book_id" value="<?= $book['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require 'php/footer.php'; ?>
<?php require 'js/bootstrap_script.html'; ?>

</body>
</html>