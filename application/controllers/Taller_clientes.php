<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taller_clientes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cargamos el modelo correspondiente
        $this->load->model('Taller_clientes_model');
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
        $data['reference'] = 'TALLER CLIENTES';
        $data['view'] = 'inicio';
        $data['page'] = 'Clientes';
        $data['icono'] = 'fa-solid fa-users'; // Asegúrate de que haya un icono definido o coméntalo si no es necesario
        $data['robots'] = 'noindex, nofollow';

        // JS/CSS: si usas archivos dentro de vistas parciales
        $data["js"] = $this->load->view('taller_clientes/js_module/js_module', '', TRUE);
        $data['css'] = $this->load->view('taller_clientes/css_module/css_module', '', TRUE);

        // Datos reales para la vista
        $data['clientes'] = $this->Taller_clientes_model->get_clientes();

        // Vista principal con layout
        $this->load->view('taller_clientes/list_clientes', $data);
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

    
    public function get_cliente()
    {
        $dni = $this->input->post('id_cliente');
        $cliente = $this->Taller_clientes_model->get_cliente($dni);

        if ($cliente) {
            echo json_encode($cliente);
        } else {
            echo json_encode(['error' => 'Cliente no encontrado']);
        }
    }

    public function guardar_cliente()
    {
        $this->form_validation->set_rules('dni', 'DNI', 'required');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('telefono', 'Teléfono', 'required');
        $this->form_validation->set_rules('correo_electronico', 'Correo Electrónico', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            // Validación fallida
            echo json_encode([
                "success" => "validacion",
                "message" => validation_errors()
            ]);
        } else {
            // Guardar cliente
            $guardado = $this->Taller_clientes_model->guardar_cliente([
                'dni' => $this->input->post('dni'),
                'nombre' => $this->input->post('nombre'),
                'telefono' => $this->input->post('telefono'),
                'correo_electronico' => $this->input->post('correo_electronico'),
                'id_organizacion' => '1'
            ]);
            if ($guardado) {
                echo json_encode([
                    "success" => true,
                    "message" => "Cliente guardado con éxito."
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Por favor revise todos los campos."
                ]);
            }
        }
    }

    public function eliminar_cliente($dni)
    {
        $eliminado = $this->Taller_clientes_model->eliminar_cliente($dni);

        if ($eliminado) {
            redirect('clientes');
        } else {
            echo json_encode(['error' => 'Error al eliminar el cliente']);
        }

    }

    public function buscar_clientes()
    {
        $buscar = $this->input->post('buscar');
        $data['clientes'] = $this->Taller_clientes_model->buscar_clientes($buscar);

        
        if ($data['clientes']) {
            echo json_encode([
                "success" => true,
                "cliente" => $data['clientes']
            ]);
        } else {
            echo json_encode([
                "success" => false,
            ]);
        }
    }

    public function get_clientes()
    {
        $data['clientes'] = $this->Taller_clientes_model->get_clientes();
        if ($data['clientes']) {
            echo json_encode([
                "success" => true,
                "cliente" => $data['clientes']
            ]);
        } else {
            echo json_encode([
                "success" => false,
            ]);
        }
    }
}
?>
