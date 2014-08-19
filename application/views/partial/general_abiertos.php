<script>
	var urlDetallado = '<?php echo site_url('inicio/detallado'); ?>'
</script>  
	<!-- div datos generales -->
		<!--<div class="alert alert-info">
			<p>Tíckets oberts entre les dues dates fixades.</p>
		</div> -->
		
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
								<th width="11%">Incidències <i class="icon-arrow-down"></i></th>
								<th width="11%">Peticions <i class="icon-arrow-down"></i></th>
								<th width="11%">Evolutius <i class="icon-arrow-down"></i></th>
								<th width="11%">Canvis <i class="icon-arrow-down"></i></th>
								<th width="11%">Consultes<i class="icon-arrow-down"></i></th>
							</tr>
						</thead>
						<tbody>
					<?php
				foreach ($categorias as $cat){
					
					$tickets = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 1 , 1, 0 );
					$tickets1 = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 2, 1, 0 );
					$tickets2 = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 3, 1, 0 );
					$tickets3 = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 4, 1, 0 );
					$tickets4 = $this->tickets->getTicketsByCategoria($cat->id, set_value('datepicker1'), set_value('datepicker2'), 5, 1, 0 );
						echo"<tr>";
							//echo"<td>". $cat->name . "</td>";
							echo"<td>". $cat->completename . "</td>";
							
							if( $tickets->total > 0){
								echo"<td grupo='cat' cat='". $cat->id ."' tipo='1' class='cat tdContenidoSorter'>" . $tickets->total . "</td>";
							}else{
								echo"<td>0</td>";
							}
							
							if( $tickets1->total > 0){
								echo"<td grupo='cat' cat=". $cat->id ." tipo='2' class='cat tdContenidoSorter'>" . $tickets1->total . "</td>";
							}else{
								echo"<td>0</td>";
							}
							
							if( $tickets2->total > 0){
								echo"<td grupo='cat' cat=". $cat->id ." tipo='3' class='cat tdContenidoSorter'>" . $tickets2->total . "</td>";
							}else{
								echo"<td>0</td>";
							}
							
							if( $tickets3->total > 0){
								echo"<td grupo='cat' cat=". $cat->id ." tipo='4' class='cat tdContenidoSorter'>" . $tickets3->total . "</td>";
							}else{
								echo"<td>0</td>";
							}
							if( $tickets4->total > 0){
								echo"<td grupo='cat' cat=". $cat->id ." tipo='5' class='cat tdContenidoSorter'>" . $tickets4->total . "</td>";
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
						
						$tickets = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 1, 1 );
						$tickets1 = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 2, 1 );
						$tickets2 = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 3, 1 );
						$tickets3 = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 4, 1 );
						$tickets4 = $this->tickets->getTicketsByGroup($demarcacion->id, set_value('datepicker1'), set_value('datepicker2'), 5, 1 );
							echo"<tr>";
								echo"<td>". $demarcacion->name . "</td>";
								
								if( count($tickets) > 0){
								
									foreach ($tickets as $ticket){
										echo"<td grupo='dem' cat=". $demarcacion->id ." tipo='1' class='cat tdContenidoSorter'>" . $ticket->total . "</td>";
									}
								}else{
									echo"<td>0</td>";
								}
								
								if( count($tickets1) > 0){
								
									foreach ($tickets1 as $ticket1){
										echo"<td grupo='dem' cat=". $demarcacion->id ." tipo='2' class='cat tdContenidoSorter'>" . $ticket1->total . "</td>";
									}
								}else{
									echo"<td>0</td>";
								}
								
								if( count($tickets2) > 0){
								
									foreach ($tickets2 as $ticket2){
										echo"<td grupo='dem' cat=". $demarcacion->id ." tipo='3' class='cat tdContenidoSorter'>" . $ticket2->total . "</td>";
									}
								}else{
									echo"<td>0</td>";
								}
								
								if( count($tickets3) > 0){
								
									foreach ($tickets3 as $ticket3){
										echo"<td grupo='dem' cat=". $demarcacion->id ." tipo='4' class='cat tdContenidoSorter'>" . $ticket3->total . "</td>";
									}
								}else{
									echo"<td>0</td>";
								}
								if( count($tickets4) > 0){
								
									foreach ($tickets4 as $ticket4){
										echo"<td grupo='dem' cat=". $demarcacion->id ." tipo='5' class='cat tdContenidoSorter'>" . $ticket4->total . "</td>";
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
					
					$tickets = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 1 );
					$tickets1 = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 2 );
					$tickets2 = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 3 );
					$tickets3 = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 4 );
					$tickets4 = $this->tickets->getTicketsByTecnico($user->id, set_value('datepicker1'), set_value('datepicker2'), 5 );
						echo"<tr>";
							echo"<td>". $user->name . "</td>";
							
							if( count($tickets) > 0){
							
								foreach ($tickets as $ticket){
									echo"<td grupo='user' cat=". $user->id ." tipo='1' class='cat tdContenidoSorter'>" . $ticket->total . "</td>";
								}
							}else{
								echo"<td>0</td>";
							}
							
							if( count($tickets1) > 0){
							
								foreach ($tickets1 as $ticket1){
									echo"<td grupo='user' cat=". $user->id ." tipo='2' class='cat tdContenidoSorter'>" . $ticket1->total . "</td>";
								}
							}else{
								echo"<td>0</td>";
							}
							
							if( count($tickets2) > 0){
							
								foreach ($tickets2 as $ticket2){
									echo"<td grupo='user' cat=". $user->id ." tipo='3' class='cat tdContenidoSorter'>" . $ticket2->total . "</td>";
								}
							}else{
								echo"<td>0</td>";
							}
							
							if( count($tickets3) > 0){
							
								foreach ($tickets3 as $ticket3){
									echo"<td grupo='user' cat=". $user->id ." tipo='4' class='cat tdContenidoSorter'>" . $ticket3->total . "</td>";
								}
							}else{
								echo"<td>0</td>";
							}
							
							if( count($tickets4) > 0){
							
								foreach ($tickets4 as $ticket4){
									echo"<td grupo='user' cat=". $user->id ." tipo='5' class='cat tdContenidoSorter'>" . $ticket4->total . "</td>";
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
			$ticketsIn = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 1 );
			$ticketsPet = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 2 );
			$ticketsEv = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 3 );
			$ticketsCa = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 4 );
			$ticketsCon = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), 5 );
			
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
