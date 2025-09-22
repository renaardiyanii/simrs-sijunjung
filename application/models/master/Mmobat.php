<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmobat extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master obat
		function get_all_obat(){
			return $this->db->query("SELECT id_obat, nm_obat, hargabeli, hargajual, satuank, satuanb, kel, jenis_obat, min_stock FROM master_obat ORDER BY id_obat");
		}

		function get_data_satuan(){
			return $this->db->query("SELECT * FROM obat_satuan");
		}

		function get_data_kelompok(){
			return $this->db->query("SELECT * FROM obat_kelompok ORDER BY nm_satuan ASC");
		}

		function get_data_jenis(){
			return $this->db->query("SELECT * FROM obat_jenis ORDER BY nm_jenis ASC");
		}

		function get_data_obat($id_obat){
			return $this->db->query("SELECT * FROM master_obat WHERE id_obat='$id_obat'");
		}

		function insert_obat($data){
			$this->db->insert('master_obat', $data);
			return true;
		}

		function edit_obat($id_obat, $data){
			$this->db->where('id_obat', $id_obat);
			$this->db->update('master_obat', $data); 
			return true;
		}

		//kebijakan obat
		function get_all_kebijakan(){
			return $this->db->query("SELECT * FROM kebijakan_obat");
		}

		function get_data_kebijakan($id_kebijakan){
			return $this->db->query("SELECT *  FROM kebijakan_obat WHERE id_kebijakan='$id_kebijakan'");
		}

		function insert_kebijakan($data){
			$this->db->insert('kebijakan_obat', $data);
			return true;
		}

		function edit_kebijakan($id_kebijakan, $data){
			$this->db->where('id_kebijakan', $id_kebijakan);
			$this->db->update('kebijakan_obat', $data); 
			return true;
		}

		function getAllObat_adaStok(){
            return $this->db->query("SELECT o.`id_obat`, o.`nm_obat`, g.`qty`, g.`batch_no`
                FROM master_obat o
                INNER JOIN gudang_inventory g ON g.`id_obat` = o.`id_obat`
                WHERE g.`qty` > 0 AND g.`id_gudang` = 1 GROUP BY o.id_obat ORDER BY o.nm_obat");
        }

        function get_paket_obat(){
			return $this->db->get("paket_obat");
		}

        function get_paket_obat_by_id($id_paket){
            return $this->db->query("SELECT * FROM paket_obat WHERE id_paket = ".$id_paket);
        }

		function get_paket_obat_detail($id_paket){
			return $this->db->query("SELECT po.*, mo.nm_obat, mo.satuank, mo.hargajual, g.id_inventory
							FROM paket_obat_detail po
							INNER JOIN master_obat mo ON mo.id_obat = po.id_obat
							INNER JOIN gudang_inventory g ON g.id_obat = po.id_obat
							WHERE po.id_paket = ".$id_paket." AND g.qty > 0 GROUP BY g.id_obat");
		}

		function get_data_paket($id_paket){
		    return $this->db->query("SELECT * FROM paket_obat WHERE id_paket = ".$id_paket);
        }

		function update_table($table, $data, $where){
            return $this->db->update($table, $data, $where);
        }

        function insert_table($table, $data){
        	return $this->db->insert($table, $data);
		}

		function delete_table($table, $where){
        	return $this->db->delete($table, $where);
		}
	}
?>