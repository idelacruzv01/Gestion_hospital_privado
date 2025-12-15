<?php if ($datos): ?>
    <div class='bloque-opcion bloque-protocolo'>
        <h3>Protocolo de Urgencias</h3>

        <p><strong>Código General:</strong> <?= htmlspecialchars($datos['codigo_general']) ?></p>
        <p><strong>Código Pediátrico:</strong> <?= htmlspecialchars($datos['codigo_pediatria']) ?></p>
        <p><strong>Terminal:</strong> <?= htmlspecialchars($datos['terminal']) ?></p>
        <p><strong>Instrucciones:</strong><br><br> <?= nl2br(htmlspecialchars($datos['instrucciones'])) ?></p>
    </div>

<?php else: ?>
    <div class='bloque-opcion bloque-protocolo'>
        <p>No hay protocolo de urgencias para esta aseguradora.</p>
        <p><!-- ID recibido: <?= $id ?> --></p>
    </div>
<?php endif; ?>