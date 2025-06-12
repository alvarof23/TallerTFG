<?php $this->load->view('include/Header'); ?>

<!-- Botones superiores -->
<ul class="panel-controls list-unstyled d-flex justify-content-center align-items-center gap-3 p-3">
    <li>
        <button type="button" class="btn btn-primary activarModal" data-toggle="modal" title="Crear usuario"
            style="border-radius: 100%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
            <i class="fa fa-plus"></i>
        </button>
    </li>
</ul>

<!-- Panel principal -->
<div class="panel panel-default" style="border-top:none;">
    <div class="panel-body">

        <div class="d-flex justify-content-center align-items-center" style="margin-top: 20px; width: 100%;">
            <div class="col-md-11 col-xs-12 m-top-10">
                <?php $this->load->view('taller_usuarios/include/filtro'); ?>
                <!-- Asegúrate de tener este archivo o créalo -->
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center" style="margin-top: 20px; width: 100%;">


            <div class="col-md-11 table-responsive m-top-10">

                <?php if (isset($users) && !empty($users)): ?>
                    <table class="table table-striped tabla_usuarios" id="tablausuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha de creación</th>
                                <th>Firma</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['nombre'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['rol'] ?></td>
                                    <td><?= $user['fecha_creacion'] ?></td>
                                    <td>
                                        <?php if ($user['firma']): ?>
                                            <img src="<?= $user['firma'] ?>" alt="" height="94px"
                                                style="display: block; margin: 0 auto;">
                                        <?php else: ?>
                                            <span class="text-muted">No disponible</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div id="div_botones">
                                            <button type="button" class="btn btn-primary editar_usuario" id="boton_vehiculos" title="Editar"
                                                data-usuario-id="<?= $user['id'] ?>">
                                                <i class="fa fa-pencil"></i>
                                            </button>

                                            <button class="text-danger eliminar_usuario" id="boton_vehiculos" title="Eliminar"
                                                data-usuario-id="<?= $user['id'] ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div role="alert" class="alert alert-warning">
                        <button data-dismiss="alert" class="close" type="button"><span>x</span><span
                                class="sr-only">Cerrar</span></button>
                        <strong><i class="fa fa-warning"></i></strong> No hay usuarios para mostrar.
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<!-- Modales -->
<?php $this->load->view('taller_usuarios/include/modal_form'); ?> <!-- Asegúrate de tener este archivo o créalo -->

<?php $this->load->view('include/Footer'); ?>