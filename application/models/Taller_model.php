<?php

class Taller_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->database();  // Esto carga la base de datos
    }
    public function contar_citas_hoy()
    {
        $hoy = date('Y-m-d');
        return $this->db->where('fecha', $hoy)->count_all_results('taller_citas');
    }

    public function contar_vehiculos_reparacion()
    {
        return $this->db->where('estado', 'Procesando')->count_all_results('taller_citas');
    }

    public function contar_clientes()
    {
        return $this->db->count_all('taller_clientes');
    }

    // Contar citas pendientes (citas que no están confirmadas)
    public function contar_citas_pendientes()
    {
        $this->db->where('estado', 'Esperando_recepcion'); // Suponiendo que el campo 'estado' indica el estado de la cita
        return $this->db->count_all_results('taller_citas');
    }

    // Obtener próximas citas del día
    public function obtener_proximas_citas() {
        
        $fecha_hoy = date('Y-m-d');

        $this->db->select('c.*, v.id_cliente, v.num_bastidor, v.color, v.matricula, v.kilometros, t.descripcion, t.tiempo_estimado, cl.nombre, i.nombre as img');
        $this->db->from('taller_citas c');
        $this->db->join('taller_vehiculos v', 'c.id_vehiculo = v.id');
        $this->db->join('taller_clientes cl', 'v.id_cliente = cl.dni');
        $this->db->join('taller_tareas t', 'c.id_tarea = t.id');
        $this->db->join('taller_imgs i', 'v.id = i.id_vehiculo AND i.principal = 1', 'left');
        $this->db->where('fecha', $fecha_hoy);
        $this->db->order_by('hora', 'ASC'); // Ordenar por hora

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function obtener_citas_mañana() {
        $fecha_hoy = date('Y-m-d');

        $fecha_mañana = date('Y-m-d', strtotime('+1 day'));
        $fecha_semana = date('Y-m-d', strtotime('+8 day'));

        $this->db->select('c.*, v.id_cliente, v.num_bastidor, v.color, v.matricula, v.kilometros, t.descripcion, t.tiempo_estimado, cl.nombre, i.nombre as img');
        $this->db->from('taller_citas c');
        $this->db->join('taller_vehiculos v', 'c.id_vehiculo = v.id');
        $this->db->join('taller_clientes cl', 'v.id_cliente = cl.dni');
        $this->db->join('taller_tareas t', 'c.id_tarea = t.id');
        $this->db->join('taller_imgs i', 'v.id = i.id_vehiculo AND i.principal = 1', 'left');
        $this->db->where('fecha >', $fecha_hoy);
        $this->db->where('fecha <', $fecha_semana);
        $this->db->order_by('hora', 'ASC'); // Ordenar por hora

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
}

?>