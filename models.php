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
 * get a tech term by name
 *
 * @param $name tech term's name
 * @return array if it was found otherwise NULL
 */
function get_tech_by_name($name) {
    $conn = get_connection();

    $query = $conn->prepare('SELECT * FROM Tech WHERE name = :name');
    $query->bindValue(':name', $name);
    $result = $query->execute()->fetchArray(SQLITE3_ASSOC);
    $conn->close();
    return $result;
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
    return create_record('Tech', array(
        'name' => $name,
        'description' => $description,
        'home' => $homepage
    ), 'tech_id');
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

/**
 * remove a tech term
 *
 * @param $id tech's id
 * @return NULL
 */
function remove_tech($id) {
    // Step 1. remove relationship
    $conn = get_connection();

    $remove = $conn->prepare('DELETE FROM Links WHERE tech_id = :id');
    $remove->bindValue(':id', $id);
    $remove->execute();
    $remove = $conn->prepare('DELETE FROM Tech_then ' .
        'WHERE tech_id = :id OR then_id = :id');
    $remove->bindValue(':id', $id);
    $remove->execute();

    $conn->close();

    // Step 2. remove records
    return remove_record('Tech', 'tech_id', $id);
}

/**
 * get all relative tech terms
 *
 * TODO too many sql executions
 *
 * @param $id tech's id
 * @return records array
 */
function get_tech_thens($id) {
    $conn = get_connection();

    $query = $conn->prepare('SELECT * FROM Tech_then WHERE tech_id = :id');
    $query->bindValue(':id', $id);
    $results = $query->execute();

    $thens = array();
    while ($result = $results->fetchArray()) {
        $thens[] = get_tech_by_id($result['then_id']);
    }

    $conn->close();

    return $thens;
}

/**
 * get tech's links
 *
 * @param $id tech's id
 * @return link records array
 */
function get_tech_links($id) {
    $conn = get_connection();

    $query = $conn->prepare('SELECT * FROM Links WHERE tech_id = :id');
    $query->bindValue(':id', $id);
    $results = $query->execute();

    $links = array();
    while ($result = $results->fetchArray()) {
        $links[] = $result;
    }

    $conn->close();

    return $links;
}

/**
 * add a relationship for two tech terms
 *
 * @param $from parent tech's id
 * @param $to child tech's id
 * @return NULL
 * */
function create_tech_then($from, $to) {
    if ($from == $to) {
        return false;
    }

    $conn = get_connection();

    // SQLite3不能设置双主键，在插入前检查是否有这个关系存在，防止重复插入
    $query = $conn->prepare('SELECT * FROM Tech_then WHERE tech_id = :tech_id AND then_id = :then_id');
    $query->bindValue(':tech_id', $from);
    $query->bindValue(':then_id', $to);
    $result = $query->execute()->fetchArray();
    $conn->close();

    if ($result != null) {
        return false;
    }

    create_record('Tech_then', array(
        'tech_id' => $from,
        'then_id' => $to
    ));
}

/**
 * remove a techs relationship
 *
 * @param $from parent tech's id
 * @param $to child tech's id
 * @return NULL
 */
function remove_tech_then($from, $to) {
    $conn = get_connection();

    $remove = $conn->prepare('DELETE FROM Tech_then ' .
        'WHERE tech_id = :from AND then_id = :to');
    $remove = batch_bind_value($remove, array(
        'from' => $from,
        'to' => $to
    ));
    $remove->execute();

    $conn->close();
}

/**
 * get a link by id
 *
 * @param $id link's id
 * @return record array
 */
function get_link_by_id($id) {
    return get_record_by_id('Links', 'link_id', $id);
}

/**
 * create a link
 *
 * @param $name link's name
 * @param $url link's url
 * @param $tech_id link's tech category
 * @return new record array
 */
function create_link($name, $url, $tech_id) {
    return create_record('Links', array(
        'name' => $name,
        'url' => $url,
        'tech_id' => $tech_id
    ), 'link_id');
}

/**
 * update a link
 *
 * @param $id link's id
 * @param $values link's new values
 * @return updated record array
 */
function update_link($id, $values) {
    return update_record('Links', 'link_id', $values);
}

/**
 * remove a link
 *
 * @param $id link's id
 * @return NULL
 */
function remove_link($id) {
    return remove_record('Links', 'link_id', $id);
}
