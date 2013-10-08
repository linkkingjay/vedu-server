<?php if (!defined('CODENAME')) exit('No direct script access allowed');

require('database.php');

/**
 * get a tech term by id
 *
 * @param $id tech term's id
 * @return array if it was found otherwise NULL
 */
function get_tech_by_id($id) {
    return get_record_by_id('Tech', 'tech_id', $id);
}

/**
 * get all tech terms
 *
 * @return records array
 */
function get_techs() {
    return get_all_records('Tech');
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
    return create_record('Tech', 'tech_id', array(
        'name' => $name,
        'description' => $description,
        'home' => $homepage
    ));
}

/**
 * update a tech term
 *
 * @param $id tech's id
 * @param $values tech's new values
 * @return updated record array
 */
function update_tech($id, $values) {
    return update_record('Tech', 'tech_id', $id, $values);
}
