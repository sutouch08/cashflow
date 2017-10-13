<?php
class Loan_model extends CI_Model
{
public function __construct()
{
	parent:: __construct();
}

public function count_row($id_bank_ac)
{
	$rs = $this->db->where("id_bank_ac", $id_bank_ac)->count_all_results("tbl_loan");
	if($rs > 0 )
	{
		return $rs;
	}else{
		return false;
	}
}

public function get_loan_ac($id ='')
{
	if($id != '' )
	{
		$rs = $this->db->where("id_bank_ac", $id)->get("tbl_bank_ac");
	}else{
		$rs = $this->db->where("loan_budget >", 0 )->order_by("id_bank", "ASC")->get("tbl_bank_ac");
	}
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}else{
		return false;
	}
}

public function get_data($id = '', $id_bank_ac, $perpage = 20, $limit = 1)
{
	if($id != '')
	{
		$rs = $this->db->where("id_loan", $id)->get("tbl_loan");
	}else{
		$rs = $this->db->where("id_bank_ac", $id_bank_ac)->order_by("date_add", "ASC")->order_by("position", "ASC")->limit($perpage, $limit)->get("tbl_loan");
	}
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}else{
		return false;
	}
}


public function get_search($id_bank_ac, $detail, $reference, $from_date, $to_date, $perpage = 20, $limit = 1)
{
	$this->db->where("id_bank_ac", $id_bank_ac);
	if( $detail != ''){ 	$this->db->like('detail', $detail); }
	if( $reference != '' ){ $this->db->like('reference', $reference); }
	if( $from_date != '' && $to_date != '' ){ $this->db->where("date_add BETWEEN '$from_date' AND '$to_date'", NULL, false); }
	$rs = $this->db->where("id_bank_ac", $id_bank_ac)->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}else{
		return false;
	}	
}

public function count_search_row($id_bank_ac, $detail, $reference, $from_date, $to_date)
{
	$this->db->where("id_bank_ac", $id_bank_ac);
	if( $detail != ''){ 	$this->db->like('detail', $detail); }
	if( $reference != '' ){ $this->db->like('reference', $reference); }
	if( $from_date != '' && $to_date != '' ){ $this->db->where("date_add BETWEEN '$from_date' AND '$to_date'", NULL, false); }
	$rs = $this->db->where("id_bank_ac", $id_bank_ac)->get("tbl_loan");
	return $rs->num_rows();	
}


public function add_row($data)
{
	$rs =	$this->db->insert("tbl_loan", $data);
	return $rs;	
}

public function pn_budget($id_bank_ac)
{
	$rs = $this->db->select("loan_budget")->where("id_bank_ac", $id_bank_ac)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->loan_budget;
	}else{
		return 0;
	}
}


public function sum_used($id_bank_ac, $date)
{
	$rs = $this->db->select_sum("amount")->where("id_bank_ac", $id_bank_ac)->where("date_add <", $date)->get("tbl_loan");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->amount;
	}else{
		return 0;
	}
}

public function sum_paid($id_bank_ac, $date)
{
	$rs = $this->db->select_sum("amount")->where("id_bank_ac", $id_bank_ac)->where("date_add <", $date)->get("tbl_repay");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->amount;
	}else{
		return 0;
	}
}

public function used($id_band_ac, $date)
{
	$rs = $this->db->select_sum("amount")->where("id_bank_ac", $id_band_ac)->where("date_add", $date)->get("tbl_loan");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->amount;
	}else{
		return 0;
	}
}

public function paid($id_bank_ac, $date)
{
	$rs = $this->db->select_sum("amount")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->get("tbl_repay");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->amount;
	}else{
		return 0;
	}
}	

public function update_loan_balance($id_bank_ac, $amount)
{
	$rs = $this->db->query("UPDATE tbl_bank_ac SET loan_balance = loan_balance + ".$amount." WHERE id_bank_ac = ".$id_bank_ac);
	return $rs;
}
public function delete_row($id)
{
	$rs = $this->db->where("id_loan", $id)->delete("tbl_loan");
	return $rs;	
}


