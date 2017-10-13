<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
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
	<button type="button" class="btn btn-info btn-sm" id="btn_search" onclick="get_search()" ><i class="fa fa-search"></i>&nbsp; ค้นหา</button>
</div>
<div class="col-lg-2 col-md-3 col-sm-6">
	<label for="btn_reset" style="display:block;">&nbsp;</label>
	<a href="<?php echo $this->home; ?>/clear_filter/<?php echo $id_bank_ac; ?>"><button type="button" class="btn btn-warning btn-sm" id="btn_reset" ><i class="fa fa-refresh"></i>&nbsp; เคลีร์ยตัวกรอง</button></a>
</div>
</form>
</div>

<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:20px;' />
<div class="row">
<table class="table table-striped table-bordered table-hover">
<thead style="font-size:12px;">
	<th style="text-align:right; width:5%"></th>
	<th style="text-align:right; width:5%" ></th>
	<th style="width:15%; text-align:center">วันที่</th>
    <th style="width:15%; text-align:center">เลขที่เอกสาร</th>
    <th style="width:15%; text-align:center">จำนวนเงิน</th>
    <th style="text-align:center">หมายเหตุ</th>
</thead>
<tbody id="content" >
<?php 	$color_sc = ""; ?>
<?php if( isset($data) && $data != false) : ?>
<?php	foreach($data as $rs) : ?>
<?php        $date_add = thaiDate($rs->date_add, "", false); ?>
<?php 		$id		= $rs->id_repay; ?>
	<tr id="<?php echo $id; ?>" style="background-color: <?php echo $rs->color; ?>">
    	<td align="center">
		<?php if(can_do($a['add']) || can_do($a['edit']) )  : ?>
            	<select id="color<?php echo $id; ?>"><?php echo color_select(); ?></select>
            <?php endif; ?>
            </td>
    	<td>
		<?php if(can_do($a['delete']) ) : ?>
        	<a href="javascript:void(0)" style="margin: 0px 2px 0px 2px;" onclick="delete_row(<?php echo $id; ?>, '<?php echo $date_add; ?>'  ,' : <?php echo $rs->reference; ?>', ': <?php echo $rs->amount; ?>' )"><i class="fa fa-trash fa-2x red"></i></a>
        <?php endif; ?>
        </td>
    	<td align="center"><?php echo $date_add; ?><input type="hidden" id="date_add<?php echo $id; ?>" value="<?php echo $date_add; ?>"  /></td>
        <td><?php echo $rs->reference; ?><input type="hidden" id="reference<?php echo $id; ?>" value="<?php echo $rs->reference; ?>"  /></td>
        <td align="right"><?php echo number($rs->amount,2); ?><input type="hidden" id="amount<?php echo $id; ?>" value="<?php echo $rs->amount; ?>"  /></td>  
        <td><?php echo $rs->remark; ?><input type="hidden" id="remark<?php echo $id; ?>" value="<?php echo $rs->remark; ?>"  /></td>  	     
    </tr>
    <?php $color_sc .= "$('#color".$id."').ace_colorpicker().on('change', function() { var color = $('#color".$id."').val(); change_color(".$id.", color); }); "; ?>
<?php	endforeach; ?>
<?php else : ?>
<tr><td colspan="10"><center><h4>----------  ยังไม่มีรายการชำระคืน  ----------</h4></center></td></tr>
<?php endif; ?>
</tbody>
</table>
<?php echo $this->pagination->create_links(); ?>
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
			<td align="center"></td>
			<td align="right"></td>
			<td align="center">{{ date_add }}</td>	
			<td>{{ reference }}</td>
			<td align="right">{{ amount }}</td>
			<td align="right">{{ remark }}</td>
		</tr>
	{{/if}}
</script>


<script>
<?php echo $color_sc; ?>
var ref	= [<?php echo $ref; ?>];
$('#reference').autocomplete({
	source : ref, 
	autoFocus: false,
	close: function(event,ui){
		var data = $(this).val();
		$(this).val(data);
	}
});

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
$("#from_date").mask("99/99/9999");
$("#to_date").mask("99/99/9999");
$("#date_add").mask("99/99/9999");
$("#amount").numberOnly();
$("#date_add")	.bind("enterKey",function(){ 	$("#reference").focus() });
$("#reference")	.bind("enterKey",function(){  var arr = ref; var value = $(this).val(); if( $.inArray(value, arr) == -1 ){ swal("เลขที่เอกสารไม่ถูกต้อง"); }else{ 	$("#amount").focus(); } });
$("#amount")	.bind("enterKey",function(){ 	$("#remark").focus() });
$("#remark")	.bind("enterKey",function(){ 	$("#btn_save").focus() });
$("#btn_save")	.bind("enterKey",function(){ 	$("#btn_save").click() });
$("#date_add")	.keyup(function(e){		if(e.keyCode == 13){ $(this).trigger("enterKey");  } });
$("#reference")	.keyup(function(e){		if(e.keyCode == 13){ $(this).trigger("enterKey");  } });
$("#amount")	.keyup(function(e){		if(e.keyCode == 13){ $(this).trigger("enterKey");  } });
$("#remark")	.keyup(function(e){		if(e.keyCode == 13){ $(this).trigger("enterKey");  } });
$("#btn_save")	.keyup(function(e){		if(e.keyCode == 13){ $(this).trigger("enterKey");  } });
$("#search_reference").keyup(function(e){ if(e.keyCode == 13){ $(this).trigger("enterKey"); }});
$("#search_reference").bind("enterKey", function(e){ $("#from_date").focus(); });
$("#from_date").keyup(function (e){ if(e.keyCode == 13){ $(this).trigger("enterKey"); }});
$("#from_date").bind("enterKey", function(e){ $("#to_date").focus(); });
$("#to_date").keyup(function (e){ if(e.keyCode == 13 ){ $(this).trigger("enterKey"); }});
$("#to_date").bind("enterKey", function(e){ $("#btn_search").focus(); });


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


function save()
{
	load_in();
	$("#btn_save").attr("disabled","disabled");
	var date_add 	= $("#date_add").val();
	var el 			= $("#date_add");
	var reference	= $("#reference").val();
	var amount		= parseFloat($("#amount").val());
	if(date_add == "")
	{
		date_error("กรุณาระบุวันที่ครบกำหนด","", el);
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if(! isDate(date_add)){
		date_error("รูปแบบวันที่ไม่ถูกต้อง", "รูปแบบที่ถูกต้องคือ dd/mm/yyy เช่น <?php echo thai_date(); ?> หรือ เลือกวันที่จากปฏิทิน", el);
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if(amount == "" || amount < 0){
		swal("จำนวนเงินที่ระบุต้องมากกว่า 0");
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
					//$("#content").append(row);
					refresh();
					clear_field();
					$("#btn_save").removeAttr("disabled");
					load_out();
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

function clear_field()
{
	$("#date_add").val("");
	$("#reference").val('');
	$("#amount").val('');
	$("#remark").val('');
}
</script>
<?php endif; ?>