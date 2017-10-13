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
    	 <p class="pull-right"><button type="button" class="btn btn-success btn-sm" onclick="refresh()"><i class="fa fa-refresh"></i> รีเฟรซ ( F5 ) </button></p>
    </div>

</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
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
			<input type="hidden" name="id_bank_ac" id="id_bank_ac" value="<?php echo $id_bank_ac; ?>" />
			<input type="hidden" name="id_bank" id="id_bank" value="<?php echo $id_bank; ?>" />
            <input type="hidden" name="id_loan" id="id_loan" />
            <input type="hidden" name="old_date" id="old_date" />
			<input type="text" name="disable_enter" style="display:none"  disabled="disabled" placeholder="เอาไว้ป้องกันการ SUBMIT โดยการกด Enter" />
            <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label for="edit_date_add">วันที่เพิ่ม</label>
                <div class="input-group">
                <input type="text" id="edit_date_add" name="edit_date_add" class="form-control" placeholder="วันที่เอกสาร" style="text-align: center" autofocus="autofocus" />
                <span class="input-group-btn" id="icon_calendar"><button type="button" class="btn btn-default btn-sm" onclick="get_balance()" ><i class="fa fa-calendar"></i>&nbsp; Go!</button></span>
                </div>
            </div>
             <div class="col-lg-6 col-md-6 col-sm-12">
                <label for="edit_detail">รายการ</label>
                <input type="text" id="edit_detail" name="edit_detail" placeholder="ระบุรายละเอียด" class="form-control" />
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <label for="edit_reference">เลขที่เอกสาร</label>
                <input type="text" id="edit_reference" name="edit_reference" placeholder="ระบุเลขที่เอกสาร PN/LC" class="form-control" style="text-align: center" />
            </div>
             <div class="col-lg-6 col-md-6 col-sm-12">
                <label for="edit_amount">จำนวนเงิน</label>
                <input type="text" id="edit_amount" name="edit_amount" placeholder="จำนวนเงินที่กู้" class="form-control" style="text-align: center" />
            </div>
             <div class="col-lg-6 col-md-6 col-sm-12">
                <label for="edit_rate">ดอกเบี้ย</label>
                <div class="input-group">
                <input type="text" id="edit_rate" name="edit_rate" placeholder="อัตราดอกเบี้ย" class="form-control" style="text-align: center" />
                <span class="input-group-addon">%</span>
                </div>
            </div>
             <div class="col-lg-6 col-md-6 col-sm-12">
                <label for="edit_days">ระยะเวลา</label>
                <div class="input-group">
                <input type="text" id="edit_days" name="edit_days" placeholder="ระยะเวลาชำระคืน" class="form-control" style="text-align: center" />
                <span class="input-group-addon">วัน</span>
                </div>
            </div>
             <div class="col-lg-12 col-md-12 col-sm-12">
                <label for="edit_remark">หมายเหตุ</label>
                <input type="text" id="edit_remark" name="edit_remark" placeholder="ระบุหมายเหตุการบันทึก(ถ้ามี)" class="form-control" />
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
<!------------------------------------------------- Modal  ----------------------------------------------------------->
<button data-toggle='modal' data-target='#roomModal' id='btn_room_toggle' style='display:none;'>xxx</button>
<div class='modal fade' id='roomModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:600px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>ดูรายการ</h4>
		  </div>
		  <div class='modal-body'>
			<table class="table table-striped table-bordered table-hover">
            <thead>
            	<th style="width:15%;" class="align-center">วันที่</th><th style="width:25%;" class="align-right">ใช้ไป</th><th style="width:25%;" class="align-right">จ่ายคืน</th><th  class="align-right">ใช้ได้</th>
            </thead>
            <tbody id="room">
            
            </tbody>
            </table>
          </div>
		  <div class='modal-footer'>
			<button type="button"  class="btn btn-success btn-sm" data-dismiss="modal"><i class="fa fa-check"></i>&nbsp; ปิด</button>
		  </div>
		</div>
	</div>
</div>
<!------------------------------------------------- END Modal  ----------------------------------------------------------->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:20px;' />

<table class="table table-striped table-bordered table-hover">
<thead style="font-size:12px;">
	<th style="text-align:right; width:5%"></th>
	<th style="text-align:right; width:10%" ></th>
	<th style="width:10%; text-align:center">วันที่</th>
    <th style="text-align:center">รายการ</th>
    <th style="width:10%; text-align:center">เลขที่เอกสาร</th>
    <th style="width:10%; text-align:center">จำนวนเงิน</th>
    <th style="width:10%; text-align:center">จ่ายแล้ว</th>
    <th style="width:5%; text-align:center">ดอกเบี้ย</th>
    <th style="width:7%; text-align:center">ระยะเวลา</th>
    <th style="width:10%; text-align:center">วันครบกำหนด</th>  
