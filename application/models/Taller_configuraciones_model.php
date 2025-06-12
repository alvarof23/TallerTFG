<?php
class Taller_configuraciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();  // Esto carga la base de datos
    }

    public function get_configuraciones(){
        $this->db->select('*');
        $this->db->from('taller_configuraciones');
        $query = $this->db->get(); // Ejecuta la consulta
        return $query->result_array(); // Devuelve los resultados como array asociativo
    }

    public function get_area(){
        $this->db->select('*');
        $this->db->from('taller_area_trabajo');
        $query = $this->db->get(); // Ejecuta la consulta
        return $query->result_array(); // Devuelve los resultados como array asociativo
    }

    public function get_tareas_agrupadas_por_area(){
        $this->db->select('t.*, t.id as id_tarea, a.*, a.id as id_area');
        $this->db->from('taller_tareas t');
        $this->db->join('taller_area_trabajo a', 't.id_area_trabajo = a.id');
        $query = $this->db->get(); // Ejecuta la consulta
        return $query->result_array(); // Devuelve los resultados como array asociativo
    }

    public function insertar_conf($data) {
        return $this->db->insert('taller_configuraciones', $data);
    }

    public function update_configuracion($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('taller_configuraciones', $data);
    }

    public function delete_configuracion($id) {
        $this->db->where('id', $id);
        return $this->db->delete('taller_configuraciones');
    }

    
    public function add_tarea($nueva_tarea){
        return $this->db->insert('taller_tareas', $nueva_tarea);

    }

    public function delete_tarea($id) {
        $this->db->where('id', $id);
        return $this->db->delete('taller_tareas');
    }

    public function update_tarea($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('taller_tareas', $data);
    }

    public function insert_area($data) {
        $query = $this->db->insert('taller_area_trabajo', $data);
        return $query;
    }
    
    
    public function update_area($id_area, $data_area) {
        $this->db->where('id', $id_area);
        return $this->db->update('taller_area_trabajo', $data_area);
    }
    
    public function eliminar_area($id) {
        return $this->db->where('id', $id)->delete('taller_area_trabajo');
    }

    
    public function get_tareas_por_area($area_id) {
        return $this->db->where('id_area_trabajo', $area_id)->get('taller_tareas')->result_array();
    }

    
    public function get_productos_por_tarea($tarea_id) {
        return $this->db->where('id_tarea', $tarea_id)->get('taller_productos')->result_array();
    }
    
    
    public function insert_producto($data) {
        $this->db->insert('taller_productos', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function eliminar($id) {
        $this->db->where('id', $id);
        return $this->db->delete('taller_productos');
    }
    
    public function get_product($product_id) {
        $this->db->select('*');
        $this->db->from('taller_productos');
        $this->db->where('id', $product_id);
        $query = $this->db->get(); // Ejecuta la consulta
        return $query->row();

    }

    public function actualizar_producto($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('taller_productos', $data);
    }

    public function get_taller(){
        $this->db->select('*');
        $this->db->from('taller_organizacion');
        $query = $this->db->get();
        return $query->row();
    }

    public function actualizar_taller($data) {
        $this->db->where('id', 1);
        return $this->db->update('taller_organizacion', $data);
    }
}
?>