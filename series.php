<?php
global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul. This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

/**
 * Page "Series.php"
 */

session_start(); // Start the session

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require 'vendor/autoload.php';
require 'php/db_connect.php';
require 'php/series_managment.php';

// Fetch all authors
$stmt = $pdo->query("SELECT id, author_name FROM author");
$authors = $stmt->fetchAll();

// Fetch all series
$stmt = $pdo->query("SELECT series.*, author.author_name FROM series JOIN author ON series.series_author = author.id");
$series = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Neodraco's Books | Series</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <?php require 'php/favicon.php' ?>
</head>

<?php require 'php/menu.php' ?>

<body>

<main class="container mt-5">
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Ajouter une série</h2>
        </div>
        <div class="card-body">
            <form action="series.php" method="post">
                <div class="mb-3">
                    <label for="series_name" class="form-label">Nom de la série</label>
                    <input type="text" class="form-control" id="series_name" name="series_name" required>
                </div>
                <div class="mb-3">
                    <label for="series_author" class="form-label">Auteur de la série</label>
                    <select class="form-select" id="series_author" name="series_author" required>
                        <option value="">Sélectionner un auteur</option>
                        <?php foreach ($authors as $author): ?>
                            <option value="<?= htmlspecialchars($author['id']) ?>"><?= htmlspecialchars($author['author_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h2 class="h4 mb-0">Liste des séries</h2>
        </div>
        <div class="card-body">
            <?php if (empty($series)): ?>
                <div class="alert alert-warning" role="alert">
                    Aucune série n'est enregistrée
                </div>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($series as $serie): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= htmlspecialchars($serie['series_name']) ?></strong> par <?= htmlspecialchars($serie['author_name']) ?>
                            </div>
                            <form action="series.php" method="post" class="m-0">
                                <input type="hidden" name="delete_series_id" value="<?= $serie['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require 'php/footer.php' ?>
<?php require 'js/bootstrap_script.html' ?>

</body>
</html>