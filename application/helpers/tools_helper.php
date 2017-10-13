<?php
function company_name($id)
{
	$name = "";
	$c =& get_instance();
	$rs = $c->db->select("company_name")->where("id_company", $id)->get("tbl_company");
	if($rs->num_rows() == 1)
	{
		$name = $rs->row()->company_name;
	}
	return $name;
}
function bank_name($id)
{
	$name = "";
	$c =& get_instance();
	$rs = $c->db->select("bank_name")->where("id_bank", $id)->get("tbl_bank");
	if($rs->num_rows() == 1)
	{
		$name = $rs->row()->bank_name;
	}
	return $name;
}


function employee_name($id_employee)
{
	$c =& get_instance();
	$rs = $c->db->select("first_name, last_name")->where("id_employee", $id_employee)->get("tbl_employee");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->first_name." ".$rs->row()->last_name;
	}else{
		return "";
	}
}

function employee_name_by_user($id_user)
{
	$name = "";
	$c =& get_instance();
	$rs = $c->db->select("id_employee")->where("id_user", $id_user)->get("user");
	if($rs->num_rows() == 1 )
	{
		$id_employee = $rs->row()->id_employee;
		$name = employee_name($id_employee);
	}
	return $name;
}

function profile_name($id_profile)
{
	$c =& get_instance();
	$rs = $c->db->select("profile_name")->where("id_profile", $id_profile)->get("tbl_profile");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->profile_name;
	}else{
		return "";
	}
}

function menu_name($id_menu)
{
	$c =& get_instance();
	$rs = $c->db->select("name")->where("id_menu", $id_menu)->get("tbl_menu");
	return $rs->row()->name;	
}

function user_name($id_user)
{
	$c =& get_instance();
	$rs = $c->db->select("user_name")->where("id_user", $id_user)->get("user");
	return $rs->row()->user_name;
}

function bank_ac_detail($id_bank_ac)
{
	$c =& get_instance();
	$rs = $c->db->select("ac_code, ac_number, ac_name")->where("id_bank_ac", $id_bank_ac)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->ac_code." : ".$rs->row()->ac_number." : ".$rs->row()->ac_name;
	}else{
		return false;
	}
}

function get_bank_id($id_bank_ac)
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
//********************  SELECT **********************//
function book_select($id = "")
{
	$option = "<option value='0'>เลือกสมุดบัญชี</option>";
	$c =& get_instance();
	$data = $c->db->select("id_bank_ac, ac_code, ac_number")->get("tbl_bank_ac");
	if($data->num_rows() > 0 )
	{
		foreach($data->result() as $rs)
		{
			if($rs->id_bank_ac == $id){ $se = "selected"; }else{ $se = ""; }
			$option .="<option value='".$rs->id_bank_ac."' ".$se." >".$rs->ac_code." : ".$rs->ac_number."</option>";
		}
	}
	return $option;
}


function repay_reference_select($id_bank_ac, $id='')
{
	$option = "";
	$c =& get_instance();
	$rs = $c->db->select("id_loan, reference")->where("id_bank_ac", $id_bank_ac)->where("valid", 0)->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		$i = 1;
		$n = $rs->num_rows();
		foreach($rs->result() as $ro)
		{
			$id_loan = $ro->id_loan;
			$reference = $ro->reference;
			$option .= $id_loan." : ".$reference;
			if($i < $n){ $option .= ", "; }
			$i++;
		}
	}
	return $option;
}

function color_select($color='')
{
	$option = "
	<option value='lightgrey' >grey</option>
	<option value='#ff76b4' >pink</option>
	<option value='#f9cfe3' >light-pink</option>
	<option value='#0a7fe0' >blue</option>
	<option value='#9cd2f7' >light-blue</option>
	<option value='#78af2c' >green</option>
	<option value='#c7e0a0' >light-green</option>
	<option value='#efdf1b' >yellow</option>
	<option value='#fceba2' >light-yellow</option>
	<option value='#ef9533' >orange</option>
	<option value='#f9cb8f' >light-orange</option>
	";
	return $option;	
}

function move_select($name="เช็ค")
{
	$option = "";
	$c =& get_instance();
	$rs = $c->db->select("name")->get("tbl_move_type");
	if($rs->num_rows() > 0)
	{
		foreach($rs->result() as $ro)
		{
			$option .= "<option value='".$ro->name."' ".isSelected($name, $ro->name)." >".$ro->name."</option>";
		}
	}
	return $option;	
}

function bank_select($id="")
{
	$option = "<option value='0'>เลือกธนาคาร</option>";
	$c =& get_instance();
	$rs = $c->db->select("id_bank, bank_name")->get("tbl_bank");
	if($rs->num_rows() > 0)
	{
		foreach($rs->result() as $ro)
		{
			$option .= "<option value='".$ro->id_bank."' ".isSelected($id, $ro->id_bank)." >".$ro->bank_name."</option>";
		}
	}
	return $option;
}

function company_select($id="")
{
	$option = "<option value='0'>เลือกบริษัท</option>";
	$c =& get_instance();
	$rs = $c->db->select("id_company, company_name")->where("active", 1)->get("tbl_company");
	if($rs->num_rows() > 0)
	{
		foreach($rs->result() as $ro)
		{
			$option .= "<option value='".$ro->id_company."' ".isSelected($id, $ro->id_company)." >".$ro->company_name."</option>";
		}
	}
	return $option;
}


function employee_select($id = "")
{
	$option = "<option value='0'>เลือกพนักงาน </option>";
	$c =& get_instance();
	$rs = $c->db->select("id_employee, first_name, last_name")->where("is_quit !=", 1)->get("tbl_employee");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			$option .= "<option value='".$ro->id_employee."' ".isSelected($id, $ro->id_employee)." >".$ro->first_name." ".$ro->last_name."</option>";	
		}
	}
	return $option;
}

function profile_select($id = "")
{
	$option = "<option value='0'>เลือกโปรไฟล์</option>";
	$c =& get_instance();
	$rs = $c->db->get("tbl_profile");
	if($rs->num_rows() > 0)
	{
		foreach($rs->result() as $ro)
		{
			$option .= "<option value='".$ro->id_profile."' ".isSelected($id, $ro->id_profile)." >".$ro->profile_name."</option>";
		}
	}
	return $option;
}

function ignore_enter()
{
	return "<input type='text' name='disable_enter' style='display:none'  disabled placeholder='เอาไว้ป้องกันการ SUBMIT โดยการกด Enter' />";
}

function go_to($data)
{
	$c =& get_instance();
	$data['id_menu']	= $c->id_menu;
	$data['title']			= $c->title;
	$c->load->view($c->layout, $data);
}
?>