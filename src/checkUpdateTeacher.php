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

// Validation des saisies utilisateur
// Permet de stocker les erreurs
$errors = [];

// Permet de contrôler à choisir le genre
if (!isset($_POST['genre'])) {
    $errors[] = "il faut choisir un genre";
}

// Pattern de text
$textPattern = "/^[a-zA-Z]+$/";

// Permet de contôler à prénom avec pettern regex
if (! isset($_POST['firstName']) || ! preg_match($textPattern, $_POST['firstName'])) {
    $errors[] = "il faut remplir le Prénom";
}

// Permet de contôler à nom avec pettern regex
if (! isset($_POST['name']) || ! preg_match($textPattern, $_POST['name'])) {
    $errors[] = "il faut remplir le Nom";
}

// Permet de contôler à surnom avec pettern regex
if (! isset($_POST['nickName']) || ! preg_match($textPattern, $_POST['nickName'])) {
    $errors[] = "il faut remplir le Surnom";
}

// Permet de contôler à origin avec pettern regex
if (! isset($_POST['origin']) || ! preg_match($textPattern, $_POST['origin'])) {
    $errors[] = "il faut remplir le Origine";
}

// Permet de contrôler à choisir la section
if ($_POST['section'] == "") {
    $errors[] = "il faut choisir une Section";
}

// Permet de contôler à prénom avec pettern regex
if (count($errors) === 0) {

    // Appeler la fonction dans la page base de données
    $db->updateTeacher($_POST);

    // Permet de ouvrir la page d'accueil
    header("Location: ./index.php");
    exit;
} else {
    // Affichage les erreurs
    echo "<pre>";
    var_dump($errors);
    echo "</pre>";
}
