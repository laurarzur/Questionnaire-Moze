<?php
    session_start();

    if (!isset($_SESSION["administrateur"])) {
        header("Location: connexion.php");
        exit();
    } else {
        $admin = unserialize($_SESSION["administrateur"]);
    } 

    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=moze;charset=utf8", "root", "");
    $query = $pdo->prepare("SELECT id, texte, id_propositions FROM questions;"); 
    $query->setFetchMode(PDO::FETCH_ASSOC); 
    $query->execute(); 
    $questions = $query->fetchAll(); 

    if (isset ($_COOKIE["question"])) {
        $propositionId = $_COOKIE["question"];
       // $questionId = intval($questionId); 
        $query = $pdo->prepare("DELETE FROM questions WHERE id_propositions = :proposition;"); 
        $query->bindParam(":proposition", $propositionId, PDO::PARAM_INT); 
        if ($query->execute()) {
            $query = $pdo->prepare("DELETE FROM propositions WHERE id = :proposition;"); 
            $query->bindParam(":proposition", $propositionId, PDO::PARAM_INT); 
            if ($query->execute()) { ?>
                <p class="alert alert-success">La question a bien été supprimée.</p>

            <?php } else { ?>
                <p class="alert alert-warning">Une erreur s'est produite.</p>
            <?php }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <title>Supprimer des questions / réponses</title>
    </head>

    <body>
        <header>
            <a href="accueil.php"><img src="img/moze-logo.png" alt="logo Moze"></a>
        </header>

        <main>
            <h1 class="h2 m-5 text-center">Sélectionnez la question à supprimer.</h1> 
            <div class="container">
                <div class="row justify-content-center">
                    <ul class="list-group list-group-flush m-5">
                        <?php 
                            foreach ($questions as $question) { ?>
                                <div class="col-12 col-lg-8 m-auto">
                                    <li class="list-group-item list-group-item-action text-center p-5 w-100 h-100"><a href="#" class="questions-liste text-dark text-decoration-none fs-5" id="<?= $question["id_propositions"]; ?>"><?= $question["texte"]; ?></a></li>
                                </div>
                        <?php }
                        ?>
                    </ul>
                </div>
            </div>
        </main>

        <footer>
            <script src="js/script2.js"></script>
        </footer>
    </body>
</html>