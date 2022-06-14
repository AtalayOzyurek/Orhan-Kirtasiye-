/*********************************/
				// Ýlker Þahin //
/*********************************/

$(function() {
	$( "#sortable" ).sortable({
		revert: true,
		handle: ".sortable",
		stop: function (event, ui) {
			var data = $(this).sortable('serialize');
			var table = $(this).attr("target");
			
			$.ajax({
				type: "POST",
				dataType: "json",
				data: data,
				url: "actions/siralama.php?tbname=" + table,
				success: function(msg){
					// alert(msg.islemMsj);
					// her iþlem sonrasý bildirim çýkmasýný geçici olarak devre dýþý býraktýk
				}
			});
		}
	});
	$( "#sortable" ).disableSelection();
});