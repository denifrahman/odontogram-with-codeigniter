<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Rawat_tambah extends CI_Controller {



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

		// $data['m_user'] = $this->m_master_pasien->get_all_pasien();

		$data['header'] = 'header';

		$data['menu'] = 'menu';

		$data['script'] = 'script';

		$data['footer'] = 'footer';

		$this->load->view('rawat_tambah', $data);

	}



	public function lookupPasien() {

		$data_pasien = $this->m_rawat->get_all_pasien();



		$header = '<thead>

                        <tr>

                        	<th>No</th>

                            <th>Nama</th>

                            <th>No. Telp</th>

                        </tr>

                    </thead>

                    <tfoot>

                        <tr>

                        	<th>No</th>

                            <th>Nama</th>

                            <th>No. Telp</th>

                        </tr>

                    </tfoot>

                    <tbody>';



		$no = 0;

    	if($data_pasien != ""){

    		echo $header;

			foreach ($data_pasien as $key) {

				echo '<tr class="pilih-pasien" data-nama="'.$key->nama.'" data-id="'.$key->id.'" data-telp="'.$key->no_telp.'">

                            <td>'.($no + 1).'</td>

                            <td>'.$key->nama.'</td>

                            <td>'.$key->no_telp.'</td>

                        </tr>';



                $no++;

			}

			echo '</tbody>';

		}

	}



	public function lookupPenyakit() {



		$data_pasien = $this->m_rawat->get_all_penyakit();



		$header = '<thead>

                        <tr>

                        	<th>No</th>

                            <th>Kode</th>

                            <th>Nama</th>

                        </tr>

                    </thead>

                    <tfoot>

                        <tr>

                        	<th>No</th>

                            <th>Kode</th>

                            <th>Nama</th>

                        </tr>

                    </tfoot>

                    <tbody>';



		$no = 0;

    	if($data_pasien != ""){

    		echo $header;

			foreach ($data_pasien as $key) {

				echo '<tr class="pilih-penyakit" data-nama="'.$key->nama.'" data-id="'.$key->id.'">

                            <td>'.($no + 1).'</td>

                            <td>'.$key->kode.'</td>

                            <td>'.$key->nama.'</td>

                        </tr>';



                $no++;

			}

			echo '</tbody>';

		}

	}



	function add_rawat_header(){
   		error_reporting(0);

		// if($this->input->post('add_pasien')){



		$nama_pasien		= $this->input->post('nama_pasien');

		$notelp_pasien	= $this->input->post('notelp_pasien');

		$alamat_pasien	= $this->input->post('alamat_pasien');

		$tingkat_kooperatif	= $this->input->post('tingkat_kooperatif');
		$umur_pasien	= $this->input->post('umur_pasien');
		$jenis_kelamin	= $this->input->post('jenis_kelamin');
		$foto_pasien	= $this->input->post('pasien_foto_base64');
		$rahang_atas	= $this->input->post('rahang_atas_base64');
		$rahang_bawah	= $this->input->post('rahang_bawah_base64');
		$tambahan   	= $this->input->post('tambahan_base64');
		$sistemik_pasien	= $this->input->post('sistemik_pasien');
		$note	= $this->input->post('note');
		$odontogram	= $this->input->post('odontogram');

		// $tgl_rawat		= $this->input->post('tgl_rawat');

		// $status			= "MENUNGGU_DAFTAR";

		$user_ins 		= $this->session->userdata('username');

		$id_rawat 		= rand(111,999)."".time()."".rand(11,99);
		$foto_name 		= "";

		$img_name = md5(time().uniqid());
		$foto_name 				= $this->base64toImg('add', $foto_pasien, $img_name, 'foto_pasien_', $id_rawat);
		$foto_name_rahang_atas 	= $this->base64toImg('add', $rahang_atas, $img_name, 'foto_rahang_atas_', $id_rawat);
		$foto_name_rahang_bawah = $this->base64toImg('add', $rahang_bawah, $img_name, 'foto_rahang_bawah_', $id_rawat);
		$foto_name_tambahan 	= $this->base64toImg('add', $tambahan, $img_name, 'foto_tambahan_', $id_rawat);
	        				

			$data['add_rawat'] = $this->m_rawat->add_rawat_header($nama_pasien, $notelp_pasien, $alamat_pasien, $tingkat_kooperatif, $user_ins, $id_rawat, $odontogram, $umur_pasien, $sistemik_pasien, $note, $jenis_kelamin, $foto_name, $foto_name_rahang_atas, $foto_name_rahang_bawah, $foto_name_tambahan);

   			

   			if($data['add_rawat']){

   				$result = array(

   						"rc" => "0000",

   						"message" => "Silahkan Tambah detail diagnosa penyakit.",

   						"id_rawat" => $id_rawat,
   						"id" => $data['add_rawat']

   					);

   			}

   			else {

				$result = array(

   						"rc" => "0001",

   						"message" => "Rawat Pasien gagal ditambahkan."

   					);

   			}



		


		echo json_encode($result);



	}



	function edit_rawat_header(){
		error_reporting(0);

		// if($this->input->post('add_pasien')){



		$nama_pasien		= $this->input->post('nama_pasien');

		$notelp_pasien	= $this->input->post('notelp_pasien');

		$alamat_pasien	= $this->input->post('alamat_pasien');

		$tingkat_kooperatif	= $this->input->post('tingkat_kooperatif');
		$umur_pasien	= $this->input->post('umur_pasien');
		$jenis_kelamin	= $this->input->post('jenis_kelamin');
		$foto_pasien	= $this->input->post('pasien_foto_base64_1');
		$rahang_atas	= $this->input->post('rahang_atas_base64_1');
		$rahang_bawah	= $this->input->post('rahang_bawah_base64_1');
		$tambahan	    = $this->input->post('tambahan_base64_1');
		$sistemik_pasien	= $this->input->post('sistemik_pasien');
		$note	= $this->input->post('note');
		$odontogram	= $this->input->post('odontogram');
		
		// $tgl_rawat		= $this->input->post('tgl_rawat');

		$id_rawat 		= $this->input->post('id_rawat');

		$id 		= $this->input->post('id');

		//$type='', $img_file='', $nama_poto = '', $jenis='', $id_rawat
		$img_name = md5(time().uniqid());
		$foto_name 				= $this->base64toImg('update', $foto_pasien, $img_name, 'foto_pasien_', $id_rawat);
		$foto_name_rahang_atas 	= $this->base64toImg('update', $rahang_atas, $img_name, 'foto_rahang_atas_', $id_rawat);
		$foto_name_rahang_bawah = $this->base64toImg('update', $rahang_bawah, $img_name, 'foto_rahang_bawah_', $id_rawat);
		$foto_name_tambahan 	= $this->base64toImg('update', $tambahan, $img_name, 'foto_tambahan_', $id_rawat);

	        				

			$data['add_rawat'] = $this->m_rawat->edit_rawat_header($id, $nama_pasien, $notelp_pasien, $alamat_pasien, $tingkat_kooperatif, $id_rawat, $odontogram, $umur_pasien, $sistemik_pasien, $note, $jenis_kelamin, $foto_name, $foto_name_rahang_atas, $foto_name_rahang_bawah, $foto_name_tambahan );

   			

   			if($data['add_rawat']){

   				$result = array(

   						"rc" => "0000",

   						"message" => "Daftar rawat pasien berhasil diperbarui.",

   						"id_rawat" => $id_rawat

   					);

   			}

   			else {

				$result = array(

   						"rc" => "0001",

   						"message" => "Daftar Rawat Pasien gagal diperbarui."

   					);

   			}



		



		echo json_encode($result);



	}





	function add_rawat_detail(){

		// if($this->input->post('add_pasien')){



		$id_rawat		= $this->input->post('id_rawat');

		$id_bidang_ilmu	= $this->input->post('id_bidang_ilmu');

		$id_penyakit	= $this->input->post('id_penyakit');

		$id_rencana_perawatan	= $this->input->post('id_rencana_perawatan');

		$tgl_rawat		= $this->input->post('tgl_rawat');

		$status			= "DAFTAR";

		$gigi			= $this->input->post('gigi');

		$foto			= $this->input->post('foto_base64');
		
		$harga			= $this->input->post('harga');



		// $foto_name = $id_rawat."".md5(time().uniqid()).".jpg";

		// $this->base64toImg($foto, $foto_name);



		$data['add_rawat'] = $this->m_rawat->add_rawat_detail($id_rawat, $id_bidang_ilmu, $id_penyakit, $id_rencana_perawatan, $gigi, $foto, $tgl_rawat, $status, $harga);

			

			if($data['add_rawat']){

				$this->m_rawat->update_total_harga_rawat($id_rawat);

				// $this->updateStatusRawatDaftar($id_rawat);

				$result = array(

						"rc" => "0000",

						"message" => "Detail diagnosa penyakit berhasil ditambahkan.",

						"id_rawat" => $id_rawat

					);

			}

			else {

			$result = array(

						"rc" => "0001",

						"message" => "Rawat Pasien gagal ditambahkan."

					);

			}



		echo json_encode($result);



	}



	function edit_rawat_detail(){

		// if($this->input->post('add_pasien')){



		$id_rawat		= $this->input->post('id_rawat');

		$id_bidang_ilmu	= $this->input->post('id_bidang_ilmu');

		$id_penyakit	= $this->input->post('id_penyakit');

		$id_rencana_perawatan	= $this->input->post('id_rencana_perawatan');

		$tgl_rawat		= $this->input->post('tgl_rawat');

		$status			= "DAFTAR";

		$gigi			= $this->input->post('gigi');

		$foto			= $this->input->post('foto_base64');
		
		$harga          = $this->input->post('harga');

		$id 			= $this->input->post('id_detail_rawat');

		// $foto_name = $id_rawat."".md5(time().uniqid()).".jpg";

		// $this->base64toImg($foto, $foto_name);



		$data['edit_rawat'] = $this->m_rawat->edit_rawat_detail($id, $id_rawat, $id_bidang_ilmu, $id_penyakit, $id_rencana_perawatan, $gigi, $foto, $tgl_rawat, $status, $harga);

			

			if($data['edit_rawat']){

				$this->m_rawat->update_total_harga_rawat($id_rawat);

				// $this->updateStatusRawatDaftar($id_rawat);

				$result = array(

						"rc" => "0000",

						"message" => "Detail diagnosa penyakit berhasil diperbarui.",

						"id_rawat" => $id_rawat

					);

			}

			else {

			$result = array(

						"rc" => "0001",

						"message" => "Detail diagnosa penyakit gagal diperbarui."

					);

			}



		echo json_encode($result);



	}

	function base64toImg($type='', $img_file='', $nama_poto = '', $jenis='', $id_rawat)
	{
		// if ($type == "add") {
		// 	# code...
		// } else if ($type == "update") {
		$foto_name = "";
		if ($this->startsWith($img_file, "data:image")) {

			list($type, $data) = explode(';', $img_file);
			// if (preg_match('/^data:image\/(\w+);base64,/', $type, $data)) {
			if ($this->startsWith($type, "data:image") && $this->startsWith($data, "base64,")) {

			    $data = substr($data, strpos($data, ',') + 1);
			    $type = strtolower(str_replace("data:image/", "", $type)); // jpg, png, gif


			    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
			        $result = array(

	   						"rc" => "0001",

	   						"message" => "Format foto tidak diketahui"

	   					);
			    	echo json_encode($result);
			    	exit();
			    }

			    $data = base64_decode($data);

			    if ($data === false) {
			        $result = array(

	   						"rc" => "0001",

	   						"message" => "Gagal menyimpan foto kegambar"

	   					);
			    	echo json_encode($result);
			    	exit();
			    }
			    //save foto
			    
				$foto_name = $jenis."".$id_rawat."".md5(time().uniqid()).".{$type}";
				file_put_contents(FCPATH."assets/img/pasien/".$foto_name, $data);
			}
		} else {
			$arr_split = explode("/", $img_file);
			$foto_name = $arr_split[count($arr_split) - 1];
		}

		return $foto_name;
		// }
	}
	
	// function resizeAndCompressImagefunction($file, $w, $h, $crop=FALSE) {
	//     list($width, $height) = getimagesizefromstring($file);
	//     $r = $width / $height;
	//     if ($crop) {
	//         if ($width > $height) {
	//             $width = ceil($width-($width*($r-$w/$h)));
	//         } else {
	//             $height = ceil($height-($height*($r-$w/$h)));
	//         }
	//         $newwidth = $w;
	//         $newheight = $h;
	//     } else {
	//         if ($w/$h > $r) {
	//             $newwidth = $h*$r;
	//             $newheight = $h;
	//         } else {
	//             $newheight = $w/$r;
	//             $newwidth = $w;
	//         }
	//     }
	//     $src = imagecreatefromstring($file);
	//     $dst = imagecreatetruecolor($newwidth, $newheight);
	//     imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	//     return $dst;
	// }

	function coba2()
	{
		echo phpinfo();
	}



	function deleteRawatDetail(){

		// if ($this->session->userdata('role') == "ADMIN") {

			$dtusr=trim(file_get_contents('php://input'));

			$objx=json_decode(trim($dtusr), true);

			$id=$objx['id'];

			$id_rawat=$objx['id_rawat'];

			$data['delete'] = $this->m_rawat->delete_one_of_rawat_detail($id);

				

			if($data['delete']){

				$this->m_rawat->update_total_harga_rawat($id_rawat);

				// $this->updateStatusRawatDaftar($id_rawat);

				$result = array(

						"rc" => "0000",

						"message" => "Daftar Detail Rawat pasien berhasil dihapus."

					);

			}

			else {

				$result = array(

						"rc" => "0001",

						"message" => "Daftar Detail Rawat pasien gagal dihapus."

					);

			}

		// } else {

		// 	$result = array(

		// 				"rc" => "0002",

		// 				"message" => "Anda bukan admin."

		// 			);

		// }



		echo json_encode($result);

	}



	function getDetailRawatById(){

		$dtusr=trim(file_get_contents('php://input'));

		$objx=json_decode(trim($dtusr), true);

		$id=$objx['id'];



		$data['get_detail'] = $this->m_rawat->get_detail_rawat_by_id($id);

			

		if($data['get_detail']){

			$result = array_merge(json_decode(json_encode($data['get_detail'][0]), true), array(

					"rc" => "0000",

				));

		}

		else {

			$result = array(

					"rc" => "0001",

					"message" => "Gagal memperoleh data detail rawat."

				);

		}



		echo json_encode($result);

	}

	function getTotalHarga(){

		$dtusr=trim(file_get_contents('php://input'));

		$objx=json_decode(trim($dtusr), true);

		$id_rawat=$objx['id_rawat'];



		$data['get_detail'] = $this->m_rawat->get_update_total_harga_rawat($id_rawat);

			

		if($data['get_detail']){

			$result = json_decode(json_encode($data['get_detail'][0]), true);

		}

		else {

			$result = array(

					"rc" => "0001",

					"message" => "Gagal memperoleh data detail rawat."

				);

		}



		echo json_encode($result);

	}



	function getDetailRawat(){

		if ($this->input->post('id')) {

			# code...

			$id		= $this->input->post('id');

			$data_penyakit = $this->m_rawat->get_detail_rawat($id);



			$header = '<thead>

	                        <tr>

	                        	<th>No</th>

                                <th>Departemen</th>

                                <th>Diagnosa</th>

                                <th>Harga</th>

                                <th class="disabled-sorting text-right">Actions</th>

	                        </tr>

	                    </thead>

	                    <tbody>';



			$no = 0;

	    	if($data_penyakit != ""){

	    		echo $header;

				foreach ($data_penyakit as $key) {

					echo '<tr>

	                            <td>'.($no + 1).'</td>

	                            <td>'.$key->nama_bidang_ilmu.'</td>

	                            <td>'.$key->nama_penyakit.'</td>

	                            <td>'.number_format($key->harga).'</td>

	                            <td class="text-right">

	                                <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editDetailRawat('.$key->id.');"><i class="material-icons">edit</i></a>

	                                <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove" onclick="deleteRawatDetail('.$key->id.', '.$key->id_rawat.', '."'".$key->nama_penyakit."'".');"><i class="material-icons">close</i></a>

	                            </td>

	                        </tr>';



	                $no++;

				}

				echo '</tbody>';

			}

		}

	}



	function updateStatusRawatDaftar($id) {

		$cekDetail = $this->m_rawat->cekRawatDetail($id);

		if ($cekDetail) {

			$update = $this->m_rawat->updateStatusRawat($id, "DAFTAR");

		} else {

			$update = $this->m_rawat->updateStatusRawat($id, "MENUNGGU_DAFTAR");

		}

	}

	function startsWith($haystack, $needle) {
	     $length = strlen($needle);
	     return (substr($haystack, 0, $length) == $needle);
	}

}

?>