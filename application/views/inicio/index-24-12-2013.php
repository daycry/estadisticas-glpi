<html>
<head>
<title>Registro</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf8' />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src='<?php echo base_url_static_f();?>js/jquery-ui-timepicker-addon.js'></script>
<script src='<?php echo base_url_static_f();?>bootstrap/js/bootstrap.js'></script>
<link href='<?php echo base_url_static_f();?>bootstrap/css/bootstrap.css' rel="stylesheet">
<link href='<?php echo base_url_static_f();?>bootstrap/css/bootstrap-responsive.css' rel="stylesheet">
<script src='<?php echo base_url_static_f();?>js/jquery.tablesorter.min.js'></script>
<link href='<?php echo base_url_static_f();?>css/personal.css' rel="stylesheet">
<script src='<?php echo base_url_static_f();?>js/funciones.js'></script>

</head>
<body>
	
<div class="container">	
	
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<center><h1 face="verdana"><?php echo $titulo; ?></h1></center>
			</div>
		</div>
		<div class="span12">
			<div class="row-fluid">
				&nbsp;
			</div>
		</div>
		
		<div class="span12">
			<?php if ( validation_errors() ){ ?>
						<div class="alert">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Errors!</strong><?php echo validation_errors(); ?>
						</div>
			<?php } ?>
		</div>
		
		
		<?php echo form_open('inicio/buscar'); ?>
		<div class="span12">
			<div class="row-fluid">
				<div class="span4">
					Fecha inicio: <input type="text" class="datepicker" id="datepicker1" name="datepicker1" maxlength="10" value="<?php echo set_value('datepicker1'); ?>"/>
				</div>
				<div class="span4">
					Fecha Final: <input type="text" class="datepicker" id="datepicker2" name="datepicker2" maxlength="10" value="<?php echo set_value('datepicker2'); ?>"/>
				</div>
				<div class="span4">
					<button type="submit" class="btn btn-primary btn-sm">Buscar</button>
				</div>
			</div>
		 </div>
		 </form>
	</div>
<br>

<?php

