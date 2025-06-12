<?php
class Taller_clientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();  // Esto carga la base de datos
    }

    // public function get_clientes() {
    //     $this->db->select('cl.*');
    //     $this->db->from('taller_clientes cl');
    //     $this->db->join('taller_vehiculos v', 'cl.dni = v.id_cliente', 'left');
    //     $this->db->join('taller_citas c', 'v.id = c.id_vehiculo', 'left');
    //     $query = $this->db->get(); // Ejecuta la consulta
    //     return $query->result_array(); // Devuelve los resultados como array asociativo
    // }
    

    public function get_clientes() {
        $this->db->select('cl.*');
        $this->db->from('taller_clientes cl');
        $query = $this->db->get(); // Ejecuta la consulta
        return $query->result_array(); // Devuelve los resultados como array asociativo
    }
    

    public function get_cliente($dni) {
        $this->db->where('dni', $dni);
        return $this->db->get('taller_clientes')->row_array();
    }

    public function guardar_cliente($data) {
        $this->db->where('dni', $data['dni']);
        $query = $this->db->get('taller_clientes');

        if ($query->num_rows() > 0) {
            // Actualizar cliente existente
            $this->db->where('dni', $data['dni']);
            return $this->db->update('taller_clientes', $data);
        } else {
            // Insertar nuevo cliente
            return $this->db->insert('taller_clientes', $data);
        }
    }

    public function eliminar_cliente($dni) {
        $this->db->where('dni', $dni);
        return $this->db->delete('taller_clientes');
    }

    public function buscar_clientes($buscar) {
        $this->db->like('dni', $buscar);
        $this->db->or_like('nombre', $buscar);
        $this->db->or_like('telefono', $buscar);
        $this->db->or_like('correo_electronico', $buscar);
        return $this->db->get('taller_clientes')->result_array();
    }
}
?>