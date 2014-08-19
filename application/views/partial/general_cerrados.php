<!-- div datos generales -->
		<!--<div class="alert alert-info">
			<p>Tíckets tancats entre les dues dates fixades.</p>
		</div>-->
		<div class="row">
			<div class="col-md-6">	
					<?php
					if(isset($categorias)){
					?>	
					<h3>CATEGORIES</h3>
					<table id="tableSorter1" class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Categoria <i class="icon-arrow-down"></i></th>
									<th width="11%">Incidències</th>
									<th width="11%">Peticions</th>
									<th width="11%">Evolutius</th>
									<th width="11%">Canvis</th>
									<th width="11%">Consultes></th>
								</tr>
							</thead>
							<tbody>
						<?php
					foreach ($categorias as $cat){
						
						$tickets = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 1, 0, 0 );
						$tickets1 = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 2, 0 ,0 );
						$tickets2 = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 3, 0 ,0 );
						$tickets3 = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 4, 0 ,0 );
						$tickets4 = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 5, 0 ,0 );
							echo"<tr>";
								//echo"<td>". $cat->name . "</td>";
								echo"<td>". $cat->completename . "</td>";
								
								if( $tickets->total > 0){
									echo"<td class='tdContenidoSorter'>" . $tickets->total . "</td>";
								}else{
									echo"<td>0</td>";
								}
								
								if( $tickets1->total > 0){
									echo"<td class='tdContenidoSorter'>" . $tickets1->total . "</td>";
								}else{
									echo"<td>0</td>";
								}
								
								if( $tickets2->total > 0){
									echo"<td class='tdContenidoSorter'>" . $tickets2->total . "</td>";
								}else{
									echo"<td>0</td>";
								}
								
								if( $tickets3->total > 0){
									echo"<td class='tdContenidoSorter'>" . $tickets3->total . "</td>";
								}else{
									echo"<td>0</td>";
								}
								if( $tickets4->total > 0){
									echo"<td class='tdContenidoSorter'>" . $tickets4->total . "</td>";
								}else{
									echo"<td>0</td>";
								}
								
							echo"</tr>";
						unset($tickets);
						unset($tickets1);
						unset($tickets2);
						unset($tickets3);
						unset($tickets4);
					}
					echo"</tbody>";
					echo"</table>";
				}
			
			
			?>
		
		
			</div>
		<div class="col-md-6">
					<?php
					if(isset($demarcaciones)){
					?>	
					<h3>DEMARCACIONS</h3>
					<table id="tableSorter1" class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Demarcació <i class="icon-arrow-down"></i></th>
									<th>Incidències <i class="icon-arrow-down"></i></th>
									<th>Peticions <i class="icon-arrow-down"></i></th>
									<th>Evolutius <i class="icon-arrow-down"></i></th>
									<th>Canvis <i class="icon-arrow-down"></i></th>
									<th>Consultes <i class="icon-arrow-down"></i></th>
								</tr>
							</thead>
							<tbody>
						<?php
					foreach ($demarcaciones as $demarcacion){
						
						$tickets = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 1, 0, 0);
						$tickets1 = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 2, 0, 0 );
						$tickets2 = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 3, 0, 0 );
						$tickets3 = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 4, 0, 0 );
						$tickets4 = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 5, 0, 0 );
							echo"<tr>";
								echo"<td>". $demarcacion->name . "</td>";
								
								if( count($tickets) > 0){
								
									foreach ($tickets as $ticket){
										echo"<td class='tdContenidoSorter'>" . $ticket->total . "</td>";
									}
								}else{
									echo"<td>0</td>";
								}
								
								if( count($tickets1) > 0){
								
									foreach ($tickets1 as $ticket1){
										echo"<td class='tdContenidoSorter'>" . $ticket1->total . "</td>";
									}
								}else{
									echo"<td>0</td>";
								}
								
								if( count($tickets2) > 0){
								
									foreach ($tickets2 as $ticket2){
										echo"<td class='tdContenidoSorter'>" . $ticket2->total . "</td>";
									}
								}else{
									echo"<td>0</td>";
								}
								
								if( count($tickets3) > 0){
								
									foreach ($tickets3 as $ticket3){
										echo"<td class='tdContenidoSorter'>" . $ticket3->total . "</td>";
									}
								}else{
									echo"<td>0</td>";
								}
								if( count($tickets4) > 0){
								
									foreach ($tickets4 as $ticket4){
										echo"<td class='tdContenidoSorter'>" . $ticket4->total . "</td>";
									}
								}else{
									echo"<td>0</td>";
								}
								
							echo"</tr>";
						unset($tickets);
						unset($tickets1);
						unset($tickets2);
						unset($tickets3);
						unset($tickets4);
					}
					echo"</tbody>";
					echo"</table>";
				}

		if( isset($users)){
			?>
			<h3>TÈCNICS</h3>
			<table id="tableSorter1" class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>Nom <i class="icon-arrow-down"></i></th>
						<th>Incidències <i class="icon-arrow-down"></i></th>
						<th>Peticions <i class="icon-arrow-down"></i></th>
						<th>Evolutius <i class="icon-arrow-down"></i></th>
						<th>Canvis <i class="icon-arrow-down"></i></th>
						<th>Consultes <i class="icon-arrow-down"></i></th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($users as $user){
					
					$tickets = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 1, 0 );
					$tickets1 = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 2, 0 );
					$tickets2 = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 3, 0 );
					$tickets3 = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 4, 0 );
					$tickets4 = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 5, 0 );
						echo"<tr>";
							echo"<td>". $user->name . "</td>";
							
							if( count($tickets) > 0){
							
								foreach ($tickets as $ticket){
									echo"<td class='tdContenidoSorter'>" . $ticket->total . "</td>";
								}
							}else{
								echo"<td>0</td>";
							}
							
							if( count($tickets1) > 0){
							
								foreach ($tickets1 as $ticket1){
									echo"<td class='tdContenidoSorter'>" . $ticket1->total . "</td>";
								}
							}else{
								echo"<td>0</td>";
							}
							
							if( count($tickets2) > 0){
							
								foreach ($tickets2 as $ticket2){
									echo"<td class='tdContenidoSorter'>" . $ticket2->total . "</td>";
								}
							}else{
								echo"<td>0</td>";
							}
							
							if( count($tickets3) > 0){
							
								foreach ($tickets3 as $ticket3){
									echo"<td class='tdContenidoSorter'>" . $ticket3->total . "</td>";
								}
							}else{
								echo"<td>0</td>";
							}
							
							if( count($tickets4) > 0){
							
								foreach ($tickets4 as $ticket4){
									echo"<td class='tdContenidoSorter'>" . $ticket4->total . "</td>";
								}
							}else{
								echo"<td>0</td>";
							}
							
						echo"</tr>";
					unset($tickets);
					unset($tickets1);
					unset($tickets2);
					unset($tickets3);
					unset($tickets4);
				}
				echo"</tbody>";
				echo"</table>";
			?>
		
		
		
			<h3>TOTAL</h3>
			
			<?php
			$ticketsIn = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 1, 0 );
			$ticketsPet = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 2, 0 );
			$ticketsEv = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 3, 0 );
			$ticketsCa = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 4, 0 );
			$ticketsCon = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 5, 0 );
			
			?>
			
			<table id="tableSorter1" class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>T. Incidències</th>
						<th>T. Peticions</th>
						<th>T. Evolutius</th>
						<th>T. Canvis</th>
						<th>T. Consultes</th>
					</tr>
				</thead>
				<tbody>
				<?php
					echo"<tr>";
						if(isset($ticketsIn->total) > 0){
							echo"<td class='tdContenidoSorter'>". $ticketsIn->total . "</td>";
						}else{
							echo"<td>0</td>";
						}
						if(isset($ticketsPet->total)){
							echo"<td class='tdContenidoSorter'>". $ticketsPet->total . "</td>";
						}else{
							echo"<td>0</td>";
						}
						if(isset($ticketsEv->total)){
							echo"<td class='tdContenidoSorter'>". $ticketsEv->total . "</td>";
						}else{
							echo"<td>0</td>";
						}
						if(isset($ticketsCa->total)){
							echo"<td class='tdContenidoSorter'>". $ticketsCa->total . "</td>";
						}else{
							echo"<td>0</td>";
						}
						if(isset($ticketsCon->total)){
							echo"<td class='tdContenidoSorter'>". $ticketsCon->total . "</td>";
						}else{
							echo"<td>0</td>";
						}
					echo"</tr>";
			echo"</table>";
		
		
		}	
		
		?>
	</div>

</div>
