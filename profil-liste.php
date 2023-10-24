<?php
    session_start();

    if (!isset($_SESSION["administrateur"])) {
        header("Location: connexion.php");
        exit();
    } else {
        $admin = unserialize($_SESSION["administrateur"]);
    } 

    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=moze;charset=utf8", "root", "");
    $query = $pdo->prepare("SELECT id, texte FROM profils;"); 
    $query->setFetchMode(PDO::FETCH_ASSOC); 
    $query->execute(); 
    $profils = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <title>Modifier des profils</title>
    </head>

    <body>
        <header>
            <a href="accueil.php"><img src="img/moze-logo.png" alt="logo Moze"></a>
        </header>

        <main>
            <h1 class="h2 m-5 text-center">Sélectionnez le profil à modifier.</h1> 
            <div class="container">
                <div class="row justify-content-center">
                    <ul class="list-group list-group m-5">
                        <li class="list-group-item list-group-item-action text-center p-5 w-100 h-100"><a href="profil-modification.php" class="liste-profils text-dark text-decoration-none fs-5" id="<?= $profils[0]["id"]; ?>">Profil non satisfaisant</a></li>
                        <li class="list-group-item list-group-item-action text-center p-5 w-100 h-100"><a href="profil-modification.php" class="liste-profils text-dark text-decoration-none fs-5" id="<?= $profils[1]["id"]; ?>">Profil à améliorer</a></li>
                        <li class="list-group-item list-group-item-action text-center p-5 w-100 h-100"><a href="profil-modification.php" class="liste-profils text-dark text-decoration-none fs-5" id="<?= $profils[2]["id"]; ?>">Profil satisfaisant</a></li>
                    </ul>
                </div>
            </div>
        </main>

        <footer>
            <script src="js/script-copie.js"></script>
        </footer>
    </body>
</html>