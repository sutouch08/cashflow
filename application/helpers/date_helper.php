<?php 


function thaiDate($date="", $sep="/", $show_time=false)
{
	if($date ==""){ $date = date("Y-m-d"); }
	if($sep ==""){ $sep = "/"; }
	$Y = date("Y", strtotime($date)) + 543;
	$er = date("1971")+543;
	if($Y < $er){
		return "error";
	}else{
		if(!$show_time ){
			return date("d".$sep."m".$sep.$Y, strtotime($date));
		}else{
			return date("d".$sep."m".$sep.$Y." H:i:s", strtotime($date));
		}
	}
}

function dbDate($date="", $show_time=true)
{
	if($date == ""){ $date = date("Y-m-d"); }
	if($show_time)
	{
		$date = date("Y-m-d H:i:s", strtotime($date));
	}else{
		$date = date("Y-m-d", strtotime($date));
	}
	return $date;
}


function date_convert($ttt)  /// แปลง พ.ศ. เป็น ค.ศ.
{
	$d1 = substr($ttt, 0, 2);
	$m1 = substr($ttt, 3, 2);
	$y = substr($ttt, 6, 4) ;
	$y1 = $y-543;
	$h1 = substr($ttt, 10, 6);
	if ($ttt == "")
	{
		return "";
	} else	{
		return $y1 . "-" . $m1 . "-" . $d1;
	}
}

function thaiDate_to_dbDate($date="", $show_time=true)
{
	if($date == "") { $y = date("Y")+543; $date = date("$y-m-d"); }	
	$date = date_convert($date);
	if($show_time)
	{
		$date = date("Y-m-d H:i:s", strtotime($date));
	}
	return $date;
}


function thai_date($date="", $sep="/")
{
	if( $date =="")
	{
		$date = date("Y/m/d");
	}
	$y 	= date("Y", strtotime($date)) + 543;
	$date = date("d".$sep."m".$sep.$y, strtotime($date));
	return $date;
}

function NOW()
{
	return date("Y-m-d H:i:s");	
}

function dateDiff($from, $to)
{
	$fdate = strtotime($from);
	$tdate = strtotime($to);	
	$diff = ($tdate - $fdate)/(3600*24);
	return round($diff);
}
?>