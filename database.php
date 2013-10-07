<?php if (!defined('CODENAME')) exit('No direct script access allowed');

require_once('config.inc');

/**
 * create a conn cursor
 *
 * don't forget to close after using
 *
 * @return sqlite3 connection
 */
function get_connection() {
    $connection = new SQLite3(DB_NAME) or die('cannot open database');
    return $connection;
}
