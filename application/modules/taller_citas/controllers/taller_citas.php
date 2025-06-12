<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH."third_party/MX/Controller.php";

class Taller_citas extends MX_Controller
{
    private $lang = "";
    private $icono = "";

    public function __construct()
    {
        parent::__construct();
        
		$this->lang = "es";
		$this->icono = "fa fa-car";
        $this->load->model("Taller_citas_model");
    }



//------------------Index----------------------------------------------------------------------------------------------------------------------------------------------
    public function index()
	{
        
		$data['id_nav_back'] = 50;
		$data['acceso'] = $this->valida_acceso();

		if ($data['acceso'][0] == 1)
		{
			$data["lang"] = $this->lang;
			$data["title"] = "Panel de control | Gestión de Vehículos";
            $data["keywords"] = "";
			$data["description"] = "";
			$data["reference"] = "Index";
			$data["view"] = "list_citas";
			$data["page"] = "Taller_citas";
			$data["icono"] = $this->icono;
            $data["robots"] = "noindex, nofollow";
			$data["js"] = $this->load->view("js_module/js_module", ["reference" => $data["reference"]], TRUE);
			
			$data['css'] = $this->load->view('css_module/css_module', '', TRUE);

			$data['idPaginaVehiculo'] = $this->input->post('id');

			if(!$data['idPaginaVehiculo']){

				$data["list_citas"] = $this->Taller_citas_model->get_list_citas();

			}else{

				$data["list_citas"] = $this->Taller_citas_model->get_list_citas_vehiculo($data['idPaginaVehiculo']);

			}

			
			$data['clientes'] = $this->Taller_citas_model->get_clientes();
			
			$data["areasTrabajo"] = $this->Taller_citas_model->get_areasTrabajo_activas();

			$data["tareas"] = $this->Taller_citas_model->get_tareas();
			$data["optionsEstado"] = $this->Taller_citas_model->get_opciones_estado();

			$this->load->view("layout", $data);
		}
		else
		{
			redirect('');
		}
	}

	// Simulación de permisos (acceso, agregar, editar, eliminar)
	private function valida_acceso()
    {
        return array(1, 1, 1, 1); 
    }
	//------------------FIN Index----------------------------------------------------------------------------------------------------------------------------------------------


	public function getMatriculas(){
	
		$id_cliente = $this->input->post('id_cliente');
		$this->load->model('Taller_citas_model');
		$vehiculos = $this->Taller_citas_model->get_matricula_cliente($id_cliente);
		$cliente = $this->Taller_citas_model->get_cliente($id_cliente); // solo uno
	
		if (!$vehiculos) {
			echo json_encode(['matriculas' => [], 'ids' => [], 'cliente' => $cliente]);
			return;
		}
	
		$matriculas = [];
		$ids = [];
	
		foreach ($vehiculos as $vehiculo) {
			$matriculas[] = $vehiculo->matricula;
			$ids[] = $vehiculo->id;
		}
	
		echo json_encode([
			'matriculas' => $matriculas,
			'ids' => $ids,
			'cliente' => $cliente,
			'vehiculos' => $vehiculos,
		]);
	}
	
	public function getDatosVehiculo(){
	
		$id_vehiculo = $this->input->post('id_vehiculo');
		$this->load->model('Taller_citas_model');
		$vehiculo = $this->Taller_citas_model->get_vehiculo($id_vehiculo);
	
		if (!$vehiculo) {
			echo json_encode(['cliente' => $vehiculo]);
			return;
		}
	
		echo json_encode([
			'vehiculo' => $vehiculo,
		]);
	}
	
	
	

	public function obtenerHorasDisponibles() {
		$tarea_id = $this->input->post('tarea_id');
		$fecha = $this->input->post('fecha');
	
		$this->load->model('Taller_citas_model');
		$horas = $this->Taller_citas_model->getHorasDisponibles($tarea_id);
		$citas = $this->Taller_citas_model->get_citas($tarea_id, $fecha);
		$simultaneoTarea = $this->Taller_citas_model->get_simultaneo($tarea_id);
	
		if (!$horas) return [];

		$horaInicio = new DateTime($horas->hora_inicio);
		$horaFin = new DateTime($horas->hora_fin);
		list($h, $m, $s) = explode(':', $horas->duracion_intervalo);
		$intervalo = new DateInterval("PT{$h}H{$m}M{$s}S");
	
		$horasDisponibles = [];
	
		while ($horaInicio < $horaFin) {
			$horasDisponibles[] = $horaInicio->format('H:i');
			$horaInicio->add($intervalo);
		}

		echo json_encode([
			'horas' => $horasDisponibles,
			'citas' => array_map(function($cita) {
				return substr($cita->hora, 0, 5);
			}, is_array($citas) ? $citas : [])
			
		 ]);
		
	}

