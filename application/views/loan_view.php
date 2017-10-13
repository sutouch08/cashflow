
<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php 
	$p = valid_access($id_menu);  	
?>
<?php if($p['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class='row'>
	<div class='col-lg-12'>
    	<h3 style='margin-bottom:0px;'><?php echo $title; ?></h3>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<div class="row">
<?php if( isset($data) && $data != false) : ?>
<table class="table table-striped table-hover">
<thead>
	<th style="width:20%;">การกระทำ</th>
    <th style="width:40%">บัญชี</th>
    <th style="width:15%;">บริษัท</th>
    <th></th>
</thead>
<?php 	foreach($data as $rs) : ?>
<?php 		$a = valid_ac($rs->id_bank_ac); ?>
<tr>
	<td>
<?php if( can_do($a['view']) ) : ?>
    	<a href="<?php echo base_url()."loan/view/".$rs->id_bank_ac; ?>" style="text-decoration:none;">
        <button class="btn btn-warning btn-xs"><i class="fa fa-search"></i>&nbsp; ดูรายการ</button>
        </a>
<?php else : ?>
        <button class="btn btn-warning btn-xs" style="visibility:hidden;"><i class="fa fa-search"></i>&nbsp; ดูรายการ</button>
<?php endif; ?>
<?php if( can_do($a['add']) || can_do($a['edit']) ) : ?>        
        <a href="<?php echo base_url()."loan/add/".$rs->id_bank_ac; ?>" style="text-decoration:none;">
        <button class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>&nbsp; เพิ่ม/แก้ไข รายการ</button>       
        </a>
<?php else : ?> 
		<button class="btn btn-info btn-xs" style="visibility:hidden"><i class="fa fa-pencil"></i>&nbsp; เพิ่ม/แก้ไข รายการ</button>         
<?php endif; ?>  
	</td>
 	<td>
		<?php echo $rs->ac_code; ?>&nbsp; : &nbsp;<?php echo bank_name($rs->id_bank); ?>&nbsp; : &nbsp; <?php echo $rs->ac_number; ?>&nbsp; : &nbsp;<?php echo $rs->ac_name; ?>
    </td>
    <td>
    	<?php echo company_name($rs->id_company); ?>
    </td>
    <td></td>
    </tr>  
<?php 	endforeach; ?>
</table>
<?php else : ?>
<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			<strong><i class="ace-icon fa fa-exclamation-circle"></i>&nbsp; ยังไม่มีบัญชีธนาคาร สามารถเพิ่มได้ที่ เมนู กำหนดค่า >> เพิ่ม/แก้ไข บัญชีธนาคาร (ต้องเพิ่ม ธนาคาร และ บริษัทก่อน)</strong><br>
</div>

<?php endif; ?>
</div>
<?php endif; ?>