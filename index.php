<?php
/**
 * Author: Fredrik Enestad @ Devloop AB (fredrik@devloop.se)
 * Date: 2012-06-19
 *
 * This file contains the HTTP routes.
 *
 */

/**
 * Silex instance
 */
$app = require __DIR__ . "/bootstrap.php";



/**
 * GET '/'
 * Displays the program input form
 */
$app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig', array());
});


/**
 * GET '/programs'
 * Displays a list of programs as html or xml
 */
$app->get('/programs', function() use($app) {
    // TODO: list programs
    // HTML && XML
});


/**
 * POST '/program'
 * Adds a program to the DB
 */
$app->post('/program', function() use($app) {
    // TODO: add program
});


/**
 * GET '/delete-program/program-id'
 * Deletes a program from the DB
 * GET request is used instead of DELETE since not all web browsers support other than GET/POST
 */
$app->get('/delete-program/{id}', function($id) use($app) {
    // TODO: delete program
});



$app->run();

