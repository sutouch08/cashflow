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
<div class="row">
<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">User Name</label>
<div class="col-lg-3"><input type="text" name="user_name" id="user_name" class="form-control" placeholder="ชื่อผู้ใช้งาน สำหรับเข้าใข้ระบบ" required /></div>
<div class="col-lg-5" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">รหัสผ่าน</label>
<div class="col-lg-3"><input type="password" name="password" id="password" class="form-control" placeholder="ตัวเลขหรือตัวอักษร อย่างน้อย 4 ตัว" required /></div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">ยืนยันรหัสผ่าน</label>
<div class="col-lg-3"><input type="password" name="cmf_password" id="cmf_password" class="form-control" placeholder="ยืนยันรหัสผ่านอีกครั้ง" required /></div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">พนักงาน</label>
<div class="col-lg-3">
	<select name="employee" id="employee" class="form-control">
	  <?php echo employee_select(); ?>
	</select>
</div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">โปรไฟล์</label>
<div class="col-lg-3">
	<select name="profile" id="profile" class="form-control">
    <?php echo profile_select(); ?>
    </select>
</div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">สถานะ </label>
<div class="col-lg-3">
<label class="form-control" style="width:150px; border:0px; display: inline-block">
	<input class="ace" type="radio" name="active" id="yes" value="1" checked /><span class="lbl bigger-100" style="color:green;">&nbsp;<i class="fa fa-check"></i>เปิดใช้งาน</span>
</label>
<label class="form-control" style="width:150px; border:0px; display: inline-block">
	<input class="ace" type="radio" name="active" id="no" value="0"  /><span class="lbl bigger-100" style="color:red;">&nbsp;<i class="fa fa-remove"></i>ปิดใชงาน</span>
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
	var user_name 	= $("#user_name").val();
	var password 		= $("#password").val();
	var cmf_pass		= $("#cmf_password").val();
	var employee		= $("#employee").val();
	var profile			= $("#profile").val();
	if( user_name == "")
	{
		swal("ยังไม่ได้ระบุ User Name");
		$("#user_name").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else if( password =="" || cmf_pass == ""){
		swal("ยังไม่ได้กำหนดรหัสผ่าน หรือ ไม่ได้ยืนยันรหัสผ่าน");
		$("#password").parent().addClass("has-error");
		$("#cmf_password").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else if( password.length < 4 ){
		swal("รหัสผ่านต้องมีอย่างน้อย 4 ตัวอักษร");
		$("#password").parent().addClass("has-error");
		$("#cmf_password").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else if( password != cmf_pass ){
		swal("รหัสผ่าน 2 ช่องไม่ตรงกัน");
		$("#password").parent().addClass("has-error");
		$("#cmf_password").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else if( employee == 0){
		swal("ยังไม่ได้ระบุพนักงาน");
		$("#employee").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else if( profile == 0 ){
		swal("ยังไม่ได้ระบุโปรไฟล์");
		$("#profile").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
	}else{
		$.ajax({
			url : "<?php echo $this->home."/valid_user"; ?>"+"/"+user_name,
			type: "GET", cache:false, success: function(rs){
				if(rs == 1 ){
					swal("<User Name ซ้ำ", "มี User Name นี้อยู่ในระบบแล้ว","error");
					$("#user_name").parent().addClass("has-error");
					$("#btn_save").removeAttr("disabled");
				}else if(rs == 0){
					$("#btn_submit").attr("type","submit");
					$("#btn_submit").click();
				}else{
					swal("การเชื่อต่อผิดพลาด","","error");	
					$("#btn_save").removeAttr("disabled");
				}
			}
		});	
	}
}
</script>

<?php endif; ?>