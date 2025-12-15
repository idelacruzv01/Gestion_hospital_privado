<?php if ($datos): ?>
    <div class="bloque-opcion bloque-antigeno">
        <h3>Información de Antígenos</h3>
        <p><strong>Necesita autorización?</strong> <?= htmlspecialchars($datos['precisa_autorizacion']) ?></p>
        <p><strong>Codigo:</strong> <?= htmlspecialchars($datos['codigo_aut']) ?></p>
        <p><strong>Instrucciones:</strong> <br><br><?= nl2br(htmlspecialchars($datos['instrucciones'])) ?></p>
    </div>

<?php else: ?>
    <div class="bloque-opcion bloque-antigeno">
        <p>No hay información de antígenos para esta aseguradora.</p>
    </div>
<?php endif; ?>