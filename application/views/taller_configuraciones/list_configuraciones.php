<?php $this->load->view('include/Header'); ?>

<!-- Botones superiores -->



<!-- Panel principal -->
<div class="panel panel-default" style="border-top:none;">
    <div class="nav-tabs-wrapper" style="overflow-x: auto; overflow-y: hidden; white-space: nowrap;">
        <ul class="nav nav-tabs" style="display: inline-flex; min-width: 100%;">
            <li><a data-toggle="tab" href="#taller">Taller</a></li>
            <li><a data-toggle="tab" href="#configuraciones">Config. Áreas</a></li>
            <li><a data-toggle="tab" href="#areas">Áreas</a></li>
            <li><a data-toggle="tab" href="#tareas">Tareas</a></li>
            <li><a data-toggle="tab" href="#productos_tarea">Productos</a></li>
        </ul>
    </div>


    <div class="panel-body">
        <div class="tab-content">

            <!-- TAB: taller -->
            <div id="taller" class="tab-pane fade">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="glyphicon glyphicon-cog"></span> Configuración del Taller
                        </h3>
                    </div>
                    <div class="panel-body padding-md-x">
                        <form id="form_taller" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <!-- Columna Izquierda -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nombre_taller" class="control-label">Nombre del Taller</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-home"></span></span>
                                            <input type="text" class="form-control" id="nombre_taller" name="nombre"
                                                placeholder="Nombre del Taller" value="<?= $taller->nombre ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="telefono" class="control-label">Teléfono</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-earphone"></span></span>
                                            <input type="text" class="form-control" id="telefono" name="telefono"
                                                placeholder="Teléfono" value="<?= $taller->telefono ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="control-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-envelope"></span></span>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email" value="<?= $taller->email ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="direccion" class="control-label">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion"
                                            placeholder="Dirección" value="<?= $taller->direccion ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="codigo_postal" class="control-label">Código Postal</label>
                                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal"
                                            placeholder="Código Postal" value="<?= $taller->codigo_postal ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="localidad" class="control-label">Localidad</label>
                                        <input type="text" class="form-control" id="localidad" name="localidad"
                                            placeholder="Localidad" value="<?= $taller->localidad ?>">
                                    </div>
                                </div>

                                <!-- Columna Derecha -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="provincia" class="control-label">Provincia</label>
                                        <input type="text" class="form-control" id="provincia" name="provincia"
                                            placeholder="Provincia" value="<?= $taller->provincia ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="pais" class="control-label">País</label>
                                        <input type="text" class="form-control" id="pais" name="pais" placeholder="País"
                                            value="<?= $taller->pais ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="nif" class="control-label">NIF</label>
                                        <input type="text" class="form-control" id="nif" name="nif" placeholder="NIF"
                                            value="<?= $taller->nif ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="horario_atencion_cliente" class="control-label">Horario
                                            Atención</label>
                                        <textarea class="form-control" id="horario_atencion_cliente"
                                            name="horario_atencion_cliente" rows="1"
                                            placeholder="Ej. Lunes a Viernes: 8:00 - 14:00"><?= $taller->horario_atencion_cliente ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6 text-center">
                                                <label>Logo Actual</label><br>
                                                <img src="<?= base_url($taller->logo) ?>" alt="Logo del Taller"
                                                    class="img-thumbnail" style="max-height: 120px;">
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="logo" class="control-label">Cambiar Logo</label>
                                                <input type="file" class="form-control" id="logo" name="logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr>

                            <div class="form-group text-right" style="margin-right: 10px;">
                                <button type="submit" class="btn btn-success">
                                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- TAB: Configuraciones -->
            <div id="configuraciones" class="tab-pane fade">

                <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                    <button type="button" class="btn btn-primary" id="btn_nueva_conf" data-toggle="modal"
                        title="Crear configuración"
                        style="border-radius: 50%; width: 30px; height: 30px; padding: 0; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>

                <div class="panel-group" id="accordion_conf">


                </div>

            </div>


            <!-- TAB: ÁREAS DE TRABAJO -->
            <div id="areas" class="tab-pane fade">

                <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                    <button type="button" class="btn btn-primary" id="btn_nueva_area" data-toggle="modal"
                        title="Crear área"
                        style="border-radius: 50%; width: 30px; height: 30px; padding: 0; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>

                <div class="panel-group" id="accordion_areas">


                </div>

            </div>

            <!-- TAB: TAREAS POR ÁREA -->
            <div id="tareas" class="tab-pane fade">
                <!-- Nav Tabs -->
                <div class="nav-tabs-wrapper" style="overflow-x: auto; overflow-y: hidden; white-space: nowrap;">
                    <ul class="nav nav-tabs" id="nav_tareas" role="tablist"
                        style="display: inline-flex; min-width: 100%;">
                    </ul>
                </div>
                <div class="tab-content" id="tab_content_tareas"></div>

            </div>




            <div id="productos_tarea" class="tab-pane fade">

                <div class="row ">
                    <div class="col-md-10 col-md-offset-1">
                    <div class="col-md-3">
                        <label for="select_area">Selecciona Área</label>
                        <select id="select_area" class="form-control selectpicker" data-live-search="true" data-size="6">
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="select_tarea">Selecciona Tarea</label>
                        <select id="select_tarea" class="form-control selectpicker" data-live-search="true" data-size="6" disabled>
                            <option value="">-- Selecciona primero un área --</option>
                        </select>
                    </div>
                    </div>
                </div>
<br>
                <div class="row" style="display:none;" id="productos_tarea_table_container">
                     <div class="col-md-10 col-md-offset-1">
                        <h4 id="productos_titulo">
                            Productos de la tarea seleccionada
                            <button class="btn btn-primary btn-sm add_producto" id="btnCrearProducto" type="button"
                                style="border-radius: 50%; width: 30px; height: 30px; padding: 0; cursor: pointer; font-size: 16px; justify-content: center;">
                                <i class="fa fa-plus"></i>
                            </button>
                        </h4>

                        <table class="table table-striped table-bordered text-center" id="productos_tarea_table">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Modelo</th>
                                    <th>Precio (€)</th>
                                    <th>Stock</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>





</div>

<!-- DEBUG (Opcional) -->
<!-- <div class="row">
            <div class="col-md-6">
                <h4>$areas_trabajo</h4>
                <pre><?php print_r($areas_trabajo); ?></pre>
            </div>
            <div class="col-md-6">
                <h4>$tareas_por_area</h4>
                <pre><?php print_r($tareas_por_area); ?></pre>
            </div>
        </div> -->
</div>
</div>


<?php $this->load->view('taller_configuraciones/include/modal_conf'); ?>
<?php $this->load->view('taller_configuraciones/include/modal_areas'); ?>
<?php $this->load->view('taller_configuraciones/include/modal_tareas'); ?>
<?php $this->load->view('taller_configuraciones/include/modal_producto'); ?>
<?php $this->load->view('include/Footer'); ?>