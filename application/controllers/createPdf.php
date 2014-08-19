<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class createPdf extends CI_Controller {
	
	function pdf()
	{
		//$this->load->helper('pdf_helper');
		$data['titulo'] = "Prueba";
		$this->load->view('pdf/pdfreport', $data);
	}
	
}

?>
