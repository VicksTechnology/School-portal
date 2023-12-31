<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Teacher_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }


/**************************** The function below insert into bank and teacher tables   **************************** */
    function insetTeacherFunction (){

        /*$bank_data['account_holder_name'] = $this->input->post('account_holder_name');
        $bank_data['account_number'] = $this->input->post('account_number');
        $bank_data['bank_name'] = $this->input->post('bank_name');
        $bank_data['branch'] = $this->input->post('branch');
        $bank_data['school_id'] =   $this->session->userdata('school_id');
        $bank_data['session'] =   $this->db->get_where('settings', array('type' => 'session'))->row()->description;
        
		$sql = "select * from bank order by bank_id desc limit 1";
		$return_query = $this->db->query($sql)->row()->bank_id + 1;
		$bank_data['bank_id'] = $return_query;
		
        $this->db->insert('bank', $bank_data);
        $bank_id = $this->db->insert_id();

		*/
		
        $teacher_array = array(
            'name'                  => $this->input->post('name'),
            'role'                  => $this->input->post('role'),
			'teacher_number'        => $this->input->post('teacher_number'),
			'birthday'              => $this->input->post('birthday'),
        	'sex'                   => $this->input->post('sex'),
            'religion'              => $this->input->post('religion'),
            'blood_group'           => $this->input->post('blood_group'),
            'address'               => $this->input->post('address'),
			'phone'                 => $this->input->post('phone'),
			'facebook'              => $this->input->post('facebook'),
        	'twitter'               => $this->input->post('twitter'),
            'googleplus'            => $this->input->post('googleplus'),
            'linkedin'              => $this->input->post('linkedin'),
            'qualification'         => $this->input->post('qualification'),
			'marital_status'        => $this->input->post('marital_status'),
			'password'              => sha1($this->input->post('password')),
        	'department_id'         => $this->input->post('department_id'),
            'designation_id'        => $this->input->post('designation_id'),
            'date_of_joining'       => $this->input->post('date_of_joining'),
            'joining_salary'        => $this->input->post('joining_salary'),
			'status'                => $this->input->post('status'),
			'date_of_leaving'       => $this->input->post('date_of_leaving'),
			'account_holder_name'   => $this->input->post('account_holder_name'),
			'account_number'       => $this->input->post('account_number'),
			'bank_name'       => $this->input->post('bank_name'),
			'branch'       => $this->input->post('branch')
            );
			
			$email = $this->input->post('email');
			$password = $this->input->post('password');
        
            $teacher_array['file_name'] = $_FILES["file_name"]["name"];
            $teacher_array['email'] = $this->input->post('email');
            //$teacher_array['school_id'] =   $this->session->userdata('school_id');
            $teacher_array['session'] =   get_settings('session');
           // $teacher_array['bank_id'] = $bank_id;
			
			$sql = "select * from teacher order by teacher_id desc limit 1";
			$return_query = $this->db->query($sql)->row()->teacher_id + 1;
			$teacher_array['teacher_id'] = $return_query;
		
            $check_email = $this->db->get_where('teacher', array('email' => $teacher_array['email']))->row()->email;	// checking if email exists in database
            if($check_email != null) 
            {
            $this->session->set_flashdata('error_message', get_phrase('email_already_exist'));
            redirect(base_url() . 'admin/teacher/', 'refresh');
            }
            else
            {
            $this->db->insert('teacher', $teacher_array);
            $teacher_id = $this->db->insert_id();
            
                move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/teacher_image/" . $_FILES["file_name"]["name"]);	// upload files
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $teacher_id . '.jpg');			// image with user ID
				$this->email_model->account_opening_email('teacher', $email, $password); //Send email to student for registration acknoledgement
            }

    }


    function updateTeacherFunction($param2){
        
		/*
		$bank_data['account_holder_name'] = $this->input->post('account_holder_name');
        $bank_data['account_number'] = $this->input->post('account_number');
        $bank_data['bank_name'] = $this->input->post('bank_name');
        $bank_data['branch'] = $this->input->post('branch');
        $selcting_bank_id = $this->db->get_where('teacher', array('teacher_id' => $param2, 'school_id' => $this->session->userdata('school_id')))->row()->bank_id;
        $this->db->where('bank_id', $selcting_bank_id);
        $this->db->update('bank', $bank_data);
		*/

        $teacher_data = array(
            'name'                  => $this->input->post('name'),
            'role'                  => $this->input->post('role'),
			'birthday'              => $this->input->post('birthday'),
        	'sex'                   => $this->input->post('sex'),
            'religion'              => $this->input->post('religion'),
            'blood_group'           => $this->input->post('blood_group'),
            'address'               => $this->input->post('address'),
            'phone'                 => $this->input->post('phone'),
            'email'                 => $this->input->post('email'),
            'qualification'         => $this->input->post('qualification'),
            'marital_status'        => $this->input->post('marital_status'),
			'facebook'              => $this->input->post('facebook'),
        	'twitter'               => $this->input->post('twitter'),
            'googleplus'            => $this->input->post('googleplus'),
            'linkedin'              => $this->input->post('linkedin'),
            'department_id'         => $this->input->post('department_id'),
            'designation_id'        => $this->input->post('designation_id'),
            'date_of_joining'       => $this->input->post('date_of_joining'),
            'joining_salary'        => $this->input->post('joining_salary'),
			'status'                => $this->input->post('status'),
			'date_of_leaving'       => $this->input->post('date_of_leaving'),
			'account_holder_name'   => $this->input->post('account_holder_name'),
			'account_number'       => $this->input->post('account_number'),
			'bank_name'       => $this->input->post('bank_name'),
			'branch'       => $this->input->post('branch')
            );

            $this->db->where('teacher_id', $param2);
            $this->db->update('teacher', $teacher_data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $param2 . '.jpg'); 			// image with user ID
    }


    function deleteTeacherFunction($param2){

		$ImagePath = $this->db->get_where('teacher', array('teacher_id' => $param2))->row()->teacher_id;
		$FilePath = $this->db->get_where('teacher', array('teacher_id' => $param2))->row()->file_name;
          if (file_exists('uploads/teacher_image/'.$ImagePath.'.jpg')) {
            	unlink('uploads/teacher_image/'.$ImagePath.'.jpg');
          }
		  if (file_exists('uploads/teacher_image/'.$FilePath)) {
            	unlink('uploads/teacher_image/'.$FilePath);
          }
        $this->db->where('teacher_id', $param2);
        $this->db->delete('teacher');
    }
	


	
	
}
