<?php

class M_token extends CI_Model
{
	public function __construct()
	 {
	  parent::__construct();
	  $this->db = $this->load->database('utama',true);
	 }

 	function get_all_saldo_user(){
		$qry = "
				SELECT 
					u.nama AS nama_user, u.username, COALESCE(s.deposit_today, 0) AS deposit_today, COALESCE(t.trx_today, 0) AS trx_today, 
					d.* 
				FROM 
					c_deposit d
					LEFT JOIN m_user u ON u.id = d.id_user
					LEFT JOIN (SELECT id_user, SUM(saldo) AS deposit_today FROM c_mutasi WHERE tipe = 'IN') AS s ON s.id_user = d.`id_user`
					LEFT JOIN (SELECT id_user, SUM(saldo) AS trx_today FROM c_mutasi WHERE tipe = 'OUT') AS t ON t.id_user = d.`id_user`
				ORDER BY u.nama;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function getSaldoUser($id_user)
	{
		$qry = "select * from c_deposit where id_user = '$id_user';";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function allocateDeposit($user_update, $keterangan, $nominal, $status, $tipe, $id_trx, $touser, $iduser)
	{
		$qry = "UPDATE
				  `c_deposit`
				SET
				  `time_update` = NOW(),
				  `user_update` = '$user_update',
				  `keterangan` = '$keterangan',
				  `last_nominal` = '$nominal',
				  `last_status` = '$status',
				  `last_tipe`  = '$tipe',
				  `last_idtrx` = '$id_trx',
				  last_touser  = '$touser'
				WHERE id_user = '$iduser';";

		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function get_filter_mutasi_user($from, $to, $id_user)
	{
		$qry = "SELECT 
					m.*, COALESCE(u.nama, '') AS nama_user
				FROM
					c_mutasi m
					LEFT JOIN m_user u ON u.id = m.`to_user`
				WHERE 
					DATE(m.`time_ins`) >= '$from' 
					AND DATE(m.`time_ins`) <= '$to'
					AND m.id_user = '$id_user'
				order by m.id asc;";
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

	function add_penyakit($nama, $kode, $id_bidang_ilmu)
 	{ 
 		 		
 		$qry = "INSERT INTO `m_penyakit`
					            (
					             `kode`,
					             `nama`,
					             `id_bidang_ilmu`)
					VALUES (
					        '$kode',
					        '$nama',
					        '$id_bidang_ilmu');";
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

	function edit_penyakit($id_penyakit, $nama, $kode, $id_bidang_ilmu){
		$qry = "UPDATE `m_penyakit`
				SET 
				  `nama` = '$nama',
				  `kode` = '$kode',
				  `id_bidang_ilmu` = '$id_bidang_ilmu'
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

