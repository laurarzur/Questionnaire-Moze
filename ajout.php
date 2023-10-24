<?php
    session_start();

    if (!isset($_SESSION["administrateur"])) {
        header("Location: connexion.php");
        exit();
    } else {
        $admin = unserialize($_SESSION["administrateur"]);
    } 

    if (isset($_POST["question"]) && isset($_POST["type"]) && isset($_POST["nombre"]) && isset($_POST["rep"])) {

        $pdo = new PDO("mysql:host=localhost;port=3306;dbname=moze;charset=utf8", "root", "");
        $query = $pdo->prepare("INSERT INTO propositions (texte, id_types) VALUES (:rep, :type);"); 
        require "sanitize.php";
        $question = sanitize($_POST["question"]); 
        $type = sanitize($_POST["type"]); 
        $nombre = sanitize($_POST["nombre"]); 
        $rep = sanitize($_POST["rep"]);  

        $query->bindParam(":rep", $rep, PDO::PARAM_STR); 
        $query->bindParam(":type", $type, PDO::PARAM_INT); 
        if ($query->execute()) {
            $query = $pdo->prepare("SELECT id FROM propositions ORDER BY id DESC LIMIT 1 ;"); 
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $dernierId = $query->fetch(); 
            $id = intval($dernierId["id"]); 

            $query = $pdo->prepare("INSERT INTO questions (texte, id_propositions, nombre, id_types) VALUES (:question, :propositions, :nombre, :type);"); 
            $query->bindParam(":question", $question, PDO::PARAM_STR); 
            $query->bindParam(":propositions", $id, PDO::PARAM_INT); 
            $query->bindParam(":nombre", $nombre, PDO::PARAM_INT); 
            $query->bindParam(":type", $type, PDO::PARAM_INT); 
            if ($query->execute()) { ?>
                <p class="alert alert-success">La question a bien été ajoutée à la base de données.</p>
            <?php } else { ?>
                <p class="alert alert-warning">Une erreur s'est produite.</p>
            <?php } 
        } 
    } else {
        $message = "Veuillez remplir tous les champs.";
    } 
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Ajouter des questions / réponses</title>
    </head>

    <body>
        <header>
            <a href="accueil.php"><img src="img/moze-logo.png" alt="logo Moze"></a>
        </header>

        <main>
            <h1 class="h2 m-5 text-center">Saisissez ci-dessous les questions et réponses à ajouter au questionnaire.</h1> 
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="text-center p-5 col-12 col-lg-6 justify-content-center">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10">
                            <label for="question" class="form-label mt-3">Libellé de la question</label> 
                        </div>
                        <div class="col-12 col-lg-10 mb-3">
                            <textarea name="question" id="question" cols="50" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10">
                            <label for="type" class="form-label mt-3">Type de réponses associé<br>(entrez 1 pour un seul choix de réponse,<br>2 pour pouvoir cocher plusieurs réponses,<br>3 pour sélectionner un chiffre sur une échelle)</label> 
                        </div>
                        <div class="col-12 col-lg-3 mb-3">
                            <input type="number" name="type" id="type" class="form-control" min=1 max=3>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10">
                            <label for="nombre" class="form-label mt-3">Nombre de réponses possibles (4 maximum)</label> 
                        </div>
                        <div class="col-12 col-lg-3 mb-3">
                            <input type="number" name="nombre" id="nombre" class="form-control" min=1 max=4> 
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10">
                            <label for="rep" class="form-label mt-3">Entrez toutes les possibilités de réponses séparées d'un point-virgule<br>(si le type de réponse est une échelle, définir l'échelle de notation ci-dessous)</label>
                        </div>
                        <div class="col-12 col-lg-10 mb-3">
                            <textarea name="rep" id="rep" cols="50" class="form-control" rows="6"></textarea> 
                        </div>
                    </div>
                    <button class="btn btn-info text-white mt-5">Enregistrer</button>
                </form>
            </div>
        </main>

        <footer>

        </footer>
    </body>
</html>