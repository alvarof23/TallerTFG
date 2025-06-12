<!-- Modal Crear/Editar Área -->
<div class="modal fade" id="modalCrearArea" tabindex="-1" role="dialog" aria-labelledby="modalCrearAreaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formCrearArea" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearAreaLabel">Crear Nueva Área</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="form-group">
          <label for="area_nombre">Nombre</label>
          <input type="text" class="form-control" id="area_nombre" name="nombre" required>
        </div>

        <div class="form-group">
          <label for="area_codigo">Código</label>
          <input type="text" class="form-control" id="area_codigo" name="codigo" required>
        </div>

        <div class="form-group">
          <label for="area_configuracion">Configuración</label>
          <select id="area_configuracion" name="configuracion_id" class="form-control">
              <option selected default value="">Seleccione una configuración</option>
              <?php foreach($configuraciones as $conf): ?>
                  <option value="<?= $conf['id'] ?>">
                      Configuración <?= $conf['id'] ?>
                  </option>
              <?php endforeach; ?>
          </select>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Área</button>
      </div>
    </form>
  </div>
</div>
