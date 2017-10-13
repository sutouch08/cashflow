<?php
class Repay extends CI_Controller
{
public $id_menu	= 13;
public $title			= "จ่ายชำระตั๋วกู้";
public $layout		= "include/template";
public $home;

public function __construct()
{
	parent:: __construct();
	$this->home = base_url()."repay";
	$this->load->model("repay_model");
	$this->load->model("loan_model");
}

public function go_to($data)
{
	$data['id_menu']	= $this->id_menu;
	$data['title']			= $this->title;
	$this->load->view($this->layout, $data);	
}

public function index()
{
	$data['data']		= $this->	loan_model->get_loan_ac();
	$data['view']		= "repay_view";
	$data['id_menu'] = $this->id_menu;
	$data['title']		= $this->title;
	$this->load->view($this->layout, $data);
}

public function view($id_bank_ac)
{
	if( $this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "view") )
	{
		$row							= $this->repay_model->count_row($id_bank_ac);
		$perpage					= getConfig("PER_PAGE");
		$segment					= 4;
		$config						= pagination_config($this->home."/view/".$id_bank_ac."/", $row, $perpage, $segment); /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$data['data'] 				= $this->repay_model->get_data( "", $id_bank_ac, $perpage, $this->uri->segment($segment) );
		$data['view']					= "repay_search_view";
		$data['id_menu']			= $this->id_menu;
		$data['title']					= bank_ac_detail($id_bank_ac);
		$data['id_bank_ac']		= $id_bank_ac;
		$data['ref']					= $this->repay_model->get_reference($id_bank_ac);
		$this->pagination->initialize($config);
		$this->load->view($this->layout, $data);	
		
	}else{
		access_deny();	
	}
}

public function search($id_bank_ac)
{
	if( $this->input->post("reference") || $this->input->post("from_date") || $this->input->post("to_date") )
	{
		$reference = $this->input->post("reference");
		$from_date = $this->input->post('from_date') ? thaiDate_to_dbDate($this->input->post("from_date"), false) : '' ;
		$to_date		= $this->input->post("to_date") ? thaiDate_to_dbDate($this->input->post("to_date"), false) : '' ;
		$cookie = array('name'=>'from_date', 'value'=>$from_date, 'expire'=>3600);
		$this->input->set_cookie($cookie);	
		$cookie = array('name'=>'to_date', 'value'=>$to_date, 'expire'=>3600);
		$this->input->set_cookie($cookie);		
		$cookie = array('name'=>'reference', 'value'=>$reference, 'expire'=>3600);
		$this->input->set_cookie($cookie);	
						
	}else{	
		$reference 	= $this->input->cookie("reference");
		$from_date 	= $this->input->cookie("from_date") ? $this->input->cookie("from_date") : '' ;
		$to_date 	= $this->input->cookie("to_date") ? $this->input->cookie("to_date") : '' ;
	}
	$row							= $this->repay_model->count_search_row($id_bank_ac, $reference, $from_date, $to_date);
	$perpage					= getConfig("PER_PAGE");
	$segment					= 4;
	$config						= pagination_config($this->home."/search/".$id_bank_ac."/", $row, $perpage, $segment); /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
	$data['data'] 				= $this->repay_model->get_search($id_bank_ac, $reference, $from_date, $to_date, $perpage, $this->uri->segment($segment) );
	$data['reference']			= $reference;
	$data['from_date']			= $from_date;
	$data['to_date']				= $to_date;
	$data['view']					= "repay_add_view";
	$data['id_menu']			= $this->id_menu;
	$data['title']					= bank_ac_detail($id_bank_ac);
	$data['id_bank_ac']		= $id_bank_ac;
	$data['id_bank']				= get_id_bank_by_ac($id_bank_ac);
	$data['search']				= true;
	$data['ref']					= $this->repay_model->get_reference($id_bank_ac);
	$data['ac_list']				= $this->loan_model->get_loan_ac();
	$this->pagination->initialize($config);
	$this->load->view($this->layout, $data);			
}

