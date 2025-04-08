<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';
require __DIR__ . '/controllers/CertificazioniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id}', "AlunniController:view");
$app->get('/alunni/search/{value}', "AlunniController:search");
$app->post('/alunni', "AlunniController:create");
$app->put('/alunni/{id}', "AlunniController:update");
$app->delete('/alunni/{id}', "AlunniController:delete");

$app->get('/alunni/{id}/cert[/{id_cert}]', "CertificazioniController:index");
$app->post('/alunni/{id}/cert', "CertificazioniController:insert");

$app->run();
