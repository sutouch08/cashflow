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
<?php if(can_do($p['edit']) ) : ?>    
         <button class='btn btn-success' id="btn_save" onclick="save()"><i class='fa fa-save'></i>&nbsp; บันทึก</button> 
<?php endif; ?>         
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<?php if( isset($data) && $data != false) : ?>
<?php 	foreach($data as $rs) : ?>
<form class="form-horizontal" id="add_form" method="post" action="<?php echo $this->home."/edit/".$rs->id_company; ?>">
<input type="hidden" name="edit" value="1"  />
<input type="hidden" id="id" value="<?php echo $rs->id_company; ?>" />
<button type="button" id="btn_submit" style="display:none">Submit</button>
<?php echo ignore_enter(); ?>
<div class="row">
<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">ชื่อบริษัท </label>
<div class="col-lg-4"><input type="text" name="company_name" id="company_name" class="form-control" required="required" autocomplete="off" placeholder="ชื่อบริษัท" value="<?php echo $rs->company_name; ?>" /></div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">สถานะ </label>
<div class="col-lg-4">
<label class="form-control" style="width:150px; border:0px; display: inline-block">
	<input class="ace" type="radio" name="active" id="yes" value="1" <?php echo isChecked($rs->active, 1); ?> /><span class="lbl bigger-100" style="color:green;">&nbsp;<i class="fa fa-check"></i>เปิดใช้งาน</span>
</label>
<label class="form-control" style="width:150px; border:0px; display: inline-block">
	<input class="ace" type="radio" name="active" id="no" value="0"  <?php echo isChecked($rs->active, 0); ?> /><span class="lbl bigger-100" style="color:red;">&nbsp;<i class="fa fa-remove"></i>ปิดใชงาน</span>
</label>
</div>
<div class="col-lg-4" ></div>
</div>
</div><!--/ Row -->
</form>
<?php		endforeach; ?>
<?php endif; ?>
<script>
function save()
{
	$("#btn_save").attr("disabled","disabled");
	var name = $("#company_name").val();	
	var id		= $("#id").val();
	if(name =="")
	{
		swal("ยังไม่ได้ระบุชื่อบริษัท", "กรุณากรอกข้อมูลให้ครบถ้วน","error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else{
		$.ajax({
			url : "<?php echo $this->home."/valid_name"; ?>"+"/"+name+"/"+id,
			type: "GET", cache:false, success: function(rs){
				if(rs == 1 ){
				swal("ชื่อบริษัทซ้ำ", "","error");
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