<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Home_model'));
    }

	public function index()
	{
		$this->load->view('customers/login');
	}

	public function login()
	{
		$userdata = $_POST;
		
		if($_POST['emp_email'] != '' && $_POST['emp_password'])
		{
			$user = $this->Home_model->check_login($userdata);
			
			if(count($user) != 0)
			{
				$this->session->set_userdata(['username' => $user['emp_name'],'email' => $user['emp_email']]);
				header("Location: http://www.prvivek.com/CRM/dashboard"); 
			}
			else
			{
				header("Location: http://www.prvivek.com/CRM/"); 
			}
		}
		else
		{
			header("Location: http://www.prvivek.com/CRM/"); 
		}
		
		
	}

	public function register()
	{
		$this->load->view('customer/register');
	}

	function dashboard()
	{
		$products = $this->Home_model->get_result(USER_DB.'.products');
		$employee = $this->Home_model->get_result(MAIN_DB.'.employee_master');
		$roles = $this->Home_model->get_result(USER_DB.'.emp_roles');
		$customers = $this->Home_model->get_result(MAIN_DB.'.customer_master');

		$data['product_count'] = count($products);
		$data['employee_count'] = count($employee);
		$data['roles_count'] = count($roles);
		$data['customers_count'] = count($customers);
		

		$this->load->view('header');
		$this->load->view('dashboard/dashboard',$data);
		$this->load->view('footer');
	}

	function roles()
	{
		$data['modules'] = $this->Home_model->get_result('emp_module');	
		$data['roles'] = $this->Home_model->get_result(USER_DB.'.emp_roles');
		$this->load->view('header');
		$this->load->view('roles/roles',$data);
		$this->load->view('footer');
	}

	function add_roles()
	{
	
		$mod=array();
		foreach ($_POST['modules'] as $key => $value) 
		{
			array_push($mod,$value);	
		}
		$mod = implode(', ', $mod);

		if($_POST['role'] != 0)
		{
		    $role_data = ['modules' => $mod];
			$condition = ['rol_id' => $_POST['role']];
			$user = $this->Home_model->update_roles(USER_DB.'.emp_roles',$role_data,$condition);
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

		echo 1;
		

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
        $condition = ['is_delete' => 0];
		$data['emplyees'] = $this->Home_model->get_result(MAIN_DB.'.employee_master',$condition);
		$data['roles'] = $this->Home_model->get_result(USER_DB.'.emp_roles');
		$this->load->view('header');
		$this->load->view('employee/employee',$data);
		$this->load->view('footer');
	}

	function employee_add($type = null, $id = null)
	{

		if($type == 'edit')
		{
			$condition = ['emp_id' => $id];
			$data['employee'] = $this->Home_model->get_result(MAIN_DB.'.employee_master',$condition,'single');
			$data['roles'] = $this->Home_model->get_result(USER_DB.'.emp_roles');	
			$this->load->view('header');
			$this->load->view('employee/employee_add',$data);
			$this->load->view('footer');
		}
		else
		{
			$data['roles'] = $this->Home_model->get_result(USER_DB.'.emp_roles');	
			$this->load->view('header');
			$this->load->view('employee/employee_add',$data);
			$this->load->view('footer');	
		}
	}

	public function employee_register($type = null)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('emp_name', 'Employee Name', 'required|alpha');
		$this->form_validation->set_rules('emp_email', 'Email', 'required');
		$this->form_validation->set_rules('emp_password', 'Password', 'required');
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
	
	public function delete_employee()
	{
		$condition = ['emp_id' => $_POST['emp_id']];
		$employee_data = ['is_delete' => 1];
		$employee = $this->Home_model->update_record(MAIN_DB.'.employee_master',$employee_data,$condition);
		echo '1| <div class="text-success"><strong>Employee Updated Success</strong></div>';
		
	}

	public function product_add()
	{

		$data['categories'] = $this->Home_model->get_result(MAIN_DB.'.product_category');
		$this->load->view('header');
		$this->load->view('products/product_add',$data);
		$this->load->view('footer');
	}

	public function add_prod_category()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('prod_cat_name', 'Product Category', 'required');
		if ($this->form_validation->run() == FALSE) 
		{ 
	    	$message= '<div class="text-danger"><ul>';
			$message.= validation_errors();
			$message.= '</ul></div>';
			echo '0| ' .$message;
	     } 
	     else 
	     { 
			$prod_cat_data = ['prod_category_name' => $_POST['prod_cat_name']];

			$categories = $this->Home_model->insert_record(MAIN_DB.'.product_category',$prod_cat_data);
			
			if(isset($categories))
			{
				echo '1| <div class="text-success"><strong>Product Category Added Success</strong></div>';
			}
			else
			{
				echo '1| <div class="text-danger"><strong>Product Category Added Failed</strong></div>';
			}
		 }

	}

	public function add_product()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('prod_name', 'Product Name', 'required');
		$this->form_validation->set_rules('prod_cat_id', 'Product Category', 'required');
		if ($this->form_validation->run() == FALSE) 
		{ 
	    	$message= '<div class="text-danger"><ul>';
			$message.= validation_errors();
			$message.= '</ul></div>';
			echo '0| ' .$message;
	     } 
	     else 
	     { 

			$product = $_POST;
			$products = $this->Home_model->insert_record(USER_DB.'.products',$product);	
			
			if(isset($products))
			{
				echo '1| <div class="text-success"><strong>Product Added Success</strong></div>';
			}
			else
			{
				echo '1| <div class="text-danger"><strong>Product Added Failed</strong></div>';
			}
		}

	}

	function products()
	{

		$data['categories'] = $this->Home_model->get_result(MAIN_DB.'.product_category');
		$data['products'] = $this->Home_model->get_products(USER_DB.'.products as p');
		$this->load->view('header');
		$this->load->view('products/products',$data);
		$this->load->view('footer');
	}

	function customers()
	{

		$data['customers'] = $this->Home_model->get_result(MAIN_DB.'.customer_master');
		$this->load->view('header');
		$this->load->view('customers/customers',$data);
		$this->load->view('footer');
	}

	function customer_add()
	{
		$this->load->view('header');
		$this->load->view('customers/customer_add');
		$this->load->view('footer');
	}

	public function customer_register()
	{
		$customer_data = $_POST;
		if($_POST['cust_name'] !== '' && $_POST['cust_email'] !== '')
		{
			$customer = $this->Home_model->insert_record(MAIN_DB.'.customer_master',$customer_data);
		}
		else
		{
			echo 0;
		}
		
		if(isset($customer))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	function purchase()
	{
		$data['purchase'] = $this->Home_model->get_purchase_products(USER_DB.'.customer_purchase as cp');
		$this->load->view('header');
		$this->load->view('purchase/purchase',$data);
		$this->load->view('footer');
	}

	function purchase_add()
	{
		$data['customers'] = $this->Home_model->get_result(MAIN_DB.'.customer_master');
		$data['products'] = $this->Home_model->get_products(USER_DB.'.products as p');
		$this->load->view('header');
		$this->load->view('purchase/purchase_add',$data);
		$this->load->view('footer');
	}

	public function purchase_register()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('prod_id', 'Product', 'required');
		$this->form_validation->set_rules('cust_id', 'Customer', 'required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required');
		if ($this->form_validation->run() == FALSE) { 
	    	 $message= '<div class="text-danger"><ul>';
				$message.= validation_errors();
				$message.= '</ul></div>';
				echo '0| ' .$message;
	     } 
	     else 
	     { 
	        $purchase_data = $_POST;
			$purchase = $this->Home_model->insert_record(USER_DB.'.customer_purchase',$purchase_data);
			
			if(isset($purchase))
			{
				echo '1| <div class="text-success"><strong>Purchase Added Success</strong></div>';
			}
			else
			{
				echo '1| <div class="text-danger"><strong>Purchase Added Failed</strong></div>';
			}
	     } 

		
	}

	function get_product()
	{
		$prod_id = $_POST['prod_id'];
		$condition = ['prod_id' => $prod_id];
		$prod = $this->Home_model->get_products(USER_DB.'.products as p',$prod_id);
		echo $prod['prod_desc'].'|'.$prod['prod_company'].'|'.$prod['prod_category_name'];
	}
	
	function is_role_already_exist()
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
		
		// echo $prod['prod_desc'].'|'.$prod['prod_company'].'|'.$prod['prod_category_name'];
	}
}
