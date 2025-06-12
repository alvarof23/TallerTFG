<?php $this->load->view('include/Header'); ?>

<!-- Botones superiores -->
<ul class="panel-controls list-unstyled d-flex justify-content-center align-items-center gap-3 p-3">

    <li>
        <button type="button" class="btn btn-primary activarModal" data-toggle="modal" title="Crear vehiculo"
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
                <?php $this->load->view('taller_clientes/include/filtro'); ?>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center" style="margin-top: 20px; width: 100%;">

            <div class="col-md-11 table-responsive m-top-10">
                <?php if (isset($clientes) && $clientes != 0): ?>
                    <table class="table table-striped tabla_clientes" id="tablaclientes">
                        <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Correo Electrónico</th>
                                <th></th>
                            </tr>
                        </thead>

                        <?php $this->load->view('taller_clientes/include/tabla_cuerpo'); ?>
                    </table>
                <?php else: ?>
                    <div role="alert" class="alert alert-warning">
                        <button data-dismiss="alert" class="close" type="button"><span>x</span><span
                                class="sr-only">Cerrar</span></button>
                        <strong><i class="fa fa-warning"></i></strong> Esta sección no tiene datos para mostrar.
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<!-- Modales -->
<?php $this->load->view('taller_clientes/include/modal_form'); ?>

<?php $this->load->view('include/Footer'); ?>