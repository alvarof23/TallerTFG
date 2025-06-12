<tbody class="tabla_clientes_cuerpo">
    <?php if (!empty($clientes)): ?>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= $cliente['dni'] ?></td>
                <td><?= $cliente['nombre'] ?></td>
                <td><?= $cliente['telefono'] ?></td>
                <td><?= $cliente['correo_electronico'] ?></td>
                <td class="pull-right">
                    <!-- Botón de edición -->
                    <button type="button"
                            class="btn btn-primary editarModal"
                            data-toggle="modal"
                            data-target="#modal_form"
                            data-id="<?= $cliente['dni'] ?>"
                            title="Editar cliente"
							id="boton_vehiculos">
                        <i class="fa fa-edit"></i>
                    </button>
                    <?= anchor('clientes/eliminar_cliente/'.$cliente['dni'], '<span class="fa fa-trash"></span>', 'class="text-danger delete" id="boton_vehiculos" data-placement="top" data-toggle="tooltip" data-original-title="Borrar vehiculo"') ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-center">No hay clientes registrados.</td>
        </tr>
    <?php endif; ?>
</tbody>
