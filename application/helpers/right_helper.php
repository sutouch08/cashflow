<?php

function isOpen($id_group, $id_menu)
{
	$group[0] = array("1"=>1, "2"=>1, "3"=>1, "4"=>1, "5"=>1, "6"=>1, "7"=>1, "8"=>1, "9"=>1, "11"=>1);
	$group[1] = array("12"=>1, "13"=>1);
	if( isset($group[$id_group][$id_menu]) )
	{
		return "open";
	}else{
		return "";
	}
}

function active_menu($value, $id_menu)
{
	if($value == $id_menu)
	{
		return "active";
	}else{
		return "";
	}
}


function valid_menu($id_menu, $url)
{	
	$c =& get_instance();
	$id_profile = $c->session->userdata("id_profile");
	if($id_profile == 0)
	{
		$url = base_url().$url;
	}else{
		$c->db->select("view");
		$ro = $c->db->get_where("tbl_access", array("id_profile"=>$id_profile, "id_menu"=>$id_menu), 1);
		if($ro->num_rows() ==1)
		{
			$rs = $ro->row();
			if($rs->view == 1)
			{ 
				$url = base_url().$url;
			}else{
				$url = "#";
			}
		}else{
			$url = "#";
		}
	}
	return $url;
}

function valid_access($id_menu)
{
	$c =& get_instance();
	$id_profile = $c->session->userdata("id_profile");
	$result = array();
	if( $id_profile == 0 )
	{
		$result['view'] = 1;
		$result['add'] = 1;
		$result['edit'] = 1;
		$result['delete'] = 1;
		$result['print'] = 1;
		$result['approve'] = 1;
		
	}else{
		if( $id_menu != "" && $id_menu != 0 )
		{
			$limit = 1; // Limit 1 row
			$ro = $c->db->get_where("tbl_access", array("id_profile"=>$id_profile, "id_menu"=>$id_menu), $limit);
			if($ro->num_rows() ==1)
			{
				$rs = $ro->row();
				$result['view'] = $rs->view;
				$result['add'] = $rs->add;
				$result['edit'] = $rs->edit;
				$result['delete'] = $rs->del;
				$result['print'] = $rs->print;
				$result['approve'] = $rs->approve;
			}
		}else{
			$result['view'] = 1;
			$result['add'] = 0;
			$result['edit'] = 0;
			$result['delete'] = 0;
			$result['print'] = 0;
			$result['approve'] = 0;
		}
	}
	return $result;
}

function cando($permission, $action)
{	
	if($permission != 1)
	{
		$action = "";
	}
	return $action;
}


function can_do($perm)
{
	if($perm == 1)
	{
		return true;
	}else{
		return false;
	}
}


function valid_ac($id_bank_ac)/////  ตรวจสอบสิทธิ์ ว่าสามารถทำรายการบัญชีนี้ได้หรือไม่
{
	$c =& get_instance();
	if($c->session->userdata("id_profile") == 0 )
	{
		$rs['view']	= 1;
		$rs['add']	 = 1;
		$rs['edit']	 = 1;
		$rs['delete'] = 1;
	}else{
		$rd = $c->db->where("id_user", $c->session->userdata("id_user"))->where("id_bank_ac", $id_bank_ac)->get("tbl_ac_access");
		if($rd->num_rows() == 1)
		{
			$rs['view']	= $rd->row()->view;
			$rs['add']	 = $rd->row()->add;
			$rs['edit']	 = $rd->row()->edit;
			$rs['delete'] = $rd->row()->delete;
		}else{
			$rs['view']	= 0;
			$rs['add']	 = 0;
			$rs['edit']	 = 0;
			$rs['delete'] = 0;
		}
	}
	return $rs;		
}

function action_deny()
{
	$c =& get_instance();
	setError("คุณไม่ได้รับอนุญาติในการกระทำนี้");
	redirect($c->home);
}

function access_deny()
{
	$c =& get_instance();
	setError("คุณไม่ได้รับอนุญาติให้เข้าหน้านี้");
	redirect($c->home);	
}

?>