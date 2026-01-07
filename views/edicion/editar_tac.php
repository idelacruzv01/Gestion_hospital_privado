<h3>Editar TAC</h3>

<form id="form-tac" onsubmit="guardarTac(event, <?= $datos['aseguradora_id'] ?>)">  

    <label>Precisa Autorización</label>
    <select name="precisa_autorizacion">
        <option value="sí" <?= (isset($datos['precisa_autorizacion']) && $datos['precisa_autorizacion'] === 'sí') ? 'selected' : '' ?>>Sí</option>
        <option value="no" <?= (isset($datos['precisa_autorizacion']) && $datos['precisa_autorizacion'] === 'no') ? 'selected' : '' ?>>No</option>
    </select>

    <label>Autorizable por Terminal</label>
    <select name="autorizable_por_terminal">
        <option value="sí" <?= (isset($datos['autorizable_por_terminal']) && $datos['autorizable_por_terminal'] === 'sí') ? 'selected' : '' ?>>Sí</option>
        <option value="no" <?= (isset($datos['autorizable_por_terminal']) && $datos['autorizable_por_terminal'] === 'no') ? 'selected' : '' ?>>No</option>
    </select>

    <label>Autorizable por Teléfono</label>
    <select name="autorizable_por_telefono">
        <option value="sí" <?= (isset($datos['autorizable_por_telefono']) && $datos['autorizable_por_telefono'] === 'sí') ? 'selected' : '' ?>>Sí</option>
        <option value="no" <?= (isset($datos['autorizable_por_telefono']) && $datos['autorizable_por_telefono'] === 'no') ? 'selected' : '' ?>>No</option>
    </select>

    <label>Teléfono autorizaciones</label>
    <input type="text" name="telefono_autorizaciones" value="<?= htmlspecialchars($datos['telefono_autorizaciones'] ?? '') ?>">

    <label>Email autorizaciones</label>
    <input type="email" name="email_autorizaciones" value="<?= htmlspecialchars($datos['email_autorizaciones'] ?? '') ?>">

    <label>Instrucciones</label>
    <textarea name="instrucciones"><?= htmlspecialchars($datos['instrucciones'] ?? '') ?></textarea>

    <label>TAC Doble</label>
    <textarea name="tac_doble"><?= htmlspecialchars($datos['tac_doble'] ?? '') ?></textarea>

    <label>TAC con Contraste</label>
    <textarea name="tac_con_contraste"><?= htmlspecialchars($datos['tac_con_contraste'] ?? '') ?></textarea>

    <button type="submit" class="boton-accion boton-editar">Guardar</button>
    <button type="button" class="boton-accion boton-borrar" onclick="volverListado()">Cancelar</button>
</form>
