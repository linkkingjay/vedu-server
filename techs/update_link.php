<?php
require_once('../config.inc');
require_once('../models.php');

$link_id = $_POST['tech_id'];

$values = array(
    'name' => $_POST['name'],
    'url' => $_POST['url']
);

update_link($link_id, $values);

$uri = $_SERVER['HTTP_REFERER'];
header("Location: $uri", TRUE, 302);
