<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="usuarioLabel">
    <div class="modal-dialog modal-lg" role="form">
        <div class="modal-content">
            <form class="form-horizontal" id="formUsuario" enctype="multipart/form-data" role="form" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Encabezado del modal -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span><span
                                    class="sr-only">Cerrar</span></button>
                            <h4 class="modal-title" id="usuarioModalHead">Gestión de Usuario</h4>
                        </div>

                        <!-- Cuerpo del modal -->
                        <div class="modal-body">
                            <?= validation_errors(); ?>

                            <?php if (isset($result_ok)): ?>
                                <div class="alert alert-success text-center" role="alert">
                                    ¡Usuario guardado con éxito!
                                </div>
                            <?php endif ?>
                            <div class="row">
                                <input type="hidden" id="usuario_id" name="usuario_id">
                                <!-- Columna izquierda -->
                                <div class="col-md-6 text-center">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Nombre</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email</label>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" name="email" id="email" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna derecha -->
                                <div class="col-md-6 text-center">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Rol</label>
                                        <div class="col-md-8">
                                            <select class="form-control" id="rol" required>
                                                <option value="">Seleccionar Rol</option>
                                                <option value="admin">Admin</option>
                                                <option value="taller">Taller</option>
                                                <option value="empleado">Empleado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Contraseña</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="password" id="password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fila para la firma -->
                            <br>
                            <!-- <div class="row">
                                <div class="col-12 text-center">
                                    <div class="form-group">
                                        <label class="form-label d-block">Firma del cliente</label>
                                        <div class="firma-container mx-auto" style="max-width: 100%;">
                                            <canvas id="firmaCanvas" style="width:100%;max-width:500px;height:100%;border:1px solid #ccc;" class="mb-3"></canvas>
                                            <input type="hidden" name="firma_base64" id="firmaBase64"><br>
                                            <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="limpiarFirma()">Limpiar Firma</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="row justify-content-center">
                                <div class="col-md-12 text-center">
                                    <div class="form-group">
                                        <label class="form-label d-block">Firma del cliente</label>
                                        <div class="d-flex justify-content-center">
                                            <div class="col-md-10 col-xs-12">
                                                <canvas id="firmaCanvas"
                                                    style="border:1px solid #ccc;width:100%; object-fit: contain; background:#f8f9fa;"
                                                    class="mb-3">
                                                </canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <input type="hidden" name="firma_base64" id="firmaBase64">
                                            <button type="button" class="btn btn-secondary btn-sm mt-2"
                                                onclick="limpiarFirma()">
                                                Limpiar Firma
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer del modal -->
                        <div class="modal-footer text-center">
                            <button type="submit" name="submit_form"
                                class="btn btn-primary pull-right m-left-10 guarda_usuario">
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