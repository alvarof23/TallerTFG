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
        <ul class="breadcrumb bg-light" id="breadcrumb_principal" style="margin: 0; border-radius: 0; padding: 0.75rem 1rem;">
            <li class="breadcrumb-item"><?= anchor('', 'Inicio') ?></li>
            <?php if (isset($page)): ?>
                <li class="breadcrumb-item"><?= anchor($page, $page) ?></li>
            <?php endif; ?>
            <?php if (isset($subpage_cont) && isset($subpage)): ?>
                <li class="breadcrumb-item active"><?= anchor($subpage_cont, $subpage) ?></li>
            <?php elseif (isset($subpage)): ?>
                <li class="breadcrumb-item active"><?= anchor($subpage, $subpage) ?></li>
            <?php endif; ?>
        </ul>
    </div>

<body>

<ul class="panel-controls list-unstyled d-flex justify-content-center align-items-center gap-3 p-3">
        <?php if (isset($icono)): ?>
            <li>
                <h1 class="m-0">
                    <i class="<?= $icono ?>"></i> <?= $page ?>
                </h1>
            </li>
        <?php elseif(isset($subpage)): ?>
            <li>
                <h1 class="m-0"><?= $subpage ?></h1>
            </li>
        <?php endif; ?>
</ul>