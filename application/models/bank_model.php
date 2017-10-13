<?php
class Bank_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_data($id = "")
	{
		if($id != "")
		{
			$rs = $this->db->where("id_bank", $id)->get("tbl_bank");	
		}else{
			$rs = $this->db->get("tbl_bank");
		}
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function add_bank($data)
	{
		$rs = $this->db->insert("tbl_bank", $data);
		return $rs;	
	}
	
	
	public function update($id, $data)
	{
		$rs = $this->db->where("id_bank", $id)->update("tbl_bank", $data);
		return $rs;
	}
	
	public function delete_bank($id)
	{
		$rs = $this->db->where("id_bank", $id)->delete("tbl_bank");
		return $rs;
	}
	
	
	
	public function valid_transection($id)
	{
		$rs = $this->db->where("id_bank", $id)->get("tbl_cash_flow");
		if($rs->num_rows() >0)
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
			$rs = $this->db->where("bank_name", $name)->where("id_bank !=", $id)->get("tbl_bank");
		}else{
			$rs = $this->db->where("bank_name", $name)->get("tbl_bank");
		}
		if($rs->num_rows() >0)
		{
			return true;
		}else{
			return false;
		}
	}
	
}// End class

?>