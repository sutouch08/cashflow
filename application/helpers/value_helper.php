<?php

function pagination_config( $base_url, $total_rows = 0, $perpage = 20, $segment = 3)
{		
		$config['full_tag_open'] 		= "<nav><ul class='pagination'>";
		$config['full_tag_close'] 		= "</ul></nav>";
		$config['first_link'] 				= 'First';
		$config['first_tag_open'] 		= "<li>";
		$config['first_tag_close'] 		= "</li>";
		$config['next_link'] 				= 'Next';
		$config['next_tag_open'] 		= "<li>";
		$config['next_tag_close'] 	= "</li>";
		$config['prev_link'] 			= 'prev';
		$config['prev_tag_open'] 	= "<li>";
		$config['prev_tag_close'] 	= "</li>";
		$config['last_link'] 				= 'Last';
		$config['last_tag_open'] 		= "<li>";
		$config['last_tag_close'] 		= "</li>";
		$config['cur_tag_open'] 		= "<li class='active'><a href='#'>";
		$config['cur_tag_close'] 		= "</a></li>";
		$config['num_tag_open'] 		= '<li>';
		$config['num_tag_close'] 		= "</li>";
		$config['uri_segment'] 		= $segment;
		$config['per_page']			= $perpage;
		$config['total_rows']			= $total_rows != false ? $total_rows : 0 ;
		$config['base_url']				= $base_url;
		return $config;
}

function getConfig($name)
{
	$c =& get_instance();
	$rs = $c->db->select("value")->where("name", $name)->get("tbl_setting");
	return $rs->row()->value;
}

function set_session($name, $value)
{
	$c =& get_instance();
	$c->session->set_userdata($name, $value);
}



function setError($message)
{
	$c =& get_instance();
	$c->session->set_flashdata("error", $message);
}

function setMessage($message)
{
	$c =& get_instance();
	$c->session->set_flashdata("success", $message);
}

function isActived($value)
{
	$icon = "<i class='fa fa-remove' style='color:red'></i>";
	if($value == "1")
	{
		$icon = "<i class='fa fa-check' style='color:green'></i>";
	}
	return $icon;
}

function isMatch($val1, $val2)
{
	$value = false;
	if( $val1 == $val2 )
	{
		$value = true;
	}
	return $value;
}

function isChecked($val1, $val2)
{
	$value = "";
	if( $val1 == $val2 )
	{
		$value = "checked='checked'";
	}
	return $value;
}

function isSelected($val1, $val2)
{
	$value = "";
	if($val1 == $val2)
	{
		$value = "selected='selected'";
	}
	return $value;
}

function get_id_bank_by_ac($id_bank_ac)
{
	$c =& get_instance();
	$rs = $c->db->select("id_bank")->where("id_bank_ac", $id_bank_ac)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->id_bank;
	}else{
		return false;
	}
}

function get_id_employee_by_user($id_user)
{
	$c =& get_instance();
	$id = "";
	$rs = $c->db->select("id_employee")->get_where("user", array("id_user"=>$id_user),1);
	if($rs->num_rows() == 1)
	{
		$id = $rs->row()->id_employee;
	}
	return $id;		
	
}

function getEmployeeNameByIdUser($id_user)
{
	$c =& get_instance();
	$name = "";
	$rs = $c->db->select("first_name")->join("tbl_employee","tbl_employee.id_employee = user.id_employee")->get_where("user", array("id_user"=>$id_user),1);
	if($rs->num_rows() == 1)
	{
		$name = $rs->row()->first_name;
	}
	return $name;	
}

function number($value, $digit ="")
{
	$number = "";
	if($value <= 0 )
	{
		$number = "-";
	}else{
		if($digit != "")
		{
			$number = number_format($value, $digit);
		}else{
			$number = number_format($value);
		}
	}
	return $number;
}

function balance($value, $digit ="")
{
	$number = "";
	if($value == 0 )
	{
		$number = "-";
	}else{
		if($digit != "")
		{
			$number = number_format($value, $digit);
		}else{
			$number = number_format($value);
		}
	}
	return $number;
}

?>