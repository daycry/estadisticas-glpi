<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ldap extends CI_Controller {

	public function login()
	{		
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$datos['datos_ses'] = $session_data;
			$datos['username'] = $session_data['username'];
			$datos['titulo'] = "ESTADÍSTIQUES";
			$this->load->view('inicio/index', $datos);
		}else{
			$this->load->view('ldap/login');
		}
	}
	
	public function doLogin()
	{
		
		if($this->session->userdata('logged_in')){
			$datos['titulo'] = "ESTADÍSTIQUES";
			$session_data = $this->session->userdata('logged_in');
			$datos['datos_ses'] = $session_data;
			$datos['username'] = $session_data['username'];
			$this->load->view('inicio/index', $datos);
		}else{
		
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_ldap_login');
			$this->form_validation->set_message('required','El camp %s es obligatori');
			$this->form_validation->set_message('required','El camp %s es obligatori');
			
			if ($this->form_validation->run() == FALSE){
				$this->load->view('ldap/login');
			}else{
				
				$domain = $this->config->item('ldap_domain');
				$username = $this->input->post('username');
				$sesion = array(
					'username'  => $username,
					'email'     => $username.$domain,
					'logged_in' => TRUE
					);
				$this->session->set_userdata('logged_in', $sesion);
				$datos['titulo'] = "ESTADÍSTIQUES";
				$session_data = $this->session->userdata('logged_in');
				$datos['datos_ses'] = $session_data;
				$datos['username'] = $session_data['username'];
				$this->load->view('inicio/index', $datos);
			}
		}
	}
	
	public function ldap_login(){
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
					
		$ldaphost = $this->config->item('host_ldap');
		$dn = $this->config->item('dn_ldap_infor');
		$domain = $this->config->item('ldap_domain');
		$acceso = $this->config->item('acceso');
			
		$ds = ldap_connect($ldaphost);
		if ($ds){
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

			//bind con el admin para poder realizar busquedas
			$admin = $this->config->item('ldap_manager');
			$passAdmin = $this->config->item('ldap_manager_pwd');
			
			
			$ldapbind = ldap_bind($ds, $username.$domain, $password);
			
			if ($ldapbind) {
				if (in_array($username, $acceso)) {
					return TRUE;
				}else{
					$this->form_validation->set_message('ldap_login', 'Usuario sin permisos de acceso');
					return FALSE;
				}
			}else{
				$this->form_validation->set_message('ldap_login', 'El %s es incorrecte');
				return FALSE;
			}
			
			/*$ldapbindAdmin = ldap_bind($ds, $admin.$domain, $passAdmin);	
			if( $ldapbindAdmin ){
				if ($ldapbind) {
					$isITuser = ldap_search($ldapbindAdmin,$dn,'(&(objectClass=User)(sAMAccountName=' . $username. '))');
					if( $isITuser ){
						return TRUE;
					}else{
						$this->form_validation->set_message('ldap_login', $username.' és usuari no autoritzat');
						return FALSE;
					}
				}else{
					$this->form_validation->set_message('ldap_login', 'El %s es incorrecte');
					return FALSE;
				}
			}else{
				$this->form_validation->set_message('ldap_login', 'Fallo de conexió amb el Directori Actiu');
				return FALSE;
			}*/
			
		}else{
			$this->form_validation->set_message('conexio', 'Servidor sin servei');
			return FALSE;
		}
	}
	
	function logout(){

		$this->session->unset_userdata('logged_in');
		//session_destroy();
		$this->session->sess_destroy();
		redirect('inicio/index', 'refresh');

	}
	
}

