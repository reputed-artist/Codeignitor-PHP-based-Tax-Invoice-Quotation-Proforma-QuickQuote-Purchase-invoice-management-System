<div class="card mx-auto mt-5" style="max-width: 600px;">
    <div class="card-header text-center">
        <h2 class="mb-0">Installation Complete!</h2>
    </div>
    <div class="card-body">
        <?php include __DIR__ . '/../partials/alerts.php'; ?>
        <?php include __DIR__ . '/../partials/progressbar.php'; ?>

        <div class="text-center">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Success!</h4>
                <p>Your application has been successfully installed and configured.</p>
            </div>

            <p>You can now access your application and start using it.</p>

            <form action="<?= site_url('install?step=finish') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <button type="submit" class="btn btn-success">Complete Installation</button>
            </form>
        </div>
    </div>
</div>
