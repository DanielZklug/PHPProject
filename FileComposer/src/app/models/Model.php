<?php

namespace Src\App\Models;

use Src\Database\Database;

abstract class Model{

    public function __construct(protected Database $db){
        $this->db = $db;
    }
}