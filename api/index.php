<?php

require '../vendor/autoload.php';
use api\controller\settingsController;
use api\controller\playerController;
use api\controller\playlistController;
use api\controller\soundController;

$app = new Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
));
$app->contentType('text/html; charset=utf-8');
$config = parse_ini_file('config.ini');

if($config){
    $app->rootUri = 'http://'.$config['ip'];

    $app->get('/', function() use ($app, $config) {
        echo "ça marche";
    });

    $app->get('/settings', function() use ($app) {
        settingsController::settings($app);
    })->name('annoncesId');

    $app->get('/player/:action', function($action) use ($app) {
        playerController::player($app, $action);
    })->name('player');

    $app->get('/playlist/:action', function($action) use ($app) {
        playlistController::playlist($app, $action);
    })->name('playlist');

    $app->get('/volume/:vol', function($vol) use ($app) {
        soundController::volume($app, $vol);
    })->name('volume');

    $app->run();
}