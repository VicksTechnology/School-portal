<?php 
$select_hrm = $this->db->get_where('hrm', array('hrm_id' => $param2))->result_array();
foreach($select_hrm as $key => $hrm):  ?>



<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
				<?php echo get_phrase('New hrm');?></div>
                        <div class="panel-body">

                        <?php echo form_open(base_url() . 'hrm/hrm/update/'. $hrm['hrm_id'] , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

 					<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Name');?> <b style="color:red">*</b></label>

                    <div class="col-sm-12">
                            <input type="text" name="name" value="<?php echo $hrm['name'];?>" class="form-control">
                        </div>
                    </div>


                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('DOB');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">
                    <input class="form-control m-r-10" name="birthday" type="date" value="<?php echo $hrm['birthday'];?>" id="example-date-input" required>
                        </div>
                    </div>


                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Sex');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">
                    <select class="form-control select2" name="sex" / required>

                    <option value="Male"<?php if ($hrm['sex'] == 'Male') echo 'selected;' ?>><?php echo get_phrase('Male');?></option>
                    <option value="Female"<?php if ($hrm['sex'] == 'Female') echo 'selected;' ?>><?php echo get_phrase('Female');?></option>
                    </select>

                        </div>
                    </div>


                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Religion');?></label>
                    <div class="col-sm-12">
                    <input type="text" name="religion" value="<?php echo $hrm['religion'];?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Blood Group');?></label>
                    <div class="col-sm-12">
                    <input type="text" name="blood_group"  value="<?php echo $hrm['blood_group'];?>" class="form-control">
                        </div>
                    </div>
					
					<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Email');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">

                            <input type="email" name="email" value="<?php echo $hrm['email'];?>" class="form-control" /required>
                        </div>
                    </div>

                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Phone');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">

                            <input type="text" name="phone" value="<?php echo $hrm['phone'];?>" class="form-control" /required>
                        </div>
                    </div>

                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Qualification');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">

                            <input type="text" name="qualification" value="<?php echo $hrm['qualification'];?>" class="form-control" /required>
                        </div>
                    </div>


                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Marital Status');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">
                    <select class="form-control select2" name="marital_status" / required>
                    <<option value="Married"<?php if ($hrm['marital_status'] == 'Married') echo 'selected;' ?>><?php echo get_phrase('Married');?></option>
                    <option value="Single"<?php if ($hrm['marital_status'] == 'Single') echo 'selected;' ?>><?php echo get_phrase('Single');?></option>
                    <option value="Other"<?php if ($hrm['marital_status'] == 'Other') echo 'selected;' ?>><?php echo get_phrase('Other');?></option>
                    </select>

                        </div>
                    </div>


                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Address');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">
                            <textarea class="form-control" name="address"><?php echo $hrm['address'];?></textarea>
                        </div>
                    </div>
					
					
					 <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('department');?> <b style="color:red">*</b></label>
                    <div class="col-sm-12">

                            <select name="department_id" id="department_id" class="form-control select2" 
							onchange="return get_designation_val(this.value, <?php echo $param2;?>)" required>
								<?php
                                $department = $this->db->get('department')->result_array();
                                foreach ($department as $row2): ?>
                                    <option value="<?php echo $row2['department_id']; ?>"
                                    <?php if($librarian['department_id'] == $row2['department_id']) echo 'selected="selected"' ;?>><?php echo $row2['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
							
                        </div>
                    </div>
					
					 <div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo get_phrase ('designation');?> <b style="color:red">*</b></label>
                    	<div class="col-sm-12">
                          <select name="designation_id" class="form-control" id="designation_holder_modal" / required>
							<option value=""><?php echo get_phrase('select_a_department_first'); ?></option>
						</select>
                        </div>
                    </div>
					
					
					<div class="form-group">
						<label class="col-sm-12"><?php echo get_phrase('date_of_joining'); ?> <b style="color:red">*</b></label>
				
						<div class="col-sm-12">
							<input type="date" class="form-control datepicker" name="date_of_joining" value="<?php echo $hrm['date_of_joining'];?>" required>
						</div> 
					</div>
				
				
				<div class="form-group">
					<label class="col-sm-12"><?php echo get_phrase('date_of_leaving'); ?> </label>
			
					<div class="col-sm-12">
						<input type="date" class="form-control datepicker" name="date_of_leaving" value="<?php echo $hrm['date_of_leaving'];?>">
					</div> 
				</div>
				
				<div class="form-group">
                        <label class="col-sm-12"><?php echo get_phrase('status'); ?></label>

                        <div class="col-sm-12">
                            <select name="status" class="form-control select2">
                                <option value="1"<?php if($hrm ['status'] == '1') echo 'selected="selected"';?>><?php echo get_phrase('active'); ?></option>
                                <option value="2"<?php if($hrm ['status'] == '2') echo 'selected="selected"';?>><?php echo get_phrase('inactive'); ?></option>
                            </select>
                        </div> 
                    </div>
					
					
					 <div class="form-group">
                    <label class="col-sm-12"><?php echo get_phrase('joining_salary'); ?></label>

                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="joining_salary" value="<?php echo $hrm['joining_salary'];?>" required>
                        </div> 
                    </div>
					
			
				 <div class="form-group">
                        <label class="col-sm-12"><?php echo get_phrase('account_holder_name'); ?> <b style="color:red">*</b></label>

                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="account_holder_name" value="<?php echo $hrm['account_holder_name'];?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12"><?php echo get_phrase('account_number'); ?> <b style="color:red">*</b></label>

                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="account_number" value="<?php echo $hrm['account_number'];?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12"><?php echo get_phrase('bank_name'); ?> <b style="color:red">*</b></label>

                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="bank_name" value="<?php echo $hrm['bank_name'];?>" required>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12"><?php echo get_phrase('branch'); ?> <b style="color:red">*</b></label>

                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="branch" value="<?php echo $hrm['branch'];?>" >
                        </div> 
                    </div>
		
					
					 <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Facebook');?></label>
                    <div class="col-sm-12">

                            <input type="text" name="facebook" value="<?php echo $hrm['facebook'];?>" class="form-control" >
                        </div>
                    </div>
					
					 <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Facebook');?></label>
                    <div class="col-sm-12">

                            <input type="text" name="facebook" value="<?php echo $hrm['facebook'];?>" class="form-control" >
                        </div>
                    </div>
					
					 <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Facebook');?></label>
                    <div class="col-sm-12">

                            <input type="text" name="facebook" value="<?php echo $hrm['facebook'];?>" class="form-control" >
                        </div>
                    </div>


                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Facebook');?></label>
                    <div class="col-sm-12">

                            <input type="text" name="facebook" value="<?php echo $hrm['facebook'];?>" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Twitter');?></label>
                    <div class="col-sm-12">

                            <input type="text" name="twitter" value="<?php echo $hrm['twitter'];?>" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Googleple');?></label>
                    <div class="col-sm-12">

                            <input type="text" name="googleplus" value="<?php echo $hrm['googleplus'];?>" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Linkedin');?></label>
                    <div class="col-sm-12">

                            <input type="text" name="linkedin" value="<?php echo $hrm['linkedin'];?>" class="form-control" >
                        </div>
                    </div>


    

                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase ('Image');?></label>
                    <div class="col-sm-12">

                            <input type="file" name="userfile" class="form-control">
                            <img src="<?php echo  $this->crud_model->get_image_url('hrm', $hrm['hrm_id']) ;?>" width="30" height="30">
                        </div>
                    </div>


                    <div class="form-group">
							<button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><i class="fa fa-plus"></i>&nbsp;&nbsp;Save</button>
					</div>
			<?php echo form_close();?>
            </div>
		</div>
    </div>
</div>

<?php endforeach;?>


<script type="text/javascript">
    
    function get_designation_val(department_id) {
        if(department_id != '')
            $.ajax({
                url: '<?php echo base_url();?>admin/get_designation/' + department_id,
                success: function(response)
                {
                    console.log(response);
                    jQuery('#designation_holder_modal').html(response);
                }
            });
        else
            jQuery('#designation_holder_modal').html('<option value=""><?php echo get_phrase("select_a_department_first"); ?></option>');
    }
    
</script>

		<script>
			$(document).ready(function() {
				var department_id = $('#department_id').val();
				var hrm_id = '<?php echo $param2;?>';
				get_designation_val(department_id,hrm_id);
				
			});
		</script>