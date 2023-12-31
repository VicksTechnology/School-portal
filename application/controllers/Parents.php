<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Parents extends CI_Controller { 

    function __construct() {
        parent::__construct();
        		$this->load->database();                                //Load Databse Class
                $this->load->library('session');					    //Load library for session
  
    }

     /*parent dashboard code to redirect to parent page if successfull login** */
     function dashboard() {
        if ($this->session->userdata('parent_login') != 1) redirect(base_url(), 'refresh');
       	$page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('parent Dashboard');
        $this->load->view('backend/index', $page_data);
    }
	/******************* / parent dashboard code to redirect to parent page if successfull login** */

    function manage_profile($param1 = null, $param2 = null, $param3 = null){
        if ($this->session->userdata('parent_login') != 1) redirect(base_url(), 'refresh');
        if ($param1 == 'update') {
    
    
            $data['name']   =   $this->input->post('name');
            $data['email']  =   $this->input->post('email');
    
            $this->db->where('parent_id', $this->session->userdata('parent_id'));
            $this->db->update('parent', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/parent_image/' . $this->session->userdata('parent_id') . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('Info Updated'));
            redirect(base_url() . 'parents/manage_profile', 'refresh');
        }
    
        if ($param1 == 'change_password') {
            $data['new_password']           =   sha1($this->input->post('new_password'));
            $data['confirm_new_password']   =   sha1($this->input->post('confirm_new_password'));
    
            if ($data['new_password'] == $data['confirm_new_password']) {
               
               $this->db->where('parent_id', $this->session->userdata('parent_id'));
               $this->db->update('parent', array('password' => $data['new_password']));
               $this->session->set_flashdata('flash_message', get_phrase('Password Changed'));
            }
    
            else{
                $this->session->set_flashdata('error_message', get_phrase('Type the same password'));
            }
            redirect(base_url() . 'parents/manage_profile', 'refresh');
        }
    
            $page_data['page_name']     = 'manage_profile';
            $page_data['page_title']    = get_phrase('Manage Profile');
            $page_data['edit_profile']  = $this->db->get_where('parent', array('parent_id' => $this->session->userdata('parent_id')))->result_array();
            $this->load->view('backend/index', $page_data);
        }


        function subject (){

            $parent_profile = $this->db->get_where('student', array('parent_id' => $this->session->userdata('parent_id')))->row();
            $select_student_class_id = $parent_profile->class_id;

            $page_data['page_name']     = 'subject';
            $page_data['page_title']    = get_phrase('Class Subjects');
            $page_data['select_subject']  = $this->db->get_where('subject', array('class_id' => $select_student_class_id))->result_array();
            $this->load->view('backend/index', $page_data);
        }

        function teacher (){


            $parent_profile = $this->db->get_where('student', array('parent_id' => $this->session->userdata('parent_id')))->row();
            $select_student_class_id = $parent_profile->class_id;

            $return_teacher_id = $this->db->get_where('subject', array('class_id' => $select_student_class_id))->row()->teacher_id;


            $page_data['page_name']     = 'teacher';
            $page_data['page_title']    = get_phrase('Class Teachers');
            $page_data['select_teacher']  = $this->db->get_where('teacher', array('teacher_id' => $return_teacher_id))->result_array();
            $this->load->view('backend/index', $page_data);
        }

        function class_mate (){

            $parent_student_profile = $this->db->get_where('student', array('parent_id' => $this->session->userdata('parent_id')))->row();
            $page_data['select_student_parent_class_mate']  = $parent_student_profile->class_id;
            $page_data['page_name']     = 'class_mate';
            $page_data['page_title']    = get_phrase('Class Mate');
            $this->load->view('backend/index', $page_data);
        }

        function class_routine(){

            $parent_profile = $this->db->get_where('student', array('parent_id' => $this->session->userdata('parent_id')))->row();
            $page_data['class_id']  = $parent_profile->class_id;

            $page_data['page_name']     = 'class_routine';
            $page_data['page_title']    = get_phrase('Class Timetable');
            $this->load->view('backend/index', $page_data);


        }

        function invoice($param1 = null, $param2 = null, $param3 = null){

            if($param1 == 'make_payment'){

                $invoice_id = $this->input->post('invoice_id');
                $payment_email = $this->db->get_where('settings', array('type' => 'paypal_email'))->row();
                $select_invoice = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row();
                $this->session->set_userdata('inv_id', $invoice_id);

                // SENDING USER TO PAYPAL TERMINAL.
                $this->paypal->add_field('rm', 2);
                $this->paypal->add_field('no_note', 0);
                $this->paypal->add_field('item_name', $select_invoice->title);
                $this->paypal->add_field('amount', $select_invoice->due);
                $this->paypal->add_field('custom', $select_invoice->invoice_id);
                $this->paypal->add_field('business', $payment_email->description);
                $this->paypal->add_field('notify_url', base_url('parents/paypal_ipn'));
                $this->paypal->add_field('cancel_return', base_url('parents/paypal_cancel'));
                $this->paypal->add_field('return', site_url('parents/paypal_success'));

                $this->paypal->submit_paypal_post();
                //submitting info to the paypal teminal
            }


            $parent_profile = $this->db->get_where('student', array('parent_id' => $this->session->userdata('parent_id')))->row();
            $student_profile = $parent_profile->student_id;

            $page_data['invoices']     = $this->db->get_where('invoice', array('student_id' => $student_profile))->result_array();
            $page_data['page_name']     = 'invoice';
            $page_data['page_title']    = get_phrase('All Invoices');
            $this->load->view('backend/index', $page_data);
        }


        function paypal_ipn(){
            $invoice_id = $this->session->userdata('inv_id');
            if($this->paypal->validate_ipn() == true){
                    $ipn_response = '';
                    foreach ($_POST as $key => $value){
                        $value = urlencode(stripslashes($value));
                        $ipn_response .= "\n$key=$value";
                    }

                $this->payment_model->pay($invoice_id);

                $data2['method']       =   '1';
                $data2['year']         =   get_settings('session');
                $data2['invoice_id']   =   $invoice_id;
                $data2['timestamp']    =   strtotime(date("m/d/Y"));
                $data2['payment_type'] =   'income';
                $data2['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $invoice_id))->row()->title;
                $data2['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $invoice_id))->row()->description;
                $data2['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $invoice_id))->row()->student_id;
                $data2['amount']       =   $this->db->get_where('invoice' , array('invoice_id' => $invoice_id))->row()->amount;
                $this->db->insert('payment' , $data2);

            }
        }

        function paypal_cancel(){
            $this->session->set_flashdata('error_message', get_phrase('Payment Cancelled'));
            redirect(base_url() . 'student/invoice', 'refresh');
        }
        
        function paypal_success(){
            $this->session->set_flashdata('flash_message', get_phrase('Payment Successful'));
            redirect(base_url() . 'student/invoice', 'refresh');
        }


        function payment_history(){

            $parent_profile = $this->db->get_where('student', array('parent_id' => $this->session->userdata('parent_id')))->row();
            $parent_student_profile = $parent_profile->student_id;

            $page_data['invoices']     = $this->db->get_where('invoice', array('student_id' => $parent_student_profile))->result_array();
            $page_data['page_name']     = 'payment_history';
            $page_data['page_title']    = get_phrase('parent History');
            $this->load->view('backend/index', $page_data);
        }

        function submit_testimony($param1 = null, $param2 = null, $param3 = null){

            if($param1 == 'save'){

                $page_data['parent_id'] =    $this->db->get_where('parent', array('parent_id' => $this->session->userdata('parent_id')))->row()->parent_id;
                $page_data['content']   =    html_escape($this->input->post('content'));
                $page_data['status']   =    'Pending';
                $this->db->insert('testimony_table', $page_data);
                $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
                redirect(base_url() . 'parents/submit_testimony', 'refresh');
            }


            $page_data['page_name']     = 'submit_testimony';
            $page_data['page_title']    = get_phrase('Submit Testimony');
            $this->load->view('backend/index', $page_data);

        }
		
		/********** this function load student *******************/
    function search_student($student_id = '', $param2 = '', $sparam3 = '')
    {
		if ($this->session->userdata('parent_login') != 1)
		redirect('login', 'refresh');
			
		if ($this->input->post('operation') == 'selection') 
		{
		$page_data['student_id'] = $this->input->post('student_id');
		if ($page_data['student_id'] > 0 ) 
		{
		redirect(base_url() . 'parents/search_student/' . $page_data['student_id'], 'refresh');
		} 
		else 
		{
		$this->session->set_flashdata('info', 'please_student_name');
		redirect(base_url() . 'parents/search_student/', 'refresh');
		}
		}
		$class_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->class_id;	// this code load student specific class ID
		$student_name = $this->db->get_where('student', array('student_id' => $student_id))->row()->name;	// this code load student specific name of the above class
		$class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;    		// this code load class name
		
		$page_data['student_id'] = $student_id;				//student ID
		$page_data['class_id'] = $class_id;					//class ID
	
		$page_data['page_name'] = 'search_student';
		$page_data['page_title'] = get_phrase('search_students');
		$this->load->view('backend/index', $page_data);
	}
	/********** this function load student *******************/
	
	/********************* Print and view tabulation sheet **********************/
		function printResultSheet($student_id , $exam_id)
		{
		 if ($this->session->userdata('parent_login') != 1)
		 redirect(base_url(), 'refresh');
		 
		 
		 $class_id     = $this->db->get_where('student' , array('student_id' => $student_id))->row()->class_id;
		 $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
		
		$page_data['student_id'] =   $student_id;
		$page_data['class_id']   =   $class_id;
		$page_data['exam_id']    =   $exam_id;
		$page_data['page_name']  = 'printResultSheet';
		$page_data['page_title'] = get_phrase('print_result_sheet');
		$this->load->view('backend/index', $page_data);
		}
		/********************* Print and view tabulation sheet ends here **********************/
		
		
		
		// client success_payment_return
   	 	function vouguepay_success($invoice_id){
				
			$data['status'] = '2';
			$data['amount_paid'] = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->due;
            $this->db->where('invoice_id', $invoice_id);
            $this->db->set('amount_paid', 'amount_paid + ' . $data['amount_paid'], FALSE);
			$this->db->set('status', $data['status'], FALSE);
            $this->db->set('due', 'due - ' . $data['amount_paid'], FALSE);
            $this->db->update('invoice');
			
			
			
			 $data2['method']       =   'card';
             $data2['invoice_id']   =   $invoice_id;
             $data2['timestamp']    =   strtotime(date("m/d/Y"));
             $data2['payment_type'] =   'income';
             $data2['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $invoice_id))->row()->title;
             $data2['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $invoice_id))->row()->description;
             $data2['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $invoice_id))->row()->student_id;
             $data2['amount']       =   $data['amount_paid'];
			 $data2['year']       	=   $this->db->get_where('settings' , array('type' => 'session'))->row()->description;
             $this->db->insert('payment' , $data2);
			
			$this->session->set_flashdata('flash_message', get_phrase('payment_successful'));
            redirect(base_url() . 'parents/invoice/', 'refresh');
    	}
		
		



}