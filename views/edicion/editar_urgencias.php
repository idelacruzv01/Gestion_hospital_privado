<h3>Editar Protocolo de Urgencias</h3>

<form id="form-urgencias" onsubmit="guardarUrgencias(event, <?= (int)$datos['aseguradora_id'] ?>)">

    <label>Código General</label>
    <input type="number" name="codigo_general"
           value="<?= htmlspecialchars($datos['codigo_general'] ?? '') ?>">

    <label>Código Pediatría</label>
    <input type="number" name="codigo_pediatria"
           value="<?= htmlspecialchars($datos['codigo_pediatria'] ?? '') ?>">

    <label>Terminal</label>
    <textarea name="terminal"><?= htmlspecialchars($datos['terminal'] ?? '') ?></textarea>

    <label>Instrucciones</label>
    <textarea name="instrucciones"><?= htmlspecialchars($datos['instrucciones'] ?? '') ?></textarea>

    <button type="submit" class="boton-accion boton-editar">Guardar</button>
    <button type="button" class="boton-accion boton-borrar" onclick="volverListado()">Cancelar</button>

</form>
