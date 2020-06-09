<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Home_model'));
    }

	public function index()
	{
		if(!empty($this->session->userdata('users')))
		{
			header("Location: ".Base_path."dashboard");
		}
		else
		{
			$this->load->view('customers/login');
		}
	}

	public function login()
	{
		$userdata = ['user_email' => $_POST['emp_email'],'password' => $_POST['emp_password']];

		if($_POST['emp_email'] != '' && $_POST['emp_password'])
		{
			$user = $this->Home_model->check_login($userdata);

			$condition = ['rol_id' => $user['role']];
			$permission  = $this->Home_model->get_result(USER_DB.'.emp_roles',$condition,'single');
			if(count($user) != 0)
			{
				if($user['company_id'] == 0)
				{
					$users = ['user_id' => $user['user_id'],'username' => $user['user_name'],'email' => $user['user_email'],'role' => $user['role'],'permissions' => $permission['modules'],'company_id' => $user['user_id']];
				}
				else
				{
					$users = ['user_id' => $user['user_id'],'username' => $user['user_name'],'email' => $user['user_email'],'role' => $user['role'],'permissions' => $permission['modules'],'company_id' => $user['company_id']];
				}
				
				$this->session->set_userdata(['users' => $users]);
				header("Location: ".Base_path."dashboard"); 
			}
			else
			{
				header("Location: ".Base_path);
			}
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	function dashboard()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['is_delete' => 0];
			$log_condition = ['type' => 'enquiry_followup','is_delete' => 0];

			if($this->session->userdata('users')['role'] == 1)
			{
				$daily_visit_enquiry_condition = ['is_delete' => 0,'enquiry_type' => 'Direct Visit'];
				$phone_visit_enquiry_condition = ['is_delete' => 0,'enquiry_type' => 'Phone Call'];
				$enq_condition = ['is_delete' => 0];
			}
			else
			{
				$daily_visit_enquiry_condition = ['is_delete' => 0,'enquiry_type' => 'Direct Visit','employee_id' => $this->session->userdata('users')['user_id']];
				$phone_visit_enquiry_condition = ['is_delete' => 0,'enquiry_type' => 'Phone Call','employee_id' => $this->session->userdata('users')['user_id']];
				$enq_condition = ['is_delete' => 0,'employee_id' => $this->session->userdata('users')['user_id']];
			}
			
			
			$total_enquiry = $this->Home_model->get_result(USER_DB.'.customer_enquiry',$enq_condition);
			$daily_visit_enquiry = $this->Home_model->get_result(USER_DB.'.customer_enquiry',$daily_visit_enquiry_condition);
			$phone_visit_enquiry = $this->Home_model->get_result(USER_DB.'.customer_enquiry',$phone_visit_enquiry_condition);
			$services = $this->Home_model->get_result(USER_DB.'.services',$condition);
			$employee = $this->Home_model->get_result(MAIN_DB.'.employee_master',$condition);
			$customers = $this->Home_model->get_result(MAIN_DB.'.customer_master',$condition);
			$roles = $this->Home_model->get_result(USER_DB.'.emp_roles',$condition);
			$ser_condition = ['s.is_delete' => 0];
			$pend_ser_condition = ['s.is_delete' => 0,'is_paid' => '-1'];
			$full_pend_ser_condition = ['s.is_delete' => 0,'is_paid' => 0];
			
			$data['services_chart'] = $this->Home_model->get_services_chart(USER_DB.'.services as s',$ser_condition);
			$data['incomes_chart'] = $this->Home_model->get_incomes_chart(USER_DB.'.services as s',$ser_condition);
			$data['pending_services'] = $this->Home_model->get_services(USER_DB.'.services as s',$pend_ser_condition);
			$data['full_pending_services'] = $this->Home_model->get_services(USER_DB.'.services as s',$full_pend_ser_condition);
			$data['logs'] = $this->Home_model->get_result(MAIN_DB.'.log_activity',$log_condition);
			$data['total_enquiry_count'] = count($total_enquiry);
			$data['daily_visit_enquiry_count'] = count($daily_visit_enquiry);
			$data['phone_visit_enquiry_count'] = count($phone_visit_enquiry);
			$data['services_count'] = count($services);
			$data['employee_count'] = count($employee);
			$data['customer_count'] = count($customers);
			$data['roles_count'] = count($roles);
			$data['modules'] = $this->Home_model->get_result('emp_module');	
		
			$this->load->view('header',$data);
			$this->load->view('dashboard/dashboard',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
		
	}

	function roles()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['is_delete' => 0];
			$data['modules'] = $this->Home_model->get_result('emp_module');	
			$data['roles'] = $this->Home_model->get_result(USER_DB.'.emp_roles',$condition);
			$this->load->view('header',$data);
			$this->load->view('roles/roles',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	function add_roles()
	{
		if(!empty($this->session->userdata('users')))
		{
			
			$mod=array();
			foreach ($_POST['modules'] as $key => $value) 
			{
				array_push($mod,$value);	
			}
			$mod = implode(', ', $mod);


			if($_POST['role'] != 0)
			{
				if(!empty($mod))
				{
					$role_data = ['modules' => $mod];
					$condition = ['rol_id' => $_POST['role']];
					$user = $this->Home_model->update_roles(USER_DB.'.emp_roles',$role_data,$condition);
					echo 1;
				}
				else
				{
					echo 0;
				}
				
			}
			else
			{
				if($_POST['role_name'] != '') 
			    {
			    	$role_alias = $_POST['role_alias'];
					$condition = ['role_alias' => $role_alias];
			
			    	$roles = $this->Home_model->is_already_exist(USER_DB.'.emp_roles',$condition);
			    	if(count($roles) > 0)
					{
						echo 0;
					}
					else
					{
						if(!empty($mod))
						{
							$role_data = ['role_name' => $_POST['role_name'],'role_alias'=> $_POST['role_alias'],'modules' => $mod];
							$user = $this->Home_model->insert_record(USER_DB.'.emp_roles',$role_data);
							echo 1;
						}
						else
						{
							echo 0;
						}
					}
				    	
				}
			}
		}
		else
		{
			header("Location: ".Base_path);
		}
		
	}

	public function delete_role()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['rol_id' => $_POST['rol_id']];
			$role_data = ['is_delete' => 1];
			$role = $this->Home_model->update_record(USER_DB.'.emp_roles',$role_data,$condition);
			echo '1| <div class="text-success"><strong>Role Updated Success</strong></div>';
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function get_modules()
	{
		$modules = $this->Home_model->get_roles($_POST['role']);
		$mod = $modules['modules']; 
		$res = str_replace(", ", "|", $mod);
		echo '"'.$res.'"';
	}

	function employee()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['em.is_delete' => 0];
			$data['emplyees'] = $this->Home_model->get_employees($condition);
			$data['roles'] = $this->Home_model->get_result(USER_DB.'.emp_roles');
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$this->load->view('header',$data);
			$this->load->view('employee/employee',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	function employee_add($type = null, $id = null)
	{
		if(!empty($this->session->userdata('users')))
		{
			if($type == 'edit')
			{
				$condition = ['emp_id' => $id];
				$data['employee'] = $this->Home_model->get_result(MAIN_DB.'.employee_master',$condition,'single');
				$data['roles'] = $this->Home_model->get_result(USER_DB.'.emp_roles');	
				$data['modules'] = $this->Home_model->get_result('emp_module');
				$this->load->view('header',$data);
				$this->load->view('employee/employee_add',$data);
				$this->load->view('footer');
			}
			else
			{
				$data['roles'] = $this->Home_model->get_result(USER_DB.'.emp_roles');
				$data['modules'] = $this->Home_model->get_result('emp_module');	
				$this->load->view('header',$data);
				$this->load->view('employee/employee_add',$data);
				$this->load->view('footer');	
			}
		}
		else
		{
			header("Location: ".Base_path);
		}
		
	}

	public function employee_register($type = null)
	{
		if(!empty($this->session->userdata('users')))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('emp_name', 'Employee Name', 'required|alpha');
			$this->form_validation->set_rules('emp_email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('emp_mobile', 'Mobile No', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('emp_password', 'Password', 'trim|required|min_length[6]', array('required' => 'Please fill the field' . ' %s.', 'min_length' => 'Please enter password of minimum 6 characters.'));
			if ($this->form_validation->run() == FALSE) 
			{ 
		    	$message= '<div class="text-danger"><ul>';
				$message.= validation_errors();
				$message.= '</ul></div>';
				echo '0| ' .$message;
		     } 
		     else 
		     { 

		     	$employee_data = $_POST;
		     	if($type == 'update')
		     	{
		     		$condition = ['emp_id' => $employee_data['emp_id']];
					$employee = $this->Home_model->update_record(MAIN_DB.'.employee_master',$employee_data,$condition);
					if(isset($employee))
					{
						echo '1| <div class="text-success"><strong>Employee Updated Success</strong></div>';
					}
					else
					{
						echo '1| <div class="text-danger"><strong>Employee Updated Failed</strong></div>';
					}
		     	}
		     	else
		     	{
		     		$condition = ['emp_email' => $employee_data['emp_email'],'emp_alias' => $employee_data['emp_alias']];
					$employee_count = $this->Home_model->get_result(MAIN_DB.'.employee_master',$condition,'single');
					if(count($employee_count) > 0)
					{
						echo '2| <div class="text-danger"><strong>Employee Already Exists</strong></div>';	
					}
					else
					{

						$employee = $this->Home_model->insert_record(MAIN_DB.'.employee_master',$employee_data);
			     		
						$user_data = ['user_name' => $employee_data['emp_name'],'user_alias' => $employee_data['emp_alias'],'role' => $employee_data['emp_role_id'],'company_id' => $this->session->userdata('users')['company_id'],'user_email' => $employee_data['emp_email'],'password' => $employee_data['emp_password'],'user_mobile' => $employee_data['emp_mobile']];
	       
				        $user_id = $this->Home_model->insert_record(MAIN_DB.'.users',$user_data);

				        $users_data = ['user_id' => $user_id];
						$condition = ['emp_id' => $employee];
						$emp = $this->Home_model->update_roles(MAIN_DB.'.employee_master',$users_data,$condition);
						
						if(isset($employee))
						{
							echo '1| <div class="text-success"><strong>Employee Added Success</strong></div>';
						}
						else
						{
							echo '1| <div class="text-danger"><strong>Employee Added Failed</strong></div>';
						}
					}
		     		
		     	}
			}
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function delete_employee()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['emp_id' => $_POST['emp_id']];
			$employee_data = ['is_delete' => 1];
			$employee = $this->Home_model->update_record(MAIN_DB.'.employee_master',$employee_data,$condition);
			echo '1| <div class="text-success"><strong>Employee Updated Success</strong></div>';
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	function customers()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['is_delete' => 0];
			$data['customers'] = $this->Home_model->get_result(MAIN_DB.'.customer_master',$condition);
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$this->load->view('header',$data);
			$this->load->view('customers/customers',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	function customer_add($type=null,$id=null)
	{
		if(!empty($this->session->userdata('users')))
		{
			if($type == 'edit')
			{
				$condition = ['cust_id' => $id];
				$data['customers'] = $this->Home_model->get_result(MAIN_DB.'.customer_master',$condition,'single');
				$data['cities'] = $this->Home_model->get_result(MAIN_DB.'.cities');
				$data['modules'] = $this->Home_model->get_result('emp_module');
				$this->load->view('header',$data);
				$this->load->view('customers/customer_add',$data);
				$this->load->view('footer');
			}
			else
			{
				$data['cities'] = $this->Home_model->get_result(MAIN_DB.'.cities');
				$data['modules'] = $this->Home_model->get_result('emp_module');
				$this->load->view('header',$data);
				$this->load->view('customers/customer_add');
				$this->load->view('footer');
			}
		}
		else
		{
			header("Location: ".Base_path);
		}
		
	}

	public function customer_register($type = null)
	{
		if(!empty($this->session->userdata('users')))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cust_name', 'Customer Name', 'required');
			$this->form_validation->set_rules('cust_email', 'Customer Email', 'required|valid_email');
			$this->form_validation->set_rules('cust_mob_no', 'Customer Mobile No', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('cust_type', 'Customer Type', 'required');
			$this->form_validation->set_rules('city_id', 'City', 'required');
			$this->form_validation->set_rules('pincode', 'Customer Pincode', 'required');
			if($_POST['cust_type'] == 'Corporate')
			{
				$this->form_validation->set_rules('cust_land_mob_no', 'Customer Office Landline Mobile', 'required');
				$this->form_validation->set_rules('cust_office_email', 'Customer Office Email', 'required|valid_email');
			}
			if ($this->form_validation->run() == FALSE) { 
		    	 $message= '<div class="text-danger"><ul>';
					$message.= validation_errors();
					$message.= '</ul></div>';
					echo '0| ' .$message;
		     } 
		     else 
		     { 

				$customer_data = $_POST;

				if($type == 'update')
				{
					$condition = ['cust_id' => $customer_data['cust_id']];
					
					$cust_address = $customer_data['flat_no'].'|'.$customer_data['street'].'|'.$customer_data['city'].'|'.$customer_data['pincode'];

					$customer_data_details = ['cust_type' => $customer_data['cust_type'],'cust_name'=>$customer_data['cust_name'],'cust_mob_no'=>$customer_data['cust_mob_no'],'cust_whatsapp_mob_no'=>$customer_data['cust_whatsapp_mob_no'],'cust_land_mob_no'=>$customer_data['cust_land_mob_no'],'cust_email'=>$customer_data['cust_email'],'cust_office_email'=>$customer_data['cust_office_email'],'cust_address'=>$cust_address,'city_id'=>$customer_data['city_id']];
					
					$customer = $this->Home_model->update_record(MAIN_DB.'.customer_master',$customer_data_details,$condition);
					if(isset($customer))
					{
						echo '1| <div class="text-success"><strong>Customer Updated Success</strong></div>';
					}
					else
					{
						echo '1| <div class="text-danger"><strong>Customer Updated Failed</strong></div>';
					}

				}
				else
				{
					$condition = ['cust_mob_no' => $customer_data['cust_mob_no'],'cust_email' => $customer_data['cust_email']];
					$customer_count = $this->Home_model->get_result(MAIN_DB.'.customer_master',$condition,'single');
					if(count($customer_count) > 0)
					{
						echo '2| <div class="text-danger"><strong>Employee Already Exists</strong></div>';	
					}
					else
					{
						$cust_address = $customer_data['flat_no'].'|'.$customer_data['street'].'|'.$customer_data['city'].'|'.$customer_data['pincode'];
						$customer_data_details = ['cust_type' => $customer_data['cust_type'],'cust_name'=>$customer_data['cust_name'],'cust_mob_no'=>$customer_data['cust_mob_no'],'cust_whatsapp_mob_no'=>$customer_data['cust_whatsapp_mob_no'],'cust_land_mob_no'=>$customer_data['cust_land_mob_no'],'cust_email'=>$customer_data['cust_email'],'cust_office_email'=>$customer_data['cust_office_email'],'cust_address'=>$cust_address,'city_id'=>$customer_data['city_id']];
						$customer = $this->Home_model->insert_record(MAIN_DB.'.customer_master',$customer_data_details);
						if(isset($customer))
						{
							echo '1| <div class="text-success"><strong>Customer Added Success</strong></div>';
						}
						else
						{
							echo '1| <div class="text-danger"><strong>Customer Added Failed</strong></div>';
						}
					}
				}
				
			}
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function delete_customer()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['cust_id' => $_POST['cust_id']];
			$customer_data = ['is_delete' => 1];
			$customer = $this->Home_model->update_record(MAIN_DB.'.customer_master',$customer_data,$condition);
			echo '1| <div class="text-success"><strong>Customer Deleted Success</strong></div>';
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	function is_role_already_exist()
	{
		if(!empty($this->session->userdata('users')))
		{
			$role_alias = $_POST['role_alias'];
			$condition = ['role_alias' => $role_alias];
			$roles = $this->Home_model->is_already_exist(USER_DB.'.emp_roles',$condition);
			if(count($roles) > 0)
			{
				echo '1| <div class="text-danger"><strong>Role Already Exists</strong></div>';
			}
			else
			{
				echo '0|';
			}
		}
		else
		{
			header("Location: ".Base_path);
		}
		
	}

	function is_emp_already_exist()
	{
		if(!empty($this->session->userdata('users')))
		{
			$emp_alias = $_POST['emp_alias'];
			$condition = ['emp_alias' => $emp_alias];
			$emplyees = $this->Home_model->is_already_exist(MAIN_DB.'.employee_master',$condition);
			if(count($emplyees) > 0)
			{
				echo '1| <div class="text-danger"><strong>Employee Already Exists</strong></div>';
			}
			else
			{
				echo '0|';
			}
		}
		else
		{
			header("Location: ".Base_path);
		}
		
	}

	function customer_enquiry($type=null,$id=null)
	{
		if(!empty($this->session->userdata('users')))
		{
			if($type == 'cust' && $id != '')
			{
				$condition = ['cust_id' => $id];
				$data['customer_enquiry'] = $this->Home_model->get_result(USER_DB.'.customer_enquiry',$condition);
				$data['mobile'] = $data['customer_enquiry'][0]['cust_mobile_no'];
			}
			else if($type == 'emp' && $id != '')
			{
				$condition = ['employee_id' => $id];
				$data['customer_enquiry'] = $this->Home_model->get_result(USER_DB.'.customer_enquiry as ce',$condition);
			}
			else
			{
				if($this->session->userdata('users')['role'] == 1)
				{
					$condition = ['enquiry_status' => ''];
				}
				else
				{
					$condition = ['employee_id' => $this->session->userdata('users')['user_id']];
				}
				$data['customer_enquiry'] = $this->Home_model->get_result(USER_DB.'.customer_enquiry',$condition);
			}
			
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$this->load->view('header',$data);
			$this->load->view('customers/customer_enquiry',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function customer_enquiry_add($mob = null)
	{
		if(!empty($this->session->userdata('users')))
		{
			$data['customers'] = $this->Home_model->get_result(MAIN_DB.'.customer_master');
			$data['employees'] = $this->Home_model->get_result(MAIN_DB.'.employee_master');
			$data['modules'] = $this->Home_model->get_result('emp_module');
			if($mob != '')
			{
				$data['mobile'] = $mob;
			}
			$this->load->view('header',$data);
			$this->load->view('customers/customer_enquiry_add',$data);
			$this->load->view('footer');	
		}
		else
		{
			header("Location: ".Base_path);
		}
		
	}

	public function customer_enquiry_register()
	{
		if(!empty($this->session->userdata('users')))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cust_name', 'Customer Name', 'required');
			$this->form_validation->set_rules('cust_mobile_no', 'Mobile No', 'required');
			if ($this->form_validation->run() == FALSE) { 
		    	 $message= '<div class="text-danger"><ul>';
					$message.= validation_errors();
					$message.= '</ul></div>';
					echo '0| ' .$message;
		     } 
		     else 
		     { 
		        $enquiry_data = $_POST;
				$enquiry = $this->Home_model->insert_record(USER_DB.'.customer_enquiry',$enquiry_data);
				
				if(isset($enquiry))
				{
					echo '1| <div class="text-success"><strong>Enquiry Added Success</strong></div>';
				}
				else
				{
					echo '1| <div class="text-danger"><strong>Enquiry Added Failed</strong></div>';
				}
		     } 
		 }
		 else
		 {
		 	header("Location: ".Base_path);
		 }
		
	}

	function update_enquiry_customer_status()
	{
		$customer_data = $_POST;
		if($customer_data['cust_id'] == 0)
		{
			$enq_data = ['cust_name' => $customer_data['cust_name'],'cust_mob_no' => $customer_data['cust_mob_no'],'cust_email' => $customer_data['cust_email'],'cust_address' => '|||','cust_type' => 'Customer_Place'];
			$customer = $this->Home_model->insert_record(MAIN_DB.'.customer_master',$enq_data);

			$condition = ['ce_id' => $customer_data['ce_id']];
			$customer_datas = ['enquiry_status' => 'Contact','cust_id' => $customer];
			$customer = $this->Home_model->update_record(USER_DB.'.customer_enquiry',$customer_datas,$condition);
			$customer_enquiry = $this->Home_model->get_result(USER_DB.'.customer_enquiry',$condition,'single');
			echo '1|'.$customer_enquiry['cust_id'];
		}
		else
		{
			$condition = ['ce_id' => $customer_data['ce_id']];
			$customer_datas = ['enquiry_status' => 'Contact'];
			$customer = $this->Home_model->update_record(USER_DB.'.customer_enquiry',$customer_datas,$condition);
			$customer_enquiry = $this->Home_model->get_result(USER_DB.'.customer_enquiry',$condition,'single');
			echo '1|'.$customer_enquiry['cust_id'];

		}
		

		//echo '1| <div class="text-success"><strong>Service Response Added Success</strong></div>';
	}

	function assign_service_request()
	{
		$service_data = $_POST;
		$condition = ['sr_id' => $service_data['sr_id']];
		$services = ['status' => 'Assigned','emp_id' => $service_data['emp_id']];
		$customer = $this->Home_model->update_record(USER_DB.'.service_request',$services,$condition);
		
		$response_data = ['sr_id' => $service_data['sr_id']];
		$response = $this->Home_model->insert_record(USER_DB.'.service_response',$response_data);
		echo '1| <div class="text-success"><strong>Service Request Assigned Success</strong></div>';
	}

	
	function update_expected_date()
	{
		$enquiry_data = ['expected_date' => $_POST['new_expected_date']];
		$condition = ['ce_id' => $_POST['ce_id']];
		$enquiry = $this->Home_model->update_record(USER_DB.'.customer_enquiry',$enquiry_data,$condition);

		$log_desc = ucfirst($this->session->userdata('users')['username'])." was updated the followup date from ".$_POST['old_expected_date'].' to '.$_POST['new_expected_date'];

		$log_data = ['emp_id' => $this->session->userdata('users')['user_id'], 'type' => 'enquiry_followup','log' => $log_desc, 'log_desc' => $_POST['reason']];
		$response = $this->Home_model->insert_record(MAIN_DB.'.log_activity',$log_data);
		echo '1| <div class="text-success"><strong>Followup Date Updated Success</strong></div>';
	}

	function search_enquiry_result()
	{
		$condition = ['cust_mob_no' => $_POST['mob_no']];
		$enquiry = $this->Home_model->get_result(MAIN_DB.'.customer_master',$condition,'single');
	
		if(count($enquiry) > 0)
		{
			echo '1|'.$enquiry['cust_id'];
		}
		else
		{
			echo '0| <div class="text-success"><strong>Customer Not Exists</strong></div>';
		}
		
	}

	function profile($type=null,$id=null)
	{
		if($type == 'customer' && $id != '')
		{
			$condition = ["'s.shipper_id' => $id OR 's.consignee_id' => $id"];
			$where = '(s.shipper_id= '.$id.' or s.consignee_id = '.$id.')';
			
			$data['services'] = $this->Home_model->get_services(USER_DB.'.services as s',$where);
			
			$data['incomes'] = $this->Home_model->get_incomes($where);
			$data['expenses'] = $this->Home_model->get_expenses($where,$id);

			$income = $data['incomes'];
			$total_income = 0;
			for($i=0; $i < count($income); $i++)
			{
				$total_income += $income[$i]['income'];
			}

			$expense = $data['expenses'];
			$total_expense = 0;
			for($i=0; $i < count($expense); $i++)
			{
				$total_expense += $expense[$i]['amount'];
			}

			$data['total_incomes'] = $total_income;
			$data['total_expense'] = $total_expense;
			

			$customer_condition = ['cust_id' => $id];
			$customer_data = $this->Home_model->get_result(MAIN_DB.'.customer_master',$customer_condition,'single');
			$data['profile_name'] = $customer_data['cust_name'];
			$data['profile_mob_no'] = $customer_data['cust_mob_no'];
			$data['profile_address'] = $customer_data['cust_address'];
			
		}
		$data['modules'] = $this->Home_model->get_result('emp_module');
		

		$data['profile_type'] = $type;
		$data['profile_id'] = $id;
		
		
		$this->load->view('header',$data);
		$this->load->view('customers/profile',$data);
		$this->load->view('footer');	
	}

	function search_customer_result()
	{
		$condition = ['cust_mob_no' => $_POST['cust_mobile_no']];
		$customer = $this->Home_model->get_result(MAIN_DB.'.customer_master',$condition,'single');
	
		if(count($customer) > 0)
		{
			echo $customer['cust_id'].'|'.$customer['cust_name'].'|'.$customer['cust_mob_no'].'|'.$customer['cust_email'];
		}
		else
		{
			echo '0| <div class="text-success"><strong>Customer Not Exists</strong></div>';
		}
		// echo '1| <div class="text-success"><strong>Followup Date Updated Success</strong></div>';
	}

	

	public function services($id=null,$type=null)
	{
		if(!empty($this->session->userdata('users')))
		{
			if($id != '')
			{
				if($id == 'filter')
				{
					//print_r($type);
					$dates = explode('-',$type);
					$start = substr(base64_decode($dates[0]),0,-2);
					$end = substr(base64_decode($dates[1]),0,-1);
					$start_date = date('Y-m-d', strtotime($start));
					$end_date = date('Y-m-d', strtotime($end));
					$condition = 's.is_delete = 0 AND s.trip_start >= "'.$start_date.'" AND s.trip_start <=  "'.$end_date.'"';
					$data['services'] = $this->Home_model->get_services(USER_DB.'.services as s',$condition);
					$data['modules'] = $this->Home_model->get_result('emp_module');
					$this->load->view('header',$data);
					$this->load->view('services/services',$data);
					$this->load->view('footer');
				}
				else
				{
					if($type == 'invoice_print')
					{
						$condition = ['s.is_delete' => 0,'s.ser_id' => $id];
						$pay_condition = ['is_delete' => 0,'service_id' => $id];
						$data['service'] = $this->Home_model->get_services(USER_DB.'.services as s',$condition);
						$data['payment_transaction'] = $this->Home_model->get_result(USER_DB.'.payment_transaction',$pay_condition);
						$data['modules'] = $this->Home_model->get_result('emp_module');
						$data['services'] = $data['service'][0];
						$this->load->view('header',$data);
						$this->load->view('services/invoice_print',$data);
						$this->load->view('footer');
						// header("Location: ".Base_path.'services/'.$id);
					}
					else
					{
						$condition = ['s.is_delete' => 0,'s.ser_id' => $id];
						$pay_condition = ['is_delete' => 0,'service_id' => $id];
						$data['service'] = $this->Home_model->get_services(USER_DB.'.services as s',$condition);
						$data['payment_transaction'] = $this->Home_model->get_result(USER_DB.'.payment_transaction',$pay_condition);
						$data['modules'] = $this->Home_model->get_result('emp_module');
						$data['services'] = $data['service'][0];
						$this->load->view('header',$data);
						$this->load->view('services/invoice',$data);
						$this->load->view('footer');
					}
				}
				
			}
			else
			{
				$condition = ['s.is_delete' => 0];
				$data['services'] = $this->Home_model->get_services(USER_DB.'.services as s',$condition);
				$data['modules'] = $this->Home_model->get_result('emp_module');
				$this->load->view('header',$data);
				$this->load->view('services/services',$data);
				$this->load->view('footer');
			}
			
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function service_add($type = null, $id = null)
	{
		if(!empty($this->session->userdata('users')))
		{
			if($type == 'edit')
			{
				$condition = ['s.is_delete' => 0,'s.ser_id' => $id];
				$data['service'] = $this->Home_model->get_services(USER_DB.'.services as s',$condition);
				$data['services'] = $data['service'][0];
				$emp_condition = ['emp_role_id' => 2];
				$data['customers'] = $this->Home_model->get_result(MAIN_DB.'.customer_master');
				$data['employees'] = $this->Home_model->get_result(MAIN_DB.'.employee_master',$emp_condition);
				$data['vehicle'] = $this->Home_model->get_result(USER_DB.'.vehicle');
				$data['cities'] = $this->Home_model->get_result(MAIN_DB.'.cities');
				$data['trips'] = $this->Home_model->get_result(USER_DB.'.trips');
				$data['modules'] = $this->Home_model->get_result('emp_module');
				$this->load->view('header',$data);
				$this->load->view('services/service_add',$data);
				$this->load->view('footer');
			}
			else
			{
				$emp_condition = ['emp_role_id' => 2];
				$data['customers'] = $this->Home_model->get_result(MAIN_DB.'.customer_master');
				$data['employees'] = $this->Home_model->get_result(MAIN_DB.'.employee_master',$emp_condition);
				$data['vehicle'] = $this->Home_model->get_result(USER_DB.'.vehicle');
				$data['cities'] = $this->Home_model->get_result(MAIN_DB.'.cities');
				$data['trips'] = $this->Home_model->get_result(USER_DB.'.trips');
				$data['modules'] = $this->Home_model->get_result('emp_module');
				$this->load->view('header',$data);
				$this->load->view('services/service_add',$data);
				$this->load->view('footer');
			}
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function service_register($type = null)
	{
		if(!empty($this->session->userdata('users')))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('shipper_id', 'Shipper', 'required');
			$this->form_validation->set_rules('consignee_id', 'Consignee', 'required');
			$this->form_validation->set_rules('trip', 'Trip', 'required');
			$this->form_validation->set_rules('description[]', 'Description', 'required');
			
			
			if ($this->form_validation->run() == FALSE) 
			{ 
		    	$message= '<div class="text-danger"><ul>';
				$message.= validation_errors();
				$message.= '</ul></div>';
				echo '0| ' .$message;
		     } 
		     else 
		     { 

				$service = $_POST;

				
				if($type == 'update')
				{
					$condition = ['ser_id' => $service['ser_id']];
					$service_data = ['shipper_id' =>$service['shipper_id'],'consignee_id' =>$service['consignee_id'],'emp_id' =>$service['emp_id'],'vehicle_id' =>$service['vehicle_id'],'trip' => $service['trip'],'trip' => $service['trip'],'trip_start' => $service['trip_start'],'trip_end' => $service['trip_end'],'is_paid' => $service['is_paid'],'paid_amt' => $service['paid_amt'],'balance_amt' => $service['balance_amt']];


					$services = $this->Home_model->update_record(USER_DB.'.services',$service_data,$condition);	

					$total_price = 0;

					for($i=0;$i< count($service['description']);$i++)
					{
						$service_trans = ['service_id' => $service['ser_id'], 'description' =>$service['description'][$i],'qty' =>$service['qty'][$i],'weight' =>$service['weight'][$i],'price' =>$service['price'][$i]];

						$ser_condition = ['st_id' => $service['st_id'][$i]];

						$trans = $this->Home_model->is_already_exist(USER_DB.'.service_transaction',$service_trans);
						
						if(count($trans) > 0)
						{
							$service_transaction = $this->Home_model->update_record(USER_DB.'.service_transaction',$service_trans,$ser_condition);	
						}
						else
						{
							$service_transaction = $this->Home_model->insert_record(USER_DB.'.service_transaction',$service_trans,$ser_condition);	
						}
						

						$total_price += $service['price'][$i];
					}

					$service_condition = ['ser_id' => $service['ser_id']];
					$ser_data = ['total_price' => $service['total_sum']];
					$service_trans = $this->Home_model->update_record(USER_DB.'.services',$ser_data,$service_condition);

					$service_id = $service['ser_id'];
					if($service['ser_is_paid'] != 1)
					{
						
						if($service['ser_is_paid'] == 0)
						{
							$amt = $service['total_sum'];
						}
						else
						{
							$amt = $service['balance_amt'];
						}
							

						$payment_trans = ['service_id' => $service_id, 'pay_type' =>$service['pay_type'],'amt' =>$amt];

						$payment_transaction = $this->Home_model->insert_record(USER_DB.'.payment_transaction',$payment_trans);

						$condition = ['service_id' => $service_id];
						$incomes = $this->Home_model->get_result(USER_DB.'.incomes',$condition);
						$income_data = ['service_id' => $service_id,'income' => $service['total_sum']];
						if(count($incomes) > 0)
						{
							$payment_transaction = $this->Home_model->update_record(USER_DB.'.incomes',$income_data,$condition);
						}
						else
						{
							$payment_transaction = $this->Home_model->insert_record(USER_DB.'.incomes',$income_data);	
						}

						$service_condition = ['ser_id' => $service['ser_id']];
						$ser_data = ['total_price' => $service['total_sum'],'is_paid' => 1, 'paid_amt' => '', 'balance_amt' => ''];
						$service_trans = $this->Home_model->update_record(USER_DB.'.services',$ser_data,$service_condition);
												
					}

					echo '1| <div class="text-success"><strong>Service Updated Success</strong></div>';
				}
				else
				{

					$order_id = substr(md5(mt_rand()),0,6);
					$service_data = ['order_id' => $order_id, 'shipper_id' =>$service['shipper_id'],'consignee_id' =>$service['consignee_id'],'emp_id' =>$service['emp_id'],'vehicle_id' =>$service['vehicle_id'],'trip' => $service['trip'],'trip' => $service['trip'],'trip_start' => $service['trip_start'],'trip_end' => $service['trip_end'],'is_paid' => $service['is_paid'],'paid_amt' => $service['paid_amt'],'balance_amt' => $service['balance_amt']];

					$service_id = $this->Home_model->insert_record(USER_DB.'.services',$service_data);

					$total_price = 0;

					for($i=0;$i< count($service['description']);$i++)
					{
						$service_trans = ['service_id' => $service_id, 'description' =>$service['description'][$i],'qty' =>$service['qty'][$i],'weight' =>$service['weight'][$i],'price' =>$service['price'][$i]];

						$service_transaction = $this->Home_model->insert_record(USER_DB.'.service_transaction',$service_trans);

						$total_price += $service['price'][$i];
						
					}

					$service_condition = ['ser_id' => $service_id];
					$ser_data = ['total_price' => $service['total_sum']];
					$service_trans = $this->Home_model->update_record(USER_DB.'.services',$ser_data,$service_condition);

					if($service['is_paid'] != 0)
					{
						if($service['is_paid'] == 1)
						{
							$amt = $service['total_sum'];
						}
						else
						{
							$amt = $service['paid_amt'];
						}

						$payment_trans = ['service_id' => $service_id, 'pay_type' =>$service['pay_type'],'amt' =>$amt];

						$payment_transaction = $this->Home_model->insert_record(USER_DB.'.payment_transaction',$payment_trans);

						$condition = ['service_id' => $service_id];
						$incomes = $this->Home_model->get_result(USER_DB.'.incomes',$condition);
						$income_data = ['service_id' => $service_id,'income' => $amt];
						if(count($incomes) > 0)
						{
							$payment_transaction = $this->Home_model->update_record(USER_DB.'.incomes',$income_data,$condition);
						}
						else
						{
							$payment_transaction = $this->Home_model->insert_record(USER_DB.'.incomes',$income_data);	
						}
						
					}
					
					
					echo '1| <div class="text-success"><strong>Service Added Success</strong></div>';
					
				}
				
			}
		}
		else
		{
			header("Location: ".Base_path);
		}

	}

	public function trips()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['is_delete' => 0];
			$data['trips'] = $this->Home_model->get_result(USER_DB.'.trips',$condition);
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$this->load->view('header',$data);
			$this->load->view('trip/trips',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	function trip_add()
	{
		if(!empty($this->session->userdata('users')))
		{
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$data['cities'] = $this->Home_model->get_result(MAIN_DB.'.cities');
			
			$this->load->view('header',$data);
			$this->load->view('trip/add_trip',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function trip_register()
	{
		if(!empty($this->session->userdata('users')))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('from_id', 'From', 'required');
			$this->form_validation->set_rules('to_id', 'To', 'required');
			$this->form_validation->set_rules('trip', 'Trip', 'required');
			if ($this->form_validation->run() == FALSE) { 
		    	 $message= '<div class="text-danger"><ul>';
					$message.= validation_errors();
					$message.= '</ul></div>';
					echo '0| ' .$message;
		     } 
		     else 
		     { 
		        $trip_data = ['from_id' => $_POST['from_id'],'to_id' => $_POST['to_id'],'trip' => $_POST['trip']];
		        $trip = $this->Home_model->insert_record(USER_DB.'.trips',$trip_data);
				echo '1| <div class="text-success"><strong>Trip Added Success</strong></div>';
		     } 
		 }
		 else
		 {
		 	header("Location: ".Base_path);
		 }
		
	}

	function save_customer()
	{
		$customer_data = ['cust_name' => $_POST['cust_name'],'cust_mob_no' => $_POST['cust_mobile'],'cust_email' => $_POST['cust_email'],'city_id' => $_POST['city_id'],'cust_address' => $_POST['cust_address']];
        $customer_id = $this->Home_model->insert_record(MAIN_DB.'.customer_master',$customer_data);

        if($customer_id != '')
        {
        	echo $customer_id.'|'.$_POST['cust_name'].'|'.$_POST['cust_address'];
        }
		
	}

	public function expenses()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['e.is_delete' => 0];
			$data['expenses'] = $this->Home_model->get_expenses($condition);
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$this->load->view('header',$data);
			$this->load->view('trip/expenses',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function expenses_add()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['is_delete' => 0];
			$data['trips'] = $this->Home_model->get_result(USER_DB.'.trips',$condition);
			$data['vehicle'] = $this->Home_model->get_result(USER_DB.'.vehicle');
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$this->load->view('header',$data);
			$this->load->view('trip/expenses_add',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function expenses_register()
	{
		if(!empty($this->session->userdata('users')))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('exp_type', 'Expense Type', 'required');
			$this->form_validation->set_rules('amount', 'Amount', 'required');
			$this->form_validation->set_rules('trip', 'Trip', 'required');
			if ($this->form_validation->run() == FALSE) { 
		    	 $message= '<div class="text-danger"><ul>';
					$message.= validation_errors();
					$message.= '</ul></div>';
					echo '0| ' .$message;
		     } 
		     else 
		     { 
		        $expense_data = ['exp_type' => $_POST['exp_type'],'amount' => $_POST['amount'],'trip_id' => $_POST['trip'],'vehicle_id' => $_POST['vehicle_id'],'ship_date' => $_POST['ship_date']];
		        $expenses = $this->Home_model->insert_record(USER_DB.'.expenses',$expense_data);

		        if($expenses != '')
		        {
		        	echo '1| <div class="text-success"><strong>Expense Added Success</strong></div>';
		        }
		     } 
		 }
		 else
		 {
		 	header("Location: ".Base_path);
		 }
	}

	public function vehicle()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['is_delete' => 0];
			$data['vehicle'] = $this->Home_model->get_result(USER_DB.'.vehicle',$condition);
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$this->load->view('header',$data);
			$this->load->view('trip/vehicle',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function vehicle_add()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['is_delete' => 0];
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$this->load->view('header',$data);
			$this->load->view('trip/vehicle_add',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	public function vehicle_register()
	{
		if(!empty($this->session->userdata('users')))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'required');
			$this->form_validation->set_rules('capacity', 'Capacity', 'required');
			$this->form_validation->set_rules('payment', 'Payment', 'required');
			if ($this->form_validation->run() == FALSE) { 
		    	 $message= '<div class="text-danger"><ul>';
					$message.= validation_errors();
					$message.= '</ul></div>';
					echo '0| ' .$message;
		     } 
		     else 
		     { 
		     	$v_condition = ['vehicle_no' => $_POST['vehicle_no'],'capacity' => $_POST['capacity']];
		    	$is_vehicle_exists = $this->Home_model->is_already_exist(USER_DB.'.vehicle',$v_condition);
		    	if(count($is_vehicle_exists) > 0)
				{
					header("Location: ".Base_path.'vehicle_add');
				}
				else
				{
		     		// print_r($_POST);
		     		// print_r($_FILES);
		     		// // die;
			        $vehicle_data = ['vehicle_no' => $_POST['vehicle_no'],'capacity' => $_POST['capacity'],'payment' => $_POST['payment'],'insurance_expire' => $_POST['insurance_expire']];
			        $vehicle = $this->Home_model->insert_record(USER_DB.'.vehicle',$vehicle_data);
			        
			        if($vehicle != 0)
			        {
	        		
        				$vehicle_rc_upload_path = './uploads/owners/'.$this->session->userdata('users')['company_id'].'/vehicle/'.$vehicle.'/RC';

		        		if(!empty($vehicle_rc_upload_path))
						{
							mkdir($vehicle_rc_upload_path,0777, true);
						}

					    $vehicle_ins_upload_path = './uploads/owners/'.$this->session->userdata('users')['company_id'].'/vehicle/'.$vehicle.'/INSURANCE';

						if(!empty($vehicle_ins_upload_path))
						{
							mkdir($vehicle_ins_upload_path,0777, true);
						}

						$rc_book_file = explode('.',$_FILES['rc_book']['name']);
						$rc_book_type = $rc_book_file[1];
						$rc_file_name = substr(md5(mt_rand()),0,6).date('Ymd').'.'.$rc_book_type;
						move_uploaded_file($_FILES['rc_book']['tmp_name'], './uploads/owners/'.$this->session->userdata('users')['company_id'].'/vehicle/'.$vehicle.'/RC/'.$rc_file_name);
						// $rc_filename = $_FILES['rc_book']['name'];

						$insurance_file = explode('.',$_FILES['insurance_copy']['name']);
						$insurance_type = $insurance_file[1];
						$insurance_file_name = substr(md5(mt_rand()),0,6).date('Ymd').'.'.$insurance_type;
						move_uploaded_file($_FILES['insurance_copy']['tmp_name'], './uploads/owners/'.$this->session->userdata('users')['company_id'].'/vehicle/'.$vehicle.'/INSURANCE/'.$insurance_file_name);
						// $ins_filename = $_FILES['insurance_copy']['name'];

				   	   $image_condition = ['v_id' => $vehicle];
					   $image_data = ['rc_book' => $rc_file_name , 'insurance_copy' => $insurance_file_name];
					   $image = $this->Home_model->update_record(USER_DB.'.vehicle',$image_data,$image_condition);

			        	header("Location: ".Base_path.'vehicle');
			        }
			    }
		     } 
		 }
		 else
		 {
		 	header("Location: ".Base_path);
		 }
	}

	public function incomes()
	{
		if(!empty($this->session->userdata('users')))
		{
			$condition = ['i.is_delete' => 0];
			$data['incomes'] = $this->Home_model->get_incomes($condition);
			$data['modules'] = $this->Home_model->get_result('emp_module');
			$this->load->view('header',$data);
			$this->load->view('trip/incomes',$data);
			$this->load->view('footer');
		}
		else
		{
			header("Location: ".Base_path);
		}
	}

	function get_cust_address()
	{
		$cust_id = $_POST['cust_id'];
		$condition = ['is_delete' => 0, 'cust_id' => $cust_id];
		$customer = $this->Home_model->get_result(MAIN_DB.'.customer_master',$condition);
		echo $customer[0]['cust_address'];
		
	}

	function tracking()
	{
		$condition = ['i.is_delete' => 0];
		$data['incomes'] = $this->Home_model->get_incomes($condition);
		$data['modules'] = $this->Home_model->get_result('emp_module');
		$this->load->view('header',$data);
		$this->load->view('services/tracking',$data);
		$this->load->view('footer');

	}

	public function exportCSV($type=null,$date=null)
	{
		if($type == 'filter')
		{
			$dates = explode('-',$date);
			$start = substr(base64_decode($dates[0]),0,-2);
			$end = substr(base64_decode($dates[1]),0,-1);
			$start_date = date('Y-m-d', strtotime($start));
			$end_date = date('Y-m-d', strtotime($end));
			$condition = 's.is_delete = 0 AND s.trip_start >= "'.$start_date.'" AND s.trip_start <=  "'.$end_date.'"';
			$services = $this->Home_model->get_services(USER_DB.'.services as s',$condition);
		}
		else
		{
			$condition = ['s.is_delete' => 0];
			$services = $this->Home_model->get_services(USER_DB.'.services as s',$condition);
			
		}
        // file name
        $filename = 'services_'.date('Ymd').'.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
 
        // file creation
        $file = fopen('php://output', 'w');
 
        $header = array("Id","Shipper","Consignee","Description","Weight","Ship Date");
        fputcsv($file, $header);
 		
 		$i = 1;
        foreach ($services as $row){
        		$weight = explode(',',$row['weight']);
                $total_weight = array_sum($weight);
        	 fputcsv($file,array($i,$row['shipper'],$row['consignee'],$row['description'],$total_weight,"'".$row['trip_start']."'"));
            $i++;
        }
 
        fclose($file);
        exit;
    }

	function company_add()
	{
		$data['modules'] = $this->Home_model->get_result('emp_module');
		$data['cities'] = $this->Home_model->get_result(MAIN_DB.'.cities');
	
		// $this->load->view('header',$data);
		$this->load->view('customers/register',$data);
		// $this->load->view('footer');
	
	}

	public function company_register()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		$this->form_validation->set_rules('company_alias', 'Company Alias', 'required');
		if ($this->form_validation->run() == FALSE) { 
	    	 $message= '<div class="text-danger"><ul>';
				$message.= validation_errors();
				$message.= '</ul></div>';
				echo '0| ' .$message;
	     } 
	     else 
	     { 
	        $company_data = ['company_name' => $_POST['company_name'],'company_alias' => $_POST['company_alias']];
	       
	        $company_id = $this->Home_model->insert_record(MAIN_DB.'.company',$company_data);

	        $user_data = ['user_name' => $_POST['company_name'],'user_alias' => $_POST['company_alias'],'role' => 1,'company_id' => 0,'user_email' => $_POST['user_email'],'password' => $_POST['password'],'user_mobile' => $_POST['user_mobile'],'city_id' => $_POST['city_id'],'is_paid' => 1];
       
	        $user_id = $this->Home_model->insert_record(MAIN_DB.'.users',$user_data);

	        $users_data = ['user_id' => $user_id];
			$condition = ['company_id' => $company_id];
			$company = $this->Home_model->update_roles(MAIN_DB.'.company',$users_data,$condition);
			

	        if($company_id != '')
	        {
		        $db_first_name = str_replace('-','_',$_POST['company_alias']);
                $new_db_name = 'tms_'.$db_first_name.'_'.$company_id;
                $newdb = $new_db_name;
                $create = "CREATE DATABASE ".$newdb;
                $this->db->query($create);
                $database1 = $newdb; // destination database
               
                $database = 'tms'; //original database
               
                // $tables = $this->db->query("SHOW TABLES FROM $database")->result_array();
                $tables = ['customer_enquiry','emp_roles','expenses','incomes','payment_transaction','services','service_transaction','trips'];
                foreach ($tables as $value) 
                {
                    $tbl = $value;
                    $this->db->query("DROP TABLE IF EXISTS $database1.$tbl");
                    $this->db->query("CREATE TABLE $database1.$tbl LIKE $database.$tbl");
                }
                echo '1| <div class="text-success"><strong>Company Added Success</strong></div>';
            }
	     } 
	
	}

	function logout()
	{
		$this->session->unset_userdata('users');
		header("Location: ".Base_path);
	}
}
