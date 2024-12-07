<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 30.09.2024
Description   : Permet de mettre à jour un enseignant
*/

// Ajouter la page Datebase.php
include("Database.php");

// Permet de récupérer id de l'enseignant
$idTeacher = $_GET["idTeacher"];

// Connection de base de données
$db = new Database();

// Appeler la fonction dans le fichier Database.php pour récupérer un id de l'enseignant
$teacher = $db->getOneTeacher($idTeacher);

// Appeler la fonction dans le fichier Database.php pour récupérer une section
$sectionOfTeacher = $db->getOneSection($teacher["fkSection"]);

// Appeler la fonction dans le fichier Database.php pour récupérer toutes les sections
$sections = $db->getAllSection();
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

    <?php
    // Ajouter de la tête 
    include("./parts/header.inc.php")
    ?>

    <div class="container">
        <div class="user-body">
            <form action="checkUpdateTeacher.php" method="post" id="form">
                <h3>Edit d'un enseignant</h3>
                <p>
                    <input type="hidden" name="idTeacher" value="<?= $teacher["idTeacher"] ?>">
                    <?php
                    if ($teacher["teaGender"] === "M") {
                    ?>
                        <input type="radio" id="genre1" name="genre" value="M" checked>
                        <label for="genre1">Homme</label>
                        <input type="radio" id="genre2" name="genre" value="F">
                        <label for="genre2">Femme</label>
                        <input type="radio" id="genre3" name="genre" value="A">
                        <label for="genre3">Autre</label>
                    <?php
                    }
                    ?>
                    <?php
                    if ($teacher["teaGender"] === "F") {
                    ?>
                        <input type="radio" id="genre1" name="genre" value="M">
                        <label for="genre1">Homme</label>
                        <input type="radio" id="genre2" name="genre" value="F" checked>
                        <label for="genre2">Femme</label>
                        <input type="radio" id="genre3" name="genre" value="A">
                        <label for="genre3">Autre</label>
                    <?php
                    }
                    ?>
                    <?php
                    if ($teacher["teaGender"] === "A") {
                    ?>
                        <input type="radio" id="genre1" name="genre" value="M">
                        <label for="genre1">Homme</label>
                        <input type="radio" id="genre2" name="genre" value="F">
                        <label for="genre2">Femme</label>
                        <input type="radio" id="genre3" name="genre" value="A" checked>
                        <label for="genre3">Autre</label>
                    <?php
                    }
                    ?>
                </p>
                <p>
                    <label for="firstName">Nom :</label>
                    <input type="text" name="firstName" id="firstName" value="<?php echo $teacher["teaFirstname"] ?>">
                </p>
                <p>
                    <label for="name">Prénom :</label>
                    <input type="text" name="name" id="name" value="<?php echo $teacher["teaName"] ?>">
                </p>
                <p>
                    <label for="nickName">Surnom :</label>
                    <input type="text" name="nickName" id="nickName" value="<?php echo $teacher["teaNickname"] ?>">
                </p>
                <p>
                    <label for="origin">Origine :</label>
                    <textarea name="origin" id="origin"><?php echo $teacher["teaOrigine"] ?></textarea>
                </p>
                <p>
                    <label style="display: none" for="section"></label>
                    <select name="section" id="section">
                        <option value="">Section</option>
                        <?php
                        foreach ($sections as $section) { ?>
                            <option value="<?= $section['idSection'] ?>" <?php if ($sectionOfTeacher["idSection"] == $section["idSection"]) {
                                                                                echo "selected";
                                                                            } ?>><?php echo $section['secName'] ?></option>
                        <?php }
                        ?>
                    </select>
                </p>
                <p>
                    <input type="submit" value="Ajouter">
                    <button type="button" onclick="document.getElementById('form').reset();">Effacer</button>
                </p>
            </form>
        </div>
        <div class="user-footer">
            <a href="index.php">Retour à la page d'accueil</a>
        </div>
    </div>

    <?php
    // Ajouter de la pied
    include("./parts/footer.inc.php")
    ?>

</body>

</html>