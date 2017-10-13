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
		<a href="customer/add">
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
    <th style="width:35%;">ชื่อลูกค้า</th>
    <th style="width:10%; text-align:center">ปรับปรุงล่าสุด</th>
    <th style="text-align:right">การกระทำ</th>
</thead>
<?php if( isset($data) && $data != false) : ?>
<?php 	$n = $this->uri->segment(3)+1; ?>
<?php 	foreach($data as $rs) : ?>
<tr>
	<td align="center" class="align-middle"><?php echo $n; ?></td>
    <td class="align-middle"><?php echo $rs->name; ?></td>
    <td class="align-middle" align="center"><?php echo thaiDate($rs->date_upd); ?></td>
    <td class="align-middle" align="right">
    <?php echo cando($p['edit'], "<a href='".$this->home."/edit/".$rs->id."'><button type='button' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i>&nbsp; แก้ไข</button></a>"); ?>
    <?php echo cando($p['delete'], "<button type='button' class='btn btn-sm btn-danger' onclick=\"confirm_delete('คุณแน่ใจว่าต้องการลบรายการนี้', 'โปรดจำไว้ว่าการกระทำนี้ไม่สามารถกู้คืนได้', '".$this->home."/delete/".$rs->id."') \"><i class='fa fa-trash'></i>&nbsp; ลบ</button>"); ?>
    </td>
</tr>
<?php 		$n++; ?>
<?php 	endforeach; ?>

<?php else : ?>
<tr>
	<td colspan="6" align="center">
    	<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			<strong><i class="ace-icon fa fa-exclamation-circle"></i>&nbsp; ยังไม่มีรายชื่อลูกค้า</strong><br>
		</div>
    </td>
</tr>

<?php endif; ?>
</table>
<?php echo $this->pagination->create_links(); ?>
<?php endif; ?>