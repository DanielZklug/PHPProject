<?php

namespace Src\Router;

use Src\Database\Database;

class Route{
    private array $matches;

    public function __construct(private string $path, private string $action){
        $this->path = $path;
        $this->action = $action;
    }

    public function matches(string $url): bool{
        $path = preg_replace(pattern: '#:([\w]+)#', replacement: '([^/]+)', subject: $this->path);
        $pathToMatch = "#^$path$#";

        if (preg_match(pattern: $pathToMatch, subject: $url, matches: $matches)){
           $this->matches = $matches;
           return true;
        }
        return false;
    }

    public function execute(): void{
        $params = explode('@', $this->action);
        $controller = new $params[0](new Database('filecomposer','127.0.0.1','root',''));
        $method = $params[1];

        isset($this->matches[1]) ? $controller->$method($this->matches[1]) : $controller->$method();
    }
}