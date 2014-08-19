<?php

class categorias extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function getCategorias(){
		
		$this->db->select('gic.*');
		$this->db->from('glpi_itilcategories gic');
		$this->db->where("gic.itilcategories_id !=", 0);
		$query = $this->db->get();
		
		$this->db->close();
		return $query->result();
	}
	
    function getCategoriaById( $id ){
		
		$this->db->select('gic.*');
		$this->db->from('glpi_itilcategories gic');
		$this->db->where("gic.id", $id);
		
		$query = $this->db->get();
		$this->db->close();
		return $query->row();
	}
	
	
}
