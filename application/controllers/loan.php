<?php
class Loan extends CI_Controller
{

public $id_menu 	= 12;
public $layout 		= "include/template";
public $title			= "เพิ่ม/แก้ไข การกู้ตั๋ว";
public $home;

public function __construct()
{
	parent:: __construct();
	$this->home = base_url()."loan";
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
	$data['data']		= $this->loan_model->get_loan_ac();
	$data['view']		= "loan_view";
	$this->go_to($data);		
}

public function add($id_bank_ac)
{
	if( $this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "add") || $this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "edit") )
	{
		$row							= $this->loan_model->count_row($id_bank_ac);
		$segment				 	= 4;
		$perpage					= getConfig("PER_PAGE");
		$config						= pagination_config($this->home."/add/".$id_bank_ac."/", $row, $perpage, $segment);  /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$rs 							= $this->loan_model->get_data("",$id_bank_ac, $perpage, $this->uri->segment($segment));
		$data['data']					= $rs;
		$data['view']					= "loan_add_view";
		$data['id_bank_ac']		= $id_bank_ac;
		$data['id_bank']				= get_id_bank_by_ac($id_bank_ac);
		$data['ac_list']				= $this->loan_model->get_loan_ac();
		$this->pagination->initialize($config);
		$this->go_to($data);	
	}else{
		access_deny();
	}
}

public function view($id_bank_ac)
{
	if( $this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "view") )
	{
		$row							= $this->loan_model->count_row($id_bank_ac);
		$perpage					= getConfig("PER_PAGE");
		$segment					= 4;
		$config						= pagination_config($this->home."/view/".$id_bank_ac."/", $row, $perpage, $segment); /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$data['data'] 				= $this->loan_model->get_data( "", $id_bank_ac, $perpage, $this->uri->segment($segment) );
		$data['view']					= "loan_search_view";
		$data['id_menu']			= $this->id_menu;
		$data['title']					= bank_ac_detail($id_bank_ac);
		$data['id_bank_ac']		= $id_bank_ac;
		$this->pagination->initialize($config);
		$this->load->view($this->layout, $data);	
		
	}else{
		access_deny();	
	}
}

