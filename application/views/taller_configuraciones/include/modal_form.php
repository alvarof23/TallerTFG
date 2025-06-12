<div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="clienteLabel">
    <div class="modal-dialog modal-lg" role="form">
        <div class="modal-content">
            <form class="form-horizontal" id="formCliente" enctype="multipart/form-data" role="form" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Encabezado del modal -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span><span class="sr-only">Cerrar</span></button>
                            <h4 class="modal-title" id="clienteModalHead">Gestión de Cliente</h4>
                        </div>

                        <!-- Cuerpo del modal -->
                        <div class="modal-body">
                            <?= validation_errors(); ?>

                            <?php if (isset($result_ok)) : ?>
                                <div class="alert alert-success text-center" role="alert">
                                    ¡Cliente guardado con éxito!
                                </div>
                            <?php endif ?>

                            <div class="row">

                                <!-- Columna izquierda -->
                                <div class="col-md-6 text-center">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">DNI</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="dni" id="dni" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Nombre</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna derecha -->
                                <div class="col-md-6 text-center">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Teléfono</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="telefono" id="telefono" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Correo</label>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" name="correo_electronico" id="correo_electronico" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer del modal -->
                        <div class="modal-footer text-center">
                            <button type="submit" name="submit_form" class="btn btn-primary pull-right m-left-10 guarda_cliente">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-default pull-right m-left-10" data-dismiss="modal">
                                <span class="fa fa-reply"></span> Volver
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
