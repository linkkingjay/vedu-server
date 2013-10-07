<?php if (!defined('CODENAME')) exit('No direct script access allowed');

/**
 * build update sub sequence
 *
 * e.g.,
 *
 *  name = :name, title = :title
 *
 * @param $items associate array
 * @return sub sequence string
 */
function build_update_params($items) {
    $params = array();
    foreach ($items as $k => $v) {
        $params[] = $k . ' = :' . $k;
    }

    return implode($params, ',');
}

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