	public function add_cita(){

		$hora = $this->input->post('textoBoton');
		$fecha = $this->input->post('fecha');
		$datos = $this->input->post('datos');
		$id_vehiculo = $this->input->post('id_vehiculo');

		$id_tarea = ''; // Valor predeterminado

		foreach ($datos as $dato) {
			if ($dato['name'] === 'areasTrabajo') {
				$id_tarea = $dato['value']; // Aquí obtienes el valor
				break; // Salimos del bucle una vez que encontramos el valor
			}
		}

		$this->Taller_citas_model->add_citas($id_vehiculo, $fecha, $hora, $id_tarea);

		echo json_encode([
			"status" => "success",
			"hora" => $hora,
			"fecha" => $fecha,
			"datos" => $datos,
			"id_vehiculo" => $id_vehiculo
		]);

	}
	
	public function update_cita(){

		$hora = $this->input->post('textoBoton');
		$fecha = $this->input->post('fecha');
		$datos = $this->input->post('datos');
		$id_vehiculo = $this->input->post('id_vehiculo');
		$id_cita = $this->input->post('id_cita');
		$estado = $this->input->post('estado');

		$id_tarea = ''; // Valor predeterminado

		foreach ($datos as $dato) {
			if ($dato['name'] === 'areasTrabajo') {
				$id_tarea = $dato['value']; // Aquí obtienes el valor
				break; // Salimos del bucle una vez que encontramos el valor
			}
		}

		$this->Taller_citas_model->update_citas($id_cita, $id_vehiculo, $fecha, $hora, $id_tarea, $estado);

		echo json_encode([
			"status" => "success",
			"hora" => $hora,
			"fecha" => $fecha,
			"datos" => $datos,
			"id_vehiculo" => $id_vehiculo
		]);

	}

	public function edit_cita() {
		$estado = $this->input->post('estado');
		$id = $this->input->post('id');
		$id_vehiculo = $this->input->post('id_vehiculo');
		$fecha = $this->input->post('fecha');
		$hora = $this->input->post('hora');
		$id_tarea = $this->input->post('id_tarea');
	
		$this->load->model('Taller_citas_model');
		$this->Taller_citas_model->actualizar_cita($id, $estado, $id_vehiculo, $fecha, $hora, $id_tarea);
	
		if ($this->db->affected_rows() >= 0) {
			echo json_encode([
				"status" => "success",
				"id" => $id,
				"estado" => $estado,
				"id_vehiculo" => $id_vehiculo,
				"fecha" => $fecha,
				"hora" => $hora,
				"id_tarea" => $id_tarea
			]);
		} else {
			echo json_encode(["status" => "error", "message" => "No se pudo actualizar la cita"]);
		}
	}
	


