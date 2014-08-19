<?php

class groups extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function getAll( $demarcacio ){
		$this->db->where('is_assign', $demarcacio);
		$query = $this->db->get('glpi_groups');
		$this->db->close();
		return $query->result();
	}
	
	function getGroupsByIdUser( $id ){
		
		$this->db->select('gg.*');
		$this->db->from('glpi_groups gg');
		$this->db->join('glpi_groups_users ggu', 'gg.id = ggu.groups_id', 'left');
		$this->db->where_in('ggu.users_id', $id);
		$query = $this->db->get();
		$this->db->close();
		return $query->result();
	}
	
}
