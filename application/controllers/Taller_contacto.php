<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taller_contacto extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cargamos el modelo correspondiente
        $this->load->helper('html');
        $this->load->library(['form_validation', 'session']);
    }

    // Página principal de gestión de vehículos
    public function index()
    {
        $data['id_nav_back'] = 50;
        $data['acceso'] = $this->valida_acceso();

         if (!$data['acceso']) {
            $this->session->set_flashdata('error', 'Acceso denegado');
            redirect('usuario/login');
        }

        // Datos para la vista
        $data['lang'] = 'es';
        $data['title'] = 'Panel de control | Gestión de Vehículos';
        $data['keywords'] = '';
        $data['description'] = '';
        $data['reference'] = 'Contacto';
        $data['view'] = 'inicio';
        $data['page'] = 'Contacto';
        $data['icono'] = 'fa fa-car'; // Asegúrate de que haya un icono definido o coméntalo si no es necesario
        $data['robots'] = 'noindex, nofollow';

        // JS/CSS: si usas archivos dentro de vistas parciales
        $data["js"] = $this->load->view("taller_contacto/js_module/js_module", "", TRUE);
        $data['css'] = $this->load->view('taller_contacto/css_module/css_module', '', TRUE);

        // Vista principal con layout
        $this->load->view('taller_contacto/contacto', $data);
    }

    // Función ficticia para validación de acceso (debes implementarla)
    private function valida_acceso()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('usuario/login');
        }

        $usuario = $this->session->userdata('usuario');

        if ($usuario && isset($usuario['rol'])) {
            switch ($usuario['rol']) {
                case 'admin':
                    return [2];
                case 'taller':
                    return [1];
                case 'empleado':
                    return [0];
            }
        }
        return;
    }

public function enviar()
{
    $this->load->library('email');

    $nombre   = $this->input->post('nombre_first') . ' ' . $this->input->post('nombre_last');
    $email    = $this->input->post('email');
    $telefono = $this->input->post('telefono');
    $mensaje  = $this->input->post('mensaje');

    $this->email->from('TU_CORREO@gmail.com', 'Formulario de contacto');
    $this->email->to('alvarofalconeti@gmail.com');
    $this->email->reply_to($email);
    $this->email->subject('Nuevo mensaje de contacto');
    $this->email->message("Nombre: $nombre\nCorreo: $email\nTeléfono: $telefono\n\nMensaje:\n$mensaje");

    if ($this->email->send()) {
        echo json_encode(['success' => true, 'msg' => '¡Mensaje enviado correctamente!']);
    } else {
        echo json_encode(['success' => false, 'msg' => $this->email->print_debugger(['headers'])]);
    }
}


    
    
    
}
?>
