<?php
include ("./Database.php");
$db = new Database();

// TODO : Validation des saisies utilisateur

$db->addTeacher($_POST);

header("Location: ./index.php");
exit;
