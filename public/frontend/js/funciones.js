$(function (){
		
	$( ".datepicker" ).datepicker({ dateFormat: 'yy/mm/dd' });
	
	$("table#tableSorter").tablesorter({ sortList: [[1,0]] });
	$("table#tableSorter1").tablesorter({ sortList: [[1,0]] });
	
	$("table#tableSorter4").tablesorter({ sortList: [[1,0]] });
	$("table#tableSorter5").tablesorter({ sortList: [[1,0]] });
	$("table#tableSorter6").tablesorter({ sortList: [[1,0]] });
	$("table#tableSorter7").tablesorter({ sortList: [[1,0]] });
	
	$( "button").on( "click", function() {
		var valor = $(this).attr('identi');
		$("#"+ valor).toggle();
	});
	
	$("[rel=tooltip]").tooltip({ placement: 'right'});
	
	$("#exportar_excel").click(function(e) {
		e.preventDefault();
		window.open('data:application/vnd.ms-excel;charset=UTF-8,' + $('#datos_export').html());
	});
	
	$("a#links").on('click', function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		$.ajax({
			type: 'GET',
			url: url,
			success: function(data){
				$('#div_calendario').html(data);
			}
	   });
		
	});
	
	$( ".cat" ).click(function(e){
		e.preventDefault();
		$('.modal-body').empty();
		var tipo = $(this).attr('tipo');
		var cat = $(this).attr('cat');
		var grupo = $(this).attr('grupo');
		var datepicker1 = $('#datepicker1').val();
		var datepicker2 = $('#datepicker2').val();
		$.ajax({
			type: 'POST',
			data: {'tipo' : tipo, 'cat' : cat, 'datepicker1' : datepicker1, 'datepicker2' : datepicker2, 'grupo' : grupo},
			dataType: 'json',
			url: urlDetallado,
			success: function(data){
				$('.modal-body').append("<div class='row-fluid'><div class='panel panel-info'><div class='panel-heading'>Tickets</div><div class='panel-body'><table class='table table-bordered table-hover datatable' id='dataTableModal'><thead><tr><td><b>ID</b></td><td><b>Títol</b></td></tr><tbody></tbody></table></div></div></div>");
				for( var i = 0; i < data.length; i++ ){
					$('.modal-body table tbody').append('<tr><td>' + data[i].id + '</td><td>' + data[i].titol + '</td></tr>');
				}

				$("#myModal").modal('show');
			}
	   });
	});
});
