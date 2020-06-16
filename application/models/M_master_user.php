<?php

class M_master_user extends CI_Model
{
	public function __construct()
	 {
	  parent::__construct();
	  $this->db = $this->load->database('utama',true);
	 }

 	function get_all_user(){
		$qry = "
				SELECT * FROM m_user order by nama asc;
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function get_user_by_id($id){
		$qry = "
				SELECT * FROM m_user where id='$id';
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	function add_user($nama, $username, $password, $alamat, $jenis_kelamin, $no_telp, $role)
 	{ 
 		 		
 		$qry = "INSERT INTO `m_user`
					            (
					             `time_ins`,
					             `nama`,
					             `username`,
					             `password`,
					             `no_telp`,
					             alamat,
					             jenis_kelamin,
					             `role`)
					VALUES (
					        now(),
					        '$nama',
					        '$username',
					        '$password',
					        '$no_telp',
					        '$alamat',
					        '$jenis_kelamin',
					        '$role');";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function cek_username($username){
		$qry = "select * from m_user where username = '".$username."';";
		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return true;
		else return false;
	}

	function delete_user($id_user){
		$qry = "DELETE FROM `m_user` WHERE `id` = '".$id_user."';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	function edit_user($id_user, $nama, $password, $alamat, $jenis_kelamin, $no_telp, $role){
		$qry = "UPDATE `m_user`
				SET 
				  `nama` = '$nama',
				  `password` = '$password',
				  `alamat` = '$alamat',
				  `jenis_kelamin` = '$jenis_kelamin',
				  `no_telp` = '$no_telp',
				  `role` = '$role'
				WHERE `id` = '$id_user';";
		$data = $this->db->query($qry);
		
		if($data) return true;
		else return false;
	}

	public function count_all()
	{
		$this->db->from("m_user");
		return $this->db->count_all_results();
	}
	
}

?>

