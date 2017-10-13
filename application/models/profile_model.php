<?php
class Profile_model extends CI_Model
{

public function __construct()
{
	parent:: __construct();	
}

public function get_data($id="")
{
	if($id != "" )
	{
		$rs = $this->db->where("id_profile", $id)->get("tbl_profile");
	}else{
		$rs = $this->db->get("tbl_profile");
	}
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}else{
		return false;
	}
}

public function add_profile($data)
{
	$rs = $this->db->insert("tbl_profile", $data);
	return $rs;	
}

public function update($id, $data)
{
	$rs = $this->db->where("id_profile", $id)->update("tbl_profile", $data);
	return $rs;	
}

public function delete_profile($id)
{
	$rs = $this->db->where("id_profile", $id)->delete("tbl_profile");
	return $rs;	
}

public function valid_profile($id)
{
	$rs = $this->db->select("id_profile")->where("id_profile", $id)->get("user");
	if($rs->num_rows() > 0 )
	{
		return true;
	}else{
		return false;
	}
}


public function clear_profile($id)
{
	$rs = $this->db->where("id_profile", $id)->delete("tbl_access");
	return $rs;
}

public function valid_name($name, $id="")
{
	if($id !="" )
	{
		$rs = $this->db->where("id_profile !=", $id)->where("profile_name", $name)->get("tbl_profile");
	}else{
		$rs = $this->db->where("profile_name", $name)->get("tbl_profile");
	}
	if($rs->num_rows() > 0 )
	{
		return true;
	}else{
		return false;
	}	
}




	
}/// Endclass


?>