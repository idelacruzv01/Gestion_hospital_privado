<div class="menu-section">

    <h2>Editar aseguradora: <?= htmlspecialchars($aseguradora['nombre']) ?></h2>

    <div class="menu-edicion">
        <button class="btn-menu" onclick="editarSeccion('editarContacto', <?= $aseguradora['id'] ?>)">Contacto</button>
        <button class="btn-menu" onclick="editarSeccion('editarUrgencias', <?= $aseguradora['id'] ?>)">Urgencias</button>
        <button class="btn-menu" onclick="editarSeccion('editarAntigenos', <?= $aseguradora['id'] ?>)">Antígenos</button>
        <button class="btn-menu" onclick="editarSeccion('editarIngresos', <?= $aseguradora['id'] ?>)">Ingresos</button>
        <button class="btn-menu" onclick="editarSeccion('editarTAC', <?= $aseguradora['id'] ?>)">TAC</button> 
        <button class="btn-menu" onclick="editarSeccion('editarTrasladoOtroCentro', <?= $aseguradora['id'] ?>)">Traslado a otro centro</button>
        <button class="btn-menu" onclick="editarSeccion('editarTrasladoDomicilio', <?= $aseguradora['id'] ?>)">Traslado Domicilio</button>
    </div>

    <button class="btn-volver" onclick="volverListado()">⬅ Volver</button>
</div>