<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_penyakit extends CI_Controller {

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
		$this->load->model('m_master_penyakit'); 
		$this->load->model('m_login'); 
		$this->load->library('session');  
		if(!$this->m_login->is_login()) redirect('login');  
	} 

	public function index()
	{
		$data['m_penyakit'] = $this->m_master_penyakit->get_all_penyakit();
		$data['header'] = 'header';
		$data['menu'] = 'menu';
		$data['script'] = 'script';
		$data['footer'] = 'footer';
		$this->load->view('master_penyakit', $data);
	}

	function add_penyakit(){
		// if($this->input->post('add_penyakit')){
		$nama		= $this->input->post('nama');
		$kode	= $this->input->post('kode');

		// $harga	= $this->input->post('harga');
		// $id_bidang_ilmu = $this->input->post('id_bidang_ilmu');

		$cek_kode = $this->m_master_penyakit->cek_kode($kode);

		$result = array();

		
		if(!$cek_kode){

			$cek_nama = $this->m_master_penyakit->cek_nama($nama);

			if(!$cek_nama){

	        				
				$data['add_penyakit'] = $this->m_master_penyakit->add_penyakit($nama, $kode);
	   			
	   			if($data['add_penyakit']){
	   				$result = array(
	   						"rc" => "0000",
	   						"message" => "Master Penyakit berhasil ditambahkan."
	   					);
	   			}
	   			else {
					$result = array(
	   						"rc" => "0001",
	   						"message" => "Master Penyakit gagal ditambahkan."
	   					);
	   			}

	   		} else{
				$result = array(
	   						"rc" => "0002",
	   						"message" => "Nama Penyakit Sudah Ada!"
	   					);
			}

		} else{
			$result = array(
   						"rc" => "0003",
   						"message" => "Kode Penyakit Sudah Ada!"
   					);
		}

		echo json_encode($result);

	}

	function edit_penyakit(){

		$nama		= $this->input->post('nama');
		$id		= $this->input->post('id');
		$kode	= $this->input->post('kode');
		// $harga	= $this->input->post('harga');
		$kode_lama	= $this->input->post('kode_lama');
		$nama_lama	= $this->input->post('nama_lama');
		// $id_bidang_ilmu = $this->input->post('id_bidang_ilmu');

		// $cek_kode = $this->m_master_penyakit->cek_kode($kode);

		$result = array();

		
		// if(!$cek_kode || $kode != $kode_lama){

		// 	$cek_nama = $this->m_master_penyakit->cek_nama($nama);

		// 	if(!$cek_nama || $nama != $nama_lama){
	        				
				$data['add_penyakit'] = $this->m_master_penyakit->edit_penyakit($id, $nama, $kode);
	   			
	   			if($data['add_penyakit']){
	   				$result = array(
	   						"rc" => "0000",
	   						"message" => "Master Penyakit berhasil diperbarui."
	   					);
	   			}
	   			else {
					$result = array(
	   						"rc" => "0001",
	   						"message" => "Master Penyakit gagal diperbarui."
	   					);
	   			}
	 //   		} else{
		// 		$result = array(
	 //   						"rc" => "0002",
	 //   						"message" => "Nama Penyakit Sudah Ada!"
	 //   					);
		// 	}

		// } else{
		// 	$result = array(
  //  						"rc" => "0003",
  //  						"message" => "Kode Penyakit Sudah Ada!"
  //  					);
		// }

		echo json_encode($result);

	}

	function delete_penyakit(){
		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$id=$objx['id'];

		$data['delete_penyakit'] = $this->m_master_penyakit->delete_penyakit($id);
			
		if($data['delete_penyakit']){
			$result = array(
					"rc" => "0000",
					"message" => "Master Penyakit berhasil dihapus."
				);
		}
		else {
			$result = array(
					"rc" => "0001",
					"message" => "Master Penyakit gagal dihapus."
				);
		}

		echo json_encode($result);

		// } else {

		// 	redirect(base_url().'master_user');

		// }
	}

	function get_penyakit_by_id(){
		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$id=$objx['id'];

		$data['get_penyakit'] = $this->m_master_penyakit->get_penyakit_by_id($id);
			
		if($data['get_penyakit']){
			// print_r(json_decode(json_encode($data['get_penyakit'][0]), true));
			$result = array_merge(json_decode(json_encode($data['get_penyakit'][0]), true), array(
					"rc" => "0000",
				));
			// $result = $data['get_penyakit'];
		}
		else {
			$result = array(
					"rc" => "0001",
					"message" => "Master Penyakit tidak ditemukan."
				);
		}

		echo json_encode($result);

		// } else {

		// 	redirect(base_url().'master_user');

		// }
	}

	function getPenyakit(){
		$data_penyakit = $this->m_master_penyakit->get_all_penyakit();

		$header = '<thead>
                        <tr>
                        	<th>No</th>
                            <th>Kode</th>
                            <th>Diagnosa</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        	<th>No</th>
                            <th>Kode</th>
                            <th>Diagnosa</th>
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
                            <td>'.$key->kode.'</td>
                            <td>'.$key->nama.'</td>
                            <td class="text-right">
                                <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editPenyakit('.$key->id.');"><i class="material-icons">edit</i></a>
                                <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove"  onclick="deletePenyakit('.$key->id.', '."'".$key->nama."'".');"><i class="material-icons">close</i></a>
                            </td>
                        </tr>';

                $no++;
			}
			echo '</tbody>';
		}
	}

	function getPenyakitSelect2(){
		$data_penyakit = $this->m_master_penyakit->get_all_penyakit();
		$result = array();
		if($data_penyakit != ""){
			$result = $data_penyakit;
		}

		echo json_encode($result);
	}

	function getPenyakitByBidangIlmuSelect2(){
		$result = array();
		if ($this->input->post('id')) {
			# code...
			$id		= $this->input->post('id');
			$data_penyakit = $this->m_master_penyakit->get_all_penyakit_by_bidang_ilmu($id);
			if($data_penyakit != ""){
				$result = $data_penyakit;
			}
		}

		echo json_encode($result);
	}
}
