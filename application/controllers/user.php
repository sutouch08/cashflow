<?php
class User extends CI_Controller
{
	public $id_menu 	= 4;
	public $layout 		= "include/template";
	public $title 			= "เพิ่ม/แก้ไข ชื่อผู้ใช้งาน";
	public $home;
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."user";
		$this->load->model("user_model");	
	}
	
	public function index()
	{
		$rs = $this->user_model->get_data();
		$data['id_menu'] 	= $this->id_menu;
		$data['title']			= $this->title;
		$data['data']			= $rs;
		$data['view']			= "user_view";
		$this->load->view($this->layout, $data);			
	}
	
	public function add()
	{
		if( $this->input->post("add") )
		{
			if( $this->verify->validate($this->id_menu, "add") )
			{
				$data['id_employee'] 	= $this->input->post("employee");
				$data['id_profile']		= $this->input->post("profile");
				$data['user_name']		= $this->input->post("user_name");
				$data['password']		= md5( $this->input->post("password") );
				$data['active']			= $this->input->post("active");
				$data['last_login']		= "00-00-00 00:00:00";
				$rs = $this->user_model->add_user($data);
				if($rs)
				{
					setMessage("เพิ่มชื่อผู้ใช้งานเรียบร้อยแล้ว");
				}else{
					setError("เพิ่มชื่อผู้ใช้งานไม่สำเร็จ");
				}
				redirect($this->home);				
			}else{
				action_deny();	
			}
		}else{
			$data['id_menu'] 	= $this->id_menu;
			$data['title']			= $this->title;
			$data['view']			= "user_add_view";
			$this->load->view($this->layout, $data);
		}
	}
	
	
	public function edit($id)
	{
		if( $this->input->post("edit") )
		{
			if( $this->verify->validate($this->id_menu, "edit") )
			{
				$data['id_employee'] 	= $this->input->post("employee");
				$data['id_profile']		= $this->input->post("profile");
				$data['active']			= $this->input->post("active");
				$rs = $this->user_model->update_user($id, $data);
				if($rs)
				{
					setMessage("ปรับปรุงข้อมูลเรียบร้อยแล้ว");
				}else{
					setError("ปรับปรุงข้อมูลผู้ใช้งานไม่สำเร็จ");
				}
				redirect($this->home);				
			}else{
				action_deny();	
			}
			
		}else{
			$rs 					= $this->user_model->get_data($id);
			$data['id_menu']	= $this->id_menu;
			$data['title']			= $this->title;
			$data['view']			= "user_edit_view";
			$data['data']			= $rs;
			$this->load->view($this->layout, $data);				
		}
	}
	
	public function delete($id)
	{
		if( $this->verify->validate($this->id_menu, "delete") )
		{
			$rs = $this->user_model->delete_user($id);
			if($rs)
			{
				$this->load->model("permit_model");
				$this->permit_model->delete_ac_permission($id);
				setMessage("ลบผู้ใช้งานเรียบร้อยแล้ว");
			}else{
				setError("ลบผู้ใช้งานไม่สำเร็จ");
			}
			redirect($this->home);			
		}else{
			action_deny();
		}		
	}
	
	public function reset_password($id)
	{
		if( $this->input->post("reset_password") )
		{
			if( $this->verify->validate($this->id_menu, "edit") )
			{
				$data['password']		= md5($this->input->post("password")	);
				$rs = $this->user_model->change_password($id, $data);
				if($rs)
				{
					setMessage("เปลี่ยนรหัสผ่านเรียบร้อยแล้ว");
				}else{
					setError("เปลี่ยนรหัสผ่านไม่สำเร็จ");
				}
				redirect($this->home);
			}else{
				action_deny();
			}
		}else{
			$rs = $this->user_model->get_data($id);
			$data['id_menu']	= $this->id_menu;
			$data['title']			= "เปลี่ยนรหัสผ่าน";
			$data['data']			= $rs;
			$data['view']			= "user_reset_password";
			$this->load->view($this->layout, $data);	
		}
	}
	
	public function valid_user($user_name, $id = "")
	{
		if($this->user_model->valid_user(urldecode($user_name), $id) )
		{
			echo 1; // ซ้ำ
		}else{
			echo 0; // ไม่ซ้ำ
		}
	}

}/// end class
?>