</thead>
<tbody id="content">
<?php 	$color_sc = ""; ?>
<?php if( isset($data) && $data != false) : ?>
<?php	foreach($data as $rs) : ?>
<?php		$due_date = thaiDate($rs->due_date, "", false); ?>
<?php        $date_add = thaiDate($rs->date_add, "", false); ?>
<?php 		$id		= $rs->id_loan; ?>
	<tr id="<?php echo $id; ?>" style="background-color: <?php echo $rs->color; ?>">
    	<td align="center">
		<?php if(can_do($a['add']) || can_do($a['edit']) )  : ?>
            	<select id="color<?php echo $id; ?>"><?php echo color_select(); ?></select>
            <?php endif; ?>
            </td>
    	<td><input type="hidden" id="remark<?php echo $id; ?>" value="<?php echo $rs->remark; ?>"  />
        <?php if(!$rs->valid) : ?>
		<?php if(can_do($a['delete']) ) : ?>
        	<a href="javascript:void(0)" style="margin: 0px 2px 0px 2px;" onclick="delete_row(<?php echo $id; ?>, '<?php echo $date_add; ?>'  ,' : <?php echo $rs->reference; ?>', ': <?php echo $rs->detail; ?>' )"><i class="fa fa-trash fa-2x red"></i></a>
        <?php endif; ?>
        <?php if( can_do($a['edit']) ) : ?>
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
    	<td align="center"><?php echo $date_add; ?><input type="hidden" id="date_add<?php echo $id; ?>" value="<?php echo $date_add; ?>"  /></td>
        <td><?php echo $rs->detail; ?><input type="hidden" id="detail<?php echo $id; ?>" value="<?php echo $rs->detail; ?>"  /></td>
        <td><?php echo $rs->reference; ?><input type="hidden" id="reference<?php echo $id; ?>" value="<?php echo $rs->reference; ?>"  /></td>
        <td align="right"><?php echo number($rs->amount,2); ?><input type="hidden" id="amount<?php echo $id; ?>" value="<?php echo $rs->amount; ?>"  /></td>  
        <td align="right"><?php echo number($rs->paid,2); ?></td>  	
        <td align="center"><?php echo $rs->rate; ?> %<input type="hidden" id="rate<?php echo $id; ?>" value="<?php echo $rs->rate; ?>"  /></td>
        <td align="center"><?php echo number($rs->days); ?><input type="hidden" id="days<?php echo $id; ?>" value="<?php echo $rs->days; ?>"  /></td>
        <td align="center"><?php echo $due_date; ?></td>   
    </tr>
    <?php $color_sc .= "$('#color".$id."').ace_colorpicker().on('change', function() { var color = $('#color".$id."').val(); change_color(".$id.", color); }); "; ?>
<?php	endforeach; ?>
<?php else : ?>

<?php endif; ?>
</tbody>
</table>
<?php echo $this->pagination->create_links(); ?>

