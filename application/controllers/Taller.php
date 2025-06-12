<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cargamos el modelo correspondiente
        $this->load->model('Taller_model');
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
        $data['reference'] = 'TALLER';
        $data['view'] = 'inicio';
        $data['page'] = 'Taller';
        $data['icono'] = 'fa fa-car'; // Asegúrate de que haya un icono definido o coméntalo si no es necesario
        $data['robots'] = 'noindex, nofollow';

        // JS/CSS: si usas archivos dentro de vistas parciales
        $data["js"] = $this->load->view("taller/js_module/js_module", "", TRUE);
        $data['css'] = $this->load->view('taller/css_module/css_module', '', TRUE);

        // Datos reales para la vista
        $data['citas_hoy'] = $this->Taller_model->contar_citas_hoy();
        $data['vehiculos_taller'] = $this->Taller_model->contar_vehiculos_reparacion();
        $data['clientes_registrados'] = $this->Taller_model->contar_clientes();
        $data['citas_pendientes'] = $this->Taller_model->contar_citas_pendientes(); // Nuevo: Citas pendientes
        $data['citas_actuales'] = $this->Taller_model->obtener_proximas_citas(); // Nuevo: Próximas citas del día
        $data['proximas_citas'] = $this->Taller_model->obtener_citas_mañana(); // Nuevo: Próximas citas del día

        $usuario = $this->session->userdata('usuario');
        $data['usuario_nombre'] = $usuario['nombre'];

        // Vista principal con layout
        $this->load->view('taller/inicio', $data);
    }

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
}
?>
