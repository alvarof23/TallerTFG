<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control | Gestión de Vehículos</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Select compatible con Bootstrap 3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/91a053dd8d.js" crossorigin="anonymous"></script>

    <!-- Dropzone -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">

    <!-- Intro.js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.0.1/introjs.min.css" rel="stylesheet">

    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    
<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<style>
    .navbar-collapse > .nav > li > a, .navbar-brand{
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .navbar-collapse > .nav > li > a:hover, .navbar-brand:hover, .open > #desplegable {
        transform: scale(1.25);
        text-decoration: none;
    }

    .open > #desplegable {
        background-color: transparent !important;
        color: #ffffff !important;
        box-shadow: none !important;
    }

    @media (max-width: 768px) {
        .navbar-collapse > .nav > li > a, .navbar-brand{
        transition: none !important;
        }

        .navbar-collapse > .nav > li > a:hover, .navbar-brand:hover, .open > #desplegable {
            transform: none !important;
            text-decoration: none;
        }
    }

    @media (max-width: 768px) {
    .navbar-collapse {
        text-align: center;
    }

    /* Los <ul> del menú */
    .navbar-collapse > .nav {
        float: none !important;
        display: block;
        margin: 0 auto;
    }

    /* Los items del menú */
    .navbar-collapse > .nav > li {
        float: none !important;
        display: block;
        margin: 0 auto;
    }

    /* Los enlaces centrados */
    .navbar-collapse > .nav > li > a {
        text-align: center;
        display: block;
    }

    /* Para el dropdown (navbar-right) */
    .navbar-nav.navbar-right {
        float: none !important;
        display: block;
        margin: 0 auto;
    }

    /* Estado cerrado: caret sin rotación */
    a.dropdown-toggle > .caret {
        transition: transform 0.3s ease;
        transform: rotate(0deg);
    }

    /* Estado abierto: caret girada 180 grados */
    li.dropdown.open > a.dropdown-toggle > .caret {
        transform: rotate(180deg);
    }

    /* Quitar la flecha (triángulo) que aparece sobre el dropdown-menu */
    .dropdown-menu:before,
    .dropdown-menu:after {
        display: none !important;
        content: none !important;
        border: none !important;
    }



</style>

<?php if (isset($css)) echo $css; ?>

</head>

    <div class="navigation-container">
        <nav class="navbar navbar-inverse" role="navigation" style="margin-bottom: 0; padding: 1rem; background-color: #003366; border-color: #002244; border-radius: 0px;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" 
                            data-toggle="collapse" data-target="#navbarNav">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar" style="background-color: #ffffff;"></span>
                        <span class="icon-bar" style="background-color: #ffffff;"></span>
                        <span class="icon-bar" style="background-color: #ffffff;"></span>
                    </button>
                    <a class="navbar-brand text-white" href="<?= base_url('taller') ?>" style="font-size: 1.8rem; font-weight: bold; color: #ffffff;">Gestión de Taller</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbarNav" style="cursor: default;">
                    <ul class="nav navbar-nav">
                        <li><a href="<?= base_url('clientes') ?>" style="color: #ffffff;">Clientes</a></li>
                        <li><a href="<?= base_url('vehiculos') ?>" style="color: #ffffff;">Vehículos</a></li>
                        <li><a href="<?= base_url('citas') ?>" style="color: #ffffff;">Citas</a></li>
                    
                    </ul>
                    
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" id="desplegable" style="color: #ffffff;">Opciones <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu" style="background-color: #f8f9fa; border-color: #cccccc;">
                                <?php if($acceso[0] != 0): ?>
                                    <li><a href="<?= base_url('usuarios') ?>" style="color: #003366;"><span>Usuarios</span></a></li>
                                    <li><a href="<?= base_url('configuraciones') ?>" style="color: #003366;"><span>Configuracion</span></a></li>
                                <?php endif; ?>
                                <li><a href="<?= base_url('contacto') ?>" style="color: #003366;"><span>Ponte en contacto</span></a></li>
                                <li><a href="<?= base_url('usuario/logout') ?>" style="color: #003366;"><span>Logout</span></a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>



    <body>
        <div>
            <!-- Alerta de citas pendientes -->
            <?php if ($citas_pendientes > 0): ?>
                <div class="alert alert-warning">
                    <strong>Atención:</strong> Tienes <?= $citas_pendientes ?> citas sin recepcionar.
                    <?php if ($citas_hoy): ?>De las cuales <?= $citas_hoy ?> es para hoy. <?php endif; ?>
                    <div class="pull-right">
                        <a href="<?= site_url('citas?estado=Esperando_recepcion') ?>" class="btn btn-sm btn-primary">Ver</a>

                        <!-- cerrar -->
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <div class="jumbotron text-center">
                <h1>Bienvenido <?= $usuario_nombre ?></h1>
                <p class="lead">Gestiona citas, vehículos, clientes y mucho más desde un solo lugar.</p>
            </div>




            <div class="col-md-8">
                <!-- Dashboard de estadísticas -->
                <div class="row text-center">
                    <div class="col-sm-4">
                        <div class="dashboard-box well">
                            <h3><i class="fa fa-calendar-check-o"></i> Citas de hoy</h3>
                            <p><?= $citas_hoy ?> citas programadas</p>
                            <a href="<?= site_url('citas') ?>" class="btn btn-primary">Ver citas</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dashboard-box well">
                            <h3><i class="fa fa-wrench"></i> Vehículos en taller</h3>
                            <p><?= $vehiculos_taller ?> vehículos en reparación</p>
                            <a href="<?= site_url('vehiculos') ?>" class="btn btn-info">Ver vehículos</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dashboard-box well">
                            <h3><i class="fa fa-users"></i> Clientes registrados</h3>
                            <p><?= $clientes_registrados ?> clientes activos</p>
                            <a href="<?= site_url('clientes') ?>" class="btn btn-success">Ver clientes</a>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 30px; display: flex; justify-content: center; text-align: center;">
                    <div class="col-sm-4">
                        <div class="dashboard-box well">
                            <h3><i class="fa fa-plus-circle"></i> Crear nueva cita</h3>
                            <p>Registra una nueva cita</p>
                            <a href="<?= site_url('citas?nueva=1') ?>" class="btn btn-warning">Nueva cita</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dashboard-box well">
                            <h3><i class="fa fa-car"></i> Registrar vehículo</h3>
                            <p>Añade un nuevo vehículo</p>
                            <a href="<?= site_url('vehiculos?nueva=1') ?>" class="btn btn-default">Nuevo vehículo</a>
                        </div>
                    </div>
                </div>
                <!-- <div class="row text-center" style="margin-top: 30px;">
                    <div class="col-sm-4 col-sm-offset-2">
                        <div class="dashboard-box well">
                            <h3><i class="fa fa-plus-circle"></i> Crear nueva cita</h3>
                            <p>Registra una nueva cita para un cliente</p>
                            <a href="<?= site_url('citas?nueva=1') ?>" class="btn btn-warning">Nueva cita</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dashboard-box well">
                            <h3><i class="fa fa-car"></i> Registrar vehículo</h3>
                            <p>Añade un nuevo vehículo</p>
                            <a href="<?= site_url('vehiculos?nueva=1') ?>" class="btn btn-default">Nuevo vehículo</a>
                        </div>
                    </div>
                </div> -->


            </div>
            <div class="col-md-4 pull-right">
                <!-- Próximas citas -->
                <div class="row">
                    <div class="panel panel-primary shadow-sm">
                        <div class="panel-heading text-center">
                            <h4 style="color: white;"><strong>Citas de hoy</strong></h4>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <?php if (!empty($citas_actuales)): ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Hora</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Vehículo</th>
                                                <th scope="col">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($citas_actuales as $cita): ?>
                                                <tr>
                                                    <td><?= $cita->hora ?></td>
                                                    <td><?= $cita->nombre ?></td>
                                                    <td><?= $cita->matricula ?></td>
                                                    <td><span class="badge badge-primary badge-pill"><?= $cita->estado ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <li class="list-group-item text-center text-muted">No hay citas próximas para hoy.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="<?= site_url('citas') ?>" class="btn btn-sm btn-primary">
                                <i class="fa fa-calendar"></i> Ver todas
                            </a>
                        </div>
                    </div>

                    <div class="panel panel-primary shadow-sm">
                        <div class="panel-heading text-center">
                            <h4 style="color: white;"><strong>Citas de mañana</strong></h4>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <?php if (!empty($proximas_citas)): ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Hora</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Vehículo</th>
                                                <th scope="col">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($proximas_citas as $cita): ?>
                                                <tr>
                                                    <td><?= $cita->hora ?></td>
                                                    <td><?= $cita->nombre ?></td>
                                                    <td><?= $cita->matricula ?></td>
                                                    <td><span class="badge badge-primary badge-pill"><?= $cita->estado ?></span>
                                                    </td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <li class="list-group-item text-center text-muted">No hay citas próximas para hoy.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="<?= site_url('citas') ?>" class="btn btn-sm btn-primary">
                                <i class="fa fa-calendar"></i> Ver todas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('include/Footer'); ?>