<?php if (!defined('CODENAME')) exit('No direct script access allowed');

require('database.php');
require_once('utils.php');

/**
 * get a tech term by id
 *
 * @param $id tech term's id
 * @return array if it was found otherwise NULL
 */
function get_tech_by_id($id) {
    $conn = get_connection();

    $query = $conn->prepare('SELECT * FROM Tech WHERE tech_id = :id');
    $query->bindValue(':id', $id);
    $result = $query->execute();

    if ($result) {
        $result = $result->fetchArray();
    }

    $conn->close();

    return $result;
}

/**
 * get all tech terms
 *
 * @return records array
 */
function get_techs() {
    $conn = get_connection();

    $results = array();
    $query = $conn->query('SELECT * FROM Tech');

    while ($result = $query->fetchArray()) {
        $results[] = $result;
    }

    $conn->close();

    return $results;
}

/**
 * create a tech term
 *
 * @param $name tech's name
 * @param $description tech's description
 * @param $homepage tech's homepage
 * @return new record array
 */
function create_tech($name, $description, $homepage) {
    $conn = get_connection();

    $insert = $conn->prepare('INSERT INTO Tech (name, description, home) ' .
                             'VALUES (:name, :description, :home)');
    $insert = batch_bind_value($insert, array(
        'name' => $name,
        'description' => $description,
        'home' => $homepage
    ));
    $result = $insert->execute();

    $id = $conn->lastInsertRowid();
    
    $conn->close();

    return get_tech_by_id($id);
}

function update_tech($id, $values) {
    $conn = get_connection();

    $query = $conn->prepare('UPDATE Tech SET ' . build_update_params($values) .
                            ' WHERE tech_id = :id');
    $values['id'] = $id;
    $query = batch_bind_value($query, $values);
    $result = $query->execute();

    $conn->close();

    return get_tech_by_id($id);
}
