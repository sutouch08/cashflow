<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php 
	$p = valid_access($id_menu);  	
?>
<?php if($p['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-bank'></i>&nbsp; <?php echo $title; ?></h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo $this->home; ?>"><button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button></a>
<?php if(can_do($p['edit']) ) : ?>    
         <button class='btn btn-success' id="btn_save" onclick="save()"><i class='fa fa-save'></i>&nbsp; บันทึก</button> 
<?php endif; ?>         
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<?php if( isset( $data ) && $data != false ) : ?>
<?php 	foreach($data as $rs) : ?>
<form class="form-horizontal" id="add_form" method="post" action="<?php echo $this->home."/edit/".$rs->id_bank_ac; ?>">
<input type="hidden" name="edit" value="1"  />
<input type="hidden" name="id" id="id" value="<?php echo $rs->id_bank_ac; ?>"  />
<button type="button" id="btn_submit" style="display:none">Submit</button>
<input type="text" name="disable_enter" style="display:none"  disabled="disabled" placeholder="เอาไว้ป้องกันการ SUBMIT โดยการกด Enter" />
<div class="row">

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">รหัสบัญชี </label>
<div class="col-lg-4">
	<input type="text" name="ac_code" id="ac_code" class="form-control" placeholder="กำหนดรหัสบัญชี เพื่อให้ง่ายต่อการจดจำ" value="<?php echo $rs->ac_code; ?>" required autocomplete="off" />
</div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">ธนาคาร </label>
<div class="col-lg-4">
	<select name="id_bank" id="id_bank" class="form-control">
    <?php echo bank_select($rs->id_bank); ?>
    </select>
</div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">เลขที่บัญชี</label>
<div class="col-lg-4">
<input type="text" name="ac_number" id="ac_number" class="form-control" placeholder="ระบุเลขที่บัญชี (รูปแบบเดียวกับที่ปรากฎบนหน้าสมุดบัญชี)" value="<?php echo $rs->ac_number; ?>" required autocomplete="off" />
</div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">ชื่อบัญชี</label>
<div class="col-lg-4">
<input type="text" name="ac_name" id="ac_name" class="form-control" placeholder="ระบุชื่อบัญชี" value="<?php echo $rs->ac_name; ?>" required autocomplete="off" /></div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">สาขา</label>
<div class="col-lg-4"><input type="text" name="branch" id="branch" class="form-control" placeholder="ระบุสาขาธนาคาร" value="<?php echo $rs->branch; ?>" autocomplete="off" /></div>
<div class="col-lg-4" style="color:red;"></div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">ประเภทบัญชี</label>
<div class="col-lg-4"><input type="text" name="ac_type" id="ac_type" class="form-control" placeholder="ระบุประเภทบัญชี" value="<?php echo $rs->ac_type; ?>"  autocomplete="off" /></div>
<div class="col-lg-4" style="color:red;"></div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">บริษัท </label>
<div class="col-lg-4">
	<select name="id_company" id="id_company" class="form-control">
    <?php echo company_select($rs->id_company); ?>
    </select>
</div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">วงเงิน OD</label>
<div class="col-lg-4"><input type="text" name="od_budget" id="od_budget" class="form-control" value="<?php echo $rs->od_budget; ?>" placeholder="กำหนดวงเงิน OD (ตัวเลขเท่านั้น)" autocomplete="off" /></div>
<div class="col-lg-4" style="color:red;"></div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">อัตราดอกเบี้ย OD</label>
<div class="col-lg-4">
	<div class="input-group">
	<input type="text" name="od_rate" id="od_rate" class="form-control" placeholder="ระบุอัตราดอกเบี้ย OD เป็นตัวเลข เช่น 5 หรือ 3.2 เป็นต้น" value="<?php echo $rs->od_rate; ?>" autocomplete="off" />
	<span class="input-group-addon">%</span>
    </div>
</div>
<div class="col-lg-4" style="color:#666;"></div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">เปิดใช้งาน</label>
<div class="col-lg-4">
<label class="form-control" style="width:150px; border:0px; display: inline-block">
	<input class="ace" type="radio" name="active" id="yes" value="1" <?php echo isChecked($rs->active, 1); ?> /><span class="lbl bigger-100" style="color:green;">&nbsp;<i class="fa fa-check"></i>เปิดใช้งาน</span>
</label>
<label class="form-control" style="width:150px; border:0px; display: inline-block">
	<input class="ace" type="radio" name="active" id="no" value="0" <?php echo isChecked($rs->active, 0); ?>  /><span class="lbl bigger-100" style="color:red;">&nbsp;<i class="fa fa-remove"></i>ปิดใชงาน</span>
</label>
</div>
<div class="col-lg-4" ></div>
</div>

<div class="col-lg-8 col-lg-offset-2" ><h3 class="header smaller lighter blue">สินเชื่อ</h3></div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">วงเงินกู้</label>
<div class="col-lg-4">
	<input type="text" name="loan_budget" id="loan_budget" class="form-control" placeholder="กำหนดวงเงินสำหรับกู้ตั๋วของบัญชีนี้" value="<?php echo $rs->loan_budget; ?>" autocomplete="off" />
</div>
<div class="col-lg-4" style="color:#666;"></div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">การจ่ายดอกเบี้ย</label>
<div class="col-lg-4">
	<div class="control-group">
    	<div class="radio"><label><input name="int" id="pay_method1" class="ace" type="radio" value="1" <?php echo isChecked($rs->int, 1); ?>><span class="lbl"> จ่ายทันที</span></label></div>
    	<div class="radio"><label><input name="int" id="pay_method2" class="ace" type="radio" value="0" <?php echo isChecked($rs->int, 0); ?> ><span class="lbl"> จ่ายเมื่อครบกำหนด</span></label></div>
    	<div class="radio"><label><input name="int" id="pay_method3" class="ace" type="radio" value="2" <?php echo isChecked($rs->int, 2); ?>><span class="lbl"> จ่ายทุกวันที่กำหนด</span></label></div>
        <div class="control-group" id="pay_option" style="padding-left:30px; <?php if(isMatch(2, $rs->int) ){ }else{ echo "display:none"; } ?>">
        	<div class="radio"><label><input name="pay_in_date" id="pay_in_last" class="ace" type="radio" value="x" <?php echo isChecked($rs->int_date, 'x'); ?> ><span class="lbl"> จ่ายทุกสิ้นเดือน</span></label></div>
            <div class="radio">
            	<label>
                <input name="pay_in_date" id="pay_in_date" class="ace" type="radio" value="1" <?php if($rs->int_date != 0 && $rs->int_date != 'x'){ echo "checked"; }?> >
                <span class="lbl"> จ่ายทุกวันที่</span>
                <input type="text" name="pay_date" id="pay_date" value="<?php if($rs->int_date != 0 && $rs->int_date != 'x'){ echo $rs->int_date; }?>" style="margin-left:10px; margin-right:10px; width:50px;" />
                <span class="lbl">ของเดือน</span>
                </label>
          </div>
        </div>
    </div>
</div>
<div class="col-lg-4" style="color:#666;"></div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">การคำนวณดอกเบี้ย</label>
<div class="col-lg-4">
	<div class="control-group">
    	<div class="radio"><label><input name="int_cal" id="cal_all" class="ace" type="radio" value="1" <?php echo isChecked(1, $rs->int_cal); ?>><span class="lbl"> ใช้เงินต้นทั้งหมดมาคำนวณดอกเบี้ย</span></label></div>
    	<div class="radio"><label><input name="int_cal" id="cal_bal" class="ace" type="radio" value="0" <?php echo isChecked(0, $rs->int_cal); ?> ><span class="lbl"> ใช้ยอดค้างชำระมาคำนวณดอกเบี้ย</span></label></div>
    </div>
</div>
<div class="col-lg-4" style="color:#666;"></div>
</div>


<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">เงินเข้าบัญชี</label>
<div class="col-lg-4">
	<label><select name="in_book" id="in_book" class="form-control"><?php echo book_select($rs->in_book); ?></select></label>
</div>
<div class="col-lg-4" style="color:#666;"></div>
</div>




</div><!--/ Row -->
</form>
<?php  	endforeach; ?>
<?php else : ?>
<div class="row">
	<div class="col-lg-4 col-lg-offset-4">
    	<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			<strong><i class="ace-icon fa fa-exclamation-circle"></i>&nbsp; เกิดข้อผิดพลาด : &nbsp;&nbsp;ไม่พบข้อมูลที่ต้องการแก้ไข</strong><br>
		</div>
    </div>
</div>
<?php 	endif; ?>
<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js" type="text/javascript"></script>
<script>
$("#pay_method3").change(function(e) {
    if($(this).prop('checked')){ $("#pay_option").css("display", ""); }
});

$("#pay_method1").change(function(e) {
   $("#pay_option").css("display", "none"); 
});
$("#pay_method2").change(function(e) {
    $("#pay_option").css("display", "none");
});

$("#pay_in_date").change(function(e){ 
	$("#pay_date").focus();
});
$("#pay_in_last").change(function(e) {
    $("#pay_date").val('');
});

$("#pay_date").numberOnly();
$("#pay_date").keyup(function(e) {
    var value = $(this).val();
	if(value != ""){
	if(value < 1 ){ $(this).val(1); swal("ระบุวันที่ 1 - 31 เท่านั้น"); }
	if(value > 31 ){ $(this).val(31); swal("ระบุวันที่ 1 - 31 เท่านั้น"); }
	}
});

function save()
{
	load_in();
	$("#btn_save").attr("disabled","disabled");
	var id 				= $("#id").val();
	var id_bank 		= $("#id_bank").val();
	var ac_code		= $("#ac_code").val();
	var ac_no			= $("#ac_number").val();
	var ac_name		= $("#ac_name").val();
	var id_company	= $("#id_company").val();
	var rate				= $("#od_rate").val();
	var budget			= $("#od_budget").val();
	if(ac_code == "")
	{
		swal("กรุณากำหนดรหัสบัญชี", "รหัสบัญชีจะทำให้การบันทึกรายการง่ายขึ้น","error");
		$("#ac_code").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if(id_bank == 0){
		swal("ยังไม่ได้ระบุชื่อธนาคาร", "","error");
		$("#id_bank").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if(ac_no == ""){
		swal("ยังไม่ได้ระบุเลขที่บัญชี", "","error");
		$("#ac_number").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if(ac_name == ""){
		swal("ยังไม่ได้ระบุชื่อบัญชี", "","error");
		$("#ac_name").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if(id_company == "0"){
		swal("ยังไม่ได้เลือกบริษัท", "","error");
		$("#id_company").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		load_out();
		return false;
	}else if( budget != "" && isNaN(parseInt(budget))){
			swal("วงเงิน OD ต้องเป็นตัวเลขเท่านั้น", "เช่น 3000000 หรือ 300000.50", "error");
			$("#od_budget").parent().addClass("has-error");
			$("#btn_save").removeAttr("disabled");
			load_out();
			return false;
	}else if( rate != "" && isNaN(parseInt(rate))){
			swal("อัตรดอกเบี้ย OD ต้องเป็นตัวเลขเท่านั้น", "เช่น 3.5 หรือ 5", "error");
			$("#od_rate").parent().addClass("has-error");
			$("#btn_save").removeAttr("disabled");
			load_out();
			return false;
	}else{
		$.ajax({
			url : "<?php echo $this->home."/valid_ac_code"; ?>"+"/"+ac_code+"/"+id,
			type: "GET", cache:false, success: function(rs){
				if(rs == 1){
					swal("รหัสบัญชีซ้ำ", "เพื่อความถูกต้อง ไม่อนุญาติให้รหัสบัญชีซ้ำกัน", "error");
					$("#ac_code").parent().addClass("has-error");
					$("#btn_save").removeAttr("disabled");
					load_out();
					return false;
					
				}else{
					$.ajax({
						url : "<?php echo $this->home."/valid_ac_number"; ?>"+"/"+ac_no+"/"+id_bank+"/"+id,
						type: "GET", cache:false, success: function(cs){
							if(cs == 1){
								swal("เลขที่บัญชีซ้ำ", "", "error");
								$("#ac_number").parent().addClass("has-error");
								$("#btn_save").removeAttr("disabled");
								load_out();
								return false;
								
							}else{
								$("#btn_save").removeAttr("disabled");
								$("#btn_submit").attr("type","submit");
								$("#btn_submit").click();
							}
						}
					});
				}
			}
		});
	}
}

$("#loan_budget").numberOnly();
$("#od_budget").numberOnly();

</script>

<?php endif; ?>