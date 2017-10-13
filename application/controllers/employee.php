<?php

class Employee extends CI_Controller
{
	public $home;
	public $layout = "include/template";
	public $id_menu = 3;
	public $title = "เพิ่ม/แก้ไข พนักงาน";
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->model("employee_model");
		$this->home = base_url()."employee";
	}
	
	public function index()
	{
		$rs = $this->employee_model->get_data();
		$data['id_menu'] 	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "employee_view";
		$data['data'] 		= $rs;	
		$this->load->view($this->layout, $data);
	}
	
	public function quiter()
	{
		$rs = $this->employee_model->get_data();
		$data['id_menu'] 	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "employee_quit_view";
		$data['data'] 		= $rs;	
		$this->load->view($this->layout, $data);
	}
	
	public function add()
	{
		if( $this->input->post("add") )
		 {
			 $data['first_name'] = $this->input->post("fname");
			 $data['last_name'] = $this->input->post("lname");
			 $data['active']		= $this->input->post("active");
			 if( $this->verify->validate($this->id_menu, "add") )
			 {
				 $rs = $this->employee_model->add_employee($data);
				 if($rs)
				 {
					 setMessage("เพิ่ม 1 รายการ สำเร็จ");
				 }else{
					 setError("เพิ่มรายการไม่สำเร็จ");
				 }
				 redirect($this->home);				 
			 }else{
				action_deny();
			 }
		 }else{
			 $data['id_menu'] = $this->id_menu;
			 $data['title'] = $this->title;
			 $data['view'] = "employee_add_view";
			 $this->load->view($this->layout, $data);		 
		 }	
	}
	
	public function edit($id)
	{
		if( $this->input->post("edit") )
		{
			$data['first_name']		= $this->input->post("fname");
			$data['last_name']		= $this->input->post("lname");
			$data['active']			= $this->input->post("active");
			$data['is_quit']			= $this->input->post("is_quit");
			if( $this->verify->validate($this->id_menu, "edit") )
			{
				$rs = $this->employee_model->update($id, $data);
				if($rs)
				{
					setMessage("ปรับปรุงข้อมูลเรียบร้อย");
				}else{
					setError("ปรับปรุงข้อมูลไม่สำเร็จ");
				}
				redirect($this->home);
			}else{
				action_deny();	
			}
		}else{
			$rs 					= $this->employee_model->get_data($id);
			$data['data']			= $rs;
			$data['id_menu']	= $this->id_menu;
			$data['title']			= $this->title;
			$data['view'] 		= "employee_edit_view";
			$this->load->view($this->layout, $data);	
		}
	}
	
	public function delete($id)
	{
		if( $this->verify->validate($this->id_menu, "delete") )
		{
			$rs = $this->employee_model->delete_employee($id);
			if($rs)
			{
				setMessage("ลบพนักงานเรียบร้อยแล้ว");
			}else{
				setError("ลบพนักงานไม่สำเร็จ");
			}
			redirect($this->home."/quiter");
		}else{
			action_deny();
		}
	}
	
	public function valid_employee($first_name, $last_name, $id = "")
	{
		if($this->employee_model->valid_employee(urldecode($first_name), urldecode($last_name), $id) )
		{
			echo 1; // ซ้ำ
		}else{
			echo 0; // ไม่ซ้ำ
		}
	}
	
}// end class
?>