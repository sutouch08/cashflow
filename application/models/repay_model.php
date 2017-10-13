<?php
class Repay_model extends CI_Model
{
public function __construct()
{
	parent:: __construct();
}

public function count_row($id_bank_ac)
{
	$rs = $this->db->where("id_bank_ac", $id_bank_ac)->count_all_results("tbl_repay");
	if($rs > 0 )
	{
		return $rs;
	}else{
		return false;
	}
}

public function get_data($id = '', $id_bank_ac, $perpage = 20, $limit = 1)
{
	if($id != '')
	{
		$rs = $this->db->where("id_repay", $id)->get("tbl_repay");
		if($rs->num_rows() == 1 )
		{
			return $rs->row_array();
		}else{
			return false;
		}
	}else{
		$rs = $this->db->where("id_bank_ac", $id_bank_ac)->order_by("date_add", "ASC")->limit($perpage, $limit)->get("tbl_repay");
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}else{
			return false;
		}
	}
}

public function get_search($id_bank_ac, $reference, $from_date, $to_date, $perpage = 20, $limit = 1)
{
	$this->db->where("id_bank_ac", $id_bank_ac);
	if( $reference != '' ){ $this->db->like('reference', $reference); }
	if( $from_date != '' && $to_date != '' ){ $this->db->where("date_add BETWEEN '$from_date' AND '$to_date'", NULL, false); }
	$rs = $this->db->where("id_bank_ac", $id_bank_ac)->order_by("date_add", "ASC")->get("tbl_repay");
	if($rs->num_rows() > 0 )
	{
		return $rs->result();
	}else{
		return false;
	}	
}

public function count_search_row($id_bank_ac, $reference, $from_date, $to_date)
{
	$this->db->where("id_bank_ac", $id_bank_ac);
	if( $reference != ''){ $this->db->like('reference', $reference); }
	if( $from_date != '' && $to_date != '' ){ $this->db->where("date_add BETWEEN '$from_date' AND '$to_date'", NULL, false); }
	$rs = $this->db->where("id_bank_ac", $id_bank_ac)->get("tbl_repay");
	return $rs->num_rows();	
}


public function get_reference($id_bank_ac)
{
	$option = "";
	$rs = $this->db->select("reference")->where("id_bank_ac", $id_bank_ac)->where("valid", 0)->get("tbl_loan");
	if($rs->num_rows() > 0)
	{
		$i = 1;
		$n = $rs->num_rows();
		foreach($rs->result() as $ro)
		{
			$reference = $ro->reference;
			$option .= "'".$reference."'";
			if($i < $n){ $option .= ", "; }
			$i++;
		}
	}
	return $option;
}

public function get_loan_id_by_reference($reference)
{
	$rs = $this->db->select("id_loan")->where("reference", $reference)->get("tbl_loan");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->id_loan;
	}else{
		return false;
	}
}

public function get_paid($id_loan)
{
	$rs = $this->db->select("paid")->where("id_loan", $id_loan)->get("tbl_loan");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->paid;
	}else{
		return false;
	}
}

public function amount($id_repay)
{
	$rs = $this->db->select("amount")->where("id_repay", $id_repay)->get("tbl_repay");
	if($rs->num_rows() == 1)
	{
		return $rs->row()->amount;
	}else{
		return 0;
	}
}

public function update_paid($id_loan, $paid)
{
	$rs = $this->db->query("UPDATE tbl_loan SET paid = paid + ".$paid." WHERE id_loan = ".$id_loan);
	return $rs;
}

public function add_row($data)
{
	$rs = $this->db->insert("tbl_repay", $data);
	return $this->db->insert_id();	
}

public function delete_row($id)
{
	$rs = $this->db->where("id_repay", $id)->delete("tbl_repay");
	return $rs;
}

public function get_id_cash_flow($id_repay)
{
	$rs = $this->db->select("id_cash_flow")->where("id_repay", $id_repay)->get("tbl_cash_flow");
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->id_cash_flow;
	}else{
		return false;
	}
}

public function change_color($id, $data)
{
	$rs = $this->db->where("id_repay", $id)->update("tbl_repay", $data);
	return $rs;
}
	
}/////// end class


?>