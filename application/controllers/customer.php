<?php
class Customer extends CI_Controller
{
public $id_menu			= 6;
public $title					= "เพิ่ม/แก้ไข ลูกค้า";
public $layout				= "include/template";
public $home;

public function __construct()
{
	parent:: __construct();
	$this->home		= base_url()."customer";
	$this->load->model("customer_model");
}
public function index()
{
	$row 						= $this->customer_model->count_row();
	$config 					= pagination_config($this->home."/index/", $row);
	$data['data']				= $this->customer_model->get_data("", $config['per_page'], $this->uri->segment($config['uri_segment']));
	$data['view']				= "customer_view";
	$this->pagination->initialize($config);
	$this->go_to($data);
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
			$rs = $this->customer_model->add_customer($data);
			if($rs)
			{
				setMessage("เพิ่มลูกค้าเรียบร้อยแล้ว");
			}else{
				setError("เพิ่มลูกค้าไม่สำเร็จ");
			}
			redirect($this->home);
		}else{
			action_deny();	
		}
	}else{			
		$data['id_menu']	= $this->id_menu;	
		$data['title']			= $this->title;
		$data['view']			= "customer_add_view";
		$this->load->view($this->layout, $data);
	}
}	

public function edit($id)
{
	if($this->input->post("edit"))
	{
		if( $this->verify->validate($this->id_menu, "edit") )
		{
			$data['name']	= $this->input->post("name");
			$rs = $this->customer_model->update($id, $data);
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
		$data['view']			= "customer_edit_view";
		$data['data']			= $this->customer_model->get_data($id);
		$this->load->view($this->layout, $data);	
	}
}


public function delete($id)
{
	if( $this->verify->validate($this->id_menu, "delete") )
	{
		if( $this->customer_model->delete_customer($id) )
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