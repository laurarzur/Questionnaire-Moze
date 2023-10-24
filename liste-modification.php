<?php
    session_start();

    if (!isset($_SESSION["administrateur"])) {
        header("Location: connexion.php");
        exit();
    } else {
        $admin = unserialize($_SESSION["administrateur"]);
    } 

    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=moze;charset=utf8", "root", "");
    $query = $pdo->prepare("SELECT id, texte FROM questions;"); 
    $query->setFetchMode(PDO::FETCH_ASSOC); 
    $query->execute(); 
    $questions = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <title>Modifier des questions / réponses</title>
    </head>

    <body>
        <header>
            <a href="accueil.php"><img src="img/moze-logo.png" alt="logo Moze"></a>
        </header>

        <main>
            <h1 class="h2 m-5 text-center">Sélectionnez la question à modifier.</h1> 
                <div class="container">
                    <div class="row justify-content-center">
                        <ul class="list-group list-group-flush m-5">
                        <?php 
                            foreach ($questions as $question) { ?>
                                <div class="col-12 col-lg-8 m-auto">
                                    <li class="list-group-item list-group-item-action text-center p-5 w-100 h-100"><a class="liste-questions text-dark text-decoration-none fs-5" href="modification-question.php" id="<?= $question["id"]; ?>"><?= $question["texte"]; ?></a></li>
                                </div>
                        <?php }
                        ?>
                        </ul>
                    </div>
                </div>

            <form action="modification-question.php" method="post" id="hidden-form">
                <input type="hidden" name="update-input" id="update-input" value="">
            </form>
        </main>

        <footer>

            <script>
                const lienQuestions = document.querySelectorAll(".liste-questions"); // récupérer les liens des questions à modifier

                lienQuestions.forEach((lien) => { // pour chaque lien
                    lien.addEventListener("click", function () {
                        console.log("cliqué");
                        const idQuestion = lien.getAttribute("id"); // obtenir l'id de la question cliquée

                        // document.cookie = "id = " + idQuestion; // le renvoyer à PHP 

                               $.ajax({
                                    type: "POST", 
                                    url: "api/get-id-question.php", 
                                    data: { idQuestion: idQuestion }, 
                                    success: function(response) {
                                        console.log(idQuestion);
                                    }
                                });
                            });
                        }); 

                       /* const form = document.getElementById("hidden-form") // formulaire caché
                        const input = document.getElementById("update-input"); // input type hidden

                        input.value = idQuestion; // entrer l'id de la question cliquée dans l'input

                        form.submit(); // soumettre le formulaire 

                    });
                }); */
            </script>
        </footer>
    </body>
</html>