
		<p>Permite la exportación de todos los datos a Excel utilizando el filtro de fechas.PPP</p>
		
		<?php echo form_open('inicio/exportarExcel', array('id'=>'form_excel', 'target' =>'_blank')); ?>
		
			<button id="exportar_excel1" name="exportar_excel1" type="submit" class="btn btn-link">Exportar datos</button>
			<input type="hidden" name="form_ini_fecha" id="form_ini_fecha" value="<?php echo set_value('datepicker1'); ?>" />
			<input type="hidden" name="form_fin_fecha" id="form_fin_fecha" value="<?php echo set_value('datepicker2'); ?>" />
		</form> 
			<div id="datos_export">
				<table id="tableSorter1" class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>ID</th>
							<th>Títol</th>
							<th>Creació</th>
							<th>Finalització</th>
							<th>Estat</th>
							<th>Tipus</th>
							<th>Venciment</th>
							<th>Usuari</th>
							<th>Tècnic</th>
							<th>Categoria</th>
							<th>Urgència</th>
							<th>SLA</th>
							<th>Localització</th>
						</tr>
						</thead>
						<tbody>
					<?php
					foreach( $listTicketsAll as $listAll ){
						$listTicketsUsers = $this->tickets->getTicketsByFechaAllUsers($listAll->id);
						echo"<tr>";
							echo"<td>".$listAll->id."</td>";
							echo"<td>".$listAll->name."</td>";
							echo"<td>".$listAll->date."</td>";
							echo"<td>".$listAll->closedate."</td>";
							echo"<td>".$this->tickets->getEstadoById($listAll->status)."</td>";
							echo"<td>".$this->tickets->getTipoById($listAll->type)."</td>";
							echo"<td>".$listAll->due_date."</td>";
							
							//usuario afectado
							
							if( count($listTicketsUsers) > 1 ){
								foreach( $listTicketsUsers as $listTicketUser){
										if( $listTicketUser->type == 1 ){
											$usu = $this->users->getUsuarioById( $listTicketUser->users_id );
											echo"<td>".$usu->name."</td>";
										}elseif( $listTicketUser->type == 2){
											$usu = $this->users->getUsuarioById( $listTicketUser->users_id );
											echo"<td>".$usu->name."</td>";
										}
								}
							}else{
								foreach( $listTicketsUsers as $listTicketUser){
										if( $listTicketUser->type == 1 ){
											$usu = $this->users->getUsuarioById( $listTicketUser->users_id );
											echo"<td>".$usu->name."</td>";
											echo"<td>&nbsp;</td>";
										}elseif( $listTicketUser->type == 2){
											$usu = $this->users->getUsuarioById( $listTicketUser->users_id );
											echo"<td>&nbsp;</td>";
											echo"<td>".$usu->name."</td>";
										}
								}
							}
							
							//categoria
							$categoria = $this->categorias->getCategoriaById($listAll->itilcategories_id);
							if( $categoria ){
								echo"<td>".$categoria->name."</td>";
							}else{
								echo"<td>&nbsp;</td>";
							}
							
							//urgencia
							$urgencia = $this->tickets->getUrgenciaById($listAll->urgency);
							echo"<td>".$urgencia."</td>";
							
							//sla
							$sla = $this->tickets->getSLAById($listAll->slas_id);
							if( $sla ){
								echo"<td>".$sla->name."</td>";
							}else{
								echo"<td>&nbsp;</td>";
							}
							
							//location
							$location = $this->tickets->getLocationById($listAll->locations_id);
							if( $location ){
								echo"<td>".$location->name."</td>";
							}else{
								echo"<td>&nbsp;</td>";
							}
						
						echo"</tr>";
					}
					
					?>
					</tbody>
				</table>
			</div>
	
	<!-- </div> -->

<!--FIN tab EXCEL -->
