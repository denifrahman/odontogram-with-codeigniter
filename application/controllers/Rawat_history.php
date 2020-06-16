<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rawat_history extends CI_Controller {

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
		$toDate = date("Y-m-d");
		$fromDate = date("Y-m-d", strtotime("-1 month"));

		if($this->input->post('cari')){
			$toDate = $this->input->post('toDate');
			$fromDate = $this->input->post('fromDate');
		}

		$role = $this->session->userdata('role');
		$id = "";
		$filter = "";
		if ($role == "DOKTER_MUDA") {
			$id = $this->session->userdata('id');
			$username = $this->session->userdata('username');
			$filter = "AND (rd.id_dokter = '$id'
						OR r.user_ins = '$username')";
		} else if ($role == "MAHASISWA") {
			$username = $this->session->userdata('username');
			$filter = "AND r.user_ins = '$username'";
		}
		
		$data['fromDate'] = $fromDate;
		$data['toDate'] = $toDate;
		$data['m_rawat'] = $this->m_rawat->history($toDate, $fromDate, $filter);
		$data['header'] = 'header';
		$data['menu'] = 'menu';
		$data['script'] = 'script';
		$data['footer'] = 'footer';
		$this->load->view('rawat_history', $data);
	}

	function delete_rawat(){
	if ($this->session->userdata('role') == "ADMIN" || $this->session->userdata('role') == "DOKTER_MUDA" || $this->session->userdata('role') == "MAHASISWA" ) {
			$dtusr=trim(file_get_contents('php://input'));
			$objx=json_decode(trim($dtusr), true);
			$id=isset($objx['id']) ? $objx['id'] : "";
			$id_rawat=$objx['id_rawat'];
			$jmlDetailRawat = $this->m_rawat->jmlDetailRawatPerPasien($id_rawat);

			$jml_detail = (int)$jmlDetailRawat[0]->jml;
			// $id_rawat = $jmlDetailRawat[0]->id_rawat;

			if ($jml_detail > 1) {
				// echo "f";
				$data['delete'] = $this->m_rawat->delete_one_of_rawat_detail($id);
			} else if ($jml_detail == 1 && $objx['id'] != ""){
				// echo "s";
				$data['xx'] = $this->m_rawat->delete_rawat_detail($id_rawat);
				$data['delete'] = $this->m_rawat->delete_rawat($id_rawat);

			} else {
				// echo "a";
				$data['delete'] = $this->m_rawat->delete_rawat($id_rawat);
			}
				
			if($data['delete']){
				$result = array(
						"rc" => "0000",
						"message" => "Daftar Rawat pasien berhasil dihapus."
					);
			}
			else {
				$result = array(
						"rc" => "0001",
						"message" => "Daftar Rawat pasien gagal dihapus."
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

	function rawat_edit($id){
		$rawat = $this->m_rawat->get_one_rawat_by_id($id);
		$data_rawat = json_decode(json_encode($rawat[0]), true);
		$rawat_detail = $this->m_rawat->get_detail_rawat($data_rawat['id_rawat']);

		if ($rawat_detail) {
			$rawat = array_merge($data_rawat, array("detail_rawat" => json_decode(json_encode($rawat_detail), true)));
		} else {
			$rawat = array_merge($data_rawat, array("detail_rawat" => array()));
		}
		
		$data['rawat'] = $rawat;
		$data['header'] = 'header';
		$data['menu'] = 'menu';
		$data['script'] = 'script';
		$data['footer'] = 'footer';
		$this->load->view('rawat_edit', $data);
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
			$filter = "AND (rd.id_dokter = '$id'
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
                            <th>Nama Dokter</th>
                            <th>Tgl. Pilih</th>
                            <th>Tgl. Selesai</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        	<th>No</th>
                            <th>Tgl. Rawat</th>
                            <th>Nama Pasien</th>
                            <th>Diagnosa</th>
                            <th>Nama Dokter</th>
                            <th>Tgl. Pilih</th>
                            <th>Tgl. Selesai</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>';

		$no = 0;
    	if($data_rawat != ""){
    		echo $header;
			foreach ($data_rawat as $key) {
				$status = "";
				
				if ($key->status == "DAFTAR") {
					$status = '<button class="btn btn-info btn-xs" style="margin: 0;">DAFTAR</button>';
				} else if ($key->status == "RAWAT"){
					$status = '<button class="btn btn-warning btn-xs" style="margin: 0;">RAWAT</button>';
                } else if ($key->status == "MENUNGGU_DAFTAR"){
                    $status = '<button class="btn btn-xs" style="margin: 0;">MENUNGGU DAFTAR</button>';
                } else if ($key->status == "MENUNGGU_RAWAT"){
                    $status = '<button class="btn btn-rose btn-xs" style="margin: 0;">MENUNGGU RAWAT</button>';
                } else if ($key->status == "MENOLAK_RAWAT"){
                    $status = '<button class="btn btn-danger btn-xs" style="margin: 0;">MENOLAK RAWAT</button>';
				} else {
					$status = '<button class="btn btn-success btn-xs" style="margin: 0;">SELESAI</button>';
				}
				echo '<tr>
                            <td>'.($no + 1).'</td>
                            <td>'.$key->tgl_rawat.'</td>
                            <td>'.$key->nama_pasien.'</td>
                            <td>'.$key->nama_penyakit.'</td>
                            <td>'.$key->nama_dokter.'</td>
                            <td>'.$key->tgl_pilih.'</td>
                            <td>'.$key->tgl_selesai.'</td>
                            <td>'.$status.'</td>
                            <td class="text-right">
                                <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editRawat('.$key->id.');"><i class="material-icons">edit</i></a>';
                                if ($key->nama_penyakit) {
                                	echo '
                                <a href="#" class="btn btn-simple btn-success btn-icon edit" rel="tooltip" title="Print"  onclick="printPasien('.$key->id.');"><i class="material-icons">print</i></a>';
                            	}
                                if (!$key->id_dokter) {
                                 echo '
                                <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove"  onclick="deleteRawat('.$key->id_rawat.', '."'".$key->nama_pasien."'".', '.$key->id_detail.');"><i class="material-icons">close</i></a>';
                            }
                            echo '</td>';
                        echo '</tr>';

                $no++;
			}
			echo '</tbody>';
		}

	}

	function pagePrintPasien($id, $tipe){
		$data['id'] = $id;
		$data['header'] = 'header';
		$data['menu'] = 'menu';
		$data['script'] = 'script';
		$data['footer'] = 'footer';
		$this->load->view('print_pasien', $data);
	}

	function printPasien($id, $tipe){
		$data_pasien = $this->m_rawat->getPrintPasien($id);
		$result = "";
		if ($data_pasien) {
			$odonto = json_decode($data_pasien[0]->odontogram, true);
			$arrId4Sisi = array('dental13', 'dental12', 'dental11', 'dental21', 'dental22', 'dental23', 
						    'dental53', 'dental52', 'dental51', 'dental61', 'dental62', 'dental63',
						    'dental83', 'dental82', 'dental81', 'dental71', 'dental72', 'dental73',
						    'dental43', 'dental42', 'dental41', 'dental31', 'dental32', 'dental33');
			$jenis_kelamin = "";
			if ($data_pasien[0]->jenis_kelamin == "L") {
				$jenis_kelamin = "Laki - Laki";
			} else {
				$jenis_kelamin = "Perempuan";
			}

			$sistemik_pasien = "";
			if ($data_pasien[0]->sistemik_pasien == "tidakAda") {
				$sistemik_pasien = "Tidak Ada";
			} else if ($data_pasien[0]->sistemik_pasien == "diabetesMellitus") {
				$sistemik_pasien = "Diabetes Mellitus";
			} else if ($data_pasien[0]->sistemik_pasien == "penyakitKardivaskular") {
				$sistemik_pasien = "Penyakit Kardivaskular";
			} else if ($data_pasien[0]->sistemik_pasien == "gagalGinjalkronis") {
				$sistemik_pasien = "Gagal Ginjal Kronis";
			} else if ($data_pasien[0]->sistemik_pasien == "PenyakitHatikronis") {
				$sistemik_pasien = "Penyakit Hati Kronis";
			} else {
				$sistemik_pasien = $data_pasien[0]->sistemik_pasien;
			}

			// echo $data_pasien[0]->odontogram;
			if ($tipe == "print") {
				$result = '<h3 style="text-align: center;" id="header_print"><strong>BANK PASIEN <br>
								FAKULTAS KEDOKTERAN GIGI (FKG) <br>
								UNIVERSITAS AIRLANGGA SURABAYA
							</strong></h3>';
			}
				
				$result .=  '<table style="width:100%; border-spacing: 0px;">
	                    		<tr>
	                    			<td style="vertical-align: top; text-align: left; width:50%;">
										<table style="border-spacing: 0px;">
				                    		<tr>
				                    			<td style="width: 120px;">Nama Pasien</td>
				                    			<td style="width: 2px;">:</td>
				                    			<td>'.$data_pasien[0]->nama_pasien.'</td>
				                    		</tr>
				                    	</table>
				                    </td>
				                    <td style="vertical-align: top; padding-left:100px;">
	                    				<table style="border-spacing: 0px;">
	                    					<tr>
				                    			<td style="width: 120px;">Tgl. Input</td>
				                    			<td style="width: 2px;">:</td>
				                    			<td>'.$data_pasien[0]->tgl_rawat.'</td>
				                    		</tr>
	                    				</table>

	                    			</td>
				                <tr>
				                <tr>
	                    			<td style="vertical-align: top; text-align: left; width:50%;">
										<table style="border-spacing: 0px;">
				                    		<tr>
				                    			<td style="width: 120px;">Tgl. Lahir</td>
				                    			<td style="width: 2px;">:</td>
				                    			<td>'.$data_pasien[0]->umur_pasien.'</td>
				                    		</tr>
				                    	</table>
				                    </td>
				                    <td style="vertical-align: top; padding-left:100px;">
	                    				<table style="border-spacing: 0px;">
	                    					<tr>
				                    			<td style="width: 120px;">Penyakit Sistemik</td>
				                    			<td style="width: 2px;">:</td>
				                    			<td>'.$sistemik_pasien.'</td>
				                    		</tr>
	                    				</table>

	                    			</td>
				                <tr>
				                <tr>
	                    			<td style="vertical-align: top; text-align: left; width:50%;">
										<table style="border-spacing: 0px;">
				                    		<tr>
				                    			<td style="width: 120px;">Jenis Kelamin</td>
				                    			<td style="width: 2px;">:</td>
				                    			<td>'.$jenis_kelamin.'</td>
				                    		</tr>
				                    	</table>
				                    </td>
				                    <td style="vertical-align: top; padding-left:100px;">
	                    				<table style="border-spacing: 0px;">
	                    					<tr>
				                    			<td style="width: 120px;">No. Telp</td>
				                    			<td style="width: 2px;">:</td>
				                    			<td>'.$data_pasien[0]->notelp_pasien.'</td>
				                    		</tr>
	                    				</table>

	                    			</td>
	                    			
				                <tr>
				                <tr>
				                <td style="vertical-align: top; text-align: left; width:50%;">
	                    				<table style="border-spacing: 0px;">
	                    					<tr>
				                    			<td style="width: 120px;">Tingkat Kooperatif</td>
				                    			<td style="width: 2px;">:</td>
				                    			<td>'.$data_pasien[0]->tingkat_kooperatif.'</td>
				                    		</tr>
	                    				</table>

	                    			</td>
	                    		</tr>
				            </table>
				            <table style="width:100%; border-spacing: 0px;">
	                    		<tr>
	                    			<td>
							            <table style="border-spacing: 0px;">
				                    		<tr>
				                    			<td style="width: 120px;">Alamat</td>
				                    			<td style="width: 2px;">:</td>
				                    			<td>'.$data_pasien[0]->alamat_pasien.'</td>
				                    		</tr>
				                    		<tr>
				                    			<td>Diagnosa Pasien</td>
				                    			<td style="width: 2px;">:</td>
				                    			<td>'.$data_pasien[0]->nama_penyakit.'</td>
				                    		</tr>
				                    	</table>
				                    </td>
				                </tr>
				            </table>
				            <table style="width:100%; border-spacing: 0px;">
	                    		<tr>
	                    			<td>
							            <table style="border-spacing: 0px;">

				                    		<tr>
				                    			<td style="width: 25%; vertical-align: top;">
				                    				Foto Pasien : <br>
				                    				<img src="'.($data_pasien[0]->foto_pasien == "" ? "-" : site_url()."assets/img/pasien/".$data_pasien[0]->foto_pasien).'"  width="200px"/>
				                    			</td>
				                    			<td style="width: 25%; vertical-align: top;">
				                    				Foto Pasien : <br>
				                    				<img src="'.($data_pasien[0]->rahang_atas == "" ? "-" : site_url()."assets/img/pasien/".$data_pasien[0]->rahang_atas).'" width="200px"/>
				                    			</td>
				                    			<td style="width: 25%; vertical-align: top;">
				                    				Foto Pasien : <br>
				                    				<img src="'.($data_pasien[0]->rahang_bawah == "" ? "-" : site_url()."assets/img/pasien/".$data_pasien[0]->rahang_bawah).'" width="200px"/>
				                    			</td>
				                    			<td style="width: 25%;  vertical-align: top;">
				                    				Foto Pasien : <br>
				                    				<img src="'.($data_pasien[0]->tambahan == "" ? "-" : site_url()."assets/img/pasien/".$data_pasien[0]->tambahan).'" width="200px" id="foto_tambahan_pasien"/>
				                    			</td>
				                    		</tr>
				                    	</table>
				                    </td>
				                </tr>
				            </table>
				            <table style="width:100%; border-spacing: 0px;">
	                    		<tr>
	                    			<td>
							            <table style="border-spacing: 0px;">
				                    		<tr>
				                    			<td style="vertical-align: top; width: 120px;">Odontogram</td>
				                    			<td style="vertical-align: top; width: 2px;">:</td>
				                    			<td></td>
				                    		</tr>
				                    		<tr>
				                    			<td colspan="3">
				                    				<table style="border-spacing: 0px;">
				                    					<tr>
							                    			<td>
							                    				<div id="svgselect" style="width: 610px; height: 230px; background-color: #ffffff;"> 
			                                                        <svg version="1.1" height="100%" width="100%" style="overflow-x: scroll;">
			                                                            <g transform="scale(1.5)" id="odontograma">';
			                                                            for ($i = 0; $i < count($odonto); $i++) {
			                                                            	// print_r($odonto[$i]['id']);
			                                                            	if (in_array($odonto[$i]['id'], $arrId4Sisi)) {
			                                                            		$result .= '<g id="'.$odonto[$i]['id'].'" transform="translate('.$odonto[$i]['transform1'].','.$odonto[$i]['transform2'].')">
																                        <polygon points="0,0   20,0    15,10    0,10" fill="'.$odonto[$i]['data']['T'].'" stroke="navy" stroke-width="0.5" id="T" opacity="1"></polygon>
																                        <polygon points="5,10  15,10   20,20   0,20" fill="'.$odonto[$i]['data']['B'].'" stroke="navy" stroke-width="0.5" id="B" opacity="1"></polygon>
																                        <polygon points="20,0  20,0    20,20   15,10" fill="'.$odonto[$i]['data']['R'].'" stroke="navy" stroke-width="0.5" id="R" opacity="1"></polygon>
																                        <polygon points="0,0   5,10     5,10    0,20" fill="'.$odonto[$i]['data']['L'].'" stroke="navy" stroke-width="0.5" id="L" opacity="1"></polygon>
																                        <text x="6" y="30" stroke="navy" fill="navy" stroke-width="0.1" style="font-size: 6pt;font-weight:normal">'.$odonto[$i]['title'].'</text>
																                    </g>';
			                                                            	} else {
			                                                            		$result .= '<g id="'.$odonto[$i]['id'].'" transform="translate('.$odonto[$i]['transform1'].','.$odonto[$i]['transform2'].')">
																                        <polygon points="5,5   15,5    15,15   5,15" fill="'.$odonto[$i]['data']['C'].'" stroke="navy" stroke-width="0.5" id="C" opacity="1"></polygon>
																                        <polygon points="0,0   20,0    15,5    5,5" fill="'.$odonto[$i]['data']['T'].'" stroke="navy" stroke-width="0.5" id="T" opacity="1"></polygon>
																                        <polygon points="5,15  15,15   20,20   0,20" fill="'.$odonto[$i]['data']['B'].'" stroke="navy" stroke-width="0.5" id="B" opacity="1"></polygon>
																                        <polygon points="15,5  20,0    20,20   15,15" fill="'.$odonto[$i]['data']['R'].'" stroke="navy" stroke-width="0.5" id="R" opacity="1"></polygon>
																                        <polygon points="0,0   5,5     5,15    0,20" fill="'.$odonto[$i]['data']['L'].'" stroke="navy" stroke-width="0.5" id="L" opacity="1"></polygon>
																                        <text x="6" y="30" stroke="navy" fill="navy" stroke-width="0.1" style="font-size: 6pt;font-weight:normal">'.$odonto[$i]['title'].'</text>
																                    </g>';
			                                                            	}
			                                                            }
			                                                     $result .= '</g>
			                                                        </svg>
			                                                    </div>
			                                                </td>
							                    			<td>';
							                    				if ($tipe == "detail") {
							                    				$result .= '<div id="controls" class="panel panel-default">
                                                                    <div class="panel-body">
                                                                        <label class="label-control">Kategori</label>
                                                                        <div class="btn-group list-group" data-toggle="buttons">
                                                                            
                                                                            <div id="kariesSuperfisia" class="btn btn-primary btn-xs list-group-item active" style="width: 100%; background-color: yellow; color: black;">
                                                                                <input type="radio" name="options" id="option2" autocomplete="off" checked> Karies Superfisial
                                                                            </div>
                                                                            <div id="kariesMedia" class="btn btn-warning btn-xs list-group-item" style="width: 100%; background-color: orange; color: black;">
                                                                                <input type="radio" name="options" id="option3" autocomplete="off"> Karies media
                                                                            </div>
                                                                            <div id="kariesProfunda" class="btn btn-warning btn-xs list-group-item" style="width: 100%; background-color: red; color: black;">
                                                                                <input type="radio" name="options" id="option4" autocomplete="off"> Karies profunda
                                                                            </div>
                                                                            <div id="kariesProfundaPerfores" class="btn btn-primary btn-xs list-group-item" style="width: 100%; background-color: gray;color: black; ">
                                                                                <input type="radio" name="options" id="option5" autocomplete="off"> Karies profunda perforasi
                                                                            </div>
                                                                            <div id="sisaAkar" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: purple; ">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> Sisa akar
                                                                            </div>
                                                                            <div id="pitFissuredalam" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: #6495ED; color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> pit fissure dalam
                                                                            </div>
                                                                            <div id="kariesMangkok" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: blue; color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> karies mangkok
                                                                            </div>
                                                                            <div id="gigiGoyang" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: #7FFF00; color: black; ">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> gigi goyang
                                                                            </div>
                                                                            <div id="presistensi" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: pink; color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> presistensi
                                                                            </div>
                                                                            <div id="tambalanRestoras" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> tambalan / restoras
                                                                            </div>
                                                                            <div id="gigiHilang" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: #228B22; color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> gigi hilang
                                                                            </div>
                                                                            <div id="resesiGingiva" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: brown; ">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> resesi gingiva
                                                                            </div>
                                                                            <div id="karangGigi" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: #191970; ">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> Karang Gigi
                                                                            </div>
                                                                        </div>  
                                                                    </div>
                                                                </div>';
                                                            	}
							                    			$result .= '</td>
							                    		</tr>
							                    	</table>
                                                </td>

				                    		</tr>
				                    	</table>
							        </td>
							    </tr>
							</table>';
		} else {
			$result = "GAGAL GET DATA PASIEN";
		}
		echo $result;
	}


}
?>