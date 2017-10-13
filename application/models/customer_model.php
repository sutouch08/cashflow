<?php
class Customer_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function count_row()
	{
		return $this->db->count_all("tbl_customer");
	}
	
	public function get_data($id="", $perpage= 20, $limit = 1)
	{
		if($id != "" )
		{
			$rs = $this->db->where("id", $id)->get("tbl_customer");
		}else{
			$rs = $this->db->limit($perpage, $limit)->get("tbl_customer");
		}
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}	
	
	public function add_customer($data)
	{
		$rs = $this->db->insert("tbl_customer", $data);
		return $rs;
	}
	
	public function update($id, $data)
	{
		$rs = $this->db->where("id", $id)->update("tbl_customer", $data);
		return $rs;
	}
	
	public function delete_customer($id)
	{
		$rs = $this->db->where("id",$id)->delete("tbl_customer");
		return $rs;
	}
	
	
	
}/// end class

?>