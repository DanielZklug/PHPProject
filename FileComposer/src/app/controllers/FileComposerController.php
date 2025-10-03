<?php

namespace Src\App\Controllers;

use Src\App\Models\FileComposerModel;

class FileComposerController extends Controller
{
    public function homePage()
    {
        // Récupérer les dossiers dans uploads
        $baseDir = __DIR__ . '/../../../uploads';
        $folders = [];
        if (is_dir($baseDir)) {
            foreach (scandir($baseDir) as $item) {
                if ($item === '.' || $item === '..') continue;
                if (is_dir($baseDir . '/' . $item)) {
                    $folders[] = $item;
                }
            }
        }
        $dirs_linked = (new FileComposerModel($this->getDB()))->getAllLinks();

        $tables = (new FileComposerModel($this->getDB()))->getUserTables();

        return $this->view('pages.home',compact('folders','tables','dirs_linked'));
    }
    public function getColumns(string $tableName){
        $model = new FileComposerModel($this->getDB());
        $columns = $model->getUserColumns($tableName);
        header('Content-Type: application/json');
        echo json_encode($columns);
    }
    public function createLink(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           try {
                $dirName = $_POST['dir_name'] ?? null;
                $tableName = $_POST['table_name'] ?? null;
                $columns = $_POST['columns'] ?? [];

                if (!$dirName || !$tableName || empty($columns)) {
                    $_SESSION['error'] = "Veuillez remplir tous les champs.";
                    header("Location: /fileComposer");
                    exit;
                }
                (new FileComposerModel($this->getDB()))->createLink([
                    'dir_name' => $dirName,
                    'table_name' => $tableName,
                    'columns' => $columns
                ]);
                $_SESSION['success'] = "Lien créé avec succès !";
                header("Location: /fileComposer");
                exit;
           } catch (\Throwable $th) {
                $_SESSION['error'] = "Erreur lors de la création du lien : " . $th->getMessage();
                header("Location: /fileComposer");
                exit;
           }
        }
    }
    public function deleteLink(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id = $_POST['dir_linked_id'] ?? null;
                if (!$id) {
                    $_SESSION['error'] = "ID manquant pour la suppression.";
                    header("Location: /fileComposer");
                    exit;
                }
                (new FileComposerModel($this->getDB()))->deleteLink($id);
                $_SESSION['success'] = "Lien supprimé avec succès.";
                header("Location: /fileComposer");
                exit;
            } catch (\Throwable $th) {
                $_SESSION['error'] = "Erreur lors de la suppression du lien : " . $th->getMessage();
                header("Location: /fileComposer");
                exit;
            }
        }
    }
    public function scan(string $id){
        try {
            $id = $id ?? null;
            if (!$id) {
                $_SESSION['error'] = "ID manquant pour le scan.";
                header("Location: /filecomposer");
                exit;
            }
            $dirs = (new FileComposerModel($this->getDB()))->getLinkById($id);
            (new ScanController($this->getDB()))->homePage($dirs);
        } catch (\Throwable $th) {
            $_SESSION['error'] = "Erreur lors du scan : " . $th->getMessage();
            header("Location: /filecomposer");
            exit;
        }
    }
}
