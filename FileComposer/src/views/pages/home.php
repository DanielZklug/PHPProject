<div class="container mt-4">

  <h2 class="mb-4">📂 Tableau de bord - FileComposer</h2>

  <!-- Section création de lien -->
  <div class="card mb-4">
    <div class="card-header">Créer un nouveau lien</div>
    <div class="card-body">
        <form method="post" action="/filecomposer/create-link">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Dossier</label>
                    <select name="dir_name" class="form-select">
                        <?php foreach($params['folders'] as $folder): ?>
                            <option value="<?=$folder?>"><?=$folder?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Table liée</label>
                    <select name="table_name" id="table-select" class="form-select">
                        <option value="">-- Sélectionner une table --</option>
                        <?php foreach($params['tables'] as $table): ?>
                            <option value="<?=$table?>"><?=$table?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="columns-container" class="mt-3"></div>
            <script>
                document.getElementById('table-select').addEventListener('change', function() {
                    const tableName = this.value;
                    const container = document.getElementById('columns-container');

                    if (!tableName) {
                        container.innerHTML = "";
                        return;
                    }

                    fetch(`/filecomposer/get-columns/${tableName}`)
                        .then(res => res.json())
                        .then(cols => {
                            let html = "<label class='form-label'>Colonnes disponibles</label>";
                            cols.forEach(col => {
                                html += `
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="columns[]" value="${col}" id="col_${col}">
                                    <label class="form-check-label" for="col_${col}">${col}</label>
                                    </div>
                                `;
                            });
                            container.innerHTML = html;
                        });
                });
            </script>

            <button type="submit" class="btn btn-primary mt-3">Créer le lien</button>
        </form>
    </div>
  </div>

  <!-- Section dashboard -->
  <div class="card">
    <div class="card-header">Liens existants</div>
    <div class="card-body">
      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th>Dossier</th>
            <th>Table liée</th>
            <th>Colonnes</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach($params['dirs_linked'] as $link): ?>
                <tr>
                    <td><?=$link['dir_name']?></td>
                    <td><?=$link['table_name']?></td>
                    <td><?=$link['columns']?></td>
                    <td>
                        <form method="GET" action="/filecomposer/scan/results/<?=$link['id']?>" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-success">Scanner</button>
                        </form>
                        <form method="POST" action="/filecomposer/delete-link" class="d-inline">
                            <input type="hidden" name="dir_linked_id" value="<?=$link['id']?>">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression du lien ?')">Supprimer lien</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>


