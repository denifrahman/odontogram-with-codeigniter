<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_bidang_ilmu extends CI_Controller {

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
		$this->load->model('m_master_bidang_ilmu'); 
		$this->load->model('m_login'); 
		$this->load->library('session');  
		if(!$this->m_login->is_login()) redirect('login');  
	} 

	public function index()
	{
		$data['m_bidang_ilmu'] = $this->m_master_bidang_ilmu->get_all_bidang_ilmu();
		$data['header'] = 'header';
		$data['menu'] = 'menu';
		$data['script'] = 'script';
		$data['footer'] = 'footer';
		$this->load->view('master_bidang_ilmu', $data);
	}

	function add_bidang_ilmu(){
		// if($this->input->post('add_bidang_ilmu')){
		$nama		= $this->input->post('nama');
		$kode	= $this->input->post('kode');

		$cek_kode = $this->m_master_bidang_ilmu->cek_kode($kode);

		$result = array();

		
		if(!$cek_kode){

			$cek_nama = $this->m_master_bidang_ilmu->cek_nama($nama);

			if(!$cek_nama){

	        				
				$data['add_bidang_ilmu'] = $this->m_master_bidang_ilmu->add_bidang_ilmu($nama, $kode);
	   			
	   			if($data['add_bidang_ilmu']){
	   				$result = array(
	   						"rc" => "0000",
	   						"message" => "Master Departemen berhasil ditambahkan."
	   					);
	   			}
	   			else {
					$result = array(
	   						"rc" => "0001",
	   						"message" => "Master Departemen gagal ditambahkan."
	   					);
	   			}

	   		} else{
				$result = array(
	   						"rc" => "0002",
	   						"message" => "Nama Departemen Sudah Ada!"
	   					);
			}

		} else{
			$result = array(
   						"rc" => "0003",
   						"message" => "Kode Departemen Sudah Ada!"
   					);
		}

		echo json_encode($result);

	}

	function edit_bidang_ilmu(){

		$nama		= $this->input->post('nama');
		$id		= $this->input->post('id');
		$kode	= $this->input->post('kode');
		$kode_lama	= $this->input->post('kode_lama');
		$nama_lama	= $this->input->post('nama_lama');

		// $cek_kode = $this->m_master_bidang_ilmu->cek_kode($kode);

		$result = array();

		
		// if(!$cek_kode || $kode != $kode_lama){

		// 	$cek_nama = $this->m_master_bidang_ilmu->cek_nama($nama);

		// 	if(!$cek_nama || $nama != $nama_lama){
	        				
				$data['add_bidang_ilmu'] = $this->m_master_bidang_ilmu->edit_bidang_ilmu($id, $nama, $kode);
	   			
	   			if($data['add_bidang_ilmu']){
	   				$result = array(
	   						"rc" => "0000",
	   						"message" => "Master Departemen berhasil diperbarui."
	   					);
	   			}
	   			else {
					$result = array(
	   						"rc" => "0001",
	   						"message" => "Master Departemen gagal diperbarui."
	   					);
	   			}
	 //   		} else{
		// 		$result = array(
	 //   						"rc" => "0002",
	 //   						"message" => "Nama bidang_ilmu Sudah Ada!"
	 //   					);
		// 	}

		// } else{
		// 	$result = array(
  //  						"rc" => "0003",
  //  						"message" => "Kode bidang_ilmu Sudah Ada!"
  //  					);
		// }

		echo json_encode($result);

	}

	function delete_bidang_ilmu(){
		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$id=$objx['id'];

		$data['delete_bidang_ilmu'] = $this->m_master_bidang_ilmu->delete_bidang_ilmu($id);
			
		if($data['delete_bidang_ilmu']){
			$result = array(
					"rc" => "0000",
					"message" => "Master Departemen berhasil dihapus."
				);
		}
		else {
			$result = array(
					"rc" => "0001",
					"message" => "Master Departemen gagal dihapus."
				);
		}

		echo json_encode($result);

		// } else {

		// 	redirect(base_url().'master_user');

		// }
	}

	function get_bidang_ilmu_by_id(){
		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$id=$objx['id'];

		$data['get_bidang_ilmu'] = $this->m_master_bidang_ilmu->get_bidang_ilmu_by_id($id);
			
		if($data['get_bidang_ilmu']){
			// print_r(json_decode(json_encode($data['get_bidang_ilmu'][0]), true));
			$result = array_merge(json_decode(json_encode($data['get_bidang_ilmu'][0]), true), array(
					"rc" => "0000",
				));
			// $result = $data['get_bidang_ilmu'];
		}
		else {
			$result = array(
					"rc" => "0001",
					"message" => "Master Departemen tidak ditemukan."
				);
		}

		echo json_encode($result);

		// } else {

		// 	redirect(base_url().'master_user');

		// }
	}

	function getBidangIlmu(){
		$data_bidang_ilmu = $this->m_master_bidang_ilmu->get_all_bidang_ilmu();

		$header = '<thead>
                        <tr>
                        	<th>No</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        	<th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>';

		$no = 0;
    	if($data_bidang_ilmu != ""){
    		echo $header;
			foreach ($data_bidang_ilmu as $key) {
				echo '<tr>
                            <td>'.($no + 1).'</td>
                            <td>'.$key->kode.'</td>
                            <td>'.$key->nama.'</td>
                            <td class="text-right">
                                <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editBidangIlmu('.$key->id.');"><i class="material-icons">edit</i></a>
                                <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove"  onclick="deleteBidangIlmu('.$key->id.', '."'".$key->nama."'".');"><i class="material-icons">close</i></a>
                            </td>
                        </tr>';

                $no++;
			}
			echo '</tbody>';
		}
	}

	function getBidangIlmuSelect2(){
		$data_bidang_ilmu = $this->m_master_bidang_ilmu->get_all_bidang_ilmu();
		$result = array();
		if($data_bidang_ilmu != ""){
			$result = $data_bidang_ilmu;
		}

		echo json_encode($result);
	}

}
?>
