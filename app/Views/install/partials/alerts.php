<?php if (!empty($alerts)) : ?>
    <div class="alerts-container mt-3">
        <?php foreach ($alerts as $alert) : ?>
            <div class="alert alert-<?= esc($alert['type']) ?> alert-dismissible fade show" role="alert">
                <?= esc($alert['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
