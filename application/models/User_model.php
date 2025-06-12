<?php
class User_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function register($data) {
        // Hashear la contraseña con password_hash
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->db->insert('usuarios', $data);
    }

    public function login($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        $user = $query->row();

        if ($user && $password === $user->password) {
            return $user;
        }

        return false;
    }

    public function get_user_by_email($email) {
        return $this->db->get_where('usuarios', ['email' => $email])->row();
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('usuarios', ['id' => $id])->row();
    }
}
?>
