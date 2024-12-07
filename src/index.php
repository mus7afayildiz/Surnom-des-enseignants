<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 30.09.2024
Description   : Page d'accueil permet de afficher les enseignants
*/

// Ajouter la page Database.php
include("./Database.php");

// Connection de base de données
$db = new Database();

// Appeler la fonction dans le fichier Database.php pour récupérer tous les enseignants
$teachers = $db->getAllTeachers();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/style.css" rel="stylesheet">
    <title>Application des surnoms des enseignants</title>
</head>

<body>

    <?php 
    // Ajouter de la tête 
    include("./parts/header.inc.php") 
    ?>

    <div class="container">
        <h3>Liste des enseignants</h3>
        <form action="#" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Surnom</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // foreach pour parcourir tous les enseignants                
                    $html = "";
                    foreach ($teachers as $teacher) {
                        $html .= "<tr>";
                        $html .= "<td>" . $teacher["teaFirstname"] . " " . $teacher["teaName"] . "</td>";
                        $html .= "<td>" . $teacher["teaNickname"] . "</td>";

                        $html .= "<td class=\"containerOptions\">";

                        $html .= "<a href=\"./updateTeacher.php?idTeacher=" . $teacher["idTeacher"] . "\">";
                        $html .= "<img height=\"20em\" src=\"./img/edit.png\" alt=\"edit\">";
                        $html .= "</a>";

                        $html .= "<a onClick='return confirm(\"Êtes-vous sûr de vouloir supprimer l enseignant?\");' href=\"./deleteTeacher.php?idTeacher=" . $teacher["idTeacher"] . "\">";
                        $html .= "<img height=\"20em\" src=\"./img/delete.png\" alt=\"delete\">";
                        $html .= "</a>";

                        $html .= "<a href='./detailTeacher.php?idTeacher=" . $teacher["idTeacher"] . "'>";

                        $html .= "<img height=\"20em\" src=\"./img/detail.png\" alt=\"detail\">";
                        $html .= "</a>";

                        $html .= "</td>";
                        $html .= "</tr>";
                    }

                    echo $html;
                    ?>

                </tbody>
            </table>
        </form>
        <script src="js/script.js"></script>
    </div>

    <?php 
    // Ajouter de la pied
    include("./parts/footer.inc.php") 
    ?>

</body>

</html>