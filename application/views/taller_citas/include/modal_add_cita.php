<!-- Modal Ficha Vehículo -->
<div class="modal fade" id="modal_ficha_cita" tabindex="-1" role="dialog" aria-labelledby="modalFichaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal_ficha_cita" role="form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFichaTitulo">Reservar cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formPasoAPaso">
                <div class="modal-body">
                    <div class="form-step active">
                        <div class="form-group row">
                            <!-- Cliente -->
                            <div class="col-md-6 col-sm-12">
                                
                                <input type="hidden" name="id_cita" id="id_cita" value="">
                                <input type="hidden" name="estado" id="estado" value="">

                                <label class="control-label">Cliente</label>
                                <select class="form-control selectpicker" name="id_cliente" id="id_cliente" data-live-search="true" data-size="6" required>
                                    <option value="default" selected disabled>Seleccione un cliente</option>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <option value="<?= $cliente->dni ?>">
                                            <?= $cliente->nombre ?> (<?= $cliente->dni ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Info del cliente justo debajo del select -->
                                <div class="mt-2">
                                    <h5>Datos del cliente:</h5>
                                    <label id="info_nombre_cliente"></label><br>
                                    <label id="info_email_cliente"></label><br>
                                    <label id="info_telefono_cliente"></label>
                                </div>
                            </div>

                            <!-- Matrícula -->
                            <div class="col-md-6 col-sm-12">
                                <label class="control-label">Matrícula</label>
                                <select class="form-control selectpicker" name="id_matricula" id="id_matricula" data-live-search="true" data-size="6" required>
                                    <option value="" selected disabled>
                                        Selecciona un cliente
                                    </option>

                                </select>

                                <!-- Info del vehículo justo debajo de la matrícula -->
                                <div class="mt-2">
                                    <h5>Datos del vehículo:</h5>
                                    <label id="info_marca_vehiculo"></label><br>
                                    <label id="info_modelo_vehiculo"></label><br>
                                    <label id="info_bastidor_vehiculo"></label><br>                 


                                    <input type="hidden" id="info_id_vehiculo" value="">                                
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="form-step">
                        <input type="hidden" name="id_vehiculo" id="id_vehiculo" value="">
                        <div class="form-group col-md-12">
                            <label for="areasTrabajo">¿Qué servicio necesitas?</label>
                            <select class="form-control selectpicker" name="areasTrabajo" data-live-search="true" data-size="6" required>
                                <option value="default" selected disabled>Seleccione una razon de cita</option>
                                <?php foreach ($areasTrabajo as $area): ?>
                                    <option value="<?= $area->id ?>">
                                        <?= $area->descripcion ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="fecha">Selecciona una fecha:</label>
                            <input type="date" id="fecha" name="fecha" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                            <label>Horarios disponibles:</label>
                            <div id="selectorHoras" class="mt-3"></div>
                        </div>

                    </div>

                    <div class="form-step">
                        <div class="form-group col-md-12">
                            <label for="descripcion">¿Alguna cosa que comentar?</label>
                            <textarea name="descripcion" class="form-control textarea-fija" rows="5"></textarea>
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
                    <button type="submit" class="btn btn-success pull-right" id="pedirCita">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
</div>