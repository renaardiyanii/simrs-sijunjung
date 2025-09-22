<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmobat_poli extends CI_Model{
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
			return $this->db->query("SELECT id_obat_poli,nm_obat,nm_poli,obat_poli.id_poli as id_poli_obat_poli,satuank,satuanb,min_stock,obat_poli.deleted as delete_obat_poli
			FROM obat_poli
			left join master_obat on master_obat.id_obat = obat_poli.id_obat
			left join poliklinik on poliklinik.id_poli = obat_poli.id_poli
			ORDER BY obat_poli.id_obat");
		}

		function get_obat(){
			return $this->db->query("SELECT * FROM master_obat where deleted = '0' ");
		}

		function get_poli(){
			return $this->db->query("SELECT * FROM poliklinik where active = '1' ");
		}

		function get_data_obat($id_obat_poli){
			return $this->db->query("SELECT nm_poli,id_obat_poli,nm_obat,obat_poli.id_poli as id_poli_obat_poli,obat_poli.id_obat  as id_obat_obat_poli
			FROM obat_poli
			join master_obat on master_obat.id_obat = obat_poli.id_obat
			join poliklinik on poliklinik.id_poli = obat_poli.id_poli
			WHERE id_obat_poli='$id_obat_poli'");
		}

		function insert_obat($data){
			$this->db->insert('obat_poli', $data);
			return true;
		}

		function edit_obat($id_obat_poli, $data){
			$this->db->where('id_obat_poli', $id_obat_poli);
			$this->db->update('obat_poli', $data);
			return true;
		}

		function soft_delete_obat($id_obat_poli){
			$this->db->set('deleted', '1', FALSE);
			$this->db->where('id_obat_poli',$id_obat_poli);
			$this->db->update('obat_poli');
			return true;
		}

		function active_obat($id_obat_poli){
			$this->db->set('deleted', '0', FALSE);
			$this->db->where('id_obat_poli',$id_obat_poli);
			$this->db->update('obat_poli');
			return true;
		}


	}
?>