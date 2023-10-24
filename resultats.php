<?php 
    session_start(); 
    $totalQuestions = $_SESSION["total"];
    $totalCheckbox = $_SESSION["checkbox"];
    $totalAutres = $_SESSION["autres"]; 
    $score = $_COOKIE["score"];

    $maxCheckbox = 8 * $totalCheckbox; 
    $maxAutres = 5 * $totalAutres; 
    $pointsMax = $maxCheckbox + $maxAutres; 
    $palier1 = round($pointsMax / 3); 
    $palier2 = $palier1 *2; 

    $rdv = "";
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=moze;charset=utf8", "root", "");
    if ($score <= $palier1) { 
        $query = $pdo->prepare("SELECT texte FROM profils WHERE id = 1;");
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute(); 
        $profil = $query->fetch(); 
        $query = $pdo->prepare("SELECT texte FROM besoins_resources WHERE id = 1;");
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute(); 
        $besoin = $query->fetch();
        $query = $pdo->prepare("SELECT texte FROM recommandations WHERE id = 1;");
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute(); 
        $recommandation = $query->fetch(); 

    } elseif ($score > $palier1 && $score <= $palier2) {
        $query = $pdo->prepare("SELECT texte FROM profils WHERE id = 2;");
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute(); 
        $profil = $query->fetch(); 
        $query = $pdo->prepare("SELECT texte FROM besoins_resources WHERE id = 2;");
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute(); 
        $besoin = $query->fetch();
        $query = $pdo->prepare("SELECT texte FROM recommandations WHERE id = 2;");
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute(); 
        $recommandation = $query->fetch(); 

    } else {
        $query = $pdo->prepare("SELECT texte FROM profils WHERE id = 3;");
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute(); 
        $profil = $query->fetch(); 
        $query = $pdo->prepare("SELECT texte FROM besoins_resources WHERE id = 3;");
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute(); 
        $besoin = $query->fetch();
        $query = $pdo->prepare("SELECT texte FROM recommandations WHERE id = 3;");
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute(); 
        $recommandation = $query->fetch(); 
        $rdv = "ok";
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Résultats</title>
    </head>
    <body>
        <header>

        </header>

        <main>
            <h1 class="h2 m-5 text-center">Votre résultat</h1>
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-4">
                        <h2 class="h4 mt-5 mb-4 text-info">Profil</h2>
                        <p><?= implode($profil); ?></p> 
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-4">
                        <h2 class="h4 mt-5 mb-4 text-info">Besoins & Resources</h2>
                        <p><?= implode($besoin); ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-4">
                        <h2 class="h4 mt-5 mb-4 text-info">Recommandations</h2>
                        <p class="mb-5"><?= implode($recommandation); ?></p>
                    </div>
                </div>
                <?php 
                if ($rdv == "ok") { ?>
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-4">
                            <button class="btn btn-info mt-5 text-white text-center">Prendre rendez-vous</button>
                        </div>
                    </div>
                <?php }
            ?>
            </div>
        </main>

        <footer>

        </footer>
    </body>
</html>