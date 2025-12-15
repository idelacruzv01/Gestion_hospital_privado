<?php if ($datos): ?>
    <div class='bloque-opcion bloque-tac'>
        <h3>Autorización de TACs</h3>
        <p><strong>Necesita autorización?</strong> <?= htmlspecialchars($datos['precisa_autorizacion']) ?></p>
        <p><strong>Se autoriza por terminal?</strong> <?= htmlspecialchars($datos['autorizable_por_terminal']) ?></p>
        <p><strong>Se autoriza por teléfono?</strong> <?= htmlspecialchars($datos['autorizable_por_telefono']) ?></p>
        <p><strong>Tfno autorizaciones:</strong> <?= htmlspecialchars($datos['telefono_autorizaciones']) ?></p>
        <p><strong>Email autorizaciones:</strong> <?= htmlspecialchars($datos['email_autorizaciones']) ?></p>
        <p><strong>TAC doble: </strong> <?= htmlspecialchars($datos['tac_doble']) ?></p>
        <p><strong>TAC con contraste:</strong> <?= htmlspecialchars($datos['tac_con_contraste']) ?></p>
        <p><strong>Instrucciones:</strong> <br><br><?= nl2br(htmlspecialchars($datos['instrucciones'])) ?></p>
    </div>

<?php else: ?>
    <div class='bloque-opcion bloque-tac'>
        <p>No hay información de TACs para esta aseguradora.</p>
    </div>
<?php endif; ?>