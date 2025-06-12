<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taller_configuraciones extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cargamos el modelo correspondiente
        $this->load->model('Taller_configuraciones_model');
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
        $data['reference'] = 'TALLER_CONFIGURACIONES';
        $data['view'] = 'inicio';
        $data['page'] = 'Configuraciones';
        $data['icono'] = 'fa fa-wrench'; // Asegúrate de que haya un icono definido o coméntalo si no es necesario
        $data['robots'] = 'noindex, nofollow';

        // JS/CSS: si usas archivos dentro de vistas parciales
        $data["js"] = $this->load->view("taller_configuraciones/js_module/js_module", '', TRUE);
        $data['css'] = $this->load->view('taller_configuraciones/css_module/css_module', '', TRUE);

        // Datos reales para la vista
        $data['configuraciones'] = $this->Taller_configuraciones_model->get_configuraciones();

        $data['areas_trabajo'] = $this->Taller_configuraciones_model->get_area();
        $data['tareas_por_area'] = $this->Taller_configuraciones_model->get_tareas_agrupadas_por_area();

        $data['taller'] = $this->Taller_configuraciones_model->get_taller();


        // Vista principal con layout
        $this->load->view('taller_configuraciones/list_configuraciones', $data);
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
    public function guardar_configuracion() {
    
        $data = [
            'hora_inicio' => $this->input->post('hora_inicio'),
            'hora_fin' => $this->input->post('hora_fin'),
            'duracion_intervalo' => $this->input->post('duracion_intervalo'),
            'simultaneo' => $this->input->post('simultaneo'),
        ];
    
        // Validaciones básicas
        if (!$data['hora_inicio'] || !$data['hora_fin'] || !$data['duracion_intervalo'] || !$data['simultaneo']) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos obligatorios']);
            return;
        }
    
        $inserted = $this->Taller_configuraciones_model->insertar_conf($data);
    
        if ($inserted) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo guardar la configuración']);
        }
    }

    public function editar_configuracion() {

        $data = [
            'hora_inicio' => $this->input->post('hora_inicio'),
            'hora_fin' => $this->input->post('hora_fin'),
            'duracion_intervalo' => $this->input->post('duracion_intervalo'),
            'simultaneo' => $this->input->post('simultaneo'),
        ];

        $id = $this->input->post('id');

        $update = $this->Taller_configuraciones_model->update_configuracion($id, $data);

        if ($update) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar la configuración.']);
        }
    }

    public function eliminar_configuracion() {
    
        $id = $this->input->post('id');
    
        if (empty($id) || !is_numeric($id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID inválido']);
            return;
        }
    
        $delete = $this->Taller_configuraciones_model->delete_configuracion($id);
    
        if ($delete) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar la configuración.']);
        }
    }

    

    public function guardar_tarea()
    {
        $data = [
            'id_area_trabajo' => $this->input->post('id_area'),
            'descripcion' => $this->input->post('descripcion'),
            'tiempo_estimado' => $this->input->post('tiempo_estimado'),
            'precio_unitario' => $this->input->post('precio_unitario'),
            'max_unidades' => $this->input->post('max_unidades'),
            'externa' => $this->input->post('externa'),
        ];
        $add = $this->Taller_configuraciones_model->add_tarea($data);

        if ($add){
            $response = [
                "status" => "success"
            ];
        }else{
            $response = [
                "status" => "error"
            ]; 
        }
        

        echo json_encode($response);


    }

    public function editar_tarea() {
        $id = $this->input->post('id');
        $data = array(
            'descripcion' => $this->input->post('descripcion'),
            'tiempo_estimado' => $this->input->post('tiempo_estimado'),
            'precio_unitario' => $this->input->post('precio_unitario'),
            'max_unidades' => $this->input->post('max_unidades'),
            'externa' => $this->input->post('externa'),
        );
    
        $update = $this->Taller_configuraciones_model->update_tarea($id, $data);

        
    
        if ($update) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    


    public function eliminar_tarea() {
        $id = $this->input->post('id');
    
        $this->load->model('Taller_configuraciones_model');
        $eliminado = $this->Taller_configuraciones_model->delete_tarea($id);
    
        if ($eliminado) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function guardar_area() {
        // Verifica que sea una petición POST
    
        $nombre = $this->input->post('nombre');
        $codigo = $this->input->post('codigo');
        $id_configuracion = $this->input->post('configuracion_id');

        // Validación básica
        if (empty($nombre) || empty($codigo)) {
            echo json_encode(['status' => 'error', 'message' => 'Nombre y código son obligatorios.']);
            return;
        }

        $data = [
            'nombre' => $nombre,
            'codigo' => $codigo,
            'id_configuracion' => $id_configuracion ?: null, // puede ser null si está vacío
        ];

        // Inserta en la base de datos
        $insertado = $this->Taller_configuraciones_model->insert_area($data);

        if ($insertado) {
            echo json_encode(['status' => 'ok', 'message' => 'Área guardada correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo guardar el área.']);
        }

       
    }
    
    public function editar_area() {
        $id = $this->input->post('id');
        $data_area = array(
            'nombre' => $this->input->post('nombre'),
            'codigo' => $this->input->post('codigo'),
            'id_configuracion' => $this->input->post('id_configuracion'),
            
        );
    
        $update = $this->Taller_configuraciones_model->update_area($id, $data_area);
    
        if ($update) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function eliminar_area() {
        $id = $this->input->post('id');
    
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado.']);
            return;
        }
    
        $eliminado = $this->Taller_configuraciones_model->eliminar_area($id);
    
        if ($eliminado) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar.']);
        }
    }
    
    
    

    public function get_tareas_por_area() {
        $area_id = $this->input->post('area_id');
        $tareas = $this->Taller_configuraciones_model->get_tareas_por_area($area_id);
        echo json_encode($tareas);
    }
    
    public function get_productos_por_tarea() {
        $tarea_id = $this->input->post('tarea_id');
        $productos = $this->Taller_configuraciones_model->get_productos_por_tarea($tarea_id);
        echo json_encode($productos);
    }
    

    public function crear_producto() {
        $id_tarea = $this->input->post('id_tarea');
        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('descripcion');
        $precio = $this->input->post('precio');
        $stock = $this->input->post('stock');

        if (!$id_tarea || !$nombre) {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
            return;
        }

        $data = [
            'id_tarea' => $id_tarea,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio ?: 0,
            'stock' => $stock,
        ];

        $insert_id = $this->Taller_configuraciones_model->insert_producto($data);

        if ($insert_id) {
            echo json_encode(['status' => 'success', 'id_tarea' => $id_tarea]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo guardar el producto']);
        }
    }


    public function eliminar_producto() {
        $id = $this->input->post('product_id');
    
        if ($this->Taller_configuraciones_model->eliminar($id)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function cargar_producto() {
        $product_id = $this->input->post('product_id');
        $producto = $this->Taller_configuraciones_model->get_product($product_id);
    
        if ($producto) {
            echo json_encode([
                'status' => 'success',
                'producto' => $producto
            ]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function editar_producto()
    {
        $producto_id = $this->input->post('id_producto');

        $data = [
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion'),
            'precio' => $this->input->post('precio'),
            'stock' => $this->input->post('stock')
            // no se actualiza tarea_id aquí para mantener la relación original
        ];

        if ($this->Taller_configuraciones_model->actualizar_producto($producto_id, $data)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Producto actualizado correctamente',
                'id_tarea' => $this->input->post('tarea_id')
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo actualizar el producto'
            ]);
        }
    }

    public function get_conf() {
        $configuraciones = $this->Taller_configuraciones_model->get_configuraciones(); // o el método que uses
        echo json_encode($configuraciones);
    }
    

    public function get_Tarea() {
        $tareas = $this->Taller_configuraciones_model->get_area(); // o el método que uses
        echo json_encode($tareas);
    }

    
    public function get_Tarea_area() {
        $tareas = $this->Taller_configuraciones_model->get_tareas_agrupadas_por_area(); // o el método que uses
        echo json_encode($tareas);
    }

    public function get_Areas() {
        $areas_trabajo = $this->Taller_configuraciones_model->get_area(); // o el método que uses
        $configuraciones = $this->Taller_configuraciones_model->get_configuraciones(); // o el método que uses

        $respuesta = [
            'areas' => $areas_trabajo,
            'configuraciones' => $configuraciones
        ];

        echo json_encode($respuesta);
    }


    public function guardar_taller(){
    $this->form_validation->set_rules('nombre', 'Nombre del Taller', 'required');

    if ($this->form_validation->run() == FALSE) {
        $response = [
            'success' => false,
            'message' => validation_errors()
        ];
        echo json_encode($response);
        return;
    }

    $data = [
        'nombre' => $this->input->post('nombre', TRUE),
        'telefono' => $this->input->post('telefono', TRUE),
        'email' => $this->input->post('email', TRUE),
        'direccion' => $this->input->post('direccion', TRUE),
        'codigo_postal' => $this->input->post('codigo_postal', TRUE),
        'localidad' => $this->input->post('localidad', TRUE),
        'provincia' => $this->input->post('provincia', TRUE),
        'pais' => $this->input->post('pais', TRUE),
        'nif' => $this->input->post('nif', TRUE),
        'horario_atencion_cliente' => $this->input->post('horario_atencion_cliente', TRUE),
    ];

    // Obtener logo actual antes de subir el nuevo
    $taller = $this->Taller_configuraciones_model->get_taller(); // Asegúrate de tener este método
    $logo_actual = isset($taller->logo) ? $taller->logo : null;

    if (!empty($_FILES['logo']['name'])) {
        $config['upload_path'] = './assets/img/empresa/logo/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['file_name'] = 'logoTaller_' . time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('logo')) {
            $response = [
                'success' => false,
                'message' => $this->upload->display_errors()
            ];
            echo json_encode($response);
            return;
        } else {
            $upload_data = $this->upload->data();
            $nuevo_logo = 'assets/img/empresa/logo/' . $upload_data['file_name'];

            // Eliminar el logo anterior si existe
            if ($logo_actual && file_exists(FCPATH . $logo_actual)) {
                unlink(FCPATH . $logo_actual);
            }

            $data['logo'] = $nuevo_logo;
        }
    }

    $ok = $this->Taller_configuraciones_model->actualizar_taller($data);

    if ($ok) {
        $taller_actualizado = $this->Taller_configuraciones_model->get_taller(); // Devuelve el taller actualizado

        $response = [
            'success' => true,
            'message' => 'Datos guardados correctamente.',
            'taller' => $taller_actualizado
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error al guardar los datos.'
        ];
    }


    echo json_encode($response);
}

}
?>
