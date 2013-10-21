<?php
require_once('../config.inc');
require_once('../models.php');

$tech_id = $_GET['id'];

remove_tech($tech_id);

$uri = $_SERVER['HTTP_REFERER'];
header("Location: $uri", TRUE, 302);
