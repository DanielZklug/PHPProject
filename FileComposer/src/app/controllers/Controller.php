<?php

namespace Src\App\Controllers;

use Src\Database\Database;

class Controller{

    public function __construct(
        protected ?Database $db = null
    ){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
    }

    public static function view(string $path, ?array $params = null){
        ob_start();
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        require VIEWS.$path.'.php';
        if ($params) {
            $params = extract($params);
        }
        $content = ob_get_clean();
        require VIEWS.'templates/layout.php';
    }

    protected function getDB(){
        return $this->db;
    }

    public static function error404(string $error){
        header("HTTP/1.1 404 Not Found");
        return self::view('errors.404', compact('error'));
    }
}