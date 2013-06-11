function monitoramento() {
	$.ajax({
		type:"get",
		url:"content/monitor_ajax.php",
		success: function(data) {
			$('#monitoramento').html(data);
		}
	});
}

$(function() {
	if($("#monitoramento").size() > 0)
		setInterval("monitoramento()", 1000);
});