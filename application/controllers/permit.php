<?php
class Permit extends CI_Controller
{
public $id_menu 	= 9;
public $layout		= "include/template";
public $title 			= "กำหนดสิทธิ์";
public $home;

public function __construct()
{
	parent:: __construct();
	$this->home		= base_url()."permit";
	$this->load->model("permit_model");
	$this->load->model("profile_model");
}

public function go_to($data)
{
	$data['id_menu']	= $this->id_menu;
	$data['title']			= $this->title;
	$this->load->view($this->layout, $data);
}

public function index()
{
	$rs = $this->profile_model->get_data();
	$data['data']		= $rs;
	$data['view']		= "permit_view";
	$this->go_to($data);		
}


public function edit($id_profile)
{
	if( $this->input->post("edit") )
	{
		$menus		= $this->input->post("menu");
		$view			= $this->input->post("view");
		$add		= $this->input->post("add");
		$edit			= $this->input->post("edit");
		$delete		= $this->input->post("delete");
		$print			= $this->input->post("print");
		$approve	= $this->input->post("approve");
		foreach($menus as $id)
		{
			$data['id_profile']	= $id_profile;
			$data['id_menu']	= $id;
			$data['view']			= (isset($view[$id]) ? 1 : 0 ); 
			$data['add']			= (isset($add[$id]) ? 1 : 0 );
			$data['edit']			= (isset($edit[$id]) ? 1 : 0 );
			$data['del']			= (isset($delete[$id]) ? 1 : 0 );
			$data['print']			= (isset($print[$id]) ? 1 : 0 );
			$data['approve']	= (isset($approve[$id]) ? 1 : 0 );
			$id_access = $this->permit_model->is_in($id, $id_profile);
			if($id_access)
			{	
				$this->permit_model->update($id_access, $data);
			}else{
				$this->permit_model->add_tab($data);
			}
		}
		setMessage("Successfull");
		redirect($this->home);
	}else{
		$this->permit_model->update_menu($id_profile);
		$rs = $this->permit_model->get_permission($id_profile);
		$data['profile_name'] 	 = profile_name($id_profile);
		$data['id_profile'] 		= $id_profile;
		$data['data']				= $rs;
		$data['view']				= "permit_edit_view";
		$this->go_to($data);	
	}
}

public function add_tabs($id_profile)
{
	$menus = $this->permit_model->get_menu();
	if($menus)
	{
		foreach($menus as $menu)
		{
			$data['id_profile']	= $id_profile;
			$data['id_menu']	= $menu->id_menu;
			$data['view']			= 0;
			$data['add']			= 0;
			$data['edit']			= 0;
			$data['del']			= 0;
			$data['print']			= 0;
			$data['approve']	= 0;
			$this->permit_model->add_tab($data);	
		}
		echo "success";
	}else{
		echo "fail";
	}
	
}

}/// end class

?>