<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmobat extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		function get_obat_by_gudang_amprah($id_gudang){
			return $this->db->query("SELECT o.id_obat, o.nm_obat,o.satuank,o.satuanb,o.faktorsatuan,o.hargabeli,o.hargajual,
			o.kel,o.jenis_obat,o.hapus,o.obatalkes,o.min_stock,o.harga_po,o.barcode,o.margin,o.hargabeli_new,o.deleted,
			g.qty, g.expire_date,g.batch_no,g.quantity_retur,g.id_inventory
			FROM master_obat o
			LEFT JOIN gudang_inventory g ON g.id_obat = o.id_obat
			WHERE g.id_gudang = '$id_gudang' and o.deleted = '0' 
			and DATE_PART('year', g.expire_date::date) - DATE_PART('year', now()::date) >= 0
        	and (DATE_PART('year', g.expire_date::date) - DATE_PART('year', now()::date)) * 12 +
              (DATE_PART('month', g.expire_date::date) - DATE_PART('month', now()::date)) >= 1 ");
		}

		// End Update

		function get_all_inventory($gudang){
			return $this->db->query("SELECT a.id_obat, b.nm_obat, b.hargabeli, b.hargajual, b.margin, b.satuank, b.satuanb, b.kel, b.jenis_obat, b.min_stock FROM gudang_inventory a, master_obat b where a.id_obat = b.id_obat and id_gudang = $gudang ORDER BY a.id_obat");
		}


		// Update 
		function get_obat_by_gudang($id_gudang){
			return $this->db->query("SELECT o.id_obat, o.nm_obat,o.satuank,o.satuanb,o.faktorsatuan,o.hargabeli,o.hargajual,
			o.kel,o.jenis_obat,o.hapus,o.obatalkes,o.min_stock,o.harga_po,o.barcode,o.margin,o.hargabeli_new,o.deleted,
			g.qty, g.expire_date,g.batch_no,g.quantity_retur,g.id_inventory,o.golongan_obat
			FROM master_obat o
			LEFT JOIN gudang_inventory g ON g.id_obat = o.id_obat
			WHERE g.id_gudang = '$id_gudang' and o.deleted = '0' ");
		}

		function get_obat_by_gudang_for_penerimaan($id_gudang){
			return $this->db->query("SELECT o.id_obat, o.nm_obat,o.satuank,o.satuanb,o.faktorsatuan,o.hargabeli,o.hargajual,
			o.kel,o.jenis_obat,o.hapus,o.obatalkes,o.min_stock,o.harga_po,o.barcode,o.margin,o.hargabeli_new,o.deleted
						-- g.qty, g.expire_date,g.batch_no,g.quantity_retur,g.id_inventory
			FROM master_obat o
			-- LEFT JOIN gudang_inventory g ON g.id_obat = o.id_obat
			-- WHERE g.id_gudang = '$id_gudang' and 
			WHERE o.deleted = '0' ");
		}

		function get_obat_by_gudang_for_adjust($id_gudang){
			return $this->db->query("SELECT o.id_obat, o.nm_obat,o.satuank,o.satuanb,o.faktorsatuan,o.hargabeli,o.hargajual,
			o.kel,o.jenis_obat,o.hapus,o.obatalkes,o.min_stock,o.harga_po,o.barcode,o.margin,o.hargabeli_new,o.deleted,
			g.qty, g.expire_date,g.batch_no,g.quantity_retur,g.id_inventory,o.golongan_obat
			FROM master_obat o
			LEFT JOIN gudang_inventory g ON g.id_obat = o.id_obat
			WHERE g.id_gudang = '$id_gudang' and o.deleted = '0' ");
		}

		function get_obat_by_gudang_for_distribusi($id_gudang){
			return $this->db->query("SELECT o.id_obat, o.nm_obat,o.satuank,o.satuanb,o.faktorsatuan,o.hargabeli,o.hargajual,
			o.kel,o.jenis_obat,o.hapus,o.obatalkes,o.min_stock,o.harga_po,o.barcode,o.margin,o.hargabeli_new,o.deleted,
			g.qty, g.expire_date,g.batch_no,g.quantity_retur,g.id_inventory,o.golongan_obat
			FROM master_obat o
			LEFT JOIN gudang_inventory g ON g.id_obat = o.id_obat
			WHERE g.id_gudang = '$id_gudang' and o.deleted = '0' ");
		}


		// End Update


		function get_all_obat(){
			return $this->db->query("SELECT id_obat, nm_obat, hargabeli, hargajual, satuank, satuanb, kel,golongan_obat, jenis_obat, min_stock,deleted FROM master_obat where deleted = 0 ORDER BY id_obat");
		}

		function get_all_obat_master_(){
			return $this->db->query("SELECT id_obat,nm_obat,nama_generik,satuank,jenis_obat,golongan_obat,kemasan,kategori6,
			(select nm_kelompok  from master_kelompok_obat where master_kelompok_obat.kode = master_obat.kelompok ) as nama_kelompok,
			(select bentuk_sediaan  from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok ) as nama_subkelompok,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori1 ) as kategori1,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori2 ) as kategori2,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori3 ) as kategori3,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori4 ) as kategori4,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori5 ) as kategori5,
			deleted,formularium from master_obat  ORDER BY id_obat desc");
		}

		function get_all_obat_master(){
			return $this->db->query("SELECT
						id_obat,
					nm_obat,
					satuank,
					deleted,
					(select nm_kategori_1 from master_kategori_obat where master_kategori_obat.id = master_obat.kategori_obat) as kategori
				FROM
					master_obat 
				ORDER BY
					id_obat DESC");
		}

		function get_all_obat_aktif(){
			return $this->db->query("SELECT id_obat, nm_obat, hargabeli, hargajual, satuank, satuanb, kel,golongan_obat, jenis_obat, min_stock,deleted FROM master_obat where deleted = '0' ORDER BY id_obat");
		}

		function get_data_satuan(){
			return $this->db->query("SELECT * FROM obat_satuan");
		}

		function get_data_satuan_obat(){
			return $this->db->query("SELECT * FROM obat_satuan");
		}

		function get_data_kemasan_obat(){
			return $this->db->query("SELECT * FROM kemasan_obat");
		}


		function get_data_kelompok(){
			return $this->db->query("SELECT * FROM obat_kelompok ORDER BY nm_satuan ASC");
		}

		function get_data_kelompok_obat(){
			return $this->db->query("SELECT * FROM master_kelompok_obat ORDER BY nm_kelompok ASC");
		}

		function get_data_subkelompok_obat(){
			return $this->db->query("SELECT * FROM master_subkelompok_obat ORDER BY bentuk_sediaan ASC");
		}

		function get_data_generik_obat(){
			return $this->db->query("SELECT * FROM obat_generik ORDER BY nm_generik ASC");
		}

		function get_data_kategori_satu(){
			return $this->db->query("SELECT * FROM master_kategori_obat where kategori = '1' ORDER BY nama_kategori ASC");
		}

		function get_data_kategori_dua(){
			return $this->db->query("SELECT * FROM master_kategori_obat where kategori = '2' ORDER BY nama_kategori ASC");
		}

		function get_data_kategori_tiga(){
			return $this->db->query("SELECT * FROM master_kategori_obat where kategori = '3' ORDER BY nama_kategori ASC");
		}

		function get_data_kategori_empat(){
			return $this->db->query("SELECT * FROM master_kategori_obat where kategori = '4' ORDER BY nama_kategori ASC");
		}

		function get_data_kategori_lima(){
			return $this->db->query("SELECT * FROM master_kategori_obat where kategori = '5' ORDER BY nama_kategori ASC");
		}

		function get_data_jenis(){
			return $this->db->query("SELECT * FROM obat_jenis ORDER BY nm_jenis ASC");
		}

		function get_data_golongan(){
			return $this->db->query("SELECT * FROM obat_golongan ORDER BY nm_golongan ASC");
		}

		function get_data_obat($id_obat){
			return $this->db->query("SELECT * FROM master_obat WHERE id_obat='$id_obat'");
		}

		function insert_obat($data){
			$this->db->insert('master_obat', $data);
			return $this->db->insert_id();
		}

		function edit_obat($id_obat, $data){
			$this->db->where('id_obat', $id_obat);
			$this->db->update('master_obat', $data); 
			return true;
		}

		function soft_delete_obat($id_obat){
			$this->db->set('deleted', '1', FALSE);
			$this->db->where('id_obat',$id_obat);
			$this->db->update('master_obat');
			return true;
		}

		function active_obat($id_obat){
			$this->db->set('deleted', '0', FALSE);
			$this->db->where('id_obat',$id_obat);
			$this->db->update('master_obat');
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
			$this->db->set('deleted',0);
			$this->db->insert('kebijakan_obat', $data);
			return true;
		}

		function soft_delete_kebijakan($id_obat){
			$this->db->set('deleted', '1', FALSE);
			$this->db->where('id_kebijakan',$id_obat);
			$this->db->update('kebijakan_obat');
			return true;
		}


		function edit_kebijakan($id_kebijakan, $data){
			$this->db->where('id_kebijakan', $id_kebijakan);
			$this->db->update('kebijakan_obat', $data); 
			return true;
		}

		function getAllObat_adaStok(){
            return $this->db->query("SELECT o.id_obat, o.nm_obat, g.qty, g.batch_no
                FROM master_obat o
                INNER JOIN gudang_inventory g ON g.id_obat = o.id_obat
                WHERE g.qty > 0 AND g.id_gudang = 1  ORDER BY o.nm_obat");
        }

        function get_paket_obat(){
			return $this->db->get("paket_obat");
		}

        function get_paket_obat_by_id($id_paket){
            return $this->db->query("SELECT * FROM paket_obat WHERE id_paket = ".$id_paket);
        }

		function get_paket_obat_detail($id_paket){
			return $this->db->query("SELECT po.*,(select nm_obat from master_obat where po.id_obat = master_obat.id_obat )
							FROM paket_obat_detail po
							
							WHERE po.id_paket = ".$id_paket." ");
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

        function get_last_obat(){
            return $this->db->query("SELECT * FROM master_obat order by id_obat desc limit 1");
        }

		function insert_obat_to_gudang($data){
			$this->db->insert('gudang_inventory', $data);
			return true;
		}

        function get_all_gudang(){
            return $this->db->query("SELECT * from master_gudang order by id_gudang");
        }

		function get_all_obat_by_kelompok($kel){
			return $this->db->query("SELECT id_obat,nm_obat,nama_generik,satuank,jenis_obat,golongan_obat,produksi,kelompok,subkelompok,kemasan,kategori6,
			(select nm_kelompok  from master_kelompok_obat where master_kelompok_obat.kode = master_obat.kelompok ) as nama_kelompok,
			(select bentuk_sediaan  from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok ) as nama_subkelompok,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori1 ) as kategori1,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori2 ) as kategori2,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori3 ) as kategori3,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori4 ) as kategori4,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori5 ) as kategori5,
			deleted,formularium from master_obat where id_obat >=6000 and kelompok = '$kel' ORDER BY id_obat");
		}

		function get_all_obat_by_subkelompok($kel){
			return $this->db->query("SELECT id_obat,nm_obat,nama_generik,satuank,jenis_obat,golongan_obat,produksi,kelompok,subkelompok,kemasan,kategori6,
			(select nm_kelompok  from master_kelompok_obat where master_kelompok_obat.kode = master_obat.kelompok ) as nama_kelompok,
			(select bentuk_sediaan  from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok ) as nama_subkelompok,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori1 ) as kategori1,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori2 ) as kategori2,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori3 ) as kategori3,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori4 ) as kategori4,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori5 ) as kategori5,
			deleted,formularium from master_obat where id_obat >=6000 and subkelompok = '$kel' ORDER BY id_obat");
		}

		function get_all_obat_by_subkelompok_kel($kel,$pok){
			return $this->db->query("SELECT id_obat,nm_obat,nama_generik,satuank,jenis_obat,golongan_obat,produksi,kelompok,subkelompok,kemasan,kategori6,
			(select nm_kelompok  from master_kelompok_obat where master_kelompok_obat.kode = master_obat.kelompok ) as nama_kelompok,
			(select bentuk_sediaan  from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok ) as nama_subkelompok,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori1 ) as kategori1,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori2 ) as kategori2,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori3 ) as kategori3,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori4 ) as kategori4,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori5 ) as kategori5,
			deleted,formularium from master_obat where id_obat >=6000 and subkelompok = '$kel' and kelompok = '$pok' ORDER BY id_obat");
		}

		function get_all_obat_by_jenis($jns){
			return $this->db->query("SELECT id_obat,nm_obat,nama_generik,satuank,jenis_obat,golongan_obat,produksi,kelompok,subkelompok,kemasan,kategori6,
			(select nm_kelompok  from master_kelompok_obat where master_kelompok_obat.kode = master_obat.kelompok ) as nama_kelompok,
			(select bentuk_sediaan  from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok ) as nama_subkelompok,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori1 ) as kategori1,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori2 ) as kategori2,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori3 ) as kategori3,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori4 ) as kategori4,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori5 ) as kategori5,
			deleted,formularium from master_obat where id_obat >=6000 and jenis_obat = '$jns' ORDER BY id_obat");
		}

		function get_all_obat_by_jns_kel($jns,$kel){
			return $this->db->query("SELECT id_obat,nm_obat,nama_generik,satuank,jenis_obat,golongan_obat,produksi,kelompok,subkelompok,kemasan,kategori6,
			(select nm_kelompok  from master_kelompok_obat where master_kelompok_obat.kode = master_obat.kelompok ) as nama_kelompok,
			(select bentuk_sediaan  from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok ) as nama_subkelompok,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori1 ) as kategori1,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori2 ) as kategori2,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori3 ) as kategori3,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori4 ) as kategori4,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori5 ) as kategori5,
			deleted,formularium from master_obat where id_obat >=6000 and jenis_obat = '$jns' and kelompok = '$kel' ORDER BY id_obat");
		}

		function get_all_obat_by_jns_sub($jns,$sub){
			return $this->db->query("SELECT id_obat,nm_obat,nama_generik,satuank,jenis_obat,golongan_obat,produksi,kelompok,subkelompok,kemasan,kategori6,
			(select nm_kelompok  from master_kelompok_obat where master_kelompok_obat.kode = master_obat.kelompok ) as nama_kelompok,
			(select bentuk_sediaan  from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok ) as nama_subkelompok,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori1 ) as kategori1,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori2 ) as kategori2,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori3 ) as kategori3,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori4 ) as kategori4,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori5 ) as kategori5,
			deleted,formularium from master_obat where id_obat >=6000 and jenis_obat = '$jns' and subkelompok = '$sub' ORDER BY id_obat");
		}

		
		function get_all_obat_by_jns_sub_kel($jns,$sub,$kel){
			return $this->db->query("SELECT id_obat,nm_obat,nama_generik,satuank,jenis_obat,golongan_obat,produksi,kelompok,subkelompok,kemasan,kategori6,
			(select nm_kelompok  from master_kelompok_obat where master_kelompok_obat.kode = master_obat.kelompok ) as nama_kelompok,
			(select bentuk_sediaan  from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok ) as nama_subkelompok,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori1 ) as kategori1,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori2 ) as kategori2,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori3 ) as kategori3,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori4 ) as kategori4,
			(select nama_kategori  from master_kategori_obat where master_kategori_obat.kode = master_obat.kategori5 ) as kategori5,
			deleted,formularium from master_obat where id_obat >=6000 and jenis_obat = '$jns' and subkelompok = '$sub' and kelompok = '$kel' ORDER BY id_obat");
		}

		function getdata_resep_racik($id_paket){
			return $this->db->query("SELECT *, (SELECT nm_obat FROM master_obat WHERE id_obat=a.item_obat) as nm_obat 
				FROM obat_racikan AS a where id_paket=".$id_paket." AND no_resep IS NULL");
		}

		function get_paket_obat_detail2($id_paket){
			return $this->db->query("SELECT * FROM paket_obat_detail WHERE id_paket = ".$id_paket." AND id_obat IS NULL");
		}
		function hapus_data_obat($id){
			$this->db->where('id', $id);
			$this->db->where('racikan',0);
       		$this->db->delete('paket_obat_detail');			
			return true;
		}

		function get_id($nm_obat){
			return $this->db->query("SELECT * FROM master_obat WHERE nm_obat = '$nm_obat'");
		}

		function insert_permintaan($data){
			$this->db->insert('paket_obat_detail', $data);
			return $this->db->insert_id();
		}

		function get_id_resep($id_paket, $nama_obat){
			return $this->db->query("SELECT id FROM paket_obat_detail WHERE id_paket='$id_paket' AND nama_obat='$nama_obat'LIMIT 1");
		}

		function get_all_kategori(){
			return $this->db->query("SELECT * from master_kategori_obat
				ORDER BY
					id ASC");
		}

	}
?>