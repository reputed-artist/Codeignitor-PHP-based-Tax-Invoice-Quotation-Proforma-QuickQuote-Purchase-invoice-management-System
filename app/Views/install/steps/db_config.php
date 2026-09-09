<div class="card mx-auto mt-5" style="max-width: 600px;">
    <div class="card-header text-center">
        <h2 class="mb-0">Database Configuration</h2>
    </div>
    <div class="card-body">
        <?php include __DIR__ . '/../partials/alerts.php'; ?>
        <?php include __DIR__ . '/../partials/progressbar.php'; ?>

        <form action="<?= site_url('install?step=db_config') ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <div class="mb-3">
                <label for="db_driver" class="form-label">Database Type</label>
                <select class="form-control" id="db_driver" name="db_driver" onchange="toggleDatabaseFields()" required>
                    <option value="mysql" <?= ($db_driver ?? 'mysql') === 'mysql' ? 'selected' : '' ?>>MySQL</option>
                    <option value="pgsql" <?= ($db_driver ?? 'mysql') === 'pgsql' ? 'selected' : '' ?>>PostgreSQL</option>
                    <option value="sqlite" <?= ($db_driver ?? 'mysql') === 'sqlite' ? 'selected' : '' ?>>SQLite</option>
                </select>
            </div>
            <div id="server-fields">
                <div class="mb-3">
                    <label for="db_host" class="form-label">Database Host</label>
                    <input type="text" class="form-control" id="db_host" name="db_host" value="<?= esc($db_host ?? 'localhost') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="db_port" class="form-label">Database Port</label>
                    <input type="number" class="form-control" id="db_port" name="db_port" value="<?= esc($db_port ?? '3306') ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="db_name" class="form-label" id="db_name_label">Database Name</label>
                <input type="text" class="form-control" id="db_name" name="db_name" value="<?= esc($db_name ?? '') ?>" required>
                <small class="form-text text-muted" id="db_name_help">Enter the database name</small>
            </div>
            <div id="auth-fields">
                <div class="mb-3">
                    <label for="db_username" class="form-label">Database Username</label>
                    <input type="text" class="form-control" id="db_username" name="db_username" value="<?= esc($db_username ?? 'root') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="db_password" class="form-label">Database Password</label>
                    <input type="password" class="form-control" id="db_password" name="db_password" value="<?= esc($db_password ?? '') ?>">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?= site_url('install?step=system_check') ?>" class="btn btn-secondary">Previous</a>
                <button type="submit" class="btn btn-primary">Next</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDatabaseFields() {
    const driver = document.getElementById('db_driver').value;
    const serverFields = document.getElementById('server-fields');
    const authFields = document.getElementById('auth-fields');
    const dbNameLabel = document.getElementById('db_name_label');
    const dbNameHelp = document.getElementById('db_name_help');
    const dbPortField = document.getElementById('db_port');

    if (driver === 'sqlite') {
        serverFields.style.display = 'none';
        authFields.style.display = 'none';
        dbNameLabel.textContent = 'Database File Path';
        dbNameHelp.textContent = 'Enter the path to SQLite database file (e.g., /path/to/database.db)';
        document.getElementById('db_host').required = false;
        document.getElementById('db_port').required = false;
        document.getElementById('db_username').required = false;
    } else {
        serverFields.style.display = 'block';
        authFields.style.display = 'block';
        dbNameLabel.textContent = 'Database Name';
        dbNameHelp.textContent = 'Enter the database name';
        document.getElementById('db_host').required = true;
        document.getElementById('db_port').required = true;
        document.getElementById('db_username').required = true;

        // Set default ports
        const supportedDbs = {
            mysql: { default_port: '3306' },
            pgsql: { default_port: '5432' },
            sqlite: { default_port: null }
        };
        if (supportedDbs[driver] && supportedDbs[driver].default_port) {
            dbPortField.value = supportedDbs[driver].default_port;
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleDatabaseFields();
});
</script>
