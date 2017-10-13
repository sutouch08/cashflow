<?php
class Sup extends CI_Controller
{

public $id_menu		= 5;
public $layout			= "include/template";
public $title				= "เพิ่ม/แก้ไข ผู้ขาย";
public $home;

public function __construct()
{
	parent:: __construct();
	$this->home		= base_url()."sup";
	$this->load->model("sup_model");
}



public function index()
{
	$row		= $this->sup_model->count_row();
	$config	= pagination_config($this->home."/index/", $row);
	$data['data']				= $this->sup_model->get_data( "", $config['per_page'], $this->uri->segment( $config['uri_segment'] ) );
	$data['id_menu']		= $this->id_menu;
	$data['view']				= "sup_view";
	$data['title']				= $this->title;
	$this->pagination->initialize($config);
	$this->load->view($this->layout, $data);
		
}

public function go_to($data)  
{
	$data['id_menu']	= $this->id_menu;
	$data['title']			= $this->title;
	$this->load->view($this->layout, $data);
}

public function add()
{
	if( $this->input->post("add") )
	{
		if( $this->verify->validate($this->id_menu, "add") )
		{
			$data['name']	= $this->input->post("name");
			$rs = $this->sup_model->add_sup($data);
			if($rs)
			{
				setMessage("เพิ่มข้อมูลเรียบร้อยแล้ว");
			}else{
				setError("เพิ่มข้อมูลไม่สำเร็จ");
			}
			redirect($this->home);
		}else{
			action_deny();	
		}
	}else{
		$data['id_menu']	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "sup_add_view";
		$this->load->view($this->layout, $data);	
	}		
}


public function edit($id)
{
	if( $this->input->post("edit") )
	{
		if( $this->verify->validate($this->id_menu, "edit") )
		{
			$data['name']	= $this->input->post("name");
			$rs = $this->sup_model->update($id, $data);
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
		$data['view']			= "sup_edit_view";
		$data['data']			= $this->sup_model->get_data($id);
		$this->go_to($data);
	}
}


public function delete($id)
{
	if( $this->verify->validate($this->id_menu, "delete") )
	{
		if( $this->sup_model->delete_sup($id) )
		{
			setMessage("ลบข้อมูลเรียบร้อยแล้ว");
		}else{
			setError("ลบข้อมูลไม่สำเร็จ");
		}
		redirect($this->home);
	}else{
		action_deny();	
	}
	
}


	
}/// end class



?>