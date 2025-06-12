<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taller_usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cargamos el modelo correspondiente
        $this->load->model('Taller_usuarios_model');
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

        if($data['acceso'][0] == 0) {
            $this->session->set_flashdata('error', 'Acceso denegado');
            redirect('usuario/login');
        }
        
        // Datos para la vista
        $data['lang'] = 'es';
        $data['title'] = 'Panel de control | Gestión de Vehículos';
        $data['keywords'] = '';
        $data['description'] = '';
        $data['reference'] = 'TALLER USUARIOS';
        $data['view'] = 'inicio';
        $data['page'] = 'Usuarios';
        $data['icono'] = 'fa-solid fa-users'; // Asegúrate de que haya un icono definido o coméntalo si no es necesario
        $data['robots'] = 'noindex, nofollow';

        // JS/CSS: si usas archivos dentro de vistas parciales
        $data["js"] = $this->load->view('taller_usuarios/js_module/js_module', '', TRUE);
        $data['css'] = $this->load->view('taller_usuarios/css_module/css_module', '', TRUE);

        // Datos reales para la vista
        $data['users'] = $this->Taller_usuarios_model->get_users();

        // Vista principal con layout
        $this->load->view('taller_usuarios/list_users', $data);
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

    public function guardar_usuario() {
        header('Content-Type: application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'No se permite el acceso directo']);
            return;
        }

        $nombre = $this->input->post('nombre');
        $email = $this->input->post('email');
        $rol = $this->input->post('rol');
        $password = $this->input->post('password');
        $firmaBase64 = $this->input->post('firma_base64');

        if (empty($nombre) || empty($email) || empty($rol)) {
            echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios']);
            return;
        }

        $datos = array(
            'nombre' => $nombre,
            'email' => $email,
            'rol' => $rol,
            'password' => $password,
            'firma_base64' => $firmaBase64
        );

        $usuario_id = $this->Taller_usuarios_model->guardar_usuario($datos);

        if ($usuario_id) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario guardado con éxito', 'usuario_id' => $usuario_id]);
        } else {
            if ($this->Taller_usuarios_model->correo_existe($email)) {
                echo json_encode(['status' => 'error', 'message' => 'El correo electrónico ya está registrado']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al guardar el usuario']);
            }
        }
    }

     public function eliminar_usuario() {
        header('Content-Type: application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'No se permite el acceso directo']);
            return;
        }

        $usuario_id = $this->input->post('usuario_id');

        if (empty($usuario_id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID de usuario es obligatorio']);
            return;
        }

        $eliminado = $this->Taller_usuarios_model->eliminar_usuario($usuario_id);

        if ($eliminado) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario eliminado con éxito']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el usuario']);
        }
    }

    public function obtener_usuario() {
        header('Content-Type: application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'No se permite el acceso directo']);
            return;
        }

        $usuario_id = $this->input->post('usuario_id');

        if (empty($usuario_id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID de usuario es obligatorio']);
            return;
        }

        $usuario = $this->Taller_usuarios_model->obtener_usuario($usuario_id);

        if ($usuario) {
            echo json_encode(['status' => 'success', 'data' => $usuario]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
        }
    }

    public function actualizar_usuario() {
        header('Content-Type: application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'No se permite el acceso directo']);
            return;
        }

        $usuario_id = $this->input->post('usuario_id');
        $nombre = $this->input->post('nombre');
        $email = $this->input->post('email');
        $rol = $this->input->post('rol');
        $password = $this->input->post('password');
        $firmaBase64 = $this->input->post('firma_base64');

        if (empty($usuario_id) || empty($nombre) || empty($email) || empty($rol)) {
            echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios']);
            return;
        }

        $datos = array(
            'nombre' => $nombre,
            'email' => $email,
            'rol' => $rol,
            'password' => $password
        );

        if (!empty($firmaBase64)) {
            $datos['firma_base64'] = $firmaBase64;
        }

        $actualizado = $this->Taller_usuarios_model->actualizar_usuario($usuario_id, $datos);

        if ($actualizado) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario actualizado con éxito']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el usuario']);
        }
    }

    public function listar_usuarios(){
        header('Content-Type: application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'No se permite el acceso directo']);
            return;
        }

        $usuarios = $this->Taller_usuarios_model->get_users();

        $html = '';
        if ($usuarios) {
            foreach ($usuarios as $user) {
                
                $html .= '<tr>';
                $html .= '<td>' . $user['id'] . '</td>';
                $html .= '<td>' . $user['nombre'] . '</td>';
                $html .= '<td>' . $user['email'] . '</td>';
                $html .= '<td>' . $user['rol'] . '</td>';
                $html .= '<td>' . date('Y-m-d H:i:s', strtotime($user['fecha_creacion'])) . '</td>';
                $html .= '<td><img src="' . base_url($user['firma']) . '" alt="" height="94px" style="display: block; margin: 0 auto;"></td>';
                $html .= '<td>
                            <button class="btn btn-info btn-sm editar_usuario" title="Editar" data-usuario-id="' . $user['id'] . '">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-sm eliminar_usuario" title="Eliminar" data-usuario-id="' . $user['id'] . '">
                                <i class="fa fa-trash"></i>
                            </button>
                          </td>';
                $html .= '</tr>';
            }
        }

         // Verificar si hay usuarios

        if ($usuarios) {
            echo json_encode(['status' => 'success', 'data' => $html]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontraron usuarios']);
        }
    }

    public function filtrar_usuarios() {
        header('Content-Type: application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'No se permite el acceso directo']);
            return;
        }

        $nombre = $this->input->post('nombre');
        $email = $this->input->post('email'); 
        $rol = $this->input->post('rol');

        $usuarios = $this->Taller_usuarios_model->filtrar_usuarios($nombre, $email, $rol);

        $html = '';
        if ($usuarios) {
            foreach ($usuarios as $user) {
                $html .= '<tr>';
                $html .= '<td>' . $user['id'] . '</td>';
                $html .= '<td>' . $user['nombre'] . '</td>';
                $html .= '<td>' . $user['email'] . '</td>';
                $html .= '<td>' . $user['rol'] . '</td>';
                $html .= '<td>' . date('Y-m-d H:i:s', strtotime($user['fecha_creacion'])) . '</td>';
                $html .= '<td><img src="' . base_url($user['firma']) . '" alt="" height="94px" style="display: block; margin: 0 auto;"></td>';
                $html .= '<td>
                            <button class="btn btn-info btn-sm editar_usuario" title="Editar" data-usuario-id="' . $user['id'] . '">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-sm eliminar_usuario" title="Eliminar" data-usuario-id="' . $user['id'] . '">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>';
                $html .= '</tr>';
            }
        }else {
            $html .= '<tr><td colspan="7" class="text-center">No se encontraron usuarios</td></tr>';
        }


        echo json_encode(['status' => 'success', 'data' => $html]);
    }
    
}
?>
