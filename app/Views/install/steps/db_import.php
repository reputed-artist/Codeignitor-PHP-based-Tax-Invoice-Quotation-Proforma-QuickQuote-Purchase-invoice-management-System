<div class="card mx-auto mt-5" style="max-width: 600px;">
    <div class="card-header text-center">
        <h2 class="mb-0">Database Import</h2>
    </div>
    <div class="card-body">
        <?php include __DIR__ . '/../partials/alerts.php'; ?>
        <?php include __DIR__ . '/../partials/progressbar.php'; ?>

        <div class="mb-4">
            <h5>Import Options</h5>
            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="import_type" id="useDefault" value="default" checked>
                <label class="form-check-label" for="useDefault">
                    Use default database schema
                    <small class="d-block text-muted">Imports <code>database/install.sql</code> if present</small>
                </label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="import_type" id="uploadFile" value="upload">
                <label class="form-check-label" for="uploadFile">
                    Upload custom SQL file
                </label>
            </div>
        </div>

        <form action="<?= site_url('install?step=db_import') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

            <div id="uploadSection" class="mb-3" style="display: none;">
                <label for="sqlFile" class="form-label">Select SQL File</label>
                <input type="file" class="form-control" id="sqlFile" name="sql_file" accept=".sql,.zip">
                <div class="form-text">Upload a .sql file or .zip archive containing SQL files.</div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= site_url('install?step=db_config') ?>" class="btn btn-secondary">Previous</a>
                <button type="submit" class="btn btn-primary">Import Database</button>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const defaultRadio = document.getElementById('useDefault');
                const uploadRadio = document.getElementById('uploadFile');
                const uploadSection = document.getElementById('uploadSection');

                function toggleUploadSection() {
                    uploadSection.style.display = uploadRadio.checked ? 'block' : 'none';
                }

                defaultRadio.addEventListener('change', toggleUploadSection);
                uploadRadio.addEventListener('change', toggleUploadSection);
            });
        </script>
    </div>
</div>
