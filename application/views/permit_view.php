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

<table  id="simple-table"class="table table-striped">
<thead>
	<th style="width:5%; text-align:center">ID</th>
    <th style="width:35%;">โปรไฟล์</th>
    <th style="text-align:right"></th>
</thead>
<?php if( isset($data) && $data != false) : ?>
<?php 	foreach($data as $rs) : ?>
<tr>
	<td align="center" class="align-middle"><?php echo $rs->id_profile; ?></td>
    <td class="align-middle"><?php echo $rs->profile_name; ?></td>
    <td class="align-middle" align="right">
    <?php echo cando($p['edit'], "<a href='".$this->home."/edit/".$rs->id_profile."'><button type='button' class='btn btn-sm btn-warning'><i class='fa fa-lock'></i>&nbsp; กำหนดสิทธิ์</button></a>"); ?>
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