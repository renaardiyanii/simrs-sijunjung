<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmlistfaktur extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master obat
		// function get_all_faktur(){
		// 	return $this->db->query("SELECT a.id_po, a.no_po, b.company_name as supplier, a.tgl_po, a.no_surat, a.perihal, a.open FROM header_po a JOIN suppliers b ON b.person_id=a.supplier_id WHERE a.no_surat!=''");
		// }

		function get_all_faktur(){
			return $this->db->query("SELECT a.receiving_id, a.no_faktur, b.company_name as supplier, left(a.receiving_time,10) as tanggal, a.jenis_barang as gudang, a.receiving_by as user FROM receivings a JOIN suppliers b ON b.person_id=a.supplier_id");
		}

		function get_data_faktur($id_po){
			return $this->db->query("SELECT a.id_po, a.no_po, a.no_surat FROM header_po a JOIN suppliers b ON b.person_id=a.supplier_id WHERE a.id_po=$id_po");
		}

		function get_detail($id){
			return $this->db->query("SELECT description, qty, satuank, harga_item, (qty*harga_item) as subtotal FROM po WHERE id_po=$id")->result();
		}

		function edit_faktur($id_po, $data){
			$this->db->where('id_po', $id_po);
			$this->db->update('header_po', $data); 
			return true;
		}
	}
?>