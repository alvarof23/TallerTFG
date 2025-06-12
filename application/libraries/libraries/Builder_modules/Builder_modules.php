<?php
/**
 * YCP Creativos
 *
 * @package	CodeIgniter
 * @author	YCP Creativos
 * @copyright	YCP Creativos (c) 2015, YCP Creativos SL, (http://www.ycomieronperdices.net)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://www.ycomieronperdices.net
 * @since	Version 1.0.0
 */
// ------------------------------------------------------------------------
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Builder_modules Class
 *
 * Permits email to be sent using Mail, Sendmail, or SMTP.
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		YCP Creativos Team
 */
 
class Builder_modules{

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @param	$module -> string. It contains the module name
	 * @param	$icon-> name icon module
	 * @param	$CI -> Assign the CodeIgniter object to the  variable CI
	 * @param	$CI->load->helper('file'); -> We load the file helper
	 * @param	$folders -> array with the folder structure
	 * @param	$records -> array with the records structure
	 * @return	Depending on if everything went well or badly will return true or false
	 */
	public function built_module($module,$icon)
	{
		
		$CI =& get_instance();
		$CI->load->helper('file');
		$module = $this->clear_characters($module); //remove accents and special characters
		$data_archives = $this->template_module($module,$icon);
		$module = strtolower($module); //converted to lowercase
		$module = str_replace(" ","_",$module); //guiób change the space low
		$result = TRUE;
		
		$folders = array(
						
						'back_office/modules/'.$module,
						'back_office/modules/'.$module.'/controllers',
						'back_office/modules/'.$module.'/models',
						'back_office/modules/'.$module.'/views',
						'back_office/modules/'.$module.'/views/js_module',
						'back_office/modules/'.$module.'/views/css_module',
						'back_office/modules/'.$module.'/views/include',
					);
					
		$records = array(
						
						'back_office/modules/'.$module.'/controllers/'.ucwords($module).'.php',//capitulate to match the file name
						'back_office/modules/'.$module.'/models/'.ucwords($module).'_module.php',//capitulate to match the file name
						'back_office/modules/'.$module.'/views/'.$module.'.php',
						'back_office/modules/'.$module.'/views/'.$module.'_add.php',
						'back_office/modules/'.$module.'/views/'.$module.'_edit.php',
						'back_office/modules/'.$module.'/views/js_module/js_module.php',
						'back_office/modules/'.$module.'/views/css_module/css_module.php',
					);
					
		foreach ($folders as $key => $folder)
		{
			
			if (!file_exists($folder))
			{
			
			    mkdir($folder, 0755, true);
				
			}else{
				
				$result = FALSE;
			}
			
		}
		
		foreach ($records as $key => $archive)
		{
			
			if (!write_file($archive, $data_archives[$key]))
			{
								
				$result = FALSE;
								
			}
			
		}

		return $result;
		
	}

	// --------------------------------------------------------------------
	
	/**
	 *function module generates templates
	 * @param	$controller -> It contains controller data
	 * @param	$CI -> Assign the CodeIgniter object to the  variable CI
	 * @param	$CI->load->helper('url'); -> We load the url helper
	 * @param	$model -> It contains model data
	 * @param	$view_table -> It contains view table data
	 * @param	$view_add ->  It contains view add data
	 * @param	$view_edit -> It contains view edit data
	 * @param	$data -> array with the data file
	 * @param	$module-> name module
	 * @param	$icon-> name icon module
	 * @return	returns an array with the data of each file
	 */
	
