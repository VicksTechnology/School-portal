<div class="row">			
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-heading"> <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo get_phrase('list_paylist'); ?></div
				><div class="panel-body table-responsive">
								
					<table class="table table-bordered">
						<thead>
							<tr>
								<th><div>#</div></th>
								<th><div>ID</div></th>
								<th><div><?php echo get_phrase('employee'); ?></div></th>
								<th><div><?php echo get_phrase('summary'); ?></div></th>
								<th><div><?php echo get_phrase('date'); ?></div></th>
								<th><div><?php echo get_phrase('status'); ?></div></th>
								<th><div><?php echo get_phrase('options'); ?></div></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$count = 1;
								$login_user_id = $this->session->userdata('login_type').'-'.$this->session->userdata('login_user_id');
								$this->db->order_by('payroll_id', 'desc');
								$payroll = $this->db->get_where('payroll', array('user_id' => $login_user_id))->result_array();
									
								foreach($payroll as $row): 
								$user = explode('-', $row['user_id']);
								$user_type  = $user[0];
								$user_id = $user[1];
								$user = $this->db->get_where($user_type, array($user_type . '_id' => $user_id))->row();
								?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $row['payroll_code']; ?></td>
									<td>
										<?php echo $this->db->get_where($user_type, array($user_type . '_id' => $user_id))->row()->name;?>
									</td>
									<td>
										<?php
										$total_allowance    = 0;
										$total_deduction    = 0;
										$allowances         = json_decode($row['allowances']);
										$deductions         = json_decode($row['deductions']);
										
										foreach($allowances as $allowance)
											$total_allowance += $allowance->amount;
										foreach($deductions as $deduction)
											$total_deduction += $deduction->amount;
										
										$net_salary = $user->joining_salary + $total_allowance - $total_deduction;
										?>
										<div>
											<table style="width: 100%;">
												<tr>
													<td style="text-align: right;"><?php echo get_phrase('basic_salary'); ?></td>
													<td style="width: 15%; text-align: right;"> : </td>
													<td style="text-align: right;"><?php echo $user->joining_salary; ?></td>
												</tr>
												<tr>
													<td style="text-align: right;"><?php echo get_phrase('total_allowance'); ?></td>
													<td style="width: 15%; text-align: right;"> : </td>
													<td style="text-align: right;"><?php echo $total_allowance; ?></td>
												</tr>
												<tr>
													<td style="text-align: right;"><?php echo get_phrase('total_deduction'); ?></td>
													<td style="width: 15%; text-align: right;"> : </td>
													<td style="text-align: right;"><?php echo $total_deduction; ?></td>
												</tr>
												<tr>
													<td colspan="3"><hr style="margin: 5px 0px;"></td>
												</tr>
												<tr>
													<td style="text-align: right;"><?php echo get_phrase('net_salary'); ?></td>
													<td style="width: 15%; text-align: right;"> : </td>
													<td style="text-align: right;"><?php echo $net_salary; ?></td>
												</tr>
											</table>
										</div>
									</td>
									<td>
										<?php
										$date = explode(',', $row['date']);
										$month_list = array('january', 'february', 'march', 'april', 'may', 'june', 'july',
											'august', 'september', 'october', 'november', 'december');
										for($i = 1; $i <= 12; $i++)
											if($i == $date[0])
												$month = get_phrase($month_list[$i-1]);
										echo $month . ', ' . $date[1];
										?>
									</td>
									<td>
										<?php
										if($row['status'] == 1)
											echo '<div class="label label-success">' . get_phrase('paid').'</div>';
										else
											echo '<div class="label label-danger">' . get_phrase('unpaid').'</div>';
										?>
									</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-info btn-rounded btn-sm dropdown-toggle" data-toggle="dropdown">
												Action <span class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-default pull-right" role="menu">
					
												<li>
													<a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/payroll_details/<?php echo $row['payroll_id']; ?>');">
														<i class="fa fa-link"></i>
														<?php echo get_phrase('view_payslip_details'); ?>
													</a>
												</li>
												
											</ul>
										</div>
					
									</td>
								</tr>
						<?php endforeach; ?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
            <!----TABLE LISTING ENDS--->