	public function detalles($id = null, $dni = null)
	{
        if (!$id) {
			show_404();
		}
		

		$data['id_nav_back'] = 50;
		$data['acceso'] = $this->valida_acceso();

		if ($data['acceso'][0] == 1)
		{
			$data["lang"] = $this->lang;
			$data["title"] = "Panel de control | Gestión de Vehículos";
            $data["keywords"] = "";
			$data["description"] = "";
			$data["reference"] = "Detalles";
			$data["view"] = "detalles_cita";
			$data["page"] = $id." - Detalles_cita";
			$data["icono"] = $this->icono;
            $data["robots"] = "noindex, nofollow";

			$data["js"] = $this->load->view("js_module/js_module", ["reference" => $data["reference"]], TRUE);
			$data['css'] = $this->load->view('css_module/css_module', '', TRUE);
			$data['idPaginaVehiculo'] = $this->input->post('id');


			$this->load->model('Taller_citas_model');


			if(!$data['idPaginaVehiculo']){
				$data["list_citas"] = $this->Taller_citas_model->get_list_citas();
			}else{
				$data["list_citas"] = $this->Taller_citas_model->get_list_citas_vehiculo($data['idPaginaVehiculo']);
			}

			$data['clientes'] = $this->Taller_citas_model->get_clientes();
			$data["areasTrabajo"] = $this->Taller_citas_model->get_areasTrabajo_activas();
			$data["tareas"] = $this->Taller_citas_model->get_tareas();
			$data["optionsEstado"] = $this->Taller_citas_model->get_opciones_estado();



			$data['cita'] = $this->Taller_citas_model->obtener_cita_con_detalles($id);
			$data['vehiculos_cita'] = $this->Taller_citas_model->obtener_vehiculos_cliente($dni, $id);
			$data['vehiculos_recepcion'] = $this->Taller_citas_model->get_recepcion_by_cita($id);


			$this->load->view("layout", $data);
		}
		else
		{
			redirect('');
		}
	}
	
	
	public function cambiar_estado() {
		$id = $this->input->post('id');
		$estado = $this->input->post('estado');
		$this->load->model('Taller_citas_model');

		$this->Taller_citas_model->actualizar_estado_cita($id, $estado);

		if ($this->db->affected_rows() > 0) {
			echo json_encode(["status" => "success", 'message' => 'Estado actualizado.']);
		} else {
			echo json_encode(["status" => "error", 'message' => 'No se pudo actualizar el estado.']);
		}
	}

	public function actualizar_citas(){
		$id_vehiculo = $this->input->post('id_vehiculo');
		$id_cita = $this->input->post('id_cita');

		$this->load->model('Taller_citas_model');

		$citas = $this->Taller_citas_model->obtener_cita_vehiculos($id_vehiculo, $id_cita);

		$cadena = '';
		if ($citas) {
			foreach ($citas as $cita) {
				$cadena .= '<tr class="fila_sel fila-cita fila-otras-citas"
					data-id_cita="'.$cita->id.'"
					data-id_cliente="'.$cita->id_cliente.'">';

				$cadena .= '<td class="col_sel">'.$cita->id.'</td>';
				$cadena .= '<td>'.$cita->fecha.'</td>';
				$cadena .= '<td>'.$cita->hora.'</td>';
				$cadena .= '<td>'.$cita->nombre.'</td>';
				$cadena .= '<td>'.$cita->tiempo_estimado.' min</td>';
				$cadena .= '<td>'.$cita->estado.'</td>';
				$cadena .= '</tr>';
			}
		} else {
			$cadena .= '<tr><td colspan="6" class="text-center">No hay citas activas para este vehículo.</td></tr>';
		}
		

		echo json_encode([
			"status" => "success",
			"response" => $cadena
		]);
	}