if ( set_value('datepicker1') != "" && set_value('datepicker2') != ""){

?>

<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li><a href="#home" data-toggle="tab">Datos Generales</a></li>
  <li><a href="#tickets" data-toggle="tab">Tickets</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="home">
	  
	<!-- div datos generales -->
	<div class="span12">
	<div class="row-fluid">
		<div class="span6">	
	<?php
	$ci = &get_instance();
	$ci->load->model('tickets');
	
	if(isset($grupos)){
		
		echo"<h2>DEPARTAMENTS</h2>";
		echo "<table border='1' bordercolor='#FFCC00' style='background-color:#CCFFCC' width='90%' cellpadding='3' cellspacing='3'>";
			echo "<tr>";
				echo "<td><b>GRUP</b></td>";
				echo "<td><b>TOTAL INCIDENCIES</b></td>";
				echo "<td><b>TOTAL CONSULTES</b></td>";
				echo "<td><b>TOTAL EVOLUTIUS</b></td>";
				echo "<td><b>TOTAL CANVIS</b></td>";
			echo "</tr>";
		
		foreach ($grupos as $grupo){
			
			$tickets = $ci->tickets->getTicketsByGroup($grupo->id, set_value('datepicker1'), set_value('datepicker2'), 1, 1);
			$tickets1 = $ci->tickets->getTicketsByGroup($grupo->id, set_value('datepicker1'), set_value('datepicker2'), 2, 1 );
			$tickets2 = $ci->tickets->getTicketsByGroup($grupo->id, set_value('datepicker1'), set_value('datepicker2'), 3, 1 );
			$tickets3 = $ci->tickets->getTicketsByGroup($grupo->id, set_value('datepicker1'), set_value('datepicker2'), 4, 1 );
				echo"<tr>";
					echo"<td>". $grupo->name . "</td>";
					
					if( count($tickets) > 0){
						$totalIncidencias = 0;
						foreach ($tickets as $ticket){
							echo"<td class='tdContenido'>" . $ticket->total . "</td>";
							$totalIncidencias = $totalIncidencias + (int)$ticket->total;
						}
					}else{
						echo"<td class='tdSinContenido'>0</td>";
					}
					
					if( count($tickets1) > 0){
						$totalConsultas = 0;
						foreach ($tickets1 as $ticket1){
							echo"<td class='tdContenido'>" . $ticket1->total . "</td>";
							$totalConsultas = $totalConsultas + (int)$ticket1->total;
						}
					}else{
						echo"<td class='tdSinContenido'>0</td>";
					}
					
					if( count($tickets2) > 0){
						$totalEvolutivos = 0;
						foreach ($tickets2 as $ticket2){
							echo"<td class='tdContenido'>" . $ticket2->total . "</td>";
							$totalEvolutivos = $totalEvolutivos + (int)$ticket2->total;
						}
					}else{
						echo"<td class='tdSinContenido'>0</td>";
					}
					
					if( count($tickets3) > 0){
						$totalCanvis = 0;
						foreach ($tickets3 as $ticket3){
							echo"<td class='tdContenido'>" . $ticket3->total . "</td>";
							$totalCanvis = $totalCanvis + (int)$ticket3->total;
						}
					}else{
						echo"<td class='tdSinContenido'>0</td>";
					}
					
				echo"</tr>";
				//libero las variables para no consumir recursos
			unset($tickets);
			unset($tickets1);
			unset($tickets2);
			unset($tickets3);
		}
		echo"</table>";
	}
?>	
		
		
		</div>
	<div class="span6">
		<?php
				if(isset($demarcaciones)){
		
		echo"<h2>DEMARCACIONS</h2>";
		echo "<table border='1' bordercolor='#FFCC00' style='background-color:#CCFFCC' width='90%' cellpadding='3' cellspacing='3'>";
			echo "<tr>";
				echo "<td><b>DEMARCACIÓ</b></td>";
				echo "<td><b>TOTAL INCIDENCIES</b></td>";
				echo "<td><b>TOTAL CONSULTES</b></td>";
				echo "<td><b>TOTAL EVOLUTIUS</b></td>";
				echo "<td><b>TOTAL CANVIS</b></td>";
			echo "</tr>";
		
		foreach ($demarcaciones as $demarcacion){
			
			$tickets = $ci->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 1, 0);
			$tickets1 = $ci->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 2, 0 );
			$tickets2 = $ci->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 3, 0 );
			$tickets3 = $ci->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 4, 0 );
				echo"<tr>";
					echo"<td>". $demarcacion->name . "</td>";
					
					if( count($tickets) > 0){
					
						foreach ($tickets as $ticket){
							echo"<td class='tdContenido'>" . $ticket->total . "</td>";
						}
					}else{
						echo"<td class='tdSinContenido'>0</td>";
					}
					
					if( count($tickets1) > 0){
					
						foreach ($tickets1 as $ticket1){
							echo"<td class='tdContenido'>" . $ticket1->total . "</td>";
						}
					}else{
						echo"<td class='tdSinContenido'>0</td>";
					}
					
					if( count($tickets2) > 0){
					
						foreach ($tickets2 as $ticket2){
							echo"<td class='tdContenido'>" . $ticket2->total . "</td>";
						}
					}else{
						echo"<td class='tdSinContenido'>0</td>";
					}
					
					if( count($tickets3) > 0){
					
						foreach ($tickets3 as $ticket3){
							echo"<td class='tdContenido'>" . $ticket3->total . "</td>";
						}
					}else{
						echo"<td class='tdSinContenido'>0</td>";
					}
					
				echo"</tr>";
			unset($tickets);
			unset($tickets1);
			unset($tickets2);
			unset($tickets3);
		}
		echo"</table>";
	}
		
		
		if( isset($users)){
			echo"<h2>TÈCNICS</h2>";
			echo "<table border='1' bordercolor='#FFCC00' style='background-color:#CCFFCC' width='90%' cellpadding='3' cellspacing='3'>";
			echo "<tr>";
				echo "<td><b>TÈCNIC</td>";
				echo "<td><b>TOTAL INCIDENCIES</b></td>";
				echo "<td><b>TOTAL CONSULTES</b></td>";
				echo "<td><b>TOTAL EVOLUTIUS</b></td>";
				echo "<td><b>TOTAL CANVIS</b></td>";
				echo "</tr>";
		
				foreach ($users as $user){
					
					$tickets = $ci->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 1 );
					$tickets1 = $ci->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 2 );
					$tickets2 = $ci->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 3 );
					$tickets3 = $ci->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 4 );
						echo"<tr>";
							echo"<td>". $user->name . "</td>";
							
							if( count($tickets) > 0){
							
								foreach ($tickets as $ticket){
									echo"<td class='tdContenido'>" . $ticket->total . "</td>";
								}
							}else{
								echo"<td class='tdSinContenido'>0</td>";
							}
							
							if( count($tickets1) > 0){
							
								foreach ($tickets1 as $ticket1){
									echo"<td class='tdContenido'>" . $ticket1->total . "</td>";
								}
							}else{
								echo"<td class='tdSinContenido'>0</td>";
							}
							
							if( count($tickets2) > 0){
							
								foreach ($tickets2 as $ticket2){
									echo"<td class='tdContenido'>" . $ticket2->total . "</td>";
								}
							}else{
								echo"<td class='tdSinContenido'>0</td>";
							}
							
							if( count($tickets3) > 0){
							
								foreach ($tickets3 as $ticket3){
									echo"<td class='tdContenido'>" . $ticket3->total . "</td>";
								}
							}else{
								echo"<td class='tdSinContenido'>0</td>";
							}
							
						echo"</tr>";
					unset($tickets);
					unset($tickets1);
					unset($tickets2);
					unset($tickets3);
				}
				echo"</table>";
		
		
		
		
					echo"<h2>TOTAL</h2>";
			echo "<table border='1' bordercolor='#FFCC00' style='background-color:#CCFFCC' width='90%' cellpadding='3' cellspacing='3'>";
				echo "<tr>";
					echo "<td><b>TOTAL INCIDENCIES</b></td>";
					echo "<td><b>TOTAL CONSULTES</b></td>";
					echo "<td><b>TOTAL EVOLUTIUS</b></td>";
					echo "<td><b>TOTAL CANVIS</b></td>";
				echo "</tr>";
			
					echo"<tr>";
						if(isset($totalIncidencias)){
							echo"<td class='tdContenido'>". $totalIncidencias . "</td>";
						}else{
							echo"<td class='tdSinContenido'>0</td>";
						}
						if(isset($totalConsultas)){
							echo"<td class='tdContenido'>". $totalConsultas . "</td>";
						}else{
							echo"<td class='tdSinContenido'>0</td>";
						}
						if(isset($totalEvolutivos)){
							echo"<td class='tdContenido'>". $totalEvolutivos . "</td>";
						}else{
							echo"<td class='tdSinContenido'>0</td>";
						}
						if(isset($totalCanvis)){
							echo"<td class='tdContenido'>". $totalCanvis . "</td>";
						}else{
							echo"<td class='tdSinContenido'>0</td>";
						}
					echo"</tr>";
			echo"</table>";
		
		
		}	
		
		?>
	</div>

