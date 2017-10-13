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
    	<h3 style='margin-bottom:0px;'><?php echo $title; ?></h3>
    </div>
    <div class="col-lg-4">
    	 <p class="pull-right"><button type="button" class="btn btn-success btn-sm" onclick="refresh()"><i class="fa fa-refresh"></i> รีเฟรซ </button></p>
    </div>

</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />

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
<input type="hidden" name="id_bank_ac" id="id_bank_ac" value="<?php echo $id_bank_ac; ?>" />
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
			<button type="button" id="btn_update" onclick="update()" class="btn btn-success btn-sm"><i class="fa fa-save"></i>&nbsp; บันทึก</button>
		  </div>
		</div>
	</div>
</div>
<!------------------------------------------------- END Modal  ----------------------------------------------------------->
<?php 
	if(!isset($detail)){ $detail = ""; }
	if(!isset($reference)){ $reference = ""; }
	if(!isset($from_date)){ $from_date = ""; }
	if(!isset($to_date)){ $to_date = ""; }
?>
<div class="row">
<form id="search_form" action="<?php echo $this->home; ?>/search/<?php echo $id_bank_ac; ?>" method="post">
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="detail">รายการ</label>
	<input type="text" id="detail" name="detail" placeholder="ระบุรายการค้นหา" class="form-control" value="<?php echo $detail; ?>" />
</div>
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="reference">เลขที่เอกสาร</label>
	<input type="text" id="reference" name="reference" placeholder="ระบุเลขที่เอกสาร" class="form-control" value="<?php echo $reference; ?>" />
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
	<button type="button" class="btn btn-info btn-sm" id="btn_search" onclick="get_search()" ><i class="fa fa-search"></i>&nbsp; ค้นหา</button>
</div>
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="btn_reset" style="display:block;">&nbsp;</label>
	<a href="<?php echo $this->home; ?>/clear_filter/<?php echo $id_bank_ac; ?>"><button type="button" class="btn btn-warning btn-sm" id="btn_reset" ><i class="fa fa-refresh"></i>&nbsp; เคลีร์ยตัวกรอง</button></a>
</div>
</form>
</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:10px;' />
<div class="row">
<div class="col-lg-12">
<table class="table table-striped table-bordered table-hover">
<thead style="font-size:12px;">
	<th style="text-align:center; width:5%;"></th>
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
<?php 	$color_sc = ""; ?>
<?php if( isset($data) && $data != false) : ?>
<?php	foreach($data as $rs) : ?>
<?php		$due_date = thaiDate($rs->due_date, "", false); ?>
<?php 		$id		= $rs->id_cash_flow; ?>
	<tr id="<?php echo $id; ?>" style="background-color: <?php echo $rs->color.";"; ?><?php if($rs->od_balance < 0 ){ echo " color:red"; } ?>">
    	<td align="center">
        <select id="color<?php echo $id; ?>"><?php echo color_select(); ?></select>
		<?php if(can_do($a['add']) || can_do($a['edit']) )  : ?>
            	<select id="color<?php echo $id; ?>"><?php echo color_select(); ?></select>
            <?php endif; ?>
        </td>
    	<td><input type="hidden" id="remark<?php echo $id; ?>" value="<?php echo $rs->remark; ?>"  />
		<?php if(can_do($a['delete']) ) : ?>
        	<a href="javascript:void(0)" style="margin: 0px 2px 0px 2px;" onclick="delete_row(<?php echo $id; ?>, '<?php echo $due_date; ?>'  ,'เงินเข้า : <?php echo $rs->cash_in; ?>', 'เงินออก : <?php echo $rs->cash_out; ?>' )"><i class="fa fa-trash fa-2x red"></i></a>
        <?php endif; ?>
        <?php if( can_do($a['edit']) ) : ?>
        	&nbsp;&nbsp;
        	<a href="javascript:void(0)" style="margin: 0px 2px 0px 2px;" id="btn_edit_<?php echo $id; ?>" onclick="edit(<?php echo $id; ?>)" ><i class="fa fa-pencil fa-2x light-blue"></i></a> 
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
        <td align="right"><?php echo number($rs->od_balance,2); ?></td>
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
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js" type="text/javascript"></script>
<script>
<?php echo $color_sc; ?>
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

function edit(id)
{
	var due_date 			= $("#due_date"+id).val();
	var old_date			= $("#due_date"+id).val();
	var detail 				= $("#detail"+id).val();
	var reference 			= $("#reference"+id).val();
	var cash_in 			= $("#cash_in"+id).val();
	var cash_out 			= $("#cash_out"+id).val();
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
			data: {"id_bank_ac" : id_bank_ac, "old_date" : old_date, "due_date": due_date, "detail" : detail, "reference" : reference, "cash_in" : cash_in, "cash_out" : cash_out, "move_type" : move_type, "move_reference" : move_ref, "remark" : remark},
			success: function(rs)
			{
					location.href = "<?php echo base_url().uri_string(); ?>";
			}
		})
	}	
}

function change_color(id, color)
{
	if(color == 'lightgrey') { color = ''; }
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
	$("#edit_due_date").val("");	
	$("#edit_detail").val("");
	$("#edit_reference").val("");
	$("#edit_cash_in").val("");
	$("#edit_cash_out").val("");
	$("#edit_move_type").val("เช็ค");
	$("#edit_move_reference").val("");
	$("#edit_remark").val("");
}

$("#from_date").mask("99/99/9999");
$("#to_date").mask("99/99/9999");

$("#detail").bind("enterKey",function(){
	$("#reference").focus();
});

$("#reference").bind("enterKey",function(){
	$("#from_date").focus();
});

$("#from_date").bind("enterKey",function(){
	$("#to_date").focus();
});

$("#todate").bind("enterKey",function(){
	$("#btn_search").focus();
});
("#todate").bind("enterKey",function(){
	$("#btn_search").click();
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

$("#from_date").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#to_date").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});
$("#btn_search").keyup(function(e){
    if(e.keyCode == 13)
    {
        $(this).trigger("enterKey");
    }
});


function refresh()
{
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