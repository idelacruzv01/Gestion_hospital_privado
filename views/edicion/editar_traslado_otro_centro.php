<h3>Editar Traslado a Otro Centro</h3>

<form id="form-traslado-hospitalario" onsubmit="guardarTrasladoHospitalario(event, <?= $datos['aseguradora_id'] ?>)">

    <label>Teléfono Traslado</label>
    <input type="text" name="telefono_traslados" value="<?= htmlspecialchars($datos['telefono_traslados'] ?? '') ?>">

    <label>Email Traslado</label>
    <input type="email" name="email_traslados" value="<?= htmlspecialchars($datos['email_traslados'] ?? '') ?>">

    <label>Instrucciones Traslado</label>
    <textarea name="instrucciones"><?= htmlspecialchars($datos['instrucciones'] ?? '') ?></textarea>

    <button type="submit" class="btn-menu">Guardar</button>
    <button type="button" class="btn-volver" onclick="volverMenuEdicion()">Cancelar</button>
</form>