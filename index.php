<?php

require_once('config.inc');
require_once('models.php');
require_once('templates.php');

echo $templates->render('index.html', array('name' => 'world'));
