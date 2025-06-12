<?php

class Taller_usuarios_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();  // Esto carga la base de datos

    }

    public function get_users()
    {
        // Aquí puedes definir la consulta para obtener los usuarios del taller
        $query = $this->db->get('usuarios'); // Asegúrate de que 'usuarios' sea el nombre correcto de tu tabla
        return $query->result_array(); // Devuelve los resultados como un array asociativo
    }

    public function guardar_usuario($datos) {
        $nombre = $datos['nombre'];
        $email = $datos['email'];
        $rol = $datos['rol'];
        $password = $datos['password'];
        $firmaBase64 = $datos['firma_base64'];

        // Verificar si el correo ya existe
        if ($this->correo_existe($email)) {
            return false; // Retorna false si el correo ya existe
        }

        try {
            $rutaFirma = $this->guardar_firma($firmaBase64);
        } catch (Exception $e) {
            return false;
        }

        $data = array(
            'nombre' => $nombre,
            'email' => $email,
            'rol' => $rol,
            'firma' => $rutaFirma,
            'password' => $password,
            'fecha_creacion' => date('Y-m-d H:i:s')
        );

        $this->db->insert('usuarios', $data);
        return $this->db->insert_id();
    }

    private function guardar_firma($firmaBase64) {
        $firmaBase64 = explode(',', $firmaBase64);
        $data = base64_decode($firmaBase64[1]);

        $ruta = 'assets/firmas/usuario_' . uniqid() . '.png';

        if (!file_exists('assets/firmas')) {
            mkdir('assets/firmas', 0777, true);
        }

        if (file_put_contents($ruta, $data) === false) {
            throw new Exception("No se pudo guardar la firma en el servidor.");
        }

        return $ruta;
    }

    public function correo_existe($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        return $query->num_rows() > 0;
    }

    public function eliminar_usuario($usuario_id) {
        $this->db->where('id', $usuario_id);
        return $this->db->delete('usuarios');
    }

     public function obtener_usuario($usuario_id) {
        $this->db->where('id', $usuario_id);
        $query = $this->db->get('usuarios');
        return $query->row_array();
    }

    public function actualizar_usuario($usuario_id, $datos) {
        if (isset($datos['firma_base64'])) {
            $rutaFirma = $this->guardar_firma($datos['firma_base64']);
            $datos['firma'] = $rutaFirma;
            unset($datos['firma_base64']); // Eliminar el campo base64 ya que no se guarda en la base de datos
        }

        $this->db->where('id', $usuario_id);
        return $this->db->update('usuarios', $datos);
    }

    public function filtrar_usuarios($nombre, $email, $rol) {
        if ($nombre) {
            $this->db->like('nombre', $nombre);
        }
        if ($email) {
            $this->db->like('email', $email);
        }
        if ($rol) {
            $this->db->where('rol', $rol);
        }

        $query = $this->db->get('usuarios');
        return $query->result_array();
    }

}

?>