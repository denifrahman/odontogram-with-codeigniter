<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rawat_verifikasi extends CI_Controller {

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
		$this->load->model('m_rawat'); 
		$this->load->model('m_login'); 
		$this->load->library('session');  
		if(!$this->m_login->is_login()) redirect('login');  
	} 

	public function index()
	{
		if ($this->session->userdata('role') == "ADMIN" || $this->session->userdata('role') == "VERIFIKATOR") {
				# code...
			$toDate = date("Y-m-d");
			$fromDate = date("Y-m-d", strtotime("-1 month"));

			if($this->input->post('cari')){
				$toDate = $this->input->post('toDate');
				$fromDate = $this->input->post('fromDate');
			}

			$role = $this->session->userdata('role');
			$id = "";
			$filter = "";
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			$data['m_rawat'] = $this->m_rawat->history($toDate, $fromDate, $filter);
			$data['header'] = 'header';
			$data['menu'] = 'menu';
			$data['script'] = 'script';
			$data['footer'] = 'footer';
			$this->load->view('rawat_verifikasi', $data);
		} else {
			redirect("dashboard");
		}
	}



	function getDetailPasien(){
		if ($this->session->userdata('role') == "ADMIN" || $this->session->userdata('role') == "VERIFIKATOR" ) {
			$dtusr=trim(file_get_contents('php://input'));
			$objx=json_decode(trim($dtusr), true);
			$id=isset($objx['id']) ? $objx['id'] : "";
			$data_pasien = $this->m_rawat->getDetailVerifikasi($id);
			if ($data_pasien) {
				$data_user = json_decode(json_encode($data_pasien[0]), true);

				$result = array_merge($data_user, array(
						"rc" => "0000",
					));
			} else {
				$result = array(
						"rc" => "0001",
						"message" => "Gagal get data pasien."
					);
			}

		} else {
			$result = array(
						"rc" => "0002",
						"message" => "Anda bukan admin."
					);
		}

		echo json_encode($result);
	}


	function update_verifikasi() {
		$role = $this->session->userdata('role');
		$id = "";
		$filter = "";
		if ($role == "VERIFIKATOR" || $role == "ADMIN") {
			$dtusr=trim(file_get_contents('php://input'));
			$objx=json_decode(trim($dtusr), true);
			$id=$objx['id'];
			$action=$objx['action'];

			if ($action == "yes") {
				$data['pilihPasien'] = $this->m_rawat->updateStatusVerifikasi($id, 1);
			} else if ($action == "no") {
				$data['pilihPasien'] = $this->m_rawat->updateStatusVerifikasi($id, 0);
			} else {
				exit();
			}  			

   			if($data['pilihPasien']){
   				$result = array(
   						"rc" => "0000",
   						"message" => "Pasien berhasil diverifikasi."
   					);
   			}
   			else {
				$result = array(
   						"rc" => "0001",
   						"message" => "Pasien gagal diverifikasi."
  					);
   			}
		} else {
			$result = array(
   						"rc" => "0001",
   						"message" => "Pasien gagal diverifikasi."
   					);
		}
		echo json_encode($result);
	}

	function getRawat(){

		$dtusr=trim(file_get_contents('php://input'));
		$objx=json_decode(trim($dtusr), true);
		$dari=$objx['dari'];
		$sampai=$objx['sampai'];

		$toDate = date("Y-m-d");
		$fromDate = date("Y-m-d", strtotime("-1 month"));

		if(isset($objx['dari'])){
			$toDate = $objx['sampai'];
			$fromDate = $objx['dari'];
		}

		$role = $this->session->userdata('role');
		$id = "";
		$filter = "";
		if ($role == "DOKTER_MUDA") {
			$id = $this->session->userdata('id');
			$username = $this->session->userdata('username');
			$filter = "AND (r.id_dokter = '$id'
						OR r.user_ins = '$username')";
		} else if ($role == "MAHASISWA") {
			$username = $this->session->userdata('username');
			$filter = "AND r.user_ins = '$username'";
		}
		$data_rawat = $this->m_rawat->history($toDate, $fromDate, $filter);


		$header = '<thead>
                        <tr>
                        	<th>No</th>
                            <th>Tgl. Rawat</th>
                            <th>Nama Pasien</th>
                            <th>Diagnosa</th>
                            <th>Status</th>
                            <th>Verifikasi</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        	<th>No</th>
                            <th>Tgl. Rawat</th>
                            <th>Nama Pasien</th>
                            <th>Diagnosa</th>
                            <th>Status</th>
                            <th>Verifikasi</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>';

		$no = 0;
    	if($data_rawat != ""){
    		echo $header;
			foreach ($data_rawat as $key) {
				if ($key->status != "MENUNGGU_DAFTAR") {
                    $verifikasion = "";
                    if ($key->verifikasi == "1") {
                        $verifikasion = '<button class="btn btn-success btn-xs btn-fab btn-fab-mini" style="margin: 0;"><i class="material-icons">check</i></button>';
                    } else if ($key->verifikasi == "0"){
                        $verifikasion = '<button class="btn btn-danger btn-xs btn-fab btn-fab-mini" style="margin: 0;"><i class="material-icons">close</i></button>';
                    }
                    $status = "";
                    if ($key->status == "DAFTAR") {
                        $status = '<button class="btn btn-info btn-xs" style="margin: 0;">DAFTAR</button>';
                    } else if ($key->status == "RAWAT"){
                        $status = '<button class="btn btn-warning btn-xs" style="margin: 0;">RAWAT</button>';
                    } else if ($key->status == "MENUNGGU_DAFTAR"){
                        $status = '<button class="btn btn-xs" style="margin: 0;">MENUNGGU DAFTAR</button>';
                    } else if ($key->status == "MENUNGGU_RAWAT"){
                        $status = '<button class="btn btn-rose btn-xs" style="margin: 0;">MENUNGGU RAWAT</button>';
                    } else {
                        $status = '<button class="btn btn-success btn-xs" style="margin: 0;">SELESAI</button>';
                    }
                    echo '<tr>
                                <td>'.($no + 1).'</td>
                                <td>'.$key->tgl_rawat.'</td>
                                <td>'.$key->nama_pasien.'</td>
                                <td>'.$key->nama_penyakit.'</td>
                                <td>'.$status.'</td>
                                <td>'.$verifikasion.'</td>
                                <td class="text-right">';
                                    if ($key->status == "DAFTAR") {
                                    echo '<a href="#" class="btn btn-simple btn-info btn-icon edit" rel="tooltip" title="Verifikasi" onclick="verifikasiPasien('.$key->id_detail.');"><i class="material-icons" style="font-size: 30px">offline_pin</i></a>';
                                   }
                                    echo    '<a href="#" class="btn btn-simple btn-info btn-icon edit" rel="tooltip" title="Detail Pasien" data-placement="top" onclick="verifikasiPasien('.$key->id_detail.', '."'detail'".');"><i class="material-icons" style="font-size: 30px">pageview</i></a>';

                                echo '</td>';
                            echo '</tr>';

                    $no++;
                }
			}
			echo '</tbody>';
		}

	}
}
?>