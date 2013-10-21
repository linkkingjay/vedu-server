<?php
require_once('../config.inc');
require_once('../models.php');

$tech_id = $_POST['tech_id'];
$name = $_POST['name'];

$then = get_tech_by_name($name);

if ($then != null) {
    create_tech_then($tech_id, $then['tech_id']);
    $uri = $_SERVER['HTTP_REFERER'];
    header("Location: $uri", TRUE, 302);
} else {
    echo "error";
}

