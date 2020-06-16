<?php

class M_master_rencana_perawatan extends CI_Model
{
	public function __construct()
	 {
	  parent::__construct();
	  $this->db = $this->load->database('utama',true);
	 }

 	function get_all_rencana_perawatan(){
		$qry = "
				SELECT rb.*, p.nama as nama_penyakit FROM m_rencana_perawatan rb
				inner join m_penyakit p on p.id = rb.id_penyakit
				order by rb.nama asc;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function get_all_rencana_perawatan_by_penyakit($id){
		$qry = "
				SELECT * FROM m_rencana_perawatan where id_penyakit = '$id'
				order by nama asc;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function get_rencana_perawatan_by_id($id){
		$qry = "
				SELECT * FROM m_rencana_perawatan where id='$id';
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function add_rencana_perawatan($nama, $id_penyakit)
 	{ 
 		 		
 		$qry = "INSERT INTO `m_rencana_perawatan`
					            (
					             `nama`,
					             `id_penyakit`)
					VALUES (
					        '$nama',
					        '$id_penyakit');";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function cek_nama($nama){
		$qry = "select * from m_rencana_perawatan where nama = '".$nama."';";
		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return true;
		else return false;
	}

	function delete_rencana_perawatan($id_rencana){
		$qry = "DELETE FROM `m_rencana_perawatan` WHERE `id` = '".$id_rencana."';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function edit_rencana_perawatan($id_rencana, $nama, $id_penyakit){
		$qry = "UPDATE `m_rencana_perawatan`
				SET 
				  `nama` = '$nama',
				  `id_penyakit` = '$id_penyakit'
				WHERE `id` = '$id_rencana';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	public function count_all()
	{
		$this->db->from("m_rencana_perawatan");
		return $this->db->count_all_results();
	}
	
}

?>

