<?php
class Permit_ac extends CI_Controller
{

public $id_menu	= 11;
public $layout		= "include/template";
public $title			= "กำหนดสิทธิ์ การทำงานกับบัญชีธนาคาร";
public $home;

public function __construct()
{
	parent:: __construct();
	$this->home 	= base_url()."permit_ac";
	$this->load->model("permit_model");
}

public function index()
{
	$data['data']		= $this->permit_model->get_user();
	$data['view']		= "permit_ac_view";
	go_to($data);	
}

public function set_permission($id_user)
{
	if( $this->input->post("edit") )
	{
		if( $this->verify->validate($this->id_menu, "edit") )
		{
			$book		= $this->input->post("id_bank_ac");
			$view		= $this->input->post("view");
			$add		= $this->input->post("add");
			$edit		= $this->input->post("edit");
			$delete	= $this->input->post("delete");
			foreach($book as $id)
			{
				$data['view']		= (isset($view[$id]) ? 1 : 0 );
				$data['add']		= (isset($add[$id]) ? 1 : 0 );
				$data['edit']		= (isset($edit[$id]) ? 1 : 0 );
				$data['delete']	= (isset($delete[$id]) ? 1 : 0 );
				$this->permit_model->update_ac_permission($id_user, $id, $data);
			}
			setMessage("กำหนดค่าเรียบร้อย");
			redirect($this->home);
		}else{
			action_deny();
		}
		
	}else{
		$this->permit_model->update_ac_permit($id_user);
		$data['data'] = $this->permit_model->get_ac_permission($id_user);
		$data['view']	= "permit_ac_edit_view";
		$data['user_name']	= user_name($id_user);
		$data['id_user']		= $id_user;
		$data['id_profile']	= $this->session->userdata('id_profile');
		go_to($data);
	}
}
	
}/// end class

?>