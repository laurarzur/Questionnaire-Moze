<?php
    session_start();

    if (!isset($_SESSION["administrateur"])) {
        header("Location: connexion.php");
        exit();
    } else {
        $admin = unserialize($_SESSION["administrateur"]);
    } 

    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=moze;charset=utf8", "root", "");
    $query = $pdo->prepare("SELECT * FROM administrateur WHERE email = :email ORDER BY id DESC;");

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <title>Partie Administrateur</title>
    </head>

    <body>
        <header>
            <a href="accueil.php"><img src="img/moze-logo.png" alt="logo Moze"></a>
        </header>

        <main>
            <h1 class="h2 text-center m-5">Bienvenue</h1> 
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-4 m-5">
                        <button class="btn btn-outline-info w-100 h-100 btn-block btn-lg p-5"><a class="text-dark text-decoration-none" href="ajout.php">Ajouter des questions / réponses</a></button>
                    </div>
                    <div class="col-12 col-lg-4 m-5">
                        <button class="btn btn-outline-warning w-100 h-100 btn-block btn-lg p-5"><a class="text-dark text-decoration-none" href="liste-modification.php">Modifier des questions / réponses</a></button>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-4 m-5">
                        <button class="btn btn-outline-danger w-100 h-100 btn-block btn-lg p-5"><a class="text-dark text-decoration-none" href="liste-suppression.php">Supprimer des questions / réponses</a></button> 
                    </div>
                    <div class="col-12 col-lg-4 m-5">
                        <button class="btn btn-outline-warning w-100 h-100 btn-lg p-5"><a class="text-dark text-decoration-none" href="profil-liste.php">Modifier les profils</a></button>
                    </div>
                </div>
            </div>
        </main>

        <footer>

        </footer>
    </body>
</html>