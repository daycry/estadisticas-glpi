<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function __construct(){
		
		parent::__construct();
        $this->load->library('graficas');
    }


	public function index()
	{
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$datos['username'] = $session_data['username'];
			$datos['titulo'] = "ESTADÍSTIQUES";
			$this->load->view('inicio/index', $datos);
		}else{
			$this->load->view('ldap/login');
		}
		
	}
	
	public function buscar(){
		
		if($this->session->userdata('logged_in')){
		
			$session_data = $this->session->userdata('logged_in');
			$datos['username'] = $session_data['username'];
			$datos['titulo'] = "ESTADÍSTIQUES";
			$datos['url'] = $this->config->item('url_glpi');
			$fechaInicial = $this->input->post('datepicker1');
			$fechaFinal = $this->input->post('datepicker2');
			$this->form_validation->set_rules('datepicker1', 'Fecha Inicial', 'required|xss_clean');
			$this->form_validation->set_rules('datepicker2', 'Fecha Final', 'required|xss_clean|callback_compruebaFechas');
			$this->form_validation->set_message('required','El camp %s es obligatori');
			$this->form_validation->set_message('required','El camp %s es obligatori');
				
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('inicio/index', $datos);
			}
			else
			{
				/*$fechaInicial1 = date("Y/m/d", strtotime($fechaInicial));
				$fechaFinal1 = date("Y/m/d", strtotime($fechaFinal));*/
				
				$datos['grupos'] = $this->groups->getAll(1);
				$datos['demarcaciones'] = $this->groups->getAll(0);
				$datos['categorias'] = $this->categorias->getCategorias();
				$datos['users'] = $this->users->getTecnicos();
				/*recoge los tipos de tiquests*/
				$tiposTickets = $this->tickets->getTiposTicket();
				
				$totalSum = 0;
				
				foreach( $tiposTickets as $tipoTicket => $value){
					//datos detallados de los tickets abiertos
					$datos['listTickets'.$tipoTicket] = $this->tickets->getTicketsByFecha($fechaInicial, $fechaFinal, $tipoTicket);
					$datos['listTickets'.$tipoTicket.'C'] = $this->tickets->getTicketsByFecha($fechaInicial, $fechaFinal, $tipoTicket, 0);
					$datos['listTickets'.$tipoTicket.'SLA'] = $this->tickets->getTicketsByFechaSLA($fechaInicial, $fechaFinal, $tipoTicket);
					$datos['listTickets'.$tipoTicket.'SLAC'] = $this->tickets->getTicketsByFechaSLA($fechaInicial, $fechaFinal, $tipoTicket, 0);
					
					//calculo total tickets abiertos
					$datos['tickets'.$tipoTicket] = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), $tipoTicket );
					$totalSum = $totalSum + $datos['tickets'.$tipoTicket]->total;
					
					//calculo total tickets cerrados
					$datos['tickets'.$tipoTicket.'C'] = $this->tickets->getTicketsTotales(set_value('datepicker1'), set_value('datepicker2'), $tipoTicket, 0 );
					$totalSumTancats = $totalSumTancats + $datos['tickets'.$tipoTicket.'C']->total;
				}
				
				$porcentaje =array();
				$arrayTotal = array();
				$arrayColumnCStack = array();
				$arrayColumnCStackSLA = array();
				$columNomTipus = array();
				$prior1 = 0;
				$prior2 = 0;
				$prior3 = 0;
				$prior4 = 0;
				$prior1SLA = 0;
				$prior2SLA = 0;
				$prior3SLA = 0;
				$prior4SLA = 0;
				foreach( $tiposTickets as $tipoTicket => $value){
					//porcetaje de tickets SLA por tipo: Inci, Pet,...
					$valor = ($datos['tickets'.$tipoTicket]->total * 100) / $totalSum;
					$valorTancats = ($datos['tickets'.$tipoTicket.'C']->total * 100) / $totalSumTancats;
					
					//porcetaje de tickets SLA por tipo abiertos
					if( $datos['tickets'.$tipoTicket]->total > 0 ){
						$valorSLA= (count($datos['listTickets'.$tipoTicket.'SLA']) * 100) / $datos['tickets'.$tipoTicket]->total;
						$valorSLAok = 100 - $valorSLA;
					}else{
						$valorSLA = 0;
						$valorSLAok = 0;
					}
					
					//porcetaje de tickets SLA por tipo cerrados
					if( $datos['tickets'.$tipoTicket.'C']->total > 0 ){
						$valorSLAC= (count($datos['listTickets'.$tipoTicket.'SLAC']) * 100) / $datos['tickets'.$tipoTicket.'C']->total;
						$valorSLAokC = 100 - $valorSLA;
					}else{
						$valorSLAC = 0;
						$valorSLAokC = 0;
					}
					$porcentaje[$tipoTicket] = array('SLA' => $valorSLA, 'SLAok' => $valorSLAok);
					$porcentaje[$tipoTicket.'C'] = array('SLA' => $valorSLAC, 'SLAok' => $valorSLAokC);
					
					
					/*****************************************************************************************************************
					calculos para las graficas Tickets Abiertos
					****************************************************************************************************************/
					$arrayTotalPie[] = array($value, $valor);
					$arrayTotalPieC[] = array($value, $valorTancats);
					$arrayTotalColumn[] = array('name' => $value, 'data' => array(count($datos['listTickets'.$tipoTicket])));
					$arrayTotalColumnC[] = array('name' => $value, 'data' => array(count($datos['listTickets'.$tipoTicket.'C'])));
					
					//tipo de grafica stacked
					$slaOk = (int)$datos['tickets'.$tipoTicket.'C']->total - count($datos['listTickets'.$tipoTicket.'SLAC']);
					
					//para el eje de graficos de columnas
					array_push($columNomTipus, $value);
					array_push($arrayColumnCStack, $slaOk);
					array_push($arrayColumnCStackSLA, count($datos['listTickets'.$tipoTicket.'SLAC']));
					
					//rellenamos los datos para los tipos Incidencia por SLA
					if( $tipoTicket == 1){
						
						foreach( $datos['listTickets'.$tipoTicket.'C'] as $list){
							if( $list->priority == 1 ){
								$prior1 = $prior1 + 1;
							}elseif( $list->priority == 2 ){
								$prior2 = $prior2 + 1;
							}elseif( $list->priority == 3 ){
								$prior3 = $prior3 + 1;
							}elseif( $list->priority == 4 ){
								$prior4 = $prior4 + 1;
							}
						}
						foreach( $datos['listTickets'.$tipoTicket.'SLAC'] as $list1){
							if( $list1->priority == 5 ){
								$prior5SLA = $prior5SLA + 1;
							}elseif( $list1->priority == 4 ){
								$prior4SLA = $prior4SLA + 1;
							}elseif( $list1->priority == 3 ){
								$prior3SLA = $prior3SLA + 1;
							}elseif( $list1->priority == 2 ){
								$prior2SLA = $prior2SLA + 1;
							}
						}
						
					}
					
					/*sla por tipos*/
					$array = array(array('SLA OK', $porcentaje[$tipoTicket]['SLAok']), array('SLA no OK', $porcentaje[$tipoTicket]['SLA']));
					$posGraf = $tipoTicket + 1;
					$datos['opcTotales'.$tipoTicket] = $this->graficas->createStruct('containerGraf'.$posGraf, $value.' SLA', 'Tickets', $array, 'pie');
					
				}
				//conjunto global para la grafice Pie y column
				$datos['opcTotalesPie'] = $this->graficas->createStruct('containerGrafPie', 'Tickets Totals Oberts', 'Tickets', $arrayTotalPie, 'pie');
				$datos['opcTotalesColumn'] = $this->graficas->createStruct('containerGrafColumn', 'Tickets Totals Oberts Columns', 'Tickets', $arrayTotalColumn, 'column');
				$datos['opcTotalesPieC'] = $this->graficas->createStruct('containerGrafPieC', 'Tickets Totals Tancats', 'Tickets', $arrayTotalPieC, 'pie');
				$datos['opcTotalesColumnC'] = $this->graficas->createStruct('containerGrafColumnC', 'Tickets Totals Tancats Columns', 'Tickets', $arrayTotalColumnC, 'column');
				
				$arrayTotalColumnCStack = array(array('name' => 'NoOK', 'data' => $arrayColumnCStackSLA), array('name' => 'OK', 'data' => $arrayColumnCStack));
				$datos['opcTotalesColumnCStack'] = $this->graficas->createStruct('containerGrafColumnCStack', 'Tickets SLA', 'Tickets', $arrayTotalColumnCStack, 'columnStack', $columNomTipus);
				
				//calculo de graficos mediante urgencia solo para Incidencias
				//rellenamos el eje de la X con los tipos de SLA
				$tiposSla = $this->tickets->getSLAById();
				$columSLA = array();
				foreach( $tiposSla as $tipoS ){
					array_push( $columSLA, $tipoS->name );
				}
				//calculo para tickets de la grafica de incidencias por prioridad
				$prior5 = $prior5 - $prior5SLA;
				$prior2 = $prior2 - $prior2SLA;
				$prior3 = $prior3 - $prior3SLA;
				$prior4 = $prior4 - $prior4SLA;
				$arrayTotalColumnCStackI = array(array('name' => 'NoOK', 'data' => array( $prior5SLA, $prior4SLA, $prior3SLA, $prior2SLA )), array('name' => 'OK', 'data' => array( $prior5, $prior4, $prior3, $prior2 )));
				$datos['opcTotalesColumnCStackI'] = $this->graficas->createStruct('containerGrafColumnCStackI', 'Incidencies per prioritat', 'Tickets', $arrayTotalColumnCStackI, 'columnStack', $columSLA);
								
				/*datos completos abiertos*/
				$datos['listTicketsAll'] = $this->tickets->getTicketsByFechaAll($fechaInicial, $fechaFinal);
				
				/* datos completos cerrados*/
				$datos['listTicketsAllC'] = $this->tickets->getTicketsByFechaAll($fechaInicial, $fechaFinal, 0);
				
				
				/*********************************************************
				 * Creación del calendario *******************************
				 * *******************************************************/
				$fechaDefault = date('Y-m-d', strtotime($fechaInicial));
				$newCalendario = $this->tickets->newcalendar();
				$this->load->library('new_calendar');
				$datos['newCalendario'] = $this->new_calendar->createStruct($newCalendario, $fechaDefault);
					
				$this->load->view('inicio/index', $datos);
			}
		}else{
			$this->load->view('ldap/login');
		}
	}
	
	public function detallado(){
		
		$cat = $this->input->post('cat');
		$tipo = $this->input->post('tipo');
		$grupo = $this->input->post('grupo');
		$fechaInicial = $this->input->post('datepicker1');
		$fechaFinal = $this->input->post('datepicker2');
		
		if( $grupo == "cat" ){
			$tickets = $this->tickets->getTicketsByCategoria($cat, $fechaInicial, $fechaFinal, $tipo, 1, 1 );
		}elseif( $grupo == "dem" ){
			$tickets = $this->tickets->getTicketsByGroup($cat, $fechaInicial, $fechaFinal, $tipo, 1, 1, 1);
		}elseif( $grupo == "user" ){
			$tickets = $this->tickets->getTicketsByTecnico($cat, $fechaInicial, $fechaFinal, $tipo, 1, 1);
		}
		
		foreach( $tickets as $ticket){
			$datos[] = array('id' => $ticket->id, 'titol' => $ticket->name, 'data' => $ticket->date);
		}
		echo json_encode($datos);
	}
	
	public function compruebaFechas(){
		
		$fechaInicial = $this->input->post('datepicker1');
		$fechaFinal = $this->input->post('datepicker2');
		
		$fechaInicial1 = date("Y/m/d", strtotime($fechaInicial));
		$fechaFinal1 = date("Y/m/d", strtotime($fechaFinal));
		
		if( $fechaInicial1 <= $fechaFinal1 ){
			return TRUE;
		}else{
			$this->form_validation->set_message('compruebaFechas', 'La data Inicial ha de ser menor que la data Final');
			return FALSE;
		}					
	}
	
	public function exportarExcel($id){
		
		$fechaInicial = $this->input->post('form_ini_fecha');
		$fechaFinal = $this->input->post('form_fin_fecha');
		
		if( $id == 0 ){
			$listTickets = $this->tickets->getTicketsByFechaAll($fechaInicial, $fechaFinal);
		}else{
			$listTickets = $this->tickets->getTicketsByFechaAll($fechaInicial, $fechaFinal, 0);
		}
		
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Informe');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1','ID');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('B1','Títol');
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('C1','Dia Apertura');
		$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('D1','Hora Apertura');
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
		$this->excel->getActiveSheet()->setCellValue('E1','Dia Tancament');
		$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('F1','Hora Tancament');
		$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
		$this->excel->getActiveSheet()->setCellValue('G1','Estat');
		$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('H1','Tipus');
		$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('I1','Dia Venciment');
		$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('J1','Usuari Afectat');
		$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('K1','Tècnic Assignat');
		$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('L1','Categoria');
		$this->excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('M1','Prioritat');
		$this->excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('M1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('N1','SLA');
		$this->excel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('N1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('O1','Localització');
		$this->excel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('O1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('P1','Flag SLA');
		$this->excel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('P1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('Q1','Origen Sol.licitud');
		$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('R1','Departaments Usuari Afectat');
		$this->excel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('R1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
		$rowCount = 2;
		foreach( $listTickets as $list ){
			$this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $list->id);
			$this->excel->getActiveSheet()->getStyle('A'.$rowCount)->getFont()->setSize(10);
			$this->excel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $list->name);
			$this->excel->getActiveSheet()->getStyle('B'.$rowCount)->getFont()->setSize(10);
			
			$diaApertura = date("Y-m-d", strtotime($list->date));
			$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $diaApertura);
			$this->excel->getActiveSheet()->getStyle('C'.$rowCount)->getFont()->setSize(10);
			
			$horaApertura = date("H:i:s", strtotime($list->date));
			$this->excel->getActiveSheet()->setCellValue('D'.$rowCount, $horaApertura);
			$this->excel->getActiveSheet()->getStyle('D'.$rowCount)->getFont()->setSize(10);
			
			if( $list->closedate != null ){
				$diaClose = date("Y-m-d", strtotime($list->closedate));
				$horaClose = date("H:i:s", strtotime($list->closedate));
			}else{
				$diaClose="";
				$horaClose="";
			}

			$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, $diaClose);
			$this->excel->getActiveSheet()->getStyle('E'.$rowCount)->getFont()->setSize(10);
			
			$this->excel->getActiveSheet()->setCellValue('F'.$rowCount, $horaClose);
			$this->excel->getActiveSheet()->getStyle('F'.$rowCount)->getFont()->setSize(10);
			
			$this->excel->getActiveSheet()->setCellValue('G'.$rowCount, $this->tickets->getEstadoById($list->status));
			$this->excel->getActiveSheet()->getStyle('G'.$rowCount)->getFont()->setSize(10);
			
			$this->excel->getActiveSheet()->setCellValue('H'.$rowCount, $this->tickets->getTipoById($list->type));
			$this->excel->getActiveSheet()->getStyle('H'.$rowCount)->getFont()->setSize(10);
			
			if( $list->due_date != null ){
				$diaVenciment = date("Y-m-d", strtotime($list->due_date));
			}else{
				$diaVenciment = "";
			}
			$this->excel->getActiveSheet()->setCellValue('I'.$rowCount, $diaVenciment);
			$this->excel->getActiveSheet()->getStyle('I'.$rowCount)->getFont()->setSize(10);
			
			$listTicketsUsers = $this->tickets->getTicketsByFechaAllUsers($list->id);
			
			if( count($listTicketsUsers) > 1 ){
								foreach( $listTicketsUsers as $listTicketUser){
										if( $listTicketUser->type == 1 ){
											$usu = $this->users->getUsuarioById( $listTicketUser->users_id );
											$this->excel->getActiveSheet()->setCellValue('J'.$rowCount, $usu->name);
											$this->excel->getActiveSheet()->getStyle('J'.$rowCount)->getFont()->setSize(10);
										}elseif( $listTicketUser->type == 2){
											$usu = $this->users->getUsuarioById( $listTicketUser->users_id );
											$this->excel->getActiveSheet()->setCellValue('K'.$rowCount, $usu->name);
											$this->excel->getActiveSheet()->getStyle('K'.$rowCount)->getFont()->setSize(10);
										}
								}
							}else{
								foreach( $listTicketsUsers as $listTicketUser){
										if( $listTicketUser->type == 1 ){
											$usu = $this->users->getUsuarioById( $listTicketUser->users_id );
											$this->excel->getActiveSheet()->setCellValue('J'.$rowCount, $usu->name);
											$this->excel->getActiveSheet()->getStyle('J'.$rowCount)->getFont()->setSize(10);
											$this->excel->getActiveSheet()->setCellValue('K'.$rowCount, "");
										}elseif( $listTicketUser->type == 2){
											$usu = $this->users->getUsuarioById( $listTicketUser->users_id );
											$this->excel->getActiveSheet()->setCellValue('J'.$rowCount, "");
											$this->excel->getActiveSheet()->setCellValue('K'.$rowCount, $usu->name);
											$this->excel->getActiveSheet()->getStyle('K'.$rowCount)->getFont()->setSize(10);
										}
								}
							}
							
							//categoria
							$categoria = $this->categorias->getCategoriaById($list->itilcategories_id);
							if( $categoria ){
								$this->excel->getActiveSheet()->setCellValue('L'.$rowCount, $categoria->completename);
								$this->excel->getActiveSheet()->getStyle('L'.$rowCount)->getFont()->setSize(10);
							}else{
								$this->excel->getActiveSheet()->setCellValue('L'.$rowCount, "");
							}
							
							//urgencia
							$urgencia = $this->tickets->getPrioridadById( $list->priority );
							$this->excel->getActiveSheet()->setCellValue('M'.$rowCount, $urgencia);
							$this->excel->getActiveSheet()->getStyle('M'.$rowCount)->getFont()->setSize(10);
							
							//sla
							$sla = $this->tickets->getSLAById($list->slas_id);
							if( $sla ){
								$this->excel->getActiveSheet()->setCellValue('N'.$rowCount, $sla->name);
								$this->excel->getActiveSheet()->getStyle('N'.$rowCount)->getFont()->setSize(10);
							}else{
								$this->excel->getActiveSheet()->setCellValue('N'.$rowCount, "");
							}
							
							//localizacion
							$location = $this->tickets->getLocationById($list->locations_id);
							if( $location ){
								$this->excel->getActiveSheet()->setCellValue('O'.$rowCount, $location->name);
								$this->excel->getActiveSheet()->getStyle('O'.$rowCount)->getFont()->setSize(10);
							}else{
								$this->excel->getActiveSheet()->setCellValue('O'.$rowCount, "");
							}
						
				
				if( ($list->closedate != null) && ($list->due_date != null) ){
					
					$fechaClose = date("Y-m-d H:i:s", strtotime($list->closedate));
					$fechaSLA = date("Y-m-d H:i:s", strtotime($list->due_date));
					
					if( $fechaClose > $fechaSLA ){
						$this->excel->getActiveSheet()->setCellValue('P'.$rowCount, "NO OK");
						$this->excel->getActiveSheet()->getStyle('P'.$rowCount)->getFont()->setSize(10);
					}else{
						$this->excel->getActiveSheet()->setCellValue('P'.$rowCount, "OK");
						$this->excel->getActiveSheet()->getStyle('P'.$rowCount)->getFont()->setSize(10);
					}
				}elseif( ($fechaClose == null) || ($fechaSLA == null) ){
					$this->excel->getActiveSheet()->setCellValue('P'.$rowCount, "NO SLA");
					$this->excel->getActiveSheet()->getStyle('P'.$rowCount)->getFont()->setSize(10);
				}
				
			$this->excel->getActiveSheet()->setCellValue('Q'.$rowCount, $this->tickets->getRequestType($list->requesttypes_id));
			$this->excel->getActiveSheet()->getStyle('Q'.$rowCount)->getFont()->setSize(10);
			
			if ( count($listTicketsUsers) > 0 ){
				foreach( $listTicketsUsers as $userRow ){
					if( $userRow->type == 1 ){
						$group = $this->groups->getGroupsByIdUser( $userRow->users_id );
						if( count($group) > 0){
							$gruposUsuario = "";
							foreach( $group as $gr ){
								$gruposUsuario = $gruposUsuario." , ".$gr->name;
							}
							$this->excel->getActiveSheet()->setCellValue('R'.$rowCount, $gruposUsuario);
							$this->excel->getActiveSheet()->getStyle('R'.$rowCount)->getFont()->setSize(10);
						}
					}
				}
			}
				

			$rowCount ++;
		}
		
		if( $id == 0 ){
			$filename="estadisticas-oberts-".$fechaInicial.".xls"; //save our workbook as this file name
		}else{
			$filename="estadisticas-tancats-".$fechaInicial.".xls"; //save our workbook as this file name
		}
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
			
		//autofilter
		$this->excel->getActiveSheet()->setAutoFilter($this->excel->getActiveSheet()->calculateWorksheetDimension());
		
		//auto width
		for ($col = 'A'; $col != 'R'; $col++) {
			$this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
		
		
		
	}
		
	public function exportarExcelCalendar(){
		
		$datos_calendario = $this->tickets->getDatosCalendario($this->input->post('anyoCal'), $this->input->post('mesCal'), 1);
			
		$anyo = $this->input->post('anyoCal');
		$mes = $this->input->post('mesCal');
	
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Informe Diario');

		$tiposTickets = $this->tickets->getTiposTicket();
		
		//devuelve los dias del mes
		$diasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $anyo);
		
		$this->excel->getActiveSheet()->setCellValue('A1','Día');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$columnaDatos = "B";
		foreach( $tiposTickets as $tipo => $valor ){
				$this->excel->getActiveSheet()->setCellValue($columnaDatos."1", $valor);
				$this->excel->getActiveSheet()->getStyle($columnaDatos."1")->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle($columnaDatos."1")->getFont()->setSize(10);
				$this->excel->getActiveSheet()->getStyle($columnaDatos."1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$columnaDatos ++;		
		}
		
		//recorro los dias que tiene el mes
		for( $i = 1; $i <= $diasMes; $i++){
			$columnaDatos = "A";
			$y = $i + 1;
			$this->excel->getActiveSheet()->setCellValue($columnaDatos.$y, $i);
			$this->excel->getActiveSheet()->getStyle($columnaDatos.$y)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle($columnaDatos.$y)->getFont()->setSize(10);
			$this->excel->getActiveSheet()->getStyle($columnaDatos.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			foreach( $tiposTickets as $tipo => $valor ){
				$columnaDatos ++;
				if( $datos_calendario[$tipo][$i] ){
					$this->excel->getActiveSheet()->getStyle($columnaDatos.$y)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'F79F81'))));
					$this->excel->getActiveSheet()->setCellValue($columnaDatos.$y, $datos_calendario[$tipo][$i]);
				}else{
					$this->excel->getActiveSheet()->setCellValue($columnaDatos.$y, 0);
				}
				$this->excel->getActiveSheet()->getStyle($columnaDatos.$y)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle($columnaDatos.$y)->getFont()->setSize(10);
				$this->excel->getActiveSheet()->getStyle($columnaDatos.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			}
		}
		log_message('info', 'ESTADISTICAS - Excel diaria generado');
		
		$filename="estadisticas-diari-".date("Y-m-d").".xls"; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//autofilter
		$this->excel->getActiveSheet()->setAutoFilter($this->excel->getActiveSheet()->calculateWorksheetDimension());
			
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
	
}

