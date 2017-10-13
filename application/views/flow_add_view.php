<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.gritter.css" />
<script src="<?php echo base_url(); ?>assets/js/jquery.gritter.js"></script>
<?php 
	$p = valid_access($id_menu);  	
	$a = valid_ac($id_bank_ac); 
?>
<?php if($p['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class='row'>
	<div class='col-lg-8'>
    	<h3 style='margin-bottom:0px;'><?php echo $title; ?> - <?php echo bank_ac_detail($id_bank_ac); ?></h3>
    </div>
    <div class="col-lg-4">
    	 <p class="pull-right">
         <button type="button" class="btn btn-info btn-sm" onclick="recalculate(<?php echo $id_bank_ac; ?>)"><i class="fa fa-calculator"></i> recalculate </button>
         <button type="button" class="btn btn-success btn-sm" onclick="refresh()"><i class="fa fa-refresh"></i> รีเฟรซ  </button>
         </p>
    </div>

</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<div class="tabbable tabs-below">
<div class="tab-content">
<?php if(isset($search)){ $save = ""; $search = "active"; }else{ $save = "active"; $search = ""; } ?>
<div id="home2" class="tab-pane <?php echo $save; ?>">
<form class="form-horizontal" id="add_form" method="post" action="<?php echo $this->home."/add"; ?>">
<input type="hidden" name="add" value="1"  />
<input type="hidden" name="id_bank_ac" id="id_bank_ac" value="<?php echo $id_bank_ac; ?>" />
<input type="hidden" name="id_bank" id="id_bank" value="<?php echo $id_bank; ?>" />

<input type="text" name="disable_enter" style="display:none"  disabled="disabled" placeholder="เอาไว้ป้องกันการ SUBMIT โดยการกด Enter" />

<div class="row">

<div class="col-lg-2 col-md-4 col-sm-6">
    <label for="due_date">วันครบกำหนด</label>
    <div class="input-group">
	<input type="text" id="due_date" name="due_date" class="form-control" placeholder="ระบุวันที่เงินจะเข้าหรือออก" autofocus="autofocus" />
    <span class="input-group-addon" id="icon_calendar"><i class="fa fa-calendar"></i></span>
    </div>
</div>

<div class="col-lg-2 col-md-4 col-sm-6">
	<label for="detail">รายการ</label>
	<input type="text" id="detail" name="detail" placeholder="ระบุรายละเอียดของการเคลื่อนไหว" class="form-control" />
</div>

<div class="col-lg-2 col-md-4 col-sm-6">
	<label for="reference">เลขที่เอกสาร</label>
	<input type="text" id="reference" name="reference" placeholder="ระบุเลขที่เอกสาร แจ้งหนี้ ใบกำกับ ฯลฯ" class="form-control" />
</div>
<div class="col-lg-2 col-md-4 col-sm-6">
	<label for="cash_in">รับเงิน</label>
	<input type="text" id="cash_in" name="cash_in" placeholder="ระบุจำนวนเงินเข้า(กรณีรับเงิน)" class="form-control" />
</div>
<div class="col-lg-2 col-md-4 col-sm-6">
	<label for="cash_out">จ่ายเงิน</label>
	<input type="text" id="cash_out" name="cash_out" placeholder="ระบุจำนวนเงินออก(กรณีจ่ายเงิน)" class="form-control" />
</div>

<div class="col-lg-2 col-md-4 col-sm-6">
	<label for="move_type">รับ/จ่าย โดย</label>
	<select id="move_type" name="move_type" class="form-control" ><?php echo move_select(); ?></select>
</div>
<div class="col-lg-2 col-md-4 col-sm-6">
	<label for="move_reference">เลขที่อ้างอิง</label>
	<input type="text" id="move_reference" name="move_reference" placeholder="อ้างอิงเลขที่ เช็ค เลขที่การโอน ฯลฯ" class="form-control" />
</div>
<div class="col-lg-4 col-md-4 col-sm-6">
	<label for="remark">หมายเหตุ</label>
	<input type="text" id="remark" name="remark" placeholder="ระบุหมายเหตุการบันทึก(ถ้ามี)" class="form-control" />
</div>
<?php if(can_do($a['add'])) : ?>
<div class="col-lg-2 col-md-2 col-sm-6">
	<label for="btn_save">&nbsp;</label>
  
	<button type="button" id="btn_save" onclick="save()" class="btn btn-success btn-sm btn-block"><i class="fa fa-save"></i>&nbsp; บันทึก</button>
     
</div>
<?php endif; ?>
</div><!--/ Row -->
</form>
</div>
<div id="profile2" class="tab-pane <?php echo $search; ?>">
<?php 
	if(!isset($detail)){ $detail = ""; }
	if(!isset($reference)){ $reference = ""; }
	if(!isset($from_date)){ $from_date = ""; }
	if(!isset($to_date)){ $to_date = ""; }
?>
<div class="row">
<form id="search_form" action="<?php echo $this->home; ?>/search/<?php echo $id_bank_ac; ?>" method="post">
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="search_detail">รายการ</label>
	<input type="text" id="search_detail" name="detail" placeholder="ระบุรายการค้นหา" class="form-control" value="<?php echo $detail; ?>" />
</div>
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="search_reference">เลขที่เอกสาร</label>
	<input type="text" id="search_reference" name="reference" placeholder="ระบุเลขที่เอกสาร" class="form-control" value="<?php echo $reference; ?>" />
</div>
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="from_date">จากวันที่</label>
	<input type="text" id="from_date" name="from_date" placeholder="กำหนดวันที่เริ่มต้น" class="form-control" value="<?php if( $from_date != '' ){ echo thaiDate($from_date, false); } ?>" />
</div>
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="to_date">ถึงวันที่</label>
	<input type="text" id="to_date" name="to_date" placeholder="กำหนดวันที่สิ้นสุด" class="form-control" value="<?php if( $to_date != '' ){ echo thaiDate($to_date, false); } ?>" />
</div>
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="btn_search" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-info btn-sm btn-block" id="btn_search" onclick="get_search()" ><i class="fa fa-search"></i>&nbsp; ค้นหา</button>
</div>
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="btn_reset" style="display:block;">&nbsp;</label>
	<a href="<?php echo $this->home; ?>/clear_filter/<?php echo $id_bank_ac; ?>"><button type="button" class="btn btn-warning btn-sm btn-block" id="btn_reset" ><i class="fa fa-refresh"></i>&nbsp; เคลีร์ยตัวกรอง</button></a>
</div>
<div class="col-lg-2 col-md-3 col-sm-6" style="visibility:hidden">
	<label for="xx" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-warning btn-sm" id="xx" ><i class="fa fa-refresh"></i></button>
</div>
</form>
</div>
</div>
</div>
<ul class="nav nav-tabs" id="myTab2">
<li class="<?php echo $save; ?>"><a aria-expanded="true" data-toggle="tab" href="#home2"><i class="fa fa-save"></i>&nbsp; บันทึก</a></li>
<li class="<?php echo $search; ?>"><a aria-expanded="false" data-toggle="tab" href="#profile2"><i class="fa fa-search"></i>&nbsp; ค้นหา</a></li>
</ul>
<div class="row">
<div class="col-lg-12" style="height:1px !important">
<p class="pull-right" style="margin-top:-25px;">
จำนวนแถวต่อหน้า 
<input type="text" class="input-sm" id="set_rows" value="<?php echo $rows; ?>" style="width:50px; text-align:center; margin-left:15px; margin-right:15px;" />
<button class="btn btn-success btn-mini" onclick="set_rows()">บันทึก</button>
</p>
</div>
</div>
</div>





<!------------------------------------------------- Modal  ----------------------------------------------------------->
<button data-toggle='modal' data-target='#myModal' id='btn_toggle' style='display:none;'>xxx</button>
<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:800px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>แก้ไขรายการ</h4>
		  </div>
		  <div class='modal-body'>
<div class="row">
<input type="hidden" id="id_cash_flow"  />
<div class="col-lg-6 col-md-6 col-sm-6">
    <label for="edit_due_date">วันครบกำหนด</label>
    <div class="input-group">
	<input type="text" id="edit_due_date" class="form-control" placeholder="ระบุวันที่เงินจะเข้าหรือออก" autofocus="autofocus" />
    <input type="hidden" id="old_date"  />
    <span class="input-group-addon" id="icon_calendar"><i class="fa fa-calendar"></i></span>
    </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-6">
	<label for="edit_detail">รายการ</label>
	<input type="text" id="edit_detail" placeholder="ระบุรายละเอียดของการเคลื่อนไหว" class="form-control" />
</div>

<div class="col-lg-6 col-md-6 col-sm-6">
	<label for="edit_reference">เลขที่เอกสาร</label>
	<input type="text" id="edit_reference" placeholder="ระบุเลขที่เอกสาร แจ้งหนี้ ใบกำกับ ฯลฯ" class="form-control" />
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
	<label for="edit_cash_in">รับเงิน</label>
	<input type="text" id="edit_cash_in" placeholder="ระบุจำนวนเงินเข้า(กรณีรับเงิน)" class="form-control" />
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
	<label for="cash_out">จ่ายเงิน</label>
	<input type="text" id="edit_cash_out" placeholder="ระบุจำนวนเงินออก(กรณีจ่ายเงิน)" class="form-control" />
</div>

<div class="col-lg-6 col-md-6 col-sm-6">
	<label for="edit_move_type">รับ/จ่าย โดย</label>
	<select id="edit_move_type" class="form-control" ><?php echo move_select(); ?></select>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
	<label for="edit_move_reference">เลขที่อ้างอิง</label>
	<input type="text" id="edit_move_reference" placeholder="อ้างอิงเลขที่ เช็ค เลขที่การโอน ฯลฯ" class="form-control" />
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
	<label for="edit_remark">หมายเหตุ</label>
	<input type="text" id="edit_remark" placeholder="ระบุหมายเหตุการบันทึก(ถ้ามี)" class="form-control" />
</div>

</div><!--/ Row -->          
          
          </div>
		  <div class='modal-footer'>
          <?php if( can_do($a['edit']) ) : ?>
			<button type="button" id="btn_update" onclick="update()" class="btn btn-success btn-sm"><i class="fa fa-save"></i>&nbsp; บันทึก</button>
          <?php endif; ?>
		  </div>
		</div>
	</div>
</div>
<!------------------------------------------------- END Modal  ----------------------------------------------------------->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:20px;' />
<div class="row">
<div class="col-lg-12">
<table class="table table-striped table-bordered table-hover table-responsive">
<thead style="font-size:12px;">
	<th></th>
	<th style="text-align:right; width:10%" ></th>
	<th style="width:10%; text-align:center">Due date</th>
    <th style="width:15%; text-align:center">รายการ</th>
    <th style="width:10%; text-align:center">เลขที่เอกสาร</th>
    <th style="width:10%; text-align:center">เงินเข้า</th>
    <th style="width:10%; text-align:center">เงินออก</th>
    <th style="width:10%; text-align:center">คงเหลือ</th>
    <th style="width:10%; text-align:center">ใช้ได้</th>
    <th style="width:5%; text-align:center">โดย</th>
    <th style="text-align:center">อ้างอิง</th> 
    
</thead>
<tbody id="content">
<?php if( isset($data) && $data != false) : ?>
<?php 	$color_sc = ""; ?>
<?php	foreach($data as $rs) : ?>
<?php		$due_date = thaiDate($rs->due_date, "", false); ?>
<?php 		$id		= $rs->id_cash_flow; ?>
	<tr id="<?php echo $id; ?>" style="background-color: <?php echo $rs->color.";"; ?><?php if($rs->od_balance < 0 ){ echo " color:red"; } ?>">
    	<td>
			<?php if(can_do($a['add']) || can_do($a['edit']) )  : ?>
            	<select id="color<?php echo $id; ?>"><?php echo color_select(); ?></select>
            <?php endif; ?>
        </td>
    	<td><input type="hidden" id="remark<?php echo $id; ?>" value="<?php echo $rs->remark; ?>"  />
		<?php if(can_do($a['delete']) ) : ?>
        	<a href="javascript:void(0)" style="margin: 0px 2px 0px 2px;" onclick="delete_row(<?php echo $id; ?>, '<?php echo $due_date; ?>'  ,'เงินเข้า : <?php echo $rs->cash_in; ?>', 'เงินออก : <?php echo $rs->cash_out; ?>' )"><i class="fa fa-trash fa-2x red"></i></a>
        <?php endif; ?>
        <?php if( can_do($a['edit']) ) : ?>
        	<?php if( $rs->id_repay == 0 ) : ?>
        	&nbsp;&nbsp;
        	<a href="javascript:void(0)" style="margin: 0px 2px 0px 2px;" id="btn_edit_<?php echo $id; ?>" onclick="edit(<?php echo $id; ?>)" ><i class="fa fa-pencil fa-2x light-blue"></i></a> 
            <?php endif; ?>
        <?php endif; ?>
        <?php if( $rs->remark != "") : ?>
        		&nbsp;&nbsp;
            	<a href="javascript:void(0)" id="gritter_<?php echo $id; ?>"><i class="fa fa-exclamation-triangle fa-2x orange"></i></a>
                <script>
					$('#gritter_<?php echo $id; ?>').on(ace.click_event, function(){
						$.gritter.add({
							title: "<i class='fa fa-exclamation-triangle'></i> &nbsp;หมายเหตุ",
							text: '<?php echo $rs->remark; ?>',
							timer:'3000',
							sticky: false,
							class_name: 'gritter-info gritter-center'
						});
						return false;
					});
				</script>
            <?php endif; ?>
        </td>
    	<td><?php echo $due_date; ?><input type="hidden" id="due_date<?php echo $id; ?>" value="<?php echo $due_date; ?>"  /></td>
        <td><?php echo $rs->detail; ?><input type="hidden" id="detail<?php echo $id; ?>" value="<?php echo $rs->detail; ?>"  /></td>
        <td><?php echo $rs->reference; ?><input type="hidden" id="reference<?php echo $id; ?>" value="<?php echo $rs->reference; ?>"  /></td>
        <td align="right"><?php echo number($rs->cash_in,2); ?><input type="hidden" id="cash_in<?php echo $id; ?>" value="<?php echo $rs->cash_in; ?>"  /></td>    	
        <td align="right"><?php echo number($rs->cash_out,2); ?><input type="hidden" id="cash_out<?php echo $id; ?>" value="<?php echo $rs->cash_out; ?>"  /></td>
        <td align="right"><?php echo number($rs->balance,2); ?></td>
        <td align="right" ><?php echo balance($rs->od_balance,2); ?></td>
        <td align="center"><?php echo $rs->move_type; ?><input type="hidden" id="move_type<?php echo $id; ?>" value="<?php echo $rs->move_type; ?>"  /></td>
        <td><?php echo $rs->move_reference; ?><input type="hidden" id="move_reference<?php echo $id; ?>" value="<?php echo $rs->move_reference; ?>"  /></td>        
    </tr>
    <?php $color_sc .= "$('#color".$id."').ace_colorpicker().on('change', function() { var color = $('#color".$id."').val(); change_color(".$id.", color); }); "; ?>
<?php	endforeach; ?>
<?php else : ?>
	<tr>
	<td colspan="12">
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			<strong><i class="ace-icon fa fa-exclamation-circle"></i>&nbsp; ยังไม่มีรายการ</strong><br>
		</div>
    </td>
    </tr>
<?php endif; ?>
</tbody>
</table>
<?php echo $this->pagination->create_links(); ?>
</div>
<?php if(isset($ac_list)) : ?>
<div class="col-lg-12">
<?php $color = array("default", "primary", "info", "success", "warning", "danger", "inverse", "pink", "purple", "yellow", "grey", "light"); ?>
<?php $i = 0; ?>
<?php foreach($ac_list as $rd) : ?>
<?php  if( can_do($a['add']) || can_do($a['edit']) ) : ?>		
	<a href="<?php echo $this->home; ?>/add/<?php echo $rd->id_bank_ac; ?>" style="text-decoration:none;">
    	<button type="button" class="btn btn-<?php echo $color[$i]; ?> btn-xs" style="margin-bottom:10px;"><i class="fa fa-bolt"></i>&nbsp;<?php echo $rd->ac_code; ?></button>
    </a>
<?php $i++; if($i== 12){ $i=0; } ?>    
<?php 	endif; ?>    
<?php endforeach; ?>
</div>

<?php endif; ?>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js" type="text/javascript"></script>
<script id="template" type="text/x-handlebars-template">
	{{#if nocontent}}
		{{ nocontent }}
	{{else}}
		<tr>
			<td></td>
			<td align="right"></td>
			<td>{{ due_date }}</td>
			<td>{{ detail }}</td>
			<td>{{ reference }}</td>
			<td align="right">{{ cash_in }}</td>
			<td align="right">{{ cash_out }}</td>
			<td align="right">{{ balance }}</td>
			<td align="right">{{ od_balance }}</td>
			<td align="center">{{ move_type }}</td>
			<td>{{ move_reference }}</td>	
		</tr>
	{{/if}}
</script>
<script>
function recalculate(id_bank_ac)
{
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/recalculate/"+id_bank_ac,
		type:"GET", cache:false,
		success: function(rs){
			if(rs=="success")
			{	
				refresh();
				load_out();
			}else{
				load_out();
				swal("คำนวนรายการไม่สำเร็จ");
			}
		}
	});
}
$("#set_rows").numberOnly();
function set_rows()
{
	load_in();
	var rows =$("#set_rows").val();
	if(rows == "")
	{
		load_out();
		swal("จำนวนแถวต้องเป็นตัวเลขเท่านั้น");
		return false;
	}else{
		$.ajax({
			url:"<?php echo $this->home; ?>/set_rows",type:"POST",cache:false,
			data:{ "rows" : rows },
			success: function(rs)
			{
				if(rs == "success")
				{
					refresh();
					load_out();
				}else{
					load_out();
					swal("ไม่สามารถเปลี่ยนจำนวนแถวต่อหน้าได้ กรุณาลองใหม่อีกครั้งภายหลัง");
				}
			}
		});
	}
}
</script>
<script>
<?php echo $color_sc; ?>

$("#from_date").mask("99/99/9999");
$("#to_date").mask("99/99/9999");
$("#search_detail").keyup(function(e) { if(e.keyCode ==13){ $(this).trigger("enterKey"); }});
$("#search_detail").bind("enterKey", function(e){ $("#search_reference").focus(); });
$("#search_reference").keyup(function(e){ if(e.keyCode == 13){ $(this).trigger("enterKey"); }});
$("#search_reference").bind("enterKey", function(e){ $("#from_date").focus(); });
$("#from_date").keyup(function (e){ if(e.keyCode == 13){ $(this).trigger("enterKey"); }});
$("#from_date").bind("enterKey", function(e){ $("#to_date").focus(); });
$("#to_date").keyup(function (e){ if(e.keyCode == 13 ){ $(this).trigger("enterKey"); }});
$("#to_date").bind("enterKey", function(e){ $("#btn_search").focus(); });
function get_search()
{
	var detail = $("#detail").val();
	var ref	= $("#reference").val();
	var from 	= $("#from_date").val();
	var to 	= $("#to_date").val();
	load_in();
	if(from != "" || to != "")
	{
		if( !isDate(from) || !isDate(to) )
		{
			swal("รูปแบบวันที่ไม่ถูกต้อง", "กรุณาตรวจสอบวันที่ รูปแบบที่ถูกต้องคือ  วว/ดด/ปปปป", "error");
			load_out();
			return false;
		}else{
			$("#search_form").submit();
		}
	}
	$("#search_form").submit();
}

function change_color(id, color)
{
	if(color == 'lightgrey'){ color = ''; }
	load_in();
	$.ajax({
		url:'<?php echo $this->home; ?>/change_color/'+ id,
		type:"POST", cache:false, 
		data:{ "color" : color },
		success: function(rs){
			if(rs == 'success'){
				load_out();
				if(color != ''){
					$("#"+id).css("background-color", color);
				}else{
					$("#"+id).css("background-color", "");
				}
			}else{
				swal("ไม่สามารถเปลี่ยนสีได้");
			}
		}		
	});
}

function edit(id)
{
	var due_date 			= $("#due_date"+id).val();
	var old_date			= $("#due_date"+id).val();
	var detail 				= $("#detail"+id).val();
	var reference 			= $("#reference"+id).val();
	var cash_in 			= $("#cash_in"+id).val();
	var cash_out 			= $("#cash_out"+id).val();
	var pn					= $("#pn"+id).val();
	var move_type 		= $("#move_type"+id).val();
	var move_reference = $("#move_reference"+id).val();
	$("#edit_cash_in").css("visibility","");
	$("#edit_cash_out").css("visibility","");
	$("#edit_cash_in").val(cash_in);
	$("#edit_cash_out").val(cash_out);
	if( cash_in > 0 && cash_out == 0)
	{
		$("#edit_cash_out").css("visibility", "hidden");
	}else{
		$("#edit_cash_in").css("visibility", "hidden");
	}
	$("#id_cash_flow").val(id);
	$("#edit_due_date").val(due_date);
	$("#old_date").val(old_date);
	$("#edit_detail").val(detail);
	$("#edit_reference").val(reference);
	$("#edit_move_type").val(move_type);
	$("#edit_move_reference").val(move_reference);
	$("#btn_toggle").click();	
}

function update()
{
	$("#btn_toggle").click();
	$("#btn_update").attr("disabled", "disabled");
	var id_cash_flow 	= $("#id_cash_flow").val();
	var id_bank 		= $("#id_bank").val();
	var id_bank_ac 	= $("#id_bank_ac").val();
	var old_date 		= $("#old_date").val();
	var due_date 		= $("#edit_due_date").val();
	var detail				= $("#edit_detail").val();
	var reference 		= $("#edit_reference").val();
	var cash_in			= $("#edit_cash_in").val();
	var cash_out		= $("#edit_cash_out").val();	
	var move_type		= $("#edit_move_type").val();
	var move_ref 		= $("#edit_move_reference").val();
	var remark 			= $("#edit_remark").val();
	load_in();
	if( !isDate(due_date) )
	{
		swal("รูปแบบวันที่ไม่ถูกต้อง");
		return false;
	}else{
		$.ajax({
			url:"<?php echo $this->home; ?>/update_row/"+id_cash_flow,
			type:"GET", cache:false,
			data: {"id_bank" : id_bank, "id_bank_ac" : id_bank_ac, "old_date" : old_date, "due_date": due_date, "detail" : detail, "reference" : reference, "cash_in" : cash_in, "cash_out" : cash_out, "move_type" : move_type, "move_reference" : move_ref, "remark" : remark},
			success: function(rs)
			{
					location.href = "<?php echo base_url().uri_string(); ?>";
					
			}
		})
	}	
}

function save()
{
	load_in();
	$("#btn_save").attr("disabled","disabled");
	var el 	= $("#due_date");
	var due_date = $("#due_date").val();
	var detail			= $("#detail").val();
	var cash_in		= parseFloat($("#cash_in").val());
	var cash_out	= parseFloat($("#cash_out").val());
	
	if(due_date == "")
	{
		date_error("กรุณาระบุวันที่ครบกำหนด","", el);
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if(! isDate(due_date)){
		date_error("รูปแบบวันที่ไม่ถูกต้อง", "รูปแบบที่ถูกต้องคือ dd/mm/yyy เช่น <?php echo thai_date(); ?> หรือ เลือกวันที่จากปฏิทิน", el);
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if((cash_in == "" || cash_in == 0) && (cash_out == "" || cash_out == 0) ){
		swal("ช่อง รับเงิน และ จ่ายเงิน ต้องระบุช่องใดช่องหนึ่ง และช่องที่ระบุต้องมากกว่า 0");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if( cash_in !="" && cash_out != "" && cash_in != 0 && cash_out !=0 ){
		swal("ช่อง รับเงิน และ จ่ายเงิน ต้องระบุช่องใดช่องหนึ่ง");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if( ( (cash_in != "" && cash_in !=0) && isNaN(cash_in) ) ){
		swal("ช่องรับเงิน ต้องระบุเป็นตัวเลขเท่านั้น");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if( ( (cash_out != "" && cash_out != 0 ) && isNaN(cash_out) ) ){
		swal("ช่องจ่ายเงิน ต้องระบุเป็นตัวเลขเท่านั้น");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;	
	}else{
		$.ajax({
			url: "<?php echo $this->home; ?>/add_row",
			type:"POST", cache:false,data: $("#add_form").serialize(),
			success: function(data){
				if(data != "error"){
					var source = $("#template").html();
					var data = $.parseJSON(data);
					var template = Handlebars.compile(source);
					var row = template(data);
					$("#content").append(row);
					clear_field();
					$("#btn_save").removeAttr("disabled");
					load_out()
				}else{
					swal("การส่งข้อมูลผิดพลาด");
					$("#btn_save").removeAttr("disabled");
					load_out();
				}
			}
		});

	}
}

function date_error(title, text, el)
{
	swal({
			  title: title,
			  text: text,
			  type: "error",
			  showCancelButton: false,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "ตกลง",
			  closeOnConfirm: true},
			  function(isConfirm){
			  if (isConfirm) {
				el.focus();
			  } 
			});
			el.focus();
}

function clear_field()
{
	$("#due_date").val("");	
	$("#detail").val("");
	$("#reference").val("");
	$("#customer").val("");
	$("#supplier").val("");
	$("#cash_in").val("");
	$("#cash_out").val("");
	$("#move_type").val("เช็ค");
	$("#move_reference").val("");
	$("#remark").val("");
	$("#due_date").focus();
}

$("#due_date").mask("99/99/9999");

$("#due_date").bind("enterKey",function(){
	$("#detail").focus();
});

$("#detail").bind("enterKey",function(){
	$("#reference").focus();
});

$("#reference").bind("enterKey",function(){
	$("#cash_in").focus();
});

$("#cash_in").bind("enterKey",function(){
	if($(this).val() =="")
	{
		$(this).val(0);
	}
	$("#cash_out").focus();
});

$("#cash_out").bind("enterKey",function(){
	if($(this).val() =="")
	{
		$(this).val(0);
	}
	$("#move_type").focus();
});

$("#move_type").bind("enterKey",function(){
	$("#move_reference").focus();
});

$("#move_reference").bind("enterKey",function(){
	$("#remark").focus();
});

$("#remark").bind("enterKey",function(){
	$("#btn_save").focus();
});

$("#btn_save").bind("enterKey",function(){
	$("#btn_save").click();
});



$("#due_date").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#detail").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#reference").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});

$("#cash_in").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#cash_out").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#move_type").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#move_reference").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#remark").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#btn_save").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});

function refresh()
{
	load_in();
	location.href = "<?php echo base_url().uri_string(); ?>";
}

function delete_row(id, date, s_in, out)
{
	swal({
 		title: "<strong>คุณแน่ใจนะ ?</strong>",
  		text: "โปรดตรวจสอบให้ดีว่าคุณต้องการลบรายการนี้ <br/> "+date+" &nbsp;"+s_in+" &nbsp;" + out,
  		type: "warning",
		html : true,
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "ใช่ ฉันต้องการลบ",
	  cancelButtonText: "ไม่ใช่",
	  closeOnConfirm: true,
	  closeOnCancel: true
	},
	function(isConfirm){
	  if (isConfirm) {
		  load_in();
			$.ajax({
			url:"<?php echo $this->home; ?>/delete_row/"+id,
			type:"GET", cache:false,
			success: function(rs){
				load_out();
				var rs = $.trim(rs);
				if(rs == "success")
				{
					swal({title: "สำเร็จ", text: "ลบรายการเรียบร้อยแล้ว", timer: 1000, type: "success"});
					$("#"+id).remove();
				}else if(rs =="fail"){
					swal("ผิดพลาด","ลบรายการไม่สำเร็จ","error");
				}
			}
		});
	  } 
	});
}

$("#edit_due_date").mask("99/99/9999");

$("#edit_due_date").bind("enterKey",function(){
	$("#edit_detail").focus();
});

$("#edit_detail").bind("enterKey",function(){
	$("#edit_reference").focus();
});

$("#edit_reference").bind("enterKey",function(){
	if($("#edit_cash_in").css("visibility") )
	{
		$("#edit_cash_out").focus();
	 }else{
		 $("#edit_cash_in").focus();
	 }
});

$("#edit_cash_in").bind("enterKey",function(){
	if($(this).val() =="")
	{
		swal("กรุณาระบุจำนวนที่มากกว่า 0 ");
	}else if( $("#edit_cash_out").css("visibility") ){
		$("#edit_move_type").focus();
	}else{
		$("#edit_cash_out").focus();
	}
});

$("#edit_cash_out").bind("enterKey",function(){
	if($(this).val() =="")
	{
		$(this).val(0);
	}
	$("#edit_move_type").focus();
});

$("#edit_move_type").bind("enterKey",function(){
	$("#edit_move_reference").focus();
});

$("#edit_move_reference").bind("enterKey",function(){
	$("#edit_remark").focus();
});

$("#edit_remark").bind("enterKey",function(){
	$("#btn_update").focus();
});

$("#btn_update").bind("enterKey",function(){
	$("#btn_btn_update").click();
});



$("#edit_due_date").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#edit_detail").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#edit_reference").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});

$("#edit_cash_in").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#edit_cash_out").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#edit_move_type").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#edit_move_reference").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#edit_remark").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#edit_btn_save").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});

</script>

<?php endif; ?>