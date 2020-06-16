<?php

class M_rawat extends CI_Model
{
	public function __construct()
	 {
	  parent::__construct();
	  $this->db = $this->load->database('utama',true);
	 }

 	function get_all_pasien(){
		$qry = "
				SELECT * FROM m_pasien where id not in (select id_pasien from t_rawat where status in ('DAFTAR', 'RAWAT')) order by nama asc;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	} 

	function get_all_penyakit(){
		$qry = "
				SELECT * FROM m_penyakit order by nama asc;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function get_detail_rawat($id){
		$qry = "SELECT rd.*, p.nama AS nama_penyakit, b.nama AS nama_bidang_ilmu, rp.nama AS nama_rencana_perawatan FROM t_rawat_detail rd 
					INNER JOIN m_bidang_ilmu b ON b.id = rd.id_bidang_ilmu
					INNER JOIN m_penyakit p ON p.`id` = rd.id_penyakit
					INNER JOIN m_rencana_perawatan rp ON rp.id = rd.id_rencana_perawatan
					WHERE rd.id_rawat = '$id';";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function add_rawat_header($nama_pasien, $notelp_pasien, $alamat_pasien, $tingkat_kooperatif, $user_ins, $id_rawat,$odontogram, $umur_pasien, $sistemik_pasien, $note, $jenis_kelamin, $foto_pasien, $rahang_atas, $rahang_bawah, $tambahan)
 	{ 
 		 		
 		$qry = "INSERT INTO `t_rawat`
					            (
					             `time_ins`,
					             `user_ins`,
					             `nama_pasien`,
					             `umur_pasien`,
					             `sistemik_pasien`,
					             `note`,
					             `jenis_kelamin`,
					             `foto_pasien`,
					             `rahang_atas`,
					             `rahang_bawah`,
					             `tambahan`,
					             `notelp_pasien`,
					             `alamat_pasien`,
					             `tingkat_kooperatif`,
					             `id_rawat`,
					             odontogram)
					VALUES (
					        now(),
					        '$user_ins',
					        '$nama_pasien',
					        '$umur_pasien',
					        '$sistemik_pasien',
					        '$note',
					        '$jenis_kelamin',
					        '$foto_pasien',
					        '$rahang_atas',
					        '$rahang_bawah',
					        '$tambahan',
					        '$notelp_pasien',
					        '$alamat_pasien',
					        '$tingkat_kooperatif',
					        '$id_rawat',
					        '$odontogram');";
		$data = $this->db->query($qry);
		
		if($data) return $this->db->insert_id();
		else return false;
	}

	function edit_rawat_header($id, $nama_pasien, $notelp_pasien, $alamat_pasien, $tingkat_kooperatif, $id_rawat,$odontogram, $umur_pasien, $sistemik_pasien, $note, $jenis_kelamin, $foto_pasien, $rahang_atas, $rahang_bawah, $tambahan) {
		$qry = "UPDATE
				  `t_rawat`
				SET
				  `nama_pasien` = '$nama_pasien',
				  `umur_pasien` = '$umur_pasien',
				  `sistemik_pasien` = '$sistemik_pasien',
				  `note` = '$note',
				  `jenis_kelamin` = '$jenis_kelamin',
				  `foto_pasien` = '$foto_pasien',
				  `rahang_atas` = '$rahang_atas',
				  `rahang_bawah` = '$rahang_bawah',
				  `tambahan` = '$tambahan',
				  `notelp_pasien` = '$notelp_pasien',
				  `alamat_pasien` = '$alamat_pasien',
				  `tingkat_kooperatif` = '$tingkat_kooperatif',
				  `odontogram` = '$odontogram'
				WHERE `id` = '$id'
				  AND `id_rawat` = '$id_rawat';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function add_rawat_detail($id_rawat, $id_bidang_ilmu, $id_penyakit, $id_rencana_perawatan, $gigi, $foto, $tgl_rawat, $status, $harga)
 	{ 
 		 		
 		$qry = "INSERT INTO `t_rawat_detail`
					            (
					             `id_rawat`,
					             `id_bidang_ilmu`,
					             `id_penyakit`,
					             `id_rencana_perawatan`,
					             `tgl_rawat`,
					             `status`,
					             `gigi`,
					             `foto`,
					             `harga`)
					VALUES (
					        '$id_rawat',
					        '$id_bidang_ilmu',
					        '$id_penyakit',
					        '$id_rencana_perawatan',
					        '$tgl_rawat',
					        '$status',
					        '$gigi',
					        '$foto',
					        '$harga');";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function edit_rawat_detail($id, $id_rawat, $id_bidang_ilmu, $id_penyakit, $id_rencana_perawatan, $gigi, $foto, $tgl_rawat, $status, $harga) {
		$qry = "UPDATE
				  `t_rawat_detail`
				SET
				  `id_bidang_ilmu` = '$id_bidang_ilmu',
				  `id_penyakit` = '$id_penyakit',
				  `id_rencana_perawatan` = '$id_rencana_perawatan',
				  `foto` = '$foto',
				  `gigi` = '$gigi',
				  `status` = '$status',
				  `harga` = '$harga'
				WHERE `id` = '$id';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function getPrintPasien($id){
		// $filter = "";

		$qry = "SELECT 
					rd.*, r.jenis_kelamin, r.tingkat_kooperatif, r.notelp_pasien,  r.foto_pasien, r.rahang_atas, r.rahang_bawah, r.tambahan, r.sistemik_pasien, r.alamat_pasien, r.time_ins, r.id as id_header, r.`user_ins`, r.nama_pasien, r.umur_pasien, r.`odontogram`, COALESCE(k.nama, '') AS nama_penyakit
				FROM t_rawat r
				LEFT JOIN t_rawat_detail rd ON rd.`id_rawat` = r.`id_rawat`
				LEFT JOIN m_penyakit k ON k.id = rd.`id_penyakit`
				WHERE rd.id = '$id'
				LIMIT 1";

		// echo $qry;

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function getDetailVerifikasi($id){
		// $filter = "";

		$qry = "SELECT 
					rd.*, r.time_ins, r.id as id_header, r.`user_ins`, r.nama_pasien, r.umur_pasien, r.alamat_pasien, r.`odontogram`, COALESCE(k.nama, '') AS nama_penyakit, r.foto_pasien, r.rahang_atas, r.rahang_bawah, r.tambahan
				FROM t_rawat r
				LEFT JOIN t_rawat_detail rd ON rd.`id_rawat` = r.`id_rawat`
				LEFT JOIN m_penyakit k ON k.id = rd.`id_penyakit`
				WHERE rd.id = '$id'
				LIMIT 1";

		// echo $qry;

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function history($toDate, $fromDate, $filter){
		// $filter = "";

		$qry = "SELECT 
					r.time_ins, r.id, rd.id as id_detail, rd.verifikasi, r.`user_ins`, r.`id_rawat`, COALESCE(rd.`id_dokter`, '') AS id_dokter,  COALESCE(rd.`id_penyakit`, '') AS id_penyakit,COALESCE(rd.`status`, 'MENUNGGU_DAFTAR') AS `status`, COALESCE(rd.`tgl_pilih`, '') AS tgl_pilih, 
					COALESCE(rd.`tgl_rawat`, date(r.time_ins)) AS tgl_rawat, COALESCE(rd.`tgl_selesai`, '') AS tgl_selesai, r.nama_pasien, COALESCE(k.nama, '') AS nama_penyakit, 
					COALESCE(u.nama, '') AS nama_dokter 
				FROM t_rawat r
				LEFT JOIN t_rawat_detail rd ON rd.`id_rawat` = r.`id_rawat`
				LEFT JOIN m_penyakit k ON k.id = rd.`id_penyakit`
				LEFT JOIN m_user u ON u.id = rd.`id_dokter`
				WHERE date(r.time_ins) <= '$toDate'
				and date(r.time_ins) >= '$fromDate'
				".$filter."
				ORDER BY r.`time_ins` DESC;";

		// echo $qry;

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function rawat_terpilih($id){

		$qry = "SELECT 
					rd.verifikasi, r.time_ins, rd.id, r.`user_ins`, COALESCE(rd.`id_dokter`, '') AS id_dokter, rd.`id_penyakit`,rd.`status`, COALESCE(rd.`tgl_pilih`, '') AS tgl_pilih,  r.notelp_pasien,
					COALESCE(rd.`tgl_rawat`, '') AS tgl_rawat, COALESCE(rd.`tgl_selesai`, '') AS tgl_selesai, r.nama_pasien, k.nama AS nama_penyakit, 
					COALESCE(u.nama, '') AS nama_dokter 
				FROM t_rawat r
				LEFT JOIN t_rawat_detail rd ON rd.`id_rawat` = r.`id_rawat`
				LEFT JOIN m_penyakit k ON k.id = rd.`id_penyakit`
				LEFT JOIN m_user u ON u.id = rd.`id_dokter`
				WHERE rd.id_dokter = '$id'
				AND rd.status NOT IN ('SELESAI', 'MENOLAK_RAWAT')
				ORDER BY r.`time_ins` DESC;";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function cek_update_pasien($id)
	{
		$qry = "SELECT * FROM `t_rawat_detail` WHERE id = '$id' and id_dokter is null";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return true;
		else return false;
	}

	function cari_outsanding_pasien($id){

		$qry = "SELECT 
					rd.verifikasi, r.time_ins, rd.id, r.`user_ins`, COALESCE(rd.`id_dokter`, '') AS id_dokter, rd.`id_penyakit`,rd.`status`, COALESCE(rd.`tgl_pilih`, '') AS tgl_pilih, 
					COALESCE(rd.`tgl_rawat`, '') AS tgl_rawat, COALESCE(rd.`tgl_selesai`, '') AS tgl_selesai, r.nama_pasien, k.nama AS nama_penyakit, r.notelp_pasien AS no_telp, rd.harga
				FROM t_rawat r
				LEFT JOIN t_rawat_detail rd ON rd.`id_rawat` = r.`id_rawat`
				LEFT JOIN m_penyakit k ON k.id = rd.`id_penyakit`
				WHERE rd.id_penyakit = '$id'
				AND rd.status = 'DAFTAR' ORDER BY FIELD(verifikasi, '1','0' , tingkat_kooperatif, 'BAIK', 'SEDANG', 'BURUK') LIMIT 1 
				;";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function delete_rawat($id){
		$qry = "DELETE FROM `t_rawat` WHERE `id_rawat` = '".$id."';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function delete_rawat_detail($id){
		$qry = "DELETE FROM `t_rawat_detail` WHERE `id_rawat` = '".$id."';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function delete_one_of_rawat_detail($id){
		$qry = "DELETE FROM `t_rawat_detail` WHERE `id` = '".$id."';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function pilihPasien($id, $id_dokter, $tgl_pilih){
		$qry = "UPDATE `t_rawat_detail`
				SET 
				  `id_dokter` = '$id_dokter',
				  `tgl_pilih` = '$tgl_pilih',
				  `status` = 'MENUNGGU_RAWAT'
				WHERE `id` = '$id';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function jmlRawatPasien($id_dokter){
		$qry = "SELECT COUNT(*) AS jml FROM t_rawat_detail WHERE id_dokter = '$id_dokter' AND STATUS <> 'SELESAI';";
		$data = $this->db->query($qry);

		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function jmlDetailRawatPerPasien($id){
		$qry = "SELECT COUNT(*) AS jml, id_rawat FROM t_rawat_detail WHERE id_rawat = '$id';";
		$data = $this->db->query($qry);

		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function getRawatById($id){
		$qry = "SELECT 
					r.time_ins, rd.id, r.`user_ins`, COALESCE(rd.`id_dokter`, '') AS id_dokter, rd.`id_penyakit`,rd.`status`, COALESCE(rd.`tgl_pilih`, '') AS tgl_pilih, 
					COALESCE(rd.`tgl_rawat`, '') AS tgl_rawat, COALESCE(rd.`tgl_selesai`, '') AS tgl_selesai, r.nama_pasien, k.nama AS nama_penyakit, r.notelp_pasien as no_telp
				FROM t_rawat r
				LEFT JOIN t_rawat_detail rd ON rd.`id_rawat` = r.`id_rawat`
				LEFT JOIN m_penyakit k ON k.id = rd.`id_penyakit`
				WHERE rd.id = '$id'
				limit 1";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function updateSelesai($id, $tgl_selesai){
		$qry = "UPDATE `t_rawat_detail`
				SET 
				  `tgl_selesai` = '$tgl_selesai',
				  `status` = 'SELESAI'
				WHERE `id` = '$id';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function hapusOutsandingPasien($id){
		$qry = "UPDATE `t_rawat_detail`
				SET 
				  `id_dokter` = null,
				  `tgl_pilih` = null,
				  `status` = 'DAFTAR'
				WHERE `id` = '$id';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function pasienTolakRawat($id_rawat, $id_dokter, $tgl_pilih){
		$qry = "UPDATE `t_rawat_detail`
				SET 
				  `id_dokter` = '$id_dokter',
				  `tgl_pilih` = '$tgl_pilih',
				  `status` = 'MENOLAK_RAWAT'
				WHERE `id_rawat` = '$id_rawat';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function cekRawatDetail($id){
		$qry = "
				SELECT * FROM t_rawat_detail WHERE id_rawat = '$id';
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return true;
		else return false;
	}

	function updateStatusRawat($id, $status){
		$qry = "UPDATE `t_rawat_detail`
				SET 
				  `status` = '$status'
				WHERE `id_rawat` = '$id' or id = '$id';";

		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}


	function updateStatusVerifikasi($id, $action){

		$qry = "UPDATE `t_rawat_detail` 
				SET 
				  `verifikasi` = ".($action == 1 ? 'true ' : 'false ' )." 
				WHERE id = '$id';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function get_detail_rawat_by_id($id){
		$qry = " 
				SELECT *  FROM t_rawat_detail WHERE id = '$id';
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function get_detail_rawat_by_id_rawat($id){
		$qry = "
				SELECT * FROM t_rawat_detail WHERE id_rawat = '$id';
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function get_one_rawat_by_id($id){
		$qry = "
				SELECT t.*, SUM(d.harga) AS harga_total FROM t_rawat t LEFT JOIN t_rawat_detail d ON t.id_rawat = d.id_rawat WHERE t.id = '$id' GROUP BY t.id_rawat;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}
	
	function get_detail_odonto_by_id($id){
		$qry = "SELECT rd.id, r.`odontogram`, r.foto_pasien, r.rahang_atas, r.rahang_bawah, r.tambahan 
					FROM t_rawat r 
					INNER JOIN t_rawat_detail rd ON rd.`id_rawat` = r.`id_rawat`
					WHERE rd.id = '$id';";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function update_total_harga_rawat($id_rawat)
	{
		$qry = "UPDATE `t_rawat` 
				SET 
				  `total_harga` = (select sum(harga) as total from t_rawat_detail where id_rawat = '$id_rawat')
				WHERE id_rawat = '$id_rawat';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function get_update_total_harga_rawat($id_rawat)
	{
		$qry = "SELECT r.id, r.id_rawat, r.nama_pasien, r.total_harga from t_rawat r where r.id_rawat = '$id_rawat';";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}
}

?>

