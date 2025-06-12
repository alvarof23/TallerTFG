<?php
	
function view_table_template($module_format,$module,$icon)
{

$name = explode("_", $module_format); 
$name = ucwords($name[0]);

$view_table ='

<div class="page-content-wrap">
	
	<div class="row">
	
		<div class="col-md-12">

	        <div class="panel panel-default">
	        
				<div class="panel-heading">
	            	                                
	                <ul class="panel-controls">
	                	
	                    <li><?= anchor("modulos/add", '."'".'<span class="fa fa-plus"></span>","data-placement="left" data-toggle="tooltip" data-original-title="Nuevo módulo"'."'".') ?></li>
	                    
	                </ul>
	                
	                <?= anchor("modulos/export_excel", '."'".'<i class="fa fa-cloud-download"></i> Exportar datos","class="btn btn-danger dropdown-toggle"'."'".') ?> 
	                
	                <?= anchor("modulos/import_excel", '."'".'<i class="fa fa-cloud-upload"></i> Importar datos","class="btn btn-danger dropdown-toggle"'."'".') ?>
	                                       
	            </div>
	            
	            <div class="panel-body">
	            	
	                <div class="table-responsive">
	                	
	                	<?php if ($data_list): ?>
	                	
	                    	<table class="table datatable">
	                    		
	                    		<thead>
	                        	
		                            <tr>
		                                <th>id</th>
		                                <th>'.$name.'</th>
		                                <th>Acciones</th>
		                                
		                            </tr>
		                            
		                        </thead>
		                        
		                        <tbody>
		                        	
		                        	<?php foreach ($data_list as $key => $data): ?>
		                        		
		                        		<tr>
		                        			
		                        			<td><?= $data->id_'.$module_format.' ?></td>
	                                
	                                		<td><?= $data->name_'.$module_format.' ?></td>
	                                		
	                                		<td>    
								    			<?= anchor("modulos/edit/".$data->id_'.$module_format.', '."'".'<span class="fa fa-pencil"></span>'."'".','."'".'class="text-default" data-placement="top" data-toggle="tooltip" data-original-title="Editar módulo"'."'".') ?>
								    			<?= anchor("modulos/delete/".$data->name_'.$module_format.', '."'".'<span class="fa fa-times"></span>'."'".','."'".'class="text-danger delete" data-placement="top" data-toggle="tooltip" data-original-title="Borrar módulo"'."'".') ?>
								  			</td>
		                        			
		                        		</tr>
		                        		
		                        	<?php endforeach ?>
		                       
	                    		</tbody>
	                    		
	                    	</table>
	                    
	                    <?php else: ?>
								
							<div role="alert" class="alert alert-warning">
								
                                <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>
                                
                                <strong><i class="fa fa-warning"></i></strong> Esta sección no tiene datos para mostrar.
                                
                            </div>
									
						<?php endif ?>
	                	
	                </div>
	                
	            </div>
	        
			</div>
			
		</div>
		
	</div>
	
</div>

';

return $view_table;
		
}
	
	
	
