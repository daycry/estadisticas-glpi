<?php
//if (!defined('BASEPATH')) exit('No direct script access allowed');

class new_calendar{

	var $series   			= array();
	var $fechaDefault		= "";
	
	function new_calendar()
	{
		
	}
	
	function createStruct($data, $fechaDefault)
	{	
		$datos = array();
		//formateo los datos
		foreach( $data as $key => $dat){
			foreach( $dat as $da => $d ){
				if( $d != null ){
					if( $da == "Incidencies" ){
						$datos[] = array('title' => $da. ' --> '. $d, 'start' => $key, 'textColor' => 'black');
					}elseif( $da == "Peticions" ){
						$datos[] = array('title' => $da. ' --> '. $d, 'start' => $key, 'textColor' => '#1C1C1C');
					}elseif( $da == "Evolutius" ){
						$datos[] = array('title' => $da. ' --> '. $d, 'start' => $key, 'textColor' => '#1B2A0A');
					}elseif( $da == "Canvis" ){
						$datos[] = array('title' => $da. ' --> '. $d, 'start' => $key, 'textColor' => '#181907');
					}elseif( $da == "Consultes" ){
						$datos[] = array('title' => $da. ' --> '. $d, 'start' => $key, 'textColor' => 'white');
					}
				}
			}
			
		}
		$this->setSeries($datos);
		$this->setFechaDefault($fechaDefault);
		return $this->renderJson();
	}

	private function renderJson(){
		$options = array('render','lang' => 'es', 'defaultDate' => $this->fechaDefault,'editable' => 'true', 'weekends' => 'false',
		'events' => $this->series);
		return json_encode($options);
	}
	
	function setSeries( $data ){
		$this->series = $data;
	}
	
	function setFechaDefault( $fecha ){
		$this->fechaDefault = $fecha;
	}
	
}

?>
