<?php

class M_master_pasien extends CI_Model
{
	public function __construct()
	 {
	  parent::__construct();
	  $this->db = $this->load->database('utama',true);
	 }

 	function get_all_pasien(){
		$qry = "
				SELECT * FROM m_pasien order by nama asc;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function get_pasien_by_id($id){
		$qry = "
				SELECT * FROM m_pasien where id='$id';
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function add_pasien($nama, $alamat, $tgl_lahir, $jenis_kelamin, $no_telp)
 	{ 
 		 		
 		$qry = "INSERT INTO `m_pasien`
					            (
					             `time_ins`,
					             `nama`,
					             `tgl_lahir`,
					             `no_telp`,
					             alamat,
					             jenis_kelamin)
					VALUES (
					        now(),
					        '$nama',
					        '$tgl_lahir',
					        '$no_telp',
					        '$alamat',
					        '$jenis_kelamin');";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function delete_pasien($id_pasien){
		$qry = "DELETE FROM `m_pasien` WHERE `id` = '".$id_pasien."';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function edit_pasien($id_pasien, $nama, $alamat, $tgl_lahir, $jenis_kelamin, $no_telp){
		$qry = "UPDATE `m_pasien`
				SET 
				  `nama` = '$nama',
				  `tgl_lahir` = '$tgl_lahir',
				  `alamat` = '$alamat',
				  `jenis_kelamin` = '$jenis_kelamin',
				  `no_telp` = '$no_telp'
				WHERE `id` = '$id_pasien';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	public function count_all()
	{
		$this->db->from("m_pasien");
		return $this->db->count_all_results();
	}
	
}

?>

