<?php

namespace Src\App\Models;

use Src\App\Models\Model;

class FileComposerModel extends Model{

    public function getUserTables(): array{
        $stmt = $this->db->getUserPDO()->query("SHOW TABLES");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function getUserColumns(string $tableName): array{
        $stmt = $this->db->getUserPDO()->prepare("SHOW COLUMNS FROM `$tableName`");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function createLink(array $data){
        $stmt = $this->db->getPDO()->prepare("INSERT INTO dir_linked (dir_name, table_name) VALUES (:dir_name, :table_name)");
        $stmt->execute([
            ':dir_name' => $data['dir_name'],
            ':table_name' => $data['table_name']
        ]);
        $dirLinkedId = $this->db->getPDO()->lastInsertId();

        $stmtCol = $this->db->getPDO()->prepare("INSERT INTO dir_linked_columns (dir_linked_id, column_name) VALUES (:dir_linked_id, :column_name)");
        foreach ($data['columns'] as $col) {
            $stmtCol->execute([
                ':dir_linked_id' => $dirLinkedId,
                ':column_name' => $col
            ]);
        }
    }
    public function getAllLinks(): array{
        $stmt = $this->db->getPDO()->query("
            SELECT 
                dir_linked.id,
                dir_linked.dir_name,
                dir_linked.table_name,
                GROUP_CONCAT(dir_linked_columns.column_name SEPARATOR ', ') AS columns
            FROM dir_linked
            LEFT JOIN dir_linked_columns 
                ON dir_linked.id = dir_linked_columns.dir_linked_id
            GROUP BY dir_linked.id
        ");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function deleteLink(string $id){
        $stmt = $this->db->getPDO()->prepare("DELETE FROM dir_linked WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
    public function getLinkById(string $id): array{
        $stmt = $this->db->getPDO()->prepare(" SELECT 
                dir_linked.id,
                dir_linked.dir_name,
                dir_linked.table_name,
                GROUP_CONCAT(dir_linked_columns.column_name SEPARATOR ', ') AS columns
            FROM dir_linked
            LEFT JOIN dir_linked_columns 
                ON dir_linked.id = dir_linked_columns.dir_linked_id
            GROUP BY dir_linked.id HAVING dir_linked.id = :id");
        $stmt->execute([':id' => $id]);
        $link = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $link;
    }
}