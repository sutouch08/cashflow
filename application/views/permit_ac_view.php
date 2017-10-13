<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php 
	$p = valid_access($id_menu);  	
?>
<?php if($p['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class='row'>
	<div class='col-lg-12'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-lock'></i>&nbsp; <?php echo $title; ?></h3>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<h4 class="header smaller lighter orange"><i class="fa fa-exclamation-triangle"></i>&nbsp; การกำหนดสิทธิ์ จะมีผูกกับ User name เท่านั้นไม่ได้ผูกกับพนักงาน</h4>
<table  id="simple-table"class="table table-striped">
<thead>
	<th style="width:5%; text-align:center">ID</th>
    <th style="width:35%;">พนักงาน</th>
    <th style="width:15%;">User Name</th>
    <th style="text-align:right"></th>
</thead>
<?php if( isset($data) && $data != false) : ?>
<?php 	foreach($data as $rs) : ?>
<tr>
	<td class="align-middle center"><?php echo $rs->id_user; ?></td>
    <td class="align-middle"><?php echo employee_name($rs->id_employee); ?></td>
    <td class="align-middle"><?php echo $rs->user_name; ?></td>
    <td class="align-middle" align="right">
    <?php echo cando($p['add'], "<a href='".$this->home."/set_permission/".$rs->id_user."'><button type='button' class='btn btn-sm btn-warning'><i class='fa fa-lock'></i>&nbsp; กำหนดสิทธิ์</button></a>"); ?>
    </td>
</tr>
<?php 	endforeach; ?>

<?php else : ?>
<tr>
	<td colspan="6" align="center">
    	<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			<strong><i class="ace-icon fa fa-exclamation-circle"></i>&nbsp; ยังไม่มีโปรไฟล์</strong><br>
		</div>
    </td>
</tr>

<?php endif; ?>
</table>

<?php endif; ?>