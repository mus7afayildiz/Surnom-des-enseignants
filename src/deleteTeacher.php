<?php

include("./Database.php");

$db = new Database();

$db->deleteTeacher($_GET["idTeacher"]);

header("Location: /index.php");
exit;
