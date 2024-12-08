<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 14.10.2024
Description   : Contôler des saisies utilisateur pour mettre à jour un enseignant
*/

// Ajouter la page Datebase.php
include("./Database.php");

// Connection de la base de données
$db = new Database();

// Permet de stocker les erreurs
$errors = [];

// Permet de contrôler à choisir le genre
if (!isset($_POST['genre'])) {
    $errors[] = "il faut choisir un genre";
}

// Pattern de prénom
$firstNamePattern = "/^[a-zA-Z]+$/";

// Permet de contôler à prénom avec pettern regex
if (! isset($_POST['firstName']) || ! preg_match($firstNamePattern, $_POST['firstName'])) {
    $errors[] = "il faut remplir le prénom";
}

// Permet de contôler à prénom avec pettern regex
if (count($errors) === 0) {

    // Appeler la fonction dans la page base de données
    $db->updateTeacher($_POST);

    // Permet de ouvrir la page d'accueil
    header("Location: ./index.php");
    exit;
} else {
    echo "<pre>";
    var_dump($errors);
    echo "</pre>";
}
