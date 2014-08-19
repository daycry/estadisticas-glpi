<?php
//if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	HighCharts
 * @author		Daycry
 * @link		http://daycryweb.blogspot.com
 */
class graficas{

	var $renderTo			= '';
	var $titleText	 		= '';
	//var $series   			= array();
	var $name				= '';
	var $data				= array();
	var $categorias				= array();
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	function graficas()
	{
		/*if (count($params) > 0)
		{
			$this->initialize($params);		
		}*/

		//log_message('debug', "Graficas Class Initialized");
	}
	
	function createStruct($render,$title, $name, $data, $format, $categorias = null){
		$this->setRenderTo($render);
		$this->setTitleText($title);
		$this->setName($name);
		$this->setData($data);
		$this->setCategorias($categorias);
		
		if( $format == "pie" ){
			return $this->renderJsonPie();
		}elseif( $format == "column" ){
			return $this->renderJsonColumn();
		}elseif( $format == "columnStack" ){
			return $this->renderJsonColumnStack();
		}
	}

	function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}		
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Generate Json string
	 *
	 * @access	public
	 * @return	string
	 */	
	/*function renderJson(){
		
		$options = array('chart' =>array('renderTo' =>$this->renderTo, 'plotBackgroundColor' => null, 'plotBorderWidth' => null, 'plotShadow' => false),
		'title' => array('text' => $this->titleText),
		'toltip' => array('pointFormat' => '{series.name}: {point.percentage:.1f}%'),
		'plotOptions' => array('pie' => array('allowPointSelect' => true, 'cursor' => 'pointer','dataLabels' => array('enabled' => true, 'color' => '#000000', 'connectorColor' => '#000000', 'format' => '{point.name}: {point.percentage:.1f} %'), 'showInLegend' => true)),
		'series' => array(array('type' => 'pie','name' => $this->name,'data' => $this->data)),
		'exporting' => array('buttons' => array('contextButton' => array('menuItems' => null, 'onclick' => 'function(){this.exportChart();}'))));
		return json_encode($options);
	}*/
	
	private function renderJsonPie(){
		
		$options = array('chart' =>array('renderTo' =>$this->renderTo, 'plotBackgroundColor' => null, 'plotBorderWidth' => null, 'plotShadow' => false),
		'title' => array('text' => $this->titleText),
		'toltip' => array('pointFormat' => '<b>{series.name}</b>: {point.percentage:.1f}%'),
		'plotOptions' => array('pie' => array('allowPointSelect' => true, 'cursor' => 'pointer','dataLabels' => array('enabled' => true, 'color' => '#000000', 'connectorColor' => '#000000', 'format' => '<b>{point.name}</b>: {point.percentage:.1f} %'), 'showInLegend' => true)),
		'series' => array(array('type' => 'pie','name' => $this->name,'data' => $this->data)),
		'exporting' => array('buttons' => array('contextButton' => array('menuItems' => null, 'onclick' => '')))
		);
		return json_encode($options);
	}
	
	private function renderJsonColumn(){
		
		$options = array('chart' =>array('type' => 'column', 'renderTo' =>$this->renderTo),
		//'colors' => array('#F79F81', '#CECEF6','#F7BE81','#819FF7','#A9F5BC','#74DF00'),
		'title' => array('text' => $this->titleText),
		'xAxis' => array('categories' => array('Entre fechas seleccionadas')),
		'yAxis' => array('min' => 0, 'title' => array('text' => 'Num. Tickets')),
		'toltip' => array('headerFormat' => '<span style="font-size:10px">{point.key}</span><table>', 'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>', 'footerFormat' => '</table>', 'shared' => true, 'useHTML' => true),
		'plotOptions' => array('column' => array('dataLabels' => array('enabled' => true, 'color' => '(Highcharts.theme && Highcharts.theme.dataLabelsColor) || "white"'), 'pointPadding' => 0.2, 'borderWidth' => 0)),
		'series' => $this->data,
		'exporting' => array('buttons' => array('contextButton' => array('menuItems' => null, 'onclick' => '')))
		);
		return json_encode($options);
	}
	
	
	private function renderJsonColumnStack(){
		
		$options = array('chart' =>array('type' => 'column', 'renderTo' =>$this->renderTo),
		'title' => array('text' => $this->titleText),
		'colors' => array('#F79F81', '#CECEF6'),
		/*'xAxis' => array('categories' => array('Incidencia', 'Petició', 'Evolutiu', 'Canvi', 'Consulta')),*/
		'xAxis' => array('categories' => $this->categorias),
		'yAxis' => array('min' => 0, 'title' => array('text' => 'Num. Tickets'),'stackLabels' => array('enabled' => true, 'style' => array('fontWeight' => 'bold', 'color' => '(Highcharts.theme && Highcharts.theme.textColor) || "gray"'))),
		/*'legend' => array('align' => 'right', 'x' => -70, 'verticalAlign' => 'top', 'y' => 20, 'floating' => true, 'backgroundColor' => '(Highcharts.theme && Highcharts.theme.background2) || "white"', 'borderColor' => '#CCC', 'borderWidth' => 1, 'shadow' => false),*/
		'legend' => array('align' => 'right', 'x' => -70, 'verticalAlign' => 'top', 'y' => 20, 'floating' => true, 'backgroundColor' => 'white', 'borderColor' => '#CCC', 'borderWidth' => 1, 'shadow' => false),
		'toltip' => array('headerFormat' => '<span style="font-size:10px">{point.key}</span><table>', 'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>', 'footerFormat' => '</table>', 'shared' => true, 'useHTML' => true),
		'plotOptions' => array('column' => array('stacking' => 'normal', 'dataLabels' => array('enabled' => true, 'color' => '(Highcharts.theme && Highcharts.theme.dataLabelsColor) || "white"'), 'style' => array( 'textShadow' => '0 0 3px black, 0 0 3px black' ), 'pointPadding' => 0.2, 'borderWidth' => 0)),
		'series' => $this->data,
		'exporting' => array('buttons' => array('contextButton' => array('menuItems' => null, 'onclick' => '')))
		);
		return json_encode($options);
	}
	
	
	private function setRenderTo( $renderTo ){
		$this->renderTo = $renderTo;
	}
	
	private function setTitleText( $titleText ){
		$this->titleText = $titleText;
	}
	
	private function setData( $data ){
		$this->data = $data;
	}
	
	private function setCategorias( $categorias ){
		$this->categorias = $categorias;
	}
	
	private function setName( $name ){
		$this->name = $name;
	}

}

?>
