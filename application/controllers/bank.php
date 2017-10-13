<?php
class Bank extends CI_Controller
{
	public $id_menu		= 1;
	public $home;
	public $layout			= "include/template";
	public $title				= "เพิ่ม/แก้ไข รายชื่อธนาคาร";
	
	public function __construct()
	{
		parent::__construct();
		$this->home		= base_url()."bank";
		$this->load->model("bank_model");
	}
	
	public function index()
	{
		$rs					= $this->bank_model->get_data();
		$data['data']			= $rs;
		$data['id_menu']	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "bank_view";
		$this->load->view($this->layout, $data);
	}
	
	
	public function add()
	{
		if($this->input->post("add"))
		{
			if( $this->verify->validate($this->id_menu, "add") )
			{
				$data['bank_name'] 	= $this->input->post("bank_name");
				$data['date_add']		= date("Y-m-d H:i:s");
				$rs = $this->bank_model->add_bank($data);
				if($rs)
				{
					setMessage("เพิ่มธนาคารเรียบร้อยแล้ว");
				}else{
					setError("เพิ่มธนาคารไม่สำเร็จ");
				}
				redirect($this->home);
			}else{
				action_deny();
			}
		}else{
			$data['id_menu']	= $this->id_menu;
			$data['title']			= $this->title;
			$data['view']			= "bank_add_view";
			$this->load->view($this->layout, $data);	
		}
	}
	
	public function edit($id)
	{
		if( $this->input->post("edit") )
		{
			if( $this->verify->validate($this->id_menu, "edit") )
			{
				$data['bank_name']	= $this->input->post("bank_name");
				$rs = $this->bank_model->update($id, $data);
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
			$rs 					= $this->bank_model->get_data($id);
			$data['data'] 		= $rs;
			$data['id_menu'] 	= $this->id_menu;
			$data['title']			= $this->title;
			$data['view']			= "bank_edit_view";
			$this->load->view($this->layout, $data);
				
		}
			
	}
	
	
	public function delete($id)
	{
		if( $this->verify->validate($this->id_menu, "delete") )
		{
			$rs = $this->bank_model->valid_transection($id);
			if($rs)
			{
				setError("ไม่สามารถธนาคารนี้ได้ เนื่องจากมี transection เกิดขึ้นแล้ว");
			}else{
				if( $this->bank_model->delete_bank($id) )
				{
					setMessage("ลบธนาคารเรียบร้อยแล้ว");
				}else{
					setError("ลบธนาคารไม่สำเร็จ");
				}
			}
			redirect($this->home);
		}else{
			action_deny();
		}
	}
	
	public function valid_name($name, $id="")
	{
		if($this->bank_model->valid_name(urldecode($name), $id) )
		{
			echo 1; /// ซ้ำ
		}else{
			echo 0; ///ไม่ซ้ำ
		}
	}
	
}// End class

?>