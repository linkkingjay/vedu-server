<?php 
require_once('../config.inc');
require_once('../models.php');

$link_id = $_GET['link_id'];

remove_link($link_id);

$uri = $_SERVER['HTTP_REFERER'];
header("Location: $uri", TRUE, 302);
