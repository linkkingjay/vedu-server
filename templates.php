<?php if (!defined('CODENAME')) exit('No direct script access allowed');

if (!defined('VENDOR_PATH') || !defined('TMPL_PATH'))
    exit('No direct script access allowed');

require_once(VENDOR_PATH . 'autoload.php');

$loader = new Twig_Loader_Filesystem(TMPL_PATH);
$templates = new Twig_Environment($loader, array(
    'cache' => TMPL_PATH . 'cache'
));
