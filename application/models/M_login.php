<?php

class M_login extends CI_Model
{
	public function __construct()
	 {
	  parent::__construct();
	  $this->db = $this->load->database('utama',true);
	 }

 	function login($user, $pass)
 	{ 
		// $data = $this->db->where(array('username'=>$user,'password'=>$pass))->get('m_user'); 
	
		// if($data->num_rows() > 0){  

		// 	return $data->result();
		// }
		// else{
		// 	return false;
		// }

		$qry = "
				SELECT * FROM m_user where username = '$user' and password = '$pass';
				";

		$data = $this->db->query($qry);
		
		if($data->num_rows() > 0) return $data->result();
		else return false;
	}

	public function is_login(){
        if($this->session->userdata('akses') != 0)  return true;  else   return false;
        // return true;
    }
	
}

?>

