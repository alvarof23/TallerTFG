<!-- Modal Crear Producto -->
<div class="modal fade" id="modalCrearProducto" tabindex="-1" role="dialog" aria-labelledby="modalCrearProductoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formCrearProducto" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearProductoLabel">Crear Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="id_tarea" id="producto_id_tarea">
          <input type="hidden" name="id_producto" id="producto_id">
          <div class="form-group">
            <label for="producto_nombre">Tipo</label>
            <input type="text" class="form-control" id="producto_nombre" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="producto_descripcion">Modelo</label>
            <textarea class="form-control" id="producto_descripcion" name="descripcion"></textarea>
          </div>
          <div class="form-group">
            <label for="producto_precio">Precio (€)</label>
            <input type="number" class="form-control" id="producto_precio" name="precio" step="0.01" min="0" value="0">
          </div>
          <div class="form-group">
            <label for="producto_precio">Stock (€)</label>
            <input type="number" class="form-control" id="producto_stock" name="stock" step="0.01" min="0" value="0">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Producto</button>
      </div>
    </form>
  </div>
</div>
