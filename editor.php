<?php global $pdo;
/**
 * Copyright (c) 2024 - Veivneorul. This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

/**
 * Page "Editor.php"
 */

session_start(); // Start the session

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require 'vendor/autoload.php';
require 'php/db_connect.php';
require 'php/editor_managment.php';

// Fetch all editors
$stmt = $pdo->query("SELECT * FROM editor");
$editors = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Neodraco's Books | Editeur</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <?php require 'php/favicon.php' ?>
</head>

<?php require 'php/menu.php' ?>

<body>

<main class="container mt-5">
    <!-- Section for Adding Editors -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Ajouter un éditeur</h2>
        </div>
        <div class="card-body">
            <form action="editor.php" method="post">
                <div class="mb-3">
                    <label for="editor_name" class="form-label">Nom de l'éditeur</label>
                    <input type="text" class="form-control" id="editor_name" name="editor_name" required>
                </div>
                <div class="mb-3">
                    <label for="editor_website" class="form-label">Site internet (https://)</label>
                    <input type="url" class="form-control" id="editor_website" name="editor_website" required pattern="https://.*">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Section for Listing Editors -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-secondary text-white">
            <h2 class="h4 mb-0">Liste des éditeurs</h2>
        </div>
        <div class="card-body">
            <?php if (empty($editors)): ?>
                <div class="alert alert-warning" role="alert">
                    Aucun éditeur n'est enregistré
                </div>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($editors as $editor): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= htmlspecialchars($editor['editor_name']) ?></strong>
                                <a href="<?= htmlspecialchars($editor['editor_website']) ?>" target="_blank" class="ms-3">Visitez le site</a>
                            </div>
                            <form action="editor.php" method="post" class="m-0">
                                <input type="hidden" name="delete_editor_id" value="<?= $editor['id'] ?>">
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