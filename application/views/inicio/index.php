<html>
<head>
<title>Registro</title>

<!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->

<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src='<?php echo base_url_static_f();?>js/jquery-ui-timepicker-addon.js'></script>
<script src='<?php echo base_url_static_f();?>bootstrap/js/bootstrap.js'></script>
<link href='<?php echo base_url_static_f();?>bootstrap/css/bootstrap.css' rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url_static_f();?>bootstrap/css/bootstrap-theme.min.css">

<!-- Page-Level Plugin Scripts - Tables -->
<script src="<?php echo base_url_static_f();?>js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url_static_f();?>js/dataTables/dataTables.bootstrap.js"></script>
<link href="<?php echo base_url_static_f();?>css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

<!-- tablas generales-->
<script src='<?php echo base_url_static_f();?>js/jquery.tablesorter.min.js'></script>
<link href='<?php echo base_url_static_f();?>css/personal.css' rel="stylesheet">
<script src='<?php echo base_url_static_f();?>js/funciones.js'></script>

<!-- calendario -->
<link href='<?php echo base_url_static_f();?>calendar/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo base_url_static_f();?>calendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='<?php echo base_url_static_f();?>calendar/lib/moment.min.js'></script>
<script src='<?php echo base_url_static_f();?>calendar/fullcalendar.min.js'></script>
<script src='<?php echo base_url_static_f();?>calendar/lang/es.js'></script>


<script>
    $(document).ready(function() {
        $('.dataTable').dataTable();
        $('#calendar').fullCalendar(<?php echo $newCalendario; ?>);       
	});
</script>

</head>
<body>
	
<div class="container">	
	<div class="row">&nbsp;</div>
	<div class="row">
		<div class="col-md-12"></div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
						<img src="<?php echo base_url_static_f();?>images/logo.png" />
					</div>
					<div class="col-md-6">
						<!-- <div class="row"> -->
						<center><h1 face="verdana"><?php echo $titulo; ?></h1></center>
						<!-- </div> -->
					</div>
					<div class="col-md-3">
						<p><b>USUARI REGISTRAT: <?php echo strtoupper($username); ?></b></p>
						<p><span class="glyphicon glyphicon-off"></span> <?php echo anchor('ldap/logout', 'Tancar sessió ', 'title="Tancar sessió"'); ?></p>
					</div>
				</div>
				<div class="col-md-12">
					<div class="row"></div>
				</div>
		</div>
		
		
		<?php echo form_open('inicio/buscar'); ?>
		<!--
			<div class="col-md-12">
				<p><b>USUARI REGISTRAT: <?php //echo strtoupper($username); ?></b></p>
				<p><i class="icon-off"></i><?php //echo anchor('ldap/logout', 'Tancar sessió', 'title="Tancar sessió"'); ?></p>
			 </div>
		 -->
		
		<fieldset class="row fieldset">
			<legend>Cercador</legend>
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							Data inici: <input type="text" class="datepicker" id="datepicker1" name="datepicker1" maxlength="10" value="<?php echo set_value('datepicker1'); ?>"/>
						</div>
						<div class="col-md-4">
							Data Final: <input type="text" class="datepicker" id="datepicker2" name="datepicker2" maxlength="10" value="<?php echo set_value('datepicker2'); ?>"/>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary btn-sm">Cercar</button>
						</div>
					</div>
				 </div>
		 </fieldset>
		 
		 </form>
		 
		 
		 
			<?php if ( validation_errors() ){ ?>
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="alert">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Errors!</strong><?php echo validation_errors(); ?>
							</div>
						</div>
					</div>
			<?php } ?>
		
		 
	</div>
<!-- <br> -->

<?php
	$inici = date('Y-m-d', strtotime(set_value('datepicker1')));
	$final = date('Y-m-d', strtotime(set_value('datepicker2')));

if ( set_value('datepicker1') != "" && set_value('datepicker2') != "" && ( $inici <= $final )){

?>
		<div class="row">
			<div class="col-md-5">
				<div class="alert alert-success">Filtre seleccionat entre <h4 style="display:inline"><b><?php echo date('d-m-Y', strtotime(set_value('datepicker1')));?></b></h4> i <h4 style="display:inline"><b><?php echo date('d-m-Y', strtotime(set_value('datepicker2'))); ?></b></h4></div>
			</div>
		</div>

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" id="myTabs">
		  <li class="active"><a href="#home" data-toggle="tab">Generals Oberts <?php if( isset($listTicketsAll) ){ ?>&nbsp;<span class="badge"><?php echo count($listTicketsAll); ?></span> <?php } ?></a></li>
		  <li><a href="#tancats" data-toggle="tab">Generals Tancats <?php if( isset($listTicketsAllC) ){ ?>&nbsp;<span class="badge"><?php echo count($listTicketsAllC); ?></span> <?php } ?></a></li>
		  <li><a href="#tickets" data-toggle="tab">Tickets Oberts</a></li>
		  <li><a href="#sla" data-toggle="tab">Tickets tancats</a></li>
		  <li><a href="#grafics" data-toggle="tab">Gràfics</a></li>
		  <li><a href="#excel" data-toggle="tab">Excel Oberts</a></li>
		  <li><a href="#excelC" data-toggle="tab">Excel Tancats</a></li>
		  <li><a href="#Divcalendar" data-toggle="tab">Calendari</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">

			
		<!-- INICIO DATOS GENERALES ABIERTOS -->
			<div class="tab-pane active" id="home">
				<?php
					$this->load->view('partial/general_abiertos');
				?>
			</div>
		<!-- FIN div datos generales abiertos-->	



		<!-- INICIO DATOS GENERALES CERRADOS -->
			<div class="tab-pane" id="tancats">
				<?php
					$this->load->view('partial/general_cerrados');
				?>
			</div>
		<!-- FIN DATOS GENERALES CERRADOS -->



		<!-- INICIO tickets detallados -->
			<div class="tab-pane" id="tickets">
				<?php
					$this->load->view('partial/tickets');
				?>
		  
			</div>
		<!--FIN tab tickets -->  
		  
		  
		  
		  
		<!-- INICIO tab SLA -->
			<div class="tab-pane" id="sla">
				<?php
					$this->load->view('partial/sla');
				?>
			</div>
		<!--FIN tab SLA -->
		  
		  
		 
		<!-- INICIO tab GRAFICS -->
			<div class="tab-pane" id="grafics">
				<?php
					$this->load->view('partial/graficos');
				?>
			</div>
		<!--FIN tab GRAFICS -->
		  
		  
		  
		<!--INICIO tab EXCEL ABIERTOS -->
			<div class="tab-pane" id="excel">
					<div id="datos_export">
					<?php 
						$this->load->view('partial/exportar_excel');
					?>
					</div>
			</div>
		<!--FIN tab EXCEL ABIERTOS -->
		
		
		<!--INICIO tab EXCEL CERRADOS -->
			<div class="tab-pane" id="excelC">
					<div id="datos_export">
					<?php 
						$this->load->view('partial/exportar_excel_cerrados');
					?>
					</div>
			</div>
		<!--FIN tab EXCEL CERRADOS -->
		
		<!--INICIO tab Calendario -->
			<div class="tab-pane" id="Divcalendar">
					<div id="div_calendario">
					<?php 
						$this->load->view('partial/calendario');
					?>
					</div>
			</div>
		<!--FIN tab Calendario -->

		</div> 
	
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Informació Detallada</h4>
			  </div>
			  <div class="modal-body">
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
<?php

}

?>	


</body>
</html>
