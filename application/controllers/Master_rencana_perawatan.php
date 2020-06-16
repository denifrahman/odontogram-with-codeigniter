<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_rencana_perawatan extends CI_Controller {

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
		$this->load->model('m_master_rencana_perawatan'); 
		$this->load->model('m_login'); 
		$this->load->library('session');  
		if(!$this->m_login->is_login()) redirect('login');  
	} 

	public function index()
	{
		$data['m_master_rencana_perawatan'] = $this->m_master_rencana_perawatan->get_all_rencana_perawatan();
		$data['header'] = 'header';
		$data['menu'] = 'menu';
		$data['script'] = 'script';
		$data['footer'] = 'footer';
		$this->load->view('master_rencana_perawatan', $data);
	}

	function add_rencana_perawatan(){
		// if($this->input->post('add_rencana_perawatan')){
		$nama		= $this->input->post('nama');
		$id_penyakit = $this->input->post('id_penyakit');

		$result = array();

			// $cek_nama = $this->m_master_rencana_perawatan->cek_nama($nama);

			// if(!$cek_nama){

	        				
			$data['add_rencana_perawatan'] = $this->m_master_rencana_perawatan->add_rencana_perawatan($nama, $id_penyakit);
   			
   			if($data['add_rencana_perawatan']){
   				$result = array(
   						"rc" => "0000",
   						"message" => "Master Rencana perawatan berhasil ditambahkan."
   					);
   			}
   			else {
				$result = array(
   						"rc" => "0001",
   						"message" => "Master Rencana perawatan gagal ditambahkan."
   					);
   			}

  //  		} else{
		// 	$result = array(
  //  						"rc" => "0002",
  //  						"message" => "Nama Rencana perawatan Sudah Ada!"
  //  					);
		// }


		echo json_encode($result);

	}

	function edit_rencana_perawatan(){

		$nama		= $this->input->post('nama');
		$id		= $this->input->post('id');
		$nama_lama	= $this->input->post('nama_lama');
		$id_penyakit = $this->input->post('id_penyakit');

		// $cek_kode = $this->m_master_rencana_perawatan->cek_kode($kode);

		$result = array();

		
		// if(!$cek_kode || $kode != $kode_lama){

		// 	$cek_nama = $this->m_master_rencana_perawatan->cek_nama($nama);

		// 	if(!$cek_nama || $nama != $nama_lama){
	        				
				$data['add_rencana_perawatan'] = $this->m_master_rencana_perawatan->edit_rencana_perawatan($id, $nama, $id_penyakit);
	   			
	   			if($data['add_rencana_perawatan']){
	   				$result = array(
	   						"rc" => "0000",
	   						"message" => "Master Rencana perawatan berhasil diperbarui."
	   					);
	   			}
	   			else {
					$result = array(
	   						"rc" => "0001",
	   						"message" => "Master Rencana perawatan gagal diperbarui."
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

	function delete_rencana_perawatan(){
		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$id=$objx['id'];

		$data['delete_rencana_perawatan'] = $this->m_master_rencana_perawatan->delete_rencana_perawatan($id);
			
		if($data['delete_rencana_perawatan']){
			$result = array(
					"rc" => "0000",
					"message" => "Master Rencana perawatan berhasil dihapus."
				);
		}
		else {
			$result = array(
					"rc" => "0001",
					"message" => "Master Rencana perawatan gagal dihapus."
				);
		}

		echo json_encode($result);

		// } else {

		// 	redirect(base_url().'master_user');

		// }
	}

	function get_rencana_perawatan_by_id(){
		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$id=$objx['id'];

		$data['get_rencana_perawatan'] = $this->m_master_rencana_perawatan->get_rencana_perawatan_by_id($id);
			
		if($data['get_rencana_perawatan']){
			// print_r(json_decode(json_encode($data['get_rencana_perawatan'][0]), true));
			$result = array_merge(json_decode(json_encode($data['get_rencana_perawatan'][0]), true), array(
					"rc" => "0000",
				));
			// $result = $data['get_rencana_perawatan'];
		}
		else {
			$result = array(
					"rc" => "0001",
					"message" => "Master Rencana perawatan tidak ditemukan."
				);
		}

		echo json_encode($result);

		// } else {

		// 	redirect(base_url().'master_user');

		// }
	}

	function getRencanaPerawatan(){
		$data_rencana_perawatan = $this->m_master_rencana_perawatan->get_all_rencana_perawatan();

		$header = '<thead>
                        <tr>
                        	<th>No</th>
                            <th>Nama</th>
                            <th>Penyakit</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        	<th>No</th>
                            <th>Nama</th>
                            <th>Penyakit</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>';

		$no = 0;
    	if($data_rencana_perawatan != ""){
    		echo $header;
			foreach ($data_rencana_perawatan as $key) {
				echo '<tr>
                            <td>'.($no + 1).'</td>
                            <td>'.$key->nama.'</td>
                            <td>'.$key->nama_penyakit.'</td>
                            <td class="text-right">
                                <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editRencanaPerawatan('.$key->id.');"><i class="material-icons">edit</i></a>
                                <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove"  onclick="deleteRencanaPerawatan('.$key->id.', '."'".$key->nama."'".');"><i class="material-icons">close</i></a>
                            </td>
                        </tr>';

                $no++;
			}
			echo '</tbody>';
		}
	} 

	function getRencanaPerawatanByPenyakitSelect2(){
		$result = array();
		if ($this->input->post('id')) {
			# code...
			$id		= $this->input->post('id');
			$data_penyakit = $this->m_master_rencana_perawatan->get_all_rencana_perawatan_by_penyakit($id);
			if($data_penyakit != ""){
				$result = $data_penyakit;
			}
		}

		echo json_encode($result);
	}
}
