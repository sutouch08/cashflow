<?php
class index extends CI_Controller
{
public $home;
public $layout = "include/template";
public $title = "Dash Board";
public $id_menu	= 0;
public function __construct()
{
	parent::__construct();
	$this->home		= base_url()."index";
	$this->load->model("account_model");
}

public function go_to($data)
{
	$data['id_menu']	= $this->id_menu;
	$data['title']			= $this->title;
	$this->load->view($this->layout, $data);	
}
public function index()
{
	$data['data']		= $this->account_model->get_data();
	$data['view']			=  "main_view";
	$this->go_to($data);
}

}// End class
		
	
?>