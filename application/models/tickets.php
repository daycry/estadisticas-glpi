<?php

class tickets extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    
	function getTiposTicket(){
		
		$tipostickets = array(1 => "Incidència", 2 => "Petició", 3 => "Evolutiu", 4 => "Canvi", 5 => "Consulta");
		return $tipostickets;
		
	}
    
    
    function getTicketsByGroup( $id, $fechaInicial, $fechaFinal, $tipo, $demarcacio, $abierto = 1, $consulta = 0){
		
		if( $consulta == 0 ){
			$this->db->select('count(DISTINCT gt.id) as total');
		}else{
			$this->db->select('gt.*');
		}
		$this->db->from('glpi_tickets gt');
		$this->db->join('glpi_tickets_users gtu', 'gt.id = gtu.tickets_id', 'left');
		$this->db->join('glpi_users gu', 'gu.id = gtu.users_id', 'left');
		$this->db->join('glpi_groups_users ggu', 'ggu.users_id = gu.id', 'left');
		$this->db->join('glpi_groups gg', 'gg.id = ggu.groups_id', 'left');

		$this->db->where('gtu.type', 1);
		$this->db->where('ggu.groups_id', $id);
		$this->db->where('gt.type', $tipo);
		$this->db->where('gg.is_assign', $demarcacio); //para diferenciar de demarcacion y departamento
		
		if( $abierto == 1 ){
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}else{
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}
		if( $consulta == 0 ){
			$this->db->group_by("gg.name");
			$this->db->limit(1);
		}
		$query = $this->db->get();
		$this->db->close();
		
		return $query->result();
	}
		
	function getTicketsByCategoria( $id, $fechaInicial, $fechaFinal, $tipo, $abierto = 1, $consulta = 0){
		
		if( $consulta == 0 ){
			$this->db->select('count(*) as total');
		}else{
			$this->db->select('*');
		}
		$this->db->from('glpi_tickets gt');
		$this->db->where('gt.itilcategories_id', $id);
		$this->db->where('gt.type', $tipo);

		if( $abierto == 1 ){
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}else{
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}		
		$query = $this->db->get();	
		$this->db->close();
		if( $consulta == 0 ){
			return $query->row();
		}else{
			return $query->result();
		}
		
	}
	
	function getTicketsTotales( $fechaInicial, $fechaFinal, $tipo, $abierto = 1 ){
		
		$this->db->select('count(*) as total');
		$this->db->from('glpi_tickets gt');
		$this->db->where('gt.type', $tipo);
		if( $abierto == 1 ){
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}else{
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}
		$query = $this->db->get();
		$this->db->close();		
		return $query->row();
		
	}
	
    function getTicketsByTecnico( $id, $fechaInicial, $fechaFinal, $tipo, $abierto = 1, $consulta = 0 ){
		
		if( $consulta == 0 ){
			$this->db->select('count(*) as total');
		}else{
			$this->db->select('*');
		}
		$this->db->from('glpi_tickets_users gtu');
		$this->db->join('glpi_users gu', 'gu.id = gtu.users_id', 'left');
		$this->db->join('glpi_tickets gt', 'gt.id = gtu.tickets_id', 'left');
		$this->db->where('gtu.type', 2);
		$this->db->where('gu.id', $id);
		$this->db->where('gt.type', $tipo);
		if( $abierto == 1 ){
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}else{
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}
		if( $consulta == 0 ){
			$this->db->group_by("gu.realname");
		}
		$query = $this->db->get();
		$this->db->close();	
		return $query->result();
	}
	
	function getTicketsDiario ( $fecha ) {
		
		$this->db->distinct();
		$this->db->select('gt.*, gtu.users_id, ggu.groups_id');
		$this->db->from('glpi_tickets gt');
		$this->db->join('glpi_tickets_users gtu', 'gt.id = gtu.tickets_id', 'left');
		$this->db->join('glpi_groups_users ggu', 'ggu.users_id = gtu.users_id', 'left');
		$this->db->where('gtu.type', 1);
		$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') = '" .$fecha. "'",NULL,FALSE);
		$query = $this->db->get();
		$this->db->close();		
		return $query->result();
	}
	
	function insertGroupTicket( $datos ){
		$this->db->insert('glpi_groups_tickets', $datos);
		if($this->db->affected_rows() == 0){
			$this->db->close();
			return 0;
		}else{
			$this->db->close();
			return 1;
		}
	}
	
	function selectGroupTicket( $id, $grupo){
		$query = $this->db->get_where('glpi_groups_tickets', array('tickets_id' => $id, 'groups_id' => $grupo));
		$this->db->close();
		return $query->num_rows();
	}
	
    function getTicketsByFecha( $fechaInicial, $fechaFinal, $tipo, $abierto = 1){
		
		$this->db->select('gt.*');
		$this->db->from('glpi_tickets gt');
		$this->db->join('glpi_tickets_users gtu', 'gt.id = gtu.tickets_id', 'left');
		$this->db->join('glpi_users gu', 'gu.id = gtu.users_id', 'left');
		$this->db->where('gtu.type', 1);
		$this->db->where('gt.type', $tipo);
		if( $abierto == 1 ){
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}else{
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}
		$query = $this->db->get();
		$this->db->close();	
		return $query->result();
	}
	
	
    function getTicketsByFechaAll( $fechaInicial, $fechaFinal, $abierto = 1 ){
		
		$this->db->select('*');
		$this->db->from('glpi_tickets gt');
		if( $abierto == 1 ){
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}else{
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}
		$this->db->order_by("gt.id", "asc"); 
		$query = $this->db->get();
		$this->db->close();	
		return $query->result();
	}
	
    function getTicketsByFechaAllUsers( $id ){
		
		$this->db->select('*');
		$this->db->from('glpi_tickets_users gtu');
		$this->db->where("gtu.tickets_id", $id);
		
		$query = $this->db->get();
		$this->db->close();	
		return $query->result();
	}
	
	function getTicketsByFechaSLA( $fechaInicial, $fechaFinal, $tipo, $abierto = 1){
		
		$this->db->select('gt.*');
		$this->db->from('glpi_tickets gt');
		$this->db->join('glpi_tickets_users gtu', 'gt.id = gtu.tickets_id', 'left');
		$this->db->join('glpi_users gu', 'gu.id = gtu.users_id', 'left');
		$this->db->where('gtu.type', 1);
		$this->db->where('gt.type', $tipo);
		if( $abierto == 1 ){
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.date,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}else{
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') >= '" .$fechaInicial. "'",NULL,FALSE);
			$this->db->where("DATE_FORMAT(gt.closedate,'%Y/%m/%d') <= '" .$fechaFinal. "'",NULL,FALSE);
		}
		$this->db->where("gt.due_date < gt.closedate",NULL,FALSE);
		
		$query = $this->db->get();
		$this->db->close();		
		return $query->result();
	}
	
	function getSLAById( $id = 0){
		
		$this->db->select('*');
		$this->db->from('glpi_slas gs');
		if( $id != 0 ){
			$this->db->where('gs.id', $id);
		}
		$query = $this->db->get();
		$this->db->close();
		if( $id != 0 ){
			return $query->row();
		}else{
			return $query->result();
		}
	}
	
	function getLocationById( $id ){
		
		$this->db->select('*');
		$this->db->from('glpi_locations gl');
		$this->db->where('gl.id', $id);
		
		$query = $this->db->get();
		$this->db->close();	
		return $query->row();
	}
	
	function getEstadoById ( $id ){
		if( $id == 1 ){
			return "Nou";
		}
		if( $id == 2 ){
			return "En Curs (assignada)";
		}
		if( $id == 3 ){
			return "En Curs (planificada)";
		}
		if( $id == 4 ){
			return "En espera";
		}
		if( $id == 5 ){
			return "Anul·lat";
		}
		if( $id == 6 ){
			return "Tancat";
		}
	}
	
	function getTipoById ( $id ){
		if( $id == 1 ){
			return "Incidència";
		}
		if( $id == 2 ){
			return "Petició";
		}
		if( $id == 3 ){
			return "Evolutiu";
		}
		if( $id == 4 ){
			return "Canvi";
		}
		if( $id == 5 ){
			return "Consulta";
		}
	}
	
	function getUrgenciaById ( $id ){
		if( $id == 5 ){
			return "Molt Alt";
		}
		if( $id == 4 ){
			return "Alt";
		}
		if( $id == 3 ){
			return "Mitjana";
		}
		if( $id == 2 ){
			return "Baixa";
		}
		if( $id == 1 ){
			return "Molt Baixa";
		}
	}
	
		function getPrioridadById ( $id ){
		if( $id == 5 ){
			return "Molt Urgent";
		}
		if( $id == 4 ){
			return "Urgent";
		}
		if( $id == 3 ){
			return "Mitjana";
		}
		if( $id == 2 ){
			return "Baixa";
		}
		if( $id == 1 ){
			return "Molt Baixa";
		}
	}
	
	function getRequestType( $id ){
		
		$this->db->select('*');
		$this->db->from('glpi_requesttypes grt');
		$this->db->where('grt.id', $id);
		
		$query = $this->db->get();
		$this->db->close();	
		return $query->row()->name;
	}
	
	function getAllTickets() {
		$this->db->select('gt.*');
		$this->db->from('glpi_tickets gt');
		$query = $this->db->get();
		$this->db->close();	
		return $query->result();
	}
	
	function setTicketSla($data, $id){
		$this->db->where('id', $id);
		$this->db->update('glpi_tickets', $data); 
		$this->db->close();
	}
	
	/*
	 * funcion para el calendario
	 */
	 //obsoleta
	public function getDatosCalendario($year, $month, $tipo = 0)
    {
		$this->db->select('gt.*');
		$this->db->from('glpi_tickets gt');
        $this->db->like('date', $year.'-'.$month, 'after');
        $this->db->group_by('date');
        $query = $this->db->get();

        $datos_calendario = array();
        $datos_calendarioExcel = array();
        
        $arrayIn = array();
        $arrayPet = array();
        $arrayCan = array();
        $arrayEv = array();
        $arrayCon = array();
        $index = 0;

        foreach ($query->result() as $row) 
        {
            //si el primer número encontrado a partir del octavo
            //encontrado en la fecha es un cero, es decir, los días 
            //01,02,03 etc le quitamos el 0 y mostramos el siguiente número
            //si no lo hacemos así nuestro calendario no mostrará los resultados
            //de los días del 1 al 9
            if( $row->date ){
				$index = ltrim(substr($row->date, 8, 2), '0');
           
				if ( $index != null){
					if($row->type == 1){
						$arrayIn[$index] = $arrayIn[$index] + 1;
					}elseif($row->type == 2){
						$arrayPet[$index] = $arrayPet[$index] + 1;
					}elseif($row->type == 3){
						$arrayEv[$index] = $arrayEv[$index] + 1;
					}elseif($row->type == 4){
						$arrayCan[$index] = $arrayCan[$index] + 1;
					}elseif($row->type == 5){
						$arrayCon[$index] = $arrayCon[$index] + 1;
					}
					$datos_calendario[$index] = "<p>Incidències : ".$arrayIn[$index]."</p><p>Peticions : ".$arrayPet[$index]."</p>
					<p>Evolutius : ".$arrayEv[$index]."</p><p>Canvis : ".$arrayCan[$index]."</p><p>Consultes : ".$arrayCon[$index]."</p>";
				}
			}
				
            
           
        }
        //devolvemos los datos y así ya podemos pasarle estos datos al método genera_calendario($year, $month)
        if($tipo == 0){
			return $datos_calendario;
		}else{
			return $datos_calendarioExcel = array('1' => $arrayIn, '2' => $arrayPet, '3' => $arrayEv, '4' => $arrayCan, '5' => $arrayCon);
		}
    }
    
    public function newcalendar(){
		$this->db->select('gt.*');
		$this->db->from('glpi_tickets gt');
        //$this->db->like('date', $year.'-'.$month, 'after');
        $this->db->group_by('date');
        $query = $this->db->get();
        
        $arrayIn = array();
        $arrayPet = array();
        $arrayCan = array();
        $arrayEv = array();
        $arrayCon = array();
        $index = 0;
        
        foreach( $query->result() as $row ){
			
			if( $row->date ){
				$index = date('Y-m-d', strtotime($row->date));
           
				if ( $index != null){
					if($row->type == 1){
						$arrayIn[$index] = $arrayIn[$index] + 1;
					}elseif($row->type == 2){
						$arrayPet[$index] = $arrayPet[$index] + 1;
					}elseif($row->type == 3){
						$arrayEv[$index] = $arrayEv[$index] + 1;
					}elseif($row->type == 4){
						$arrayCan[$index] = $arrayCan[$index] + 1;
					}elseif($row->type == 5){
						$arrayCon[$index] = $arrayCon[$index] + 1;
					}
					$datos_calendario[$index]['Incidencies'] = $arrayIn[$index];
					$datos_calendario[$index]['Peticions'] = $arrayPet[$index];
					$datos_calendario[$index]['Evolutius'] = $arrayEv[$index];
					$datos_calendario[$index]['Canvis'] = $arrayCan[$index];
					$datos_calendario[$index]['Consultes'] = $arrayCon[$index];
				}
			}
			
		}
		return $datos_calendario;
	}


    
}
