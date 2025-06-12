<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Taller_citas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Cargamos el modelo correspondiente
		$this->load->model('Taller_citas_model');
		$this->load->helper('html');
		$this->load->library(['form_validation', 'session']);
	}



	//------------------Index----------------------------------------------------------------------------------------------------------------------------------------------
	public function index()
	{

		$data['id_nav_back'] = 50;
		$data['acceso'] = $this->valida_acceso();

		if (!$data['acceso']) {
			$this->session->set_flashdata('error', 'Acceso denegado');
			redirect('usuario/login');
		}

		$data["lang"] = 'es';
		$data["title"] = 'Panel de control | Gestión de Vehículos';
		$data["keywords"] = '';
		$data["description"] = '';
		$data["reference"] = 'Index';
		$data["view"] = 'list_citas';
		$data["page"] = 'Citas';
		$data['icono'] = 'fa fa-car'; // Asegúrate de que haya un icono definido o coméntalo si no es necesario
		$data["robots"] = 'noindex, nofollow';

		$data["js"] = $this->load->view("taller_citas/js_module/js_module", ["reference" => $data["reference"]], TRUE);
		$data['css'] = $this->load->view('taller_citas/css_module/css_module', '', TRUE);

		$data['idPaginaVehiculo'] = $this->input->get('id');

		if (!$data['idPaginaVehiculo']) {

			$data["list_citas"] = $this->Taller_citas_model->get_list_citas();

		} else {

			$data["list_citas"] = $this->Taller_citas_model->get_list_citas_vehiculo($data['idPaginaVehiculo']);

		}



		$data['clientes'] = $this->Taller_citas_model->get_clientes();

		$data["areasTrabajo"] = $this->Taller_citas_model->get_areasTrabajo_activas();

		$data["tareas"] = $this->Taller_citas_model->get_tareas();
		$data["optionsEstado"] = $this->Taller_citas_model->get_opciones_estado();

		$this->load->view("taller_citas/list_citas", $data);
	}

	// Simulación de permisos (acceso, agregar, editar, eliminar)
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
	//------------------FIN Index----------------------------------------------------------------------------------------------------------------------------------------------


	public function getMatriculas()
	{

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

	public function getDatosVehiculo()
	{

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




	public function obtenerHorasDisponibles()
	{
		$tarea_id = $this->input->post('tarea_id');
		$fecha = $this->input->post('fecha');

		$this->load->model('Taller_citas_model');
		$horas = $this->Taller_citas_model->getHorasDisponibles($tarea_id);
		$citas = $this->Taller_citas_model->get_citas($tarea_id, $fecha);
		$simultaneoTarea = $this->Taller_citas_model->get_simultaneo($tarea_id);

		if (!$horas)
			return [];

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
			'citas' => array_map(function ($cita) {
				return substr($cita->hora, 0, 5);
			}, is_array($citas) ? $citas : [])

		]);

	}

	public function add_cita()
	{

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

	public function update_cita()
	{

		$hora = $this->input->post('hora');
		$fecha = $this->input->post('fecha');
		$id_tarea = $this->input->post('id_tarea');
		$id_vehiculo = $this->input->post('id_vehiculo');
		$id_cita = $this->input->post('id_cita');
		$estado = $this->input->post('estado');

		$this->Taller_citas_model->update_citas($id_cita, $id_vehiculo, $fecha, $hora, $id_tarea, $estado);

		echo json_encode([
			"status" => "success",
			"hora" => $hora,
			"fecha" => $fecha,
			"datos" => $id_tarea,
			"id_vehiculo" => $id_vehiculo
		]);

	}

	public function edit_cita()
	{
		$estado = $this->input->post('estado');
		$id_cita = $this->input->post('id');
		$id_vehiculo = $this->input->post('id_vehiculo');
		$fecha = $this->input->post('fecha');
		$hora = $this->input->post('hora');
		$id_tarea = $this->input->post('id_tarea');

		$this->Taller_citas_model->update_citas($id_cita, $id_vehiculo, $fecha, $hora, $id_tarea, $estado);

		if ($this->db->affected_rows() >= 0) {
			echo json_encode([
				"status" => "success",
				"id" => $id_cita,
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

		$data['acceso'] = $this->valida_acceso();

		if (!$data['acceso']) {
			$this->session->set_flashdata('error', 'Acceso denegado');
			redirect('usuario/login');
		}

		$data["title"] = "Panel de control | Gestión de Vehículos";
		$data["keywords"] = "";
		$data["description"] = "";
		$data["reference"] = "Detalles";
		$data["view"] = "detalles_cita";
		$data["page"] = "Taller_citas";
		$data["subpage_cont"] = "Taller_citas/detalles/" . $id . "/" . $dni;
		$data["subpage"] = $id . " - Detalles Cita";
		$data["robots"] = "noindex, nofollow";

		$data["js"] = $this->load->view("taller_citas/js_module/js_module", ["reference" => $data["reference"]], TRUE);
		$data['css'] = $this->load->view('taller_citas/css_module/css_module', '', TRUE);
		$data['idPaginaVehiculo'] = $this->input->post('id');


		$this->load->model('Taller_citas_model');


		if (!$data['idPaginaVehiculo']) {
			$data["list_citas"] = $this->Taller_citas_model->get_list_citas();
		} else {
			$data["list_citas"] = $this->Taller_citas_model->get_list_citas_vehiculo($data['idPaginaVehiculo']);
		}

		$data['clientes'] = $this->Taller_citas_model->get_clientes();
		$data["areasTrabajo"] = $this->Taller_citas_model->get_areasTrabajo_activas();
		$data["tareas"] = $this->Taller_citas_model->get_tareas();
		$data["optionsEstado"] = $this->Taller_citas_model->get_opciones_estado();



		$data['cita'] = $this->Taller_citas_model->obtener_cita_con_detalles($id);
		$data['vehiculos_cita'] = $this->Taller_citas_model->obtener_vehiculos_cliente($dni, $id);
		$data['vehiculos_recepcion'] = $this->Taller_citas_model->get_recepcion_by_cita($id);

		$this->load->view("taller_citas/detalles_cita", $data);
	}


	public function cambiar_estado()
	{
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

	public function actualizar_citas()
	{
		$id_vehiculo = $this->input->post('id_vehiculo');
		$id_cita = $this->input->post('id_cita');

		$this->load->model('Taller_citas_model');

		$citas = $this->Taller_citas_model->obtener_cita_vehiculos($id_vehiculo, $id_cita);

		$cadena = '';
		if ($citas) {
			foreach ($citas as $cita) {
				$cadena .= '<tr class="fila_sel fila-cita fila-otras-citas"
					data-id_cita="' . $cita->id . '"
					data-id_cliente="' . $cita->id_cliente . '">';

				$cadena .= '<td class="col_sel">' . $cita->id . '</td>';
				$cadena .= '<td>' . $cita->fecha . '</td>';
				$cadena .= '<td>' . $cita->hora . '</td>';
				$cadena .= '<td>' . $cita->nombre . '</td>';
				$cadena .= '<td>' . $cita->tiempo_estimado . ' min</td>';
				$cadena .= '<td>' . $cita->estado . '</td>';
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

	public function recargar_tabla_citas()
	{

		$boton = $this->input->post('botonPresionado');

		if (!$boton) {

			$list_citas = $this->Taller_citas_model->get_list_citas();

		}

		if ($boton === "filtrar") {

			$filtros = $this->input->post();

			$list_citas = $this->Taller_citas_model->get_list_citas_filtros($filtros);

		}
		if ($boton === "ver_todos") {

			$list_citas = $this->Taller_citas_model->get_list_citas();

		}

		if ($boton === "redirigido") {

			$list_citas = $this->Taller_citas_model->get_list_esperando();

		}

		$cadena = '';

		if($list_citas === null || $list_citas === false) {
				echo json_encode([
				'status' => 'success',
				'data' => '' // cadena vacía para que la tabla se limpie
			]);
			return;
		}

		foreach ($list_citas as $cita) {
			$estado_legible = ucwords(str_replace('_', ' ', $cita->estado));

			$img_url = $cita->img ? base_url('assets/img/taller/' . $cita->img) : '';

			$cadena .= '<tr class="fila_sel fila-cita" 
							data-id="' . $cita->id . '" 
							data-id_vehiculo="' . $cita->id_vehiculo . '" 
							data-estado="' . $cita->estado . '" 
							data-fecha="' . $cita->fecha . '" 
							data-hora="' . $cita->hora . '" 
							data-id_tarea="' . $cita->id_tarea . '">
							
							<td class="col_sel">' . $cita->id . '</td>';

			$cadena .= '<td class="col_sel">' . $cita->id_cliente . '</td>';
			$cadena .= '<td class="col_sel">' . $cita->nombre . '</td>';
			$cadena .= '<td class="col_sel">' . $cita->matricula;

			if ($cita->img) {
				$cadena .= '<button type="button" class="btn btn-primary fichaModal boton_citas imgModelo" alt="' . $cita->img . '"
									data-url="' . $img_url . '"
									style="cursor: pointer;" id="boton_citas">
								<i class="fa fa-car-side"></i>
							</button>';
			}
			$cadena .= '</td><td class="col_sel">' . $cita->num_bastidor . '</td>';
			$cadena .= '<td class="col_sel">' . $cita->fecha . '</td>';
			$cadena .= '<td class="col_sel">' . $cita->hora . '</td>';
			$cadena .= '<td class="col_sel">' . $cita->descripcion . '</td>';
			$cadena .= '<td class="col_sel">' . $cita->tiempo_estimado . '</td>';
			$cadena .= '<td class="col_sel">' . $estado_legible . '</td>';


			// Estilos de fondo por estado
			$style = '';
			if ($cita->estado == "Completada") {
				$style = 'background-color: rgba(0, 255, 0, 0.4)';
			} elseif ($cita->estado == "Procesando") {
				$style = 'background-color: rgba(255, 255, 0, 0.4)';
			} elseif ($cita->estado == "Esperando_recepcion") {
				$style = 'background-color: rgb(209, 236, 241)';
			} elseif ($cita->estado == "Anulada") {
				$style = 'background-color: rgba(255, 0, 0, 0.7)';
			}

			$style2 = '';
			if (in_array($cita->estado, ["Completada", "Procesando", "Esperando_recepcion"])) {
				$style2 = 'color: black;';
			}

			$hay_recepciones = $this->db
				->from('taller_recepcion')
				->where('id_cita', $cita->id)
				->count_all_results() > 0;

			$cadena .= '<td class="col_sel">
							<div id="div_botones">
								<!-- Botón a la izquierda -->
								<div class="btns-izquierda">
									<a href="' . base_url('taller_citas/detalles/' . $cita->id) . '/' . $cita->id_cliente . '" 
										class="btn btn-primary boton_citas" 
										id="boton_citas" 
										title="' . $cita->estado . '" ' . ($style ? 'style="' . $style . '"' : '') . '>
										<i class="fa fa-info" ' . ($style2 ? 'style="' . $style2 . '"' : '') . '></i>
									</a>
								</div>
		
								<!-- Botones a la derecha -->
								<div class="btns-derecha">';

			if ($cita->estado !== "Esperando_recepcion" && $cita->estado !== "Anulada") {
				$estados = [
					"Entregado" => "car-side",
					"Completada" => "flag-checkered",
					"Procesando" => "wrench",
					"Anulada" => "ban"
				];
				foreach ($estados as $estado => $icono) {
					if ($cita->estado !== $estado) {
						$cadena .= '<button class="btn btn-primary fichaModal btn_estado boton_citas btn-xs" title="' . $estado . '"
										data-id="' . $cita->id . '"
										data-id_vehiculo="' . $cita->id_vehiculo . '"
										data-fecha="' . $cita->fecha . '"
										data-hora="' . $cita->hora . '"
										data-id_tarea="' . $cita->id_tarea . '"
										data-estado="' . $estado . '">
										<i class="fa fa-' . $icono . '"></i>
									</button>';
					}
				}
			} elseif ($cita->estado === "Esperando_recepcion") {
				$cadena .= '<button class="btn btn-primary fichaModal btn_estado boton_citas btn-xs" title="Anulada"
									data-id="' . $cita->id . '"
									data-id_vehiculo="' . $cita->id_vehiculo . '"
									data-fecha="' . $cita->fecha . '"
									data-hora="' . $cita->hora . '"
									data-id_tarea="' . $cita->id_tarea . '"
									data-estado="Anulada">
									<i class="fa fa-ban"></i>
								</button>';
			} elseif ($cita->estado === "Anulada") {
				if ($hay_recepciones) {
					$estados = [
						"Entregado" => "car-side",
						"Completada" => "flag-checkered",
						"Procesando" => "wrench",
					];
					foreach ($estados as $estado => $icono) {
						$cadena .= '<button class="btn btn-primary fichaModal btn_estado boton_citas btn-xs" title="' . $estado . '"
											data-id="' . $cita->id . '"
											data-id_vehiculo="' . $cita->id_vehiculo . '"
											data-fecha="' . $cita->fecha . '"
											data-hora="' . $cita->hora . '"
											data-id_tarea="' . $cita->id_tarea . '"
											data-estado="' . $estado . '">
											<i class="fa fa-' . $icono . '"></i>
										</button>';
					}
				} else {
					$cadena .= '<button class="btn btn-primary fichaModal btn_estado boton_citas btn-xs" title="Esperando recepción"
										data-id="' . $cita->id . '"
										data-id_vehiculo="' . $cita->id_vehiculo . '"
										data-fecha="' . $cita->fecha . '"
										data-hora="' . $cita->hora . '"
										data-id_tarea="' . $cita->id_tarea . '"
										data-estado="Esperando_recepcion">
										<i class="fa fa-bell-concierge"></i>
									</button>';
				}
			}

			$cadena .= '</div></div></td>';




			$cadena .= '</div></div></td></tr>';

		}

		echo json_encode([
			"status" => "success",
			"response" => $cadena
		]);
	}





	public function del_recepcion($recepcion_id, $citaId)
	{
		$deleted = $this->Taller_citas_model->del_recepcion($recepcion_id);
		$actualizar = $this->Taller_citas_model->actualizar_estado_cita($citaId, "Esperando_recepcion");

		$path = FCPATH . "assets/img/taller/recepcion/" . $citaId;
		if (is_dir($path)) {
			$this->delete_directory($path);
		}


		$response = ['status' => ($deleted && $actualizar) ? 'success' : 'error'];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	private function delete_directory($dir)
	{
		if (!file_exists($dir))
			return false;
		if (!is_dir($dir))
			return unlink($dir);

		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..')
				continue;
			$this->delete_directory($dir . DIRECTORY_SEPARATOR . $item);
		}
		return rmdir($dir);
	}




	public function get_recepcion($cita_id)
	{
		// Validar que la cita existe
		$recepcion = $this->Taller_citas_model->get_recepcion_by_cita($cita_id);

		if ($recepcion) {
			// Devolver los datos de la recepción en formato JSON
			$response = [
				'recepcion_existente' => true,
				'id' => $recepcion['id'],
				'kilometros' => $recepcion['kilometros'],
				'combustible' => $recepcion['combustible'],
				'observaciones' => $recepcion['observaciones'],
				'confirmacion_cliente' => $recepcion['confirmacion_cliente'],
				'fotos' => $recepcion['fotos'] // directamente como array de fotos
			];


		} else {
			$response = ['recepcion_existente' => false];
		}

		// Retornar respuesta en formato JSON
		echo json_encode($response);
	}

	public function guardar()
	{
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
					$carpeta_base = FCPATH . 'assets/img/taller/recepcion/';
					$carpeta_cita = $carpeta_base . $data['id_cita'] . '/';

					if (!is_dir($carpeta_cita)) {
						mkdir($carpeta_cita, 0755, true);
					}

					$config['upload_path'] = $carpeta_cita;
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['file_name'] = $_FILES[$campo_imagen]['name'];
					$config['overwrite'] = false;

					$this->load->library('upload', $config);

					if ($this->upload->do_upload($campo_imagen)) {
						$data_upload = $this->upload->data();
						$imagen_path = 'assets/img/taller/recepcion/' . $data['id_cita'] . '/' . $data_upload['file_name'];
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

	public function cargar_firma($cita_id)
	{
		$firma = $this->Taller_citas_model->get_firma_by_cita($cita_id);

		if ($firma && !empty($firma->firma_cliente)) {
			// Codificamos el binario en base64
			$firmaBase64 = 'data:image/png;base64,' . base64_encode($firma->firma_cliente);

			echo json_encode([
				'existe' => true,
				'firmaBase64' => $firmaBase64
			]);
		} else {
			echo json_encode([
				'existe' => false,
				'error' => 'No se encontró la firma'
			]);
		}
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

		$errores = [];

		if ($cita_id === "") {
			$errores[] = "ID de la cita";
		}
		if ($kilometraje === "0" || $kilometraje === "") {
			$errores[] = "kilometraje";
		}
		if ($combustible === "Vacío" || $combustible === "") {
			$errores[] = "combustible";
		}
		if ($confirmacion_cliente === "0" || $confirmacion_cliente === "") {
			$errores[] = "confirmación del cliente";

		}

		$errores2 = implode(', ', $errores);

		if (!empty($errores)) {
			header('Content-Type: application/json'); // ✅ Asegura que el navegador sepa que es JSON
			echo json_encode([
				'status' => 'error',
				'message' => 'Faltan datos requeridos: ' . $errores2
			]);
			return;
		}


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

		if (is_array($fotos_existentes)) {
			foreach ($fotos_existentes as $foto) {
				$fotos_existentes_arr[$foto->parte] = $foto->imagen_path;
			}
		}


		if (!empty($firma_base64) || !empty($fotos_existentes_arr) || !empty($zonas_impacto)) {
			$carpeta_cita = 'assets/img/taller/recepcion/' . $cita_id . '/';
			if (!is_dir($carpeta_cita)) {
				mkdir($carpeta_cita, 0777, true);
			}
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
			// Guardar la firma como binario en la nueva tabla 'firma_cliente'

			$this->Taller_citas_model->add_firma($firma_data, $id_recepcion);


		}

		header('Content-Type: application/json'); // ✅ Asegura que el navegador sepa que es JSON
		echo json_encode(['status' => 'success']);
		return;
	}



	public function imprimir_factura($cita_id)
	{
		$this->output->enable_profiler(FALSE);
		if (ob_get_length()) {
			ob_end_clean();
		}

		// $cliente = $this->taller_citas_model->get_cliente($cliente_id);	obtener_cita_con_detalles

		$usuario = $this->session->userdata('usuario');

		$usuario_id = $usuario['id'];


		$user = $this->Taller_citas_model->get_usuario_por_id($usuario_id);

		$data['usuario_nombre'] = $user->nombre;
		$data['firma_usuario'] = $user->firma;

		$organizacion = $this->Taller_citas_model->obtener_organizacion();
		$cita = $this->Taller_citas_model->obtener_cita_mucho_detalles($cita_id);
		$fotos = $this->Taller_citas_model->obtener_fotos($cita->id_recepcion);
		$firma = $this->Taller_citas_model->get_firma_by_cita($cita_id);

		if ($firma && !empty($firma->firma_cliente)) {
			$data['firma'] = 'data:image/png;base64,' . base64_encode($firma->firma_cliente);
		} else {
			$data['firma'] = null;
		}

		$data['titulo'] = 'Justificante de Recepción del Vehículo';
		$data['fecha'] = $cita->fecha;
		$data['cliente'] = [
			'dni' => $cita->dni,
			'nombre' => $cita->cliente_nombre,
			'apellidos' => $cita->cliente_apellidos,
			'direccion' => 'Calle Falsa 123',
			'telefono' => $cita->cliente_telefono,
			'email' => $cita->cliente_email
		];
		$data['vehiculo'] = [
			'marca' => $cita->marca,
			'modelo' => $cita->modelo,
			'matricula' => $cita->matricula,
			'kilometraje' => $cita->kilometros,
			'bastidor' => $cita->num_bastidor,
			'combustible' => $cita->combustible
		];
		// $data['servicios'] = [
		// 	($cita->area_nombre.': '.$cita->descripcion),
		// ];

		$data['servicios'] = [];

		$data['servicios'][] = [
			'area' => $cita->area_nombre,
			'tarea' => $cita->descripcion,
			'precio' => $cita->precio_unitario,
			'unidades' => $cita->max_unidades,
		];

		$data['danos'] = $fotos;
		$data['cita'] = $cita->id;
		$data['observaciones'] = $cita->observaciones_cliente;

		$data['empresa'] = [
			'nombre' => $organizacion->empresa,
			'nif' => $organizacion->nif_empresa,
			'logo' => $organizacion->logo,
			'pais' => $organizacion->pais,
			'provincia' => $organizacion->provincia,
			'direccion' => $organizacion->direccion_empresa,
			'codigo_postal' => $organizacion->codigo_postal_empresa,
			'email' => $organizacion->email_empresa,
			'telefono' => $organizacion->telefono_empresa,
			'horario' => $organizacion->horario_atencion_cliente,
		];

		$presupuesto = $this->Taller_citas_model->get_presupuesto_por_cita($cita_id);

		if ($presupuesto) {
			$order = $presupuesto; // El objeto presupuesto completo
			$items = $presupuesto->productos; // Los productos asociados

			$data['presupuesto'] = [
				'order' => $order,
				'items' => $items
			];
		}

		// Cargar mPDF
		require_once FCPATH . '/vendor/autoload.php';

		// Usar la forma correcta para la versión 6.x de mPDF
		$mpdf = new \mPDF();

		// Establecer los metadatos del documento PDF
		$mpdf->SetCreator(PDF_CREATOR);
		$mpdf->SetAuthor($data['cliente']['nombre']);
		$mpdf->SetTitle('Factura Taller');
		$mpdf->SetSubject('Factura de servicios del taller');
		$mpdf->SetKeywords('Factura, Taller, Servicios');

		// Cargar el archivo CSS si lo tienes
		$css = file_get_contents(FCPATH . 'vendor/mpdf/mpdf/mpdf.css');
		$mpdf->WriteHTML($css, 1);

		//$data['css'] = $this->load->view('taller_citas/css_module/css_module', '', TRUE);


		// Generar el contenido del PDF usando solo el archivo generar_factura.php
		$html = $this->load->view('taller_citas/include/generar_factura', $data, true);

		// Escribir el contenido HTML al PDF
		$mpdf->WriteHTML($html);

		// Definir el nombre del archivo
		$nombre_archivo = "Factura_" . $cita_id . ".pdf";

		// Generar el PDF y mostrarlo en línea
		ob_end_clean();
		$mpdf->Output($nombre_archivo, 'I');
	}


	public function getProductos()
	{
		$tarea_id = $this->input->post('tareaId');

		if (!$tarea_id) {
			echo json_encode(['status' => 'error', 'message' => 'Tarea no especificada']);
			return;
		}

		$productos = $this->Taller_citas_model->get_product_tarea($tarea_id);

		if (!$productos) {
			echo json_encode(['status' => 'error', 'message' => 'Productos no encontrados']);
			return;
		}

		echo json_encode(['status' => 'ok', 'productos' => $productos]);
	}

	public function guardar_presupuesto()
	{
		$cita_id = $this->input->post('cita_id');
		$tarea_id = $this->input->post('tarea_id');
		$productos = $this->input->post('productos');

		if (!$cita_id || !$tarea_id || empty($productos)) {
			echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
			return;
		}

		foreach ($productos as $producto) {
			if (!isset($producto['id']) || !isset($producto['cantidad']) || !is_numeric($producto['cantidad']) || $producto['cantidad'] < 1) {
				echo json_encode(['status' => 'error', 'message' => 'Cantidad de producto inválida']);
				return;
			}

			$producto_db = $this->Taller_citas_model->get_producto_por_id($producto['id']);
			if (!$producto_db) {
				echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
				return;
			}

			if ($producto_db->stock < $producto['cantidad']) {
				echo json_encode(['status' => 'error', 'message' => 'Stock insuficiente para el producto: ' . $producto_db->nombre]);
				return;
			}
		}

		$presupuesto_existente = $this->Taller_citas_model->get_presupuesto_por_cita($cita_id);

		if ($presupuesto_existente) {
			$presupuesto_id = $presupuesto_existente->id;

			// Mapeamos nuevos productos por ID para acceso rápido
			$nuevos_productos_map = [];
			foreach ($productos as $nuevo_prod) {
				$nuevos_productos_map[$nuevo_prod['id']] = $nuevo_prod;
			}

			// Obtenemos los productos actuales del presupuesto
			$productos_anteriores = $this->Taller_citas_model->get_productos_presupuesto($presupuesto_id);
			$productos_actualizados = [];

			foreach ($productos_anteriores as $prod_ant) {
				$producto_id = $prod_ant->id;
				$cantidad_anterior = $prod_ant->cantidad;

				if (isset($nuevos_productos_map[$producto_id])) {
					$nuevo = $nuevos_productos_map[$producto_id];
					$cantidad_nueva = $nuevo['cantidad'];

					// Comprobamos si la cantidad ha cambiado
					if ($cantidad_nueva != $cantidad_anterior) {
						$diferencia = $cantidad_nueva - $cantidad_anterior;

						if ($diferencia > 0) {
							$this->Taller_citas_model->descontar_stock_producto($producto_id, $diferencia);
						} else {
							$dif_invertida = abs($diferencia);
							$this->Taller_citas_model->incrementar_stock_producto($producto_id, $dif_invertida);
						}

						// Actualizamos la cantidad en la tabla de productos del presupuesto
						$this->Taller_citas_model->actualizar_producto_presupuesto($presupuesto_id, $producto_id, $cantidad_nueva);
					}

					// Ya está actualizado, lo marcamos como procesado
					$productos_actualizados[] = $producto_id;
				} else {
					// Producto eliminado, devolver stock y borrar
					$this->Taller_citas_model->incrementar_stock_producto($producto_id, $cantidad_anterior);
					$this->Taller_citas_model->eliminar_producto_presupuesto($presupuesto_id, $producto_id);
				}
			}
			
			$nuevo_total = 0;
			
			// Insertamos los productos nuevos que no estaban antes
			foreach ($productos as $nuevo_prod) {
				if (!in_array($nuevo_prod['id'], $productos_actualizados)) {
					$this->Taller_citas_model->insertar_productos($presupuesto_id, $nuevo_prod);
					$this->Taller_citas_model->descontar_stock_producto($nuevo_prod['id'], $nuevo_prod['cantidad']);
				}

				$producto_db = $this->Taller_citas_model->get_producto_por_id($nuevo_prod['id']);
				if ($producto_db) {
					$nuevo_total += $producto_db->precio * $nuevo_prod['cantidad'];
				}
			}

			// Insertamos los productos nuevos que no estaban antes
			foreach ($productos as $nuevo_prod) {
				if (!in_array($nuevo_prod['id'], $productos_actualizados)) {
					$producto_db = $this->Taller_citas_model->get_producto_por_id($nuevo_prod['id']);

					if ($producto_db) {
						
						$prod = [
							'id' => $nuevo_prod['id'],
							'cantidad' => $nuevo_prod['cantidad'],
							'precio' => $producto_db->precio
						];
						$this->Taller_citas_model->insertar_producto($presupuesto_id, $prod);

						$this->Taller_citas_model->descontar_stock_producto($nuevo_prod['id'], $nuevo_prod['cantidad']);
					}
				}
			}

			$this->Taller_citas_model->actualizar_total_presupuesto($presupuesto_id, $nuevo_total);

			// Recalcular y actualizar el total del presupuesto
			$nuevo_total = 0;

			foreach ($productos as $prod) {
				$producto_db = $this->Taller_citas_model->get_producto_por_id($prod['id']);
				if ($producto_db) {
					$nuevo_total += $producto_db->precio * $prod['cantidad'];
				}
			}

			$this->Taller_citas_model->actualizar_total_presupuesto($presupuesto_id, $nuevo_total);

		} else {
			$presupuesto_id = $this->Taller_citas_model->guardar_presupuesto($cita_id, $tarea_id, $productos);
		}

		if ($presupuesto_id) {

			echo json_encode(['status' => 'ok', 'nuevo_id' => $presupuesto_id]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Error al guardar el presupuesto']);
		}
	}





	public function eliminar_presupuesto()
	{
		$id_presupuesto = $this->input->post('id_presupuesto');

		if (!$id_presupuesto) {
			echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
			return;
		}

		$productos = $this->Taller_citas_model->get_productos_por_presupuesto($id_presupuesto);

		foreach ($productos as $producto) {
			$this->Taller_citas_model->incrementar_stock_producto($producto->producto_id, $producto->cantidad);
		}

		$result = $this->Taller_citas_model->eliminar_presupuesto($id_presupuesto);

		if ($result) {
			echo json_encode(['status' => 'ok']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar']);
		}
	}



	public function getDatosPresupuesto()
	{
		$cita_id = $this->input->post('cita_id');

		if (!$cita_id) {
			echo json_encode(['status' => 'error', 'message' => 'ID de cita no especificado']);
			return;
		}

		$presupuesto = $this->Taller_citas_model->get_presupuesto_by_cita($cita_id);

		if ($presupuesto) {
			echo json_encode([
				'status' => 'ok',
				'existe_presupuesto' => true,
				'presupuesto' => $presupuesto
			]);
		} else {
			$id_tarea = $this->Taller_citas_model->get_tarea_id_by_cita($cita_id);
			// También puedes incluir ID de tarea si lo necesitas
			echo json_encode([
				'status' => 'ok',
				'existe_presupuesto' => false,
				'presupuesto' => [
					'id_cita' => $cita_id,
					'id_tarea' => $id_tarea,
				]
			]);
		}
	}

	public function get_presupuesto_detalle()
	{
		$id_presupuesto = $this->input->post('presupuesto_id');
		$id_tarea = $this->input->post('tareaId');

		if (!$id_presupuesto || !$id_tarea) {
			echo json_encode(['success' => false, 'message' => 'Faltan parámetros']);
			return;
		}

		$todos = $this->Taller_citas_model->get_product_tarea($id_tarea);
		$usados = $this->Taller_citas_model->get_productos_presupuesto($id_presupuesto);

		if (!$todos) {
			echo json_encode(['success' => false, 'message' => 'No hay productos para esta tarea']);
			return;
		}

		$usados_assoc = [];
		foreach ($usados as $u) {
			$usados_assoc[$u->id] = $u;
		}

		foreach ($todos as $p) {
			if (isset($usados_assoc[$p->id])) {
				$p->seleccionado = true;
				$p->cantidad = $usados_assoc[$p->id]->cantidad;
			} else {
				$p->seleccionado = false;
				$p->cantidad = 1;
			}
		}

		echo json_encode(['success' => true, 'productos' => $todos]);
	}









}