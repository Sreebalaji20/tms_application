<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

public function check_login($userdata)
{
	$this->db->select('*');
    $this->db->where($userdata);
    $this->db->from('employee_master');
    $query = $this->db->get()->row_array();
    return $query;

}


public function insert_record($table=null,$data=null)
{
	$this->db->insert($table, $data);
    $last_id = $this->db->insert_id();
    // print_r($this->db->last_query());    
    return $last_id;
    
}

public function update_record($table,$data,$condition)	
{	
    $this->db->where($condition);   	
    if ($this->db->update($table, $data)) {	
        return 1;	
    } else {	
        return 0;	
    }	
}	


public function get_result($table=null,$condition=null,$single=null)
{
	$this->db->select('*');
	if(isset($condition))
	{
		$this->db->where($condition);
	}
    $this->db->from($table);
    if(isset($single))
    {
    	$query = $this->db->get()->row_array();
    }
    else
    {
    	$query = $this->db->get()->result_array();
    }
    
    return $query;
}

public function get_modules()
{
	$this->db->select('*');
    $this->db->from('emp_module');
    $query = $this->db->get()->result_array();
    return $query;
}


public function get_products($table,$prod_id=null)
{
    $this->db->select('p.*,pc.prod_category_name');
    $this->db->from($table);
    $this->db->join(MAIN_DB.'.product_category as pc', 'pc.prod_cat_id = p.prod_cat_id');
    if($prod_id != '')
    {
        $this->db->where('prod_id',$prod_id);
        $query = $this->db->get()->row_array();
    }
    else
    {
        $query = $this->db->get()->result_array();
    }
    return $query;
}

public function get_roles($role=null)
{
	$this->db->select('*');
	if(isset($role))
    {
    	$this->db->where('rol_id',$role);	
    }
    $this->db->from(USER_DB.'.emp_roles');
    if(isset($role))
    {
    	$query = $this->db->get()->row_array();
    }
    else
    {
    	$query = $this->db->get()->result_array();	
    }
    return $query;
}

public function update_roles($table,$data,$condition)
{
	$this->db->where($condition);	
    if ($this->db->update($table, $data)) {
        return 1;
    } else {
        return 0;
    }
}

public function get_purchase_products($table,$prod_id=null)
{
    $this->db->select('cp.*,p.*,c.*,pc.prod_category_name');
    $this->db->from($table);
    $this->db->join(MAIN_DB.'.customer_master as c', 'c.cust_id = cp.cust_id');
    $this->db->join(USER_DB.'.products as p', 'p.prod_id = cp.prod_id');
    $this->db->join(MAIN_DB.'.product_category as pc', 'pc.prod_cat_id = p.prod_cat_id');
    if($prod_id != '')
    {
        $this->db->where('p.prod_id',$prod_id);
        $query = $this->db->get()->row_array();
    }
    else
    {
        $query = $this->db->get()->result_array();
    }
    
    return $query;
}

public function is_already_exist($table=null,$condition=null)
{
    $this->db->select('*');
    $this->db->where($condition);   
    $this->db->from($table);
    $query = $this->db->get()->row_array();
    return $query;
}

}

?>