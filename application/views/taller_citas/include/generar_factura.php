<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

    <style>
        @page {
            margin-top: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            padding: 0;
            box-sizing: border-box;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        .panel-heading {
            font-weight: bold;
            background-color: #f5f5f5 !important;
            font-size: 13px;
        }

        .signature {
            margin: 0px;
        }

        .signature p {
            margin-bottom: 0px;
        }

        .page-break {
            page-break-after: always;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%; /* Esto es clave para que el centrado funcione */
            text-align: center;
            font-size: 10px;
            left: 0;
            width: 100%;
            margin-bottom: 10px;
        }


        /*.footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            text-align: center;
            font-size: 10px;
            color: grey;
        }*/

        .container-row {
            overflow: hidden;
        }

        .col-half {
            float: left;
            width: 50%;
        }

        .col-left {
            float: left;
            width: 30%;
        }

        .col-right {
            float: right;
            width: 70%;
        }


        .tabla_danos th,
        .tabla_danos td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: middle;
        }


        .row {
            display: flex;
            align-items: stretch;
            gap: 20px;
            margin-left:0px; 
            margin-right:0px;
        }

        .col-half {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .panel {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .panel-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-top: 15px;
        }
        .panel-default {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        }


        .factura-box {
            font-family: Arial, sans-serif;
            font-size: 11px;
            width: 100%;
            margin: auto;
            border: 1px solid #333;
            padding: 10px;
        }
        .factura-box table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .factura-box th, .factura-box td {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
        }
        .factura-header td {
            border: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .no-border {
            border: none !important;
        }

        h2 {
            margin-top:40px; 
            margin-bottom: 30px;
            font-weight: bold; 
            font-size: 20px;
        }
    </style>
</head>

<body>


    <div class="text-center">
        <table width="100%" cellpadding="10">
            <tr>
                <td width="50%">
                    <img src="<?= base_url($empresa['logo']) ?>" alt="Imagen zona <?= $foto->parte ?>" style="height: 110px;">

                </td>
                <td width="50%">
                    <h1><?= $empresa['nombre'] ?></h1>
                    <p style="color:black; font-size:11px;">
                        Teléfono: <b><?= $empresa['telefono'] ?></b><br>
                        Horario: <b><?= $empresa['horario'] ?></b><br>
                        Email: <b><?= $empresa['email'] ?></b><br>
                        Dirección: <b><?= $empresa['direccion'] ?></b><br>
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <!-- DATOS VEHÍCULO Y CLIENTE EN LA MISMA FILA -->
    <div class="container-row">
        <div class="col-half">
            <div class="panel panel-default">
                <div class="panel-heading">Datos del Vehículo</div>
                <div class="panel-body">
                    Marca: <?= $vehiculo['marca'] ?><br>
                    Modelo: <?= $vehiculo['modelo'] ?><br>
                    Matrícula: <?= $vehiculo['matricula'] ?><br>
                    Kilometraje: <?= $vehiculo['kilometraje'] ?><br>
                    VIN/Nº Bastidor: <?= $vehiculo['bastidor'] ?><br>
                    Nivel Depósito: <?= $vehiculo['kilometraje'] ?><br>
                    Fecha de entrega: <?= $fecha ?>

                </div>
            </div>
        </div>

        <div class="col-half">
            <div class="panel panel-default">
                <div class="panel-heading">Datos del Cliente</div>
                <div class="panel-body">
                    <div>
                        NIF/CIF: <?= $cliente['dni'] ?><br>
                        Nombre: <?= $cliente['nombre'] ?> <?= $cliente['apellidos'] ?><br>
                        Dirección: <?= $cliente['direccion'] ?><br>
                        Teléfono: <?= $cliente['telefono'] ?><br>
                        Email: <?= $cliente['email'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">Informe de Daños del Vehículo</div>
            <div class="panel-body" style="display: flex; align-items: flex-start; gap: 20px;">
                <div style="flex: 0 0 160px;"></div>
                    <div class="col-left"  style="margin-top: 10px;">
                        <img src="http://localhost/Taller/assets/img/taller/golpe/cocheGolpe.jpg" alt="Esquema coche" class="img-fluid">
                    </div>
                    <div class="col-right">
                        <?php if (!empty($danos)): ?>
                            <table class="table" style="margin-left: 15px;">
                                <tbody>
                                    <?php 
                                    $count = 0;
                                    foreach ($danos as $foto): 
                                        if ($count % 2 == 0) echo '<tr>';
                                    ?>
                                        <td> <li>Zona <?= $foto->parte ?></li> </td>
                                    <?php 
                                        if ($count % 2 == 1) echo '</tr>';
                                        $count++;
                                    endforeach;

                                    if ($count % 2 == 1) echo '<td></td></tr>';
                                    ?>
                                </tbody>
                            </table>
                    </div>   
                </div>

                    <p style="color: grey">Para ver las imagenes asociadas consultar el ANEXO Registro Fotográfico de Daños</p>

                        <?php else: ?>
                    </div>
                </div>

                            <p style="color: grey">No se detectaron daños en el vehículo.</p>
                        <?php endif; ?>
            </div>
        </div>
    
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Servicios Solicitados</div>
            <div class="panel-body">
                <ul>
                    <?php foreach ($servicios as $servicio): ?>
                        <li><?= $servicio['area'] ?>: <?= $servicio['tarea'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Observaciones del Taller</div>
        <div class="panel-body">
            <?= $observaciones ? $observaciones : 'Vehículo entregado sin objetos personales visibles. Se informa al cliente del tiempo estimado de reparación.' ?>
        </div>
    </div>

    <div class="container-row">
        <div class="row">
            <div class="col-half">
                <div class="panel panel-default">
                    <div class="panel-body text-center signature">
                        <p><strong>Firma del Taller:</strong></p>
                            <?php if ($firma_usuario): ?>
                                <img src="<?= $firma_usuario ?>" alt="" height="94px" style="display: block; margin: 0 auto;">
                                <div class="line center-block"
                                    style="border-top: 1px solid #000; width: 250px; margin: 0 auto;"></div>
                            <?php else: ?>
                                <div class="line" style="margin: 94px auto 0; border-top: 1px solid #000; width: 250px;"></div>

                            <?php endif; ?>

                        <p><i>Taller: <?= $usuario_nombre ?></i></p>
                    </div>
                </div>
            </div>
            <div class="col-half">
                <div class="panel panel-default">
                    <div class="panel-body text-center signature">
                        <p><strong>Firma del Cliente:</strong></p>
                        <?php if ($firma): ?>
                            <img src="<?= $firma ?>" alt="" height="94px" style="display: block; margin: 0 auto;">
                            <div class="line center-block"
                                style="border-top: 1px solid #000; width: 250px; margin: 0 auto;"></div>
                        <?php else: ?>
                            <div class="line" style="margin: 94px auto 0; border-top: 1px solid #000; width: 250px;"></div>

                        <?php endif; ?>
                        <p><i>Nombre: <?= $cliente['nombre'] ?></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p><?= $empresa['nombre'] ?> - <?= $empresa['direccion'] ?>, <?= $empresa['codigo_postal'] ?>
            <?= $empresa['provincia'] ?> (<?= $empresa['pais'] ?>) | <?= $empresa['email'] ?> | CIF:
            <?= $empresa['nif'] ?> | tel. <?= $empresa['telefono'] ?></p>
    </div>
    

    <div class="page-break"></div>

    <h2 class="text-center">ANEXO 1 - Términos Legales y Condiciones de Pago</h2>

    <div class="panel panel-default">
        <div class="panel-heading">Términos y Condiciones Legales</div>
            <div class="panel-body">
                <ol style="padding-left: 15px;">

                <!-- Términos Legales -->
                    <li><strong>Objetos personales:</strong> El taller no se hace responsable de los objetos personales que puedan quedar en el interior del vehículo.</li>

                    <li><strong>Responsabilidad durante la intervención:</strong> El cliente acepta que el taller no se hace responsable de daños que puedan surgir durante la reparación, prueba, entrega o recogida del vehículo, siempre que se actúe con la diligencia profesional correspondiente.</li>

                    <li><strong>Autorización de intervención:</strong> El cliente autoriza al taller a realizar los trabajos indicados en la orden de reparación y a efectuar las pruebas necesarias para verificar su correcto funcionamiento.</li>

                    <li><strong>Presupuestos y trabajos adicionales:</strong> En caso de detectarse averías no presupuestadas, el taller se compromete a informar al cliente y solicitar su autorización antes de proceder.</li>

                    <li><strong>Plazos de entrega:</strong> Son estimados y están sujetos a la disponibilidad de repuestos y la naturaleza de la reparación. El taller no se responsabiliza de retrasos por causas ajenas.</li>

                    <li><strong>Piezas sustituidas:</strong> El cliente podrá solicitar las piezas sustituidas, salvo que estén cubiertas por garantía o deban ser devueltas al fabricante.</li>

                    <li><strong>Garantía de reparación:</strong> Las reparaciones están garantizadas durante 3 meses o 2.000 km (lo que antes ocurra), conforme a la normativa vigente. Esta garantía cubre únicamente la reparación efectuada.</li>

                    <li><strong>Derecho de retención:</strong> El taller podrá retener el vehículo hasta que se haya abonado la totalidad del importe de la reparación.</li>

                    <li><strong>Protección de datos:</strong> Los datos personales facilitados serán tratados conforme al Reglamento General de Protección de Datos (RGPD) y utilizados exclusivamente para la gestión del servicio.</li>
                </ol>
            </div>
            
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Términos y Condiciones Legales</div>
            <div class="panel-body">
                <ol style="padding-left: 15px;">
                    <li><strong>Importe de la reparación:</strong> El cliente se compromete a abonar el importe total presupuestado o autorizado por los servicios realizados en el vehículo.</li>

                    <li><strong>Formas de pago:</strong> El pago podrá realizarse en efectivo, con tarjeta bancaria u otros medios previamente aceptados por el taller.</li>

                    <li><strong>Pago anticipado:</strong> En algunos casos, el taller podrá requerir un anticipo del coste estimado para comenzar con la reparación.</li>

                    <li><strong>Emisión de factura:</strong> Una vez finalizado el servicio, el taller emitirá la correspondiente factura detallando los conceptos facturados.</li>

                    <li><strong>Plazo de pago:</strong> El cliente se compromete a realizar el pago inmediatamente tras la entrega del vehículo, salvo pacto escrito diferente.</li>

                    <li><strong>Intereses de demora:</strong> En caso de impago dentro del plazo acordado, podrán aplicarse intereses de demora conforme a la normativa vigente.</li>

                    <li><strong>Derecho de retención:</strong> Hasta que no se haya satisfecho el importe total de la reparación, el taller podrá ejercer su derecho de retención sobre el vehículo conforme al artículo 1.600 del Código Civil.</li>

                    <li><strong>Autorización de cargo:</strong> En caso de que el pago se efectúe mediante domiciliación bancaria, el cliente autoriza al taller a cargar el importe correspondiente en la cuenta indicada previamente.</li>

                    <li><strong>Renuncia a reclamación:</strong> Salvo prueba en contrario, una vez abonado el importe, se considerará aceptado el trabajo realizado.</li>

                    <li><strong>Aceptación:</strong> Con la firma de este documento, el/la cliente manifiesta su conformidad con los términos aquí recogidos.</li>
                </ol>
            </div>
            
        </div>

    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Aceptación de Términos y Condiciones Legales</strong></div>
            <div class="panel-body">
                <table style="width: 100%;; line-height: 1.6;">
                    <tr>
                        <td><strong>Fecha: </strong> <?= date('d/m/Y') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nombre: </strong><?= $cliente['nombre'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>DNI/NIF: </strong><?= $cliente['dni'] ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        
                        <td><strong>Firma del Cliente:</strong></td>
                        <td>___________________________</td>

                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="footer">
        <p><?= $empresa['nombre'] ?> - <?= $empresa['direccion'] ?>, <?= $empresa['codigo_postal'] ?>
            <?= $empresa['provincia'] ?> (<?= $empresa['pais'] ?>) | <?= $empresa['email'] ?> | CIF:
            <?= $empresa['nif'] ?> | tel. <?= $empresa['telefono'] ?></p>
    </div>

    <?php $n_anexo = 2 ?>

<?php if($presupuesto != 0 and $presupuesto != null): ?>

    <div class="page-break"></div>

    <div class="text-center">
        <h2>ANEXO <?= $n_anexo ?> - Factura de la recepción</h2>
        <?php $n_anexo++ ?>
        <div class="factura-box">
            <table class="factura-header">
                <thead>
                    <tr >
                        <td>
                            <h2><strong><?= $empresa['nombre'] ?></strong><br></h2>
                        </td>
                        <td>
                            <h4><strong><?= $cliente['nombre'] . ' ' . $cliente['apellidos'] ?></strong><br></h4>   
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= $empresa['direccion'] ?><br>
                            NIF: <?= $empresa['nif'] ?><br>
                            Teléfono: <?= $empresa['telefono'] ?><br>
                            Email: <?= $empresa['email'] ?>
                        </td>
                        <td class="text-right">
                            <?= $cliente['direccion'] ?><br>
                            NIF: <?= $cliente['dni'] ?><br>
                            Teléfono: <?= $cliente['telefono'] ?><br>
                            Email: <?= $cliente['email'] ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table>
                <tr>
                    <td><strong>Fecha del presupuesto:</strong> <?= $presupuesto['order']->fecha_creacion ?></td>
                    <td><strong>Validez:</strong> 30 días</td>
                </tr>
            </table>

            <br>

            <?php
            $base = $presupuesto['order']->total - $presupuesto['order']->total_descuento;
            $iva = $base * 0.21;
            $suma_total = $base + $iva;
            ?>

            <table>
                <thead>
                    <tr>
                        <th align="center">DESCRIPCIÓN</th>
                        <th align="center">UNIDADES</th>
                        <th align="center">PRECIO</th>
                        <th align="center">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($presupuesto['items'] as $item): ?>
                        <?php $total_item = $item->precio * $item->cantidad; ?>
                        <tr>
                            <td><?= $item->nombre ?> <?= $item->descripcion ?></td>
                            <td align="center"><?= number_format($item->cantidad) ?></td>
                            <td align="right"><?= number_format($item->precio, 2) ?> €</td>
                            <td align="right"><?= number_format($total_item, 2) ?> €</td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="3"><strong>SUB-TOTAL</strong></td>
                        <td align="right"><?= number_format($presupuesto['order']->total, 2) ?> €</td>
                    </tr>

                    <?php if ($presupuesto['order']->total_descuento > 0): ?>
                        <tr>
                            <td colspan="3"><strong>DESCUENTO</strong></td>
                            <td align="right">-<?= number_format($presupuesto['order']->total_descuento, 2) ?> €</td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td colspan="3"><strong>IVA 21%</strong></td>
                        <td align="right"><?= number_format($iva, 2) ?> €</td>
                    </tr>

                    <tr style="border: none;"><td colspan="4" style="height: 20px;"></td></tr>

                    <tr>
                        <td colspan="3"><strong>TOTAL PRESUPUESTADO</strong></td>
                        <td align="right"><strong><?= number_format($suma_total, 2) ?> €</strong></td>
                    </tr>
                </tbody>
            </table>


            <br><br>

            <div class="container-row">
                <div class="row">
                    <div class="col-half">
                        <div class="panel panel-default">
                            <div class="panel-body text-center signature">
                                <p><strong>Firma del Taller:</strong></p>
                                    <?php if ($firma_usuario): ?>
                                        <img src="<?= $firma_usuario ?>" alt="" height="94px" style="display: block; margin: 0 auto;">
                                        <div class="line center-block"
                                            style="border-top: 1px solid #000; width: 250px; margin: 0 auto;"></div>
                                    <?php else: ?>
                                        <div class="line" style="margin: 94px auto 0; border-top: 1px solid #000; width: 250px;"></div>

                                    <?php endif; ?>

                                <p><i>Taller: <?= $usuario_nombre ?></i></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-half">
                        <div class="panel panel-default">
                            <div class="panel-body text-center signature">
                                <p><strong>Firma del Cliente:</strong></p>
                                    <div class="line" style="margin: 94px auto 0; border-top: 1px solid #000; width: 250px;"></div>
                                <p><i>Nombre: <?= $cliente['nombre'] ?></i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



        <div class="footer">
            <p><?= $empresa['nombre'] ?> - <?= $empresa['direccion'] ?>, <?= $empresa['codigo_postal'] ?>
                <?= $empresa['provincia'] ?> (<?= $empresa['pais'] ?>) | <?= $empresa['email'] ?> | CIF:
                <?= $empresa['nif'] ?> | tel. <?= $empresa['telefono'] ?></p>
        </div>

<?php endif ?>

    <?php if (!empty($danos)): ?>
            <div class="page-break"></div>

    <h2 class="text-center">ANEXO <?= $n_anexo ?> - Registro Fotográfico de Daños</h2>
    <?php $n_anexo++ ?>

    <div style="font-family: Arial, sans-serif;">
        <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <tr>
                <?php
                $count = 0;
                foreach ($danos as $foto):
                    if ($foto->parte === 'firma_cliente') continue;

                    // Abrir nueva fila cada 3 elementos
                    if ($count > 0 && $count % 3 == 0): ?>
                        </tr><tr>
                    <?php endif; ?>

                    <td align="center" valign="top" style="
                        border: 1px solid #999;
                        padding: 10px;
                        width: 33.3%;
                    ">
                        <img src="<?= base_url($foto->imagen_path) ?>" alt="Zona <?= $foto->parte ?>" style="height: 80px; margin-bottom: 6px;">
                        <div><strong><?= $foto->parte ?></strong></div>
                    </td>

                    <?php $count++;
                endforeach;

                // Completar fila si faltan celdas
                $resto = $count % 3;
                if ($resto !== 0) {
                    for ($i = 0; $i < 3 - $resto; $i++) {
                        echo '<td style="border: none;"></td>';
                    }
                }
                ?>
            </tr>
        </table>
    </div>



    <div class="footer">
        <p><?= $empresa['nombre'] ?> - <?= $empresa['direccion'] ?>, <?= $empresa['codigo_postal'] ?>
            <?= $empresa['provincia'] ?> (<?= $empresa['pais'] ?>) | <?= $empresa['email'] ?> | CIF:
            <?= $empresa['nif'] ?> | tel. <?= $empresa['telefono'] ?></p>
    </div>
    <?php endif ?>
</body>

</html>