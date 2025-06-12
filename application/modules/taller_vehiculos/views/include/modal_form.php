<div class="modal fade" id="pruebaModal" tabindex="-1" role="dialog" aria-labelledby="editarClasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="form">
        <div class="modal-content">
            <form class="form-horizontal" id="formModal" enctype="multipart/form-data" role="form" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                           
                            <h4 class="modal-title" id="defModalHead"></h4>

                        </div>

                        <div class="modal-body">
                            <?= validation_errors(); ?>

                            <?php if (isset($result_ok)) : ?>
                                <div class="alert alert-success text-center" role="alert">
                                    ¡Vehículo guardado con éxito!
                                </div>
                            <?php endif ?>

                            <div class="row">
                                <input type="hidden" name="id_vehiculo" id="id_vehiculo" value="">


                                <!-- Columna Izquierda -->
                                <div class="col-md-6 text-center">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Cliente</label>
                                        <div class="col-md-8">
                                            <select class="form-control select" name="id_cliente" data-live-search="true" required>
                                                <option value="default" selected disabled>Seleccione un cliente</option>
                                                <?php foreach ($clientes as $cliente): ?>
                                                    <option value="<?= $cliente->dni ?>">
                                                        <?= $cliente->nombre ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Marca</label>
                                        <div class="col-md-8">
                                            <select class="form-control select" id="marca" name="nom_marca" data-live-search="true" required>
                                                <option value="default" selected disabled>Seleccione una marca</option>
                                                <?php foreach ($marca_vehiculo as $marca): ?>
                                                    <option value="<?= $marca->id ?>">
                                                        <?= $marca->marca ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Modelo</label>
                                        <div class="col-md-8">
                                            <select class="form-control select" name="id_modelo" id="modelo_change" data-live-search="true" required>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Matrícula</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="matricula" required value="<?= $matricula[0]->matricula ?>">
                                        </div>
                                    </div>
                                    <div class="table-container">
                                        <table class="table table-striped" id="tablaImagenesModal">
                                            <thead>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Nombre</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="imagenesVehiculo">
                                                <!-- Las filas se insertarán aquí -->
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <!-- Columna Derecha -->
                                <div class="col-md-6 text-center">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Color</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="color" required value="<?= $color[0]->color ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Bastidor</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="num_bastidor" required value="<?= $bastidor[0]->num_bastidor ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Fabricado</label>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control" name="fecha_matriculacion" required value="<?= $fecha_matriculacion[0]->fecha_matriculacion ?>">
                                        </div>
                                    </div>


                                    <!-- Para subir imagenes -->
                                    <div class="form-group col-md-12" id="div_dropzone" style="margin-top: 60px;">
                                        <label for="subirImagen">Suelta aquí tu imagen:</label>
                                        <div id="dropzone" class="dropzone dropzone-mini dz-clickable"></div>
                                        <button type="button" name="submit_form" class="btn btn-primary   col-md-12  " id="btnSubirImagen"><i class="fa fa-save"></i> Subir imagen</button>

                                    </div>

                                </div>
                            </div>
                            
                        </div>

                        
                        <div class="modal-footer text-center">
                            <button type="button" name="submit_form" class="btn btn-primary pull-right  m-left-10  guarda_vehiculo"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-default  pull-right  m-left-10 " data-dismiss="modal"><span aria-hidden="true" class="fa fa-reply"></span> Volver</button>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
