<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();


$app->get('/', function() {
    // TODO: show form to input new program
});

$app->get('/programs', function() {
    // TODO: list programs
    // HTML && XML
});

$app->post('/program', function() {
    // TODO: add program
});

$app->delete('/program', function() {
    // TODO: delete program
});



$app->run();
