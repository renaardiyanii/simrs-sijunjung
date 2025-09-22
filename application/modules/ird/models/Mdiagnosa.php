<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdiagnosa extends CI_Model{
    var $diagnosa_order = array(null,'klasifikasi_diagnos','id_diagnosa');
    var $diagnosa_search = array('klasifikasi_diagnos','id_diagnosa','diagnosa'); 
    var $default_order = array('klasifikasi_diagnos' => 'desc','id_diagnosa_pasien' => 'desc'); 

    function __construct(){
        parent::__construct();
    }

    function autocomplete_irj($q)
    {   
        $query=$this->db->query("
            SELECT * FROM icd1 WHERE id_icd LIKE '%$q%'
            UNION
            SELECT * FROM icd1 WHERE nm_diagnosa LIKE '%$q%' GROUP BY id_icd limit 50"
        );
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row) {
                $new_row['label']=htmlentities(stripslashes($row['id_icd'].' - '.$row['nm_diagnosa']));
                $new_row['value']=htmlentities(stripslashes($row['id_icd'].' - '.$row['nm_diagnosa']));
                $new_row['id_icd']=htmlentities(stripslashes($row['id_icd']));
                $new_row['nm_diagnosa']=htmlentities(stripslashes($row['nm_diagnosa']));                
                $row_set[] = $new_row;
            }
            echo json_encode($row_set);
        } else {        
            echo json_encode([]);
        }
    }

    function insert($data_insert)
    {          
        if (substr($data_insert['no_register'], 0,2) == 'RJ') {  
            $this->db->insert('diagnosa_pasien', $data_insert);
        }
        if (substr($data_insert['no_register'], 0,2) == 'RI') {  
            $this->db->insert('diagnosa_iri', $data_insert);
        }
        return true;
    }   

    function cekdiagnosa_kerja($no_register){
        return $this->db->query("SELECT * FROM pemeriksaan_fisik WHERE no_register='".$no_register."'");
    }

    function insert_irj($data_insert)
    {          
        $this->db->insert('diagnosa_pasien', $data_insert);
        return true;
    }   

    function show_irj($id_diagnosa_pasien) {
        $this->db->FROM('diagnosa_pasien'); 
        $this->db->where('id_diagnosa_pasien', $id_diagnosa_pasien);
        $query = $this->db->get();
        return $query->row();
    }      

    function delete($id_diagnosa_pasien,$no_register)
    {           
        if (substr($no_register, 0,2) == 'RJ') {  
            $this->db->query("DELETE FROM diagnosa_pasien WHERE id_diagnosa_pasien='$id_diagnosa_pasien'");

            $this->db->query("DELETE FROM diagnosa_pasien WHERE id_diagnosa_pasien='$id_diagnosa_pasien'");
        }
        if (substr($no_register, 0,2) == 'RI') {  
            $this->db->query("DELETE FROM diagnosa_iri WHERE id_diagnosa_pasien='$id_diagnosa_pasien'");
        }
        return true;
    }     

    // function delete_irj($id_diagnosa_pasien)
    // {            
    //  $this->db->query("DELETE FROM diagnosa_pasien WHERE id_diagnosa_pasien='$id_diagnosa_pasien'");
    //  return true;
    // }

    function set_utama($id_diagnosa_pasien,$no_register)
    {          
        $this->db->trans_begin();      
        if (substr($no_register, 0,2) == 'RJ') {   
            $this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='tambahan' WHERE klasifikasi_diagnos='utama' AND no_register = '$no_register'");
            $this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='utama' WHERE id_diagnosa_pasien = '$id_diagnosa_pasien' ");
        }
        if (substr($no_register, 0,2) == 'RI') {  
            $this->db->query("UPDATE diagnosa_iri SET klasifikasi_diagnos='tambahan' WHERE klasifikasi_diagnos='utama' AND no_register = '$no_register'");
            $this->db->query("UPDATE diagnosa_iri SET klasifikasi_diagnos='utama' WHERE id_diagnosa_pasien = '$id_diagnosa_pasien' ");
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        } 
        return true;
    }
    
    // function set_utama_irj($id_diagnosa_pasien,$no_register)
    // {          
    //     $this->db->trans_begin();       
    //     $this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='tambahan' WHERE klasifikasi_diagnos='utama' AND no_register = '$no_register'");
    //     $this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='utama' WHERE id_diagnosa_pasien = '$id_diagnosa_pasien' ");
    //     if ($this->db->trans_status() === FALSE) {
    //         $this->db->trans_rollback();
    //     } else {
    //         $this->db->trans_commit();
    //     } 
    //     return true;
    // }

    function auto_utama($no_register)
    {          
        $this->db->trans_begin();       
        if (substr($no_register, 0,2) == 'RJ') {  
            $get_diagnosa = $this->db->query("SELECT id_diagnosa_pasien FROM diagnosa_pasien WHERE no_register = '$no_register' ORDER BY id_diagnosa_pasien ASC LIMIT 1")->row();
            if ($get_diagnosa && $get_diagnosa != NULL) {
                $this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='utama' WHERE no_register = '$no_register' AND id_diagnosa_pasien='$get_diagnosa->id_diagnosa_pasien'");
            }       
        }
        if (substr($no_register, 0,2) == 'RI') { 
            $get_diagnosa = $this->db->query("SELECT id_diagnosa_pasien FROM diagnosa_iri WHERE no_register = '$no_register' ORDER BY id_diagnosa_pasien ASC LIMIT 1")->row();
            if ($get_diagnosa && $get_diagnosa != NULL) {
                $this->db->query("UPDATE diagnosa_iri SET klasifikasi_diagnos='utama' WHERE no_register = '$no_register' AND id_diagnosa_pasien='$get_diagnosa->id_diagnosa_pasien'");
            }      
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        } 
        return true;
    }

  //   function auto_utama_irj($no_register)
  //   {          
  //       $this->db->trans_begin();        
        // $get_diagnosa = $this->db->query("SELECT id_diagnosa_pasien FROM diagnosa_pasien WHERE no_register = '$no_register' ORDER BY id_diagnosa_pasien ASC LIMIT 1")->row();
        // if ($get_diagnosa && $get_diagnosa != NULL) {
        //  $this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='utama' WHERE no_register = '$no_register' AND id_diagnosa_pasien='$get_diagnosa->id_diagnosa_pasien' ");
        // }        
        // if ($this->db->trans_status() === FALSE) {
        //  $this->db->trans_rollback();
        // } else {
        //     $this->db->trans_commit();
        // } 
  //       return true;
  //   } 

    public function count_utama($no_register)
    {                         
        if (substr($no_register, 0,2) == 'RJ') {  
            $this->db->from('diagnosa_pasien');
            $this->db->where('klasifikasi_diagnos','utama');
            $this->db->where('no_register',$no_register);
        }
        if (substr($no_register, 0,2) == 'RI') {  
            $this->db->from('diagnosa_iri');
            $this->db->where('klasifikasi_diagnos','utama');
            $this->db->where('no_register',$no_register);
        }
        return $this->db->count_all_results();                  
    }

 //    public function count_utama_irj($no_register)
 //    {                            
    //  $this->db->from('diagnosa_pasien');
    //  $this->db->where('klasifikasi_diagnos','utama');
    //  $this->db->where('no_register',$no_register);
    //  return $this->db->count_all_results();                  
    // }

    public function count_limit($no_register)
    {   
        if (substr($no_register, 0,2) == 'RJ') {  
            $this->db->from('diagnosa_pasien');        
            $this->db->where('no_register',$no_register);
        }
        if (substr($no_register, 0,2) == 'RI') {  
            $this->db->from('diagnosa_iri');
            $this->db->where('no_register',$no_register);
        }
        return $this->db->count_all_results();                  
    }

    // public function count_limit_irj($no_register)
    // {                           
    //     $this->db->from('diagnosa_pasien');        
    //     $this->db->where('no_register',$no_register);
    //     return $this->db->count_all_results();                  
    // }

    private function show_query()  
    {
        $no_register = $this->input->post('no_register');
        if (substr($no_register, 0,2) == 'RJ') {  
            $this->db->FROM('diagnosa_pasien');
            $this->db->where('diagnosa_pasien.no_register',$no_register);
            $this->db->select('diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.id_diagnosa_pasien,diagnosa_pasien.id_diagnosa,diagnosa_pasien.diagnosa,diagnosa_pasien.diagnosa_text');
        }
        if (substr($no_register, 0,2) == 'RI') {  
            $this->db->from('diagnosa_iri');
            $this->db->where('diagnosa_iri.no_register',$no_register);
            $this->db->select('diagnosa_iri.klasifikasi_diagnos,diagnosa_iri.id_diagnosa_pasien,diagnosa_iri.id_diagnosa,diagnosa_iri.diagnosa,diagnosa_iri.diagnosa_text');
        }
    
        $i = 0;     
        foreach ($this->diagnosa_search as $item)
        {
            if($_POST['search']['value'])
            {    
                if($i===0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->diagnosa_search) - 1 == $i)
                    $this->db->group_end();
            }
                $i++;
            }
             
            if(isset($_POST['order'])) // here order processing
            {
                $this->db->order_by($this->diagnosa_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->default_order))
            {
                $order = $this->default_order;
                $this->db->order_by(key($order), $order[key($order)]);
            }         
    } 

    public function get_diagnosa()
    {
        $this->show_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }  

    public function filtered()
    {
        $this->show_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $no_register = $this->input->post('no_register');
        if (substr($no_register, 0,2) == 'RJ') {  
            $this->db->FROM('diagnosa_pasien');
            $this->db->where('diagnosa_pasien.no_register',$no_register);  
        } 
        if (substr($no_register, 0,2) == 'RI') {  
            $this->db->FROM('diagnosa_iri');
            $this->db->where('diagnosa_iri.no_register',$no_register);  
        } 
        return $this->db->count_all_results();
    }    

    public function pelayanan($no_register)
    {
        if (substr($no_register, 0,2) == 'RJ') {
            $this->db->from('diagnosa_pasien'); 
        }
        if (substr($no_register, 0,2) == 'RI') {
            $this->db->from('diagnosa_iri'); 
        }
        $this->db->where('no_register', $no_register);
        $this->db->order_by('klasifikasi_diagnos', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function select2($keyword){
        // $this->db->select('id_icd, nm_diagnosa');
        // $this->db->from('icd1');
        // $this->db->like('id_icd', $keyword);
        // $this->db->or_like('nm_diagnosa', $keyword); 
        // $this->db->or_like('diagnosa_indonesia', $keyword); 
        // $this->db->where('deleted = 0'); 
        // $query = $this->db->get();
        // return $query->result();

        return $this->db->query("SELECT 
            id_icd, 
            nm_diagnosa 
        FROM 
            icd1 
        WHERE 
            deleted = 0 
            AND (id_icd LIKE '%$keyword%' OR nm_diagnosa LIKE '%$keyword%' OR diagnosa_indonesia LIKE '%$keyword%')")->result();
    }

    function insert_data_fisik($data_insert){
        $this->db->insert('pemeriksaan_fisik', $data_insert);
        return true;
    }
    
    function update_data_fisik($no_register,$data_insert){
        $this->db->where('no_register',$no_register);
        $this->db->update('pemeriksaan_fisik', $data_insert);
        return true;
    }

    function getdata_tindakan_fisik($no_register)
	{
		return $this->db->query("SELECT *
		                         FROM pemeriksaan_fisik 
		                         where no_register='" . $no_register . "'");
	}


}
?>
