<?php
/**
 * Author: Fredrik Enestad @ Devloop AB (fredrik@devloop.se)
 * Date: 2012-06-19
 *
 * This file contains the HTTP routes.
 *
 */

require_once __DIR__."/controllers/ProgramController.php";

/**
 * Silex instance
 */
$app = require __DIR__ . "/bootstrap.php";


/**
 * GET '/'
 * Displays the program input form
 */
$app->get('/', function() use ($app) {
    $controller = new ProgramController($app);
    return $controller->Index();
});

/**
 * GET '/programs.{format}/{page}/{size}'
 * format = html|xml
 * page = page number
 * size = number of entries per page
 * Displays a list of programs as html or xml
 */
$app->get('/programs.{format}/{page}/{size}', function($format, $page, $size) use($app) {

    $controller = new ProgramController($app);
    return $controller->Programs($format, $page, $size);

})->value("format", "html")->value("page", "1")->value("size", "10");

/**
 * POST '/program'
 * Adds a program to the DB
 */
$app->post('/program', function() use($app) {
    $controller = new ProgramController($app);
    return $controller->AddProgram();
});


/**
 * GET '/delete-program/program-id'
 * Deletes a program from the DB
 * GET request is used instead of DELETE since not all web browsers support other than GET/POST
 */
$app->get('/delete-program/{id}', function($id) use($app) {
    $controller = new ProgramController($app);
    return $controller->DeleteProgram($id);
});



$app->run();

