<?php if ($datos): ?>
    <div class="bloque-opcion bloque-contacto">
        <h3>Información de Contacto</h3>
        <p><strong>Teléfono:</strong> <?= htmlspecialchars($datos['telefono']) ?></p>
        <p><strong>Horario:</strong> <?= htmlspecialchars($datos['horario']) ?></p>
        <p><strong>Email 1:</strong> <?= htmlspecialchars($datos['mail1']) ?></p>
        <p><strong>Email 2:</strong> <?= htmlspecialchars($datos['mail2']) ?></p>
    </div>

<?php else: ?>
    <div class="bloque-opcion bloque-contacto">
        <p>No se encontraron datos de contacto.</p>
    </div>
<?php endif; ?>