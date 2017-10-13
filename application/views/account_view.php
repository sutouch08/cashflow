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
		<a href="account/add">
         <button class='btn btn-success'><i class='fa fa-plus'></i>&nbsp; เพิ่มใหม่</button>   	
         </a>
<?php endif; ?>     
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />

<table  id="simple-table"class="table table-striped">
<thead style="font-size:10px">
	<th style="width:5%; text-align:center">ID</th>
    <th style="width:8%">รหัสบัญชี</th>
    <th style="width:10%;">เลขที่บัญชี</th>
    <th style="width:15%;">ชื่อบัญชี</th>
    <th style="width:10%;">ธนาคาร</th>
    <th style="width:8%;">สาขา</th>
    <th style="width:8%;">บริษัท</th>
    <th style="width:8%; text-align:right">วงเงิน OD</th>
    <th style="width:5%; text-align:right">ดอกเบี้ย OD</th>
    <th style="width:8%; text-align:right">วงเงินกู้</th>
    <th style="width:5%; text-align:center">สถานะ</th>
    <th style="text-align:right">การกระทำ</th>
</thead>
<?php if( isset($data) && $data != false) : ?>
<?php 	foreach($data as $rs) : ?>
<tr style="font-size:12px">
	<td align="center" class="align-middle"><?php echo $rs->id_bank_ac; ?></td>
    <td class="align-middle"><?php echo $rs->ac_code; ?></td>
    <td class="align-middle"><?php echo $rs->ac_number; ?></td>
    <td class="align-middle"><?php echo $rs->ac_name; ?></td>
    <td class="align-middle"><?php echo bank_name($rs->id_bank); ?></td>
    <td class="align-middle"><?php echo $rs->branch; ?></td>
    <td class="align-middle"><?php echo company_name($rs->id_company); ?></td>
    <td class="align-middle" align="right"><?php echo number_format($rs->od_budget); ?></td>
    <td class="align-middle" align="right"><?php echo $rs->od_rate; ?></td>
    <td class="align-middle" align="right"><?php echo number_format($rs->loan_budget); ?></td>
    <td class="align-middle" align="center"><?php echo isActived($rs->active); ?></td>
    <td class="align-middle" align="right">
    <?php echo cando($p['edit'], "<a href='".$this->home."/edit/".$rs->id_bank_ac."'><button type='button' class='btn btn-xs btn-warning'><i class='fa fa-pencil'></i>&nbsp; แก้ไข</button></a>"); ?>
    <?php echo cando($p['delete'], "<button type='button' class='btn btn-xs btn-danger' onclick=\"confirm_delete('คุณแน่ใจว่าต้องการลบรายการนี้', 'โปรดจำไว้ว่าการกระทำนี้ไม่สามารถกู้คืนได้', '".$this->home."/delete/".$rs->id_bank_ac."') \"><i class='fa fa-trash'></i>&nbsp; ลบ</button>"); ?>
    </td>
</tr>
<?php 	endforeach; ?>

<?php else : ?>
<tr><td colspan="9" align="center"><h3>---------- ยังไม่มีบัญชีธนาคาร  ----------</h3></td></tr>

<?php endif; ?>
</table>

<?php endif; ?>