</div>
</div>	  
<!-- FIN div datos generales -->	  
	   
  </div>
  <div class="tab-pane" id="tickets">
  
  
  <!-- tickets detallados -->


<!--tickets de incidencias -->
	<div class="divBorder" identi="listadoIn"><h3>Llistat d'Incidèncias</h3><button identi = "listadoIn" type="button" class="btn btn-primary btn-xs">Muestra Listado</button>
		<div class="listado" id="listadoIn">
			<table id="tableSorter" class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>Títol</th>
						<th>Data Creació</th>
						<th>Data Finalització</th>
						<th>Estat</th>
						<th>Tipus</th>
					</tr>
				</thead>
				<tbody>
			<?php
			//print_r($listTicketsIn);
				foreach( $listTicketsIn as $listIn ){
						echo"<tr>";
							
							echo"<td>".$listIn->id."</td>";
							echo"<td>".$listIn->name."</td>";
							echo"<td>".$listIn->date."</td>";
							echo"<td>".$listIn->closedate."</td>";
							echo"<td>".$listIn->status."</td>";
							echo"<td>Incidència</td>";
						echo"</tr>";
				}
			?>
			</tbody>
			</table>
		</div>
	</div>
<!--FIN tickets de incidencias -->	


<!--tickets de peticiones -->
	<div class="divBorder" identi="listadoIn"><h3>Llistat de Peticions</h3><button identi = "listadoPet" type="button" class="btn btn-primary btn-xs">Muestra Listado</button>
		<div class="listado" id="listadoPet">
			<table id="tableSorter1" class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>Títol</th>
						<th>Data Creació</th>
						<th>Data Finalització</th>
						<th>Estat</th>
						<th>Tipus</th>
					</tr>
				</thead>
				<tbody>
			<?php
			//print_r($listTicketsIn);
				foreach( $listTicketsPet as $listPet ){
						echo"<tr>";
							
							echo"<td>".$listPet->id."</td>";
							echo"<td>".$listPet->name."</td>";
							echo"<td>".$listPet->date."</td>";
							echo"<td>".$listPet->closedate."</td>";
							echo"<td>".$listPet->status."</td>";
							echo"<td>Petició</td>";
						echo"</tr>";
				}
			?>
			</tbody>
			</table>
		</div>
	</div>
