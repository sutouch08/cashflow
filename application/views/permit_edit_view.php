<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php 
	$p = valid_access($id_menu);  	
?>
<?php if($p['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class='row'>
	<div class='col-lg-6 col-md-6 col-sm-6'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-lock'></i>&nbsp; <?php echo $title; ?>&nbsp; : &nbsp; <?php echo $profile_name; ?></h3>
    </div>
    <div class='col-lg-6 col-md-6 col-sm-6'>
    	<p class="pull-right">
        	<a href="<?php echo $this->home; ?>" style="text-decoration:none;">
            	<button type="button" class="btn btn-warning"><i class="fa fa-arrow-left"></i>&nbsp;กลับ</button>
            </a>
<?php if( can_do($p['add'] ) || can_do($p['edit']) ) : ?>
			&nbsp;<button class="btn btn-success" type="button" onclick="save()"><i class="fa fa-save"></i> &nbsp; บันทึก</button>
<?php endif; ?>        
        </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<form id="permit_form" action="<?php echo $this->home; ?>/edit/<?php echo $id_profile; ?>" method="post">
<input type="hidden" name="edit" value="1" />
<table  id="simple-table"class="table table-striped table-bordered">
<thead>
	<th style="width:30%; text-align:center">เมนู</th>
    <th class="center" style="width:10%;"><label ><input class="ace" type="checkbox" id="view_all" /><span class="lbl">&nbsp;เข้า</span></label></th>
    <th class="center" style="width:10%;"><label ><input class="ace" type="checkbox" id="add_all" /><span class="lbl">&nbsp;เพิ่ม</span></label></th>
    <th class="center" style="width:10%;"><label ><input class="ace" type="checkbox" id="edit_all" /><span class="lbl">&nbsp;แก้ไข</span></label></th>
    <th class="center" style="width:10%;"><label ><input class="ace" type="checkbox" id="delete_all" /><span class="lbl">&nbsp;ลบ</span></label></th>
    <th class="center" style="width:10%;"><label ><input class="ace" type="checkbox" id="print_all" /><span class="lbl">&nbsp;พิมพ์</span></label></th>
    <th class="center" style="width:10%;"><label ><input class="ace" type="checkbox" id="approve_all" /><span class="lbl">&nbsp;อนุมัติ</span></label></th>
    <th class="center" style="width:10%;"><label ><input class="ace" type="checkbox" id="check_all" /><span class="lbl">&nbsp; เลือกทั้งหมด</span></label></th>
</thead>
<?php if( isset($data) && $data != false) : ?>
<?php 	foreach($data as $rs) : ?>
<?php 	if( ($rs->view + $rs->add + $rs->edit + $rs->del + $rs->print + $rs->approve) == 6 ){ $all = 1; }else{ $all = 0; } ?>
<tr>
	<td><?php echo menu_name($rs->id_menu); ?> <input type="hidden" name="menu[<?php echo $rs->id_menu; ?>]" value="<?php echo $rs->id_menu; ?>"  /></td>
    <td align="center">
    	<input type="checkbox" class="<?php echo $rs->id_menu; ?> view ace" name="view[<?php echo $rs->id_menu; ?>]" id="view[<?php echo $rs->id_menu; ?>]" value="1" <?php echo isChecked($rs->view, 1); ?> onchange="remove_check_all($(this),<?php echo $rs->id_menu; ?>, 'view_all')"  />
        <span class="lbl"></span>
    </td>
    <td align="center">
    <input type="checkbox" class="<?php echo $rs->id_menu; ?> add ace" name="add[<?php echo $rs->id_menu; ?>]" id="add[<?php echo $rs->id_menu; ?>]" value="1" <?php echo isChecked($rs->add, 1); ?> onchange="remove_check_all($(this),<?php echo $rs->id_menu; ?>, 'add_all')" />
    <span class="lbl"></span>
    </td>
    <td align="center">
    <input type="checkbox" class="<?php echo $rs->id_menu; ?> edit ace" name="edit[<?php echo $rs->id_menu; ?>]" id="edit[<?php echo $rs->id_menu; ?>]" value="1" <?php echo isChecked($rs->edit, 1); ?> onchange="remove_check_all($(this),<?php echo $rs->id_menu; ?>, 'edit_all')" />
    <span class="lbl"></span>
    </td>
    <td align="center">
    <input type="checkbox" class="<?php echo $rs->id_menu; ?> delete ace" name="delete[<?php echo $rs->id_menu; ?>]" id="delete[<?php echo $rs->id_menu; ?>]" value="1" <?php echo isChecked($rs->del, 1); ?> onchange="remove_check_all($(this),<?php echo $rs->id_menu; ?>, 'delete_all')" />
    <span class="lbl"></span>
    </td>
    <td align="center">
    <input type="checkbox" class="<?php echo $rs->id_menu; ?> print ace" name="print[<?php echo $rs->id_menu; ?>]" id="print[<?php echo $rs->id_menu; ?>]" value="1" <?php echo isChecked($rs->print, 1); ?> onchange="remove_check_all($(this),<?php echo $rs->id_menu; ?>, 'print_all')" />
    <span class="lbl"></span>
    </td>
    <td align="center">
    <input type="checkbox" class="<?php echo $rs->id_menu; ?> approve ace" name="approve[<?php echo $rs->id_menu; ?>]" id="approve[<?php echo $rs->id_menu; ?>]" value="1" <?php echo isChecked($rs->approve, 1); ?> onchange="remove_check_all($(this),<?php echo $rs->id_menu; ?>, 'approve_all')" />
    <span class="lbl"></span>
    </td>
    <td align="center"><input type="checkbox" class="all<?php echo $rs->id_menu; ?> ace" id="all_<?php echo $rs->id_menu; ?>" onchange="select_all($(this), <?php echo $rs->id_menu; ?>)"  <?php echo isChecked($all, 1); ?> /><span class="lbl"></span></td>
</tr>
<?php 	endforeach; ?>

<?php else : ?>
<tr>
	<td colspan="8" align="center">
    	<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
			<h3 style="display:inline;"><i class="ace-icon fa fa-exclamation-circle"></i>&nbsp; ยังไม่มีรายการ</h3>&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-primary" onclick="add_tabs(<?php echo $id_profile; ?>)" ><i class="fa fa-plus"></i>&nbsp; เปิดรายการกำหนดสิทธิ์</button>
		</div>
    </td>
</tr>

<?php endif; ?>
</table>
</form>
<script>
function save()
{
	$("#permit_form").submit();	
}

function add_tabs(id)
{
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/add_tabs/"+id,
		type:"GET", cache:false,
		success: function(rs)
		{
			var rs = $.trim(rs);
			if(rs == "success")
			{
				location.reload();
			}else if( rs == "fail" ){
				swal("Add tabs notsuccessfull");
			}			
		}
	});
}

