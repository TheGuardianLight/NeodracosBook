<?php
/*
 * Copyright (c) 2024 - Veivneorul. This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (BY-NC-ND 4.0).
 */

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Neodraco's Books | Register</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <?php require 'php/favicon.php' ?>
</head>

<?php require 'php/menu.php' ?>

<body>
<div class="container login-register">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="mb-3">Inscription</h2>
            <form class="needs-validation mb-3" novalidate action="register.php" method="post">
                <div class="form-group mb-3">
                    <label for="firstname" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Le prénom est requis.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="lastname" class="form-label">Nom de famille</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom de famille" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Le nom de famille est requis.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        L'email est requis.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Le mot de passe est requis.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="password-confirm" name="password-confirm" placeholder="Confirmer le mot de passe" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        La confirmation du mot de passe est requise.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">S'inscrire</button>
            </form>
        </div>
    </div>
</div>

<?php require 'js/bootstrap_script.html' ?>

</body>

<?php require 'php/footer.php'?>

</html>