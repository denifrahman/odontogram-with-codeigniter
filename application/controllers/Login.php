<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->load->model('m_login'); 
		$this->load->library('session'); 
		$this->load->library('crypt'); 
	} 

	public function index()
	{
		if($this->session->userdata('akses') == 0){
			
			if($this->input->post('login')){

				$user = $this->input->post('username');
				$pass = $this->input->post('password');		

				$encrypt_pass= $this->crypt->encrypt($pass,'abcdef0123456789');

				$data['user'] = $this->m_login->login($user, $encrypt_pass);

				if($data['user']){
					$session = array(
							'akses'=>1, 
							'id'=>$data['user'][0]->id,
							'username'=>$user, 
							'nama'=>$data['user'][0]->nama, 
							'role'=>$data['user'][0]->role,
							'no_telp'=>$data['user'][0]->no_telp
						);
					$this->session->set_userdata($session);
					redirect('dashboard');
				}
				else{
					echo '
						<script>
							alert("Username or Password is Wrong. Try Again!");
							window.location = "'.site_url().'";
						</script>
					';
				}

			} else {

				$data['header'] = 'header';
				$data['script'] = 'script';
				$this->load->view('login', $data);

			}

		} else {
			redirect('dashboard');
		}
	}

	function logout()
	{
		$session = array(
				'akses'=>0,
				'username'=>'',
				'nama'=>'', 
				'role'=>'',
				'no_telp' => ''
			);
    	$ses = $this->session->unset_userdata($session); 
		$this->session->sess_destroy();

		redirect('login');
	}

}
