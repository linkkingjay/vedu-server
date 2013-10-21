<?php

require_once('../config.inc');
require_once('../models.php');
require_once('../templates.php');

$id = $_GET['id'];
$tech = get_tech_by_id($id);
if ($tech != NULL) {
    $tech['links'] = get_tech_links($tech['tech_id']);
    $tech['thens'] = get_tech_thens($tech['tech_id']);

    echo $templates->render('techs/subject.html', $tech);
} else {
    echo "404";
}
