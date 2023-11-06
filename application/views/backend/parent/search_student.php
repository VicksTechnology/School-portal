


<?php 
$this->db->select_sum('due');
$this->db->from('invoice');
$this->db->where('student_id', $student_id);
$query = $this->db->get();
$due_amount = $query->row()->due;
?>






<style>
    .exam_chart {
    width           : 100%;
        height      : 265px;
        font-size   : 11px;
}
.amcharts-chart-div a{
    display:none !important;
}
  
</style>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-heading"> <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo get_phrase('student_marks');?></div>
				<div class="panel-body table-responsive">
					
					<?php echo form_open(base_url() . 'parents/search_student');?>

					                       
						<div class="form-group">
                 			<label class="col-md-12" for="example-text"><?php echo get_phrase('select_your_child');?></label>
                    			<div class="col-sm-12">
									<select name="student_id" class="form-control select2" required>
									  <option value=""><?php echo get_phrase('select_your_child');?></option>
											 <?php
													$children_of_parent = $this->db->get_where('student', 
													array('parent_id' => $this->session->userdata('parent_id')))->result_array();
													foreach ($children_of_parent as $row):
											  ?>
											  
										<option value="<?php echo $row['student_id'];?>"<?php if($row['student_id'] == $student_id) echo 'selected="selected"';?>><?php echo $row['name'];?></option>
										   
										   <?php endforeach; ?>
								  </select>
                        	</div>
                    	</div> 

						<input type="hidden" name="operation" value="selection">

						<button type="submit" class="btn btn-info btn-sm btn-rounded btn-block"><i class="fa fa-search"></i>&nbsp;<?php echo get_phrase('get_results');?></button>
						<hr>
					<?php echo form_close();?>


					<?php
						$student_name = $this->db->get_where('student', array('student_id' => $student_id))->result_array();
						foreach ($student_name as $row):
					?>
	

			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading" align="center">
						<img src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']); ?>" class="img-circle" width="100" height="100"/>
						<h2><strong><?php echo $row ['name'];?></strong></h2>
					</div>
			
				</div>
			</div>


<?php endforeach; ?>



<?php if($due_amount == 0) : ?>

<?php if ($student_id != ''):?>

<?php 
	$parent_id = $this->session->userdata('parent_id');
    $student_info  = $this->db->get_where('student' , array('parent_id' => $parent_id, 'student_id' => $student_id))->result_array();
    $exams         = $this->crud_model->get_exams();
    foreach ($student_info as $row1):
    foreach ($exams as $row2):