	public function recargar_tabla_citas() {

		$boton = $this->input->post('botonPresionado');

		if(!$boton){

			$list_citas = $this->Taller_citas_model->get_list_citas();
	
		}

		if($boton === "filtrar"){

			$filtros = $this->input->post();
	
			$list_citas = $this->Taller_citas_model->get_list_citas_filtros($filtros);
	
		}
		if($boton === "ver_todos"){
	
			$list_citas = $this->Taller_citas_model->get_list_citas();
	
		}


		$this->load->model('Taller_citas_model');
	
		$cadena = '';
		foreach ($list_citas as $cita) {
			$estado_legible = ucwords(str_replace('_', ' ', $cita->estado));

			$img_url = $cita->img ? base_url('assets_app/images/taller/'.$cita->img) : '';

			$cadena .= '<tr class="fila_sel fila-cita" 
							data-id="'.$cita->id.'" 
							data-id_vehiculo="'.$cita->id_vehiculo.'" 
							data-estado="'.$cita->estado.'" 
							data-fecha="'.$cita->fecha.'" 
							data-hora="'.$cita->hora.'" 
							data-id_tarea="'.$cita->id_tarea.'">
							
							<td class="col_sel">'.$cita->id.'</td>';

			$cadena .= '<td class="col_sel">'.$cita->id_cliente.'</td>';
			$cadena .= '<td class="col_sel">'.$cita->nombre.'</td>';
			$cadena .= '<td class="col_sel">'.$cita->matricula;
			
			if($cita->img){
				$cadena .= '<button type="button" class="btn btn-primary fichaModal boton_citas imgModelo" alt="'.$cita->img.'"
									data-url="'.$img_url.'"
									style="cursor: pointer;" id="boton_citas">
								<i class="fa fa-car-side"></i>
							</button>';
			}
			$cadena .= '</td><td class="col_sel">'.$cita->num_bastidor.'</td>';
			$cadena .= '<td class="col_sel">'.$cita->fecha.'</td>';
			$cadena .= '<td class="col_sel">'.$cita->hora.'</td>';
			$cadena .= '<td class="col_sel">'.$cita->descripcion.'</td>';
			$cadena .= '<td class="col_sel">'.$cita->tiempo_estimado.'</td>';
			$cadena .= '<td class="col_sel">'.$estado_legible.'</td>';

			$style = '';
			if ($cita->estado == "Completada") {
				$style = 'background-color: rgba(0, 255, 0, 0.4)';
			} elseif ($cita->estado == "Procesando") {
				$style = 'background-color: rgba(255, 255, 0, 0.4)';
			}elseif($cita->estado == "Esperando_recepcion"){
				$style="background-color: rgb(209, 236, 241)";
			}elseif ($cita->estado == "Anulada") {
				$style = 'background-color: rgba(255, 0, 0, 0.7)';
			}

			$style2 = '';
			if ($cita->estado == "Completada" || $cita->estado == "Procesando" || $cita->estado == "Esperando_recepcion") {
				$style2 = 'color: black;';
			}
			$hay_recepciones = $this->db
								->from('taller_recepcion')
								->where('id_cita', $cita->id)
								->count_all_results() > 0;



			if($cita->estado !== "Esperando_recepcion" && $cita->estado !== "Anulada"){

				$cadena .= '<td class="col_sel">
								<div id="div_botones">
									<!-- Botón a la izquierda -->
									<div class="btns-izquierda">
										<a href="' . base_url('admin.php/citas/detalles/' . $cita->id) . '/' . $cita->id_cliente . '" 
											class="btn btn-primary boton_citas" 
											id="boton_citas" 
											title="'.$cita->estado.'" '. ($style ? 'style="' . $style . '"' : '') . '>
											<i class="fa fa-info" '. ($style2 ? 'style="' . $style2 . '"' : '') . '></i>
										</a>
									</div>
			
									<!-- Botones a la derecha -->
									<div class="btns-derecha">';
				
				$estados = ["Entregado" => "car-side", "Completada" => "flag-checkered", "Procesando" => "wrench", "Esperando_recepcion" => "bell-concierge", "Anulada" => "ban"];
				foreach ($estados as $estado => $icono) {
					if ($cita->estado !== $estado) {
						$cadena .= '<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" 
										data-estado="'.$estado.'" 
										data-toggle="modal" 
										data-target="#modal_ficha" 
										id="boton_citas"
										title="'.$estado.'">
										<i class="fa fa-'.$icono.'"></i>
									</button>';
					}
				}
			
				$cadena .= '</div></div></td>';
			
			} elseif ($cita->estado === "Esperando_recepcion") {
				$cadena .= '<td class="col_sel">
								<div id="div_botones">
									<!-- Botón a la izquierda -->
									<div class="btns-izquierda">
										<a href="' . base_url('admin.php/citas/detalles/' . $cita->id) . '/' . $cita->id_cliente . '" 
											class="btn btn-primary boton_citas" 
											id="boton_citas" 
											title="'.$cita->estado.'" 
											style="background-color: rgb(209, 236, 241)">
											<i class="fa fa-info" style="color: black"></i>
										</a>
									</div>
			
									<!-- Botones a la derecha -->
									<div class="btns-derecha">
										<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" 
											data-estado="Anulada" 
											data-toggle="modal" 
											data-target="#modal_ficha" 
											id="boton_citas"
											title="Anulada">
											<i class="fa fa-ban"></i>
										</button>
									</div>
								</div>
							</td>';
			
			} elseif ($cita->estado === "Anulada") {
				$cadena .= '<td class="col_sel">
								<div id="div_botones">
									<!-- Botón a la izquierda -->
									<div class="btns-izquierda">
										<a href="' . base_url('admin.php/citas/detalles/' . $cita->id) . '/' . $cita->id_cliente . '" 
											class="btn btn-primary boton_citas" 
											id="boton_citas" 
											title="'.$cita->estado.'" 
											style="background-color: rgba(255, 0, 0, 0.7)">
											<i class="fa fa-info"></i>
										</a>
									</div>
			
									<!-- Botones a la derecha -->
									<div class="btns-derecha">';
			
				if ($hay_recepciones) {
					// Mostrar todos menos el actual ("Anulada")
					$estados = ["Entregado" => "car-side", "Completada" => "flag-checkered", "Procesando" => "wrench", "Esperando_recepcion" => "bell-concierge"];
					foreach ($estados as $estado => $icono) {
						$cadena .= '<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" 
										data-estado="'.$estado.'" 
										data-toggle="modal" 
										data-target="#modal_ficha" 
										id="boton_citas"
										title="'.$estado.'">
										<i class="fa fa-'.$icono.'"></i>
									</button>';
					}
				} else {
					// Solo mostrar botón de "Esperando_recepcion"
					$cadena .= '<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" 
									data-estado="Esperando_recepcion" 
									data-toggle="modal" 
									data-target="#modal_ficha" 
									id="boton_citas"
									title="Esperando recepción">
									<i class="fa fa-bell-concierge"></i>
								</button>';
				}
			
				$cadena .= '</div></div></td>';
			}
			
		

			$cadena .= '</div></div></td></tr>';

		}

		echo json_encode([
			"status" => "success",
			"response" => $cadena
		]);
	}
	
	





