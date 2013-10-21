<?php
require_once('../config.inc');
require_once('../models.php');

$tech_id = $_GET['tech_id'];
$then_id = $_GET['then_id'];

remove_tech_then($tech_id, $then_id);

$uri = $_SERVER['HTTP_REFERER'];
header("Location: $uri", TRUE, 302);
