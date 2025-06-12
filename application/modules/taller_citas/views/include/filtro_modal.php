<div class="col-md-12 col-xs-12 font-small hidden" id="filtro_modal">
	<div class="panel panel-default sin_bordes">
		<div class="panel-body">
			<div class="row form-group">
				<div class="col-md-12 col-xs-12 box_datos"> 

                
                <div class="ifPagina">
                <?php
                
                if(isset($list_citas) && $list_citas!=0){

                    echo ("<p>Citas</p>");

                }else if(isset($list_vehiculos) && $list_vehiculos!=0){

                    echo ("<p>Vehiculos</p>");

                }
                
                ?>
                </div>

                    <div class="col-sm-3 m-top-10">
                        <label class="col-md-3 col-xs-12 control-label">Bastidor</label>
                        <div class="col-sm-8">
                            <input type="text" name="buscarBastidor" class="form-control" id="buscarBastidor">
                        </div>
                    </div>

                <?php if(isset($list_vehiculos) && $list_vehiculos!=0) : ?>

                    <div class="col-sm-3 m-top-10">
                        <label class="col-md-3 col-xs-12 control-label">Marca</label>
                        <div class="col-sm-8">
                            <select class="form-control select" id="buscarMarca" name="buscarMarca" data-live-search="true">
                                <option value="default" selected disabled>Seleccione Marca</option>
                                <option value="">-- No seleccionar --</option>
                                <?php foreach ($marca_vehiculo as $marca): ?>
                                    <option value="<?= $marca->id ?>">
                                        <?= $marca->marca ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> 

                    <div class="col-sm-3 m-top-10">
                        <label class="col-md-3 col-xs-12 control-label">Color</label>
                        <div class="col-sm-8">
                            <input type="text" name="buscarColor" class="form-control" id="buscarColor">
                        </div>
                    </div> 

                    <div class="clearfix"></div>

                    <div class="col-sm-3 m-top-10">
                        <label for="buscarFechaMatr" class="col-md-3 col-xs-12 control-label">F. Matriculación</label>
                        <div class="col-sm-8">
                            <input type="date" id="buscarFechaMatr" name="buscarFechaMatr" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-3 m-top-10">
                        <label for="buscarFechaMantBasc" class="col-md-3 col-xs-12 control-label">Fecha Mant. Basc.</label>
                        <div class="col-sm-8">
                            <input type="date" id="buscarFechaMantBasc" name="buscarFechaMantBasc" class="form-control">
                        </div>
                    </div> 

                    <div class="col-sm-3 m-top-10">
                        <label for="buscarFechaMantCompl" class="col-md-3 col-xs-12 control-label">Fecha Mant. Compl.</label>
                        <div class="col-sm-8">
                            <input type="date" id="buscarFechaMantCompl" name="buscarFechaMantCompl" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-3 m-top-10">
                        <label for="tieneCita" class="col-md-3 col-xs-12 control-label">Tiene Cita</label>
                        <div class="col-sm-8 m-top-10">
                            <input type="checkbox" value="1" name="tieneCita" class="mt-3">    
                        </div>                   
                    </div>
                <?php elseif (isset($list_citas) && $list_citas!=0): ?>   

                    <div class="col-sm-3 m-top-10">
                        <label for="buscarFechaMantBasc" class="col-md-3 col-xs-12 control-label">Fecha</label>
                        <div class="col-sm-8">
                            <input type="date" id="buscarFecha" name="buscarFecha" class="form-control">
                        </div>
                    </div> 

                    <div class="col-sm-3 m-top-10">
                        <label for="buscarFechaMantBasc" class="col-md-3 col-xs-12 control-label">Hora</label>
                        <div class="col-sm-8">
                            <input type="time" id="buscarHora" name="buscarHora" class="form-control">
                        </div>
                    </div> 

                    <div class="col-sm-3 m-top-10">
                        <label for="buscarFechaMantBasc" class="col-md-3 col-xs-12 control-label">Tarea</label>
                        <select class="form-control select" name="buscarTarea" id="buscarTarea" data-live-search="true">
                            <option value="default" selected disabled>Seleccione una Tarea</option>
                            <option value="">-- No seleccionar --</option>
                            <?php foreach ($tareas as $tarea): ?>
                                <option value="<?= $tarea->id ?>">
                                    <?= $tarea->descripcion ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div> 

                    <div class="col-sm-3 m-top-10">
                        <label for="buscarFechaMantBasc" class="col-md-3 col-xs-12 control-label">Tiempo Estimado</label>
                        <div class="col-sm-8">
                            <input type="time" id="buscarTEstimado" name="buscarTEstimado" class="form-control">
                        </div>
                    </div> 

                    <div class="col-sm-3 m-top-10">
                        <label for="buscarFechaMantBasc" class="col-md-3 col-xs-12 control-label">Estado</label>
                        <select class="form-control select" name="buscarEstado" id="buscarEstado" data-live-search="true">
                            <option value="default" selected disabled>Seleccione un Estado</option>
                            <option value="">-- No seleccionar --</option>
                            <?php for ($i = 0; $i < count($optionsEstado); $i++) : ?>
                                <option value="<?= $optionsEstado[$i] ?>">
                                    <?= $optionsEstado[$i] ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div> 

                <?php endif; ?>
                </div>
			</div>	  
		</div>
	</div>
</div>