<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent:: __construct();   
		$this->load->database();
		$this->load->helper('url');   
		// $this->load->model('m_rawat'); 
		$this->load->model('m_login'); 
		$this->load->model('m_token'); 
		$this->load->library('session');  
		if(!$this->m_login->is_login()) redirect('login');  
	} 
	
	public function index()
	{
		$id_user = $this->session->userdata('id');

		$saldo_user = $this->m_token->getSaldoUser($id_user);

		$data['saldo'] = $saldo_user[0]->saldo;
		$data['header'] = 'header';
		$data['menu'] = 'menu';
		$data['script'] = 'script';
		$data['footer'] = 'footer';
		$this->load->view('dashboard', $data);
	}
}
