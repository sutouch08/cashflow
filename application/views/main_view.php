
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
<?php
			$total_balance = 0;
			$total_last_month = 0;
			$total_move_in = 0;
			$total_move_out = 0;
?>
<table class="table table-striped table-hover">
<thead>
	<th style="width:20%;">การกระทำ</th>
    <th style="">บัญชี</th>
		<th style="width:10%; text-align:right;">ยอดยกมา</th>
		<th style="width:10%; text-align:right;">เงินเข้า</th>
		<th style="width:10%; text-align:right;">เงินออก</th>
		<th style="width:10%; text-align:right;">คงเหลือ[ปัจจุบัน]</th>
    <th style="width:15%; text-align:center;">บริษัท</th>
    <th></th>
</thead>
<?php 	foreach($data as $rs) : ?>
<?php
				$a = valid_ac($rs->id_bank_ac);
				$last_month_balance = $this->account_model->get_last_month_balance($rs->id_bank_ac);
				$total_move_in_amount = $this->account_model->get_total_move_in($rs->id_bank_ac);
				$total_move_out_amount = $this->account_model->get_total_move_out($rs->id_bank_ac);
				$balance = $this->account_model->get_balance($rs->id_bank_ac);

	?>
<tr>
	<td>
<?php if( can_do($a['view']) ) : ?>
    	<a href="<?php echo base_url()."flow/view/".$rs->id_bank_ac; ?>" style="text-decoration:none;">
        <button class="btn btn-warning btn-xs"><i class="fa fa-search"></i>&nbsp; ดูรายการ</button>
        </a>
<?php else : ?>
        <button class="btn btn-warning btn-xs" style="visibility:hidden;"><i class="fa fa-search"></i>&nbsp; ดูรายการ</button>
<?php endif; ?>
<?php if( can_do($a['add']) || can_do($a['edit']) ) : ?>
        <a href="<?php echo base_url()."flow/add/".$rs->id_bank_ac; ?>" style="text-decoration:none;">
        <button class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>&nbsp; เพิ่ม/แก้ไข รายการ</button>
        </a>
<?php else : ?>
		<button class="btn btn-info btn-xs" style="visibility:hidden"><i class="fa fa-pencil"></i>&nbsp; เพิ่ม/แก้ไข รายการ</button>
<?php endif; ?>
	</td>
    <td>
		<?php echo $rs->ac_code; ?>
		&nbsp; : &nbsp;
		<?php echo bank_name($rs->id_bank); ?>
		&nbsp; : &nbsp;
		<?php echo $rs->ac_number; ?>
		&nbsp; : &nbsp;
		<?php echo $rs->ac_name; ?>
    </td>
		<td align="right">
			<?php echo number_format($last_month_balance, 2); ?>
		</td>
		<td align="right">
			<?php echo number_format($total_move_in_amount, 2); ?>
		</td>
		<td align="right">
			<?php echo number_format($total_move_out_amount, 2); ?>
		</td>
		<td align="right">
			<?php echo number_format($balance, 2); ?>
		</td>
    <td align="center">
    	<?php echo company_name($rs->id_company); ?>
    </td>
    <td></td>
    </tr>
		<?php
			$total_balance += $balance;
			$total_last_month += $last_month_balance;
			$total_move_in += $total_move_in_amount;
			$total_move_out += $total_move_out_amount;
		?>
<?php 	endforeach; ?>
	<tr>
		<td colspan="2" align="right">คงเหลือรวม(<?php echo thaiDate(); ?>)</td>
		<td align="right"><?php echo number_format($total_last_month, 2); ?></td>
		<td align="right"><?php echo number_format($total_move_in, 2); ?></td>
		<td align="right"><?php echo number_format($total_move_out, 2); ?></td>
		<td align="right"><?php echo number_format($total_balance, 2); ?></td>
		<td></td>
		<td></td>
	</tr>
</table>
<?php else : ?>
<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			<strong><i class="ace-icon fa fa-exclamation-circle"></i>&nbsp; ยังไม่มีบัญชีธนาคาร สามารถเพิ่มได้ที่ เมนู กำหนดค่า >> เพิ่ม/แก้ไข บัญชีธนาคาร (ต้องเพิ่ม ธนาคาร และ บริษัทก่อน)</strong><br>
</div>

<?php endif; ?>
</div>
<?php endif; ?>
