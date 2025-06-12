<div class="page-content-wrap">
	<div class="row">
		<form method="post" class="form-horizontal">
			
			<?php if($reference == 'PAGE-ADD'): ?>
			
				<div class="col-md-12">
				
			<?php else: ?>
				
				<div class="col-md-9">
				
			<?php endif ?>		
				
                <div class="panel panel-default">
                    <div class="panel-body">          
                        <div class="form-group">
                            <div class="col-md-2 col-xs-12" ></div>
							<div class="col-md-8 col-xs-12">
								<?= validation_errors(); ?>
								
								<?php if(isset($edit_ok)) echo $edit_ok ?>
							</div>   
                            <div class="col-md-2 col-xs-12" ></div>
                        </div>
                        <div class="form-group">
                         	<label class="col-md-2 col-xs-12 control-label">Indexar <i class="fa fa-question-circle" title="" data-toggle="tooltip" data-original-title="Index"></i></label>
				    		<div class="col-md-8 col-xs-12">
				    			<label class="switch switch-small">
                                    <input name="index_page" <?php if($values_1['index_page'] == 1) echo 'checked="checked"' ?> value="1" type="checkbox">
                                    <span></span>
                                </label>
                            </div>
                        </div>        
                       <!-- <div class="form-group">
                            <label class="col-md-2 control-label">Carrusel <i class="fa fa-question-circle" title="" data-toggle="tooltip" data-original-title="Cabecera"></i></label>
                            <div class="col-md-6 col-sm-12 col-xs-12">                                                    
                            	<select id="id_carrusel" name="id_carrusel" class="select form-control" title="Selecciona una categoría...">
									<option data-hidden="true"></option>
										
										<?php if ($carrusel): ?>
											
											<?php foreach ($carrusel as $key => $value): ?>
												
												<option <?php if($values_1['id_carrusel'] == $value->id) echo 'selected' ?> value="<?= $value->id ?>"><?= $value->name_category ?></option>
												
											<?php endforeach ?>
											
										<?php endif ?>
									
								</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Galería de imágenes <i class="fa fa-question-circle" title="" data-toggle="tooltip" data-original-title=""></i></label>
                            <div class="col-md-6 col-sm-12 col-xs-12">                                                    
                            	<select id="galerias" name="galerias[]" class="select form-control" title="Selecciona una categoría.." multiple>
										
									<?php if ($galerias): ?>
										
										<?php foreach ($galerias as $key => $value): ?>
											
											<option <?php if(in_array($value->id, $values_1['edit_galeria'])) echo 'selected' ?> value="<?= $value->id ?>"><?= $value->name_category ?></option>
											
										<?php endforeach ?>
										
									<?php endif ?>
									
								</select>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label class="col-md-2 control-label">Galería de videos <i class="fa fa-question-circle" title="" data-toggle="tooltip" data-original-title=""></i></label>
                            <div class="col-md-6 col-sm-12 col-xs-12">                                                    
                            	<select id="videos" name="videos[]" class="select form-control" title="Selecciona una categoría.." multiple>
										
									<?php if ($videos): ?>
										
										<?php foreach ($videos as $key => $value): ?>
											
											<option <?php if(in_array($value->id, $values_1['edit_videos'])) echo 'selected' ?> value="<?= $value->id ?>"><?= $value->name_category ?></option>
											
										<?php endforeach ?>
										
									<?php endif ?>
									
								</select>
                            </div>
                        </div> -->
                        
                        
                         <div class="form-group">
                            <label class="col-md-2 control-label">Galería de imágenes <i class="fa fa-question-circle" title="" data-toggle="tooltip" data-original-title=""></i></label>
                            <div class="col-md-6 col-sm-12 col-xs-12">                                                    
                            	<select id="galerias" name="galerias[]" class="select form-control" title="Selecciona una categoría.." multiple>
										
									<?php if ($galerias): ?>
										
										<?php foreach ($galerias as $key => $value): ?>
											
											<option <?php if(in_array($value->id, $values_1['edit_galeria'])) echo 'selected' ?> value="<?= $value->id ?>"><?= $value->name_category ?></option>
											
										<?php endforeach ?>
										
									<?php endif ?>
									
								</select>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label class="col-md-2 control-label">Galería de videos <i class="fa fa-question-circle" title="" data-toggle="tooltip" data-original-title=""></i></label>
                            <div class="col-md-6 col-sm-12 col-xs-12">                                                    
                            	<select id="videos" name="videos[]" class="select form-control" title="Selecciona una categoría.." multiple>
									<?php if ($videos): ?>
										
										<?php foreach ($videos as $key => $value): ?>
											
											<option <?php if(in_array($value->id, $values_1['edit_videos'])) echo 'selected' ?> value="<?= $value->id ?>"><?= $value->name_category ?></option>
											
										<?php endforeach ?>
										
									<?php endif ?>
									
									
								</select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label">Categoría FAQS <i class="fa fa-question-circle" title="" data-toggle="tooltip" data-original-title=""></i></label>
                            <div class="col-md-6 col-sm-12 col-xs-12">                                                    
                            	<select id="faq" name="faq[]" class="select form-control" title="Selecciona una categoría.." multiple>
										
									<?php if ($faq): ?>
										
										<?php foreach ($faq as $key => $value): ?>
											
											<option <?php if(in_array($value->id_category, $values_1['edit_faq'])) echo 'selected' ?> value="<?= $value->id_category ?>"><?= $value->name_category_faq ?></option>
											
										<?php endforeach ?>
										
									<?php endif ?>
									
								</select>
                            </div>
                        </div>
                        
                        
                        
                        <?php $this->load->view('include/form_lang') ?>

                 	</div>
                	<div class="panel-footer">
                    	<a href="<?= site_url('paginas') ?>" class="btn btn-ycp"><i class="fa fa-reply"></i>Volver</a>
                    	
                    	<?php if($reference == 'PAGE-EDIT'): ?>
                    		
                    		<button type="submit" name="submit_form_exit" class="btn btn-default exit pull-right"><i class="fa fa-sign-out"></i> Guardar y salir</button>
                        
                        <?php endif ?>	
                        
                        <button type="submit" name="submit_form" class="btn btn-primary pull-right m-right-10"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                </div>
			</div>
		</form>
		
		<?php if($reference == 'PAGE-EDIT'): ?>
		
			<?php $this->load->view('include/attached_files') ?>
			
			<?= $this->load->view('include/modal_upload') ?>
			
		<?php endif ?>	
		
	</div>
</div>