<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>script/loan_add.js" type="text/javascript"></script>
<script id="template" type="text/x-handlebars-template">
	{{#if nocontent}}
		{{ nocontent }}
	{{else}}
		<tr>
			<td align="center"></td>
			<td align="right"></td>
			<td align="center">{{ date_add }}</td>
			<td>{{ detail }}</td>
			<td>{{ reference }}</td>
			<td align="right">{{ amount }}</td>
			<td align="right">{{ paid }}</td>
			<td align="center">{{ rate }}</td>
			<td align="center">{{ days }}</td>
			<td align="center">{{ due_date }}</td>
		</tr>
	{{/if}}
</script>
<script id="room_template" type="text/x-handlebars-template">
	
	{{#each this}}
		<tr>
			<td align="center">{{ date }}</td>
			<td align="right">{{ used }}</td>
			<td align="right">{{ paid }}</td>
			<td align="right">{{ balance }}</td>
		</tr>
	{{/each}}
</script>

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

$("#date_add").keyup(function(e) {
    if(e.keyCode == 107){ $(this).trigger("addKey"); }
});
$("#date_add").bind("addKey", function(e){ get_balance(); });

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
function edit(id)
{
	var date_add 	= $("#date_add"+id).val();
	var old_date	= $("#date_add"+id).val();
	var detail 		= $("#detail"+id).val();
	var reference	= $("#reference"+id).val();
	var amount	 	= $("#amount"+id).val();
	var rate		 	= $("#rate"+id).val();
	var days			= $("#days"+id).val();
	var remark		= $("#remark"+id).val();	
	$("#edit_amount")		.val(amount);
	$("#id_loan")				.val(id);
	$("#edit_date_add")	.val(date_add);
	$("#old_date")			.val(old_date);
	$("#edit_detail")			.val(detail);
	$("#edit_reference")	.val(reference);
	$("#edit_rate")			.val(rate);
	$("#edit_days")			.val(days);
	$("#edit_remark")		.val(remark);
	$("#btn_toggle").click();	
}

function update()
{
	$("#btn_toggle").click();
	$("#btn_update").attr("disabled", "disabled");
	var id_loan		 	= $("#id_loan").val();
	var id_bank 		= $("#id_bank").val();
	var id_bank_ac 	= $("#id_bank_ac").val();
	var old_date 		= $("#old_date").val();
	var date_add 		= $("#edit_date_add").val();
	var detail				= $("#edit_detail").val();
	var reference 		= $("#edit_reference").val();
	var amount			= $("#edit_amount").val();
	var rate				= $("#edit_rate").val();	
	var days				= $("#edit_days").val();
	var remark 			= $("#edit_remark").val();
	load_in();
	if( !isDate(date_add) )
	{
		swal("รูปแบบวันที่ไม่ถูกต้อง");
		return false;
	}else{
		$.ajax({
			url:"<?php echo $this->home; ?>/update_row/"+id_loan,
			type:"GET", cache:false,
			data: {"id_bank" : id_bank, "id_bank_ac" : id_bank_ac, "old_date" : old_date, "date_add": date_add, "detail" : detail, "reference" : reference, "amount" : amount, "rate" : rate, "days" : days, "remark" : remark},
			success: function(rs)
			{	
				location.href = "<?php echo base_url().uri_string(); ?>";					
			}
		})
	}	
}

function start_save()
{
	var date 		= $("#start_date_add").val();
	var detail 	= $("#start_detail").val();
	var amount 	= parseFloat($("#start_amount").val());
	$("#btn_save").attr("disabled", "disabled");
	load_in();
	if( !isDate(date) )
	{
		swal("รูปแบบวันที่ไม่ถูกต้อง");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else if( isNaN(amount) ){
		swal("ตัวเลขจำนวนเงินไม่ถูกต้อง");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else{
		$("#add_form").submit();
	}
}

function save()
{
	load_in();
	$("#btn_save").attr("disabled","disabled");
	var due_date 	= $("#date_add").val();
	var el 			= $("#date_add");
	var detail			= $("#detail").val();
	var amount		= parseFloat($("#amount").val());
	var rate			= parseFloat($("#rate").val());
	var days			= $("#days").val();
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
	}else if(amount == "" || amount < 0){
		swal("จำนวนเงินที่ระบุต้องมากกว่าที่ระบุต้องมากกว่า 0");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if(rate === '' ){
		swal("อัตราดอกเบี้ยต้องระบุอย่างน้อย 0.000");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;	
	}else{
		$.ajax({
			url: "<?php echo $this->home; ?>/add_row",
			type:"POST", cache:false,data: $("#add_form").serialize(),
			success: function(data){
				if(data != "error"){
					var source 		= $("#template").html();
					var data 			= $.parseJSON(data);
					var template 	= Handlebars.compile(source);
					var row 			= template(data);
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

function refresh(){  location.href = "<?php echo base_url().uri_string(); ?>"; }

function delete_row(id, date, ref, detail)
{
	swal({
 		title: "<strong>คุณแน่ใจนะ ?</strong>",
  		text: "โปรดตรวจสอบให้ดีว่าคุณต้องการลบรายการนี้ <br/> "+date+" &nbsp;"+ref+" &nbsp;" + detail,
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

function get_balance()
{
	var date = $("#date_add").val();
	var id_bank_ac = $("#id_bank_ac").val();
	load_in();
	if(!isDate(date))
	{
		load_out();
		swal("วันที่ไม่ถูกต้อง");
		$("#date_add").focus();
		return false;
	}else{
		$.ajax({
			url: "<?php echo $this->home; ?>/view_balance",type:"POST", cache:false,
			data:{"id_bank_ac" : id_bank_ac, "date" : date},
			success: function(data)
			{
				var source 		= $("#room_template").html();
				var data 			= $.parseJSON(data);
				var template 	= Handlebars.compile(source);
				var row 			= template(data);
				$("#room").html(row);
				$("#btn_room_toggle").click();
				load_out()
			}
		});
	}
}

$("#roomModal").on('hidden.bs.modal', function(e){ $("#date_add").focus();});
</script>
<?php endif; ?>