?>
  <hr>
			
             <div class="panel-heading"> <i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $row2['name'];?></div>
                          
           
							<?php if($report_template == 1) : ?>
						   
								   <table class="table table-bordered">
									   <thead>
										<tr>
											<td style="text-align: center;">SUBJECT</td>
											<td style="text-align: center;">1ST SCORE</td>
											<td style="text-align: center;">2ND SCORE</td>
											<td style="text-align: center;">3RD SCORE</td>
											<td style="text-align: center;">EXAM SCORE</td>
											<td style="text-align: center;">TOTAL SCORE</td>
											<td style="text-align: center;">AVERAGE</td>
											<td style="text-align: center;">COMMENT</td>
										</tr>
									</thead>
									<tbody>
										<?php 
											$total_marks = 0;
											$total_grade_point = 0;
											$subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
											foreach ($subjects as $row3):
										?>
										<tr>
											<td style="text-align: center;"><?php echo $row3['name'];?></td>
											<td style="text-align: center;">
											
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score1'];												
														echo $obtained_class_score;
														}
													}
												?>
											
											</td>
											<td style="text-align: center;">
											
											
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
															
															$obtained_class_score2 = $row4['class_score2'];												
														echo $obtained_class_score2;
															
														}
													}
												?>
											
											
											</td>
											<td style="text-align: center;">
											
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
														$obtained_class_score3 = $row4['class_score3'];												
														echo $obtained_class_score3;
															
														}
													}
												?>
											
											</td>
											<td style="text-align: center;">
											
											<?php
													$exam_score_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $exam_score_query->num_rows() > 0) {
														$marks = $exam_score_query->result_array();
														foreach ($marks as $row4) {
														
														$obtained_exam_score = $row4['exam_score'];												
														echo $obtained_exam_score;
															
														}
													}
												?>
											
											
											</td>
										   
											<td style="text-align: center;">
									  <?php echo ($obtained_class_score + $obtained_class_score2 + $obtained_class_score3 + $obtained_exam_score);?>
											</td>
											<td style="text-align: center;">
												
												<?php 
										$a = $obtained_class_score;
										$b = $obtained_class_score2;
										$c = $obtained_class_score3;
										$d = $obtained_exam_score;
										
										$sum = $a + $b + $c + $d;
										$average = $sum/4;
										
										echo $average; 
										?>
											</td>
											<td style="text-align: center;"><?php echo $row4['comment'];?></td>
										</tr>
									<?php endforeach;?>
								</tbody>
							   </table>
					
					<?php endif;?> 
					
					<?php if($report_template == 2) : ?>
					
    					<table cellpadding="0" cellspacing="0" border="0" class="table">
								<thead>
									<tr>
										<td><?php echo get_phrase('subject');?></td>
										<td><?php echo get_phrase('continous_assessment');?></td>
										<td><?php echo get_phrase('exam score');?></td>
                                        <td><?php echo get_phrase('total_score');?></td>
										<td><?php echo get_phrase('comment');?></td>
									</tr>
								</thead>
                    				<tbody>

										<?php $subjects  =   $this->crud_model->get_subjects_by_class($class_id);
											foreach ($subjects as $key => $class_subject_exam_student): 
								
										   ?>
										   
										<tr>
										
                                        <?php 
										$obtained_mark_query = $this->db->get_where('mark', 
											array('class_id' => $class_id, 'subject_id' => $class_subject_exam_student['subject_id'], 
											'student_id' => $student_id));
                                        
										if($obtained_mark_query->num_rows() > 0){

                                            $class_score_one    = $obtained_mark_query->row()->class_score1;
                                            $exam_score         = $obtained_mark_query->row()->exam_score;
                                            $total_score        = $class_score_one + $exam_score;
											$comment         	= $obtained_mark_query->row()->comment;
                                        } 
                                        ?>
											<td><?php echo $class_subject_exam_student['name'];?></td>
											<td><?php echo $class_score_one;?></td>
											<td><?php echo $exam_score;?></td>
											<td><?php echo $total_score;?></td>
											<td><?php echo $comment;?></td>
										</tr>

								<?php endforeach;?>                 	
                    	</tbody>
               	</table>
					
					<?php endif;?> 
					
					
							<?php if($report_template == 'udemy') : ?>
						   
								   <table class="table table-bordered">
									   <thead>
										<tr>
											<td style="text-align: center;">SUBJECT</td>
											<td style="text-align: center;">1ST SCORE</td>
											<td style="text-align: center;">2ND SCORE</td>
											<td style="text-align: center;">EXAM SCORE</td>
											<td style="text-align: center;">TOTAL SCORE</td>
											<td style="text-align: center;">AVERAGE</td>
											<td style="text-align: center;">COMMENT</td>
										</tr>
									</thead>
									<tbody>
										<?php 
											$total_marks = 0;
											$total_grade_point = 0;
											$subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
											foreach ($subjects as $row3):
										?>
										<tr>
											<td style="text-align: center;"><?php echo $row3['name'];?></td>
											<td style="text-align: center;">
											
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score1'];												
														echo $obtained_class_score;
														}
													}
												?>
											
											</td>
											<td style="text-align: center;">
											
											
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
															
															$obtained_class_score2 = $row4['class_score2'];												
														echo $obtained_class_score2;
															
														}
													}
												?>
											
											
											</td>
											
											<td style="text-align: center;">
											
											<?php
													$exam_score_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $exam_score_query->num_rows() > 0) {
														$marks = $exam_score_query->result_array();
														foreach ($marks as $row4) {
														
														$obtained_exam_score = $row4['exam_score'];												
														echo $obtained_exam_score;
															
														}
													}
												?>
											
											
											</td>
										   
											<td style="text-align: center;">
									  <?php echo ($obtained_class_score + $obtained_class_score2 + $obtained_class_score3 + $obtained_exam_score);?>
											</td>
											<td style="text-align: center;">
												
												<?php 
													$a = $obtained_class_score;
													$b = $obtained_class_score2;
													$c = $obtained_class_score3;
													$d = $obtained_exam_score;
													
													$sum = $a + $b + $c + $d;
													$average = $sum/4;
													
													echo $average; 
												?>
											</td>
											<td style="text-align: center;"><?php echo $row4['comment'];?></td>
										</tr>
									<?php endforeach;?>
								</tbody>
							   </table>
					
					<?php endif;?> 
					
					
					
					
					<?php if($report_template == 'diamond') : ?>
					
						
						
    					<table cellpadding="0" cellspacing="0" border="1" class="table">
								<thead>
									<tr bordercolordark="#000000; 1px solid">
										<td>&nbsp;</td>
										<td colspan="5"><div align="center"><strong>CA1</strong></div></td>
										<td colspan="7"><div align="center"><strong>CA2 AND EXAM </strong></div></td>
									</tr>
									<tr>
										<td>SUBJECT</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Class Works (2 Marks)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Home Work (1 Mark)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Classnote (1 Mark)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Project (1 Mark)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Test1 (15 Marks)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">CA1 Comment</td>
										
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Class Work (2 Marks)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Home Work (1 Mark)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Classnote (1 Mark)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Project (1 Mark)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Test2 (15 Marks)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">CA2 Comment</td>
										
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Exam Score (60 Marks)</td>
										<td style="writing-mode:vertical-lr;transform:rotate(180deg)">Exam Comment</td>
									</tr>
								</thead>
                    				<tbody>
									
										<?php 
											$total_marks = 0;
											$total_grade_point = 0;
											$subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
											foreach ($subjects as $row3):
										?>

										
										<tr>
											<td><?php echo $row3['name'];?></td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score1'];												
														echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score2'];												
															echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score3'];												
															echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score4'];												
															echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score5'];												
															echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['ca1_comment'];												
															echo $obtained_class_score;
														}
													}
												?>
											
											</td>
											
											
											
											
											
											
											
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score11'];												
														echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score22'];												
															echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score33'];												
															echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score44'];												
															echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['class_score55'];												
															echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['ca2_comment'];												
															echo $obtained_class_score;
														}
													}
												?>
											
											</td>
											
											<td align="right">
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['exam_score'];												
															echo $obtained_class_score;
														}
													}
												?>
											</td>
											<td align="right">
											
											<?php
													$obtained_mark_query = $this->db->get_where('mark' , array(
																'subject_id' => $row3['subject_id'],
																	'exam_id' => $row2['exam_id'],
																		'class_id' => $class_id,
																			'student_id' => $student_id));
													if ( $obtained_mark_query->num_rows() > 0) {
														$marks = $obtained_mark_query->result_array();
														foreach ($marks as $row4) {
														
															$obtained_class_score = $row4['comment'];												
															echo $obtained_class_score;
														}
													}
												?>
											
											</td>
										</tr>

								<?php endforeach;?>                 	
                    	</tbody>
               	</table>
						
						
						
						
					<?php endif;?> 
					
					
					
                  
                    <a href="<?php echo base_url();?>parents/printResultSheet/<?php echo $student_id;?>/<?php echo $row2['exam_id'];?>" 
                        class="btn btn-info btn-rounded btn-sm pull-right" style="color:white">
                        <i class="entypo-print"></i>&nbsp;<?php echo get_phrase('print_report_card');?>
                    </a>

                   <div id="chartdiv<?php echo $row2['exam_id'];?>" class="exam_chart"></div>
                       <script type="text/javascript">
                            var chart<?php echo $row2['exam_id'];?> = AmCharts.makeChart("chartdiv<?php echo $row2['exam_id'];?>", {
                                "theme": "light",
                                "type": "serial",
                                "dataProvider": [
                                        <?php 
                                            foreach ($subjects as $subject) :
                                        ?>
                                        {
                                             "subject": "<?php echo substr($subject['name'], 0, 3);?>",
                                            "mark_obtained": 
                                            <?php
                                            $obtained_mark = $this->crud_model->get_obtained_marks( $row2['exam_id'] , $class_id , $subject['subject_id'] , $row1['student_id']);
                                                echo $obtained_exam_score;
                                            ?>,
                                            "mark_highest": 
                                            <?php
                                                $highest_mark = $this->crud_model->get_highest_marks( $row2['exam_id'] , $class_id , $subject['subject_id'] );
                                                echo $highest_mark;
                                            ?>
                                        },
                                        <?php 
                                            endforeach;

                                        ?>
                                    
                                ],
                                "valueAxes": [{
                                    "stackType": "3d",
                                    "unit": "%",
                                    "position": "left",
                                    "title": "Mark Score Vs Highest Mark"
                                }],
                                "startDuration": 1,
                                "graphs": [{
                                    "balloonText": "Mark Score In [[category]]: <b>[[value]]</b>",
                                    "fillAlphas": 0.9,
                                    "lineAlpha": 0.2,
                                    "title": "2004",
                                    "type": "column",
                                    "fillColors":"orange",
                                    "valueField": "mark_obtained"
                                }, {
                                    "balloonText": "Highest Mark In [[category]]: <b>[[value]]</b>",
                                    "fillAlphas": 0.9,
                                    "lineAlpha": 0.2,
                                    "title": "2005",
                                    "type": "column",
                                    "fillColors":"#72c02c",
                                    "valueField": "mark_highest"
                                }],
                                "plotAreaFillAlphas": 0.1,
                                "depth3D": 20,
                                "angle": 45,
                                "categoryField": "subject",
                                "categoryAxis": {
                                    "gridPosition": "start"
                                },
                                "exportConfig":{
                                    "menuTop":"20px",
                                    "menuRight":"20px",
                                    "menuItems": [{
                                        "format": 'png'   
                                    }]  
                                }
                            });
                    </script>
              
 
		<?php endforeach; endforeach;?>
		<?php endif;?>

<?php endif;?>

		
			
			</div>
		</div>
	</div>
</div>
<?php if($due_amount > 0) : ?>


			<div class="row">
                    <div class="col-sm-12">
				  	<div class="panel panel-danger">
                            <div class="panel-heading"> <i class="fa fa-times"></i>&nbsp;NOTIFICATION</div>
                                <div class="panel-body table-responsive">
								
								<h2 align="center">DEAR PARENT, YOUR CHILD <strong><?=$this->db->get_where('student' , array('student_id' => $student_id))->row()->name;?></strong> YOU HAVE PENDING INVOICE(S). PLEASE PAY ALL YOUR PENDING INVOICE(S) TO VIEW AND PRINT YOUR REPORT CARD</h2>
								
								
								</div>
							</div>
						</div>
					</div>
				

<?php endif;?>
