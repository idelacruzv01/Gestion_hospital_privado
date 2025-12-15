<?php if ($datos): ?>
    <div class='bloque-opcion bloque-traslado-domicilio'>
        <h3>Gestión de traslados hospitalarios a domicilio</h3>
        <p><strong>Tfno. Traslados:</strong> <?= htmlspecialchars($datos['telefono_traslados']) ?></p>
        <p><strong>Email Traslados:</strong> <?= htmlspecialchars($datos['email_traslados']) ?></p>
        <p><strong>Instrucciones:</strong> <br><br><?= nl2br(htmlspecialchars($datos['instrucciones'])) ?></p>
    </div>

<?php else: ?>
    <p>No se encontraron datos para gestionar traslados con esta aseguradora.</p>
<?php endif; ?>