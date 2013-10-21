<?php
require_once('../config.inc');
require_once('../models.php');

$tech_id = $_POST['tech_id'];
$name = $_POST['name'];
$url = $_POST['url'];

create_link($name, $url, $tech_id);

$uri = "subject.php?id=$tech_id";
header("Location: $uri", TRUE, 302);
