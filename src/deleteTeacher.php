<?php
/*
ETML
Auteur        : Mustafa Yildiz
Date          : 30.09.2024
Description   : Supprimer un enseignant
*/

include("./Database.php");

$db = new Database();

$db->deleteTeacher($_GET["idTeacher"]);

header("Location: /index.php");
exit;
