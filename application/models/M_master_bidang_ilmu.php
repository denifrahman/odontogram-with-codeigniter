<?php

class M_master_bidang_ilmu extends CI_Model
{
	public function __construct()
	 {
	  parent::__construct();
	  $this->db = $this->load->database('utama',true);
	 }

 	function get_all_bidang_ilmu(){
		$qry = "
				SELECT * FROM m_bidang_ilmu order by nama asc;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function get_bidang_ilmu_by_id($id){
		$qry = "
				SELECT * FROM m_bidang_ilmu where id='$id';
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function add_bidang_ilmu($nama, $kode)
 	{ 
 		 		
 		$qry = "INSERT INTO `m_bidang_ilmu`
					            (
					             `kode`,
					             `nama`)
					VALUES (
					        '$kode',
					        '$nama');";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function cek_kode($kode){
		$qry = "select * from m_bidang_ilmu where kode = '".$kode."';";
		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return true;
		else return false;
	}

	function cek_nama($nama){
		$qry = "select * from m_bidang_ilmu where nama = '".$nama."';";
		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return true;
		else return false;
	}

	function delete_bidang_ilmu($id_bidang_ilmu){
		$qry = "DELETE FROM `m_bidang_ilmu` WHERE `id` = '".$id_bidang_ilmu."';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function edit_bidang_ilmu($id_bidang_ilmu, $nama, $kode){
		$qry = "UPDATE `m_bidang_ilmu`
				SET 
				  `nama` = '$nama',
				  `kode` = '$kode'
				WHERE `id` = '$id_bidang_ilmu';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	public function count_all()
	{
		$this->db->from("m_bidang_ilmu");
		return $this->db->count_all_results();
	}
	
}

?>

