<?php if (!defined('CODENAME')) exit('No direct script access allowed');

// check for DB settings
if (!defined('DB_NAME')) exit('No direct script access allowed');

/**
 * bind value to prepared sql query batchly
 *
 * @param $prepare prepared sql query
 * @param $items associate array
 * @return value binded sql query
 */
function batch_bind_value($prepare, $items) {
    foreach ($items as $k => $v) {
        $prepare->bindValue(':' . $k, $v);
    }

    return $prepare;
}

/**
 * remove sql record array's integer index
 *
 * @param $array raw sql record array
 * @return record array
 */
function clean_fetch_record($array) {
    $cleaned = array();
    foreach ($array as $k => $v) {
        if (is_string($k)) {
            $cleaned[$k] = $v;
        }
    }
    return $cleaned;
}

/**
 * create a conn cursor
 *
 * XXX don't forget to close after using
 *
 * @return sqlite3 connection
 */
function get_connection() {
    $connection = new SQLite3(DB_NAME) or die('cannot open database');
    return $connection;
}

/**
 * get record from database
 *
 * @param $table table name
 * @param $primary_key table primary key's name
 * @param $id record's id
 * @return array if it was found otherwise NULL
 */
function get_record_by_id($table, $primary_key, $id) {
    $conn = get_connection();

    $query = $conn->prepare(
        'SELECT * FROM ' . $table . ' WHERE ' . $primary_key . ' = :id');
    $query->bindValue(':id', $id);
    $result = $query->execute();

    if ($result) {
        $result = clean_fetch_record($result->fetchArray());
    }

    $conn->close();

    return $result;
}

/**
 * get all records from database
 *
 * @param $table table name
 * @return records array
 */
function get_all_records($table) {
    $conn = get_connection();

    $results = array();
    $query = $conn->query('SELECT * FROM ' . $table);

    while ($result = $query->fetchArray()) {
        $results[] = clean_fetch_record($result);
    }

    $conn->close();

    return $results;
}

/**
 * create a record
 *
 * @param $table table name
 * @param $values new record's value
 * @param $primary_key table's primary key
 * @return new record array if $primary_key is provided
 */
function create_record($table, $values, $primary_key=null) {
    $conn = get_connection();

    $k1 = array();
    $k2 = array();
    foreach ($values as $k => $v) {
        $k1[] = $k;
        $k2[] = ':' . $k;
    }
    $insert = $conn->prepare('INSERT INTO ' . $table .
        '(' . implode($k1, ',') . ') VALUES' .
        '(' . implode($k2, ',') . ')' );
    $insert = batch_bind_value($insert, $values);
    $result = $insert->execute();

    if ($primary_key) {
        $id = $conn->lastInsertRowid();
    }

    $conn->close();

    if ($primary_key) {
        return get_record_by_id($table, $primary_key, $id);
    }

    return null;
}

/**
 * update a record
 *
 * @param $table table name
 * @param $primary_key table primary key's name
 * @param $id record's id
 * @param $values values to be updated
 * @return record array
 */
function update_record($table, $primary_key, $id, $values) {
    $conn = get_connection();

    $params = array();
    foreach ($values as $k => $v) {
        $params[] = $k . ' = :' . $k;
    }

    $query = $conn->prepare('UPDATE ' . $table .
        ' SET ' . implode($params, ',') .
        ' WHERE ' . $primary_key . ' = :id');
    $values['id'] = $id;
    $query = batch_bind_value($query, $values);

    $result = $query->execute();

    $conn->close();

    return get_record_by_id($table, $primary_key, $id);
}

/**
 * remove a record
 *
 * @param $table table name
 * @param $primary_key table's primary key's name
 * @param $id record's id
 * @return null
 */
function remove_record($table, $primary_key, $id) {
    $conn = get_connection();

    $remove = $conn->prepare('DELETE FROM ' . $table .
        ' WHERE ' . $primary_key . ' = :id');
    $remove->bindValue(':id', $id);
    $remove->execute();

    $conn->close();
}
