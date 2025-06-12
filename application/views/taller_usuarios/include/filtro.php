<form class="buscar_form form-horizontal" id="filtroForm">
    <div class="row">

        <div class="col-sm-3 col-md-3">
            <label class="col-md-2 col-sm-4 col-xs-12 control-label">Nombre</label>
            <div class="col-sm-8">
                <input type="text" name="buscarNombre" class="form-control" id="buscarNombre">
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <label class="col-md-2 col-sm-4 col-xs-12 control-label">Email</label>
            <div class="col-sm-8">
                <input type="email" name="buscarEmail" class="form-control" id="buscarEmail">
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <label class="col-md-2 col-sm-4 col-xs-12 control-label">Rol</label>
            <div class="col-sm-8">
                <select class="form-control" name="buscarRol" class="form-control" id="buscarRol" data-live-search="true">
                    <option value="">Todos</option>
                        <option value="admin">Admin</option>
                        <option value="taller">Taller</option>
                        <option value="empleado">Empleado</option>
                </select>
            </div>
        </div>

        <div class="col-sm-3 col-md-3 text-right">
            <div class="botones-buscar">
                <button class="btn btn-primary btn-md-wide" name="submit_filtrar" id="submit_filtrar" type="submit">
                    <i class="fa fa-search"></i> Buscar
                </button>

                <button type="submit" name="submit_ver_todos" id="submit_ver_todos" class="btn btn-warning btn-md-wide btn-search">
                    Ver todo
                </button>
            </div>
        </div>

    </div>
</form>
