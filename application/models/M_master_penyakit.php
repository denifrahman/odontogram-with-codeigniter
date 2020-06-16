<?php

class M_master_penyakit extends CI_Model
{
	public function __construct()
	 {
	  parent::__construct();
	  $this->db = $this->load->database('utama',true);
	 }

 	function get_all_penyakit(){
		$qry = "
				select * from m_penyakit;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}


 	function get_all_penyakit_by_bidang_ilmu($id){
		$qry = "
				SELECT * FROM m_penyakit where id_bidang_ilmu = '$id'
				order by nama asc;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function get_penyakit_by_id($id){
		$qry = "
				SELECT * FROM m_penyakit where id='$id';
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function add_penyakit($nama, $kode)
 	{ 
 		 		
 		$qry = "INSERT INTO `m_penyakit`
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
		$qry = "select * from m_penyakit where kode = '".$kode."';";
		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return true;
		else return false;
	}

	function cek_nama($nama){
		$qry = "select * from m_penyakit where nama = '".$nama."';";
		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return true;
		else return false;
	}

	function delete_penyakit($id_penyakit){
		$qry = "DELETE FROM `m_penyakit` WHERE `id` = '".$id_penyakit."';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function edit_penyakit($id_penyakit, $nama, $kode){
		$qry = "UPDATE `m_penyakit`
				SET 
				  `nama` = '$nama',
				  `kode` = '$kode'
				WHERE `id` = '$id_penyakit';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	public function count_all()
	{
		$this->db->from("m_penyakit");
		return $this->db->count_all_results();
	}
	
}

?>

