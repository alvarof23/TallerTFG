<?php

class Taller_citas_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();  // Esto carga la base de datos

    }


    //------------------Index----------------------------------------------------------------------------------------------------------------------------------------------
    public function get_list_citas()
    {
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

    public function get_list_citas_vehiculo($id_vehiculo)
    {

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

    public function getHorasDisponibles($tarea_id)
    {
        return $this->db->select('taller_configuraciones.*')
            ->from('taller_tareas')
            ->join('taller_area_trabajo', 'taller_tareas.id_area_trabajo = taller_area_trabajo.id')
            ->join('taller_configuraciones', 'taller_area_trabajo.id_configuracion = taller_configuraciones.id')
            ->where('taller_tareas.id', $tarea_id)
            ->get()
            ->row();
    }

    public function get_citas($tarea_id, $fecha)
    {
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

    public function get_tareas()
    {

        $this->db->select('t.descripcion, t.id');
        $this->db->from('taller_tareas t');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;

    }

    // Esta consulta consigue las opciones dentro del ENUM de estado, como devuelve una suerte de string con los valores, se trata este mismo para conseguir los valores individuales
    public function get_opciones_estado()
    {

        $query = $this->db->query("SHOW COLUMNS FROM taller_citas LIKE 'estado'");
        $row = $query->row();

        $enumBruto = substr($row->Type, 5, -1);

        $opcionesENUM = explode("','", $enumBruto);

        $opcionesENUM = array_map(function ($opcionesENUM) {

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
            ->join('taller_clientes cl', 'v.id_cliente = cl.dni')
            ->join('taller_modelos mo', 'v.id_modelo = mo.id')
            ->join('taller_marcas ma', 'mo.id_marca = ma.id')
            ->where('dni', $cliente)
            ->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function get_vehiculo($id_vehiculo)
    {
        $query = $this->db->select('v.*, mo.nombre as modelo, ma.nombre as marca')
            ->from('taller_vehiculos v')
            ->join('taller_modelos mo', 'v.id_modelo = mo.id')
            ->join('taller_marcas ma', 'mo.id_marca = ma.id')
            ->where('v.id', $id_vehiculo)
            ->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function add_citas($id_vehiculo, $fecha, $hora, $id_tarea)
    {

        $this->db->insert('taller_citas', [
            'id_vehiculo' => $id_vehiculo,
            'estado' => 'Esperando_recepcion',
            'fecha' => $fecha,
            'hora' => $hora,
            'id_tarea' => $id_tarea
        ]);

    }


    public function update_citas($id_cita, $id_vehiculo, $fecha, $hora, $id_tarea, $estado)
    {

        $this->db->where('id', $id_cita);
        $this->db->update('taller_citas', [
            'id_vehiculo' => $id_vehiculo,
            'estado' => $estado,
            'fecha' => $fecha,
            'hora' => $hora,
            'id_tarea' => $id_tarea
        ]);

    }

    public function actualizar_estado_cita($id, $estado)
    {
        $this->db->where('id', $id);
        return $this->db->update('taller_citas', ['estado' => $estado]);
    }

    public function obtener_cita_mucho_detalles($id)
    {
        $this->db->select('
        c.*,
        v.id_cliente, v.num_bastidor, v.color, v.matricula, v.kilometros,
        mo.nombre as modelo,
        ma.nombre as marca,
        cl.dni, cl.nombre as cliente_nombre, cl.telefono as cliente_telefono, cl.correo_electronico as cliente_email,
        t.descripcion, t.tiempo_estimado,
        art.nombre as area_nombre, art.codigo,
        i.nombre as img,
        r.observaciones_cliente, r.combustible, r.id as id_recepcion,
    ');

        $this->db->from('taller_citas c');
        $this->db->join('taller_vehiculos v', 'c.id_vehiculo = v.id');
        $this->db->join('taller_modelos mo', 'v.id_modelo = mo.id');
        $this->db->join('taller_marcas ma', 'mo.id_marca = ma.id');
        $this->db->join('taller_clientes cl', 'v.id_cliente = cl.dni');
        $this->db->join('taller_tareas t', 'c.id_tarea = t.id');
        $this->db->join('taller_area_trabajo art', 't.id_area_trabajo = art.id');
        $this->db->join('taller_imgs i', 'v.id = i.id_vehiculo AND i.principal = 1', 'left');
        $this->db->join('taller_recepcion r', 'c.id = r.id_cita');
        $this->db->where('c.id', $id);

        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->row(); // SOLO UN REGISTRO
        } else {
            return FALSE;
        }
    }

    public function obtener_organizacion()
    {
        $this->db->select('nombre as empresa, nif as nif_empresa, logo, pais, provincia, direccion as direccion_empresa, codigo_postal as codigo_postal_empresa, email as email_empresa, telefono as telefono_empresa, horario_atencion_cliente');
        $this->db->from('taller_organizacion');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row(); // SOLO UN REGISTRO
        } else {
            return FALSE;
        }
    }

    public function obtener_cita_con_detalles($id)
    {
        $this->db->select('
        c.*,
        v.id_cliente, v.num_bastidor, v.color, v.matricula, v.kilometros,
        mo.nombre as modelo,
        ma.nombre as marca,
        cl.dni, cl.nombre as cliente_nombre, cl.telefono as cliente_telefono, cl.correo_electronico as cliente_email,
        t.descripcion, t.tiempo_estimado,
        art.nombre as area_nombre, art.codigo,
        i.nombre as img,
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

    public function obtener_fotos($id_recepcion)
    {
        $this->db->select('*');
        $this->db->from('taller_recepcion_fotos');
        $this->db->where('id_recepcion', $id_recepcion);

        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result(); // SOLO UN REGISTRO
        } else {
            return FALSE;
        }
    }


    public function obtener_vehiculos_cliente($dni, $id_cita)
    {
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

    public function obtener_cita_vehiculos($id_vehiculo, $id_cita)
    {

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

    public function get_list_citas_filtros($filtros)
    {
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
            $this->db->where("(v.id = '" . (int) $busca . "' OR 
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


    public function insertarZonasImpacto($recepcion_id, $zona, $imagen)
    {
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
            'id' => $row['id'],
            'id_cita' => $row['id_cita'],
            'kilometros' => $row['kilometros'],
            'combustible' => $row['combustible'],
            'observaciones' => $row['observaciones_cliente'],
            'confirmacion_cliente' => $row['confirmacion_cliente'],
            'fotos' => [] // por defecto vacío
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

    public function del_recepcion($recepcion_id)
    {
        $this->db->where('id', $recepcion_id);
        return $this->db->delete('taller_recepcion');
    }



    public function eliminar_fila($id_recepcion, $parte)
    {
        $this->db->where('id_recepcion', $id_recepcion);
        $this->db->where('parte', $parte);
        $this->db->delete('taller_recepcion_fotos');
    }


    public function fotos_actuales($id_recepcion)
    {
        $this->db->where('id_recepcion', $id_recepcion);
        $query = $this->db->get('taller_recepcion_fotos');

        if ($query->num_rows() > 0) {
            return $query->result(); // <- aquí va result() sobre $query, no $this->db
        } else {
            return false;
        }
    }

    public function get_firma_by_cita($id_cita)
    {
        $this->db->select('firma_cliente');
        $this->db->from('taller_recepcion');
        $this->db->where('id_cita', $id_cita);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row(); // devuelve un objeto con la propiedad firma_base64
        } else {
            return null;
        }
    }


    public function add_firma($firma_data, $id_recepcion)
    {

        $this->db->where('id', $id_recepcion);
        $this->db->update('taller_recepcion', [
            'firma_cliente' => $firma_data
        ]);
        return $id_recepcion;
    }

    public function get_presupuesto_por_cita($cita_id) {
        // Obtener el presupuesto
        $presupuesto = $this->db->get_where('taller_presupuestos', [
            'cita_id' => $cita_id,
        ])->row();

        if ($presupuesto) {
            // Obtener productos del presupuesto
            $this->db->select('pp.*, p.nombre, p.descripcion, p.precio');
            $this->db->from('taller_presupuesto_productos pp');
            $this->db->join('taller_productos p', 'p.id = pp.producto_id');
            $this->db->where('pp.presupuesto_id', $presupuesto->id);
            $productos = $this->db->get()->result();

            // Adjuntar productos al presupuesto
            $presupuesto->productos = $productos;
        }

        return $presupuesto;
    }



    // public function get_presupuesto($id){
    //     // Obtener el presupuesto (order) asociado a la cita
    //     $this->db->select('o.id, o.num_doc, o.fecha_modificado, o.total_order, o.BASE, o.IVADESCUENTO1, o.PORIVA1, o.total_iva, o.subtotal_order, o.date_order, o.id_tarifa, o.total_descuento');
    //     $this->db->from('orders o');
    //     $this->db->where('o.id_cita', $id);
    //     $query_order = $this->db->get();
    
    //     if ($query_order->num_rows() == 0) {
    //         return FALSE; // No hay presupuesto con esa cita
    //     }
    
    //     $order = $query_order->row();
    //     $id_order = $order->id;
    
    //     // Obtener las líneas del pedido
    //     $this->db->select('id, id_product, codebar_product, qty_order_item, name_product, price_product, iva_product, porcentaje_iva, id_tipo_iva_valores, base_imponible, orden_linea');
    //     $this->db->from('order_items');
    //     $this->db->where('id_order', $id_order);
    //     $query_items = $this->db->get();
    
    //     $items = $query_items->result();
    
    //     // Retornar pedido y líneas
    //     return [
    //         'order' => $order,
    //         'items' => $items
    //     ];
    // }

     // Obtener productos de una tarea



    public function get_list_esperando(){
        $this->db->select('c.*, v.id_cliente, v.num_bastidor, v.color, v.matricula, v.kilometros, t.descripcion, t.tiempo_estimado, cl.nombre, i.nombre as img');
        $this->db->from('taller_citas c');
        $this->db->join('taller_vehiculos v', 'c.id_vehiculo = v.id');
        $this->db->join('taller_clientes cl', 'v.id_cliente = cl.dni');
        $this->db->join('taller_tareas t', 'c.id_tarea = t.id');
        $this->db->join('taller_imgs i', 'v.id = i.id_vehiculo AND i.principal = 1', 'left');
        $this->db->where('c.estado', 'Esperando_recepcion');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_usuario_por_id($id) {
        return $this->db->get_where('usuarios', ['id' => $id])->row();
    }


// =========================================================================================================================




    public function get_productos_por_presupuesto($presupuesto_id) {
        return $this->db->get_where('taller_presupuesto_productos', ['presupuesto_id' => $presupuesto_id])
                        ->result();
    }

    public function incrementar_stock_producto($id, $cantidad) {
        $this->db->set('stock', 'stock + ' . (int)$cantidad, FALSE)
                 ->where('id', $id)
                 ->update('taller_productos');
    }
    
    public function descontar_stock_producto($id, $cantidad) {
        $this->db->set('stock', 'stock - ' . (int)$cantidad, FALSE)
                 ->where('id', $id)
                 ->update('taller_productos');
    }

    public function eliminar_presupuesto($presupuesto_id) {
        $this->db->trans_start();

        $this->borrar_productos_de_presupuesto($presupuesto_id);
        $this->db->where('id', $presupuesto_id)
                 ->delete('taller_presupuestos');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function borrar_productos_de_presupuesto($presupuesto_id) {
        return $this->db->where('presupuesto_id', $presupuesto_id)
                        ->delete('taller_presupuesto_productos');
    }
    public function eliminar_producto_presupuesto($presupuesto_id, $producto_id) {
        $this->db->where('presupuesto_id', $presupuesto_id)
                ->where('producto_id', $producto_id)
                ->delete('taller_presupuesto_productos');
    }


    public function get_presupuesto_by_cita($cita_id) {
        return $this->db->select('p.*, t.descripcion as tarea_descripcion')
                        ->from('taller_presupuestos p')
                        ->join('taller_tareas t', 'p.tarea_id = t.id')
                        ->where('p.cita_id', $cita_id)
                        ->get()
                        ->row();
    }

    public function get_tarea_id_by_cita($cita_id) {
        $query = $this->db->select('id_tarea')
                          ->from('taller_citas')
                          ->where('id', $cita_id)
                          ->get();
        return $query->num_rows() > 0 ? $query->row()->id_tarea : FALSE;
    }

    public function get_product_tarea($tarea_id) {
        return $this->db->select('p.id, p.nombre, p.descripcion as descripcion_p, p.precio, p.stock, t.descripcion as descripcion_t')
                        ->from('taller_tareas t')
                        ->join('taller_productos p', 't.id = p.id_tarea')
                        ->where('t.id', $tarea_id)
                        ->get()
                        ->result();
    }

    public function get_productos_presupuesto($presupuesto_id) {
        return $this->db->select('pp.producto_id as id, p.nombre, p.precio, pp.cantidad')
                        ->from('taller_presupuesto_productos pp')
                        ->join('taller_productos p', 'p.id = pp.producto_id')
                        ->where('pp.presupuesto_id', $presupuesto_id)
                        ->get()
                        ->result();
    }

    public function actualizar_presupuesto($presupuesto_id, $data) {
        $this->db->where('id', $presupuesto_id);
        return $this->db->update('taller_presupuestos', $data);
    }

    public function get_producto_por_id($id) {
        return $this->db->get_where('taller_productos', ['id' => $id])->row();
    }

    public function insertar_productos($presupuesto_id, $productos) {
        foreach ($productos as $producto) {
            $data = [
                'presupuesto_id' => $presupuesto_id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio']
            ];
            $this->db->insert('taller_presupuesto_productos', $data);
        }
    }

    public function insertar_producto($presupuesto_id, $producto) {
        $data = [
            'presupuesto_id' => $presupuesto_id,
            'producto_id' => $producto['id'],
            'cantidad' => $producto['cantidad'],
            'precio_unitario' => $producto['precio']
        ];
        $this->db->insert('taller_presupuesto_productos', $data);
    }

    public function guardar_presupuesto($cita_id, $tarea_id, $productos) {
        $total = 0;
        $productos_validos = [];

        foreach ($productos as $producto) {
            $producto_db = $this->get_producto_por_id($producto['id']);
            if (!$producto_db || $producto_db->stock < $producto['cantidad']) {
                return FALSE;
            }

            $total += $producto_db->precio * $producto['cantidad'];

            // Preparamos un array limpio con los datos necesarios
            $productos_validos[] = [
                'id' => $producto_db->id,
                'cantidad' => $producto['cantidad'],
                'precio' => $producto_db->precio
            ];
        }

        $this->db->insert('taller_presupuestos', [
            'cita_id' => $cita_id,
            'tarea_id' => $tarea_id,
            'fecha_creacion' => date('Y-m-d'),
            'total' => $total
        ]);

        $presupuesto_id = $this->db->insert_id();

        // Insertamos los productos válidos
        $this->insertar_productos($presupuesto_id, $productos_validos);

        // Descontamos el stock
        foreach ($productos_validos as $producto) {
            $this->descontar_stock_producto($producto['id'], $producto['cantidad']);
        }

        return $presupuesto_id;
    }


    public function actualizar_producto_presupuesto($presupuesto_id, $producto_id, $cantidad) {
        $this->db->where('presupuesto_id', $presupuesto_id)
                ->where('producto_id', $producto_id)
                ->update('taller_presupuesto_productos', [
                    'cantidad' => $cantidad,
                ]);
    }

    public function actualizar_total_presupuesto($presupuesto_id, $nuevo_total) {
        $this->db->where('id', $presupuesto_id)
                ->update('taller_presupuestos', ['total' => $nuevo_total]);
    }

}

