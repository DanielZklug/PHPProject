<?php

namespace Src\App\Controllers;

use Src\App\Models\ScanModel;
use Src\App\Exceptions\NotFoundException;

class ScanController extends Controller{
    public function homePage(array $dirs){
        if (empty($dirs)) {
            throw new NotFoundException();
        }
        $filesInFS = [];
        $basePath = __DIR__ . '/../../../uploads/' . $dirs['dir_name'];

        if (is_dir($basePath)) {
            foreach (scandir($basePath) as $file) {
                if ($file === '.' || $file === '..') continue;
                $fullPath = $basePath . '/' . $file;
                if (is_file($fullPath)) {
                    $filesInFS[$file] = [
                        'name' => $file,
                        'size' => filesize($fullPath),           // taille en octets
                        'created_at' => date("Y-m-d H:i:s", filemtime($fullPath)) // date de modification
                    ];
                }
            }
        }
        $columns = explode(',',$dirs['columns']); // récupérées depuis dir_linked_columns
        $tableName = $dirs['table_name'];

        $placeholders = implode(',', $columns);

        $rows =  (new ScanModel($this->getDB()))->scan($columns,$tableName);
        // On a besoin d’un tableau simple avec tous les fichiers référencés
        $filesInDB = [];
        foreach ($rows as $row) {
            foreach ($columns as $col) {
                if (!empty($row[$col])) {
                    $filesInDB[] = $row[$col];
                }
            }
        }
        $referenced = [];
        $orphans = [];

        foreach ($filesInFS as $fileName => $info) {
            if (in_array($fileName, $filesInDB)) {
                $referenced[] = $info;
            } else {
                $orphans[] = $info;
            }
        }
        return $this->view('pages.scan',compact('dirs','referenced','orphans'));
    }
    public function deleteFile(){
        $dir = $_POST['dir'] ?? null;
        $dir_id = $_POST['dir_id'] ?? null;
        $file = $_POST['file'] ?? null;
        $path = __DIR__ . '/../../../uploads/' . $dir . '/' . $file;

        if ($dir && $file && file_exists($path)) {
            unlink($path);
            $_SESSION['success'] = "Fichier supprimé avec succès !";
        } else {
            $_SESSION['error'] = "Impossible de supprimer le fichier.";
        }

        header("Location: /filecomposer/scan/results/$dir_id?");
        exit;
    }

}