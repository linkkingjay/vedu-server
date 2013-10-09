<?php

$base_name = pathinfo(__FILE__, PATHINFO_BASENAME);
define('BASEPATH', str_replace('/' . $base_name, '/', __FILE__));
define('DB_NAME', realpath(BASEPATH . 'edu.db'));

define('CODENAME', 'vedu');
