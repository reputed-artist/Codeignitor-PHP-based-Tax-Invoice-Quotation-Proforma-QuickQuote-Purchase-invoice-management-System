<div class="card mx-auto mt-5" style="max-width: 600px;">
    <div class="card-header text-center">
        <h2 class="mb-0">Application Configuration</h2>
    </div>
    <div class="card-body">
        <?php include __DIR__ . '/../partials/alerts.php'; ?>
        <?php include __DIR__ . '/../partials/progressbar.php'; ?>

        <form action="<?= site_url('install?step=app_config') ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <div class="mb-3">
                <label for="app_name" class="form-label">Application Name</label>
                <input type="text" class="form-control" id="app_name" name="app_name" value="<?= esc($app_name ?? 'C4') ?>" required>
            </div>
            <div class="mb-3">
                <label for="app_url" class="form-label">Application URL</label>
                <input type="url" class="form-control" id="app_url" name="app_url" value="<?= esc($app_url ?? 'http://localhost/C4/login') ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?= site_url('install?step=db_import') ?>" class="btn btn-secondary">Previous</a>
                <button type="submit" class="btn btn-primary">Next</button>
            </div>
        </form>
    </div>
</div>
