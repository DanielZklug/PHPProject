<?php

use Src\App\Exceptions\NotFoundException;
use Src\Router\Router;

require '../../vendor/autoload.php';

define('VIEWS',dirname(__DIR__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']).DIRECTORY_SEPARATOR);

$router = new Router($_GET['url']);

$router->get('', 'Src\App\Controllers\FileComposerController@homePage');
$router->get('get-columns/:id', 'Src\App\Controllers\FileComposerController@getColumns');
$router->get('scan/results/:id', 'Src\App\Controllers\FileComposerController@scan');
$router->post('scan/delete-file', 'Src\App\Controllers\ScanController@deleteFile');
$router->post('create-link', 'Src\App\Controllers\FileComposerController@createLink');
$router->post('delete-link', 'Src\App\Controllers\FileComposerController@deleteLink');

try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404($e->getMessage());
}