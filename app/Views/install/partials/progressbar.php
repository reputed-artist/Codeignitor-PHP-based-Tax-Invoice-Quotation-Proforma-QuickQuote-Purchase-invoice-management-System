<div class="progress-container mb-4">
    <div class="progress" style="height: 20px;">
        <div class="progress-bar" role="progressbar" style="width: <?= (($currentStepIndex + 1) / $totalSteps) * 100 ?>%;" aria-valuenow="<?= $currentStepIndex + 1 ?>" aria-valuemin="0" aria-valuemax="<?= $totalSteps ?>">
            Step <?= $currentStepIndex + 1 ?> of <?= $totalSteps ?>
        </div>
    </div>
    <div class="step-indicators mt-3">
        <?php foreach ($steps as $index => $stepName) : ?>
            <div class="step-indicator <?= $index <= $currentStepIndex ? 'completed' : '' ?> <?= $index == $currentStepIndex ? 'current' : '' ?>">
                <div class="step-circle">
                    <?php if ($index < $currentStepIndex) : ?>
                        <i class="check-icon">&#10003;</i>
                    <?php else : ?>
                        <?= $index + 1 ?>
                    <?php endif; ?>
                </div>
                <div class="step-label"><?= ucfirst(str_replace('_', ' ', $stepName)) ?></div>
                <?php if ($index < count($steps) - 1) : ?>
                    <div class="step-connector <?= $index < $currentStepIndex ? 'completed' : '' ?>"></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
