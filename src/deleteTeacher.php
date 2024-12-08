<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 10.10.2024
Description   : Supprimer un enseignant
*/

// Ajouter la page Datebase.php
include("./Database.php");

// Connection de base de données
$db = new Database();

// Appeler la fonction dans la page base de données
$db->deleteTeacher($_GET["idTeacher"]);

// Permet de ouvrir la page d'accueil
header("Location: /index.php");
exit;
