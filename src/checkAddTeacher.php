<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 30.09.2024
Description   : Validation des saisies utilisateur 
*/

// Ajouter la page Database.php
include ("./Database.php");

// Connection de la base de données
$db = new Database();

// TODO : ?????? Validation des saisies utilisateur

// Appeler la fonction dans le fichier Database.php
$db->addTeacher($_POST);

// Permet de ouvrir la page d'accueil
header("Location: ./index.php");
exit;
?>