<?php

class Taller_citas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


//------------------Index----------------------------------------------------------------------------------------------------------------------------------------------
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

    public function get_list_citas_vehiculo($id_vehiculo){

        $this->db->select('c.*, v.id_cliente, v.num_bastidor, v.color, v.matricula, v.kilometros, t.descripcion, t.tiempo_estimado, cl.nombre, i.nombre as img');
        $this->db->from('taller_citas c');
        $this->db->join('taller_vehiculos v', 'c.id_vehiculo = v.id');
        $this->db->join('taller_clientes cl', 'v.id_cliente = cl.dni');
        $this->db->join('taller_tareas t', 'c.id_tarea = t.id');
        $this->db->join('taller_imgs i', 'v.id = i.id_vehiculo AND i.principal = 1', 'left');
        $this->db->where('c.id_vehiculo', $id_vehiculo);
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }

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
                            ->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function get_simultaneo($id_tarea)
    {
        $this->db->select('c.simultaneo');
        $this->db->from('taller_tareas t');
        $this->db->join('taller_area_trabajo a', 't.id_area_trabajo = a.id');
        $this->db->join('taller_configuraciones c', 'a.id_configuracion = c.id');
        $this->db->where('t.id', $id_tarea);

        $query = $this->db->get();
        return $query->row()->simultaneo; // Devolver el valor de 'simultaneo'
    }

    public function get_tareas(){

        $this->db->select('t.descripcion, t.id');
        $this->db->from('taller_tareas t');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;

    }
    
    // Esta consulta consigue las opciones dentro del ENUM de estado, como devuelve una suerte de string con los valores, se trata este mismo para conseguir los valores individuales
    public function get_opciones_estado(){

        $query = $this->db->query("SHOW COLUMNS FROM taller_citas LIKE 'estado'");
        $row = $query->row();

        $enumBruto = substr($row->Type, 5, -1);

        $opcionesENUM = explode("','", $enumBruto);

        $opcionesENUM = array_map(function($opcionesENUM){

            return trim($opcionesENUM, "'");

        }, $opcionesENUM);

        return $opcionesENUM;

    }

    public function get_cliente($dni)
    {
        $query = $this->db->select('dni, nombre, telefono, correo_electronico')
                        ->from('taller_clientes')
                        ->where('dni', $dni)
                        ->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function get_matricula_cliente($cliente)
    {
        $query = $this->db->select('v.*, mo.nombre as modelo, ma.nombre as marca')
                        ->from('taller_vehiculos v')
                        ->join('taller_modelos mo', 'v.id_modelo = mo.id')
                        ->join('taller_marcas ma', 'mo.id_marca = ma.id')
                        ->where('id_cliente', $cliente)
                        ->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function get_vehiculo($id_vehiculo){
        $query = $this->db->select('v.*, mo.nombre as modelo, ma.nombre as marca')
                        ->from('taller_vehiculos v')
                        ->join('taller_modelos mo', 'v.id_modelo = mo.id')
                        ->join('taller_marcas ma', 'mo.id_marca = ma.id')
                        ->where('v.id', $id_vehiculo)
                        ->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function add_citas($id_vehiculo, $fecha, $hora, $id_tarea){

        $this->db->insert('taller_citas', [
            'id_vehiculo' => $id_vehiculo,
            'estado'      => 'Esperando_recepcion',
            'fecha'       => $fecha,
            'hora'        => $hora,
            'id_tarea'    => $id_tarea
        ]);
    
    }


    public function update_citas($id_cita, $id_vehiculo, $fecha, $hora, $id_tarea, $estado){

        $this->db->where('id', $id_cita);
        $this->db->update('taller_citas', [
            'id_vehiculo' => $id_vehiculo,
            'estado'      => $estado,
            'fecha'       => $fecha,
            'hora'        => $hora,
            'id_tarea'    => $id_tarea
        ]);
    
    }

    public function actualizar_estado_cita($id, $estado) {
        $this->db->where('id', $id);
        $this->db->update('taller_citas', ['estado' => $estado]);
    }

    public function actualizar_cita($id, $estado, $id_vehiculo, $fecha, $hora, $id_tarea) {
        $this->db->where('id', $id);
        $this->db->update('taller_citas', [
            'estado' => $estado,
            'id_vehiculo' => $id_vehiculo,
            'fecha' => $fecha,
            'hora' => $hora,
            'id_tarea' => $id_tarea
        ]);
    }
    
    
    public function obtener_cita_con_detalles($id) {
        $this->db->select('
            c.*,
            v.id_cliente, v.num_bastidor, v.color, v.matricula, v.kilometros,
            mo.nombre as modelo,
            ma.nombre as marca,
            cl.dni, cl.nombre as cliente_nombre, cl.telefono as cliente_telefono, cl.correo_electronico as cliente_email,
            t.descripcion, t.tiempo_estimado,
            art.nombre as area_nombre, art.codigo,
            i.nombre as img
        ');
        $this->db->from('taller_citas c');
        $this->db->join('taller_vehiculos v', 'c.id_vehiculo = v.id');
        $this->db->join('taller_modelos mo', 'v.id_modelo = mo.id');
        $this->db->join('taller_marcas ma', 'mo.id_marca = ma.id');
        $this->db->join('taller_clientes cl', 'v.id_cliente = cl.dni');
        $this->db->join('taller_tareas t', 'c.id_tarea = t.id');
        $this->db->join('taller_area_trabajo art', 't.id_area_trabajo = art.id');
        $this->db->join('taller_imgs i', 'v.id = i.id_vehiculo AND i.principal = 1', 'left');
        $this->db->where('c.id', $id);
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row(); // SOLO UN REGISTRO
        } else {
            return FALSE;
        }
    }


    public function obtener_vehiculos_cliente($dni, $id_cita) {
        $this->db->distinct();
        $this->db->select('v.*');
        $this->db->from('taller_vehiculos v');
        $this->db->join('taller_citas c', 'v.id = c.id_vehiculo');
        $this->db->where('v.id_cliente', $dni);
        $this->db->where('c.estado !=', 'Anulada');
        $this->db->where('c.estado !=', 'Entregado');
        $this->db->where('c.id !=', $id_cita);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result(); // SOLO UN REGISTRO
        } else {
            return FALSE;
        }

    }
    
    public function obtener_cita_vehiculos($id_vehiculo, $id_cita){

        $this->db->select('c.*, v.id_cliente, v.num_bastidor, v.color, v.matricula, v.kilometros, t.tiempo_estimado, cl.nombre, i.nombre as img, cl.dni as id_cliente');
        $this->db->from('taller_citas c');
        $this->db->join('taller_vehiculos v', 'c.id_vehiculo = v.id');
        $this->db->join('taller_clientes cl', 'v.id_cliente = cl.dni');
        $this->db->join('taller_tareas t', 'c.id_tarea = t.id');
        $this->db->join('taller_imgs i', 'v.id = i.id_vehiculo AND i.principal = 1', 'left');
        $this->db->where('c.id_vehiculo', $id_vehiculo);
        $this->db->where('c.estado !=', 'Anulada');
        $this->db->where('c.estado !=', 'Entregado');
        $this->db->where('c.id !=', $id_cita);
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }

    }

    public function get_list_citas_filtros($filtros){
        $this->db->select('c.*, v.id_cliente, v.num_bastidor, v.matricula,
                           t.descripcion, t.tiempo_estimado, cl.nombre, i.nombre as img');
        $this->db->from('taller_citas c');
        $this->db->join('taller_vehiculos v', 'c.id_vehiculo = v.id');
        $this->db->join('taller_clientes cl', 'v.id_cliente = cl.dni');
        $this->db->join('taller_tareas t', 'c.id_tarea = t.id');
        $this->db->join('taller_imgs i', 'v.id = i.id_vehiculo AND i.principal = 1', 'left');
        $this->db->join('taller_modelos m', 'v.id_modelo = m.id');
        $this->db->join('taller_marcas ma', 'm.id_marca = ma.id');
    
        // Filtros
        if ($filtros['buscar'] != "") {
            $busca = $filtros['buscar'];
            $this->db->where("(v.id = '" . (int)$busca . "' OR 
            v.num_bastidor LIKE '%$busca%' OR 
            v.id_cliente LIKE '%$busca%' OR 
            v.matricula LIKE '%$busca%' OR 
            t.descripcion LIKE '%$busca%' OR 
            cl.nombre LIKE '%$busca%' OR 
            c.estado LIKE '%$busca%' OR 
            c.fecha LIKE '%$busca%' OR 
            c.hora LIKE '%$busca%') OR 
            t.tiempo_estimado LIKE '%$busca%'");
        }
    
        if (!empty($filtros['buscarCliente'])) {
            $this->db->where('cl.dni', $filtros['buscarCliente']);
        } 

        if (!empty($filtros['buscarBastidor'])) {
            $this->db->like('v.num_bastidor', $filtros['buscarBastidor'], 'after');
        }
    
        if (!empty($filtros['buscarMatricula'])) {
            $this->db->like('v.matricula', $filtros['buscarMatricula'], 'after');
        }
    
        if (!empty($filtros['buscarFecha'])) {
            $this->db->where('c.fecha', $filtros['buscarFecha']);
        }
    
        if (!empty($filtros['buscarHora'])) {
            $this->db->where('c.hora', $filtros['buscarHora']);
        }
    
        if (!empty($filtros['buscarTarea'])) {
            $this->db->where('t.id', $filtros['buscarTarea']);
        }
    
        if (!empty($filtros['buscarTEstimado'])) {
            $this->db->where('t.tiempo_estimado', $filtros['buscarTEstimado']);
        }

        if (!empty($filtros['buscarEstado'])) {
            $this->db->where('c.estado', $filtros['buscarEstado']);
        }
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    

    public function guardarRecepcionPorCita($data)
    {
        // Verificar si ya existe una recepción para esta cita
        $this->db->where('id_cita', $data['id_cita']);
        $query = $this->db->get('taller_recepcion');

        $recepcion_data = [
            'kilometros' => $data['kilometraje'],
            'combustible' => $data['combustible'],
            'observaciones_cliente' => $data['observaciones'],
            'confirmacion_cliente' => $data['confirmacion_cliente'],
        ];

        $nueva = false;
        if ($query->num_rows() > 0) {
            // Actualizar recepción existente
            $this->db->where('id_cita', $data['id_cita']);
            $this->db->update('taller_recepcion', $recepcion_data);
            $id_recepcion = $query->row()->id;
        } else {
            // Insertar nueva recepción
            $recepcion_data['id_cita'] = $data['id_cita'];
            $this->db->insert('taller_recepcion', $recepcion_data);
            $id_recepcion = $this->db->insert_id();
            $nueva = true;
        }

        // Si es nueva, actualizar estado de la cita
        if ($nueva) {
            $this->db->where('id', $data['id_cita']);
            $this->db->update('taller_citas', ['estado' => 'Procesando']);
        }

        // Obtener ID del vehículo asociado a la cita
        $this->db->select('id_vehiculo');
        $this->db->where('id', $data['id_cita']);
        $vehiculo_query = $this->db->get('taller_citas');

        if ($vehiculo_query->num_rows() > 0) {
            $id_vehiculo = $vehiculo_query->row()->id_vehiculo;
            $this->db->where('id', $id_vehiculo);
            $this->db->update('taller_vehiculos', ['kilometros' => $data['kilometraje']]);
        }

        return $id_recepcion;
    }

    
    public function insertarZonasImpacto($recepcion_id, $zona, $imagen) {
            $this->db->insert('taller_recepcion_fotos', [
                'id_recepcion' => $recepcion_id,
                'parte' => $zona,
                'imagen_path' => $imagen,
            ]);
        
    }

    // public function get_recepcion_by_cita($cita_id)
    // {
    //     $this->db->select('r.*, rf.*, rf.id as id_foto');
    //     $this->db->from('taller_recepcion_fotos rf');
    //     $this->db->join('taller_recepcion r', 'rf.id_recepcion = r.id');
    //     $this->db->where('r.id_cita', $cita_id);
        
    //     $query = $this->db->get();

    //     if ($query->num_rows() > 0) {
    //         $resultados = $query->result_array();
    //         $recepcion = [
    //             'id'                   => $resultados[0]['id'],
    //             'id_cita'              => $resultados[0]['id_cita'],
    //             'kilometros'           => $resultados[0]['kilometros'],
    //             'combustible'          => $resultados[0]['combustible'],
    //             'observaciones'        => $resultados[0]['observaciones_cliente'],
    //             'confirmacion_cliente' => $resultados[0]['confirmacion_cliente'],
    //             'fotos'                => []
    //         ];

    //         foreach ($resultados as $fila) {
    //             $recepcion['fotos'][] = [
    //                 'id_foto'     => $fila['id_foto'],
    //                 'parte'       => $fila['parte'],
    //                 'imagen_path' => $fila['imagen_path']
    //             ];
    //         }
            

    //         return $recepcion;
    //     } else {
    //         return FALSE;
    //     }
    // }


    public function get_recepcion_by_cita($cita_id)
    {
        // 1. Obtener los datos de la recepción
        $this->db->select('*');
        $this->db->from('taller_recepcion');
        $this->db->where('id_cita', $cita_id);

        $query = $this->db->get();

        if ($query->num_rows() === 0) {
            return FALSE; // No hay recepción
        }

        $row = $query->row_array();

        $recepcion = [
            'id'                   => $row['id'],
            'id_cita'              => $row['id_cita'],
            'kilometros'           => $row['kilometros'],
            'combustible'          => $row['combustible'],
            'observaciones'        => $row['observaciones_cliente'],
            'confirmacion_cliente' => $row['confirmacion_cliente'],
            'fotos'                => [] // por defecto vacío
        ];

        // 2. Obtener las fotos asociadas a esa recepción (si existen)
        $this->db->select('id as id_foto, parte, imagen_path');
        $this->db->from('taller_recepcion_fotos');
        $this->db->where('id_recepcion', $row['id']);

        $fotos = $this->db->get()->result_array();

        foreach ($fotos as $foto) {
            $recepcion['fotos'][] = $foto;
        }

        return $recepcion;
    }


    public function eliminar_fila($id_recepcion, $parte) {
        $this->db->where('id_recepcion', $id_recepcion);
            $this->db->where('parte', $parte);
            $this->db->delete('taller_recepcion_fotos');
    }
    

    public function fotos_actuales($id_recepcion) {
        $this->db->where('id_recepcion', $id_recepcion);
        $query = $this->db->get('taller_recepcion_fotos');
    
        if ($query->num_rows() > 0) {
            return $query->result(); // <- aquí va result() sobre $query, no $this->db
        } else {
            return false;
        }
    }

}

