<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pasien extends CI_Controller {

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
		$this->load->model('m_master_pasien'); 
		$this->load->model('m_login'); 
		$this->load->library('session');  
		if(!$this->m_login->is_login()) redirect('login');  
	} 

	public function index()
	{
		$data['m_user'] = $this->m_master_pasien->get_all_pasien();
		$data['header'] = 'header';
		$data['menu'] = 'menu';
		$data['script'] = 'script';
		$data['footer'] = 'footer';
		$this->load->view('master_pasien', $data);
	}

	function add_pasien(){
		// if($this->input->post('add_pasien')){

		$nama		= $this->input->post('nama');
		$no_telp	= $this->input->post('no_telp');
		$alamat		= $this->input->post('alamat');
		$tgl_lahir		= $this->input->post('tgl_lahir');
		$jenis_kelamin		= $this->input->post('jenis_kelamin');

		
	        				
			$data['add_pasien'] = $this->m_master_pasien->add_pasien($nama, $alamat, $tgl_lahir, $jenis_kelamin, $no_telp);
   			
   			if($data['add_pasien']){
   				$result = array(
   						"rc" => "0000",
   						"message" => "Master Diagnosa Pasien berhasil ditambahkan."
   					);
   			}
   			else {
				$result = array(
   						"rc" => "0001",
   						"message" => "Master Diagnosa Pasien gagal ditambahkan."
   					);
   			}

		

		echo json_encode($result);

	}

	function edit_pasien(){
		$nama		= $this->input->post('nama');
		$id		= $this->input->post('id');
		$no_telp	= $this->input->post('no_telp');
		$alamat		= $this->input->post('alamat');
		$tgl_lahir		= $this->input->post('tgl_lahir');
		$jenis_kelamin		= $this->input->post('jenis_kelamin');

		// $cek_username = $this->m_master_pasien->cek_username($username);

		$result = array();

		
		// if(!$cek_username){
	        				
			$data['add_pasien'] = $this->m_master_pasien->edit_pasien($id, $nama, $alamat, $tgl_lahir, $jenis_kelamin, $no_telp);
   			
   			if($data['add_pasien']){
   				$result = array(
   						"rc" => "0000",
   						"message" => "Master Diagnosa Pasien berhasil diperbarui."
   					);
   			}
   			else {
				$result = array(
   						"rc" => "0001",
   						"message" => "Master Diagnosa Pasien gagal diperbarui."
   					);
   			}

		echo json_encode($result);

	}

	function delete_pasien(){
		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$id=$objx['id'];

		$data['delete_pasien'] = $this->m_master_pasien->delete_pasien($id);
			
		if($data['delete_pasien']){
			$result = array(
					"rc" => "0000",
					"message" => "Master Diagnosa Pasien berhasil dihapus."
				);
		}
		else {
			$result = array(
					"rc" => "0001",
					"message" => "Master Diagnosa Pasien gagal dihapus."
				);
		}

		echo json_encode($result);
	}

	function get_pasien_by_id(){
		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$id=$objx['id'];

		$data['get_pasien'] = $this->m_master_pasien->get_pasien_by_id($id);
			
		if($data['get_pasien']){
			// print_r(json_decode(json_encode($data['get_pasien'][0]), true));
			$result = array_merge(json_decode(json_encode($data['get_pasien'][0]), true), array(
					"rc" => "0000",
				));
			// $result = $data['get_pasien'];
		}
		else {
			$result = array(
					"rc" => "0001",
					"message" => "Master Diagnosa Pasien gagal diambil."
				);
		}

		echo json_encode($result);
	}

	function getPasien(){
		$data_pasien = $this->m_master_pasien->get_all_pasien();

		$header = '<thead>
                        <tr>
                        	<th>No</th>
                            <th>Nama</th>
                            <th>Tgl Lahir</th>
                            <th>No. Telp</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        	<th>No</th>
                            <th>Nama</th>
                            <th>Tgl Lahir</th>
                            <th>No. Telp</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>';

		$no = 0;
    	if($data_pasien != ""){
    		echo $header;
			foreach ($data_pasien as $key) {
				$jenis_kelamin = "";
				if ($key->jenis_kelamin == "L") {
					$jenis_kelamin = "LAKI - LAKI";
				} else if ($key->jenis_kelamin == "P"){
					$jenis_kelamin = "PEREMPUAN";
				}
				echo '<tr>
                            <td>'.($no + 1).'</td>
                            <td>'.$key->nama.'</td>
                            <td>'.$key->tgl_lahir.'</td>
                            <td>'.$key->no_telp.'</td>
                            <td>'.$jenis_kelamin.'</td>
                            <td>'.$key->alamat.'</td>
                            <td class="text-right">
                                <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editPasien('.$key->id.');"><i class="material-icons">edit</i></a>
                                <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove"  onclick="deletePasien('.$key->id.', '."'".$key->nama."'".');"><i class="material-icons">close</i></a>
                            </td>
                        </tr>';

                $no++;
			}
			echo '</tbody>';
		}
	}
}
