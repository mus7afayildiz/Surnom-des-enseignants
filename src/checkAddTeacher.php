<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 30.09.2024
Description   : Validation des saisies utilisateur 
*/

include ("./Database.php");
$db = new Database();

// TODO : Validation des saisies utilisateur

$db->addTeacher($_POST);

header("Location: ./index.php");
exit;
