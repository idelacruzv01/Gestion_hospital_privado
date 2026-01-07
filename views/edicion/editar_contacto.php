<h3>Editar Contacto</h3>

<form id="form-contacto" onsubmit="guardarContacto(event, <?= $datos['id'] ?>)">

    <label>Teléfono</label>
    <input type="text" name="telefono" value="<?= htmlspecialchars($datos['telefono'] ?? '') ?>">

    <label>Horario</label>
    <input type="text" name="horario" value="<?= htmlspecialchars($datos['horario'] ?? '') ?>">

    <label>Mail 1</label>
    <input type="email" name="mail1" value="<?= htmlspecialchars($datos['mail1'] ?? '') ?>">

    <label>Mail 2</label>
    <input type="email" name="mail2" value="<?= htmlspecialchars($datos['mail2'] ?? '') ?>">

    <button type="submit" class="boton-accion boton-editar">Guardar</button>
    <button type="button" class="boton-accion boton-borrar" onclick="volverListado()">Cancelar</button>
</form>
