<?php
    session_start();

    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=moze;charset=utf8", "root", "");
    $query = $pdo->prepare("SELECT COUNT(id) as total FROM questions;"); // compter le nombre d'id pour connaitre le nombre de questions
    $query->setFetchMode(PDO::FETCH_ASSOC);

    if ($query->execute()) {
        $resultat = $query->fetch();
        $totalQuestions = $resultat["total"]; //intval($resultat["total"]); 
        $progressBar = 100 / $totalQuestions; 

        $query = $pdo->prepare("SELECT COUNT(id) as total FROM questions WHERE id_types = 2;"); 
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $query->execute();
        $result = $query->fetch(); 
        $totalCheckbox = $result["total"]; //intval($result["total"]);
        $totalAutres = $totalQuestions - $totalCheckbox; 

        $_SESSION["total"] = $totalQuestions;
        $_SESSION["checkbox"] = $totalCheckbox;
        $_SESSION["autres"] = $totalAutres;

        $query = $pdo->prepare("SELECT id, texte, id_types, id_propositions, nombre FROM questions;"); 

        if ($query->execute()) { 
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $questions = $query->fetchAll(); 
            $idQuestion = intval($questions[0]["id"]);
        } 
    } 
?> 

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="css/style.css" rel="stylesheet">
        <title>Questionnaire</title>
    </head> 

    <body>
        <header>

        </header>

        <main>
            <h1 class="h2 m-5 text-center" id="num-question">Questionnaire</h1>
            <form action="">
                <?php 
                    $numero = 0;
                    $width = 0;
                    foreach ($questions as $question) { 
                        $numero += 1;  
                        $width += $progressBar; ?> 
                        <div class="ensemble" id="ensemble<?= $numero; ?>"> 
                            <div class="progress m-5"> 
                                <div class="progress-bar bg-info" style="width:<?= $width; ?>%"></div>
                            </div>
                            <h2 class="h3 m-3 text-center">Question <?= $numero; ?></h2>
                            <p class="h5 d-flex justify-content-center mt-5"><?= $question["texte"]; ?></p> 
                        <?php   
                        $name = "question" . $numero;
                        $idQuestion = intval($question["id"]); 
                        $idProposition = $question["id_propositions"];
                        $requete = $pdo->prepare("SELECT id, texte FROM propositions WHERE id = :id;"); 
                        $requete->bindParam(":id", $idProposition, PDO::PARAM_INT);
                        $requete->setFetchMode(PDO::FETCH_ASSOC);
                        $requete->execute(); 
                        $reponses = $requete->fetchAll();  
                        $reponse = $reponses[0]["texte"]; 
                        //var_dump($reponse); 
                        $rep = preg_split('/;/', $reponse); 

                        if ($question["id_types"] == 1) { // déterminer le type de l'input à partir de la bdd et l'affecter à une variable
                            $type = "radio"; 
                        } elseif ($question["id_types"] == 2) {
                            $type = "checkbox";
                        } else {
                            $type = "range";
                        } 


                        switch ($question["nombre"]) { // afficher autant d'input qu'il y a de reponses à une question
                            case 1: ?>
                                <div class="d-flex justify-content-center">
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-lg-5 m-3 text-center">
                                            <span id="range-value" class="h6 m-3 w-100">Faites glisser le curseur</span>
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="range" id="input1" value="0" min="0" max="10" onchange="rangeSlide(this.value)" onmousemove="rangeSlide(this.value)"> 
                                            <label for="<?= $name; ?>" id="label1" class="label h6 m-3"><?= $rep[0]; ?></label> <!-- remplir automatiquement les valeurs en fonction de la question et de la réponse --> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php break; 
                            case 2: ?> 
                                <div class="d-flex justify-content-center">
                                    <div class="row justify-content-center">
                                        <div class="h6 col-12 col-lg-5 m-3 text-center">
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="input" id="input1"> 
                                            <label for="<?= $name; ?>" id="label1" class="label btn btn-outline-dark disabled w-100 h-100""><?= $rep[0]; ?></label> 
                                        </div>
                                        <div class="h6 col-12 col-lg-5 m-3 text-center">
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="input" id="input2"> 
                                            <label for="<?= $name; ?>" id="label2" class="label btn btn-outline-dark disabled w-100 h-100""><?= $rep[1]; ?></label> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php break; 
                            case 3: ?> 
                                <div class="d-flex justify-content-center">
                                    <div class="row justify-content-center">
                                        <div class="h6 col-12 col-lg-5 m-3 text-center">
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="input" id="input1"> 
                                            <label for="<?= $name; ?>" id="label1" class="label btn btn-outline-dark disabled w-100 h-100 h6"><?= $rep[0]; ?></label> 
                                        </div>
                                        <div class="h6 col-12 col-lg-5 m-3 text-center">
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="input" id="input2"> 
                                            <label for="<?= $name; ?>" id="label2" class="label btn btn-outline-dark disabled w-100 h-100"><?= $rep[1]; ?></label> 
                                        </div>
                                        <div class="h6 col-12 col-lg-5 m-3 text-center">
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="input" id="input3"> 
                                            <label for="<?= $name; ?>" id="label3" class="label btn btn-outline-dark disabled w-100 h-100"><?= $rep[2]; ?></label> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php break; 
                            case 4: ?>
                                <div class="d-flex justify-content-center">
                                    <div class="row justify-content-center">
                                        <div class="h6 col-12 col-lg-5 m-3 text-center">
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="input" id="input1"> 
                                            <label for="<?= $name; ?>" id="label1" class="label btn btn-outline-dark disabled w-100 h-100""><?= $rep[0]; ?></label> 
                                        </div>
                                        <div class="h6 col-12 col-lg-5 m-3 text-center">
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="input" id="input2"> 
                                            <label for="<?= $name; ?>" id="label2" class="label btn btn-outline-dark disabled w-100 h-100""><?= $rep[1]; ?></label> 
                                        </div>
                                        <div class="h6 col-12 col-lg-5 m-3 text-center">
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="input" id="input3"> 
                                            <label for="<?= $name; ?>" id="label3" class="label btn btn-outline-dark disabled w-100 h-100""><?= $rep[2]; ?></label> 
                                        </div> 
                                        <div class="h6 col-12 col-lg-5 m-3 text-center">
                                            <input type="<?= $type; ?>" name="<?= $name; ?>" class="input" id="input4"> 
                                            <label for="<?= $name; ?>" id="label4" class="label btn btn-outline-dark disabled w-100 h-100""><?= $rep[3]; ?></label> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        <?php 
                        }  
                    }
                ?>
            </form> 

            <input type="hidden" name="total" id="total" value=<?= $totalQuestions; ?>> <!-- faire passer une variable php en js --> 
            <input type="hidden" name="type" id="type" value=<?= $type; ?>>  
            <div class="d-flex justify-content-center">
                <button class="h6 text-white btn m-5 px-5" id="valider">Valider</button> 
            </div>
            <br>
            <!--<p>Score: <span id="score">0</span></p>-->
        
            <br><br>
            
            <div class="row">
                <button class="h6 btn btn-info text-white" id="precedent"><< Précédent</button>
                <button class="h6 btn btn-info text-white" id="suivant">Suivant >></button>
                <button class="h6 btn btn-info text-white" id="resultats"><a class="text-decoration-none text-white" href="resultats.php">Voir les résultats</a></button>
            </div>
            <script src="js/script.js"></script>
        </main>

        <footer>

        </footer>
    </body>
</html>