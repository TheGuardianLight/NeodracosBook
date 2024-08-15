<?php global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul. This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

/**
 * Page "Author.php"
 */

session_start(); // Start the session

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require 'vendor/autoload.php';
require 'php/db_connect.php';
require 'php/author_managment.php';

// Fetch all authors
$stmt = $pdo->query("SELECT * FROM author");
$authors = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Neodraco's Books | Auteurs</title>
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
            <h2 class="h4 mb-0">Ajouter un auteur</h2>
        </div>
        <div class="card-body">
            <form action="author.php" method="post">
                <div class="mb-3">
                    <label for="author_name" class="form-label">Nom de l'auteur</label>
                    <input type="text" class="form-control" id="author_name" name="author_name" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h2 class="h4 mb-0">Liste des auteurs</h2>
        </div>
        <div class="card-body">
            <?php if (empty($authors)): ?>
                <div class="alert alert-warning" role="alert">
                    Aucun auteur n'est enregistré
                </div>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($authors as $author): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($author['author_name']) ?>
                            <form action="author.php" method="post" class="m-0">
                                <input type="hidden" name="delete_author_id" value="<?= $author['id'] ?>">
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