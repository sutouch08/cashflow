<?php
//////  บันทึก cash flow  /////

class Flow extends CI_Controller
{

public $id_menu	= 10;
public $title			= "บันทึก Cash flow";
public $layout		= "include/template";
public $home;

public function __construct()
{
	parent:: __construct();
	$this->home		= base_url()."flow";
	$this->load->model("flow_model");
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

public function recalculate($id_bank_ac)
{
$rs = $this->db->where("id_bank_ac", $id_bank_ac)->group_by("due_date")->order_by("due_date", "ASC")->order_by("date_add", "ASC")->get("tbl_cash_flow");
foreach($rs->result() as $ro)
{
	$date = $ro->due_date;
	$this->reorder($id_bank_ac, $date);
}
echo "success";
}



public function view($id_bank_ac)
{
	if( $this->verify->valid_ac($this->session->userdata("id_user"), $id_bank_ac, "view") )
	{
		$row							= $this->flow_model->count_row($id_bank_ac);
		$per_page					= $this->input->cookie('rows');
		$perpage					= $per_page? $per_page : getConfig("PER_PAGE");
		$segment					= 4;
		$config						= pagination_config($this->home."/view/".$id_bank_ac."/", $row, $perpage, $segment); /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$data['data'] 				= $this->flow_model->get_data( "", $id_bank_ac, $perpage, $this->uri->segment($segment) );
		$data['view']					= "flow_search_view";
		$data['id_menu']			= $this->id_menu;
		$data['title']					= bank_ac_detail($id_bank_ac);
		$data['id_bank_ac']		= $id_bank_ac;
		$data['rows']				= $per_page;
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

	$row							= $this->flow_model->count_search_row($id_bank_ac, $detail, $reference, $from_date, $to_date);
	$per_page					= $this->input->cookie('rows');
	$perpage					= $per_page? $per_page : getConfig("PER_PAGE");
	$segment					= 4;
	$config						= pagination_config($this->home."/search/".$id_bank_ac."/", $row, $perpage, $segment); /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
	$data['data'] 				= $this->flow_model->get_search($id_bank_ac, $detail, $reference, $from_date, $to_date, $perpage, $this->uri->segment($segment) );
	$data['detail']				= $detail;
	$data['reference']			= $reference;
	$data['from_date']			= $from_date;
	$data['to_date']				= $to_date;
	$data['view']					= "flow_add_view";
	$data['id_menu']			= $this->id_menu;
	$data['title']					= bank_ac_detail($id_bank_ac);
	$data['id_bank_ac']		= $id_bank_ac;
	$data['id_bank']				= get_id_bank_by_ac($id_bank_ac);
	$data['search']				= true;
	$data['rows']				= $per_page;
	$data['ac_list']			= $this->account_model->get_data();
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
		$row							= $this->flow_model->count_row($id_bank_ac);
		$segment				 	= 4;
		$per_page					= $this->input->cookie('rows');
		$perpage					= $per_page? $per_page : getConfig("PER_PAGE");
		$config						= pagination_config($this->home."/add/".$id_bank_ac."/", $row, $perpage, $segment);  /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$rs 							= $this->flow_model->get_data("",$id_bank_ac, $perpage, $this->uri->segment($segment));
		$data['data']					= $rs;
		$data['view']					= "flow_add_view";
		$data['id_bank_ac']		= $id_bank_ac;
		$data['id_bank']				= get_id_bank_by_ac($id_bank_ac);
		$data['ac_list']				= $this->account_model->get_data();
		$data['rows']				= $per_page;
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
		$date = thaiDate_to_dbDate($this->input->post("due_date"), false);
		$id_bank_ac = $this->input->post("id_bank_ac");
		$od 		= $this->flow_model->od_budget($id_bank_ac);
		$cash_in = $this->input->post("cash_in");
		$cash_out = $this->input->post("cash_out");
		if( $this->verify->valid_ac($this->session->userdata("id_user"), $this->input->post("id_bank_ac"), "add") )
		{
			if( $this->input->post("cash_in") > 0 ){ $is_in = 1; }else{ $is_in = 0; }
			$balance = $this->flow_model->get_last_balance($id_bank_ac, $date) + $cash_in - $cash_out;
			$od_balance = $od + $balance;
			$position = $this->flow_model->max_position($id_bank_ac, $date) + 1;

			$data['id_bank']		= $this->input->post("id_bank");
			$data['id_bank_ac']	= $this->input->post("id_bank_ac");
			$data['detail']			= $this->input->post("detail");
			$data['reference']		= $this->input->post("reference");
			$data['cash_in']			= $this->input->post("cash_in");
			$data['cash_out']		= $this->input->post("cash_out");
			$data['balance']			= $balance;
			$data['od_balance']	= $od_balance;
			$data['is_in']				= $is_in;
			$data['move_type']		= $this->input->post("move_type");
			$data['move_reference']	= $this->input->post("move_reference");
			$data['date_add']			= now();
			$data['due_date']			= $date;
			$data['remark']				= $this->input->post("remark");
			$data['employee_add']	= get_id_employee_by_user($this->session->userdata("id_user"));
			$data['position']				= $position;
			$rs = $this->flow_model->add_row($data);
			if($rs) /// ถ้าเพิ่มสำเร็จ
			{
				$rd = $this->flow_model->get_effected_row($id_bank_ac, $date) ; /// ตรวจสอบรายการที่มีผลกระทบกับการเพิ่ม
				if($rd) /// ถ้ามีรายการที่กระทบ ให้ทำการปรับปรุงยอดคงเหลือ
				{
					foreach($rd as $rm)
					{
						$balancex			= $rm->balance + $cash_in - $cash_out;
						$od_balancex		= $od + $balancex;
						$datax['balance']	= 	$balancex;
						$datax['od_balance'] = $od_balancex;
						$this->flow_model->update_balance($rm->id_cash_flow, $datax);
					}
					/// เมื่อปรับปรุงยอดคงเหลือเสร็จแล้วต้องเรียงลำดับรายการใหม่ เรียงด้านจ่ายอยู่ก่อนด้านรับ โดยด้านจ่ายเรียงตามชื่อ ด้านรับเรียงตามยอดเงินจากน้อยไปมาก
					$reorder = $this->reorder($id_bank_ac, $date);
				}
				//// จัด format ใหม่ ก่อนส่งไปแสดงผลหน้าจอ
				$data['due_date'] 	= $this->input->post("due_date");
				$data['cash_in']		= $data['cash_in'] <= 0 ? "-" : number_format($data['cash_in'],2);
				$data['cash_out']	= $data['cash_out'] <= 0 ? "-" : number_format($data['cash_out'], 2);
				$data['balance']		= $data['balance'] <= 0 ? "-" : number_format($data['balance'], 2 );
				$data['od_balance'] = number_format($data['od_balance'], 2);
				echo json_encode($data);
			}else{
				echo "error";
			}

		}else{
			action_deny();
		}
	}else{
		echo "error";
	}
}

public function reorder($id_bank_ac, $date)
{
	$od				= $this->flow_model->od_budget($id_bank_ac);
	$ro 				= $this->flow_model->get_rank($id_bank_ac, $date, 0); /// ดึงข้อมูลที่เลือกแบบเรียงลำดับแล้วมาเพื่อทำการคำนวนใหม่  0 = จ่าย  1 = รับ
	$rf					= $this->flow_model->get_rank($id_bank_ac, $date, 1);
	$pre_date 		= date("Y-m-d", strtotime("-1 day $date"));
	$last_balance 	= $this->flow_model->get_last_balance($id_bank_ac, $pre_date); /// ยอดคงเหลือบัญชีวันก่อนหน้า
	$pos = 1;
	if($rf){
		foreach($rf as $ra)
		{
			$last_balance 			= $last_balance + $ra->cash_in - $ra->cash_out;
			$datas['balance']		= $last_balance;
			$datas['od_balance'] 	= $od + $last_balance;
			$datas['position']		= $pos;
			$this->flow_model->update_balance($ra->id_cash_flow, $datas);
			$pos++;
		}
	}

	if($ro){
		foreach($ro as $ra)
		{
			$last_balance 			= $last_balance + $ra->cash_in - $ra->cash_out;
			$datas['balance']		= $last_balance;
			$datas['od_balance'] 	= $od + $last_balance;
			$datas['position']		= $pos;
			$this->flow_model->update_balance($ra->id_cash_flow, $datas);
			$pos++;
		}
	}

	return true;
}

public function update_row($id)
{
	if($this->input->get("due_date") && $this->input->get("old_date") )
	{
		$id_bank_ac 				= $this->input->get("id_bank_ac");
		$od 							= $this->flow_model->od_budget($id_bank_ac);
		$date 						= thaiDate_to_dbDate($this->input->get("due_date"), false);
		$old_date 					= thaiDate_to_dbDate($this->input->get("old_date"), false);
		$cash_in 					= $this->input->get("cash_in");
		$cash_out 					= $this->input->get("cash_out");
		$old_pos 					= $this->flow_model->get_position($id);

		if( $date > $old_date || $date == $old_date)
		{
			$balance 	= $this->flow_model->get_last_update_balance($id_bank_ac, $id, $date);
		}else{
			$balance 	= $this->flow_model->get_last_update_balance_move_to_min_date($id_bank_ac, $id, $date);
		}
		if( $cash_in > 0 ){  $is_in = 1; }else{ $is_in = 0; }
		$balance = $balance + $cash_in - $cash_out;
		$od_balance = $od + $balance;
		if($date != $old_date) { $data['position'] =  $this->flow_model->max_position($id_bank_ac, $date) + 1; }
		$detail 						= $this->input->get("detail");
		$reference 					= $this->input->get("reference");
		$move_type 				= $this->input->get("move_type");
		$move_ref 					= $this->input->get("move_reference");
		$data['detail']				= $this->input->get("detail");
		$data['reference']			= $this->input->get("reference");
		$data['cash_in']				= $cash_in;
		$data['cash_out']			= $cash_out;
		$data['balance']				= $balance;
		$data['od_balance']		= $od_balance;
		$data['move_type']			= $this->input->get("move_type");
		$data['move_reference']	= $this->input->get("move_reference");
		$data['due_date']			= $date;
		$ra = $this->flow_model->update_row($id, $data);
		if($ra)
		{
			if($date == $old_date) /// ถ้าวันที่ไม่เปลี่ยน
			{
				$rd = $this->flow_model->get_effected_update_row($id_bank_ac, $date, $old_pos);
			}else if($date > $old_date){
				$rd = $this->flow_model->get_effected_update_row($id_bank_ac, $old_date, $old_pos);
			}else{
				$rd = $this->flow_model->get_effected_update_row($id_bank_ac, $date);
			}
			if($rd)
			{
				foreach($rd as $rx)
				{
					$balancex = $this->flow_model->get_last_update_balance($id_bank_ac, $rx->id_cash_flow, $rx->due_date);
					$amount = $this->flow_model->get_move_amount($rx->id_cash_flow);
					$datax['balance']		= $balancex + $amount;
					$datax['od_balance']	= $od + $datax['balance'];
					$this->flow_model->update_balance($rx->id_cash_flow, $datax);
				}
				$this->reorder($id_bank_ac, $date);
			}
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


public function delete_row($id_cash_flow)
{
	$dx 			= $this->flow_model->get_data($id_cash_flow, "");
	$cash_in 	= 0;
	$cash_out 	= 0;
	$balance 	= 0;
	$is_in 		= 0;
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
		$this->reorder($id_bank_ac, $date);
		$result = "success";
	}else{
		$result = "fail";
	}
	echo $result;
}


public function process($id_bank_ac)
{
	$row				= $this->flow_model->count_row($id_bank_ac);
	$config			= pagination_config($this->home."/index/",$row);  /// ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
	$data['data']		= $this->flow_model->get_data("",$id_bank_ac, $config['per_page'], $config['uri_segment']);
	$data['view']		= "flow_view";
	$this->pagination->initialize($config);
	$this->go_to($data);
}

public function change_color($id)
{
	$data['color'] = $this->input->post("color");
	if($this->flow_model->change_color($id, $data) )
	{
		echo "success";
	}else{
		echo "fail";
	}
}

public function set_rows()
{
	$rows = $this->input->post('rows');
	$cookie = array('name'=>'rows', 'value'=>$rows, 'expire'=>60*60*30);
	$this->input->set_cookie($cookie);
	echo "success";
}

}/// end class


?>
