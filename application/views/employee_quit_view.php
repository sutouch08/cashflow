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
		<a href="<?php echo $this->home;?>">
         <button class='btn btn-warning'><i class='fa fa-arrow-left'></i>&nbsp; กลับ</button>   	
         </a>      
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />

<table  id="simple-table"class="table table-striped">
<thead>
	<th style="width:5%; text-align:center">ID</th>
    <th style="width:15%;">ชื่อ</th>
    <th style="width:15%">นามสกุล</th>
    <th style="width:10%; text-align:center">สถานะ</th>
    <th style="width:10%; text-align:center">ปรับปรุงล่าสุด</th>
    <th style="text-align:right">การกระทำ</th>
</thead>
<?php if( isset($data) && $data != false) : ?>
<?php 	foreach($data as $rs) : ?>
<?php		if($rs->is_quit == 1) : ?>
<tr>
	<td align="center"><?php echo $rs->id_employee; ?></td>
    <td><?php echo $rs->first_name; ?></td>
    <td><?php echo $rs->last_name; ?></td>
    <td align="center" style="color:red;"><?php echo "ลาออก"; ?></td>
    <td align="center"><?php echo thaiDate($rs->date_upd); ?></td>
    <td align="right">
    <?php echo cando($p['edit'], "<a href='".$this->home."/edit/".$rs->id_employee."'><button type='button' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i></button></a>"); ?>
    <?php echo cando($p['delete'], "<button type='button' class='btn btn-sm btn-danger' onclick=\"confirm_delete('คุณแน่ใจว่าต้องการลบพนักงานคนนี้', 'โปรดจำไว้ว่าการกระทำนี้ไม่สามารถกู้คืนได้','".$this->home."/delete/".$rs->id_employee."') \" ><i class='fa fa-trash'></i></button>"); ?>
    </td>
</tr>
<?php		endif; ?>
<?php 	endforeach; ?>

<?php else : ?>
<tr><td colspan="6" align="center"><h3>---------- ไม่มีพนักงาน  ----------</h3></td></tr>

<?php endif; ?>
</table>

<?php endif; ?>