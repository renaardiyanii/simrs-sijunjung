<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_log extends CI_Model{
	function __construct(){
		parent::__construct();
	}	
		
	function insert($data)
	{	
		$this->db->insert('log',$data);
	}
}
?>