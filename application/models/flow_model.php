<?php
class Flow_model extends CI_Model
{

public function __construct()
{
	parent:: __construct();
}

public function count_row($id)
{
	$rs = $this->db->where("id_bank_ac", $id)->count_all_results("tbl_cash_flow");
	if($rs > 0)
	{
		return $rs;
	}
	else
	{
		return false;
	}
}

public function get_data($id = "",$id_bank_ac, $perpage= 20, $limit = 1)
{
	if($id != "")
	{
		$rs = $this->db->where("id_cash_flow", $id)->get("tbl_cash_flow");
	}
	else
	{
		$rs = $this->db->where("id_bank_ac", $id_bank_ac)->order_by("due_date", "DESC")->order_by("position", "DESC")->limit($perpage, $limit)->get("tbl_cash_flow");
	}
	if($rs->num_rows() > 0)
	{
		return $rs->result();
	}
	else
	{
		return false;
	}
}

public function get_search($id_bank_ac, $detail, $reference, $from_date, $to_date, $perpage = 20, $limit = 1)
{
	$where = "WHERE id_bank_ac = ".$id_bank_ac." ";
	if( $detail != '')
	{
		$arr = explode('+', $detail);
		if(count($arr) > 1)
		{
			$i = 1;
			$details_query = "";
			foreach($arr as $ds)
			{
				$details_query .= $i == 1 ? "detail LIKE '%".trim($ds)."%' " : "OR detail LIKE '%".trim($ds)."%' ";
				$i++;
			}

			$where .= "AND (".$details_query.") ";
		}
		else
		{
			$where .= "AND detail LIKE '%".trim($detail)."%' ";
		}

	}

	if( $reference != '')
	{
		$where .= "AND reference LIKE '%".trim($reference)."%' ";
	}

	if( $from_date != '' && $to_date != '' )
	{
		$where .= "AND due_date >= '".$from_date."' ";
		$where .= "AND due_date <= '".$to_date."' ";
	}

	$qr  = "SELECT * FROM tbl_cash_flow ";
	$qr .= $where." ORDER BY due_date ASC, position ASC ";
	$qr .= "LIMIT ".$perpage;
	if($limit > 0)
	{
		$qr .= " OFFSET ".$limit;
	}

	$rs = $this->db->query($qr);

	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}
	else
	{
		return false;
	}
}

public function count_search_row($id_bank_ac, $detail, $reference, $from_date, $to_date)
{
	$where = "WHERE id_bank_ac = ".$id_bank_ac." ";
	if( $detail != '')
	{
		$arr = explode('+', $detail);
		if(count($arr) > 1)
		{
			$i = 1;
			$details_query = "";
			foreach($arr as $ds)
			{
				$details_query .= $i == 1 ? "detail LIKE '%".trim($ds)."%' " : "OR detail LIKE '%".trim($ds)."%' ";
				$i++;
			}

			$where .= "AND (".$details_query.") ";
		}
		else
		{
			$where .= "AND detail LIKE '%".trim($detail)."%' ";
		}

	}

	if( $reference != '')
	{
		$where .= "AND reference LIKE '%".trim($reference)."%' ";
	}

	if( $from_date != '' && $to_date != '' )
	{
		$where .= "AND due_date >= '".$from_date."' ";
		$where .= "AND due_date <= '".$to_date."' ";
	}

	$qr  = "SELECT count(id_cash_flow) AS rows FROM tbl_cash_flow ";
	$qr .= $where." ORDER BY due_date ASC, position ASC";

	$rs = $this->db->query($qr);
	return $rs->row()->rows;
}

public function add_row($data)
{
	$rs = $this->db->insert("tbl_cash_flow", $data);
	return $rs;
}

public function update_row($id, $data)
{
	$rs = $this->db->where("id_cash_flow",$id)->update("tbl_cash_flow", $data);
	return $rs;
}


public function delete_row($id)
{
	$rs = $this->db->where("id_cash_flow", $id)->delete("tbl_cash_flow");
	return $rs;
}

