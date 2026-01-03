<h3>Editar Traslado Domicilio</h3>

<form id="form-traslado-domicilio" onsubmit="guardarTrasladoDomicilio(event, <?= $datos['aseguradora_id'] ?>)">

    <label>Teléfono</label>
    <input type="text" name="telefono_traslados" value="<?= htmlspecialchars($datos['telefono_traslados'] ?? '') ?>">

    <label>Email</label>
    <input type="email" name="email_traslados" value="<?= htmlspecialchars($datos['email_traslados'] ?? '') ?>">

    <label>Instrucciones</label>
    <textarea name="instrucciones"><?= htmlspecialchars($datos['instrucciones'] ?? '') ?></textarea>

    <button type="submit" class="btn-menu">Guardar</button>
    <button type="button" class="btn-volver" onclick="volverMenuEdicion()">Cancelar</button>
</form>
