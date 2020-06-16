<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Rawat_pilih extends CI_Controller {



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

		

		$id = $this->session->userdata('id');



		$data['m_rawat'] = $this->m_rawat->rawat_terpilih($id);



		$data['header'] = 'header';

		$data['menu'] = 'menu';

		$data['script'] = 'script';

		$data['footer'] = 'footer';

		$this->load->view('rawat_pilih', $data);

	}



	function getPasien(){



		$dtusr=trim(file_get_contents('php://input'));

		$objx=json_decode(trim($dtusr), true);

		$id_penyakit=$objx['id_penyakit'];

		

		$data_rawat = $this->m_rawat->cari_outsanding_pasien($id_penyakit);





		$header = '<thead>

                        <tr>

                        	<th>No</th>

                            <th>Tgl. Rawat</th>

                            <th>Nama Pasien</th>

                            <th>Diagnosa</th>
                            <th>Harga</th>
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
                            <th>Harga</th>
                            <th>Verifikasi</th>

                            <th class="text-right">Actions</th>

                        </tr>

                    </tfoot>

                    <tbody>';



		$no = 0;

    	if($data_rawat != ""){

    		echo $header;

			foreach ($data_rawat as $key) {
				$verifikasion = "";
                if ($key->verifikasi == "1") {
                    $verifikasion = '<button class="btn btn-success btn-xs btn-fab btn-fab-mini" style="margin: 0;"><i class="material-icons">check</i></button>';
                } else if ($key->verifikasi == "0"){
                    $verifikasion = '<button class="btn btn-danger btn-xs btn-fab btn-fab-mini" style="margin: 0;"><i class="material-icons">close</i></button>';
                }

				echo '<tr>

                            <td>'.($no + 1).'</td>

                            <td>'.$key->tgl_rawat.'</td>

                            <td>'.$key->nama_pasien.'</td>

                            <td>'.$key->nama_penyakit.'</td>
                            <td>'.number_format($key->harga).'</td>
                            <td>'.$verifikasion.'</td>

                            <td class="text-right">
                            	<a href="#" class="btn btn-info btn-xs" rel="tooltip" title="Detail Pasien" data-placement="bottom" onclick="detailOdontoPasien('.$key->id.');">Detail</a>
	                            <a href="#" class="btn btn-success btn-xs" rel="tooltip" title="Pilih Pasien" data-placement="bottom" onclick="pilihPasien('.$key->id.');">Pilih</a>

	                        </td>

                        </tr>';



                $no++;

			}

			echo '</tbody>';

		}



	}



	function pilihPasien() {

		$role = $this->session->userdata('role');

		$id = "";

		$filter = "";

		if ($role == "DOKTER_MUDA" || $role == "ADMIN") {

			$dtusr=trim(file_get_contents('php://input'));

			$objx=json_decode(trim($dtusr), true);

			$id=$objx['id'];



			$id_dokter = $this->session->userdata('id');
			$user_update	= $this->session->userdata("username");

			$tgl_pilih = date("Y-m-d");



			$jmlRawatPasien = $this->m_rawat->jmlRawatPasien($id_dokter);



			$jml_pasien = (int)$jmlRawatPasien[0]->jml;



			if ($jml_pasien < 3) {

			
				$cek_update = $this->m_rawat->cek_update_pasien($id);

				if ($cek_update) {
					$this->load->model('m_token');


					$data_id_rawat = $this->m_rawat->get_detail_rawat_by_id($id);
					$id_trx = $data_id_rawat[0]->id_rawat."-".$id;
					$nominal = $data_id_rawat[0]->harga;

					$saldo_admin = $this->m_token->getSaldoUser($id_dokter);

				    if ($saldo_admin[0]->saldo < $nominal) {
				    	$result = array(
								"rc" => "0001",
								"message" => "Saldo anda tidak cukup untuk memilih pasien ini."
							);
				    	echo json_encode($result);
				    	exit();
				    }
					$ket = "RAWAT PASIEN";
					//motong saldo
					$data['saldo'] = $this->m_token->allocateDeposit($user_update, $ket, $nominal, 0, 'OUT', $id_trx, 0, $id_dokter);
					//pilih pasien
					$data['pilihPasien'] = $this->m_rawat->pilihPasien($id, $id_dokter, $tgl_pilih);

		   			if($data['pilihPasien']){

		   				$result = array(

		   						"rc" => "0000",

		   						"message" => "Pasien berhasil dipilih. ". $data_id_rawat[0]->id_rawat

		   					);

		   			} else {

						$result = array(

		   						"rc" => "0001",

		   						"message" => "Pasien gagal dipilih."

		   					);

		   			}

				} else {

					$result = array(

	   						"rc" => "0001",

	   						"message" => "Maaf, Pasien tidak tersedia."

	   					);

	   			}

	   		} else {

	   			$result = array(

	   						"rc" => "0001",

	   						"message" => "Anda sudah melampui batas maksimal perawatan pasien."

	   					);

	   		}



		} else {

			$result = array(

   						"rc" => "0001",

   						"message" => "Pasien gagal dipilih."

   					);

		}



		echo json_encode($result);



	}



	function getPasienTerpilih(){



		$id = $this->session->userdata('id');



		$data_rawat = $this->m_rawat->rawat_terpilih($id);





		$header = '<thead>

                        <tr>

                        	<th>No</th>

                            <th>Tgl. Rawat</th>

                            <th>Nama Pasien</th>

		                    <th>No. Telp Pasien</th>

                            <th>Diagnosa</th>

                            <th>Tgl. Pilih</th>

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

		                    <th>No. Telp Pasien</th>

                            <th>Diagnosa</th>

                            <th>Tgl. Pilih</th>

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

						    <td>'.$key->notelp_pasien.'</td>

                            <td>'.$key->nama_penyakit.'</td>

                            <td>'.$key->tgl_pilih.'</td>

                            <td>'.$status.'</td>
                            <td>'.$verifikasion.'</td>

                            <td class="text-right">
                            	<a href="#" class="btn btn-simple btn-info btn-icon edit" rel="tooltip" title="Detail Pasien" data-placement="bottom" onclick="detailOdontoPasienTerpilih('.$key->id.');"><i class="material-icons">pageview</i></a>
                            	<a href="#" class="btn btn-simple btn-success btn-icon edit" rel="tooltip" title="Print"  onclick="printPasien('.$key->id.');"><i class="material-icons">print</i></a>

	                            <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editPasienTerpilih('.$key->id.');"><i class="material-icons">edit</i></a>

	                        </td>

	                    </tr>';



                $no++;

			}

			echo '</tbody>';

		}



	}



	function get_rawat_by_id(){

		$dtusr=trim(file_get_contents('php://input'));

		$objx=json_decode(trim($dtusr), true);

		$id=$objx['id'];



		$data['rawat'] = $this->m_rawat->getRawatById($id);

			

		if($data['rawat']){

			// print_r(json_decode(json_encode($data['get_user'][0]), true));

			$result = array_merge(json_decode(json_encode($data['rawat'][0]), true), array(

					"rc" => "0000",

				));

			// $result = $data['get_user'];

		}

		else {

			$result = array(

					"rc" => "0001",

					"message" => "Data tidak ditemukan."

				);

		}



		echo json_encode($result);

	}





	function update_pasien_terpilih() {

		$role = $this->session->userdata('role');

		$id = "";

		$filter = "";

		if ($role == "DOKTER_MUDA" || $role == "ADMIN") {

			$dtusr=trim(file_get_contents('php://input'));

			$objx=json_decode(trim($dtusr), true);

			$id=$objx['id'];

			$action=$objx['action'];
			$id_dokter = $this->session->userdata('id');
			$user_update	= $this->session->userdata("username");



			$tgl_selesai = date("Y-m-d");

			if ($action == "APPROVE") {

				$data['pilihPasien'] = $this->m_rawat->updateStatusRawat($id, "RAWAT");

			} else if ($action == "SELESAI") {

				$data['pilihPasien'] = $this->m_rawat->updateSelesai($id, $tgl_selesai);

			} else if ($action == "HAPUS"){
				$this->load->model('m_token');

				$data_id_rawat = $this->m_rawat->get_detail_rawat_by_id($id);
				$id_trx = $data_id_rawat[0]->id_rawat."-".$id;
				$nominal = $data_id_rawat[0]->harga * -1;

				$ket = "REFUND PASIEN";
				//motong saldo
				$data['saldo'] = $this->m_token->allocateDeposit($user_update, $ket, $nominal, 0, 'OUT', $id_trx, 0, $id_dokter);

				$data['pilihPasien'] = $this->m_rawat->hapusOutsandingPasien($id);

			} else if ($action == "TOLAK"){
				$this->load->model('m_token');

				$data_id_rawat = $this->m_rawat->get_detail_rawat_by_id($id);
				$id_trx = $data_id_rawat[0]->id_rawat."-".$id;
				$nominal = $data_id_rawat[0]->harga * -1;

				$ket = "REFUND PASIEN";
				//motong saldo
				$data['saldo'] = $this->m_token->allocateDeposit($user_update, $ket, $nominal, 0, 'OUT', $id_trx, 0, $id_dokter);

				$data['pilihPasien'] = $this->m_rawat->pasienTolakRawat($data_id_rawat[0]->id_rawat, $id_dokter, $tgl_selesai);

			}

   			

   			if($data['pilihPasien']){

   				$result = array(

   						"rc" => "0000",

   						"message" => "Daftar Rawat berhasil diperbarui."

   					);

   			}

   			else {

				$result = array(

   						"rc" => "0001",

   						"message" => "Daftar Rawat gagal diperbarui."

   					);

   			}



		} else {

			$result = array(

   						"rc" => "0001",

   						"message" => "Daftar Rawat gagal diperbarui."

   					);

		}



		echo json_encode($result);



	}



	function get_detail_odonto_by_id(){

		$dtusr=trim(file_get_contents('php://input'));

		$objx=json_decode(trim($dtusr), true);

		$id=$objx['id'];



		$data['rawat'] = $this->m_rawat->get_detail_odonto_by_id($id);

			

		if($data['rawat']){

			// print_r(json_decode(json_encode($data['get_user'][0]), true));

			$result = array_merge(json_decode(json_encode($data['rawat'][0]), true), array(

					"rc" => "0000",

				));

			// $result = $data['get_user'];

		}

		else {

			$result = array(

					"rc" => "0001",

					"message" => "Data tidak ditemukan."

				);

		}



		echo json_encode($result);

	}





}

?>