private function check_date($id_bank_ac, $date)
{
	$rs = $this->db->select("id_cash_flow")->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->get("tbl_cash_flow");
	if($rs->num_rows() >0 )
	{
		return true;
	}else{
		return false;
	}
}

public function max_position($id_bank_ac, $date)
{
	$rs = $this->db->select_max("position")->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->get("tbl_cash_flow");
	if($rs->num_rows() > 0 )
	{
		return $rs->row()->position;
	}else{
		return 0;
	}
}

public function last_date($id_bank_ac, $date)
{
	$rs = $this->db->select_max("due_date")->where("id_bank_ac", $id_bank_ac)->where("due_date <", $date)->get("tbl_cash_flow");
	if($rs->num_rows() > 0 )
	{
		return $rs->row()->due_date;
	}else{
		return false;
	}
}

public function get_rank($id_bank_ac, $date, $is_in)  //// ส่งข้อมูลโดยเรียงลำดับรายการใหม่ เรียงด้านจ่ายอยู่ก่อนด้านรับ โดยด้านจ่ายเรียงตามชื่อ ด้านรับเรียงตามยอดเงินจากน้อยไปมาก
{
	if($is_in == 0 )
	{
		$rs = $this->db->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->where("is_in", 0)->order_by("date_add", "ASC")->get("tbl_cash_flow");
	}else{
		$rs = $this->db->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->where("is_in", 1)->order_by("date_add", "ASC")->get("tbl_cash_flow");
	}
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
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
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->where("position", $pos)->get("tbl_cash_flow");
	}else{
		$last_date = $this->last_date($id_bank_ac, $date);
		if($last_date)
		{
			$pos = $this->max_position($id_bank_ac, $last_date);
			$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("due_date", $last_date)->where("position", $pos)->get("tbl_cash_flow");
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

public function get_last_update_balance_move_to_min_date($id_bank_ac, $id_cash_flow, $date)//// ใช้ในกรณี เปลี่ยนวันที่จากมากมาวันที่ที่น้อยกว่า
{
	$is = $this->check_date($id_bank_ac, $date);
	if($is)
	{
		$pos = $this->max_position($id_bank_ac, $date);
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->where("position", $pos)->get("tbl_cash_flow");
		if( $rs->num_rows() == 1 )
		{
			return $rs->row()->balance;
		}else{
			return 0 ;
		}
	}else{
		$last_date = $this->last_date($id_bank_ac, $date);
		$pos = $this->max_position($id_bank_ac, $last_date);
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("due_date", $last_date)->where("position", $pos)->get("tbl_cash_flow");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->balance;
		}else{
			return 0;
		}
	}
}

public function get_last_update_balance($id_bank_ac,$id_cash_flow,  $date)
{
	$is = $this->check_date($id_bank_ac, $date);
	if($is)
	{
		$pos = $this->get_position($id_cash_flow);
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->where("position <", $pos)->order_by("position", "DESC")->limit(1)->get("tbl_cash_flow");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->balance;
		}else{
			$last_date = $this->last_date($id_bank_ac, $date);
			$pos = $this->max_position($id_bank_ac, $last_date);
			$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("due_date", $last_date)->where("position", $pos)->limit(1)->get("tbl_cash_flow");
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
		$rs = $this->db->select("balance")->where("id_bank_ac", $id_bank_ac)->where("due_date", $last_date)->where("position", $pos)->limit(1)->get("tbl_cash_flow");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->balance;
		}else{
			return "xxxxx";
		}
	}
}


