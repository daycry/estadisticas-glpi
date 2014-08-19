<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class automata extends CI_Controller {

	public function index2()
	{
		
		$this->load->helper('file');
		
		$datos['titulo'] = "MIS ESTADÍSTICAS";
		$fechaActual = date("Y/m/d");
		$nombrelog = "log-".date("Y-m-d").".php";
		$datos['fecha'] = $fechaActual;
		
		//borra el fichero si existe
		if ( read_file(APPPATH."logs/".$nombrelog, $data) ){
			unlink(APPPATH."logs/".$nombrelog);
		}
		
		$tickets = $this->tickets->getTicketsDiario ( $fechaActual );
		$countTickets = array();
		
		if( count($tickets) > 0 ){
			$datos['tickets'] = $tickets;
			
			$existe = 0;
			foreach($tickets as $ticket){
				
				if( $ticket->groups_id != null ){	
					$data = array();
					$data = array(
						'tickets_id' => $ticket->id,
						'groups_id' => $ticket->groups_id,
						'type' => 1
					);
					//comprueba que no esté insertado
					$existeRegistro = $this->tickets->selectGroupTicket( $ticket->id , $ticket->groups_id);
					
					//inserción del grupo en la base de datos
					if( $existeRegistro  == 0 ){
						//contador de tickets
						$countTickets[$ticket->id] = $ticket->id;
				
						$result = $this->tickets->insertGroupTicket( $data );
						log_message('info', 'AUTOMATA - Se ha modificado el grupo '. $ticket->groups_id .' para el ticket '. $ticket->id);
					}else{
						log_message('info', 'AUTOMATA - Registro duplicado : '. $ticket->id. ' ya tiene el grupo asignado');
					}
				}
					unset($data);		
			}
			
			$this->asignaSLA( $fechaActual );
			
		}else{
			$datos['tickets'] = "No se han generado tickets";
			log_message('info', 'AUTOMATA - No se han generado tickets. Total de tickets : '. count($countTickets));
		}
		$datos['contador'] = count($countTickets);
		log_message('info', 'AUTOMATA - Se han modificado ' . count($countTickets) . ' tickets a nivel de grupos');
		
		//load our new PHPmailer library
		$this->load->library('my_phpmailer');

		$this->my_phpmailer->IsSMTP(); // establecemos que utilizaremos SMTP
        $this->my_phpmailer->SMTPAuth   = true; // habilitamos la autenticación SMTP
        $this->my_phpmailer->Host       = "smtp.domain.com";      // establecemos GMail como nuestro servidor SMTP
        $this->my_phpmailer->Port       = 25;                   // establecemos el puerto SMTP en el servidor de GMail
        $this->my_phpmailer->Username   = "user";  // la cuenta que envia email
        $this->my_phpmailer->Password   = "pass";            // password dela cuenta
        $this->my_phpmailer->SetFrom('apli@coac.net', 'Automata Mis Estadisticas');  //Quien envía el correo
        $this->my_phpmailer->Subject    = "Automata Mis Estadisticas";  //Asunto del mensaje
        $this->my_phpmailer->Body      = "Se ha ejecutado correctamente<br />Revisa el log para mas informaci&oacute;n";
        $this->my_phpmailer->AltBody    = "Se ha ejecutado correctamente<br />Revisa el log para mas informaci&oacute;n";
        $this->my_phpmailer->AddAddress("email@gmail.com", "user1");
        $this->my_phpmailer->AddCC('email@gmail.net', 'user2');
        $this->my_phpmailer->AddAttachment(APPPATH."logs/".$nombrelog);   // añadimos archivos adjuntos si es necesario
		
		if(!$this->my_phpmailer->Send()) {
            log_message('info', "AUTOMATA - Error en el envío: " . $this->my_phpmailer->ErrorInfo);
        } else {
            log_message('info', "AUTOMATA - ¡Mensaje enviado correctamente!");
        }
        
		$this->load->view('automata/index2', $datos);
	}
		
	public function index()
	{
		$this->load->view('automata/index', $datos);
	}
	
	private function asignaSLA( $fechaActual )
	{
		$tickets = $this->tickets->getTicketsDiario ( $fechaActual );
		if(count($tickets) > 0){
			echo "Tickets : " .count($tickets);
			echo "<br>";
			$actualizados = array();
			foreach($tickets as $ticket){
				$data = array();
				if( $ticket->slas_id == 0 ){
					$data = array(
						'slas_id' => 3,
						'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +2 day"))
					);
					$this->tickets->setTicketSla($data, $ticket->id);
					$actualizados[$ticket->id] = array('id'=>$ticket->id);
					log_message('info', "AUTOMATA - SLA modificado para el ticket : ". $ticket->id);
				}else{
					//comparamos la urgencia Molt Alta
					if( ($ticket->priority == 5) && ($ticket->slas_id !=1 ) ){
						$data = array(
							'slas_id' => 1,
							'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +4 hour"))
						);
						$this->tickets->setTicketSla($data, $ticket->id);
						$actualizados[$ticket->id] = array('id'=>$ticket->id);
						log_message('info', "AUTOMATA - SLA modificado para el ticket : ". $ticket->id);	
					}elseif( ($ticket->priority == 4) && ($ticket->slas_id !=2 ) ){
						$data = array(
							'slas_id' => 2,
							'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +1 day"))
						);
						$this->tickets->setTicketSla($data, $ticket->id);
						$actualizados[$ticket->id] = array('id'=>$ticket->id);
						log_message('info', "AUTOMATA - SLA modificado para el ticket : ". $ticket->id);
					}elseif( ($ticket->priority == 3) && ($ticket->slas_id !=3 ) ){
						$data = array(
							'slas_id' => 3,
							'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +2 day"))
						);
						
						$this->tickets->setTicketSla($data, $ticket->id);
						$actualizados[$ticket->id] = array('id'=>$ticket->id);
						log_message('info', "AUTOMATA - SLA modificado para el ticket : ". $ticket->id);
					}elseif( ($ticket->priority == 2) && ($ticket->slas_id !=4 ) ){
						$data = array(
							'slas_id' => 4,
							'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +4 day"))
						);
						$this->tickets->setTicketSla($data, $ticket->id);
						$actualizados[$ticket->id] = array('id'=>$ticket->id);
						log_message('info', "AUTOMATA - SLA modificado para el ticket : ". $ticket->id);
					}
				}
			}
			log_message('info', "AUTOMATA - Total de SLA's modificados : ". count($actualizados));
		}
	}
	
	
	public function buscar(){
		
		$datos['titulo'] = "MIS ESTADÍSTICAS";
		
		$fechaInicial = $this->input->post('datepicker1');

		$this->form_validation->set_rules('datepicker1', 'Fecha Inicial', 'required');
		$this->form_validation->set_message('required','El camp %s es obligatori');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('automata/index', $datos);
		}
		else
		{
			$datos['titulo'] = "MIS ESTADÍSTICAS";
			$fechaActual = $fechaInicial;
			$datos['fecha'] = $fechaActual;
			$tickets = $this->tickets->getTicketsDiario ( $fechaActual );
			$countTickets = array();
			if( count($tickets) > 0 ){
				$datos['tickets'] = $tickets;
				$existe = 0;
				foreach($tickets as $ticket){
						if( $ticket->groups_id == null ){
							continue;
						}
						$data = array(
							'tickets_id' => $ticket->id,
							'groups_id' => $ticket->groups_id,
							'type' => 1
						);
						//comprueba que no esté insertado
						$existeRegistro = $this->tickets->selectGroupTicket( $ticket->id , $ticket->groups_id);
						
						//inserción del grupo en la base de datos
						if( $existeRegistro  == 0 ){
							//contador de tickets
							$countTickets[$ticket->id] = $ticket->id;
							
							$result = $this->tickets->insertGroupTicket( $data );
						}else{
							log_message('info', 'MANUAL - Registro duplicado : '. $ticket->id);
						}
						unset($data);
				}
			}else{
				$datos['tickets'] = "No se han generado tickets";
				log_message('info', 'MANUAL - No se han generado tickets. Total de tickets : '. count($countTickets));
			}
			$datos['contador'] = count($countTickets);
			log_message('info', 'MANUAL - Se han modificado ' . count($countTickets) . ' tickets');
			$this->load->view('automata/index', $datos);
		}
		
	}
	
	public function asignaSLAall()
	{
		$tickets = $this->tickets->getAllTickets();
		if(count($tickets) > 0){
			echo "Tickets : " .count($tickets);
			echo "<br>";
			$actualizados = array();
			foreach($tickets as $ticket){
				$data = array();
				if( $ticket->slas_id == 0 ){
					$data = array(
						'slas_id' => 3,
						'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +2 day"))
					);
					$this->tickets->setTicketSla($data, $ticket->id);
					$actualizados[] = array('id'=>$ticket->id);
					log_message('info', "asignaSLAall - SLA modificado para el ticket : ". $ticket->id);
				}else{
					//comparamos la urgencia Molt Alta
					if( ($ticket->priority == 5) && ($ticket->slas_id !=1 ) ){
						$data = array(
							'slas_id' => 1,
							'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +4 hour"))
						);
						$this->tickets->setTicketSla($data, $ticket->id);
						$actualizados[] = array('id'=>$ticket->id);
						log_message('info', "asignaSLAall - SLA modificado para el ticket : ". $ticket->id);	
					}elseif( ($ticket->priority == 4) && ($ticket->slas_id !=2 ) ){
						$data = array(
							'slas_id' => 2,
							'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +1 day"))
						);
						$this->tickets->setTicketSla($data, $ticket->id);
						$actualizados[] = array('id'=>$ticket->id);
						log_message('info', "asignaSLAall - SLA modificado para el ticket : ". $ticket->id);
					}elseif( ($ticket->priority == 3) && ($ticket->slas_id !=3 ) ){
						$data = array(
							'slas_id' => 3,
							'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +2 day"))
						);
						
						$this->tickets->setTicketSla($data, $ticket->id);
						$actualizados[] = array('id'=>$ticket->id);
						log_message('info', "asignaSLAall - SLA modificado para el ticket : ". $ticket->id);
					}elseif( ($ticket->priority == 2) && ($ticket->slas_id !=4 ) ){
						$data = array(
							'slas_id' => 4,
							'due_date' => date("Y-m-d H:i:s", strtotime($ticket->date." +4 day"))
						);
						$this->tickets->setTicketSla($data, $ticket->id);
						$actualizados[] = array('id'=>$ticket->id);
						log_message('info', "asignaSLAall - SLA modificado para el ticket : ". $ticket->id);
					}
				}
			}
			log_message('info', "asignaSLAall - Total de SLA's modificados : ". count($actualizados));
		}
	}
	
}

