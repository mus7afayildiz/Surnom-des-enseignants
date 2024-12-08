<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 30.09.2024
Description   : Ajouter un enseignant avec genre, nom, prénom, surnom, origin, section.
*/

// Ajouter la page Datebase.php
include("./Database.php");

// Connection de la base de données
$db = new Database();

// Appeler la fonction dans le fichier Database.php
$sections = $db->getAllSection();

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
        <div class="user-body">
            <form action="./checkAddTeacher.php" method="post" id="form">
                <h3>Ajout d'un enseignant</h3>
                <p>
                    <input type="radio" id="genre1" name="genre" value="M" checked>
                    <label for="genre1">Homme</label>
                    <input type="radio" id="genre2" name="genre" value="F">
                    <label for="genre2">Femme</label>
                    <input type="radio" id="genre3" name="genre" value="A">
                    <label for="genre3">Autre</label>
                </p>
                <p>
                    <label for="firstName">Nom :</label>
                    <input type="text" name="firstName" id="firstName" value="">
                </p>
                <p>
                    <label for="name">Prénom :</label>
                    <input type="text" name="name" id="name" value="">
                </p>
                <p>
                    <label for="nickName">Surnom :</label>
                    <input type="text" name="nickName" id="nickName" value="">
                </p>
                <p>
                    <label for="origin">Origine :</label>
                    <textarea name="origin" id="origin"></textarea>
                </p>
                <p>
                    <label style="display: none" for="section"></label>
                    <select name="section" id="section">
                        <option value="">Section</option>
                        <?php
                        // Afficher les section dynamiquement depuis la base de données
                        foreach ($sections as $section) { ?>
                            <option value="<?= $section['idSection'] ?>"><?php echo $section['secName'] ?></option>
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