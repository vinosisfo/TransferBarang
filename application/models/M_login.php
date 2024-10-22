<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}


   public function proses($user,$get_pass){
   		$query=$this->db->from('tb_user')
   						->where('username',$user)
   						->where('password',$get_pass)
   						->get();
   		return $query;
   }

   
}
