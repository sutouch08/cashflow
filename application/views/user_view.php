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
<?php if(can_do($p['add']) ) : ?>    
		<a href="user/add">
         <button class='btn btn-success'><i class='fa fa-plus'></i>&nbsp; เพิ่มใหม่</button>   	
         </a>
<?php endif; ?>       
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />

<table  id="simple-table"class="table table-striped">
<thead>
	<th style="width:5%; text-align:center">ID</th>
    <th style="width:20%">ชื่อผู้ใช้งาน</th>
    <th style="width:25%;">พนักงาน</th>
    <th style="width:10%; text-align:center">เปิดใช้งาน</th>
    <th style="width:10%; text-align:center">เข้าระบบครั้งล่าสุด</th>
    <th style="text-align:right">การกระทำ</th>
</thead>
<?php if( isset($data) && $data != false) : ?>
<?php 	foreach($data as $rs) : ?>
<tr>
	<td align="center"><?php echo $rs->id_user; ?></td>
    <td><?php echo $rs->user_name; ?></td>
    <td><?php echo employee_name($rs->id_employee); ?></td>
    <td align="center"><?php echo isActived($rs->active); ?></td>
    <td align="center"><?php echo thaiDate($rs->last_login, "", true); ?></td>
    <td align="right">
    <?php echo cando($p['edit'], "<a href='".$this->home."/reset_password/".$rs->id_user."'><button type='button' class='btn btn-sm btn-primary'><i class='fa fa-key'></i>&nbsp; เปลี่ยนรหัสผ่าน</button></a>"); ?>
    <?php echo cando($p['edit'], "<a href='".$this->home."/edit/".$rs->id_user."'><button type='button' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i>&nbsp; แก้ไข</button></a>"); ?>
    <?php echo cando($p['delete'], "<button type='button' class='btn btn-sm btn-danger' onclick=\" confirm_delete('คุณแน่ใจว่าต้องการลบ ".$rs->user_name."', 'โปรดจำไว้ การกระทำนี้ไม่สามารถกู้คืนได้', '".$this->home."/delete/".$rs->id_user."') \" >
	<i class='fa fa-trash'></i>&nbsp; ลบ</button>"); ?>   
    </td>
</tr>
<?php 	endforeach; ?>

<?php else : ?>
<tr><td colspan="6" align="center"><h3>---------- ไม่มีพนักงาน  ----------</h3></td></tr>

<?php endif; ?>
</table>

<?php endif; ?>