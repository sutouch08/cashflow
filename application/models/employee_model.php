<?php
class Employee_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data($id = "")
	{
		if($id != "")
		{
			$rs = $this->db->where("id_employee", $id)->get("tbl_employee");
			if($rs->num_rows() == 1 )
			{
				return $rs->result();
			}else{
				return false;
			}
		}else{
			$rs = $this->db->get("tbl_employee");
			if($rs->num_rows() > 0)
			{
				return $rs->result();
			}else{
				return false;
			}
		}
	}
	
	
	public function add_employee($data)
	{
		$rs = $this->db->insert("tbl_employee", $data);
		return $rs;
	}
	
	public function update($id, $data)
	{
		$rs = $this->db->where("id_employee", $id)->update("tbl_employee", $data);
		return $rs;
	}
	
	
	public function delete_employee($id)
	{
		$rs = $this->db->where("id_employee", $id)->delete("tbl_employee");
		return $rs;	
	}
	
	public function valid_employee($first_name, $last_name, $id = "")
	{
		if($id !=""){
			$rs = $this->db->select("first_name")->where("first_name", $first_name)->where("last_name", $last_name)->where("id_employee !=", $id)->get("tbl_employee");
		}else{
			$rs = $this->db->select("first_name")->where("first_name", $first_name)->where("last_name", $last_name)->get("tbl_employee");
		}
		if($rs->num_rows() > 0)
		{
			return true;
		}else{
			return false;
		}		
	}
	
}//// End class
?>