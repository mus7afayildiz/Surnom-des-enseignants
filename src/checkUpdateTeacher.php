<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 30.09.2024
Description   : Contôler des saisies utilisateur pour mettre à jour un enseignant
*/

include ("./Database.php");
$db = new Database();

$errors =[];
if(!isset($_POST['genre'])){
    $errors[] = "il faut choisir un genre";
}

$firstNamePattern = "/^[a-zA-Z]+$/";

if (! isset($_POST['firstName']) || ! preg_match($firstNamePattern, $_POST['firstName'])){
    $errors[] = "il faut remplir le prénom";
}


if(count($errors)===0){

    $db->updateTeacher($_POST);
    header("Location: ./index.php");
    
} else {
    echo "<pre>";
    var_dump($errors);
    echo "</pre>";
}

echo "<pre>";
var_dump($_POST);
echo "</pre>";