public function get_effected_row($id_bank_ac, $date)  //// กรณีเพิ่ม ส่งกลับรายการที่มีผลกระทบเวลามีการเพิ่มข้อมูลย้อนวันที่ตากกำหนดรับเงิน
{
	$in = array();
	$pos = $this->max_position($id_bank_ac, $date);
	$rs = $this->db->select("id_cash_flow")->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->where("position >", $pos)->get("tbl_cash_flow");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd)
		{
			array_push($in, $rd->id_cash_flow);
		}
	}
	$rs = $this->db->select("id_cash_flow")->where("id_bank_ac", $id_bank_ac)->where("due_date >", $date)->get("tbl_cash_flow");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd)
		{
			array_push($in, $rd->id_cash_flow);
		}
	}
	if(count($in) > 0)
	{
		$rs = $this->db->select("id_cash_flow, balance")->where_in("id_cash_flow", $in)->order_by("due_date", "ASC")->order_by("position", "ASC")->get("tbl_cash_flow");
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
		$rs = $this->db->select("id_cash_flow")->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->where("position >", $pos)->get("tbl_cash_flow");
		if($rs->num_rows() > 0 )
		{
			foreach($rs->result() as $rd )
			{
				array_push($in, $rd->id_cash_flow);
			}
		}
	}
	$rs = $this->db->select("id_cash_flow")->where("id_bank_ac", $id_bank_ac)->where("due_date >", $date)->get("tbl_cash_flow");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd )
		{
			array_push($in, $rd->id_cash_flow);
		}
	}

	if( count($in) > 0 )
	{
		$rs = $this->db->select("id_cash_flow, balance, due_date")->where_in("id_cash_flow", $in)->order_by("due_date", "ASC")->order_by("position", "ASC")->get("tbl_cash_flow");
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

public function get_effected_delete_row($id_cash_flow, $date, $id_bank_ac, $pos) ////กรณีลบ ส่งกลับรายการที่มีผลกระทบเวลามีการลบรายการ
{
	$in = array();
	$rs = $this->db->select("id_cash_flow")->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->where("position >", $pos)->get("tbl_cash_flow");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd )
		{
			array_push($in, $rd->id_cash_flow);
		}
	}
	$rs = $this->db->select("id_cash_flow")->where("id_bank_ac", $id_bank_ac)->where("due_date >", $date)->get("tbl_cash_flow");
	if($rs->num_rows() > 0 )
	{
		foreach($rs->result() as $rd )
		{
			array_push($in, $rd->id_cash_flow);
		}
	}
	if( count($in) > 0 )
	{
		$rs = $this->db->select("id_cash_flow, balance")->where_in("id_cash_flow", $in)->order_by("due_date", "ASC")->order_by("position", "ASC")->get("tbl_cash_flow");
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


public function update_balance($id_cash_flow, $new_balance)
{
	$rs = $this->db->where("id_cash_flow", $id_cash_flow)->update("tbl_cash_flow", $new_balance);
	return $rs;
}

public function od_budget($id_bank_ac)
{
	$rs = $this->db->select("od_budget")->where("id_bank_ac", $id_bank_ac)->get("tbl_bank_ac");
	if($rs->num_rows() > 0)
	{
		return $rs->row()->od_budget;
	}else{
		return 0;
	}
}


public function get_move_amount($id_cash_flow)  //// ส่งกลับยอดเคลื่อนไหว เข้า เป็นบวก ออกเป็นลบ
{
	$amount = 0;
	$rs = $this->db->select("cash_in, cash_out")->where("id_cash_flow", $id_cash_flow)->get("tbl_cash_flow");
	if($rs->num_rows() == 1 )
	{
		$amount = $rs->row()->cash_in - $rs->row()->cash_out;
	}
	return $amount;
}

public function get_position($id_cash_flow)
{
	$rs = $this->db->select("position")->where("id_cash_flow", $id_cash_flow)->get("tbl_cash_flow");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->position;
	}else{
		return 0;
	}
}

public function update_position($id_bank_ac, $date)
{
	$rs = $this->db->select("id_cash_flow")->where("id_bank_ac", $id_bank_ac)->where("due_date", $date)->order_by("position", "ASC")->get("tbl_cash_flow");
	if($rs->num_rows() > 0 )
	{
		$i = 1;
		foreach($rs->result() as $rd)
		{
			$data['position']		= $i;
			$this->db->where("id_cash_flow", $rd->id_cash_flow)->update("tbl_cash_flow", $data);
			$i++;
		}
	}
	return true;
}

public function change_color($id, $data)
{
	$rs = $this->db->where("id_cash_flow", $id)->update("tbl_cash_flow", $data);
	return $rs;
}

}/// end class

?>
