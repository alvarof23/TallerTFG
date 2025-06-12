<?php
class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function registro() {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('email', 'Correo', 'required|valid_email|is_unique[usuarios.email]');
        $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirmar Contraseña', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/registro');
        } else {
            $data = [
                'nombre' => $this->input->post('nombre'),
                'email'  => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'rol' => 'empleado' // o 'taller' o 'admin' según lo que necesites
            ];
            $this->User_model->register($data);
            $this->session->set_flashdata('msg', 'Registro correcto, ahora puedes iniciar sesión');
            redirect('usuario/login');
        }
    }

    public function login() {
        // Si es GET, simplemente mostramos la vista
        if ($this->input->method() === 'get') {
            $data = [];

            // Carga mensajes flash si existen
            if ($this->session->flashdata('error')) {
                $data['error'] = $this->session->flashdata('error');
            }
            if (validation_errors()) {
                $data['validation_errors'] = validation_errors();
            }

            $this->load->view('usuario/login', $data);
            return;
        }

        // Si es POST, procesamos
        $this->form_validation->set_rules('email', 'Correo', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Guardamos errores en flashdata y redirigimos para evitar recarga POST
            $this->session->set_flashdata('error', validation_errors());
            redirect('usuario/login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->login($email, $password);

            if ($user) {
                // loguear, crear sesión
                $this->session->set_userdata('usuario', [
                    'id'    => $user->id,
                    'nombre'=> $user->nombre,
                    'email' => $user->email,
                    'rol'   => $user->rol
                ]);
                $this->session->set_userdata('logged_in', TRUE);
                redirect('taller');
            } else {
                // En vez de cargar la vista directamente,
                // guardamos error en flashdata y redirigimos
                $this->session->set_flashdata('error', 'Credenciales incorrectas');
                redirect('usuario/login');
            }


        }
    }


    public function logout() {
        $this->session->sess_destroy();
        redirect('usuario/login');
    }
}
?>
