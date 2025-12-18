<table class="tabla-crud">
    <thead>
        <tr>
            <?php foreach ($config['cabeceras'] as $cabecera): ?>
                <th><?= htmlspecialchars($cabecera) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultados as $fila): ?>
            <tr>
                <?php foreach ($config['columnas'] as $col): ?>
                    <td><?= htmlspecialchars($fila[$col] ?? '') ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
