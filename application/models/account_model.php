<?php
class Account_model extends CI_Model
{

public function __construct()
{
	parent:: __construct();
}

public function get_data($id="")
{
	if($id != "")
	{
		$rs = $this->db->where("id_bank_ac", $id)->get("tbl_bank_ac");
	}else{
		$rs = $this->db->order_by("id_bank", "ASC")->get("tbl_bank_ac");
	}
	if($rs->num_rows() > 0)
	{
		return $rs->result();
	}else{
		return false;
	}
}

public function add_account($data)
{
	$rs = $this->db->insert("tbl_bank_ac", $data);
	return $rs;
}

public function update($id, $data)
{
	$rs = $this->db->where("id_bank_ac", $id)->update("tbl_bank_ac", $data);
	return $rs;
}

public function delete_account($id)
{
	$rs = $this->db->where("id_bank_ac", $id)->delete("tbl_bank_ac");
	return $rs;
}


public function get_budget($id)
{
	$rs = $this->db->select("od_budget")->where("id_bank_ac", $id)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->od_budget;
	}else{
		return 0;
	}
}

public function get_od_balance($id)
{
	$rs = $this->db->select("od_balance")->where("id_bank_ac", $id)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->od_balance;
	}else{
		return 0;
	}
}

public function loan_budget($id_bank_ac)
{
	$rs = $this->db->select("loan_budget")->where("id_bank_ac", $id_bank_ac)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->loan_budget;
	}else{
		return 0;
	}
}

public function loan_balance($id_bank_ac)
{
	$rs = $this->db->select("loan_balance")->where("id_bank_ac", $id_bank_ac)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->loan_balance;
	}else{
		return 0 ;
	}
}

public function valid_account($ac_number, $id_bank, $id = "")
{
	if( $id !="")
	{
		$rs = $this->db->where("id_bank_ac !=", $id)->where("ac_number", $ac_number)->where("id_bank", $id_bank)->get("tbl_bank_ac");
	}else{
		$rs = $this->db->where("ac_number", $ac_number)->where("id_bank", $id_bank)->get("tbl_bank_ac");
	}
	if( $rs->num_rows() > 0 )
	{
		return true;
	}else{
		return false;
	}
}

public function valid_code($ac_code, $id = "")
{
	if( $id !="")
	{
		$rs = $this->db->where("id_bank_ac !=", $id)->where("ac_code", $ac_code)->get("tbl_bank_ac");
	}else{
		$rs = $this->db->where("ac_code", $ac_code)->get("tbl_bank_ac");
	}
	if( $rs->num_rows() > 0 )
	{
		return true;
	}else{
		return false;
	}
}

public function valid_transection($id)
{
	$rs = $this->db->select("id_bank_ac")->where("id_bank_ac", $id)->get("tbl_cash_flow");
	if($rs->num_rows() > 0)
	{
		return true;
	}else{
		return false;
	}
}

public function is_in_book($id_bank_ac)  //// เมื่อมีการกู้เงิน เงินเข้าบัญชีหรือไม่
{
	$rs = $this->db->select("in_book")->where("id_bank_ac", $id_bank_ac)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->in_book;
	}else{
		return 0;
	}
}

public function int_method($id_bank_ac)
{
	$rs = $this->db->select("int")->where("id_bank_ac", $id_bank_ac)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->int;
	}else{
		return 0;
	}
}

public function get_id_bank($id_bank_ac)
{
	$rs = $this->db->select("id_bank")->where("id_bank_ac", $id_bank_ac)->get("tbl_bank_ac");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->id_bank;
	}else{
		return 0;
	}
}


public function get_balance($id_bank_ac, $date = '')
{
	$date = $date == '' ? date('Y-m-d') : $date;
	$qr = "SELECT balance FROM tbl_cash_flow WHERE id_bank_ac = ".$id_bank_ac." AND due_date <= '".$date."' ORDER BY due_date DESC, position DESC LIMIT 1";
	$rs = $this->db->query($qr);

	if($rs->num_rows() == 1)
	{
		return $rs->row()->balance;
	}

	return 0;
}


public function get_last_month_balance($id_bank_ac, $date = '')
{
	$date = $date == '' ? date('Y-m-d') : $date;
	$to = date('Y-m-t 23:59:59', strtotime("$date -1 month"));
	$qr = "SELECT balance FROM tbl_cash_flow ";
	$qr .= "WHERE id_bank_ac = ".$id_bank_ac." ";
	$qr .= "AND due_date <= '".$to."' ";
	$qr .= "ORDER BY due_date DESC, position DESC LIMIT 1";
	$rs = $this->db->query($qr);

	if($rs->num_rows() == 1)
	{
		return $rs->row()->balance;
	}

	return 0;
}

public function get_total_move_in($id_bank_ac, $date = '')
{
	$date = $date == '' ? date('Y-m-d') : $date;
	$from = date('Y-m-01 00:00:00', strtotime($date));
	$to = date('Y-m-t 23:59:59', strtotime($date));
	$qr = "SELECT SUM(cash_in) AS cash_in FROM tbl_cash_flow ";
	$qr .= "WHERE id_bank_ac = ".$id_bank_ac." ";
	$qr .= "AND due_date >= '".$from."' ";
	$qr .= "AND due_date <= '".$to."' ";

	$rs = $this->db->query($qr);

	if($rs->num_rows() == 1)
	{
		return $rs->row()->cash_in;
	}

	return 0;
}


public function get_total_move_out($id_bank_ac, $date = '')
{
	$date = $date == '' ? date('Y-m-d') : $date;
	$from = date('Y-m-01 00:00:00', strtotime($date));
	$to = date('Y-m-t 23:59:59', strtotime($date));
	$qr = "SELECT SUM(cash_out) AS cash_out FROM tbl_cash_flow ";
	$qr .= "WHERE id_bank_ac = ".$id_bank_ac." ";
	$qr .= "AND due_date >= '".$from."' ";
	$qr .= "AND due_date <= '".$to."' ";

	$rs = $this->db->query($qr);

	if($rs->num_rows() == 1)
	{
		return $rs->row()->cash_out;
	}

	return 0;
}

}// end class

?>
