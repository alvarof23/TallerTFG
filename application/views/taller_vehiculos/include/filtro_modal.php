
<div class="row col-md-12 col-sm-12 box_datos hidden" id="filtro_modal" style="margin:10px"> 

    <div class="col-sm-3 m-top-10">
        <label class="col-md-3 col-xs-12 control-label">Bastidor</label>
        <div class="col-sm-8">
            <input type="text" name="buscarBastidor" class="form-control" id="buscarBastidor">
        </div>
    </div>


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
        <label class="col-md-3 col-xs-12 control-label">Modelo</label>
        <div class="col-sm-8">
            <select class="form-control select" name="buscarModelo" id="buscaModelo" data-live-search="true">
                <option value="">-- No seleccionar --</option>
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
        <label for="estadoCita" class="col-md-3 col-xs-12 control-label">Estado Cita</label>
        <div class="col-sm-8 m-top-10">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="estadoCita" id="neutra" value="neutra" checked>
                <label class="form-check-label" for="neutra">Neutra</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="estadoCita" id="tieneCita" value="1">
                <label class="form-check-label" for="tieneCita">Tiene Cita</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="estadoCita" id="noTieneCita" value="2">
                <label class="form-check-label" for="noTieneCita">No Tiene Cita</label>
            </div>
        </div>                   
    </div>


</div>	  