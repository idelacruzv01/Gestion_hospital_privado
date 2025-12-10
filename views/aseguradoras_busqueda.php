<?php if (!empty($aseguradoras)): ?>
    <div class="grid-aseguradoras">
        <?php foreach ($aseguradoras as $aseg): ?>
            <div class="aseguradora"
                data-id="<?= htmlspecialchars($aseg['id']) ?>"
                data-nombre="<?= htmlspecialchars($aseg['nombre']) ?>"
                data-logo="<?= htmlspecialchars($aseg['logo']) ?>">

                <img class="logo" src="img/logos/<?= htmlspecialchars($aseg['logo']) ?>" alt="<?= htmlspecialchars($aseg['nombre']) ?>">
                <span><?= htmlspecialchars($aseg['nombre']) ?></span>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p style="text-align:center; color:gray;"><?= $mensaje ?></p>
<?php endif; ?>