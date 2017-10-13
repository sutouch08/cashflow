<?php
class Company_model extends CI_Model
{
	
public function __construct()
{
	parent:: __construct();
}

public function get_data($id="")
{
	if($id != "")
	{
		$rs = $this->db->where("id_company", $id)->get("tbl_company");
	}else{
		$rs = $this->db->get("tbl_company");
	}
	if($rs->num_rows() > 0)
	{
		return $rs->result();
	}else{
		return false;
	}
}


public function add_company($data)
{
	$rs = $this->db->insert("tbl_company", $data);
	return $rs;	
}

public function update($id, $data)
{
	$rs = $this->db->where("id_company", $id)->update("tbl_company", $data);
	return $rs;	
}

public function delete_company($id)
{
	$rs = $this->db->where("id_company", $id)->delete("tbl_company");
	return $rs;
}


public function valid_transection($id)
{
	$rs = $this->db->where("id_company", $id)->get("tbl_bank_acc");
	if($rs->num_rows() > 0)
	{
		return true;
	}else{
		return false;
	}
}

public function valid_name($name, $id="")
{
	if($id != "")
	{
		$rs = $this->db->where("company_name", $name)->where("id_company !=", $id)->get("tbl_company");
	}else{
		$rs = $this->db->where("company_name", $name)->get("tbl_company");
	}
	if($rs->num_rows() > 0)
	{
		return true;
	}else{
		return false;
	}
}
	
	
}/// End class


?>