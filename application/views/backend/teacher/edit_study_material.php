<?php $material = $this->db->get_where('material', array('material_id' => $param2))->result_array();
            foreach($material as $key => $material):?>
<div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">EDIT MATERIAL</div>
                                <div class="panel-body">
                <?php echo form_open(base_url().'studymaterial/study_material/update/'. $param2 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	


                <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('name');?></label>
                    <div class="col-sm-12">
                                    <input type="text" class="form-control" value="<?php echo $material['name'];?>" name="name" / required>
                        </div>
                    </div>


                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('class');?></label>
                    <div class="col-sm-12">
                    <select name="class_id" id="class_id" class="form-control select2" onchange="return get_class_subject(this.value)">
                    <option value=""><?php echo get_phrase('select_class');?></option>

                    <?php $class =  $this->db->get('class')->result_array();
                    foreach($class as $key => $class):?>
                    <option value="<?php echo $class['class_id'];?>"<?php if($material['class_id'] == $class['class_id']) echo 'selected';?>><?php echo $class['name'];?></option>
                    <?php endforeach;?>
                   </select>

                  </div>
                 </div>

								
					<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('subject');?></label>
                    <div class="col-sm-12">
                    <select name="subject_id" class="form-control" id="subject" / required>
                    <option value=""><?php echo get_phrase('select_subject');?></option>
                    </select>
                  </div>
                 </div>


						<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('select_date');?></label>
                    <div class="col-sm-12">

                 	<input type="date" name="timestamp" value="<?php echo $material['timestamp'];?>" class="form-control datepicker" id="example-date-input" required>
				   
                    </div>
                </div>

               <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('select_teacher');?></label>
                    <div class="col-sm-12">
                       
					   <select name="teacher_id" class="form-control select2" style="width:100%;" required>
										<option value=""><?php echo get_phrase('select');?></option>

                           <?php $teacher =  $this->db->get('teacher')->result_array();
                                    foreach($teacher as $key => $teacher):?>         	
                                    		<option value="<?php echo $teacher['teacher_id'];?>"<?php if($material['teacher_id']== $teacher['teacher_id']) echo 'selected';?>><?php echo $teacher['name'];?></option>
                            <?php endforeach;?>
                                     
                                    </select>              
					    
						
                    </div> 
                </div>


                <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('file_type');?></label>
                    <div class="col-sm-12">
                       
					   <select name="file_type" class="form-control select2" style="width:100%;" required>
										<option value=""><?php echo get_phrase('file_type');?></option>

                           
                                    		<option value="pdf"<?php if($material['file_type'] == 'pdf') echo 'selected';?>>PDF</option>
                                            <option value="xlsx"<?php if($material['file_type'] == 'xlsx') echo 'selected';?>>Excel</option>
                                            <option value="docx"<?php if($material['file_type'] == 'docx') echo 'selected';?>>Word Document</option>
                                            <option value="img"<?php if($material['file_type'] == 'img') echo 'selected';?>>Image</option>
                                            <option value="txt"<?php if($material['file_type'] == 'txt') echo 'selected';?>>Text File</option>
                          
                                     
                                    </select>              
					    
						
                    </div> 
                </div>


				
				
				<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('description');?></label>
                    <div class="col-sm-12">
                                <textarea  name="description" class="form-control"><?php echo $material['description'];?></textarea>
                            </div>
                        </div>
			

                    
 				<?php if(!(demo())){ ?>
				<div class="form-group">
					<button type="submit" class="btn btn-default btn-rounded btn-block btn-sm"><i class="fa fa-save"></i>  <?php echo get_phrase('save');?></button>
				</div>
				<?php } ?>
					
                <?php echo form_close();?>	
									
									
                            </div>
                        </div>
                    </div>
				</div>  
<?php endforeach;?>



<script type="text/javascript">

	function get_class_subject(class_id) {

    	$.ajax({
            url: '<?php echo base_url();?>admin/get_class_subject/' + class_id ,
            success: function(response)
            {
                jQuery('#subject').html(response);
            }
        });

    }

</script>
