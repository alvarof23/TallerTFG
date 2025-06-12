<?php
	
function model_template($module_format,$module,$icon)
{
	
$model ='

<?php

class '.ucwords($module_format).'_model extends CI_Model{
		
	public function __construct()
	{
		parent::__construct();
  	}
		
	public function get_data_list()
    {
   		
		$this->db->select("id_'.$module_format.',name_'.$module_format.'");
		$query = $this->db->get('.$module_format.');
		
		if ($query->num_rows() > 0)
		{
			return $query->result();
			$this->db->close();
				
		}else
		{
			return FALSE;
		}
				
	
    }
		
	public function edit_data($id)
    {
   		
		$query = $this->db->get_where("'.$module_format.'", array("id_'.$module_format.'" => $id));
		
		if ($query->num_rows() > 0)
		{
			return $query->row();
			$this->db->close();
			
		}else
		{
			return FALSE;
		}
				
	
    }
		
	public function set_data($data)
    {

		$this->db->trans_start();
		$this->db->insert("'.$module_format.'", $data);
		$this->db->trans_complete(); 
		if ($this->db->trans_status() === FALSE)
			show_error("Error al intentar insertar en la tabla '.$module_format.'.".__DIR__." Linea ".__LINE__);

		$this->db->close();

    }
	    
    public function update_data($id,$data)
    {

		$this->db->trans_start();
		$this->db->where("id_'.$module_format.'", $id);
		$this->db->update("'.$module_format.'", $data);
		$this->db->trans_complete(); 
		if ($this->db->trans_status() === FALSE)
			show_error("Error al intentar editar en la tabla '.$module_format.'.".__DIR__." Linea ".__LINE__);
		
		$this->db->close();

    }
		
	public function delete_data($id)
    {

		$this->db->trans_start();
		$this->db->where("id_'.$module_format.'", $id);
		$this->db->delete("'.$module_format.'");
		$this->db->trans_complete(); 
		if ($this->db->trans_status() === FALSE)
			show_error("Error al intentar editar en la tabla '.$module_format.'.".__DIR__." Linea ".__LINE__);
		
		$this->db->close();

    }
	
}
';

return $model;
		
}
	
	
	
