
<script>
$(function () {
	
	//gráfico total Oberts
	var opciones = <?php echo $opcTotalesPie; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);
	
	var opciones = <?php echo $opcTotalesColumn; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);
	
	//gráfico total Tancats
	var opciones = <?php echo $opcTotalesPieC; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);
	
	var opciones = <?php echo $opcTotalesColumnC; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);
	
	var opciones = <?php echo $opcTotalesColumnCStack; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);
	
	var opciones = <?php echo $opcTotalesColumnCStackI; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);
	
	
	//grafico incidencias SLA
	/*var opciones = <?php echo $opcTotales1; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);
    
    

    //grafico peticions SLA
    var opciones = <?php echo $opcTotales2; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);
    

    //grafico evolutius SLA
    var opciones = <?php echo $opcTotales3; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);
        
	//grafico consultes SLA
	var opciones = <?php echo $opcTotales4; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);

    //grafico canvis SLA
    var opciones = <?php echo $opcTotales5; ?>;
	opciones.exporting.buttons.contextButton.onclick = function() { this.exportChart();};
	var chart = new Highcharts.Chart(opciones);*/
    
});
</script>
	<br>
	<div class="alert alert-info">
		<h4>Dades dels tíckets oberts</h4>
		<!-- <p>Gràfics sobre els tickets oberts entre les dates fixades.</p> -->
	</div>
	<div class="row">
		<div id="containerGrafPie" class="col-md-5"></div>
		<div id="containerGrafColumn" class="col-md-5 col-md-offset-1"></div>
		
		<!--<div id="containerGraf1" style="width:80%; height:400px;"></div>
		<hr>
		<div id="containerGraf2" style="width:80%; height:400px;"></div>
		<hr>
		<div id="containerGraf3" style="width:80%; height:400px;"></div>
		<hr>
		<div id="containerGraf4" style="width:80%; height:400px;"></div>
		<hr>
		<div id="containerGraf5" style="width:80%; height:400px;"></div>
		<hr>
		<div id="containerGraf6" style="width:80%; height:400px;"></div>-->
		
	</div>
	
	<br>
	<div class="alert alert-info">
		<h4>Dades dels tíckets Tancats</h4>
		<!-- <p>Gràfics sobre els tickets oberts entre les dates fixades.</p> -->
	</div>
	<div class="row">
		<div id="containerGrafPieC" class="col-md-5"></div>
		<div id="containerGrafColumnC" class="col-md-5 col-md-offset-1"></div>	
	</div>
	<br>
	<div class="row">
		<div id="containerGrafColumnCStack" class="col-md-5"></div>
		<div id="containerGrafColumnCStackI" class="col-md-5 col-md-offset-1"></div>
	</div>
