<?php if ($datos): ?>
    <div class='bloque-opcion bloque-ingresos'>
        <h3>Autorización de Ingresos</h3>
        <p><strong>Autorización por terminal:</strong> <?= htmlspecialchars($datos['autorizable_por_terminal']) ?></p>
        <p><strong>Autorización por teléfono:</strong> <?= htmlspecialchars($datos['autorizable_por_telefono']) ?></p>
        <p><strong>Tfno autorizaciones:</strong> <?= htmlspecialchars($datos['telefono_autorizaciones']) ?></p>
        <p><strong>Email autorizaciones:</strong> <?= htmlspecialchars($datos['email_autorizaciones']) ?></p>
        <p><strong>Instrucciones:</strong> <br><br><?= nl2br(htmlspecialchars($datos['instrucciones'])) ?></p>
    </div>

<?php else: ?>
    <p>No se encontraron datos de autorización de ingreso con esta aseguradora.</p>
<?php endif; ?>