// JavaScript Document

function fn_getOrderTrail(oid)
{
	$.post("order_status.php",
	{
		oid:oid
	},
	function(data,status){ 
	  $("#orderStatus").html(data);
	});
}