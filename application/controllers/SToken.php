<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SToken extends CI_Controller {

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
		$this->load->model('m_token'); 
		$this->load->model('m_login'); 
		$this->load->library('session');  
		if(!$this->m_login->is_login()) redirect('login');  
	} 

	public function index()
	{
		$role = $this->session->userdata('role');
		if (strtolower($role) == "admin" && strtolower($this->session->userdata('username')) == "admin") {
			# code...
			$data['m_token'] = $this->m_token->get_all_saldo_user();
			$data['header'] = 'header';
			$data['menu'] = 'menu';
			$data['script'] = 'script';
			$data['footer'] = 'footer';
			$this->load->view('stoken', $data);
		} else {
			redirect('dashboard');
		}
	}

	public function index_mutasi($idUser)
	{
		$toDate = date("Y-m-d");
		$fromDate = date("Y-m-d", strtotime("-1 month"));

		if($this->input->post('cari')){
			$toDate = $this->input->post('toDate');
			$fromDate = $this->input->post('fromDate');
		}

		if ($idUser == "0") {
			$id_user = $this->session->userdata('id');
		} else {
			$id_user = $idUser;
		}

		$saldo_user = $this->m_token->getSaldoUser($this->session->userdata('id'));

		$data['saldo'] = $saldo_user[0]->saldo;

		$data['fromDate'] = $fromDate;
		$data['toDate'] = $toDate;
		$data['idUser'] = $id_user;
		$data['m_token'] = $this->m_token->get_filter_mutasi_user($fromDate, $toDate, $id_user);
		$data['header'] = 'header';
		$data['menu'] = 'menu';
		$data['script'] = 'script';
		$data['footer'] = 'footer';
		$this->load->view('stoken_mutasi', $data);
	}

	function get_saldo_user(){
		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$id_user=$objx['id_user'];

		$data['saldo'] = $this->m_token->getSaldoUser($id_user);
			
		if($data['saldo']){
			// print_r(json_decode(json_encode($data['get_penyakit'][0]), true));
			$result = array_merge(json_decode(json_encode($data['saldo'][0]), true), array(
					"rc" => "0000",
				));
			// $result = $data['get_penyakit'];
		}
		else {
			$result = array(
					"rc" => "0001",
					"message" => "Saldo User tidak ditemukan."
				);
		}

		echo json_encode($result);
	}

	function allocate_deposit(){
		$role = $this->session->userdata('role');
		if (strtolower($role) == "admin" && strtolower($this->session->userdata('username')) == "admin") {

			$id_user		= $this->input->post('id');
			$id_admin		= $this->input->post('id_admin');
			$nominal 		= $this->input->post('nominal');
			$user_update	= $this->session->userdata("username");

			$id_trx 		= $id_rawat 		= "DEP".rand(1111,9999)."".time();

			$result = array();

		    $saldo_admin = $this->m_token->getSaldoUser($id_admin);

		    if ($saldo_admin[0]->saldo < $nominal) {
		    	$result = array(
						"rc" => "0001",
						"message" => "Saldo anda tidak cukup untuk allocate deposit, silahkan tambah saldoanda dahulu."
					);
		    	echo json_encode($result);
		    	exit();
		    }

		    $ket = "Penambahan Saldo";
		    if ($nominal < 0) {
		    	$ket = "Penarikan Saldo";
		    }

			$data['saldo'] = $this->m_token->allocateDeposit($user_update, $ket, $nominal, 0, 'IN', $id_trx, 0, $id_user);
				
			if($data['saldo']){
				if ($id_admin != $id_user) {
					# code...
					$data['saldo'] = $this->m_token->allocateDeposit($user_update, 'Allocate Deposit', $nominal, 0, 'OUT', $id_trx, $id_user, $id_admin);
				}
				$result = array(
						"rc" => "0000",
						"message" => "Saldo user berhasil ditambahkan."
					);
			}
			else {
			$result = array(
						"rc" => "0001",
						"message" => "Saldo user gagal ditambahkan."
					);
			}

			echo json_encode($result);

		} else {
		$result = array(
					"rc" => "0001",
					"message" => "Siapakah anda?."
				);
		echo json_encode($result);

		}

	}

	function getSaldo(){
		$data_penyakit = $this->m_token->get_all_saldo_user();

		$header = '<thead>
                        <tr>
                        	<th>No</th>
                            <th>Nama User</th>
                            <th>User Name</th>
                            <th>Saldo</th>
                            <th>Deposit Hari ini</th>
                            <th>Transaksi Hari Ini</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        	<th>No</th>
                            <th>Nama User</th>
                            <th>User Name</th>
                            <th>Saldo</th>
                            <th>Deposit Hari ini</th>
                            <th>Transaksi Hari Ini</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>';

		$no = 0;
    	if($data_penyakit != ""){
    		echo $header;
			foreach ($data_penyakit as $key) {
				echo '<tr>
                        <td>'.($no + 1).'</td>
                        <td>'.$key->nama_user.'</td>
                        <td>'.$key->username.'</td>
                        <td class="text-right">'.number_format($key->saldo).'</td>
                        <td class="text-right">'.number_format($key->deposit_today).'</td>
                        <td class="text-right">'.number_format($key->trx_today).'</td>
                        <td class="text-right">
                            <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Penambahan Deposit" onclick="addSaldo('."'".$key->nama_user."'".', '."'".$key->saldo."'".', '."'".$key->id_user."'".');"><i class="material-icons">edit</i></a>
                            <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Lihat Mutasi User" onclick="viewMutasi('."'".$key->id_user."'".');"><i class="material-icons">pageview</i></a>
                        </td>
                    </tr>';

                $no++;
			}
			echo '</tbody>';
		}
	}

	
}