	public function get_recepcion($cita_id) {
        // Validar que la cita existe
        $recepcion = $this->Taller_citas_model->get_recepcion_by_cita($cita_id);

        if ($recepcion) {
            // Devolver los datos de la recepción en formato JSON
            $response = [
				'recepcion_existente'   => true,
				'kilometros'            => $recepcion['kilometros'],
				'combustible'           => $recepcion['combustible'],
				'observaciones'         => $recepcion['observaciones'],
				'confirmacion_cliente'  => $recepcion['confirmacion_cliente'],
				'fotos'                 => $recepcion['fotos'] // directamente como array de fotos
			];
			
			
        } else {
            $response = ['recepcion_existente' => false];
        }

        // Retornar respuesta en formato JSON
        echo json_encode($response);
    }

	public function guardar() {
		$this->load->model('Taller_citas_model');
	
		// Recoger los datos enviados por el cliente
		$data = array(
			'id_cita' => $this->input->post('cita_id'),
			'kilometraje' => $this->input->post('kilometraje'),
			'combustible' => $this->input->post('combustible'),
			'observaciones' => $this->input->post('observaciones'),
			'confirmacion_cliente' => $this->input->post('confirmacion_cliente') ? 1 : 0
		);
		

		if (!$data['id_cita'] || !$data['kilometraje'] || !$data['combustible'] || !$data['confirmacion_cliente']) {
			echo json_encode(['status' => 'error', 'mensaje' => 'Faltan datos obligatorios']);
			return;
		}
		
	
		$zonas_impacto = $this->input->post('zonas_impacto');
	
		// Intentar insertar los datos en la base de datos
		$recepcion_id = $this->Taller_citas_model->insertarRecepcion($data);

		if (!$recepcion_id) {
			echo json_encode(['status' => 'error', 'mensaje' => 'No se pudo guardar la recepción']);
			return;
		}

		// Insertar zonas de impacto si las hay
		if (!empty($zonas_impacto)) {
			
			foreach ($zonas_impacto as $zona) {
				$campo_imagen = 'imagen_' . $zona;
			
				if (!empty($_FILES[$campo_imagen]['name'])) {
					// Ruta de carpeta por cita
					$carpeta_base = FCPATH . 'assets_app/images/taller/recepcion/';
					$carpeta_cita = $carpeta_base . $data['id_cita'] . '/';
			
					if (!is_dir($carpeta_cita)) {
						mkdir($carpeta_cita, 0755, true);
					}
			
					$config['upload_path']   = $carpeta_cita;
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['file_name']     = $_FILES[$campo_imagen]['name'];
					$config['overwrite']     = false;
			
					$this->load->library('upload', $config);
			
					if ($this->upload->do_upload($campo_imagen)) {
						$data_upload = $this->upload->data();
						$imagen_path = 'assets_app/images/taller/recepcion/' . $data['id_cita'] . '/' . $data_upload['file_name'];
					} else {
						log_message('error', 'Error al subir imagen de ' . $zona . ': ' . $this->upload->display_errors());
						$imagen_path = null;
					}
				} else {
					$imagen_path = null;
				}
			
				$this->Taller_citas_model->insertarZonasImpacto($recepcion_id, $zona, $imagen_path);
			}
			
			
		}
	
		// Devolver respuesta si todo va bien
		echo json_encode([
			'status' => 'ok',
			'mensaje' => 'Recepción guardada correctamente',
			'recepcion_id' => $recepcion_id
		]);
		
	}
	
