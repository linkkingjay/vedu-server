<?php 
require_once('../config.inc');
require_once('../models.php');

$tech_id = $_POST['tech_id'];

$values = array(
    'name' => $_POST['name'],
    'homepage' => $_POST['homepage'],
    'description' => $_POST['description']
);

update_tech($tech_id, $values);

$uri = $_SERVER['HTTP_REFERER'];
header("Location: $uri", TRUE, 302);
