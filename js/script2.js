

const questionsLiens = document.querySelectorAll(".questions-liste"); // récupérer les liens des questions à supprimer

questionsLiens.forEach((lien) => { // pour chaque lien
    lien.addEventListener('click', function (e) { 
        e.preventDefault(); // empêcher de suivre le faux lien
        const questionId = lien.getAttribute('id'); // obtenir l'id de la question cliquée 
            if (confirm("Êtes-vous sûr de vouloir supprimer cette question ?")) { 
                document.cookie = "question = " + questionId; // le renvoyer à PHP 
                console.log(questionId);
            }
        // document.cookie = "question = " + questionId; // le renvoyer à PHP 
    });
});

function confirmerSuppression() { 
    if (confirm("Êtes-vous sûr de vouloir supprimer cette question ?")) { 
        document.cookie = "question = " + questionId; // le renvoyer à PHP 
        console.log(questionId);
    }
}

const liensProfils = document.querySelectorAll(".liste-profils"); // récupérer les liens des profils à modifier

liensProfils.forEach((lien) => { // pour chaque lien
    lien.addEventListener('click', function () {

        const idProfil = lien.getAttribute('id'); // obtenir l'id du profil

        document.cookie = "profil = " + idProfil; // le renvoyer à PHP
    });
}); 