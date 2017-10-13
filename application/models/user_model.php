<?php
class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();	
	}
	
	public function get_data($id = "")
	{
		if($id != "")
		{
			$rs = $this->db->where("id_user", $id)->get("user");	
		}else{
			$rs = $this->db->get("user");
		}
		if( $rs->num_rows() > 0 )
		{
			return $rs->result();
		}else{
			return false;
		}			
	}
	
	public function add_user($data)
	{
		$rs = $this->db->insert("user", $data);
		return $rs;
	}
	
	public function update_user($id, $data)
	{
		$rs = $this->db->where("id_user", $id)->update("user", $data);
		return $rs;
	}	
	
	public function delete_user($id)
	{
		$rs = $this->db->where("id_user", $id)->delete("user");
		return $rs;	
	}
	
	public function change_password($id, $data)
	{
		$rs = $this->db->where("id_user", $id)->update("user", $data);
		return $rs;	
	}
	
	public function disabled_user($id)
	{
		$rs = $this->db->where("id_user", $id)->update("user", array("active"=>0) );
		return $rs;	
	}
	
	public function valid_user($user_name, $id = "")
	{
		if($id !=""){
			$rs = $this->db->select("user_name")->where("user_name", $user_name)->where("id_user !=", $id)->get("user");
		}else{
			$rs = $this->db->select("user_name")->where("user_name", $user_name)->get("user");
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