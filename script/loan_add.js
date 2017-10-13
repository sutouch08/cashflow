
$("#amount").numberOnly();
$("#rate").numberOnly();
$("#days").numberOnly();
$("#edit_amount").numberOnly();
$("#edit_rate").numberOnly();
$("#edit_days").numberOnly();
$("#start_amount").numberOnly();
function date_error(title, text, el)
{
	swal({
			  title: title,
			  text: text,
			  type: "error",
			  showCancelButton: false,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "ตกลง",
			  closeOnConfirm: true},
			  function(isConfirm){
			  if (isConfirm) {
				el.focus();
			  } 
			});
			el.focus();
}

function clear_field()
{
	$("#date_add").val("");	
	$("#detail").val("");
	$("#reference").val("");
	$("#amount").val("");
	$("#rate").val("");
	$("#days").val("");
	$("#remark").val("");
	$("#date_add").focus();
}

$("#date_add").mask("99/99/9999");
$("#edit_date_add").mask("99/99/9999");
$("#start_date_add").mask("99/99/9999");

$("#date_add")	.bind("enterKey",function(){ 	$("#detail").focus(); });
$("#detail")		.bind("enterKey",function(){	$("#reference").focus(); });
$("#reference")	.bind("enterKey",function(){	$("#amount").focus(); });
$("#amount")		.bind("enterKey",function(){ 	$("#rate").focus(); });
$("#rate")			.bind("enterKey",function(){ 	if($(this).val() =="")	{ $(this).val(0.000);	}	$("#days").focus(); });
$("#days")		.bind("enterKey",function(){	$("#remark").focus(); });
$("#remark")		.bind("enterKey",function(){ 	$("#btn_save").focus(); });
$("#btn_save")	.bind("enterKey",function(){ 	$("#btn_save").click(); });


$("#date_add")	.keyup(function(e){		if(e.keyCode == 13){ $(this).trigger("enterKey");  } });
$("#detail")		.keyup(function(e){   	if(e.keyCode == 13){ $(this).trigger("enterKey");  } });
$("#reference")	.keyup(function(e){  	if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#amount")		.keyup(function(e){    	if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#rate")			.keyup(function(e){ 	if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#days")		.keyup(function(e){ 	if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#remark")		.keyup(function(e){ 	if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#btn_save")	.keyup(function(e){  	if(e.keyCode == 13){ $(this).trigger("enterKey"); } });

$("#start_date_add")	.bind("enterKey",function(){ 	$("#start_detail").focus(); });
$("#start_detail")		.bind("enterKey",function(){	$("#start_amount").focus(); });
$("#start_amount")		.bind("enterKey",function(){ 	$("#btn_save").focus(); });

$("#start_date_add")	.keyup(function(e){		if(e.keyCode == 13){ $(this).trigger("enterKey");  } });
$("#start_detail")		.keyup(function(e){   	if(e.keyCode == 13){ $(this).trigger("enterKey");  } });
$("#start_amount")		.keyup(function(e){    	if(e.keyCode == 13){ $(this).trigger("enterKey"); } });


$("#edit_date_add").bind("enterKey",function(){  $("#edit_detail").focus(); });
$("#edit_detail").bind("enterKey",function(){  $("#edit_reference").focus(); });
$("#edit_detail").bind("enterKey",function(){  $("#edit_reference").focus(); });
$("#edit_reference").bind("enterKey",function(){ $("#edit_amount").focus(); });
$("#edit_amount").bind("enterKey",function(){ $("#edit_rate").focus(); });
$("#edit_rate").bind("enterKey",function(){ $("#edit_days").focus(); });
$("#edit_days").bind("enterKey",function(){ $("#edit_remark").focus(); });
$("#edit_remark").bind("enterKey",function(){ $("#btn_update").focus(); });
$("#btn_update").bind("enterKey",function(){ $("#btn_btn_update").click(); });

$("#edit_date_add").keyup(function(e){ if(e.keyCode == 13){  $(this).trigger("enterKey"); } });
$("#edit_detail").keyup(function(e){ if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#edit_reference").keyup(function(e){ if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#edit_amount").keyup(function(e){ if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#edit_rate").keyup(function(e){if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#edit_days").keyup(function(e){ if(e.keyCode == 13) { $(this).trigger("enterKey"); } });
$("#edit_remark").keyup(function(e){ if(e.keyCode == 13){ $(this).trigger("enterKey"); } });
$("#edit_btn_save").keyup(function(e){ if(e.keyCode == 13){$(this).trigger("enterKey"); } });
