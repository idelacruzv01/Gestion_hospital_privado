    <h3>Editar Ingresos</h3>

<form id="form-ingresos" onsubmit="guardarIngresos(event, <?= $datos['aseguradora_id'] ?>)">

    <!-- Autorizable por Terminal -->
    <label>Autorizable por Terminal</label>
    <select name="autorizable_por_terminal">
        <option value="sí" <?= (isset($datos['autorizable_por_terminal']) && $datos['autorizable_por_terminal'] === 'sí') ? 'selected' : '' ?>>Sí</option>
        <option value="no" <?= (isset($datos['autorizable_por_terminal']) && $datos['autorizable_por_terminal'] === 'no') ? 'selected' : '' ?>>No</option>
    </select>

    <!-- Autorizable por Teléfono -->
    <label>Autorizable por Teléfono</label>
    <select name="autorizable_por_telefono">
        <option value="sí" <?= (isset($datos['autorizable_por_telefono']) && $datos['autorizable_por_telefono'] === 'sí') ? 'selected' : '' ?>>Sí</option>
        <option value="no" <?= (isset($datos['autorizable_por_telefono']) && $datos['autorizable_por_telefono'] === 'no') ? 'selected' : '' ?>>No</option>
    </select>

    <!-- Teléfono de Autorizaciones -->
    <label>Teléfono de Autorizaciones</label>
    <input type="text" name="telefono_autorizaciones" value="<?= htmlspecialchars($datos['telefono_autorizaciones'] ?? '') ?>">

    <!-- Email de Autorizaciones -->
    <label>Email de Autorizaciones</label>
    <input type="email" name="email_autorizaciones" value="<?= htmlspecialchars($datos['email_autorizaciones'] ?? '') ?>">

    <!-- Instrucciones -->
    <label>Instrucciones Ingresos</label>
    <textarea name="instrucciones"><?= htmlspecialchars($datos['instrucciones'] ?? '') ?></textarea>

    <button type="submit" class="boton-accion boton-editar">Guardar</button>
    <button type="button" class="boton-accion boton-borrar" onclick="volverListado()">Cancelar</button>
</form>
