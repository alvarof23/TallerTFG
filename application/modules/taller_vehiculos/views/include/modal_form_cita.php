<!-- Modal Ficha Vehículo -->
<div class="modal slide-right fade" id="modal_ficha_cita" tabindex="-1" role="dialog" aria-labelledby="modalFichaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFichaLabel">Reservar cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formPasoAPaso">
                <div class="modal-body">
                        <div class="form-step active">
                            <div class="form-group col-md-12">
                                <!-- Aqui pondriamos un if para comprobar que el usuario este logeado o no, si lo esta, este input iria hidden o algo por el estilo -->
                                <div class="col-md-6">
                                    <h5 for="nombre" id="info_princ">Clientes:</h5>
                                        <label for="nombreUsu" id="info_sec"></label>
                                        <br>
                                </div>
                                <div class="col-md-6">
                                    <h5 for="nomCoche" id="info_princ">Coche:</h5>
                                        <label for="nomCocheUsuMarca" id="info_sec"></label>
                                        <br>
                                        <label for="nomCocheUsuModelo" id="info_sec"></label>
                                        <br>
                                        <label for="nomCocheUsuMatricula" id="info_sec"></label>
                                </div>

                            </div>
                        </div>

                        <div class="form-step">
                            <input type="hidden" name="id_vehiculo" id="id_vehiculo" value="">
                            <div class="form-group col-md-12">
                                <label for="areasTrabajo">¿Qué servicio necesitas?</label>
                                <select class="form-control selectpicker" name="areasTrabajo" data-live-search="true" required>
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

                            <div id="calendar_flujo"></div>

                        </div>

                        <!-- <div class="form-step">
                            <div class="form-group col-md-12">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d16949.18435785709!2d-5.918636701083716!3d37.286000791298626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sMcDonalds!5e0!3m2!1ses!2ses!4v1744360852638!5m2!1ses!2ses"
                                    width="350" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div> -->
                        
                </div>
                <div class="modal-footer footer_cita">
                    <button type="button" class="btn btn-primary btn-prev ms-2" title="Anterior" id="boton_vehiculos">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-next ms-2" title="Siguiente" id="boton_vehiculos">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-success pull-right" id="pedirCita">Finalizar</button>
                </div>

            </form>
        </div>
    </div>
</div>