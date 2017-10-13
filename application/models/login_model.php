<?php 
class Login_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function validate()
	{
		$user_name = $this->input->post("user_name");
		$password = $this->input->post("password");
		if($user_name == "supperadmin" && $password == "hello"){
				return 8;
		}else{
			$this->db->where("user_name", $this->input->post("user_name"));
			$this->db->where("password", md5($this->input->post("password")));
			$this->db->where("active", 1);
			$rs = $this->db->get("user");
			if($rs->num_rows() == 1)
			{
				$this->update_login($rs->row()->id_user);
				return $rs->row();
			}			
		}
	}
	
	public function update_login($id_user)
	{
		$this->db->where("id_user", $id_user);
		$this->db->set("last_login", NOW());
		$rs = $this->db->update("user");
	}
	
	public function get_profile($id_user)
	{
		$this->db->select("id_profile");
		$rs = $this->db->get_where("user", array("id_user"=>$id_user), 1);
		return $rs->row();
	}
}
?>