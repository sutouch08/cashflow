<?php
class Account extends CI_Controller
{
public $id_menu		= 2;
public $layout			= "include/template";
public $title				= "เพิ่ม/แก้ไข บัญชีธนาคาร";
public $home;

public function __construct()
{
	parent:: __construct();
	$this->home		= base_url()."account";
	$this->load->model("account_model");
}

public function index()
{
	$rs					= $this->account_model->get_data();
	$data['data']			= $rs;
	$data['id_menu']	= $this->id_menu;
	$data['title']			= $this->title;
	$data['view']			= "account_view";
	$this->load->view($this->layout, $data);
}

public function add()
{
	if( $this->input->post("add") )
	{
		if( $this->verify->validate($this->id_menu, "add") )
		{
			$int_date					= 0;
			$pay_in_date 			= $this->input->post("pay_in_date");
			$pay_date				= $this->input->post("pay_date");
			$int	= $this->input->post("int");
			if( $int == 2 ){ $int_date = $pay_in_date == "x" ? $pay_in_date : $pay_date; }
			$data['id_bank']			= $this->input->post("id_bank");
			$data['ac_code']		= $this->input->post("ac_code");
			$data['ac_number']		= $this->input->post("ac_number");
			$data['ac_name']		= $this->input->post("ac_name");
			$data['branch']			= $this->input->post("branch");
			$data['ac_type']		= $this->input->post("ac_type");
			$data['id_company']	= $this->input->post("id_company");
			$data['od_rate']			= $this->input->post("od_rate");
			$data['od_budget']		= $this->input->post("od_budget");
			$data['loan_budget']	= $this->input->post("loan_budget");
			$data['date_add']		= NOW();
			$data['active']			= $this->input->post("active");
			$data['int']				= $int;
			$data['int_date']			= $int_date;
			$data['int_cal']			= $this->input->post("int_cal");
			$data['in_book']			= $this->input->post("in_book");
			$rs = $this->account_model->add_account($data);
			if($rs)
			{
				setMessage("เพิ่มบัญชีธนาคารเรียบร้อย");
			}else{
				setError("เพิ่มบัญชีธนาคารไม่สำเร็จ");
			}
			redirect($this->home);
		}else{
			action_deny();	
		}
	}else{
		$data['id_menu']	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "account_add_view";
		$this->load->view($this->layout, $data);	
	}
}

public function edit($id)
{
	if( $this->input->post("edit") )
	{
		if( $this->verify->validate($this->id_menu, "edit") )
		{		
			$int_date					= 0;
			$pay_in_date 			= $this->input->post("pay_in_date");
			$pay_date				= $this->input->post("pay_date");
			$int	= $this->input->post("int");
			if( $int == 2 ){ $int_date = $pay_in_date == "x" ? $pay_in_date : $pay_date; }
			$budget					= $this->input->post("loan_budget");	
			$data['id_bank']			= $this->input->post("id_bank");
			$data['ac_code']		= $this->input->post("ac_code");
			$data['ac_number']		= $this->input->post("ac_number");
			$data['ac_name']		= $this->input->post("ac_name");
			$data['branch']			= $this->input->post("branch");
			$data['ac_type']		= $this->input->post("ac_type");
			$data['id_company']	= $this->input->post("id_company");
			$data['od_rate']			= $this->input->post("od_rate");
			$data['od_budget']		= $this->input->post("od_budget");
			$data['loan_budget']	= $budget;
			$data['active']			= $this->input->post("active");
			$data['int']				= $int;
			$data['int_date']			= $int_date;
			$data['int_cal']			= $this->input->post("int_cal");
			$data['in_book']			= $this->input->post("in_book");
			$rs = $this->account_model->update($id, $data);
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
		$rs					= $this->account_model->get_data($id);
		$data['data']			= $rs;
		$data['id_menu']	= $this->id_menu;
		$data['title']			= $this->title;
		$data['view']			= "account_edit_view";
		$this->load->view($this->layout, $data);
	}
}

public function delete($id)
{
	if( $this->verify->validate($this->id_menu, "delete") )
	{
		if($this->account_model->valid_transection($id) ) 
		{
			setError("ไม่สามารถลบบัญชีได้เนื่องจากมี ทรานเซ็กชั่นเกิดขึ้นแล้ว");
		}else{
			$rs = $this->account_model->delete_account($id);
			if($rs)
			{
				setMessage("ลบ 1 บัญชีเรียบร้อยแล้ว");
			}else{
				setError("ลบบัญชีไม่สำเร็จ");
			}
		}
		redirect($this->home);
	}else{
		action_deny();
	}
}

public function valid_ac_number($ac_number, $id_bank, $id="")
{
	$rs = $this->account_model->valid_account(urldecode($ac_number), $id_bank,  $id);
	if($rs){
		echo 1; //ซ้ำ
	}else{
		echo 0; // ไม่ซ้ำ
	}
}

public function valid_ac_code($ac_code, $id="")
{
	$rs = $this->account_model->valid_code(urldecode($ac_code), $id);
	if($rs){
		echo 1; //ซ้ำ
	}else{
		echo 0; // ไม่ซ้ำ
	}
}

}// End class
?>