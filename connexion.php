<?php 
    session_start(); 

    $email = ""; 
    $mdp = ""; 

    if (isset($_POST["email"]) && isset($_POST["mdp"])) { // si chaque champ est rempli

        $email = $_POST["email"]; 
        $mdp = $_POST["mdp"];
        require "config.php";
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=$charset", $dbuser, $dbpass);
        $query = $pdo->prepare("SELECT * FROM administrateur WHERE email = :email ORDER BY id DESC;"); // vérifier si l'email est dans la bdd

        $query->bindParam(":email", $email, PDO::PARAM_STR); 

        $query->setFetchMode(PDO::FETCH_ASSOC);

        $query->execute(); 
        $resultats = $query->fetchAll(); 
    

        if (count($resultats) == 1) { 
                
            if (password_verify($_POST["mdp"], $resultats[0]["mdp"])) { 
                $_SESSION["administrateur"] = serialize($resultats[0]);
                header("Location: accueil.php");  
            } else { ?>
                <div class="alert alert-warning">
                    <?= $message = "Les données saisies sont incorrectes."; ?>
                </div>
            <?php 
            }

        } else { 
            echo "Votre compte n'existe pas";
        } 
    } 
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <title>Connexion</title>
    </head>

    <body>
        <header>

        </header>

        <main class="container mt-5">
            <h1 class="h2 m-5 text-center">Connectez-vous</h1>

            <div class="d-flex justify-content-center">
                <form action="" method="post" class="m3 text-center p-5 col-12 col-lg-6 justify-content-center border rounded">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10">
                            <label for="email" class="form-label">Adresse email</label>
                        </div>
                        <div class="col-12 col-lg-10">
                            <input type="email" name="email" id="email" autocomplete="email" class="form-control">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10">
                            <label for="mdp" class="form-label mt-3">Mot de passe</label>
                        </div>
                        <div class="col-12 col-lg-10">
                            <input type="password" name="mdp" id="mdp" autocomplete="current-password" class="form-control">
                        </div>
                    </div>
                    <button class="btn btn-info text-white mt-5">Se connecter</button>
                </form>
            </div>
        </main>

        <footer>

        </footer>
    </body>
</html>