<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 30.09.2024
Description   : Afficher les details de l'enseignant
*/

// Ajouter la page Database.php
include("Database.php");

// Permet de récupérer id de l'enseignant
$idTeacher = $_GET["idTeacher"];

// Connection de base de données
$db = new Database();

// Appeler la fonction dans le fichier Database.php
$teacher = $db->getOneTeacher($idTeacher);

// Appeler la fonction dans le fichier Database.php
$section = $db->getOneSection($teacher["fkSection"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/style.css" rel="stylesheet">
    <title>Version statique de l'application des surnoms</title>
</head>

<body>

    <?php include("./parts/header.inc.php") ?>

    <div class="container">
        <div class="user-head">
            <h3>Détail : <?php echo $teacher["teaFirstname"] . " " . $teacher["teaName"] ?>
                <!-- Ajouter les IF correspondants pour affichage de genre depuis DB-->
                <?php
                if ($teacher["teaGender"] === "M") {
                ?>
                    <img style="margin-left: 1vw;" height="20em" src="./img/male.png" alt="male symbole">
                <?php
                }
                ?>
                <?php
                if ($teacher["teaGender"] === "F") {
                ?>
                    <img style="margin-left: 1vw;" height="20em" src="./img/femelle.png" alt="femelle symbole">
                <?php
                }
                ?>
                <?php
                if ($teacher["teaGender"] === "A") {
                ?>
                    <img style="margin-left: 1vw;" height="20em" src="./img/autre.png" alt="autre symbole">
                <?php
                }
                ?>
            </h3>
            <p>
                <?= $section["secName"] ?>
            </p>
            <div class="actions">

                <a href="./editTeacher.php">
                    <img height="20em" src="./img/edit.png" alt="edit icon"></a>

                <?php

                $html = "<a onClick='return confirm(\"Êtes-vous sûr de vouloir supprimer l enseignant?\");' href=\"./deleteTeacher.php?idTeacher=" . $teacher["idTeacher"] . "\">";
                $html .= "<img height=\"20em\" src=\"./img/delete.png\" alt=\"delete\">";
                $html .= "</a>";

                echo $html;

                ?>

            </div>
        </div>
        <div class="user-body">
            <div class="left">
                <p>Surnom : <?php echo $teacher["teaNickname"]  ?></p>
                <p><?php echo $teacher["teaOrigine"]  ?></p>
            </div>
        </div>
        <div class="user-footer">
            <a href="index.php">Retour à la page d'accueil</a>
        </div>

    </div>

    <?php include("./parts/footer.inc.php") ?>

    <script src="js/script.js"></script>

</body>

</html>