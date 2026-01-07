<h3>Editar Traslado Domicilio</h3>

<form id="form-traslado-domicilio" onsubmit="guardarTrasladoDomicilio(event, <?= $datos['aseguradora_id'] ?>)">

    <label>Teléfono Traslado</label>
    <input type="text" name="telefono_traslados" value="<?= htmlspecialchars($datos['telefono_traslados'] ?? '') ?>">

    <label>Email Traslado</label>
    <input type="email" name="email_traslados" value="<?= htmlspecialchars($datos['email_traslados'] ?? '') ?>">

    <label>Instrucciones Traslado</label>
    <textarea name="instrucciones"><?= htmlspecialchars($datos['instrucciones'] ?? '') ?></textarea>

    <button type="submit" class="boton-accion boton-editar">Guardar</button>
    <button type="button" class="boton-accion boton-borrar" onclick="volverListado()">Cancelar</button>
</form>