public function search($id_bank_ac)
{
	if( $this->input->post("detail") || $this->input->post("reference") || $this->input->post("from_date") || $this->input->post("to_date") )
	{
		$detail = $this->input->post("detail");
		$reference = $this->input->post("reference");
		$from_date = $this->input->post('from_date') ? thaiDate_to_dbDate($this->input->post("from_date"), false) : '' ;
		$to_date		= $this->input->post("to_date") ? thaiDate_to_dbDate($this->input->post("to_date"), false) : '' ;
		$cookie = array('name'=>'from_date', 'value'=>$from_date, 'expire'=>3600);
		$this->input->set_cookie($cookie);	
		$cookie = array('name'=>'to_date', 'value'=>$to_date, 'expire'=>3600);
		$this->input->set_cookie($cookie);		
		$cookie = array('name'=>'detail', 'value'=>$detail, 'expire'=>3600);
		$this->input->set_cookie($cookie);		
		$cookie = array('name'=>'reference', 'value'=>$reference, 'expire'=>3600);
		$this->input->set_cookie($cookie);	
						
	}else{	
		
		$detail		= $this->input->cookie("detail");
		$reference 	= $this->input->cookie("reference");
		$from_date 	= $this->input->cookie("from_date") ? $this->input->cookie("from_date") : '' ;
		$to_date 	= $this->input->cookie("to_date") ? $this->input->cookie("to_date") : '' ;
	}
	$row							= $this->loan_model->count_search_row($id_bank_ac, $detail, $reference, $from_date, $to_date);
	$perpage					= getConfig("PER_PAGE");
	$segment					= 4;
	$config						= pagination_config($this->home."/search/".$id_bank_ac."/", $row, $perpage, $segment); /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
	$data['data'] 				= $this->loan_model->get_search($id_bank_ac, $detail, $reference, $from_date, $to_date, $perpage, $this->uri->segment($segment) );
	$data['detail']				= $detail;
	$data['reference']			= $reference;
	$data['from_date']			= $from_date;
	$data['to_date']				= $to_date;
	$data['view']					= "loan_add_view";
	$data['id_menu']			= $this->id_menu;
	$data['title']					= bank_ac_detail($id_bank_ac);
	$data['id_bank_ac']		= $id_bank_ac;
	$data['id_bank']				= get_id_bank_by_ac($id_bank_ac);
	$data['search']				= true;
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

public function add_row()
{
	if( $this->input->post("id_bank_ac") )
	{	
		$id_bank_ac	= $this->input->post("id_bank_ac");
		$em_name		= employee_name_by_user($this->session->userdata("id_user"));
		if($this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "add") )
		{
			$date_add = thaiDate_to_dbDate($this->input->post("date_add"), false);
			$days		= $this->input->post("days");
			$due_date = date("Y-m-d", strtotime("+$days day $date_add"));		
			$position = $this->loan_model->max_position($id_bank_ac, $date_add) + 1;
			$data['id_bank_ac']	= $this->input->post("id_bank_ac");
			$data['id_bank']			= $this->input->post("id_bank");
			$data['detail']			= $this->input->post("detail");
			$data['reference']		= $this->input->post("reference");
			$data['amount']			= $this->input->post("amount");
			$data['paid']				= 0.00;
			$data['rate']				= $this->input->post("rate");
			$data['days']			= $this->input->post("days");
			$data['due_date']		= $due_date;
			$data['date_add']		= $date_add;
			$data['position']			= $position;
			$data['remark']			= $this->input->post("remark");
			$data['employee_add'] = $em_name;
			$data['employee_upd'] = "";
			$data['color']			= "";
			$rs = $this->loan_model->add_row($data);
			if($rs)		/// ถ้าเพิ่มสำเร็จ
			{ 
				$this->load->model("account_model");
				$book = $this->account_model->is_in_book($id_bank_ac);
				if($book)  /// ถ้าเงินเข้าบัญชี จะทำการเพิ่มรายการใน book cash
				{
					$is = $this->account_model->int_method($id_bank_ac);
					$amount = $this->input->post("amount");
					$rate = $this->input->post("rate")/100;
					$days = $this->input->post("days");
					$xamount = ($amount * $rate * $days) / 365;
					$remark	= "";
					if( $is == 1 ){ $amount -= $xamount; $remark = "ยอดเงิน : ".number_format($this->input->post("amount"),2)."  หักดอกเบี้ยจ่ายทันที่ : ".number_format($xamount,2); }
					$datax['id_bank'] 				= $this->account_model->get_id_bank($book);
					$datax['id_bank_ac'] 			= $book;
					$datax['detail']					= $this->input->post("detail");
					$datax['reference']			= $this->input->post("reference");
					$datax['cash_in']				= $amount;
					$datax['cash_out']				= 0.00;
					$datax['is_in']					= 1;
					$datax['move_type']			= "เงินโอน";
					$datax['move_reference']	= "";
					$datax['date_add']				= now();
					$datax['due_date']				= $date_add;
					$datax['remark']				= $remark;
					$datax['employee_add']		= get_id_employee_by_user($this->session->userdata("id_user"));					
					$this->add_to_flow($book, $datax);	
				}
				//// จัด format ใหม่ ก่อนส่งไปแสดงผลหน้าจอ
				$data['date_add'] 	= thaiDate($data['date_add'], false);
				$data['due_date']	= thaiDate($data['due_date'], false);
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

public function add_to_flow($id_bank_ac, $data)
{
	$this->load->model("flow_model");
	$date 					= $data['due_date'];
	$id_bank_ac 			= $data['id_bank_ac'];
	$od 						= $this->flow_model->od_budget($id_bank_ac);
	$balance 				= $this->flow_model->get_last_balance($id_bank_ac, $date) + $data['cash_in'];
	$od_balance 			= $od + $balance;
	$position 				= $this->flow_model->max_position($id_bank_ac, $date) + 1;
	$data['detail']			= "กู้ตั๋ว";
	$data['balance']			= $balance;
	$data['od_balance']	= $od_balance;
	$data['position']			= $position;
	$rs = $this->flow_model->add_row($data);
	if($rs) /// ถ้าเพิ่มสำเร็จ
	{
		$rd = $this->flow_model->get_effected_row($id_bank_ac, $date) ; /// ตรวจสอบรายการที่มีผลกระทบกับการเพิ่ม
		if($rd) /// ถ้ามีรายการที่กระทบ ให้ทำการปรับปรุงยอดคงเหลือ
		{
			foreach($rd as $rm)
			{
				$balancex 				= $rm->balance + $data['cash_in'];
				$od_balancex			= $od + $balancex;
				$datax['balance']		= 	$balancex;
				$datax['od_balance'] 	= $od_balancex;
				$this->flow_model->update_balance($rm->id_cash_flow, $datax);
			}
		}
		return true;
	}else{
		return false;
	}
}

public function add_balance()
{
	if( $this->input->post("id_bank_ac") )
	{
		$id_bank_ac = $this->input->post("id_bank_ac");
		if( $this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "add") )
		{
			$data['id_bank_ac'] = $id_bank_ac;
			$data['id_bank']		= $this->input->post("id_bank");
			$data['detail']		= $this->input->post("detail");
			$data['reference']	= '';
			$data['amount']		= 0.00;
			$data['balance']		= $this->input->post("amount");
			$data['rate']			= 0.00;
			$data['days']		= 0;
			$data['due_date']	= thaiDate_to_dbDate($this->input->post("date_add"), false);
			$data['date_add'] = thaiDate_to_dbDate($this->input->post("date_add"), false);
			$data['remark']		= '';
			$data['employee_add']	= employee_name_by_user($this->session->userdata("id_user"));
			$rs = $this->loan_model->add_row($data);
			if($rs)
			{
				setMessage("เพิ่มข้อมูลเรียบร้อยแล้ว สามารถเริ่มใช้งานได้ทันที");
				redirect($this->home."/add/".$id_bank_ac);
			}else{
				setError("ไม่สามารถเพิ่มวงเงินคงเหลือยกมาได้สำเร็จ ลองใหม่อีกครั้ง หากข้อความนี้ยังปรากฏอีกครั้ง กรุณาติดต่อผู้ดูแลระบบ");
				redirect($this->home."/add/".$id_bank_ac);
			}
		}else{
			action_deny();	
		}		
	}else{
		setError("การส่งข้อมูลผิดพลาด");
		redirect($this->home);	
	}	
}


public function update_row($id)
{
	if($this->input->get("date_add") && $this->input->get("old_date") )
	{	
		$id_bank_ac	= $this->input->get("id_bank_ac");
		$date 			= thaiDate_to_dbDate($this->input->get("date_add"), false); 
		$old_date 		= thaiDate_to_dbDate($this->input->get("old_date"), false);	
		$amount	 		= $this->input->get("amount");
		$days			= $this->input->get("days");
		$due_date		= date("Y-m-d", strtotime("+$days $date"));
		$remark			= $this->input->get("remark");
		$old_pos 		= $this->loan_model->get_position($id);
		$em_name 		= employee_name_by_user($this->session->userdata("id_user"));
		if($date != $old_date) { $data['position'] =  $this->loan_model->max_position($id_bank_ac, $date) + 1; }
		$detail 						= $this->input->get("detail");
		$reference 					= $this->input->get("reference");
		$move_type 				= $this->input->get("move_type");
		$move_ref 					= $this->input->get("move_reference");
		$data['detail']				= $detail;
		$data['reference']			= $reference;
		$data['amount']				= $amount;
		$data['rate']					= $this->input->get("rate");	
		$data['days']				= $days;
		$data['remark']				= $remark;
		$data['due_date']			= $due_date;
		$data['date_add']			= $date;
		$data['employee_upd']	= $em_name;
		$ra = $this->loan_model->update_row($id, $data);
		if($ra)
		{ 
			echo "success";
			setMessage("ปรับปรุงรายการเรียบร้อย");
		}else{
			echo "fail";
			setError("ปรับปรุงรายการไม่สำเร็จ");
		}
	}else{
		echo "nodata";
		setError("ไม่พบข้อมูลที่จะแก้ไข");
	}
}

	

public function delete_row($id_loan)
{
	$dx 			= $this->loan_model->get_data($id_loan, "");
	$amount	 	= 0;
	$balance 	= 0;
	foreach( $dx as $rd )
	{
		$id_bank_ac 	= $rd->id_bank_ac;
		$amount	 		= $rd->amount;
		$balance  		= $rd->balance;	
		$date 			= $rd->date_add;
		$pos				= $rd->position;
	}

	if($this->loan_model->delete_row($id_loan))
	{
		$this->loan_model->update_position($id_bank_ac, $date);
		$result = "success";
	}else{
		$result = "fail";	
	}
	echo $result;
}	
	
	
public function change_color($id)
{
	$data['color'] = $this->input->post("color");
	if($this->loan_model->change_color($id, $data) )
	{
		echo "success"; 
	}else{
		echo "fail";
	}
}

public function view_balance()
{
	if( $this->input->post("id_bank_ac") )	
	{
		$detail 			= array();
		$id_bank_ac 	= $this->input->post("id_bank_ac");
		$date 			= thaiDate_to_dbDate($this->input->post("date"), false);
		$used				= $this->loan_model->sum_used($id_bank_ac, $date);
		$paid				= $this->loan_model->sum_paid($id_bank_ac, $date);
		$budget			= $this->loan_model->pn_budget($id_bank_ac);
		$balance			= ($budget - $used) + $paid;
		$to 	= 30;
		$i 		= 0;
		while($i < $to )
		{
			$date_add = date("Y-m-d", strtotime("+".$i."day $date"));
			$used = $this->loan_model->used($id_bank_ac, $date_add);
			$paid	= $this->loan_model->paid($id_bank_ac, $date_add);
			$balance -= $used;
			$balance += $paid;
			if($used == 0 ){ $used = "-"; }else{ $used = number_format($used,2); }
			if($paid == 0 ){ $paid = "-"; }else{ $paid = number_format($paid,2); }
			$arr = array("date"=>thaiDate($date_add, false), "used"=>$used, "paid"=>$paid, "balance"=>number_format($balance,2));
			array_push($detail, $arr);
			$i++;
		}
		echo json_encode($detail);
	}else{
		echo "error";	
	}
}
	
}/// end class
?>