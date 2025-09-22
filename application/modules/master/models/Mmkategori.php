<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mmkategori extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function get_all_kategori() {
        return $this->db->query("SELECT * FROM master_kategori");
    }

    function delete_kategori($id) {
        return $this->db->query("DELETE FROM master_kategori WHERE id_kategori = '$id'");
    }

    function get_data_edit_kategori($id) {
        return $this->db->query("SELECT * FROM master_kategori WHERE id_kategori = '$id'");
    }

    function update_kategori($id, $data) {
        $this->db->where('id_kategori', $id);
        $this->db->update('master_kategori', $data);
        return true;
    }

    function insert_kategori($data) {
        $this->db->insert('master_kategori', $data);
        return true;
    }
}