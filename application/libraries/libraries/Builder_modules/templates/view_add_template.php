<?php
	
function view_add_template($module_format,$module,$icon)
{
	
$model ='
<div class="page-content-wrap">
	
	<div class="row">
		
		<div class="col-md-12">
			
			<form method="post" class="form-horizontal">
				
				<div class="panel-body">
					
					<div class="form-group">
                        	
                        <div class="col-md-3 col-xs-12" ></div>
						<div class="col-md-6 col-xs-12"><?= validation_errors(); ?></div>   
                        <div class="col-md-3 col-xs-12" ></div>
                        
                    </div>

				</div>
				
				<div class="panel-footer">                                  
                    <button type="submit" name="submit_form" class="btn btn-primary">Guardar</button>
                </div>
				
			</form>
			
		</div>
		
	</div>
	
</div>
';

return $model;
		
}
	
	
	
