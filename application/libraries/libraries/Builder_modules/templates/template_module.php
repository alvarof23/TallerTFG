<?php
	
	require_once 'controller_template.php';
	require_once 'model_template.php';
	require_once 'view_table_template.php';
	require_once 'view_add_template.php';
	
	function get_controller_template($module_format,$module,$icon)
	{
		
		return controller_template($module_format,$module,$icon);
		
	}
	
	function get_model_template($module_format,$module,$icon)
	{
		
		return model_template($module_format,$module,$icon);
		
	}
	
	function get_view_table_template($module_format,$module,$icon)
	{
		
		return view_table_template($module_format,$module,$icon);
		
	}
	
	function get_view_add_template($module_format,$module,$icon)
	{
		
		return view_add_template($module_format,$module,$icon);
		
	}
	
?>