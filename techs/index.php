<?php

require_once('../config.inc');
require_once('../models.php');
require_once('../templates.php');

$techs = array();
foreach (get_techs() as $tech) {
    $tech['links'] = array_map(function($record) {
        return $record['name'];
    }, get_tech_links($tech['tech_id']));

    $tech['then'] = array_map(function($record) {
        return $record['name'];
    }, get_tech_thens($tech['tech_id']));

    $techs[] = $tech;
}

echo $templates->render('techs/index.html', array('techs' => $techs));
