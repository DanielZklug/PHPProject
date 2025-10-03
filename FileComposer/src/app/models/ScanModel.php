<?php

namespace Src\App\Models;

use Src\App\Models\Model;

class ScanModel extends Model{
    public function scan(array $columns, string $tableName){
        $query = "SELECT " . implode(',', $columns) . " FROM `$tableName`";
        $stmt = $this->db->getUserPDO()->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}