function select_all(el, id){
	if(el.is(":checked")){
		$("."+id).each(function(index, element) {
            $(this).prop("checked", true);
        });
	}else{
		$("."+id).each(function(index, element) {
            $(this).prop("checked", false);
        });
	}
}

$("#check_all").change(function(e) {
    if($(this).is(":checked")){
		$("input[type='checkbox']").each(function(index, element) {
            $(this).prop("checked",true);
        });
	}else{
		$("input[type='checkbox']").each(function(index, element) {
            $(this).prop("checked",false);
        });
	}
});


$("#view_all").change(function(e) {
    if($(this).is(":checked")){
		$(".view").each(function(index, element) {
            $(this).prop("checked",true);
        });
	}else{
		$(".view").each(function(index, element) {
            $(this).prop("checked",false);
        });
	}
});

$("#add_all").change(function(e) {
    if($(this).is(":checked")){
		$(".add").each(function(index, element) {
            $(this).prop("checked",true);
        });
	}else{
		$(".add").each(function(index, element) {
            $(this).prop("checked",false);
        });
	}
});

$("#edit_all").change(function(e) {
    if($(this).is(":checked")){
		$(".edit").each(function(index, element) {
            $(this).prop("checked",true);
        });
	}else{
		$(".edit").each(function(index, element) {
            $(this).prop("checked",false);
        });
	}
});

$("#delete_all").change(function(e) {
    if($(this).is(":checked")){
		$(".delete").each(function(index, element) {
            $(this).prop("checked",true);
        });
	}else{
		$(".delete").each(function(index, element) {
            $(this).prop("checked",false);
        });
	}
});

$("#print_all").change(function(e) {
    if($(this).is(":checked")){
		$(".print").each(function(index, element) {
            $(this).prop("checked",true);
        });
	}else{
		$(".print").each(function(index, element) {
            $(this).prop("checked",false);
        });
	}
});

$("#approve_all").change(function(e) {
    if($(this).is(":checked")){
		$(".approve").each(function(index, element) {
            $(this).prop("checked",true);
        });
	}else{
		$(".approve").each(function(index, element) {
            $(this).prop("checked",false);
        });
	}
});

function remove_check_all(el, id, cls)
{
	if(el.is(":checked") == false){
		$("#"+cls).prop("checked", false);
		$("#all_"+id).prop("checked", false);
	}
}

</script>



<?php endif; ?>