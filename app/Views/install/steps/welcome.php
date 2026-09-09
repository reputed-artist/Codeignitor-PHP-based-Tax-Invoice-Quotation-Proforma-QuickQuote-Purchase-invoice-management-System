<div class="card mx-auto mt-5" style="max-width: 600px;">
    <div class="card-header text-center">
        <div class="installer-logo mb-3">
            <svg width="80" height="80" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#3c8dbc;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#1e3c72;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <circle cx="50" cy="50" r="45" fill="url(#logoGradient)" stroke="white" stroke-width="3"/>
                <text x="50" y="35" font-family="Arial, sans-serif" font-size="16" font-weight="bold" fill="white" text-anchor="middle">PHP</text>
                <text x="50" y="55" font-family="Arial, sans-serif" font-size="12" fill="white" text-anchor="middle">INSTALLER</text>
                <path d="M30 65 L50 75 L70 65" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
            </svg>
        </div>
        <h2 class="mb-0">Welcome to the Installer!</h2>
    </div>
    <div class="card-body">
        <?php include __DIR__ . '/../partials/alerts.php'; ?>
        <?php include __DIR__ . '/../partials/progressbar.php'; ?>

        <p class="card-text">This wizard will guide you through the installation process of your PHP application.</p>
        <p class="card-text">Please ensure you have the necessary database credentials and application settings ready.</p>

        <form action="<?= site_url('install?step=welcome') ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Start Installation</button>
            </div>
        </form>
    </div>
</div>