public function clear_filter($id_bank_ac)
{
	$cookie = array('name'=>'detail', 'value'=>'', 'expire'=>'');
	$this->input->set_cookie($cookie);
	$cookie = array('name'=>'reference', 'value'=>'', 'expire'=>'');
	$this->input->set_cookie($cookie);
	$cookie = array('name'=>'from_date', 'value'=>'', 'expire'=>'');
	$this->input->set_cookie($cookie);
	$cookie = array('name'=>'to_date', 'value'=>'', 'expire'=>'');
	$this->input->set_cookie($cookie);
	redirect($this->home."/add/".$id_bank_ac);
}




public function add($id_bank_ac)
{
	if( $this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "add") || $this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "edit") )
	{
		$row							= $this->repay_model->count_row($id_bank_ac);
		$segment				 	= 4;
		$perpage					= getConfig("PER_PAGE");
		$config						= pagination_config($this->home."/add/".$id_bank_ac."/", $row, $perpage, $segment);  /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$rs 							= $this->repay_model->get_data("",$id_bank_ac, $perpage, $this->uri->segment($segment));
		$data['data']					= $rs;
		$data['view']					= "repay_add_view";
		$data['id_bank_ac']		= $id_bank_ac;
		$data['id_bank']				= get_id_bank_by_ac($id_bank_ac);
		$data['ref']					= $this->repay_model->get_reference($id_bank_ac);
		$data['ac_list']				= $this->loan_model->get_loan_ac();
		$this->pagination->initialize($config);
		$this->go_to($data);	
	}else{
		access_deny();
	}
}

public function add_row()
{
	if( $this->input->post("id_bank_ac") )
	{	
		$id_bank_ac	= $this->input->post("id_bank_ac");
		$em_name		= employee_name_by_user($this->session->userdata("id_user"));
		$reference		= $this->input->post("reference");
		$id_loan			= $this->repay_model->get_loan_id_by_reference($reference);
		$amount			= $this->input->post("amount");
		if($this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "add") )
		{
			$date_add 					= thaiDate_to_dbDate($this->input->post("date_add"), false);			
			$data['id_bank_ac']		= $id_bank_ac;
			$data['id_loan']				= $id_loan;
			$data['reference']			= $reference;
			$data['amount']				= $this->input->post("amount");
			$data['date_add']			= $date_add;
			$data['remark']				= $this->input->post("remark");
			$data['employee_add'] 	= $em_name;
			$data['employee_upd'] 	= "";
			$data['color']				= "";
			$rs = $this->repay_model->add_row($data);
			if($rs)		/// ถ้าเพิ่มสำเร็จ
			{
				$this->repay_model->update_paid($id_loan, $amount);
				$this->load->model("account_model");
				$book = $this->account_model->is_in_book($id_bank_ac);
				if( $book !=0 )
				{
					$datax['id_repay']			= $rs;
					$datax['id_bank']			= get_bank_id($book);
					$datax['id_bank_ac']		= $book;
					$datax['detail']				= "จ่ายคืนตั๋ว";
					$datax['reference']		= $reference;
					$datax['cash_out']			= $amount;
					$datax['due_date']			= $date_add;
					$datax['employee_add']	= get_id_employee_by_user($this->session->userdata("id_user"));
					$this->add_to_flow($datax);
				}
				//// จัด format ใหม่ ก่อนส่งไปแสดงผลหน้าจอ
				$data['date_add'] 	= thaiDate($data['date_add'], false);
				$data['amount']		= number_format($data['amount'],2);
				echo json_encode($data);
			}else{
				echo "error";
			}		
		}else{
			echo "error";
		}
	}else{
		echo "error";
	}
}

public function delete_row($id)
{
	$data = $this->repay_model->get_data($id,"");
	$amount = $data['amount'];
	$id_loan	= $data['id_loan'];
	$id_cash_flow = $this->repay_model->get_id_cash_flow($id);
	$rs = $this->repay_model->delete_row($id);
	if($rs)
	{
		$amount = $amount * -1;
		$this->repay_model->update_paid($id_loan, $amount);
		$this->delete_from_flow($id_cash_flow);
		echo "success";
	}else{
		echo "fail";
	}
}

