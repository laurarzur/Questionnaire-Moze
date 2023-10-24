<?php 

    /**
    * Fonction qui nettoie les entrées utilisateurs en enlevant les espaces inutiles 
    * et en changeant les tags en entités html
    * @param string $input entrée utilisateur à nettoyer
    * @return string entrée utilisateur nettoyée
    */
    function sanitize($input) : string {
        $output = trim($input); 
        $output = htmlspecialchars($output); 
        return $output;
    }