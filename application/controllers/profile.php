<?php
class Profile extends CI_Controller
{

public $id_menu	= 8;
public $layout		= "include/template";
public $title			= "เพิ่ม/แก้ไข โปรไฟล์";
public $home; 

public function __construct()
{
	parent:: __construct();
	$this->home		= base_url()."profile";
	$this->load->model("profile_model");	
}

public function index()
{
	$data['id_menu']	= $this->id_menu;
	$data['title']			= $this->title;
	$data['view']			= "profile_view";
	$data['data']			= $this->profile_model->get_data();
	$this->load->view($this->layout, $data);	
}

public function add()
{
	if( $this->input->post("add") )
	{
		if( $this->verify->validate($this->id_menu, "add") )
		{
			$data['profile_name']	= $this->input->post("profile_name");
			$rs = $this->profile_model->add_profile($data);
			if($rs)
			{
				setMessage("เพิ่มโปรไฟล์เรียบร้อยแล้ว");
			}else{
				setError("เพิ่มโปรไฟล์ไม่สำเร็จ");
			}
			redirect($this->home);
		}else{
			action_deny();	
		}
	}else{
		$data['id_menu']	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "profile_add_view";
		$this->load->view($this->layout, $data);	
	}
}

public function edit($id)
{
	if( $this->input->post("edit") )
	{
		if( $this->verify->validate($this->id_menu, "edit") )
		{
			$data['profile_name']	= $this->input->post("profile_name");
			$rs = $this->profile_model->update($id, $data);
			if($rs)
			{
				setMessage("ปรับปรุงโปรไฟล์เรียบร้อยแล้ว");
			}else{
				setError("ปรับปรุงโปรไฟล์ไม่สำเร็จ");
			}
			redirect($this->home);
		}else{
			action_deny();	
		}
	}else{
		$data['id_menu']	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "profile_edit_view";
		$data['data']			= $this->profile_model->get_data($id);
		$this->load->view($this->layout, $data);		
	}
}
	
public function delete($id)
{
	if( $this->verify->validate($this->id_menu, "delete") )
	{
		if( $this->profile_model->valid_profile($id) )
		{
			setError("ไม่สามารถลบโปรไฟล์นี้ได้เนื่องจากยัง ชื่อผู้ใช้งานโปรไฟล์นี้อยู่");
		}else{
			$rs = $this->profile_model->delete_profile($id);
			if($rs)
			{
				$rd = $this->profile_model->clear_profile($id); //// ลบ รายการ ที่ใช้โปรไฟล์นี้ ในตาราง tbl_access;
				setMessage("ลบโปรไฟล์เรียบร้อยแล้ว");
			}else{
				setError("ลบโปรไฟล์ไม่สำเร็จ");
			}
		}
		redirect($this->home);
	}else{
		action_deny();	
	}
}

public function valid_name($name, $id="")
{
	$rs = $this->profile_model->valid_name(urldecode($name), $id);
	if($rs)
	{
		echo 1; //ซ้ำ
	}else{
		echo 0; //ไม่ซ้ำ
	}
}
	
}// End class

?>