<!--FIN tickets de peticiones -->
  
<!--tickets de Evolutius -->
	<div class="divBorder" identi="listadoEv"><h3>Llistat de Evolutius</h3><button identi = "listadoEv" type="button" class="btn btn-primary btn-xs">Muestra Listado</button>
		<div class="listado" id="listadoEv">
			<table id="tableSorter1" class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>Títol</th>
						<th>Data Creació</th>
						<th>Data Finalització</th>
						<th>Estat</th>
						<th>Tipus</th>
					</tr>
				</thead>
				<tbody>
			<?php
			//print_r($listTicketsIn);
				foreach( $listTicketsEvo as $listEvo ){
						echo"<tr>";
							
							echo"<td>".$listEvo->id."</td>";
							echo"<td>".$listEvo->name."</td>";
							echo"<td>".$listEvo->date."</td>";
							echo"<td>".$listEvo->closedate."</td>";
							echo"<td>".$listEvo->status."</td>";
							echo"<td>Evolutiu</td>";
						echo"</tr>";
				}
			?>
			</tbody>
			</table>
		</div>
	</div>
<!--FIN tickets de Evolutius -->
  
<!--tickets de Canvis -->
	<div class="divBorder" identi="listadoCan"><h3>Llistat de Canvis</h3><button identi = "listadoCan" type="button" class="btn btn-primary btn-xs">Muestra Listado</button>
		<div class="listado" id="listadoCan">
			<table id="tableSorter1" class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>Títol</th>
						<th>Data Creació</th>
						<th>Data Finalització</th>
						<th>Estat</th>
						<th>Tipus</th>
					</tr>
				</thead>
				<tbody>
			<?php
			//print_r($listTicketsIn);
				foreach( $listTicketsCan as $listCan ){
						echo"<tr>";
							
							echo"<td>".$listCan->id."</td>";
							echo"<td>".$listCan->name."</td>";
							echo"<td>".$listCan->date."</td>";
							echo"<td>".$listCan->closedate."</td>";
							echo"<td>".$listCan->status."</td>";
							echo"<td>Canvi</td>";
						echo"</tr>";
				}
			?>
			</tbody>
			</table>
		</div>
	</div>
<!--FIN tickets de Canvis -->
  
  </div>
</div>
	
<?php

}

?>	


</body>
</html>
