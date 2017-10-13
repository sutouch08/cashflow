<?php
class Company extends CI_Controller
{
public $home;
public $id_menu	= 7;
public $layout		= "include/template";
public $title			= "เพิ่ม/แก้ไข ชื่อบริษัท";

public function __construct()
{
	parent::__construct();
	$this->home 	= base_url()."company";
	$this->load->model("company_model");
}

public function index()
{
	$rs			= $this->company_model->get_data();
	$data['id_menu']	= $this->id_menu;
	$data['title']			= $this->title;
	$data['view']			= "company_view";
	$data['data']			= $rs;
	$this->load->view($this->layout, $data);
}

public function add()
{
	if( $this->input->post("add") )
	{
		if( $this->verify->validate($this->id_menu, "add") )
		{
			$data['company_name'] 	= $this->input->post("company_name");
			$data['active']				= $this->input->post("active");
			$data['date_add']			= date("Y-m-d H:i:s");
			$rs = $this->company_model->add_company($data);
			if($rs)
			{
				setMessage("เพิ่มชื่อบริษัทเรียบร้อยแล้ว");
			}else{
				setError("เพิ่มชื่อบริษัทไม่สำเร็จ");
			}
			redirect($this->home);
		}else{
			action_deny();
		}
	}else{
		$data['id_menu']	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "company_add_view";
		$this->load->view($this->layout, $data);
	}		
}
	

public function edit($id)
{
	if( $this->input->post("edit") )
	{
		if( $this->verify->validate($this->id_menu, "edit") )
		{
			$data['company_name']	= $this->input->post("company_name");
			$data['active']				= $this->input->post("active");
			$rs	= $this->company_model->update($id, $data);
			if($rs)
			{
				setMessage("ปรับปรุงข้อมูลเรียบร้อยแล้ว");
			}else{
				setError("ปรับปรุงข้อมูลไม่สำเร็จ");
			}
			redirect($this->home);
		}else{
			action_deny();
		}
	}else{
		$data['id_menu']	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "company_edit_view";
		$data['data']			= $this->company_model->get_data($id);
		$this->load->view($this->layout, $data);
	}	
}

public function delete($id)
{
	if( $this->verify->validate($this->id_menu, "delete") )
	{
		if( $this->company_model->valid_transection($id) )
		{
			setError("ไม่สามารถลบชื่อบริษัทได้เนื่องจากมีการอ้างถึงในรายการบัญชีธนาคาร");
		}else{
			if( $this->company_model->delete_company($id) )
			{
				setMessage("ลบรายการเรียบร้อยแล้ว");
			}else{
				setError("ลบรายการไม่สำเร็จ");
			}
		}
		redirect($this->home);
	}else{
		action_deny();	
	}
}

public function valid_name($name, $id="")
{
	$rs = $this->company_model->valid_name(urldecode($name), $id);
	if($rs)
	{
		echo 1; /// Duplicate
	}else{
		echo 0; // not duplicate
	}
}
	
}/// End class

?>