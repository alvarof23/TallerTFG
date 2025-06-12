<?php

class Taller_vehiculos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();  // Esto carga la base de datos
    }


//------------------Index----------------------------------------------------------------------------------------------------------------------------------------------
    public function get_list_vehiculos() {
        $this->db->select('
            taller_vehiculos.*, 
            taller_modelos.nombre AS modelo_nombre, 
            taller_marcas.nombre AS marca_nombre,
            taller_marcas.id AS marca_id,
            taller_clientes.nombre AS cliente_nombre,
            taller_imgs.nombre AS nombre_img,
            EXISTS (SELECT 1 FROM taller_citas WHERE taller_citas.id_vehiculo = taller_vehiculos.id AND  taller_citas.estado != "anulada") AS tiene_cita
        ');
        $this->db->from('taller_vehiculos');
        $this->db->join('taller_modelos', 'taller_vehiculos.id_modelo = taller_modelos.id');
        $this->db->join('taller_marcas', 'taller_modelos.id_marca = taller_marcas.id');
        $this->db->join('taller_citas', 'taller_vehiculos.id = taller_citas.id_vehiculo', 'left');
        $this->db->join('taller_clientes', 'taller_vehiculos.id_cliente = taller_clientes.dni');
        $this->db->join('taller_imgs', 'taller_vehiculos.id = taller_imgs.id_vehiculo AND taller_imgs.principal = 1', 'left'); 

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_list_citas() {
        $this->db->select('c.*, v.id_cliente, v.num_bastidor, v.color, v.matricula, v.kilometros, t.descripcion, t.tiempo_estimado, cl.nombre, i.nombre as img');
        $this->db->from('taller_citas c');
        $this->db->join('taller_vehiculos v', 'c.id_vehiculo = v.id');
        $this->db->join('taller_clientes cl', 'v.id_cliente = cl.dni');
        $this->db->join('taller_tareas t', 'c.id_tarea = t.id');
        $this->db->join('taller_imgs i', 'v.id = i.id_vehiculo AND i.principal = 1', 'left');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    
    public function get_marcas()
    {
        $query = $this->db->select('id, nombre AS marca')
                        ->from('taller_marcas')
                        ->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function get_modelos()
    {
        $query = $this->db->select('id, id_marca, nombre AS modelo')
                        ->from('taller_modelos')
                        ->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function get_clientes()
    {
        $query = $this->db->select('dni, nombre, telefono, correo_electronico')
                        ->from('taller_clientes')
                        ->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function get_areasTrabajo_activas()
    {
        $this->db->select('*');
        $this->db->from('taller_tareas');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }


//------------------Fin Index----------------------------------------------------------------------------------------------------------------------------------------------

//------------------Form Modal----------------------------------------------------------------------------------------------------------------------------------------------

    public function get_imagenes_vehiculo($id_vehiculo) {
        $this->db->select('*');
        $this->db->from('taller_imgs');
        $this->db->where('taller_imgs.id_vehiculo', $id_vehiculo);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result(); // Devuelve todas las imágenes del vehículo
        } else {
            return array(); // Si no hay imágenes, devuelve un array vacío
        }
    }
    
    public function get_modelos_by_marca($id_marca)
    {
        $this->db->select('*');
        $this->db->from('taller_modelos');
        $this->db->where('id_marca', $id_marca);
        $query = $this->db->get();
        return $query->result();
    }
    
    //Modificación de datos

    public function insert_vehiculo($data) {
        return $this->db->insert('taller_vehiculos', $data);
    }
    
    public function update_vehiculo($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('taller_vehiculos', $data);
    }

    public function delete_vehiculo($id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM taller_citas WHERE id_vehiculo = ?", [$id]);
        $row = $query->row();
    
        $num_citas = $row ? $row->total : 0;
    
        if ($num_citas > 0) {
            $this->db->where('id_vehiculo', $id)->delete('taller_citas');
        }
    
        // Eliminar el vehículo
        $this->db->where('id', $id);
        $this->db->delete('taller_vehiculos');
    }
    
    
    
    
    
    


    public function insertar_imagen($nombre, $principal, $id_vehiculo)
    {
        $this->db->insert('taller_imgs', [
            'nombre'      => $nombre,
            'principal'   => $principal,
            'id_vehiculo' => $id_vehiculo
        ]);
    }
    public function update_poner_principal($id_vehiculo, $id_img){

        $this->db->where('id', $id_img);
        $this->db->where('id_vehiculo', $id_vehiculo);
        $this->db->update('taller_imgs', ['principal' => 1]);

    }

    public function update_quitar_principal($id_vehiculo, $id_img){

        $this->db->where('id', $id_img);
        $this->db->where('id_vehiculo', $id_vehiculo);
        $this->db->update('taller_imgs', ['principal' => 0]);

    }

    public function delete_image($image_id, $image_name)
{
    // Ruta de la imagen en el servidor
    $image_path = FCPATH . 'assets_app/images/taller/' . $image_name;

    // Intentamos eliminar el archivo físico
    if (file_exists($image_path)) {
        unlink($image_path);  // Eliminamos el archivo del sistema de archivos
    }

    // Eliminamos la imagen de la base de datos utilizando el ID
    $this->db->where('id', $image_id);
    $this->db->delete('taller_imgs');
}

public function getHorasDisponibles($tarea_id) {
    return $this->db->select('taller_configuraciones.*')
        ->from('taller_tareas')
        ->join('taller_area_trabajo', 'taller_tareas.id_area_trabajo = taller_area_trabajo.id')
        ->join('taller_configuraciones', 'taller_area_trabajo.id_configuracion = taller_configuraciones.id')
        ->where('taller_tareas.id', $tarea_id)
        ->get()
        ->row();
}

public function get_citas($tarea_id, $fecha){
    $query = $this->db->select('hora')
                        ->from('taller_citas')
                        ->where('id_tarea', $tarea_id)
                        ->where('fecha', $fecha)
                        ->where('estado !=', 'Anulada')
                        ->get();
    return ($query->num_rows() > 0) ? $query->result() : FALSE;
}

public function add_citas($id_vehiculo, $fecha, $hora, $id_tarea){

    $this->db->insert('taller_citas', [
        'id_vehiculo' => $id_vehiculo,
        'estado'      => 'Esperando_recepcion', // valor fijo según tu SQL
        'fecha'       => $fecha,
        'hora'        => $hora,
        'id_tarea'    => $id_tarea
    ]);

}

public function get_simultaneo($id_tarea)
{
    $this->db->select('c.simultaneo');
    $this->db->from('taller_tareas t');
    $this->db->join('taller_area_trabajo a', 't.id_area_trabajo = a.id');
    $this->db->join('taller_configuraciones c', 'a.id_configuracion = c.id');
    $this->db->where('t.id', $id_tarea);

    $query = $this->db->get();
    return $query->row()->simultaneo; 
}


//------------------Fin Form Modal----------------------------------------------------------------------------------------------------------------------------------------------


    
   
    // public function get_historial($id_ficha){
    //     $this->db->select('*');
    //     $this->db->from('taller_historial_cambios');
    //     $this->db->join('taller_ficha','taller_historial_cambios.id_ficha = taller_ficha.id');
    //     $this->db->where('taller_ficha.id', $id_ficha);
    //     $query = $this->db->get();

    //     if($query->num_rows() > 0){

    //         return $query->result(); // Verificar si devuelve datos

    //     }else{

    //         return false;

    //     }
    // }


    public function get_list_vehiculo_filtros($filtros) {
        $this->db->select('
            taller_vehiculos.*, 
            taller_modelos.nombre AS modelo_nombre, 
            taller_marcas.nombre AS marca_nombre, 
            taller_marcas.id AS marca_id, 
            taller_clientes.nombre AS cliente_nombre, 
            taller_imgs.nombre AS nombre_img, 
            EXISTS (SELECT 1 FROM taller_citas WHERE taller_citas.id_vehiculo = taller_vehiculos.id) AS tiene_cita
        ');
        $this->db->from('taller_vehiculos');
        $this->db->join('taller_modelos', 'taller_vehiculos.id_modelo = taller_modelos.id');
        $this->db->join('taller_marcas', 'taller_modelos.id_marca = taller_marcas.id');
        $this->db->join('taller_clientes', 'taller_vehiculos.id_cliente = taller_clientes.dni');
        $this->db->join('taller_imgs', 'taller_vehiculos.id = taller_imgs.id_vehiculo AND taller_imgs.principal = 1', 'left');
    
        // Filtro de búsqueda general
        if ($filtros['buscar'] != "") {
            $busca = $filtros['buscar'];
            $where = "(taller_vehiculos.id = '" . (int)$busca . "' OR 
                      taller_modelos.nombre LIKE '%" . $busca . "%' OR 
                      taller_marcas.nombre LIKE '%" . $busca . "%' OR 
                      taller_clientes.nombre LIKE '%" . $busca . "%' OR 
                      taller_vehiculos.num_bastidor LIKE '%" . $busca . "%' OR 
                      taller_vehiculos.color LIKE '%" . $busca . "%' OR 
                      taller_vehiculos.matricula LIKE '%" . $busca . "%' OR 
                      taller_vehiculos.fecha_matriculacion LIKE '%" . $busca . "%' OR 
                      taller_vehiculos.fecha_mant_basico LIKE '%" . $busca . "%' OR 
                      taller_vehiculos.fecha_mant_completo LIKE '%" . $busca . "%')";
            $this->db->where($where);
        }
    
         // Filtros específicos
        if (!empty($filtros['buscarCliente'])) {
            $this->db->where('taller_clientes.dni', $filtros['buscarCliente']);
        }

        if (!empty($filtros['buscarMarca'])) {
            $this->db->where('taller_marcas.id', $filtros['buscarMarca']);
        }

        if (!empty($filtros['buscarModelo'])) {
            $this->db->where('taller_modelos.id', $filtros['buscarModelo']);
        }

        if (!empty($filtros['buscarBastidor'])) {
            $this->db->like('taller_vehiculos.num_bastidor', $filtros['buscarBastidor'], 'after');
        }

        if (!empty($filtros['buscarColor'])) {
            $this->db->where('taller_vehiculos.color', $filtros['buscarColor']);
        }

        if (!empty($filtros['buscarMatricula'])) {
            $this->db->like('taller_vehiculos.matricula', $filtros['buscarMatricula'], 'after');
        }

        if (!empty($filtros['buscarFechaMatr'])) {
            $this->db->where('taller_vehiculos.fecha_matriculacion', $filtros['buscarFechaMatr']);
        }

        if (!empty($filtros['buscarFechaMantBasc'])) {
            $this->db->where('taller_vehiculos.fecha_mant_basico', $filtros['buscarFechaMantBasc']);
        }

        if (!empty($filtros['buscarFechaMantCompl'])) {
            $this->db->where('taller_vehiculos.fecha_mant_completo', $filtros['buscarFechaMantCompl']);
        }
    
        // Filtro de cita (existe o no existe)
        if (!empty($filtros['estadoCita']) && $filtros['estadoCita'] == 1) {
            $this->db->where("EXISTS (SELECT 1 FROM taller_citas WHERE taller_citas.id_vehiculo = taller_vehiculos.id)", null, false);
        }
    
        if (!empty($filtros['estadoCita']) && $filtros['estadoCita'] == 2) {
            $this->db->where("NOT EXISTS (SELECT 1 FROM taller_citas WHERE taller_citas.id_vehiculo = taller_vehiculos.id)", null, false);
        }
    
        // Ejecutar la consulta
        $query = $this->db->get();
    
        // Verificar si hay resultados y retornarlos
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }    

    public function get_vehiculos_por_cliente($cliente_id) {
        $this->db->select('taller_vehiculos.*, taller_modelos.nombre AS modelo_nombre, taller_marcas.nombre AS marca_nombre');
        $this->db->from('taller_vehiculos');
        $this->db->join('taller_modelos', 'taller_vehiculos.id_modelo = taller_modelos.id');
        $this->db->join('taller_marcas', 'taller_modelos.id_marca = taller_marcas.id');
        $this->db->where('taller_vehiculos.id_cliente', $cliente_id);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }
}
