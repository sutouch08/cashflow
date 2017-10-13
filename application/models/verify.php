<?php 
class Verify extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function validate($id_menu, $action)
	{
		if( $action == "delete"){  $action = "del"; }
		if($this->session->userdata("id_profile") == 0)
		{
			return true;
		}else{
			$this->db->select($action);
			$rs = $this->db->get_where("tbl_access", array("id_menu"=>$id_menu , "id_profile"=> $this->session->userdata("id_profile")), 1);
			$ro = $rs->row_array();
			if($ro[$action] == 1){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function valid_ac($id_user, $id_bank_ac, $action) /// ตรวจสอบสิทธิการทำงานกับ สมุดบัญชี
	{
		if( $this->session->userdata("id_profile") == 0 )
		{
			return true;
		}else{
			$rs = $this->db->select("id_bank_ac")->where("id_bank_ac", $id_bank_ac)->where("id_user", $id_user)->where($action, 1)->get("tbl_ac_access");
			if($rs->num_rows() > 0 )
			{
				return true;
			}else{
				return false;
			}
		}
	}
	
	
}/// end class
?>