<?php
require_once('../config.inc');
require_once('../models.php');
require_once('../templates.php');

$name = $_POST['name'];
$homepage = $_POST['home'];
$description = $_POST['description'];

$id = create_tech($name, $description, $homepage);

header('Content-Type: text/json');
if ($id != null) {
    echo json_encode(array(true, $id));
} else {
    echo json_encode(false);
}