	public function guardar_o_actualizar()
	{
		$cita_id = $this->input->post('cita_id');
		$kilometraje = $this->input->post('kilometraje');
		$combustible = $this->input->post('combustible');
		$observaciones = $this->input->post('observaciones');
		$confirmacion_cliente = $this->input->post('confirmacion_cliente');
		$zonas_impacto = $this->input->post('zonas_impacto'); // array con nombres de partes
		$firma_base64 = $this->input->post('firma_base64');


		$data_recepcion = [
			'id_cita' => $cita_id,
			'kilometraje' => $kilometraje,
			'combustible' => $combustible,
			'observaciones' => $observaciones,
			'confirmacion_cliente' => $confirmacion_cliente
		];

		$id_recepcion = $this->Taller_citas_model->guardarRecepcionPorCita($data_recepcion);


		// Obtener fotos actuales de la BD
		$fotos_existentes = $this->Taller_citas_model->fotos_actuales($id_recepcion);

		$fotos_existentes_arr = [];
		foreach ($fotos_existentes as $foto) {
			$fotos_existentes_arr[$foto->parte] = $foto->imagen_path;
		}

		$carpeta_cita = 'assets_app/images/taller/recepcion/' . $cita_id . '/';
		if (!is_dir($carpeta_cita)) {
			mkdir($carpeta_cita, 0777, true);
		}

		// 1. Eliminar imágenes que ya no están en zonas_impacto
		foreach ($fotos_existentes_arr as $parte => $ruta) {
			if (!in_array($parte, $zonas_impacto)) {
				// Borrar archivo físico
				if (file_exists($ruta)) {
					unlink($ruta);
				}
				
				// Borrar de la base de datos
				$this->Taller_citas_model->eliminar_fila($id_recepcion, $parte);

			}
		}

		// 2. Procesar imágenes que llegan por AJAX ($_FILES)
		foreach ($zonas_impacto as $zona) {
			if (isset($_FILES["imagen_$zona"])) {
				$nombre_archivo = $_FILES["imagen_$zona"]['name'];
				$ruta_archivo = $carpeta_cita . $nombre_archivo;

				// Subir nueva imagen
				move_uploaded_file($_FILES["imagen_$zona"]['tmp_name'], $ruta_archivo);

				// Si ya existía una imagen diferente, borrarla
				if (isset($fotos_existentes_arr[$zona]) && $fotos_existentes_arr[$zona] !== $ruta_archivo) {
					if (file_exists($fotos_existentes_arr[$zona])) {
						unlink($fotos_existentes_arr[$zona]);
					}

					$this->Taller_citas_model->eliminar_fila($id_recepcion, $zona);

				}

				// Insertar nueva imagen
				$this->Taller_citas_model->insertarZonasImpacto($id_recepcion, $zona, $ruta_archivo);

			}
		}

		// 3. Procesar firma del cliente (si existe)
		if (!empty($firma_base64)) {
			$firma_base64 = str_replace('data:image/png;base64,', '', $firma_base64);
			$firma_base64 = str_replace(' ', '+', $firma_base64);
			$firma_data = base64_decode($firma_base64);

			$nombre_firma = 'firma_cliente.png';
			$ruta_firma = $carpeta_cita . $nombre_firma;

			file_put_contents($ruta_firma, $firma_data);

			// Guardar firma en la base de datos como si fuera una zona de impacto llamada 'firma_cliente'
			$this->Taller_citas_model->eliminar_fila($id_recepcion, 'firma_cliente'); // Elimina anterior si existe
			$this->Taller_citas_model->insertarZonasImpacto($id_recepcion, 'firma_cliente', $ruta_firma);
		}


		echo json_encode(['status' => 'success']);
	}


	
}