public function update_row($id, $data)
{
	$rs = $this->db->where("id_loan",$id)->update("tbl_loan", $data);
	return $rs;
}


public function get_move_amount($id_loan)  //// ส่งกลับยอดเคลื่อนไหว
{
	$amount = 0;
	$rs = $this->db->select("amount")->where("id_loan", $id_loan)->get("tbl_loan");
	if($rs->num_rows() == 1 )
	{
		$amount = $rs->row()->amount;
	}
	return $amount;
}

public function get_paid($id_loan)
{
	$rs = $this->db->select("paid")->where("id_loan", $id_loan)->get("tbl_loan");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->paid;
	}else{
		return 0;
	}
}

private function check_date($id_bank_ac, $date)
{
	$rs = $this->db->select("id_loan")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->get("tbl_loan");
	if($rs->num_rows() >0 )
	{
		return true;
	}else{
		return false;
	}
}

public function get_position($id_loan)
{
	$rs = $this->db->select("position")->where("id_loan", $id_loan)->get("tbl_loan");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->position;
	}else{
		return 0;
	}
}

public function max_position($id_bank_ac, $date)
{
	$rs = $this->db->select_max("position")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		return $rs->row()->position;
	}else{
		return 0;
	}
}

public function last_date($id_bank_ac, $date)
{
	$rs = $this->db->select_max("date_add")->where("id_bank_ac", $id_bank_ac)->where("date_add <", $date)->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		return $rs->row()->date_add;
	}else{
		return false;
	}
}


public function get_last_balance($id_bank_ac, $date)
{
	$cs = $this->check_date($id_bank_ac, $date); /// ตรวจสอบว่ามีวันที่นี้อยู่แล้วหรือยัง
	if($cs) 													/// ถ้ามีแล้ว	
	{
		$pos = $this->max_position($id_bank_ac, $date);			/// ดึงตำแหน่งสูงสุด
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->where("position", $pos)->get("tbl_loan");
	}else{	
		$last_date = $this->last_date($id_bank_ac, $date);
		if($last_date)
		{
			$pos = $this->max_position($id_bank_ac, $last_date);
			$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("date_add", $last_date)->where("position", $pos)->get("tbl_loan");
		}else{  ///ถ้าไม่มีวันที่ล่าสุด แสดงว่าวันที่เพิ่มหรือแก้ไขมานั้นเป็นวันที่ตั้งต้น
			$rs = "first_date";
		}			
	}
	if($rs != "first_date" )
	{
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->balance;
		}else{
			return 0;
		}
	}else{
		return 0;
	}	
}

public function get_last_update_balance($id_bank_ac,$id_loan,  $date)
{
	$is = $this->check_date($id_bank_ac, $date);
	if($is)
	{
		$pos = $this->get_position($id_loan);
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->where("position <", $pos)->order_by("position", "DESC")->limit(1)->get("tbl_loan");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->balance;
		}else{
			$last_date = $this->last_date($id_bank_ac, $date);
			$pos = $this->max_position($id_bank_ac, $last_date);
			$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("date_add", $last_date)->where("position", $pos)->limit(1)->get("tbl_loan");
			if($rs->num_rows() == 1 )
			{
				return $rs->row()->balance;
			}else{
				return "aaaa";
			}
		}
	}else{
		$last_date = $this->last_date($id_bank_ac, $date);
		$pos = $this->max_position($id_bank_ac, $last_date);
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("date_add", $last_date)->where("position", $pos)->limit(1)->get("tbl_loan");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->balance;
		}else{
			return "xxxxx";
		}
	}
}


public function get_last_update_balance_move_to_min_date($id_bank_ac, $id_loan, $date)//// ใช้ในกรณี เปลี่ยนวันที่จากมากมาวันที่ที่น้อยกว่า
{
	$is = $this->check_date($id_bank_ac, $date);
	if($is)
	{
		$pos = $this->max_position($id_bank_ac, $date);
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->where("position", $pos)->get("tbl_loan");
		if( $rs->num_rows() == 1 )
		{
			return $rs->row()->balance;
		}else{
			return 0 ;
		}
	}else{
		$last_date = $this->last_date($id_bank_ac, $date);
		$pos = $this->max_position($id_bank_ac, $last_date);
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("date_add", $last_date)->where("position", $pos)->get("tbl_loan");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->balance;
		}else{
			return 0;
		}
	}
}