public function delete_from_flow($id_cash_flow)
{
	$this->load->model("flow_model");
	$dx 			= $this->flow_model->get_data($id_cash_flow, "");
	$cash_in 	= 0;
	$cash_out 	= 0;
	$balance 	= 0;
	$is_in 		= 0;
	if($dx){
		foreach( $dx as $rd )
		{
			$id_bank_ac 	= $rd->id_bank_ac;
			$cash_in 		= $rd->cash_in;
			$cash_out 		= $rd->cash_out;
			$balance  		= $rd->balance;	
			$is_in				= $rd->is_in;
			$date 			= $rd->due_date;
			$pos				= $rd->position;
		}
		$od	= $this->flow_model->od_budget($id_bank_ac);
		if($is_in)
		{
			$amount = $cash_in * -1;  /// ถ้าเป็นยอดรับเข้า ให้เอายอดรับเข้า * -1 เพื่อทำให้เป็นยอดติดลบแล้วเอาไปบวกกลับเพื่อลดจำนวน
		}else{
			$amount = $cash_out;
		}
		if($this->flow_model->delete_row($id_cash_flow))
		{
			$rx = $this->flow_model->get_effected_delete_row($id_cash_flow, $date, $id_bank_ac, $pos);
			if($rx)
			{
				foreach($rx as $rs )
				{
	
						$balancex 	= $rs->balance + $amount;
						$od_balance	= $od + $balancex;
						$datax['balance']	= 	$balancex;
						$datax['od_balance'] = $od_balance;
						$this->flow_model->update_balance($rs->id_cash_flow, $datax);
				}
			}
			$this->flow_model->update_position($id_bank_ac, $date);
			$result = "success";
		}
	}
}

public function add_to_flow($data)
{
	$this->load->model("flow_model");
	$date 			= $data['due_date'];
	$id_bank_ac 	= $data['id_bank_ac'];
	$od 				= $this->flow_model->od_budget($id_bank_ac);
	$is_in 			= 0; 
	$balance 		= $this->flow_model->get_last_balance($id_bank_ac, $date) - $data['cash_out'];
	$od_balance 	= $od + $balance;
	$position 		= $this->flow_model->max_position($id_bank_ac, $date) + 1;
	$data['cash_in']			= 0.00;
	$data['balance']			= $balance;
	$data['od_balance']	= $od_balance;
	$data['is_in']				= $is_in;
	$data['move_type']		= "ตัดบัญชี";
	$data['move_reference']	= "";
	$data['date_add']			= now();
	$data['remark']				= "";
	$data['position']				= $position;
	$rs = $this->flow_model->add_row($data);
	if($rs) /// ถ้าเพิ่มสำเร็จ
	{
		$rd = $this->flow_model->get_effected_row($id_bank_ac, $date) ; /// ตรวจสอบรายการที่มีผลกระทบกับการเพิ่ม
		if($rd) /// ถ้ามีรายการที่กระทบ ให้ทำการปรับปรุงยอดคงเหลือ
		{
			foreach($rd as $rm)
			{
				if( $is_in)
				{
					$balancex 			= $rm->balance + $this->input->post("cash_in");
					$od_balancex		= $od + $balancex;
				}else{
					$balancex			= $rm->balance - $this->input->post("cash_out");
					$od_balancex		= $od + $balancex;
				}
				$datax['balance']	= 	$balancex;
				$datax['od_balance'] = $od_balancex;
				$this->flow_model->update_balance($rm->id_cash_flow, $datax);
			}
		}
	}	
}

public function change_color($id)
{
	$data['color'] = $this->input->post("color");
	if($this->repay_model->change_color($id, $data) )
	{
		echo "success"; 
	}else{
		echo "fail";
	}
}
	
}/// 


?>