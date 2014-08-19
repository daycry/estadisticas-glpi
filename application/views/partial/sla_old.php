  
  

		<div class="alert alert-info">
			<p>Informació sobre els tickets oberts entre les dates fixades que no han complert amb el SLA.</p>
		</div>
		<div class="row-fluid">
			<!--tickets de incidencias -->
				<div class="divBorder" identi="listadoInSLA"><h3>Llistat d'Incidèncias amb SLA vençut</h3><button identi="listadoInSLA" type="button" class="btn btn-primary btn-xs">Muestra Listado</button>
					<div class="listado" id="listadoInSLA">
						
						<?php
						if( count($listTickets1SLAC) > 0 ){
						?>
							<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>ID</th>
									<th>Títol</th>
									<th>Data Creació</th>
									<th>Data Finalització</th>
									<th>Estat</th>
									<th>Venciment</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach( $listTickets1SLAC as $listInSLA ){
									echo"<tr>";
										echo"<td><a href='".$url.$listInSLA->id."' target='_blank'>".$listInSLA->id."</a></td>";
										echo"<td>".$listInSLA->name."</td>";
										echo"<td>".$listInSLA->date."</td>";
										echo"<td>".$listInSLA->closedate."</td>";
										echo"<td>".$this->tickets->getEstadoById($listInSLA->status)."</td>";
										echo"<td>".$listInSLA->due_date."</td>";
									echo"</tr>";
							}//end forach
							?>
							</tbody>
						</table>
						<?php
						}else{
						?>
						<div class="row-fluid">
							<div class="span4 alert alert-danger">
								<p>AVÍS! No hi ha dades</p>
							</div>
						</div>
						<?php
						}
						?>
					</div>
				</div>
			<!--FIN tickets de incidencias -->	

			
			<!--tickets de peticiones -->
				<div class="divBorder" identi="listadoPetSLA"><h3>Llistat de Peticions amb SLA vençut</h3><button identi="listadoPetSLA" type="button" class="btn btn-primary btn-xs">Muestra Listado</button>
					<div class="listado" id="listadoPetSLA">
						
						<?php
							if( count($listTickets2SLAC) > 0 ){
						?>
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th>ID</th>
											<th>Títol</th>
											<th>Data Creació</th>
											<th>Data Finalització</th>
											<th>Estat</th>
											<th>Venciment</th>
										</tr>
									</thead>
									<tbody>
								<?php
								foreach( $listTickets2SLAC as $listPetSLA ){
										echo"<tr>";
											echo"<td><a href='".$url.$listPetSLA->id."' target='_blank'>".$listPetSLA->id."</a></td>";
											echo"<td>".$listPetSLA->name."</td>";
											echo"<td>".$listPetSLA->date."</td>";
											echo"<td>".$listPetSLA->closedate."</td>";
											echo"<td>".$this->tickets->getEstadoById($listPetSLA->status)."</td>";
											echo"<td>".$listPetSLA->due_date."</td>";
										echo"</tr>";
								}//end foreach
								?>
									</tbody>
							</table>
							<?php
							}else{
								?>
								<div class="row-fluid">
									<div class="span4 alert alert-danger">
										<p>AVÍS! No hi ha dades</p>
									</div>
								</div>
								<?php
							}
						?>
						
					</div>
				</div>
			<!--FIN tickets de peticiones -->
			  
			<!--tickets de Evolutius -->
				<div class="divBorder" identi="listadoEvSLA"><h3>Llistat de Evolutius amb SLA vençut</h3><button identi="listadoEvSLA" type="button" class="btn btn-primary btn-xs">Muestra Listado</button>
					<div class="listado" id="listadoEvSLA">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>ID</th>
									<th>Títol</th>
									<th>Data Creació</th>
									<th>Data Finalització</th>
									<th>Estat</th>
									<th>Venciment</th>
								</tr>
							</thead>
							<tbody>
						<?php
							foreach( $listTickets3SLAC as $listEvoSLA ){
									echo"<tr>";
										echo"<td><a href='".$url.$listEvoSLA->id."' target='_blank'>".$listEvoSLA->id."</a></td>";
										echo"<td>".$listEvoSLA->name."</td>";
										echo"<td>".$listEvoSLA->date."</td>";
										echo"<td>".$listEvoSLA->closedate."</td>";
										echo"<td>".$this->tickets->getEstadoById($listEvoSLA->status)."</td>";
										echo"<td>".$listEvoSLA->due_date."</td>";
									echo"</tr>";
							}
						?>
						</tbody>
						</table>
					</div>
				</div>
			<!--FIN tickets de Evolutius -->
			  
			<!--tickets de Canvis -->
				<div class="divBorder" identi="listadoCanSLA"><h3>Llistat de Canvis amb SLA vençut</h3><button identi="listadoCanSLA" type="button" class="btn btn-primary btn-xs">Muestra Listado</button>
					<div class="listado" id="listadoCanSLA">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>ID</th>
									<th>Títol</th>
									<th>Data Creació</th>
									<th>Data Finalització</th>
									<th>Estat</th>
									<th>Venciment</th>
								</tr>
							</thead>
							<tbody>
						<?php
						//print_r($listTicketsIn);
							foreach( $listTickets4SLAC as $listCanSLA ){
									echo"<tr>";
										echo"<td><a href='".$url.$listCanSLA->id."' target='_blank'>".$listCanSLA->id."</a></td>";
										echo"<td>".$listCanSLA->name."</td>";
										echo"<td>".$listCanSLA->date."</td>";
										echo"<td>".$listCanSLA->closedate."</td>";
										echo"<td>".$this->tickets->getEstadoById($listCanSLA->status)."</td>";
										echo"<td>".$listCanSLA->due_date."</td>";
									echo"</tr>";
							}
						?>
						</tbody>
						</table>
					</div>
				</div>
			<!--FIN tickets de Canvis -->
			
			
			
			<!--tickets de consultes -->
				<div class="divBorder" identi="listadoInSLA"><h3>Llistat de Consultes amb SLA vençut</h3><button identi="listadoConSLA" type="button" class="btn btn-primary btn-xs">Muestra Listado</button>
					<div class="listado" id="listadoConSLA">
						
						<?php
						if( count($listTickets5SLAC) > 0 ){
						?>
							<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>ID</th>
									<th>Títol</th>
									<th>Data Creació</th>
									<th>Data Finalització</th>
									<th>Estat</th>
									<th>Venciment</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach( $listTickets5SLAC as $listConSLA ){
									echo"<tr>";
										echo"<td><a href='".$url.$listConSLA->id."' target='_blank'>".$listConSLA->id."</a></td>";
										echo"<td>".$listConSLA->name."</td>";
										echo"<td>".$listConSLA->date."</td>";
										echo"<td>".$listConSLA->closedate."</td>";
										echo"<td>".$this->tickets->getEstadoById($listConSLA->status)."</td>";
										echo"<td>".$listConSLA->due_date."</td>";
									echo"</tr>";
							}//end forach
							?>
							</tbody>
						</table>
						<?php
						}else{
						?>
						<div class="row-fluid">
							<div class="span4 alert alert-danger">
								<p>AVÍS! No hi ha dades</p>
							</div>
						</div>
						<?php
						}
						?>
					</div>
				</div>
			<!--FIN tickets de consultes -->
			
	</div>
