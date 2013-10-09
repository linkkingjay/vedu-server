<?php

require_once('config.inc');
require_once('models.php');

$techs = array();
foreach (get_techs() as $tech) {
    $tech['links'] = array_map(function($record) {
        return $record['link_id'];
    }, get_tech_links($tech['tech_id']));

    $tech['then'] = array_map(function($record) {
        return $record['then_id'];
    }, get_tech_thens($tech['tech_id']));

    $techs[] = $tech;
}

header('Content-Type: text/json');
echo json_encode($techs);
