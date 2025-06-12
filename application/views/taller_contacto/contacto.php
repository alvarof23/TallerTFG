<?php $this->load->view('include/Header'); ?>

<div class="panel panel-default" style="border-top:none;">
    <?php if(isset($_POST['nuevo-tipos-tareas'])): ?>
        <div class="col-xs-12">
            <?= validation_errors(); ?>
            <?php if(isset($error_subida_archivo) && $error_subida_archivo) echo $error_subida_archivo; ?>
        </div>  
    <?php endif ?>
    <div class="panel-body">
        <div class="contact-container col-xs-12">
            <div class="col-xs-12 col-md-6">
                <!-- Contact Info -->
                <div class="contact-info text-center">
                    <h1>Contacta conmigo</h1>
                    <p class="contact-subtitle">Haz clic para copiar los datos</p>

                    <p class="contact-method">
                        <i class="fa fa-phone"></i> 644 42 55
                    </p>
                    <p class="contact-method">
                        <i class="fa fa-envelope"></i> falconeti@gmail.com
                    </p>
                    <p class="contact-method">
                        <i class="fa fa-map-marker"></i> 15 West 3rd St. Media, Pa. 19063
                    </p>
                    
                    <div id="copiado-alerta" class="alert alert-success" style="display:none; margin-top:15px;">
                        Copiado al portapapeles ✔
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-md-6">
                <?php if($this->session->flashdata('msg')): ?>
                    <div class="alert alert-info text-center">
                        <?= $this->session->flashdata('msg'); ?>
                    </div>
                <?php endif; ?>

                <!-- Contact Form -->
                <form id="contactForm" class="form-horizontal" method="post" action="">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                    <div class="form-group">
                        <label for="nombre_first" class="col-xs-12 col-sm-12 control-label" style="font-weight:700; font-size:1.3em;">Nombre</label>
                        <div class="col-sm-12">
                            <div class="col-xs-12 col-sm-6">
                                <input type="text" id="nombre_first" name="nombre_first" class="form-control" placeholder="Nombre" required value="<?= set_value('nombre_first') ?>">
                            </div>
                            <div class="col-xs-12 col-sm-6" >
                                <input type="text" id="nombre_last" name="nombre_last" class="form-control" placeholder="Apellido" required value="<?= set_value('nombre_last') ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="col-xs-12 control-label" style="font-weight:700; font-size:1.3em;">Correo Electrónico</label>
                        <div class="col-xs-12">
                            <input type="email" id="email" name="email" class="form-control" placeholder="example@email.com" required value="<?= set_value('email') ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono" class="col-xs-12 control-label" style="font-weight:700; font-size:1.3em;">Teléfono (opcional)</label>
                        <div class="col-xs-12">
                            <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="xxx-xxx-xxxx" value="<?= set_value('telefono') ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="mensaje" class="col-xs-12 control-label" style="font-weight:700; font-size:1.3em;">Mensaje</label>
                        <div class="col-xs-12">
                            <textarea id="mensaje" name="mensaje" class="form-control" rows="5" placeholder="Escribe tu mensaje..." required><?= set_value('mensaje') ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg" style="padding: 12px 50px; font-weight: 700;">Enviar Mensaje</button>
                        </div>
                    </div>
                </form>

            </div>
            <div id="formMessage" class="alert alert-info text-center" style="display:none;"></div>
        </div>
    </div>
</div>

<?php $this->load->view('include/Footer'); ?>
