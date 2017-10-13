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
<form class="form-horizontal" id="add_form" method="post" action="<?php echo $this->home."/reset_password/".$rs->id_user; ?>">
<input type="hidden" name="reset_password" value="1"  />
<button type="button" id="btn_submit" style="display:none">Submit</button>
<div class="row">
<div class="form-group">
<label class="col-lg-4 control-label no-padding-right"></label>
<div class="col-lg-3"><h4 class="widget-title lighter">เปลี่ยนรหัสผ่านของ : <?php echo $rs->user_name; ?></h4></div>
<div class="col-lg-5" style="color:red;"></div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">รหัสผ่านใหม่</label>
<div class="col-lg-3"><input type="password" name="password" id="password" class="form-control" placeholder="ตัวเลขหรือตัวอักษร อย่างน้อย 4 ตัว" required /></div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label no-padding-right">ยืนยันรหัสผ่าน</label>
<div class="col-lg-3"><input type="password" name="cmf_password" id="cmf_password" class="form-control" placeholder="ยืนยันรหัสผ่านอีกครั้ง" required /></div>
<div class="col-lg-4" style="color:red;">*</div>
</div>

</div><!--/ Row -->
</form>

<script>
function save()
{
	$("#btn_save").attr("disabled","disabled");
	var password		= $("#password").val();
	var cmf_pass		= $("#cmf_password").val();
	
	if( password == "" || cmf_pass == ""){
		swal("ยังไม่ได้กำหนดรหัสผ่านใหม่ หรือ ไม่ได้ยืนยันรหัสผ่าน");
		$("#password").parent().addClass("has-error");
		$("#cmf_password").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else if( password != cmf_pass){
		swal("รหัสผ่าน 2 ช่องไม่ตรงกัน");
		$("#password").parent().addClass("has-error");
		$("#cmf_password").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		return false;
	}else if( password.length <4 ){
		swal("รหัสผ่านต้องมีอย่างน้อย 4 ตัวอักษร");
		$("#password").parent().addClass("has-error");
		$("#cmf_password").parent().addClass("has-error");
		$("#btn_save").removeAttr("disabled");
		return false;
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