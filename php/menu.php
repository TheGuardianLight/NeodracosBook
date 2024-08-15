<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm py-3">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">Neodraco's Books</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Livres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="author.php">Auteurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="editor.php">Éditeurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="series.php">Séries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Votre compte</a>
                </li>
            </ul>
            <form action="php/logout.php" method="post" class="d-flex">
                <button type="submit" class="btn btn-outline-danger">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>