public function update_balance($id_loan, $new_balance)
{
	$rs = $this->db->where("id_loan", $id_loan)->update("tbl_loan", $new_balance);
	return $rs;
}	
	
public function get_effected_row($id_bank_ac, $date)  //// กรณีเพิ่ม ส่งกลับรายการที่มีผลกระทบเวลามีการเพิ่มข้อมูลย้อนวันที่ตากกำหนดรับเงิน
{
	$in = array();
	$pos = $this->max_position($id_bank_ac, $date);
	$rs = $this->db->select("id_loan")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->where("position >", $pos)->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd)
		{
			array_push($in, $rd->id_loan);
		}
	}
	$rs = $this->db->select("id_loan")->where("id_bank_ac", $id_bank_ac)->where("date_add >", $date)->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd)
		{
			array_push($in, $rd->id_loan);
		}
	}
	if(count($in) > 0)
	{
		$rs = $this->db->select("id_loan, balance, date_add")->where_in("id_loan", $in)->order_by("date_add", "ASC")->order_by("position", "ASC")->get("tbl_loan");
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}else{
			return false;
		}
	}else{
		return false;
	}
}


public function get_effected_update_row($id_bank_ac, $date, $pos="")  //// กรณีแก้ไข ส่งกลับรายการที่มีผลกระทบเวลามีการเพิ่มข้อมูลย้อนวันที่ตากกำหนดรับเงิน
{
	$in = array();
	if( $pos != "")
	{
		$rs = $this->db->select("id_loan")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->where("position >", $pos)->get("tbl_loan");
		if($rs->num_rows() > 0 )
		{
			foreach($rs->result() as $rd )
			{
				array_push($in, $rd->id_loan);
			}
		}
	}
	$rs = $this->db->select("id_loan")->where("id_bank_ac", $id_bank_ac)->where("date_add >", $date)->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd )
		{
			array_push($in, $rd->id_loan);
		}
	}

	if( count($in) > 0 )
	{
		$rs = $this->db->select("id_loan, balance, date_add")->where_in("id_loan", $in)->order_by("date_add", "ASC")->order_by("position", "ASC")->get("tbl_loan");
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}else{
			return false;
		}
	}else{
		return false;
	}
}


public function get_effected_delete_row($id_loan, $date, $id_bank_ac, $pos) ////กรณีลบ ส่งกลับรายการที่มีผลกระทบเวลามีการลบรายการ
{
	$in = array();
	$rs = $this->db->select("id_loan")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->where("position >", $pos)->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd )
		{
			array_push($in, $rd->id_cash_flow);
		}
	}
	$rs = $this->db->select("id_loan")->where("id_bank_ac", $id_bank_ac)->where("date_add >", $date)->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd )
		{
			array_push($in, $rd->id_loan);
		}
	}
	if( count($in) > 0 )
	{
		$rs = $this->db->select("id_loan, balance")->where_in("id_loan", $in)->order_by("date_add", "ASC")->order_by("position", "ASC")->get("tbl_loan");
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}else{
			return false;
		}
	}else{
		return false;
	}
}



public function update_position($id_bank_ac, $date)
{
	$rs = $this->db->select("id_loan")->where("id_bank_ac", $id_bank_ac)->where("date_add", $date)->order_by("position", "ASC")->get("tbl_loan");
	if($rs->num_rows() > 0 )
	{
		$i = 1;
		foreach($rs->result() as $rd)
		{
			$data['position']		= $i;
			$this->db->where("id_loan", $rd->id_loan)->update("tbl_loan", $data);
			$i++;
		}
	}
	return true;
}

public function change_color($id, $data)
{
	$rs = $this->db->where("id_loan", $id)->update("tbl_loan", $data);
	return $rs;
}

public function get_date_add($id_loan)
{
	$rs = $this->db->select("date_add")->where("id_loan", $id_loan)->get("tbl_loan");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->date_add;
	}else{
		return false;
	}
}
	
}/// end class


?>