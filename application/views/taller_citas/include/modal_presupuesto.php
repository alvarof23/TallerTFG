<div class="modal fade" id="modalPresupuesto" tabindex="-1" role="dialog" aria-labelledby="modalPresupuestoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-centered custom-modal-dialog" role="document">
        <div class="modal-content custom-modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title" id="modalPresupuestoLabel">¿Que desea hacer con el documento?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p class="lead">Elige una opción:</p>
                <button type="button" class="btn btn-primary m-1" id="crearPresupuesto" data-id="<?= $cita->id ?>"
                    data-id_tarea="<?= $cita->id_tarea ?>"><i class="fa-light fa-pen-to-square"></i>
                    <i class="fa fa-edit"></i> Crear</button>

                <button type="button" class="btn btn-secondary m-1" id="editarPresupuesto">
                    <i class="fa fa-edit"></i> Editar
                </button>


                <button type="button" class="btn btn-danger m-1" id="delPresupuesto">
                    <i class="fa-solid fa-trash"></i> Eliminar</button>

                <button type="button" class="btn btn-primary m-1" id="ver_pdf" data-id="<?= $cita->id ?>"
                    data-id_cliente="<?= $cita->dni ?>" data-id_vehiculo="<?= $cita->id_vehiculo ?>"
                    data-estado="<?= $cita->estado ?>" data-observaciones="<?= $cita->observaciones ?>"
                    data-fecha="<?= $cita->fecha ?>" data-hora="<?= $cita->hora ?>"
                    data-id_tarea="<?= $cita->id_tarea ?>"><i class="fa-light fa-pen-to-square"></i>
                    <i class="fa fa-edit"></i> Ver pdf</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar productos del presupuesto -->
<div class="modal fade" id="modalSeleccionProductos" tabindex="-1" role="dialog" aria-labelledby="modalProductosLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProductosLabel">Seleccionar Productos para el Presupuesto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí iría la tabla o lista de productos -->
                <form id="formSeleccionProductos">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Cantidad</th>
                                    <th>Producto</th>
                                    <th>Marca</th>
                                    <th>Precio (€)</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-productos-body">
                                <!-- Aquí se insertarán las filas con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="guardarPresupuesto">Guardar Presupuesto</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>