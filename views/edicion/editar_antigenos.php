<h3>Editar Antígenos</h3>

<form id="form-antigenos" onsubmit="guardarAntigenos(event, <?= $datos['aseguradora_id'] ?>)">

    <label>Precisa autorización</label>
    <select name="precisa_autorizacion">
        <option value="si" <?= ($datos['precisa_autorizacion'] ?? '') === 'si' ? 'selected' : '' ?>>
            Sí
        </option>
        <option value="no" <?= ($datos['precisa_autorizacion'] ?? '') === 'no' ? 'selected' : '' ?>>
            No
        </option>
    </select>

    <label>Código de Autorización</label>
    <input type="text" name="codigo_aut"
           value="<?= htmlspecialchars($datos['codigo_aut'] ?? '') ?>">

    <label>Instrucciones Antígenos</label>
    <textarea name="instrucciones_antigenos">
        <?= htmlspecialchars($datos['instrucciones'] ?? '') ?>
    </textarea>

    <button type="submit" class="boton-accion boton-editar">Guardar</button>
    <button type="button" class="boton-accion boton-borrar" onclick="volverListado()">Cancelar</button>
</form>
