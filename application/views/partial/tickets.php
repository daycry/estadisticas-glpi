
		<!-- <div class="alert alert-info">
			<p>Informació sobre els tickets oberts entre les dates fixades.</p>
		</div> -->
		
		<div class="row">
			&nbsp;
		</div>
		
			<!--tickets de incidencias -->
			<div class="row">
				<div class="panel panel-info">
				<div class="panel-heading">
					Incidències
				</div>
					<div class="panel-body">
					<table class="table table-striped table-bordered table-hover datatable" id="dataTable1">
						<thead>
							<tr>
								<th>ID</th>
								<th>Títol</th>
								<th>Data Creació</th>
								<th>Data Finalització</th>
								<th>Estat</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach( $listTickets1 as $listIn ){
								if( ( $listIn->closedate != null ) && ( $listIn->due_date != null )){
										$timeClose = strtotime($listIn->closedate);
										$fechaClose = date('Y-m-d H:i:s',$timeClose);
										
										$timeDue = strtotime($listIn->due_date);
										$fechaLimite = date('Y-m-d H:i:s',$timeDue);
										
										if( $fechaClose > $fechaLimite ){
											echo"<tr class='danger'>";
											echo"<td><i class='icon-ban-circle' rel='tooltip' title='SLA no cumplido'></i><a style='margin-left:2px' href='".$url.$listIn->id."' title='SLA no cumplido' target='_blank'>".$listIn->id."</a></td>";
										}else{
											echo"<tr>";
											echo"<td><a href='".$url.$listIn->id."' target='_blank'>".$listIn->id."</a></td>";
										}
									}else{
										echo"<tr>";
										echo"<td><a href='".$url.$listIn->id."' target='_blank'>".$listIn->id."</a></td>";
									}
									echo"<td>".$listIn->name."</td>";
									echo"<td>".$listIn->date."</td>";
									echo"<td>".$listIn->closedate."</td>";
									echo"<td>".$this->tickets->getEstadoById($listIn->status)."</td>";
								echo"</tr>";
							}
						?>
						</tbody>
					</table>
					</div>
			</div>
			</div>
			<!--FIN tickets de incidencias -->	

			<div class="row">&nbsp;</div>
			<!--tickets de peticiones -->
				<div class="row">
				<div class="panel panel-info">
				<div class="panel-heading">
					Peticions
				</div>
					<div class="panel-body">
				<table class="table table-striped table-bordered table-hover datatable" id="dataTable2">
					<thead>
						<tr>
							<th>ID</th>
							<th>Títol</th>
							<th>Data Creació</th>
							<th>Data Finalització</th>
							<th>Estat</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach( $listTickets2 as $listPet ){
									if( ( $listPet->closedate != null ) && ( $listPet->due_date != null )){
											
											$timeClose = strtotime($listPet->closedate);
											$fechaClose = date('Y-m-d H:i:s',$timeClose);
											
											$timeDue = strtotime($listPet->due_date);
											$fechaLimite = date('Y-m-d H:i:s',$timeDue);
											
											if( $fechaClose > $fechaLimite ){
												echo"<tr class='danger'>";
												echo"<td><i class='icon-ban-circle' rel='tooltip' title='SLA no cumplido'></i><a style='margin-left:2px' href='".$url.$listPet->id."' title='SLA no cumplido' target='_blank'>".$listPet->id."</a></td>";
											}else{
												echo"<tr>";
												echo"<td><a href='".$url.$listPet->id."' target='_blank'>".$listPet->id."</a></td>";
											}
										}else{
											echo"<tr>";
											echo"<td><a href='".$url.$listPet->id."' target='_blank'>".$listPet->id."</a></td>";
										}
										echo"<td>".$listPet->name."</td>";
										echo"<td>".$listPet->date."</td>";
										echo"<td>".$listPet->closedate."</td>";
										echo"<td>".$this->tickets->getEstadoById($listPet->status)."</td>";
									echo"</tr>";
							}
						?>
						</tbody>
				</table>
			</div>
			</div>
			</div>
			<!--FIN tickets de peticiones -->
			
			<div class="row">&nbsp;</div>
			<!--tickets de Evolutius -->
				<div class="row">
				<div class="panel panel-info">
				<div class="panel-heading">
					Evolutius
				</div>
					<div class="panel-body">
				<table class="table table-striped table-bordered table-hover datatable" id="dataTable2">
					<thead>
						<tr>
							<th>ID</th>
							<th>Títol</th>
							<th>Data Creació</th>
							<th>Data Finalització</th>
							<th>Estat</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach( $listTickets3 as $listEvo ){
								
									if( ( $listEvo->closedate != null ) && ( $listEvo->due_date != null )){
											
											$timeClose = strtotime($listEvo->closedate);
											$fechaClose = date('Y-m-d H:i:s',$timeClose);
											
											$timeDue = strtotime($listEvo->due_date);
											$fechaLimite = date('Y-m-d H:i:s',$timeDue);
											
											if( $fechaClose > $fechaLimite ){
												echo"<tr class='danger'>";
												echo"<td><i class='icon-ban-circle' rel='tooltip' title='SLA no cumplido'></i><a style='margin-left:2px' href='".$url.$listEvo->id."' title='SLA no cumplido' target='_blank'>".$listEvo->id."</a></td>";
											}else{
												echo"<tr>";
												echo"<td><a href='".$url.$listEvo->id."' target='_blank'>".$listEvo->id."</a></td>";
											}
										}else{
											echo"<tr>";
											echo"<td><a href='".$url.$listEvo->id."' target='_blank'>".$listEvo->id."</a></td>";
										}
										echo"<td>".$listEvo->name."</td>";
										echo"<td>".$listEvo->date."</td>";
										echo"<td>".$listEvo->closedate."</td>";
										echo"<td>".$this->tickets->getEstadoById($listEvo->status)."</td>";
									echo"</tr>";
							}
						?>
						</tbody>
						</table>
					</div>
			</div>
			</div>
			<!--FIN tickets de Evolutius -->
			  
			  <div class="row">&nbsp;</div>
			  
			<!--tickets de Canvis -->
				<div class="row">
				<div class="panel panel-info">
				<div class="panel-heading">
					Canvis
				</div>
					<div class="panel-body">
				<table class="table table-striped table-bordered table-hover datatable" id="dataTable2">
					<thead>
						<tr>
							<th>ID</th>
							<th>Títol</th>
							<th>Data Creació</th>
							<th>Data Finalització</th>
							<th>Estat</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach( $listTickets4 as $listCan ){
									if( ( $listCan->closedate != null ) && ( $listCan->due_date != null )){
											
											$timeClose = strtotime($listCan->closedate);
											$fechaClose = date('Y-m-d H:i:s',$timeClose);
											
											$timeDue = strtotime($listCan->due_date);
											$fechaLimite = date('Y-m-d H:i:s',$timeDue);
											
											if( $fechaClose > $fechaLimite ){
												echo"<tr class='danger'>";
												echo"<td><i class='icon-ban-circle' rel='tooltip' title='SLA no cumplido'></i><a style='margin-left:2px' href='".$url.$listCan->id."' title='SLA no cumplido' target='_blank'>".$listCan->id."</a></td>";
											}else{
												echo"<tr>";
												echo"<td><a href='".$url.$listCan->id."' target='_blank'>".$listCan->id."</a></td>";
											}
										}else{
											echo"<tr>";
											echo"<td><a href='".$url.$listCan->id."' target='_blank'>".$listCan->id."</a></td>";
										}
										echo"<td>".$listCan->name."</td>";
										echo"<td>".$listCan->date."</td>";
										echo"<td>".$listCan->closedate."</td>";
										echo"<td>".$this->tickets->getEstadoById($listCan->status)."</td>";
									echo"</tr>";
							}
						?>
						</tbody>
						</table>
					</div>
			</div>
			</div>
			<!--FIN tickets de Canvis -->
			
			 <div class="row">&nbsp;</div>
			
				<!--tickets de consultes -->
				<div class="row">
				<div class="panel panel-info">
				<div class="panel-heading">
					Consultes
				</div>
					<div class="panel-body">
				<table class="table table-striped table-bordered table-hover datatable" id="dataTable2">
					<thead>
						<tr>
							<th>ID</th>
							<th>Títol</th>
							<th>Data Creació</th>
							<th>Data Finalització</th>
							<th>Estat</th>
						</tr>
					</thead>
					<tbody>
						<?php
						
							foreach( $listTickets5 as $listCon ){
									
										//convierto la string a fecha
										if( ( $listCon->closedate != null ) && ( $listCon->due_date != null )){
											
											$timeClose = strtotime($listCon->closedate);
											$fechaClose = date('Y-m-d H:i:s',$timeClose);
											
											$timeDue = strtotime($listCon->due_date);
											$fechaLimite = date('Y-m-d H:i:s',$timeDue);
											
											if( $fechaClose > $fechaLimite ){
												echo"<tr class='danger'>";
												echo"<td><i class='icon-ban-circle' rel='tooltip' title='SLA no cumplido'></i><a style='margin-left:2px' href='".$url.$listCon->id."' title='SLA no cumplido' target='_blank'>".$listCon->id."</a></td>";
											}else{
												echo"<tr>";
												echo"<td><a href='".$url.$listCon->id."' target='_blank'>".$listCon->id."</a></td>";
											}
										}else{
											echo"<tr>";
											echo"<td><a href='".$url.$listCon->id."' target='_blank'>".$listCon->id."</a></td>";
										}
										echo"<td>".$listCon->name."</td>";
										echo"<td>".$listCon->date."</td>";
										echo"<td>".$listCon->closedate."</td>";
										echo"<td>".$this->tickets->getEstadoById($listCon->status)."</td>";
									echo"</tr>";
							}
						?>
						</tbody>
						</table>
					</div>
			</div>
			</div>
			<!--FIN tickets de consultes -->				

