<?php
include("./Database.php");
$db = new Database();

$db->updateTeacher($_POST);