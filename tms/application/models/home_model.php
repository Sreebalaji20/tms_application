<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

public function check_login($userdata)
{
	$this->db->select('*');
    $this->db->where($userdata);
    $this->db->from('users');
    $query = $this->db->get()->row_array();
    return $query;

}


public function insert_record($table,$data)
{
	$this->db->insert($table, $data);
    $last_id= $this->db->insert_id();
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

public function get_employees($condition=null)
{
    $this->db->select('*');
    $this->db->from(MAIN_DB.'.employee_master as em');
    $this->db->join(USER_DB.'.emp_roles as er', 'er.rol_id = em.emp_role_id');
    $this->db->where($condition);
    $query = $this->db->get()->result_array();
    return $query;
}

public function get_expenses($condition,$id=null)
{
    $this->db->select('*,SUM(amount) as total,GROUP_CONCAT(exp_type) as type,t.trip as trip_name,v.vehicle_no');
    $this->db->from(USER_DB.'.expenses as e');
    $this->db->join(USER_DB.'.trips as t', 't.trip_id = e.trip_id');
    if($id != '')
    {
        $this->db->join(USER_DB.'.services as s', 's.trip = e.trip_id AND s.trip_start = e.ship_date');
    }
    $this->db->join(USER_DB.'.vehicle as v', 'v.v_id = e.vehicle_id');
    $this->db->where($condition);
    $this->db->group_by(array('e.trip_id','e.ship_date'));
    $this->db->order_by('e.exp_id', 'desc');

    $query = $this->db->get()->result_array();
    // echo $this->db->last_query();
    return $query;
}

public function get_incomes($condition)
{
    $this->db->select('*,c.cust_name as shipper,cm.cust_name as consignee,c.cust_id as shipper_id,cm.cust_id as consignee_id,s.trip_start');
    $this->db->from(USER_DB.'.incomes as i');
    $this->db->join(USER_DB.'.services as s', 's.ser_id = i.service_id');
    $this->db->join(MAIN_DB.'.customer_master as c', 'c.cust_id = s.shipper_id','left');
    $this->db->join(MAIN_DB.'.customer_master as cm', 'cm.cust_id = s.consignee_id','left');
    $this->db->where($condition);
    $this->db->group_by(array('i.service_id'));
    $this->db->order_by('s.ser_id', 'desc');

    $query = $this->db->get()->result_array();
    // echo $this->db->last_query();
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

public function get_services($table,$condition=null)
{
    $this->db->select('s.*,e.emp_name,t.trip as trip_name,c.cust_name as shipper,c.cust_mob_no as shipper_mobile,c.cust_address as shipper_address,c.cust_mob_no as shipper_mobile,c.cust_email as shipper_email,cm.cust_name as consignee,cm.cust_address as consignee_address,cm.cust_mob_no as consignee_mobile,cm.cust_email as consignee_email,GROUP_CONCAT(st.st_id) st_id,GROUP_CONCAT(st.description) description,GROUP_CONCAT(st.qty) qty,GROUP_CONCAT(st.weight) weight,GROUP_CONCAT(st.price) price,SUM(st.price) AS sub_total');
    $this->db->from($table);
    $this->db->join(MAIN_DB.'.customer_master as c', 'c.cust_id = s.shipper_id','left');
    $this->db->join(MAIN_DB.'.customer_master as cm', 'cm.cust_id = s.consignee_id','left');
    $this->db->join(USER_DB.'.service_transaction as st', 'st.service_id = s.ser_id','left');
    $this->db->join(MAIN_DB.'.employee_master as e', 'e.emp_id = s.emp_id','left');
    $this->db->join(USER_DB.'.trips as t', 't.trip_id = s.trip','left');
    $this->db->order_by('s.ser_id', 'desc');
    $this->db->group_by('st.service_id');

    if(isset($condition))
    {
        $this->db->where($condition);
    }

   
   $query = $this->db->get()->result_array();
    return $query;
}

public function get_services_chart($table,$condition=null)
{
    $this->db->select('MONTHNAME(trip_start) AS service_month,COUNT(*) AS service_count');
    $this->db->from($table);
    $this->db->order_by('MONTH(s.trip_start)', 'asc');
    $this->db->group_by('MONTHNAME(s.trip_start)');

    if(isset($condition))
    {
        $this->db->where($condition);
    }

   
   $query = $this->db->get()->result_array();
    return $query;
}

public function get_incomes_chart($table,$condition=null)
{
    $this->db->select('MONTHNAME(trip_start) AS income_month,SUM(income) AS income');
    $this->db->from($table);
    $this->db->join(USER_DB.'.incomes as i', 'i.service_id = s.ser_id');
    $this->db->order_by('MONTH(s.trip_start)', 'asc');
    $this->db->group_by('MONTHNAME(s.trip_start)');

    if(isset($condition))
    {
        $this->db->where($condition);
    }

   
   $query = $this->db->get()->result_array();
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