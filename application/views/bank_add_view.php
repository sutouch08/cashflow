<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php 
	$p = valid_access($id_menu);  	
?>
<?php if($p['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-user'></i>&nbsp; <?php echo $title; ?></h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo $this->home; ?>"><button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button></a>
<?php if(can_do($p['add']) ) : ?>    
         <button class='btn btn-success' id="btn_save" onclick="save()"><i class='fa fa-save'></i>&nbsp; บันทึก</button> 
<?php endif; ?>         
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<form class="form-horizontal" id="add_form" method="post" action="<?php echo $this->home."/add"; ?>">
<input type="hidden" name="add" value="1"  />
<button type="button" id="btn_submit" style="display:none">Submit</button>
<input type="text" name="disable_enter" style="display:none"  disabled="disabled" placeholder="เอาไว้ป้องกันการ SUBMIT โดยการกด Enter" />
<div class="row">
<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">ชื่อธนาคาร </label>
<div class="col-lg-4"><input type="text" name="bank_name" id="bank_name" class="form-control" required="required" autocomplete="off" /></div>
<div class="col-lg-4" style="color:red;">*</div>
</div>
</div><!--/ Row -->
</form>
<script>
function save()
{
	$("#btn_save").attr("disabled","disabled");
	var bank_name = $("#bank_name").val();
	if(bank_name == "")
	{
		swal("ยังไม่ได้ระบุชื่อธนาคาร", "กรุณากรอกข้อมูลให้ครบถ้วน","error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else{
		$.ajax({
			url : "<?php echo $this->home."/valid_name"; ?>"+"/"+bank_name,
			type: "GET", cache:false, success: function(rs){
				if(rs == 1 ){
				swal("ธนาคารซ้ำ", "","error");
				$("#btn_save").removeAttr("disabled");
				}else{
				$("#btn_submit").attr("type","submit");
				$("#btn_submit").click();
				}
			}
		});	
	}
}
</script>

<?php endif; ?>