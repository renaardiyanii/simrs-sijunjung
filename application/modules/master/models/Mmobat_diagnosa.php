<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmobat_diagnosa extends CI_Model{
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
			return $this->db->query("SELECT id_obat_diagnosa,nm_obat,nm_diagnosa,obat_diagnosa.id_diagnosa as id_diagnosa_obat_diagnosa,satuank,satuanb,min_stock,obat_diagnosa.deleted as delete_obat_diagnosa 
			FROM obat_diagnosa 
			left join master_obat on master_obat.id_obat = obat_diagnosa.id_obat
			left join icd1 on icd1.id_icd = obat_diagnosa.id_diagnosa
			ORDER BY obat_diagnosa.id_obat");
		}

		function get_obat(){
			return $this->db->query("SELECT * FROM master_obat where deleted = '0' ");
		}

		function get_diagnosa(){
			return $this->db->query("SELECT * FROM icd1 where deleted = '0' ");
		}

		function get_data_obat($id_obat_diagnosa){
			return $this->db->query("SELECT nm_diagnosa,id_obat_diagnosa,nm_obat,obat_diagnosa.id_diagnosa as id_diagnosa_obat_diagnosa,obat_diagnosa.id_obat  as id_obat_obat_diagnosa
			FROM obat_diagnosa 
			join master_obat on master_obat.id_obat = obat_diagnosa.id_obat 
			join icd1 on icd1.id_icd = obat_diagnosa.id_diagnosa 
			WHERE id_obat_diagnosa='$id_obat_diagnosa'");
		}

		function insert_obat($data){
			$this->db->insert('obat_diagnosa', $data);
			return true;
		}

		function edit_obat($id_obat_diagnosa, $data){
			$this->db->where('id_obat_diagnosa', $id_obat_diagnosa);
			$this->db->update('obat_diagnosa', $data); 
			return true;
		}

		function soft_delete_obat($id_obat_diagnosa){
			$this->db->set('deleted', '1', FALSE);
			$this->db->where('id_obat_diagnosa',$id_obat_diagnosa);
			$this->db->update('obat_diagnosa');
			return true;
		}

		function active_obat($id_obat_diagnosa){
			$this->db->set('deleted', '0', FALSE);
			$this->db->where('id_obat_diagnosa',$id_obat_diagnosa);
			$this->db->update('obat_diagnosa');
			return true;
		}


	}
?>