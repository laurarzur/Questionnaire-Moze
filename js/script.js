// AFFICHER LA VALEUR DU RANGE
function rangeSlide(value) {
    document.getElementById("range-value").innerHTML = value; //+ "€";
}

// CALCULER LE SCORE 
const valider = document.getElementById("valider");
const precedent = document.getElementById("precedent");
const suivant = document.getElementById("suivant");
const resultats = document.getElementById("resultats");
 
suivant.disabled = true;

document.addEventListener("DOMContentLoaded", function () {
    const totalQuestions = parseInt(document.getElementById("total").value);
    const questionType = document.getElementById("type").value;

    const points = [5, 0, 2, 1];  // points pour chaque input

    valider.addEventListener("click", function () {
        let score = 0; // réinitialiser le score à chaque validation

        for (let i = 1; i <= totalQuestions; i++) {
            const inputs = document.getElementsByName("question" + i); // chaque réponse
            
            inputs.forEach(input => {
                if (input.checked || (input.type === "range" && input.value !== "0")) {
                    const inputId = input.id; // id de l'input
                    const inputNumber = parseInt(inputId.replace("input", "")); // numéro de l'input
                    const inputPoints = points[inputNumber - 1]; // points attribués pour ce numéro d'input
                    score += inputPoints; // additionner au score 
                    suivant.disabled = false;
                }
            });
        }
       // document.getElementById("score").textContent = score; 
        document.cookie = "score = " + score;
    });
});

// N'AFFICHER QU'UNE QUESTION A LA FOIS
const ensembles = document.querySelectorAll(".ensemble"); 
console.log(ensembles); 

let currentQuestionIndex = 0; // question actuelle

function showQuestion(index) { // afficher la question de l'index spécifié
    ensembles.forEach((ensemble, i) => {
        ensemble.style.display = i === index ? "block" : "none";
    });

    currentQuestionIndex = index;
    updateButtonStates();
}
 
function updateButtonStates() { // activer/désactiver les boutons en fonction de la question
    precedent.disabled = currentQuestionIndex === 0;
    // suivant.disabled = currentQuestionIndex === ensembles.length - 1; 
    suivant.style.display = currentQuestionIndex < ensembles.length - 1 ? "block" : "none";
    resultats.style.display = currentQuestionIndex === ensembles.length - 1 ? "block" : "none";
}

precedent.addEventListener("click", () => { // afficher la question précédente
    if (currentQuestionIndex > 0) {
        showQuestion(currentQuestionIndex - 1);
    }
});

suivant.addEventListener("click", () => { // afficher la question suivante
    if (currentQuestionIndex < ensembles.length - 1) {
        showQuestion(currentQuestionIndex + 1); 
        suivant.disabled = true;
    }
});

showQuestion(0); // afficher la première question au chargement de la page

 