	private function template_module($module,$icon)
	{
		
		require_once 'templates/template_module.php';
		$CI =& get_instance();
		$CI->load->helper('url');
		
		$module = $this->clear_characters($module);//remove accents and special characters
		$module_format = $module;
		$module_format = strtolower($module_format); //converted to lowercase
		$module_format = str_replace(" ","_",$module_format); //guiób change the space low
		
		$controller = get_controller_template($module_format,$module,$icon);
		$model = get_model_template($module_format,$module,$icon);
		$view_table = get_view_table_template($module_format,$module,$icon);
		$view_add = get_view_add_template($module_format,$module,$icon);
		$view_edit = get_view_add_template($module_format,$module,$icon);
		$js = "";
		$css = "";

		$data = array(
						
						$controller,
						$model,
						$view_table,
						$view_add,
						$view_edit,
						$js,
						$css,
					);
					

		return $data;
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 *function delete module and folders
	 * @param	$module-> name module
	 * @return	depending on if everything went well or badly will return true or false
	 */
	
	public function delete_module($module)
	{
		
		$module = $this->clear_characters($module); //remove accents and special characters
		$module = strtolower($module); //converted to lowercase
		$module = str_replace(" ","_",$module); //guiób change the space low
		$result = TRUE;
		
		$folders = array(
						
						'back_office/modules/'.$module.'/views/js_module',
						'back_office/modules/'.$module.'/views/css_module',
						'back_office/modules/'.$module.'/views/include',
						'back_office/modules/'.$module.'/controllers',
						'back_office/modules/'.$module.'/models',
						'back_office/modules/'.$module.'/views',
						'back_office/modules/'.$module
						
					);
		
		$records = array(
						
						'back_office/modules/'.$module.'/controllers/'.ucwords($module).'.php',//capitulate to match the file name
						'back_office/modules/'.$module.'/models/'.ucwords($module).'_module.php',//capitulate to match the file name
						'back_office/modules/'.$module.'/views/'.$module.'.php',
						'back_office/modules/'.$module.'/views/'.$module.'_add.php',
						'back_office/modules/'.$module.'/views/'.$module.'_edit.php',
						'back_office/modules/'.$module.'/views/js_module/js_module.php',
						'back_office/modules/'.$module.'/views/css_module/css_module.php'
					);
		
		foreach ($records as $key => $archive)
		{
			
			if (!unlink($archive))
			{
								
				$result = FALSE;
								
			}
			
		}
		
		foreach ($folders as $key => $folder)
		{
			
			if (rmdir($folder))
			{
			
			   $result = FALSE;
				
			}
			
		}
		
		return $result;
		
	}
	
	// --------------------------------------------------------------------
	
	private function clear_characters($str)
	{

		$characters = array(
					"À"=> "A",
					"Á"=>"A",
					"Â"=>"A",
					"Ã"=>"A",
					"Ä"=>"A",
					"Å"=>"A",
					"à"=>"a",
					"á"=>"a",
					"â"=>"a",
					"ã"=>"a",
					"ä"=>"a",
					"å"=>"a",
					"Ò"=>"O",
					"Ó"=>"O",
					"Ô"=>"O",
					"Õ"=>"O",
					"Ö"=>"O",
					"Ø"=>"O",
					"ò"=>"o",
					"ó"=>"o",
					"ô"=>"o",
					"õ"=>"o",
					"ö"=>"o",
					"ø"=>"o",
					"È"=>"E",
					"É"=>"E",
					"Ê"=>"E",
					"Ë"=>"E",
					"è"=>"e",
					"é"=>"e",
					"ê"=>"e",
					"ë"=>"e",
					"Ç"=>"C",
					"ç"=>"c",
					"Ì"=>"I",
					"Í"=>"I",
					"Î"=>"I",
					"Ï"=>"I",
					"ì"=>"i",
					"í"=>"i",
					"î"=>"i",
					"ï"=>"i",
					"Ù"=>"U",
					"Ú"=>"U",
					"Û"=>"U",
					"Ü"=>"U",
					"ù"=>"u",
					"ú"=>"u",
					"û"=>"u",
					"ü"=>"u",
					"ÿ"=>"y",
					"Ñ"=>"N",
					"ñ"=>"n"
				);
				
		$str = strtr($str,$characters);
		return $str;
	}
		
}
