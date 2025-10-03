<?php
declare(strict_types=1);

namespace Src\Router;

use Src\Router\Route;
use Src\App\Exceptions\NotFoundException;

class Router{
    private string $url;
    private $routes = [];

    public function __construct(string $url){
        $this->url = $url;
    }

    public function get(string $path, string $action){
        $this->routes['GET'][] = new Route($path, $action);
    }

    public function post(string $path, string $action){
        $this->routes['POST'][] = new Route($path, $action);
    }

    public function run(){
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches($this->url)) {
                return $route->execute();
            }
        }

        throw new NotFoundException("page");
    }
}
