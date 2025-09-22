<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmexpendobat extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master obat
		function get_all_obat(){
			// return $this->db->query("SELECT mo.id_obat, mo.nm_obat, g.qty FROM master_obat mo JOIN gudang_inventory g ON g.id_obat = mo.id_obat ORDER BY id_obat");
			
			// $this->db->query("SELECT mo.id_obat, mo.nm_obat, sum(g.qty) AS qty FROM master_obat mo LEFT JOIN gudang_inventory g ON g.id_obat = mo.id_obat GROUP BY mo.id_obat ORDER BY mo.id_obat");
			// $this->db->query("SELECT sum( rp.qty ) AS qtyused FROM master_obat mo LEFT JOIN resep_pasien rp ON rp.item_obat = mo.id_obat GROUP BY mo.id_obat  ORDER BY mo.id_obat");

			return $this->db->query("SELECT mo.id_obat AS id, mo.nm_obat AS nama, g.qty AS stock, rp.qtyused AS pemakaian FROM ( SELECT id_obat, nm_obat FROM master_obat ) mo LEFT JOIN ( SELECT id_obat, SUM( qty ) AS qty FROM gudang_inventory GROUP BY id_obat ) g ON g.id_obat = mo.id_obat LEFT JOIN ( SELECT item_obat, SUM( qty ) AS qtyused FROM resep_pasien GROUP BY item_obat ) rp ON rp.item_obat = mo.id_obat GROUP BY mo.id_obat ORDER BY mo.id_obat"); 
		}

		function get_detail_pengeluaran($id){
			return $this->db->query("SELECT dp.nama, rp.qty, rp.tgl_kunjungan FROM data_pasien dp JOIN resep_pasien rp ON rp.no_medrec = dp.no_medrec WHERE rp.item_obat='$id' AND rp.cetak_faktur=1 ORDER BY rp.tgl_kunjungan ASC")->result();
		}
	}
?>