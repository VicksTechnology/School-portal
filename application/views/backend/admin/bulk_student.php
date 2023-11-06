
                <?php echo form_open(base_url(). 'admin/new_student/import_student', 
										array('class' => 'form-horizontal form-groups-bordered', 'enctype'=> 'multipart/form-data'));?>
					<div class="panel-body table-responsive">
					
                       				<a href="<?php echo base_url();?>uploads/blank_excel_file.xlsx" class="btn btn-info btn-block btn-sm" style="color:white">Download Sample</a>
										<hr>
										

										<div class="form-group">
                 							<label class="col-md-9" for="example-text"><?php echo get_phrase('select_class');?></label>
                   						 		<div class="col-sm-12">
													<select name="class_id" id="class_id" class="form-control select2"  onchange="get_sections_class(this.value)" / required>
														<option value=""><?php echo get_phrase('select_class');?></option>
														<?php
															$classes = $this->db->get('class')->result_array();
															foreach($classes as $row):
														?>
															<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
														<?php endforeach;?>
													</select>
												</div>
										</div>
										
										<div class="form-group">
                 							<label class="col-md-9" for="example-text"><?php echo get_phrase('select_section');?></label>
                   						 		<div class="col-sm-12">
												<select name="section_id" id="section_class"  class="form-control" / required>
													<option value=""><?php echo get_phrase('select_class_first') ?></option>
												</select>  
												</div>
										</div>
										
										<div class="form-group">
                 							<label class="col-md-9" for="example-text"><?php echo get_phrase('select_excel_file');?></label>
                   						 		<div class="col-sm-12">
												<input type="file" name="bulk" class="form-control" / required>
												</div>
										</div>
										
										<div class="alert alert-default" >Please note that all fields are rquired from the excel. We have prepared it based on our own logic. If you want us to select information needed only like name, email, password, address, we can do that for you.
										<br>
										</div>
				  		
				  						
							
						
                           <div class="form-group">
                                  <button type="submit" class="btn btn-block btn-info btn-rounded btn-sm "><i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add');?></button>
							</div>
                <?php echo form_close();?>
				
				
				<script type="text/javascript">

	function get_sections_class(class_id) {

    	$.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_class').html(response);
            }
        });

    }

</script>
