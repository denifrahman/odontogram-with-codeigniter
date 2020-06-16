<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_user extends CI_Controller {

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
		$this->load->model('m_master_user'); 
		$this->load->model('m_login'); 
		$this->load->library('session');  
		$this->load->library('crypt'); 
		if(!$this->m_login->is_login()) redirect('login');  
	} 

	public function index()
	{
		if ($this->session->userdata('role') == "ADMIN") {
			$data['m_user'] = $this->m_master_user->get_all_user();
			$data['header'] = 'header';
			$data['menu'] = 'menu';
			$data['script'] = 'script';
			$data['footer'] = 'footer';
			$this->load->view('master_user', $data);
		} else {
			redirect('dashboard');
		}
	}

	function add_user(){
		if ($this->session->userdata('role') == "ADMIN") {
			$data['error'] = ''; $data['validate'] = ''; $data['status'] = '';$data['user'] = '';

			$data['role']= $this->input->post('role');
			$nama		= $this->input->post('nama');
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');
			$no_telp	= $this->input->post('no_telp');
			$alamat		= $this->input->post('alamat');
			$jenis_kelamin		= $this->input->post('jenis_kelamin');

			$encrypt_pass= $this->crypt->encrypt($password,'abcdef0123456789');

			$cek_username = $this->m_master_user->cek_username($username);

			$result = array();

			
			if(!$cek_username){
		        				
				$data['add_user'] = $this->m_master_user->add_user($nama, $username, $encrypt_pass, $alamat, $jenis_kelamin, $no_telp, $data['role']);
	   			
	   			if($data['add_user']){
	   				$result = array(
	   						"rc" => "0000",
	   						"message" => "Master User berhasil ditambahkan."
	   					);
	   			}
	   			else {
					$result = array(
	   						"rc" => "0001",
	   						"message" => "Master User gagal ditambahkan."
	   					);
	   			}

			}
			else{
				$result = array(
	   						"rc" => "0002",
	   						"message" => "Username Sudah Ada!"
	   					);
			}

			echo json_encode($result);
		} else {
			redirect('dashboard');
		}

	}

	function edit_user(){
		if ($this->session->userdata('role') == "ADMIN") {
			$data['error'] = ''; $data['validate'] = ''; $data['status'] = '';$data['user'] = '';

			$id		= $this->input->post('id');
			$nama		= $this->input->post('nama');
			$password	= $this->input->post('password');
			$no_telp	= $this->input->post('no_telp');
			$alamat		= $this->input->post('alamat');
			$jenis_kelamin		= $this->input->post('jenis_kelamin');
			$data['role']= $this->input->post('role');

			// $cek_username = $this->m_master_user->cek_username($username);

			$result = array();

			
			// if(!$cek_username){
				$encrypt_pass= $this->crypt->encrypt($password,'abcdef0123456789');
		        				
				$data['add_user'] = $this->m_master_user->edit_user($id, $nama, $encrypt_pass, $alamat, $jenis_kelamin, $no_telp, $data['role']);
	   			
	   			if($data['add_user']){
	   				$result = array(
	   						"rc" => "0000",
	   						"message" => "Master User berhasil diperbarui."
	   					);
	   			}
	   			else {
					$result = array(
	   						"rc" => "0001",
	   						"message" => "Master User gagal diperbarui."
	   					);
	   			}

			// }
			// else{
			// 	$result = array(
	  //  						"rc" => "0002",
	  //  						"message" => "Username Sudah Ada!"
	  //  					);
			// }

			echo json_encode($result);
		} else {
			redirect('dashboard');
		}

	}

	function delete_user(){
		if ($this->session->userdata('role') == "ADMIN") {
			$dtusr=trim(file_get_contents('php://input'));
			$objx=json_decode(trim($dtusr), true);
			$id_user=$objx['id'];

			$data['delete_user'] = $this->m_master_user->delete_user($id_user);
				
			if($data['delete_user']){
				$result = array(
						"rc" => "0000",
						"message" => "Master User berhasil dihapus."
					);
			}
			else {
				$result = array(
						"rc" => "0001",
						"message" => "Master User gagal dihapus."
					);
			}

			echo json_encode($result);
		} else {
			redirect('dashboard');
		}
	}

	function get_user_by_id(){
		// if ($this->session->userdata('role') == "DOKTER_MUDA,ADMIN") {
			$dtusr=trim(file_get_contents('php://input'));
			$objx=json_decode(trim($dtusr), true);
			$id_user=$objx['id'];

			$data['get_user'] = $this->m_master_user->get_user_by_id($id_user);
				
			if($data['get_user']){
				// print_r(json_decode(json_encode($data['get_user'][0]), true));
				$data_user = json_decode(json_encode($data['get_user'][0]), true);
				$data_user['password'] = $this->crypt->decrypt($data_user['password'],'abcdef0123456789');
				$result = array_merge($data_user, array(
						"rc" => "0000",
					));
				// $result = $data['get_user'];
			}
			else {
				$result = array(
						"rc" => "0001",
						"message" => "Master User gagal dihapus."
					);
			}

			echo json_encode($result);
		// } else {
		// 	redirect('dashboard');
		// }
	}

	function getUser(){
		if ($this->session->userdata('role') == "ADMIN") {
			$data_user = $this->m_master_user->get_all_user();

			$header = '<thead>
	                        <tr>
	                        	<th>No</th>
	                            <th>Nama</th>
	                            <th>Username</th>
	                            <th>No. Telp</th>
	                            <th>Jenis Kelamin</th>
	                            <th>Role</th>
	                            <th class="disabled-sorting text-right">Actions</th>
	                        </tr>
	                    </thead>
	                    <tfoot>
	                        <tr>
	                        	<th>No</th>
	                            <th>Nama</th>
	                            <th>Username</th>
	                            <th>No. Telp</th>
	                            <th>Jenis Kelamin</th>
	                            <th>Role</th>
	                            <th class="text-right">Actions</th>
	                        </tr>
	                    </tfoot>
	                    <tbody id="tabel_master_user">';

			$no = 0;
	    	if($data_user != ""){
	    		echo $header;
				foreach ($data_user as $key) {
					$jenis_kelamin = "";
					if ($key->jenis_kelamin == "L") {
						$jenis_kelamin = "LAKI - LAKI";
					} else if ($key->jenis_kelamin == "P"){
						$jenis_kelamin = "PEREMPUAN";
					}
					echo '<tr>
	                            <td>'.($no + 1).'</td>
	                            <td>'.$key->nama.'</td>
	                            <td>'.$key->username.'</td>
	                            <td>'.$key->no_telp.'</td>
	                            <td>'.$jenis_kelamin.'</td>
	                            <td>'.$key->role.'</td>
	                            <td class="text-right">
	                                <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editUser('.$key->id.');"><i class="material-icons">edit</i></a>
	                                <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove"  onclick="deleteUser('.$key->id.', '."'".$key->username."'".');"><i class="material-icons">close</i></a>
	                            </td>
	                        </tr>';

	                $no++;
				}
				echo '</tbody>';
			}
		} else {
			redirect('dashboard');
		}
	}
}
