<?php
/**
 * Author: Fredrik Enestad @ Devloop AB (fredrik@devloop.se)
 * Date: 2012-06-20
 */
require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set("Europe/Stockholm");

$app = new Silex\Application();

$app["debug"] = true;

// setup twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// setup doctrine
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        "driver" 			=> "pdo_mysql",
        "user"				=> "aUser",
        "password" 			=> "aPassword",
        "dbname"			=> "db_programs",
        "host"				=> "localhost",
        "driverOptions" 	=> array(1002 => "SET NAMES utf8 COLLATE utf8_swedish_ci")
    ),
));

return $app;