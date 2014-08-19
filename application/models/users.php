<?php

class users extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function getTecnicos(){
		
		$this->db->select('gu.*');
		$this->db->from('glpi_users gu');
		$this->db->join('glpi_profiles_users gpu', 'gu.id = gpu.users_id', 'left');
		//$this->db->where_in('gpu.profiles_id', array('6','4'));
		$this->db->where_in('gpu.profiles_id', '6');
		$this->db->where_in('gu.is_active', '1');
		$query = $this->db->get();
		$this->db->close();
		return $query->result();
	}
	
    function getUsuarioById( $id ){
		
		$this->db->select('gu.*');
		$this->db->from('glpi_users gu');
		$this->db->where("gu.id", $id);
		
		$query = $this->db->get();
		$this->db->close();
		return $query->row();
	}
	
}
