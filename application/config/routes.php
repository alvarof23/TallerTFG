<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//Mostrar logs
$config['log_threshold'] = 4;

$route['prueba'] = 'welcome/prueba';

//clientes
$route['clientes'] = 'taller_clientes';
$route['clientes/eliminar_cliente/(:any)'] = 'taller_clientes/eliminar_cliente/$1';

//Vehiculos
$route['vehiculos'] = 'taller_vehiculos';
$route['vehiculos/index'] = 'taller_vehiculos/index';
$route['vehiculos/add'] = 'taller_vehiculos/vehiculos_form_ajax';
$route['vehiculos/imgs'] = 'taller_vehiculos/get_imagenes_vehiculos';
$route['vehiculos/imgCambio'] = 'taller_vehiculos/imagenes_ajax';
$route['vehiculos/subirImagen'] = 'taller_vehiculos/subir_imagen_dropzone';
$route['vehiculos/delete/(:any)'] = 'taller_vehiculos/delete/$1';
$route['vehiculos/delete_image/(:any)/(:any)'] = 'taller_vehiculos/delete_image/$1/$2';
$route['vehiculos/get_modelos_por_marca'] = 'taller_vehiculos/get_modelos_por_marca';
$route['vehiculos/modal_info_cliente'] = 'taller_vehiculos/modal_info_cliente';
$route['vehiculos/add_cita'] = 'taller_vehiculos/add_cita';
$route['vehiculos/obtenerHorasDisponibles'] = 'taller_vehiculos/obtenerHorasDisponibles';
$route['vehiculos/carga_cuerpo_tabla'] = 'taller_vehiculos/carga_cuerpo_tabla';
$route['vehiculos/ver_todos_ajax'] = 'taller_vehiculos/ver_todos_ajax';


$route['vehiculos/get_vehiculos'] = 'taller_vehiculos/get_vehiculos';




//VehiculosCOPIA
$route['citas'] = 'taller_citas';
$route['citas/detalles/(:num)/(:any)'] = 'taller_citas/detalles/$1/$2';
$route['citas/get_recepcion/(:num)'] = 'taller_citas/get_recepcion/$1';
$route['generar-factura'] = 'taller_citas/generar_factura'; 
$route['taller_facturas/imprimir_factura/(:num)'] = 'taller_facturas/imprimir_factura/$1';
$route['citas/cargar_firma/(:num)'] = 'taller_citas/cargar_firma/$1';


$route['default_controller'] = 'taller';

$route['configuraciones'] = 'taller_configuraciones';

$route['contacto'] = 'taller_contacto';

$route['usuarios'] = 'taller_usuarios';
