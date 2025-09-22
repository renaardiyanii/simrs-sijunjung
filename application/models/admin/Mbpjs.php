<?php 
class Mbpjs extends CI_Model 
{
    
    public function __construct() 
    {
        parent::__construct();
    }
	
	function get_bpjs(){
		return $this->db->query("select * from bpjs_config");
	}

    public function update_bpjs($data_bpjs){
        $this->db->update('bpjs_config', $data_bpjs);
        $this->db->limit(1);
        return true;        
    }   

    

}