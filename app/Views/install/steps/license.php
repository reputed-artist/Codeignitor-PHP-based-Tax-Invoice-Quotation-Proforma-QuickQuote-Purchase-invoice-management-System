<div class="card mx-auto mt-5" style="max-width: 800px;">
    <div class="card-header text-center">
        <h2 class="mb-0">License Agreement</h2>
    </div>
    <div class="card-body">
        <?php include __DIR__ . '/../partials/alerts.php'; ?>
        <?php include __DIR__ . '/../partials/progressbar.php'; ?>

        <div class="license-content" style="height: 300px; overflow-y: scroll; border: 1px solid #dee2e6; padding: 15px; background-color: #f8f9fa;">
            <h5>MIT License</h5>
            <p>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:</p>
            <p>The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.</p>
            <p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.</p>
        </div>

        <form action="<?= site_url('install?step=license') ?>" method="POST" class="mt-4">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="agreeLicense" name="agree_license" required>
                <label class="form-check-label" for="agreeLicense">
                    I agree to the terms and conditions of the license agreement.
                </label>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?= site_url('install?step=welcome') ?>" class="btn btn-secondary">Previous</a>
                <button type="submit" class="btn btn-primary">Next</button>
            </div>
        </form>
    </div>
</div>
