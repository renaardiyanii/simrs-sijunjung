<?php
class Muploadtindakan extends CI_Model {
    function insert_jenis_tindakan_upload($data){
        foreach($data as $result){
            $this->db->insert("jenis_tindakan_upload", $result);
        }
    }

    function insert_tarif_tindakan_upload($data){
        foreach($data as $result){
            $this->db->insert("tarif_tindakan_upload", $result);
        }
        // print_r($this->db->affected_rows());
        // exit();
        return $this->db->affected_rows();
    }

    function remove_jenis_tindakan_upload(){
        $this->db->empty_table("jenis_tindakan_upload");
    }

    function remove_tarif_tindakan_upload(){
        $this->db->empty_table("tarif_tindakan_upload");
    }

    function update_tarif_tindakan_from_excel($data){
        foreach($data as $result){
            // $this->db->set("Name",$result["name"],FALSE);
            // $this->db->set("Harga",$result["price"],FALSE);
            $this->db->where("id", $result["id"]);
            $this->db->update("aa_test_scheduler",$result);
        }
    }
}
?>