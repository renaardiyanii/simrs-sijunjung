<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmobat_sub extends CI_Model{
		function __construct(){
			parent::__construct();
		}


		// Update
		function get_obat_by_gudang($id_gudang){
			return $this->db->query("SELECT o.id_obat, o.nm_obat,o.satuank,o.satuanb,o.faktorsatuan,o.hargabeli,o.hargajual,
			o.kel,o.jenis_obat,o.hapus,o.obatalkes,o.min_stock,o.harga_po,o.barcode,o.margin,o.hargabeli_new,o.deleted,
			g.qty, g.expire_date,g.batch_no,g.quantity_retur,g.id_inventory
			FROM master_obat o
			INNER JOIN gudang_inventory g ON g.id_obat = o.id_obat
			WHERE g.id_gudang = $id_gudang");
		}

		// End Update


		function get_all_obat(){
			return $this->db->query("SELECT *,(select nm_obat from master_obat where master_obat.id_obat = obat_substitusi.id_obat_sub) as nm_obat_substitusi,(select nm_obat from master_obat where master_obat.id_obat = obat_substitusi.id_obat) as nm_obat_utama from obat_substitusi ");
		}

		function get_obat(){
			return $this->db->query("SELECT * FROM master_obat where deleted = '0' and id_obat >= 6000 ");
		}

		function get_poli(){
			return $this->db->query("SELECT * FROM poliklinik where active = '1' ");
		}

		function get_data_obat($id){
			return $this->db->query("SELECT *,(select nm_obat from master_obat 
			where master_obat.id_obat = obat_substitusi.id_obat_sub) as nm_obat_substitusi,
			(select nm_obat from master_obat where master_obat.id_obat = obat_substitusi.id_obat) as nm_obat_utama 
			from obat_substitusi WHERE id = $id");
		}

		function insert_obat($data){
			$this->db->insert('obat_substitusi', $data);
			return true;
		}

		function edit_obat($id_obat_poli, $data){
			$this->db->where('id_obat_poli', $id_obat_poli);
			$this->db->update('obat_poli', $data);
			return true;
		}

		function soft_delete_obat($id_obat_poli){
			$this->db->set('deleted', '1', FALSE);
			$this->db->where('id',$id_obat_poli);
			$this->db->update('obat_substitusi');
			return true;
		}

		function active_obat($id_obat_poli){
			$this->db->set('deleted', '0', FALSE);
			$this->db->where('id',$id_obat_poli);
			$this->db->update('obat_substitusi');
			return true;
		}


	}
?>