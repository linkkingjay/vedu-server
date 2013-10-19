<?php

define('CODENAME', 'vedu-testing');
define('DB_NAME', realpath('./test.db'));
define('SCHEMA', realpath('./schema.sql'));

require_once('models.php');

function init() {
    // init database
    $schema = file_get_contents(SCHEMA);
    $conn = get_connection();
    $conn->exec($schema);
    $conn->close();
}

function clean() {
    unlink(DB_NAME);
}

function test_get_tech_by_id() {
    $result = get_tech_by_id(1);
    assert($result['name'] === 'foobar', 'get name');
    assert($result['description'] === '123', 'get description');
    assert($result['home'] === '456', 'get home');
}

function test_get_techs() {

}

function test_create_tech() {
    $result = create_tech('foobar', '123', '456');
    assert($result['name'] === 'foobar', 'create name');
    assert($result['description'] === '123', 'create description');
    assert($result['home'] === '456', 'create home');
}

function test_update_tech() {

}

function _main() {
    init();

    test_create_tech();
    test_get_tech_by_id();
    test_update_tech();
    test_get_techs();

    //clean();
}

_main();
