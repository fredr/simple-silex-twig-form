<?php
/**
 * Author: Fredrik Enestad @ Devloop AB (fredrik@devloop.se)
 * Date: 2012-06-19
 * Time: 19:16
 */

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
