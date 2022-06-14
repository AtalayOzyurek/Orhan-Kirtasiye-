/*********************************/
				// �lker �ahin //
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
					// her i�lem sonras� bildirim ��kmas�n� ge�ici olarak devre d��� b�rakt�k
				}
			});
		}
	});
	$( "#sortable" ).disableSelection();
});