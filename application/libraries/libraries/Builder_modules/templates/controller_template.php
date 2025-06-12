<?php
	
function controller_template($module_format,$module,$icon)
{
	
$template = '
<?php

if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class '.ucwords($module_format).'  extends MX_Controller {
			
	private $lang = "";
	private $icono = "";
	
	public function __construct()
	{
		
    	parent::__construct();
		$this->lang = "es";
		$this->icono = "'.$icon.'";
		$this->load->model("'.ucwords($module_format).'_model");

    }
	
	public function index()
	{
		$data["lang"] = $this->lang;

		$data["title"] = "Panel de control | ".$this->Main_model->get_data_project_back()->name_client;
			
		$data["keywords"] = "";

		$data["description"] = "";
			
		$data["reference"] = "'.strtoupper($module).'";

		$data["view"] = "'.$module_format.'";
		
		$data["page"] = "'.$module.'";
		
		$data["icono"] = $this->icono;
			
		$data["robots"] = "noindex, nofollow";
		
		$data["js"] =  $this->load->view("js_module/js_module","",TRUE);
		
		$data["data_list"] = $this->'.ucwords($module_format).'_model->get_data_list();

		$this->load->view("layout", $data);
	}
	
	public function add()
	{
		$data["lang"] = $this->lang;

		$data["title"] = "Panel de control | ".$this->Main_model->get_data_project_back()->name_client;
			
		$data["keywords"] = "";

		$data["description"] = "";
			
		$data["reference"] = "'.strtoupper($module).'-ADD";

		$data["view"] = "'.$module_format.'_add";
		
		$data["page"] = "Añadir '.$module.'";
		
		$data["icono"] = $this->icono;
			
		$data["robots"] = "noindex, nofollow";
		
		$data["js"] =  $this->load->view("js_module/js_module","",TRUE);
		
		if (isset( $_POST["submit_form"] ))
		{
			$this->form_validation->set_rules("name", "name", "required");
			$this->form_validation->set_error_delimiters('."'".'<div role="alert" class="alert alert-danger">'."'".', '."'".'</div>'."'".');
			
			if ($this->form_validation->run() == TRUE)
			{
				
				$this->'.ucwords($module_format).'_model->set_data();
				redirect("'.url_title($module).'");
			}
		}

		$this->load->view("layout", $data);
	}

	public function edit($id)
	{
		if($id > 0)
		{
			
			$data["lang"] = $this->lang;

			$data["title"] = "Panel de control | ".$this->Main_model->get_data_project_back()->name_client;
				
			$data["keywords"] = "";
	
			$data["description"] = "";
				
			$data["reference"] = "'.strtoupper($module).'-EDIT";
	
			$data["view"] = "'.$module_format.'_edit";
			
			$data["page"] = "Editar '.$module.'";
			
			$data["icono"] = $this->icono;
				
			$data["robots"] = "noindex, nofollow";
			
			$data["js"] =  $this->load->view("js_module/js_module","",TRUE);
			
			$data["edit_data"] = $this->'.ucwords($module_format).'_model->edit_data();
			
			if (isset( $_POST["submit_form"] ))
			{
				$this->form_validation->set_rules("name", "name", "required");
				$this->form_validation->set_error_delimiters('."'".'<div role="alert" class="alert alert-danger">'."'".', '."'".'</div>'."'".');
				
				if ($this->form_validation->run() == TRUE)
				{
					
					$this->'.ucwords($module_format).'_model->update_data();
					redirect("'.url_title($module).'");
				}
			}
	
			$this->load->view("layout", $data);
			
		}else
		{
			
			show_404();
		}

	}

	public function delete($id = 0)
	{
		
		if($id > 0)
		{
			
			$this->'.ucwords($module_format).'_model->delete_data($id);
			redirect("'.url_title($module).'");
			
		}else
		{
				show_404();
		}
	}
	
}
';

return $template;
		
}
	
	
	
