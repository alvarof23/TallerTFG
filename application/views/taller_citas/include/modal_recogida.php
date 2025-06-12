<!-- Modal Ficha Vehículo -->
<div class="modal fade" id="modal_recogida" tabindex="-1" role="dialog" aria-labelledby="modalFichaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal_recogida" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recepción de vehículo - Cita ID <?= $cita->id ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formPasoAPaso" enctype="multipart/form-data" method="POST">
                <div class="modal-body">

                    <!-- PASO 1 -->
                     <div class="form-step active">
                        <input type="hidden" id="cita_id" value="<?= $cita->id ?>">

                        <div class="row">
                            <!-- Imagen coche -->
                            <div class="col-xs-12 col-sm-12 col-md-6 ">
                                <div class="car-impact-container" style="margin: 20px;">
                                    <img src="http://localhost/Taller/assets/img/taller/golpe/cocheGolpe.jpg" alt="Esquema coche" class="img-fluid" style="width: 100%; height: auto;">

                                    <!-- Zonas de impacto (checkboxes) -->
                                    <label class="zona-impacto" style="top: 50%; left: 55%;">
                                        <input type="checkbox" name="impacto_Techo" class="checkbox-impacto" data-target="input_Techo" value="Techo">
                                    </label>


                                    <label class="zona-impacto" style="top: 100%; left: 25%;">
                                        <input type="checkbox" name="impacto_Aleta_Delante_Izquierda" class="checkbox-impacto" data-target="input_Aleta_Delante_Izquierda" value="Aleta_Delante_Izquierda">
                                    </label>
                                    <label class="zona-impacto" style="top: 100%; left: 45%;">
                                        <input type="checkbox" name="impacto_Puerta_Delante_Izquierda" class="checkbox-impacto" data-target="input_Puerta_Delante_Izquierda" value="Puerta_Delante_Izquierda">
                                    </label>
                                    <label class="zona-impacto" style="top: 100%; left: 65%;">
                                        <input type="checkbox" name="impacto_Puerta_Detras_Izquierda" class="checkbox-impacto" data-target="input_Puerta_Detras_Izquierda" value="Puerta_Detras_Izquierda">
                                    </label>
                                    <label class="zona-impacto" style="top: 100%; left: 85%;">
                                        <input type="checkbox" name="impacto_Aleta_Detras_Izquierda" class="checkbox-impacto" data-target="input_Aleta_Detras_Izquierda" value="Aleta_Detras_Izquierda">
                                    </label>


                                    <label class="zona-impacto" style="top: 50%; left: -3%;">
                                        <input type="checkbox" name="impacto_Frontal" class="checkbox-impacto" data-target="input_Frontal" value="Frontal">
                                    </label>
                                    <label class="zona-impacto" style="top: 50%; left: 17%;">
                                        <input type="checkbox" name="impacto_Capo" class="checkbox-impacto" data-target="input_Capo" value="Capo">
                                    </label>
                                    <label class="zona-impacto" style="top: 50%; left: 35%;">
                                        <input type="checkbox" name="impacto_Luna_Delantera" class="checkbox-impacto" data-target="input_Luna_Delantera" value="Luna_Delantera">
                                    </label>


                                    <label class="zona-impacto" style="top: 50%; right: -10%;">
                                        <input type="checkbox" name="impacto_Trasero" class="checkbox-impacto" data-target="input_Trasero" value="Trasero">
                                    </label>
                                    <label class="zona-impacto" style="top: 50%; right: 4%;">
                                        <input type="checkbox" name="impacto_Maletero" class="checkbox-impacto" data-target="input_Maletero" value="Maletero">
                                    </label>
                                    <label class="zona-impacto" style="top: 50%; right: 15%;">
                                        <input type="checkbox" name="impacto_Luna_Trasera" class="checkbox-impacto" data-target="input_Luna_Trasera" value="Luna_Trasera">
                                    </label>


                                    <label class="zona-impacto" style="top: 0%; left: 25%;">
                                        <input type="checkbox" name="impacto_Aleta_Delante_Derecha" class="checkbox-impacto" data-target="input_Aleta_Delante_Derecha" value="Aleta_Delante_Derecha">
                                    </label>
                                    <label class="zona-impacto" style="top: 0%; left: 45%;">
                                        <input type="checkbox" name="impacto_Puerta_Delante_Derecha" class="checkbox-impacto" data-target="input_Puerta_Delante_Derecha" value="Puerta_Delante_Derecha">
                                    </label>
                                    <label class="zona-impacto" style="top: 0%; left: 65%;">
                                        <input type="checkbox" name="impacto_Puerta_Detras_Derecha" class="checkbox-impacto" data-target="input_Puerta_Detras_Derecha" value="Puerta_Detras_Derecha">
                                    </label>
                                    <label class="zona-impacto" style="top: 0%; left: 85%;">
                                        <input type="checkbox" name="impacto_Aleta_Detras_Derecha" class="checkbox-impacto" data-target="input_Aleta_Detras_Derecha" value="Aleta_Detras_Derecha">
                                    </label>
                                </div>
                            </div>
                            <div id="contenedorInputsImpacto_Arriba" class="col-md-3 col-xs-12 pull-right">
                                <h5>Por arriba</h5>
                                <table class="table table-bordered tabla_impactos">
                                    <thead>
                                        <tr>
                                            <th>Parte</th>
                                            <th>Imagen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div id="contenedorInputsImpacto_Lateral_Izquierdo" class="col-md-3">
                                <h5>Por la izquierda</h5>
                                <table class="table table-bordered tabla_impactos">
                                    <thead>
                                        <tr>
                                            <th>Parte</th>
                                            <th>Imagen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div id="contenedorInputsImpacto_Lateral_Derecho" class="col-md-3">
                                <h5>Por la derecha</h5>
                                <table class="table table-bordered tabla_impactos">
                                    <thead>
                                        <tr>
                                            <th>Parte</th>
                                            <th>Imagen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div id="contenedorInputsImpacto_Delante" class="col-md-3">
                                <h5>Por delante</h5>
                                <table class="table table-bordered tabla_impactos">
                                    <thead>
                                        <tr>
                                            <th>Parte</th>
                                            <th>Imagen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div id="contenedorInputsImpacto_Detras" class="col-md-3">
                                <h5>Por detras</h5>
                                <table class="table table-bordered tabla_impactos">
                                    <thead>
                                        <tr>
                                            <th>Parte</th>
                                            <th>Imagen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    </div>

                    <!-- PASO 2 -->
                    <div class="form-step">

                        <!-- Observaciones del cliente -->
                        <div class="form-group">
                            <label for="observaciones_cliente" class="form-label">Observaciones del cliente</label>
                            <textarea class="form-control" name="observaciones_cliente" id="observaciones_cliente" rows="4"></textarea>
                        </div>

                        <!-- Combustible y Kilometraje -->
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-6">
                                <label for="combustible" class="form-label">Nivel de combustible</label>
                                <select class="form-control selectpicker" name="combustible" id="combustible" required>
                                    <option disabled>Desconocido</option>
                                    <option>Vacío</option>
                                    <option>1/4</option>
                                    <option>1/2</option>
                                    <option>3/4</option>
                                    <option>Lleno</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="kilometros" class="form-label">Kilometraje</label>
                                <input type="number" class="form-control" name="kilometros" id="kilometros" placeholder="Ej: 152000" required>
                            </div>
                        </div>

                        <!-- Firma y confirmación -->
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label d-block">Firma del cliente</label>
                                <div class="text-center">
                                    <canvas id="firmaCanvas" width="600" height="300" style="border:1px solid #ccc;" class="mb-3"></canvas>
                                    <input type="hidden" name="firma_base64" id="firmaBase64"><br>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="limpiarFirma()">Limpiar Firma</button>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12 d-flex align-items-center">
                                <div class="form-check">                
                                    <label class="form-check-label" for="confirmacion_cliente">
                                        <input class="form-check-input me-2" type="checkbox" name="confirmacion_cliente" id="confirmacion_cliente" required>
                                        El cliente ha confirmado la recepción y revisado el estado del vehículo.
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer footer_cita">
                    <button type="button" class="btn btn-primary btn-prev ms-2" title="Anterior" id="boton_citas">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-next ms-2" title="Siguiente" id="boton_citas">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-success pull-right" data-cita-id="<?= $cita->id ?>" id="pedirRecepcion">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('taller_citas/include/modal_confirmacion_img'); ?>
<?php $this->load->view('taller_citas/include/modal_imagen'); ?>
