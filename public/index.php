<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Quizz\Core\Controller\FastRouteCore;

// Gestion des fichiers environnement
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Couche Controller
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', 'Quizz\Controller\HomeController');
    $route->addRoute('GET', '/lister', 'Quizz\Controller\Questionnaire\ListController');
    $route->addRoute('GET', '/detail/{id:\d+}', 'Quizz\Controller\Questionnaire\ViewController');

    $route->addRoute('GET', '/helloworld', 'Quizz\Controller\Questionnaire\HelloController');
    $route->addRoute('GET', '/helloworld/{id:\w+}', 'Quizz\Controller\Questionnaire\HelloController');
    
    $route->addRoute(['GET'], '/etudiant/', 'Quizz\Controller\Etudiant\EtudiantListController');
    $route->addRoute(['GET','POST'], '/etudiant/{id:\d+}', 'Quizz\Controller\Etudiant\EtudiantController');
    $route->addRoute(['GET','POST'], '/etudiant/add', 'Quizz\Controller\Etudiant\AddController');
    $route->addRoute(['GET'], '/etudiant/{id:\d+}/del', 'Quizz\Controller\Etudiant\DeleteUserController');


});
// Dispatcher -> Couche view
echo FastRouteCore::getDispatcher($dispatcher);

