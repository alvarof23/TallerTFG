<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
require APPPATH."third_party/MX/Controller.php";

class Taller_vehiculos extends MX_Controller
{
    private $lang = "";
    private $icono = "";

    public function __construct()
    {
        parent::__construct();
        
		$this->lang = "es";
		$this->icono = "fa fa-car";
        $this->load->model("Taller_vehiculos_model");
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
			$data["reference"] = "TALLER_VEHICULOS";
			$data["view"] = "list_vehiculos";  // Cambié esta línea
			$data["page"] = "Taller_vehículos";
			$data["icono"] = $this->icono;
            $data["robots"] = "noindex, nofollow";
			$data["js"] = $this->load->view("js_module/js_module");
			$data['css'] = $this->load->view('css_module/css_module', '', TRUE);



			$data["list_vehiculos"] = $this->Taller_vehiculos_model->get_list_vehiculos();
			
			$data['clientes'] = $this->Taller_vehiculos_model->get_clientes();
			$data['modelo_vehiculo'] = $this->Taller_vehiculos_model->get_modelos();
			$data['marca_vehiculo'] = $this->Taller_vehiculos_model->get_marcas();

			
			$data["areasTrabajo"] = $this->Taller_vehiculos_model->get_areasTrabajo_activas();



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



	//------------------Form Modal----------------------------------------------------------------------------------------------------------------------------------------------
	public function vehiculos_form_ajax()
	{
		if (!$this->input->is_ajax_request()) {
			show_404(); // Solo permitir llamadas AJAX
		}

		$data['editable'] = TRUE;
		$data['id_nav_back'] = 118;
		$data['acceso'] = $this->valida_acceso();

		if ($data['acceso'][1] != 1) {
			echo json_encode(["status" => "error", "message" => "Acceso denegado"]);
			exit;
		}

		// Reglas validacion Formulario
		$this->form_validation->set_rules('id_cliente', 'Cliente', 'required');
		$this->form_validation->set_rules('nom_marca', 'Marca', 'required');
		$this->form_validation->set_rules('id_modelo', 'Modelo', 'required');
		$this->form_validation->set_rules('num_bastidor', 'Número de Bastidor', 'required|alpha_numeric');
		$this->form_validation->set_rules('color', 'Color', 'required');
		$this->form_validation->set_rules('matricula', 'Matrícula', 'required|alpha_numeric');
		$this->form_validation->set_rules('fecha_matriculacion', 'Fecha de Matriculación', 'required');

		// Guardamos los datos
		if ($this->form_validation->run() == TRUE) {
			$data_vehiculo = array(
				'id_cliente' => $this->input->post('id_cliente'),
				'id_modelo' => $this->input->post('id_modelo'),
				'num_bastidor' => $this->input->post('num_bastidor'),
				'color' => $this->input->post('color'),
				'matricula' => $this->input->post('matricula'),
				'fecha_matriculacion' => $this->input->post('fecha_matriculacion'),
			);

			// Actualizar (EDITAR)
			if ($this->input->post('id_vehiculo')) {
				$this->Taller_vehiculos_model->update_vehiculo($this->input->post('id_vehiculo'), $data_vehiculo);
				$response = [
					"status" => "success",
					"message" => "Vehículo actualizado"
				];
			
			// Añadir (ADD)
			} else {
				$this->Taller_vehiculos_model->insert_vehiculo($data_vehiculo);
				$response = [
					"status" => "success",
					"message" => "Vehículo registrado"
				];
			}
		} else {
			$response = [
				"status" => "error",
				"message" => validation_errors()
			];
		}

		$this->carga_cuerpo_tabla();


	}

	// Para obtener los modelos segunmarca (desplegable edita/añadir)
	public function get_modelos_por_marca()
	{	
		$id_marca = $this->input->post('id_marca');

		$id_modelo_antiguo = $this->input->post('id_modelo', TRUE); // XSS filtering opcional

		if (!empty($id_modelo_antiguo)) {

			$id_modelo_antiguo = $this->input->post('id_modelo');
			
		} else {
			$id_modelo_antiguo = "";		
		}

		// Validar que se ha recibido un ID de marca válido
		if (!$id_marca) {
			echo json_encode(["error" => "ID de marca no válido"]);
			return;
		}

		$cadena = '<option value="">Seleccione un modelo</option>';

		$modelos = $this->Taller_vehiculos_model->get_modelos_by_marca($id_marca);

		foreach( $modelos as $modelo ) {
			
			if($modelo->id == $id_modelo_antiguo){

				$cadena .= "<option value='".$modelo->id."' selected>".$modelo->nombre."</option>";

			}else{

				$cadena .= "<option value='".$modelo->id."'>".$modelo->nombre."</option>";

			}
			
		}
		// Enviar respuesta JSON
		echo json_encode($cadena);
		exit; // Importante para evitar que CodeIgniter cargue una vista por defecto
	}


	// Delete Generico
	public function delete($id)
	{
		
		if($id > 0)
		{	$data['acceso']=$this->valida_acceso(); 
		
			if($data['acceso'][3]==1){
                $this->Taller_vehiculos_model->delete_vehiculo($id);
			}
            redirect('vehiculos');
			
		}
		else
		{
			show_404();
		}
	}


	// Delete imagen
	public function delete_image($image_id, $image_name)
{
    // Decodificamos el nombre de la imagen para poder usarlo sin problemas
    $image_name = urldecode($image_name);

    // Verificamos si el ID de la imagen es válido y si el nombre de la imagen no está vacío
    if ($image_id > 0 && !empty($image_name)) {

        // Verificamos acceso (esto es opcional según tu lógica de control de acceso)
        $data['acceso'] = $this->valida_acceso();

        // Si el usuario tiene permiso para eliminar
        if (isset($data['acceso'][3]) && $data['acceso'][3] == 1) {

            // Llamamos al modelo para eliminar la imagen y su archivo físico
            $this->Taller_vehiculos_model->delete_image($image_id, $image_name);

            // Respondemos con un mensaje de éxito
            echo json_encode([
                'status' => 'success',
                'message' => 'Imagen eliminada correctamente'
            ]);
        } else {
            // Si el usuario no tiene acceso
            echo json_encode([
                'status' => 'error',
                'message' => 'No tienes permisos para realizar esta acción'
            ]);
        }
    } else {
        // Si los IDs o el nombre de la imagen no son válidos
        echo json_encode([
            'status' => 'error',
            'message' => 'Datos inválidos para eliminar la imagen'
        ]);
    }
}




	//------------------FIN Form Modal----------------------------------------------------------------------------------------------------------------------------------------------

	//------------------TODO MODAL CITAS----------------------------------------------------------------------------------------------------------------------------------------------

	public function modal_info_cliente(){

		$id_vehiculo = $this->input->post('id');
		$cliente = $this->input->post('cliente');
		$id_marca = $this->input->post('id_marca');
		$id_modelo = $this->input->post('id_modelo');


		$todoVehiculos = $this->Taller_vehiculos_model->get_list_vehiculos();
			
		$todoClientes = $this->Taller_vehiculos_model->get_clientes();

		$mensaje = "Id enviado: " . $cliente . "   Cliente: " . $cliente;

		if (!$id_vehiculo) {
			echo json_encode(["error" => "ID de vehiculo no válido"]);
			return;
		}else{

			foreach($todoClientes as $clientito){

				if($clientito->dni === $cliente){
					$cliente = $clientito->nombre;
				};
			};

			foreach($todoVehiculos as $vehiculito){

				if($vehiculito->id === $id_vehiculo){
					$id_marca = $vehiculito->marca_nombre;
					$id_modelo = $vehiculito->modelo_nombre;
				};
			};

			echo json_encode([
                'status' => 'success',
                'message' => $mensaje,
				'id_vehiculo' => $id_vehiculo,
				'cliente' => $cliente,
				'modelo' => $id_modelo,
				'marca' => $id_marca
            ]);
		}

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

		$this->Taller_vehiculos_model->add_citas($id_vehiculo, $fecha, $hora, $id_tarea);

		echo json_encode([
			"status" => "ok",
			"hora" => $hora,
			"fecha" => $fecha,
			"datos" => $datos,
			"id_vehiculo" => $id_vehiculo
		]);

	}

	//------------------FIN TODO MODAL CITAS----------------------------------------------------------------------------------------------------------------------------------------------

	//------------------TODO IMAGENES----------------------------------------------------------------------------------------------------------------------------------------------
	// Para obtener todas las imagenes
	public function get_imagenes_vehiculos() {
		$id_vehiculo = $this->input->post('id_vehiculo');

		if ($id_vehiculo) {
			$imagenes = array($this->Taller_vehiculos_model->get_imagenes_vehiculo($id_vehiculo));
			$response = [
				"status" => "success",
				"message" => "Vehículo registrado"
			];
			$response["data"] = $imagenes;
			echo json_encode($response); // Devuelve JSON con las imágenes
		} else {
			$response = [
				"status" => "success",
				"message" =>  validation_errors()
			];
			echo json_encode($response); // En caso de error
		}
	}

	// Plugin Dropzone (Para subir imagenes)
	public function subir_imagen_dropzone(){
		if (!empty($_FILES['imagen']['name'][0])) {
			$uploads_dir = 'assets/img/taller/';
			$id_vehiculo = $this->input->post('id_vehiculo');
	
			foreach ($_FILES['imagen']['name'] as $key => $name) {
				$tmp_name = $_FILES['imagen']['tmp_name'][$key];
				$safe_name = basename($name);
	
				// Guardar en base de datos
				$this->Taller_vehiculos_model->insertar_imagen($safe_name, 0, $id_vehiculo);
	
				if (!move_uploaded_file($tmp_name, $uploads_dir . $safe_name)) {
					echo json_encode(['status' => 'error', 'message' => "Error al subir la imagen: $safe_name"]);
					return;
				}
			}
	
			echo json_encode(['status' => 'success']);
		}
	}

	

	// Cambiar imagen Principal a secundaria y Viceversa
	public function imagenes_ajax() {
		$id = $this->input->post('id_vehiculo');
		$id_img_cambiar = $this->input->post('id_img');
		$principalONo = $this->input->post('principalONo');
		$imagenes = $this->Taller_vehiculos_model->get_imagenes_vehiculo($id);
		$contadorPrincipal = 0;
		$imgPrincipal = null;

		if($id_img_cambiar){
			if($principalONo == 1){

				$this->Taller_vehiculos_model->update_quitar_principal($id, $id_img_cambiar);

			}else{

				foreach($imagenes as $imagen){

					if($imagen->principal == 1){ // Aqui es principal
						$contadorPrincipal++;
						$imgPrincipal = $imagen;
					}else if($imagen->principal == 0){ // Esta no lo es


					}else{
						// Mensaje de error
					}

				}

				if($contadorPrincipal > 0){

					$this->Taller_vehiculos_model->update_quitar_principal($id, $imgPrincipal->id);
					$this->Taller_vehiculos_model->update_poner_principal($id, $id_img_cambiar);

				}else if ($contadorPrincipal <= 0){

					$this->Taller_vehiculos_model->update_poner_principal($id, $id_img_cambiar);

				}
			}
		};

		$baseUrl = base_url(); // solo una base para todo
		$imagenes = $this->Taller_vehiculos_model->get_imagenes_vehiculo($id);
		$nuevaTabla = "";

		foreach ($imagenes as $imagen) {

			$nombreImagen = $imagen->nombre;
			$imagenUrl = $baseUrl . "assets/img/taller/" . $nombreImagen;
			$convertirUrl = $baseUrl . "taller_vehiculos/convertir_principal/" . $id . "/" . $imagen->id;
		
			$nuevaTabla .= '<tr id="images_' . $imagen->id . '">';
		
			// Agregamos <a> alrededor de la imagen (como en tu versión JS)
			$nuevaTabla .= '<td>
								<a href="#" class="imageModals" title="Ver imagen" id="boton_img" data-url="' . $imagenUrl . '" data-toggle="modal" data-placement="top" data-original-title="Ver imagen">
									<img class="images-preview" alt="" src="' . $imagenUrl . '" style="max-width: 100px; margin: 5px;" />
								</a>
							</td>';
		
			$nuevaTabla .= '<td><a data-toggle="modal" data-target="#image-' . $imagen->id . '" href="#">' . $imagen->nombre . '</a></td>';
		
			$nuevaTabla .= '<td class="f-right">';
		
			// Icono de ojo para ver imagen (como botón aparte)
			$nuevaTabla .= '<a href="#" class="imageModals text-primary" title="Ver imagen" id="boton_img" data-url="' . $imagenUrl . '" data-toggle="modal" data-placement="top" data-original-title="Ver imagen">
								<span class="fa fa-eye"></span>
							</a>';
		
			// Estrella (según si es principal o no)
			if($imagen->principal == 0){
				$nuevaTabla .= '<a href="' . $convertirUrl . '" id_product="' . $id . '" id_img="' . $imagen->id . '" principal="' . $imagen->principal . '" data-original-title="Cambiar a imagen principal" data-toggle="tooltip" data-placement="top" image="' . $imagen->id . '" class="text-default" id="cambiarImgPrincipal">
									<span class="fa fa-star-o"></span>
								</a>';
			} else {
				$nuevaTabla .= '<a href="' . $convertirUrl . '" id_product="' . $id . '" id_img="' . $imagen->id . '" principal="' . $imagen->principal . '" data-original-title="Cambiar a imagen principal" data-toggle="tooltip" data-placement="top" image="' . $imagen->id . '" class="text-default" id="cambiarImgPrincipal">
									<span class="fa-solid fa-star"></span>
								</a>';
			}
		
			// Botón de borrar
			$nuevaTabla .= '<a id="deleteImage_' . $imagen->id . '" id_product="' . $id . '" data-original-title="Borrar imagen" data-toggle="tooltip" data-placement="top" image="' . $imagen->nombre . '" class="text-danger delete-image">
								<span class="fa fa-trash"></span>
							</a>';
		
			$nuevaTabla .= '</td>';
			$nuevaTabla .= '</tr>';
		}


		echo json_encode(['status' => 'success', 'data' => $imagenes, 'nuevaTabla' => $nuevaTabla]);
	}


	public function obtenerHorasDisponibles() {
		$tarea_id = $this->input->post('tarea_id');
		$fecha = $this->input->post('fecha');
	
		$this->load->model('Taller_vehiculos_model');
		$horas = $this->Taller_vehiculos_model->getHorasDisponibles($tarea_id);
		$citas = $this->Taller_vehiculos_model->get_citas($tarea_id, $fecha);
		$simultaneoTarea = $this->Taller_vehiculos_model->get_simultaneo($tarea_id);
	
		if (!$horas) return [];

		$horaInicio = new DateTime($horas->hora_inicio);
		$horaFin = new DateTime($horas->hora_fin);
		list($h, $m, $s) = explode(':', $horas->duracion_intervalo);
		$intervalo = new DateInterval("PT{$h}H{$m}M{$s}S");
	
		$conteoCitas = [];

		if (is_array($citas)) {
			foreach ($citas as $cita) {
				$horaCita = substr($cita->hora, 0, 5);
				if (!isset($conteoCitas[$horaCita])) {
					$conteoCitas[$horaCita] = 0;
				}
				$conteoCitas[$horaCita]++;
			}
		}

		$horasDisponibles = [];
	
		while ($horaInicio < $horaFin) {
			$horaFormateada = $horaInicio->format('H:i');
			$cantidadCitas = isset($conteoCitas[$horaFormateada]) ? $conteoCitas[$horaFormateada] : 0;

			if ($cantidadCitas < $simultaneoTarea) {
				$horasDisponibles[] = $horaFormateada;
			}

			$horaInicio->add($intervalo);
		}

		echo json_encode([
			'horas' => $horasDisponibles,
			'citas' => $conteoCitas,
			'simultaneo' => $simultaneoTarea
		]);
		
	}

	public function carga_cuerpo_tabla()
	{

	$boton = $this->input->post('botonPresionado');

	if(!$boton){

		$list_vehiculos = $this->Taller_vehiculos_model->get_list_vehiculos();

	}

	if($boton === "filtrar"){

		$filtros = $this->input->post();

		$list_vehiculos = $this->Taller_vehiculos_model->get_list_vehiculo_filtros($filtros);

	}
	if($boton === "ver_todos"){

		$list_vehiculos = $this->Taller_vehiculos_model->get_list_vehiculos();

	}

	$cadena = "";

	foreach ($list_vehiculos as $vehiculo) {
		$cadena .= '<tr class="fila_sel fila-vehiculo"';
		$cadena .= ' data-id="' . $vehiculo->id . '"';
		$cadena .= ' data-cliente="' . $vehiculo->id_cliente . '"';
		$cadena .= ' data-marca="' . $vehiculo->marca_id . '"';
		$cadena .= ' data-modelo="' . $vehiculo->id_modelo . '"';
		$cadena .= ' data-imagen="' . $vehiculo->imagen . '"';
		$cadena .= ' data-matricula="' . $vehiculo->matricula . '"';
		$cadena .= ' data-color="' . $vehiculo->color . '"';
		$cadena .= ' data-bastidor="' . $vehiculo->num_bastidor . '"';
		$cadena .= ' data-fecha_mant_basico="' . $vehiculo->fecha_mant_basico . '"';
		$cadena .= ' data-fecha_mant_completo="' . $vehiculo->fecha_mant_completo . '"';
		$cadena .= ' data-fecha_matriculacion="' . $vehiculo->fecha_matriculacion . '">';

		$cadena .= '<td class="col_sel">' . $vehiculo->id . '</td>';
		$cadena .= '<td class="col_sel">' . $vehiculo->cliente_nombre . '</td>';
		$cadena .= '<td class="col_sel">' . $vehiculo->marca_nombre . '</td>';
		$cadena .= '<td class="col_sel">' . $vehiculo->modelo_nombre . '</td>';
		$cadena .= '<td class="col_sel">
			<div class="divImgModelo">';

			if ($vehiculo->nombre_img) {
				$img_url = base_url('assets/img/taller/' . $vehiculo->nombre_img);
				$cadena .= '<img class="imgModelo" 
								src="' . $img_url . '" 
								alt="' . $vehiculo->nombre_img . '" 
								value="' . $vehiculo->nombre_img . '" 
								data-url="' . $img_url . '" 
								data-toggle="modal" 
								data-target="#imageModal" 
								style="cursor: pointer;">';
			} else {
				$cadena .= '<p>Imagen principal sin asignar</p>';
			}

		$cadena .= '</div></td>';
		$cadena .= '<td class="col_sel">' . $vehiculo->num_bastidor . '</td>';
		$cadena .= '<td class="col_sel">' . $vehiculo->color . '</td>';
		$cadena .= '<td class="col_sel">' . $vehiculo->matricula . '</td>';
		$cadena .= '<td class="col_sel">' . $vehiculo->fecha_mant_basico . '</td>';
		$cadena .= '<td class="col_sel">' . $vehiculo->fecha_mant_completo . '</td>';
		$cadena .= '<td class="col_sel">' . $vehiculo->fecha_matriculacion . '</td>';

		$cadena .= '<td class="col_sel" style="display: flex; align-items: center; justify-content: center; gap: 10px;">';
		if (isset($vehiculo->id) && $vehiculo->id != 0) {
			$cadena .= '<div id="div_botones"><button type="button" class="btn btn-primary editarModal" data-toggle="modal" data-target="#modal_form" title="Editar" id="boton_vehiculos">
						<i class="fa fa-edit"></i>
					</button>';
			if(isset($vehiculo->tiene_cita) && $vehiculo->tiene_cita != 1){
				$cadena .= '<button type="button" class="btn btn-primary fichaModal" data-toggle="modal" data-target="#modal_ficha" id="boton_vehiculos">
							<i class="fa fa-clipboard"></i>
						</button>';
			}else if(isset($vehiculo->tiene_cita) && $vehiculo->tiene_cita == 1){
				$cadena .= '<button type="button" class="btn btn-primary fichaModal" data-toggle="modal" data-target="#modal_ficha" id="boton_vehiculos" style="background-color: green; border-color: #449d48;" data-info="tiene_cita">
							<i class="fa fa-clipboard"></i>
						</button>';
			}
			$cadena .= anchor("vehiculos/delete/" . $vehiculo->id, "<span class='fa fa-trash'></span>", 
						"class='text-danger delete' data-placement='top' data-toggle='tooltip' data-original-title='Borrar vehículo'");
		}
		$cadena .= '</div></td>';
		$cadena .= '</tr>';
	}

	

	if(!$boton){

		$response = [
			"status" => "success",
			"data" => $cadena
		];
		
		echo json_encode($response);

	}else{

		echo $cadena;

	}

	}

	
	
}

