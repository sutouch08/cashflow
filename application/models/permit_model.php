<?php
class Permit_model extends CI_Model
{

public function __construct()
{
	parent:: __construct();
}

public function get_permission($id_profile)
{
	$rs = $this->db->where("id_profile", $id_profile)->get("tbl_access");
	if($rs->num_rows() > 0)
	{
		return $rs->result();
	}else{
		return false;
	}
}

public function get_menu($id = "")
{
	if($id !="")
	{
		$rs = $this->db->where("id_menu", $id)->get("tbl_menu");	
	}else{
		$rs = $this->db->get("tbl_menu");
	}
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}else{
		return false;
	}	
}

public function add_tab($data)
{
	$rs = $this->db->insert("tbl_access", $data);
	return $rs;
}

public function update_menu($id_profile)
{
	$tabs = $this->get_menu();
	foreach($tabs as $rd)
	{
		if(!$this->is_in($rd->id_menu, $id_profile) )
		{
			$data['id_profile']	= $id_profile;
			$data['id_menu']	= $rd->id_menu;
			$this->add_tab($data);
		}
	}
	return true;	
}

public function update($id, $data)
{
	$rs = $this->db->where("id_access", $id)->update("tbl_access", $data);
	return $rs;	
}

public function is_in($id_menu, $id_profile)
{
	$rs = $this->db->select("id_access")->where("id_menu", $id_menu)->where("id_profile", $id_profile)->get("tbl_access");
	if($rs->num_rows() > 0 )
	{
		return $rs->row()->id_access;
	}else{
		return false;
	}
}


public function delete_permission($id_profile)
{
	$rs = $this->db->where("id_profile", $id_profile)->delete("tbl_access");
	return $rs;
}
///***********************************   ส่วนนี้สำหรับใช้กับ กำหนดสิทธิ์ตามสมุดบัญชี  **********************************//

public function get_ac_permission($id_user)
{
	$rs = $this->db->where("id_user", $id_user)->get("tbl_ac_access");
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}else{
		return false;
	}
}

public function get_user($id="")
{
	if($id != "" )
	{
		$rs = $this->db->where("id_user", $id)->get("user");	
	}else{
		$rs = $this->db->get("user");
	}
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}else{
		return false;
	}
}

private function isin($id_user, $id_bank_ac)
{
	$rs = $this->db->select("id")->where("id_user", $id_user)->where("id_bank_ac", $id_bank_ac)->get("tbl_ac_access");
	if($rs->num_rows() > 0 )
	{
		return $rs->row()->id;
	}else{
		return false;
	}
}

public function get_account_ac()
{
	$rs = $this->db->get("tbl_bank_ac");
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}else{
		return false;
	}
}
		
	
public function update_ac_permit($id_user)
{
	$account 	= $this->get_account_ac();
	if( $account !== FALSE )
	{
		foreach($account as $rs)
		{
			if( !$this->isin($id_user, $rs->id_bank_ac) )
			{
				$data['id_user']		= $id_user;
				$data['id_bank_ac']	= $rs->id_bank_ac;
				$this->db->insert("tbl_ac_access", $data);
			}
		}
	}
	return true;
}


public function update_ac_permission($id_user, $id_bank_ac, $data)
{
	$rs = $this->db->where("id_user", $id_user)->where("id_bank_ac", $id_bank_ac)->update("tbl_ac_access", $data);
	return $rs;	
}
	
	
public function delete_ac_permission($id_user)
{
	$rs = $this->db->where("id_user", $id_user)->delete("tbl_ac_access");
	return $rs;
}


}/// end class
?>