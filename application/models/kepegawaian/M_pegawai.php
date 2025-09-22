<?php 
class M_pegawai extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
    }

    function show_personil($id)
    {		
    	$this->db->select('*, kepegawaian_personil.id as id'); 
		$this->db->from('kepegawaian_personil'); 
        $this->db->join('kepegawaian_pangkat', 'kepegawaian_personil.pangkat_akhir = kepegawaian_pangkat.id', 'left');
        $this->db->join('kepegawaian_master_pangkat', 'kepegawaian_pangkat.pangkat = kepegawaian_master_pangkat.id', 'left');
        $this->db->join('kepegawaian_jabatan', 'kepegawaian_personil.jabatan_akhir = kepegawaian_jabatan.id', 'left');
        $this->db->where('kepegawaian_personil.id', $id);        
        $query = $this->db->get();
        return $query->row();
	}

	function update_personil($id,$data)
	{
        $this->db->where('id', $id);
        $this->db->update('kepegawaian_personil', $data);
        return true;
    }

    function insert_personil($data)
    {          
        $this->db->insert('kepegawaian_personil', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function remove_foto($id) 
    {
    	$data = array('foto' => '');
        $this->db->where('id', $id);
        $this->db->update('kepegawaian_personil',$data);
        return true;
    }

    function delete_personil($id) 
    {
    	$this->db->where('id', $id);
        $this->db->delete('kepegawaian_personil');
        return true;
    }

    function show_pendidikan($id) 
    {
    	$this->db->from('kepegawaian_pendidikan');
        $this->db->where('id', $id);        
        $query = $this->db->get();
        return $query->row();
    } 

    function show_pendidikan_umum($id_personil) 
    {
    	$this->db->from('kepegawaian_pendidikan');
        $this->db->where('id_personil', $id_personil); 
        $this->db->where('jenis', 1);        
        $query = $this->db->get();
        return $query->result();
    } 	

    function show_pendidikan_militer($id_personil) 
    {
    	$this->db->from('kepegawaian_pendidikan');
        $this->db->where('id_personil', $id_personil); 
        $this->db->where('jenis', 2);        
        $query = $this->db->get();
        return $query->result();
    } 	  

    function insert_pendidikan($data_insert)
    {          
        $this->db->insert('kepegawaian_pendidikan', $data_insert);
        return true;
    }   
    
    function update_pendidikan($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('kepegawaian_pendidikan', $data);
        return true;
    }  

    function delete_pendidikan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kepegawaian_pendidikan');
        return true;
    }

    function update_pendidikan_akhir($id_personil,$data)
    {    	
        $this->db->where('id', $id_personil);
        $this->db->update('kepegawaian_personil', $data);
        return true;
    }  

    function max_pendumum($id_personil)
    {
        $this->db->from('kepegawaian_pendidikan');
        $this->db->where('id_personil', $id_personil);
        $this->db->where('jenis', 1);     
        $this->db->order_by('th_lulus', 'desc');        
        $query = $this->db->get();
		return $query->row();                
    } 

    function max_pendtni($id_personil)
    {
        $this->db->from('kepegawaian_pendidikan');
        $this->db->where('id_personil', $id_personil);
        $this->db->where('jenis', 2);     
        $this->db->order_by('th_lulus', 'desc');        
        $query = $this->db->get();
		return $query->row();                
    }  

    function show_pangkat($id) 
    {
    	$this->db->from('kepegawaian_pangkat');
    	$this->db->join('kepegawaian_master_pangkat', 'kepegawaian_pangkat.pangkat = kepegawaian_master_pangkat.id', 'left');  
        $this->db->where('kepegawaian_pangkat.id', $id);        
        $query = $this->db->get();
        return $query->row();
    }

    function pangkat_personil($id_personil) 
    {
    	$this->db->from('kepegawaian_pangkat'); 
    	$this->db->join('kepegawaian_master_pangkat', 'kepegawaian_pangkat.pangkat = kepegawaian_master_pangkat.id', 'left');     	
        $this->db->where('id_personil', $id_personil);        
        $query = $this->db->get();
        return $query->result();
    } 	  

    function insert_pangkat($data_insert)
    {          
        $this->db->insert('kepegawaian_pangkat', $data_insert);
        return true;
    }   
    
    function update_pangkat($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('kepegawaian_pangkat', $data);
        return true;
    }  

    function update_pangkat_akhir($id_personil,$data)
    {    	
        $this->db->where('id', $id_personil);
        $this->db->update('kepegawaian_personil', $data);
        return true;
    }  

    function get_pangkat(){
        return $this->db->query("SELECT * FROM kepegawaian_master_pangkat");
    }

    function max_pangkat($id_personil)
    {
        $this->db->from('kepegawaian_pangkat');
        $this->db->where('id_personil', $id_personil);
        $this->db->order_by('tmt_pangkat', 'desc');        
        $query = $this->db->get();
		return $query->row();                
    }  

    function delete_pangkat($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kepegawaian_pangkat');
        return true;
    } 

    function show_jabatan($id) 
    {
    	$this->db->from('kepegawaian_jabatan');
        $this->db->where('id', $id);        
        $query = $this->db->get();
        return $query->row();
    } 	

    function jabatan_personil($id_personil) 
    {
    	$this->db->from('kepegawaian_jabatan');
        $this->db->where('id_personil', $id_personil);        
        $query = $this->db->get();
        return $query->result();
    } 	  

    function insert_jabatan($data_insert)
    {          
        $this->db->insert('kepegawaian_jabatan', $data_insert);
        return true;
    }   
    
    function update_jabatan($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('kepegawaian_jabatan', $data);
        return true;
    }  

	function update_jabatan_akhir($id_personil,$data)
	{    	
        $this->db->where('id', $id_personil);
        $this->db->update('kepegawaian_personil', $data);
        return true;
    }  

    function max_jabatan($id_personil)
    {
        $this->db->from('kepegawaian_jabatan');
        $this->db->where('id_personil', $id_personil);
        $this->db->order_by('tmt_jabatan', 'desc');        
        $query = $this->db->get();
		return $query->row();                
    }      

    function delete_jabatan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kepegawaian_jabatan');
        return true;
    }   

    function show_tandajasa($id) 
    {
    	$this->db->from('kepegawaian_tandajasa');
        $this->db->where('id', $id);        
        $query = $this->db->get();
        return $query->row();
    } 	 

    function tandajasa_personil($id_personil) 
    {
    	$this->db->from('kepegawaian_tandajasa');
        $this->db->where('id_personil', $id_personil);        
        $query = $this->db->get();
        return $query->result();
    } 	 

    function insert_tandajasa($data_insert)
    {          
        $this->db->insert('kepegawaian_tandajasa', $data_insert);
        return true;
    }   
    
    function update_tandajasa($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('kepegawaian_tandajasa', $data);
        return true;
    }  

    function delete_tandajasa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kepegawaian_tandajasa');
        return true;
    }    

    function download_daftar_nominatif($jenis) 
    {		
		$this->db->from('kepegawaian_personil'); 
        $this->db->join('kepegawaian_pangkat', 'kepegawaian_personil.pangkat_akhir = kepegawaian_pangkat.id', 'left');
        $this->db->join('kepegawaian_master_pangkat', 'kepegawaian_pangkat.pangkat = kepegawaian_master_pangkat.id', 'left');
        $this->db->join('kepegawaian_jabatan', 'kepegawaian_personil.jabatan_akhir = kepegawaian_jabatan.id', 'left');
        if ($jenis == 1 || $jenis == 2 || $jenis == 3) {
        	$this->db->where('jenis', $jenis);   
        }             
        $query = $this->db->get();
        return $query;
	}

	function download_kekuatan_prajurit_pns() 
	{	
		$select =   array(
            'kepegawaian_master_pangkat.pangkat',
            'IF(count(kepegawaian_personil.pangkat_akhir)=0,"-",count(kepegawaian_personil.pangkat_akhir)) AS total',
            'kepegawaian_master_pangkat.jenis',
        );  
	    $this->db->select($select)
	    ->from('kepegawaian_master_pangkat')
	    ->join('kepegawaian_personil', 'kepegawaian_master_pangkat.id = kepegawaian_personil.pangkat_akhir', 'left')
	    ->where('kepegawaian_master_pangkat.jenis !=', 3)
	    ->group_by('kepegawaian_master_pangkat.pangkat')	 
	    ->order_by('kepegawaian_master_pangkat.id','asc');	    
	    $query = $this->db->get();
        return $query;
    }
}