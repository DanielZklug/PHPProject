<?php
    if (isset($_POST['dir']) && isset($_POST['file'])) {
        $dir = $_POST['dir'] ?? null;
        $file = $_POST['file'] ?? null;
        $path = __DIR__ . '/../../../uploads/' . $dir . '/' . $file;

        if ($dir && $file && file_exists($path)) {
            unlink($path);
            $_SESSION['success'] = "Fichier supprimé avec succès !";
        } else {
            $_SESSION['error'] = "Impossible de supprimer le fichier.";
        }
    }
?>
<div class="container mt-4">
    <div class="mb-3">
            <a href="/filecomposer" class="btn btn-secondary">
            ⬅️ Retour au tableau de bord
            </a>
    </div>
    <h2 class="mb-4">📊 Résultat du scan - <?=$params['dirs']['dir_name']?></h2>

    <!-- Info -->
    <div class="alert alert-info">
        <strong>Table liée :</strong> <?=$params['dirs']['table_name']?> — <strong>Colonnes :</strong> <?=$params['dirs']['columns']?>
    </div>

    <!-- Fichiers référencés -->
    <div class="card mb-4">
        <div class="card-header bg-light">✔️ Fichiers référencés</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Nom du fichier</th>
                        <th>Taille</th>
                        <th>Dernière Modification</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($params['referenced'] as $referenced): ?>
                        <tr>
                            <td><?=$referenced['name']?></td>
                            <td><?=round($referenced['size']/1024, 2)?> KB</td>
                            <td><?= $referenced['created_at'] ?></td>
                            <td><span class="badge bg-success">Référencé</span></td>
                            <td>-</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Fichiers orphelins -->
    <div class="card">
        <div class="card-header bg-light">⚠️ Fichiers orphelins</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-warning">
                    <tr>
                        <th>Nom du fichier</th>
                        <th>Taille</th>
                        <th>Dernière Modification</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($params['orphans'] as $orphans): ?>
                        <tr>
                            <td><?=$orphans['name']?></td>
                            <td><?=round($orphans['size']/1024, 2)?> KB</td>
                            <td><?= $orphans['created_at'] ?></td>
                            <td><span class="badge bg-warning text-dark">Orphelin</span></td>
                            <td>
                                <form method="POST" action="/filecomposer/scan/delete-file">
                                    <input type="hidden" name="dir" value="<?=$params['dirs']['dir_name']?>">
                                    <input type="hidden" name="dir_id" value="<?=$params['dirs']['id']?>">
                                    <input type="hidden" name="file" value="<?=$orphans['name']?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
