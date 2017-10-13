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
<?php if( isset($data) && $data != false ) : ?>
<?php 	foreach( $data as $rs ) : ?>
<form class="form-horizontal" id="add_form" method="post" action="<?php echo $this->home."/edit/".$rs->id_user; ?>">
<input type="hidden" name="edit" value="1"  />
<button type="button" id="btn_submit" style="display:none">Submit</button>
<div class="row">
<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">User Name</label>
<div class="col-lg-3"><input type="text" name="user_name" id="user_name" class="form-control" placeholder="ชื่อผู้ใช้งาน สำหรับเข้าใข้ระบบ" value="<?php echo $rs->user_name; ?>" disabled /></div>
<div class="col-lg-5" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">พนักงาน</label>
<div class="col-lg-3">
	<select name="employee" id="employee" class="form-control">
	  <?php echo employee_select($rs->id_employee); ?>
	</select>
</div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">โปรไฟล์</label>
<div class="col-lg-3">
	<select name="profile" id="profile" class="form-control">
    <?php echo profile_select($rs->id_profile); ?>
    </select>
</div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">สถานะ </label>
<div class="col-lg-3">
<label class="form-control" style="width:150px; border:0px; display: inline-block">
	<input class="ace" type="radio" name="active" id="yes" value="1" <?php echo isChecked($rs->active, 1); ?> /><span class="lbl bigger-100" style="color:green;">&nbsp;<i class="fa fa-check"></i>เปิดใช้งาน</span>
</label>
<label class="form-control" style="width:150px; border:0px; display: inline-block">
	<input class="ace" type="radio" name="active" id="no" value="0" <?php echo isChecked($rs->active, 0); ?> /><span class="lbl bigger-100" style="color:red;">&nbsp;<i class="fa fa-remove"></i>ปิดใชงาน</span>
</label>
</div>
<div class="col-lg-4" ></div>
</div>
</div><!--/ Row -->
</form>

<script>
function save()
{
	$("#btn_save").attr("disabled","disabled");
	var employee		= $("#employee").val();
	var profile			= $("#profile").val();
	if( employee == 0){
		swal("ยังไม่ได้ระบุพนักงาน");
		$("#employee").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else if( profile == 0 ){
		swal("ยังไม่ได้ระบุโปรไฟล์");
		$("#profile").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
	}else{
		$("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
	}
}
</script>
<?php 	endforeach; ?>
<?php else : ?>
<center><h3>----------  เกิดความผิดพลาดในการส่งข้อมูลจาก Controller  ----------</h3></center>
<?php endif; ?>
<?php endif; ?>