<?php

require '../vendor/autoload.php';
use api\controller\settingsController;
use api\controller\playerController;
use api\controller\soundController;




$app = new Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
));

$app->contentType('text/html; charset=utf-8');
$app->rootUri = "http://90.48.35.147";


$app->get('/volume/:vol', function($vol) use ($app) {
    soundController::volume($app, $vol);
})->name('volume');



$app->get('/', function() use ($app) {
	echo "ça marche";
});


$app->get('/settings', function() use ($app) {

    settingsController::settings($app);
})->name('annoncesId');
// ?? 


$app->get('/player/:action', function($action) use ($app) {
    playerController::player($app, $action);
})->name('player');


$app->run();