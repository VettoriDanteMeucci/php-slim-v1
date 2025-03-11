<?php
use Slim\Factory\AppFactory;
use 

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");
$app->get('/alunni', "AlunniController:view");

$app->run();
