<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmlaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}



		function get_data_keuangan_tgl($tgl){
			return $this->db->query("SELECT no_register, item_obat, nama_obat, qty, vtot
				FROM resep_pasien
				WHERE left(tgl_kunjungan,10) = '$tgl'
				AND cetak_kwitansi='1'
				ORDER BY item_obat");
		}

		// function get_data_periode_bln($bln){
		// 	return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
		// 		FROM resep_pasien
		// 		WHERE left(tgl_kunjungan,7)  = '$bln'
		// 		GROUP BY tgl");
		// }

		// function get_data_keuangan_bln($bln){
		// 	return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, item_obat, nama_obat, biaya_obat, count(item_obat) as jumlah, sum(vtot) as total
		// 		FROM resep_pasien
		// 		WHERE left(tgl_kunjungan,7) = '$bln'
		// 		GROUP BY tgl, item_obat
		// 		ORDER BY item_obat");
		// }

		function get_data_periode_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7)  = '$bln' and cara_bayar='$cara_bayar'
				GROUP BY tgl");
		}

		function get_data_keuangan_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, item_obat, nama_obat, biaya_obat, cara_bayar, count(*) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7) = '$bln' and cara_bayar='$cara_bayar'
				GROUP BY item_obat, tgl
				ORDER BY tgl, item_obat");
		}

		function get_data_periode_thn($thn){
			return $this->db->query("SELECT left(receivings.receiving_time,7) as bln, count(1) as jum_pem
				FROM receivings
				WHERE left(receivings.receiving_time,4) ='$thn'
				GROUP BY bln");
		}

		function get_data_keuangan_thn($thn){
			return $this->db->query("SELECT left(receivings.receiving_time,7) as bln, suppliers.company_name, 
receivings_items.description, count(receivings_items.quantity_purchased) as jumlah, 
sum(receivings_items.item_cost_price) as total
FROM receivings, receivings_items, suppliers
WHERE receivings.receiving_id = receivings_items.receiving_id 
and suppliers.person_id = receivings.supplier_id and left(receivings.receiving_time,4) = '$thn'
GROUP BY bln, suppliers.company_name");
		}

		function get_data_periode_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4)  = '$thn' and cara_bayar='$cara_bayar'
				GROUP BY bln");
		}

		function get_data_keuangan_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, item_obat, nama_obat, biaya_obat, cara_bayar, count(*) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4) = '$thn' and cara_bayar='$cara_bayar'
				GROUP BY item_obat, bln
				ORDER BY bln, item_obat");
		}
///////////////////////////////////////////////////////////////////////////////////////////////////////////// edited ibnu

		function get_data_keuangan_bln($bln){
			return $this->db->query("SELECT left(receivings.receiving_time,10) as tgl, suppliers.company_name, receivings_items.description, count(receivings_items.quantity_purchased) as jumlah, sum(receivings_items.item_cost_price) as total
				FROM receivings, receivings_items, suppliers
				WHERE receivings.receiving_id = receivings_items.receiving_id and suppliers.person_id = receivings.supplier_id and left(receivings.receiving_time,7) = '$bln'
				GROUP BY tgl, suppliers.company_name");
		}

		function row_table_perbln($bln){
			return $this->db->query("SELECT Count(*)
				FROM receivings_items, receivings, suppliers
				WHERE receivings.receiving_id = receivings_items.receiving_id AND left(receivings.tgl_kunjungan,7)  = '$bln'
				GROUP BY suppliers.company_name");
		}

		function get_data_periode_bln($bln){
			return $this->db->query("SELECT left(receivings.receiving_time,10) as tgl, count(1) as jum_pem
				FROM receivings
				WHERE left(receivings.receiving_time,7) ='$bln'
				GROUP BY tgl");
		}
		function get_data_keu_tindakan_today(){
			return $this->db->query("SELECT receivings.supplier_id, a.company_name, b.description, b.quantity_purchased, b.item_cost_price 
				FROM suppliers as a, receivings_items as b, receivings 
				WHERE a.person_id=receivings.supplier_id AND b.receiving_id=receivings.receiving_id and left(receivings.receiving_time,10)=left(now(),10) group by receivings.supplier_id");
		}

		function get_data_keu_tind_tgl($tgl){
			return $this->db->query("SELECT receivings.supplier_id, a.company_name, b.description, b.quantity_purchased, b.item_cost_price 
				FROM suppliers as a, receivings_items as b, receivings 
				WHERE a.person_id=receivings.supplier_id AND b.receiving_id=receivings.receiving_id and left(receivings.receiving_time,10)='$tgl' group by receivings.supplier_id");
		}

		function get_data_keu_detail_tgl($tgl){
			return $this->db->query("SELECT receivings.supplier_id, a.company_name, b.description, b.quantity_purchased, b.item_cost_price, m.hargabeli 
				FROM suppliers as a, master_obat AS m, receivings_items as b, receivings 
				WHERE a.person_id=receivings.supplier_id
				AND m.id_obat = b.item_id
				AND b.receiving_id=receivings.receiving_id and left(receivings.receiving_time,10)='$tgl'");
		}

		function get_data_keu_tind_bln($bln){
			return $this->db->query("SELECT DATE_FORMAT(LEFT(receivings.receiving_time,10),'%d %M %Y') AS hari, count(receivings_items.description) AS jum_kunj, LEFT(receivings.receiving_time,10) as tgl, SUM(receivings_items.item_cost_price) as total 
										FROM receivings_items, receivings
										WHERE receivings_items.receiving_id=receivings.receiving_id and LEFT(receivings.receiving_time,7)='$bln'
										GROUP BY hari");
		}

		function get_data_keu_tind_thn($thn){
			return $this->db->query("SELECT MONTHNAME(LEFT(receivings.receiving_time,10)) AS bulan, count(receivings_items.description) AS jum_kunj, LEFT(receivings.receiving_time,10) as tgl, SUM(receivings_items.item_cost_price) as total 
FROM receivings_items, receivings
WHERE receivings_items.receiving_id=receivings.receiving_id and LEFT(receivings.receiving_time,4)='$thn'
GROUP BY bulan");
		}
/////////////////////////////////////////////////
		function row_table_pertgl($tgl){
			return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				GROUP BY item_obat");
		}

		function get_data_pembelian($param1, $param2){
			return $this->db->query("SELECT p.`id_po`, h.`no_po`, h.`sumber_dana`, h.`tgl_po`, s.`company_name`, d.`no_faktur`, d.`jatuh_tempo`, p.`description`, p.`qty_beli`, p.`satuank`, 
					p.`harga_po`, d.`diskon`, (p.`harga_po` * p.`qty_beli`) AS total_obat, d.`materai`, d.`ppn`, p.diskon_item
					FROM po p
					INNER JOIN header_po h ON p.`id_po` = h.`id_po`
					INNER JOIN `do` d ON d.`id_po` = p.`id_po`
					INNER JOIN suppliers s ON s.`person_id` = h.`supplier_id`
					WHERE p.`qty_beli` != '' AND LEFT(h.`tgl_po` , 10) >= '".$param1."' AND LEFT(h.`tgl_po`, 10) <= '".$param2."' 
					ORDER BY h.no_po ASC");
		}

		function get_nama_gudang($id_gudang){
			if($id_gudang != ""){
				$query = $this->db->query("SELECT * FROM master_gudang WHERE id_gudang = ".$id_gudang);
			}else{
				$query = $this->db->query("SELECT * FROM master_gudang WHERE id_gudang = 1");
			}
            return $query;
        }

    function get_data_distribusi_obat($param1, $param2, $filter){

		if($filter != 0){
				$gudang = " AND a.`gd_asal` = ".$filter;
		}else{
                $gudang = "";
		}

        return $this->db->query("SELECT d.`id_obat`, o.`nm_obat`, d.`satuank`, o.`hargajual`, SUM(d.`qty_acc`) AS qty, SUM(d.`qty_acc`) * o.`hargajual` AS subtotal, a.gd_asal
                FROM distribusi d
                INNER JOIN master_obat o ON o.`id_obat` = d.`id_obat`
                INNER JOIN amprah a ON a.`id_amprah` = d.`id_amprah`
                WHERE d.`qty_acc` != 0
                AND LEFT(a.tgl_amprah, 10) >= '".$param1."' AND LEFT(a.tgl_amprah, 10) <= '".$param2."' 
                GROUP BY d.`id_obat`
                ORDER BY d.`id_obat` ASC");
    }
		
	// function row_table_pertgl_bycarabayar($tgl, $cara_bayar){
	// 	return $this->db->query("SELECT Count(*)
	// 		FROM resep_pasien
	// 		WHERE  left(tgl_kunjungan,10)  = '$tgl'
	// 		AND cara_bayar='$cara_bayar'
	// 		GROUP BY item_obat");
	// }

	// function row_table_perbln($bln){
	// 	return $this->db->query("SELECT Count(*)
	// 		FROM resep_pasien
	// 		WHERE  left(tgl_kunjungan,7)  = '$bln'
	// 		GROUP BY item_obat");
	// }

	// function row_table_perbln_bycarabayar($bln, $cara_bayar){
	// 	return $this->db->query("SELECT Count(*)
	// 		FROM resep_pasien
	// 		WHERE  left(tgl_kunjungan,7)  = '$bln'
	// 		AND cara_bayar='$cara_bayar'
	// 		GROUP BY item_obat");

    public function get_supplier()
    {
    	return $this->db->get('master_pbf');
    }

     public function get_jenis_obat()
    {
    	return $this->db->get('obat_jenis');
    }

	public function get_penerimaan_obat_by_faktur($supplier="semua",$status ="semua",  $jenis_obat ="semua",$tgl_awal=null, $tgl_akhir=null)
	{
		if ($supplier != "semua") {
			$this->db->where('supplier_id', $supplier);
		}
		// if ($jenis != "semua") {
		// 	$this->db->where('jenis_barang', $jenis);
		// }
		if ($jenis_obat != "semua") {
			$this->db->where('jenis_obat', $jenis_obat);
		}

		if ($status != "semua") {
			$this->db->where('status', $status);
		}
		return $this->db->select('count(no_faktur) as "row", tanggal_masuk, tanggal_faktur, jatuh_tempo, 
		distributor,no_do,no_faktur,produsen,nilaifaktur,nilaifakturpembulatan')
		                ->from('v_penerimaan_obat_supplier')
						->where(['tanggal_masuk >=' => $tgl_awal, 'tanggal_masuk <=' => $tgl_akhir])
						->group_by('tanggal_masuk, tanggal_faktur, jatuh_tempo, distributor,no_do,no_faktur,produsen,nilaifaktur,nilaifakturpembulatan')
						->get();
	}

	public function get_penerimaan_obat($supplier="semua",$status="semua", $jenis_obat="semua", $tgl_awal=null, $tgl_akhir=null)
	{
		if ($supplier != "semua") {
			$this->db->where('supplier_id', $supplier);
		}
		// if ($jenis != "semua") {
		// 	$this->db->where('jenis_barang', $jenis);
		// }

		if ($jenis_obat != "semua") {
			$this->db->where('jenis_obat', $jenis_obat);
		}

		if ($status != "semua") {
			$this->db->where('status', $status);
		}
		return $this->db->select('count(no_faktur) as "row", 
		no_faktur, 
		description, 
		batch_no, 
		expire_date, 
		satuanb,
		satuank, 
		faktor_satuan, qtybesar, 
		qtykecil, 
		hargabruto,discount_percent,hnappnbesar,hnappnkecil,jumlah
		
		')
		 ->from('v_penerimaan_obat_supplier')
						->where(['tanggal_masuk >=' => $tgl_awal, 'tanggal_masuk <=' => $tgl_akhir])
						->group_by('no_faktur, 
						description, 
						batch_no, 
						expire_date, 
						satuanb,
						satuank, 
						faktor_satuan, qtybesar, 
						qtykecil, 
						hargabruto,discount_percent,hnappnbesar,hnappnkecil,jumlah')
						->get();
		//return $this->db->select('*, count(no_faktur) as "row"')->from('v_penerimaan_obat_supplier')->where(['tanggal_terima >=' => $tgl_awal, 'tanggal_terima <=' => $tgl_akhir])->group_by('no_faktur')->get();
	}

		public function distribusi_by_date($date1, $date2)
		{
			return $this->db->query("SELECT `distribusi`.`id_obat`,`master_obat`.`nm_obat`,`distribusi`.`satuank`,`distribusi`.`qty_req`,`amprah`.`tgl_amprah`,`master_gudang`.`nama_gudang`,`obat_jenis`.`nm_jenis` FROM `distribusi`,master_obat,amprah,master_gudang,obat_jenis where distribusi.id_amprah = amprah.id_amprah and master_obat.id_obat = distribusi.id_obat and amprah.gd_asal = master_gudang.id_gudang and amprah.gd_dituju = obat_jenis.id_jenis and  `amprah`.`tgl_amprah` >= '".$date1."' and `amprah`.`tgl_amprah` <= '".$date2."' order by amprah.tgl_amprah");
		}

		public function get_rekap_obat_noreg($tgl_awal=null, $tgl_akhir=null)
		{
			// if ($supplier != "semua") {
			// 	$this->db->where('id_pemasok', $supplier);
			// }
			// if ($jenis != "semua") {
			// 	$this->db->where('jenis_barang', $jenis);
			// }
			// if ($jenis_obat != "semua") {
			// 	$this->db->where('id_jenis', $jenis_obat);
			// }
			return $this->db->select('count(no_register) as "row", tgl_kunjungan, no_cm, no_register, nama, kelas, idrg, bed, cara_bayar')
							->from('v_rekap_obat_pasien')
							->where(['tgl_kunjungan >=' => $tgl_awal, 'tgl_kunjungan <=' => $tgl_akhir])
							->group_by('tgl_kunjungan,no_cm,no_register,nama,kelas,idrg,bed,cara_bayar')
							->get();
		}
	
		public function get_rekap_obat($tgl_awal=null, $tgl_akhir=null)
		{
			// if ($supplier != "semua") {
			// 	$this->db->where('id_pemasok', $supplier);
			// }
			// if ($jenis != "semua") {
			// 	$this->db->where('jenis_barang', $jenis);
			// }
	
			// if ($jenis_obat != "semua") {
			// 	$this->db->where('id_jenis', $jenis_obat);
			// }
			return $this->db->select('count(no_register) as "row", no_register, nama_obat, biaya_obat, signa, qty, vtot')
							->from('v_rekap_obat_pasien')
							->where(['tgl_kunjungan >=' => $tgl_awal, 'tgl_kunjungan <=' => $tgl_akhir])
							->group_by('no_register,nama_obat,biaya_obat,signa,qty,vtot')
							->get();
			//return $this->db->select('*, count(no_faktur) as "row"')->from('v_penerimaan_obat_supplier')->where(['tanggal_terima >=' => $tgl_awal, 'tanggal_terima <=' => $tgl_akhir])->group_by('no_faktur')->get();
		}

		public function get_fast_moving_all($date1, $date2)
		{
			return $this->db->query("SELECT nm_obat,id_obat,(SELECT COUNT(item_obat) as jml_obat FROM resep_pasien
			WHERE '[$date1,$date2]'::daterange @> tgl_kunjungan and CAST(resep_pasien.item_obat as int) = master_obat.id_obat 
			 ) as jml_obat FROM master_obat where id_obat >= 7000  order by jml_obat desc");
		}

		public function get_fast_moving_search($date1, $date2)
		{
			return $this->db->query("SELECT nm_obat,COUNT(item_obat) as jml_obat FROM resep_pasien
			join master_obat on id_obat = CAST(resep_pasien.item_obat as int)
			WHERE '[$date1,$date2]'::daterange @> tgl_kunjungan
			 GROUP BY nm_obat
			 HAVING COUNT(item_obat) >= 12");
		}

		public function get_medium_moving_search($date1, $date2)
		{
			return $this->db->query("SELECT nm_obat,COUNT(item_obat) as jml_obat FROM resep_pasien
			join master_obat on id_obat = CAST(resep_pasien.item_obat as int)
			WHERE '[$date1,$date2]'::daterange @> tgl_kunjungan
			 GROUP BY nm_obat
			 HAVING COUNT(item_obat) <= 11 and COUNT(item_obat) >= 4");
		}

		public function get_slow_moving_search($date1, $date2)
		{
			return $this->db->query("SELECT nm_obat,COUNT(item_obat) as jml_obat FROM resep_pasien
			join master_obat on id_obat = CAST(resep_pasien.item_obat as int)
			WHERE '[$date1,$date2]'::daterange @> tgl_kunjungan
			 GROUP BY nm_obat
			 HAVING COUNT(item_obat) <= 3 and COUNT(item_obat) >= 1");
		}

		public function get_dead_search($date1, $date2)
		{
			return $this->db->query("SELECT id_obat,nm_obat FROM master_obat where id_obat >= 6000 and (SELECT COUNT(item_obat) as jml_obat FROM resep_pasien
			WHERE '[$date1,$date2]'::daterange @> tgl_kunjungan and CAST(resep_pasien.item_obat as int) = master_obat.id_obat
			) = 0;");
		}

		public function get_obat()
		{
			return $this->db->query("SELECT * from master_obat where id_obat >= 6000 and deleted = 0");
		}

		public function get_data_tgl_stock($id)
		{
			return $this->db->query('select distinct a.item_id,b.tgl_po,b.id_po,
			(select tgl_faktur from "do" where a.no_faktur = "do".no_faktur) from po a inner 
			join header_po b on a.id_po = b.id_po where cast(a.item_id as int) = '.$id.' order by tgl_po desc limit 1');
		}

		public function get_data_rata_stock($id,$date,$date2)
		{
			return $this->db->query("SELECT AVG(qty) FROM resep_pasien 
			WHERE '[$date,$date2]'::daterange @> tgl_kunjungan and item_obat = '$id'");
		}

		public function get_hitung_stock($avg,$date,$date2)
		{
			return $this->db->query("SELECT ROUND((ROUND( CAST(DATE_PART('day', '$date'::date-'$date2'::timestamp )/30 
			as numeric),2) * $avg)  * 2) 
			as minstock;");
		}

		public function get_waktu_tunggu($date,$date2)
		{
			return $this->db->query("SELECT ROUND( CAST(DATE_PART('day', '$date'::date-'$date2'::timestamp )/30 
			as numeric),2) as tunggu" );
		}

		public function get_nm_obat($id)
		{
			return $this->db->query("select nm_obat from master_obat where id_obat = $id" );
		}

		public function get_min_max($id)
		{
			return $this->db->query("select * from history_min_max_stock where id_obat = $id ");
		}

		function update_min_stock($id,$data){
			$this->db->where('id_obat', $id);
			return $this->db->update('history_min_max_stock', $data);
			
		}

		function insert_min_stock($data)
		{
			return $this->db->insert('history_min_max_stock',$data);
		}

		public function get_min_max_all()
		{
			return $this->db->query("SELECT * from history_min_max_stock");
		}

		public function get_rekap_obat_laporan($date1,$date2,$kode)
		{
			if($kode == '' || $kode == 'semua'){
				return $this->db->query("SELECT a.*,b.diterima_barang,(select pbf from master_pbf where 
				b.supplier_id = master_pbf.id) from receivings_items a 
				left join receivings b on a.receiving_id = b.receiving_id 
				where '[$date1,$date2]'::daterange @> cast(b.diterima_barang as date)");
			}else{
				return $this->db->query("SELECT a.*,b.diterima_barang,c.subkelompok,(select pbf from master_pbf where 
				b.supplier_id = master_pbf.id) from receivings_items a 
				left join receivings b on a.receiving_id = b.receiving_id 
				left join master_obat c on a.item_id = c.id_obat
				where '[$date1,$date2]'::daterange @> cast(b.diterima_barang as date) and c.subkelompok = '$kode'");
			}
			
		}

		public function get_gudang_mutasi()
    {
    	return $this->db->get('master_gudang');
    }

	public function get_lap_mutasi_by_gudang($bulan_old,$date1,$date2,$gd,$kel)
		{
			if($gd == 'semua' && $kel == 'semua'){

				return $this->db->query("SELECT
				( SELECT satuan FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS satuan_kecil,
				( SELECT hargabeli FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS hargabeli,
				( SELECT nm_obat FROM master_obat WHERE id_obat = A.id_obat ) AS nm_obat,
				( SELECT kelompok FROM master_obat WHERE id_obat = A.id_obat ) AS kel_obat,
				( SELECT subkelompok FROM master_obat WHERE id_obat = A.id_obat ) AS subkel_obat,
				( SELECT expire_date FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS expire_date,
				A.batch_no,
				(SELECT bentuk_sediaan from master_subkelompok_obat h where h.kode = e.subkelompok) as subkel,
				SUM (
					(
					SELECT
						hi_old.stok_akhir 
					FROM
						history_obat hi_old 
					WHERE
						hi_old.batch_no = A.batch_no 
						AND TO_CHAR( hi_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					) 
				) AS stok_awal,
				SUM (
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat','Penerimaan Obat','Hapus Pembelian') THEN
							COALESCE ( A.pembelian, 0 ) + COALESCE ( A.retur_pembelian, 0 ) ELSE 0 
						END 
						) 
					) AS masuk_gd,
					SUM (
					(
					CASE
							WHEN keterangan IN ('Adjusment_Tambah','Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) +  COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) 
					) AS masuk_mutasi,
					
					
					(
					SUM (
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat','Penerimaan Obat','Hapus Pembelian') THEN
							COALESCE ( A.pembelian, 0 ) + COALESCE ( A.retur_pembelian, 0 ) ELSE 0 
						END 
						) 
						
					)+
						SUM (
					(
					CASE
							WHEN keterangan IN ('Adjusment_Tambah','Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) +  COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) 
					)
					)as total_masuk,
					SUM (
					CASE
							
							WHEN keterangan IN ('Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) AS keluar_gd,
						
						SUM (
					CASE
							
							WHEN keterangan IN ('Transaksi Penjualan') THEN
							COALESCE ( A.penjualan, 0 )  ELSE 0 
						END 
						) AS keluar_pemakaian,
						
						(
						SUM (
					CASE
							
							WHEN keterangan IN ('Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) +
						
							SUM (
					CASE
							
							WHEN keterangan IN ('Transaksi Penjualan') THEN
							COALESCE ( A.penjualan, 0 )  ELSE 0 
						END 
						)
						)as total_keluar,
						
						
				-- sisa
						(
							SUM (
								(
								SELECT
									hi_old.stok_akhir 
								FROM
									history_obat hi_old 
								WHERE
									hi_old.batch_no = A.batch_no 
									AND TO_CHAR( hi_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
								ORDER BY
									created_date DESC 
									LIMIT 1 
								) 
								) + SUM (
								(
								CASE
										
										WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
										COALESCE ( A.pembelian, 0 ) + COALESCE ( A.adjustment, 0 ) + COALESCE ( A.retur_pembelian, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
									END 
									) 
									) - SUM (
								CASE
										
										WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
										COALESCE ( A.penjualan, 0 ) + COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
									END 
									) 
								) AS sisa 
							FROM
									history_obat A left join master_obat e on a.id_obat = e.id_obat
							WHERE
							 '[$date1,$date2]'::daterange @> cast(A.created_date as date)
							GROUP BY
							A.batch_no,e.subkelompok,
				A.id_obat
				");

			
			}else if($gd != 'semua' && $kel == 'semua'){
				return $this->db->query("SELECT
				( SELECT satuan FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS satuan_kecil,
				( SELECT hargabeli FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS hargabeli,
				( SELECT nm_obat FROM master_obat WHERE id_obat = A.id_obat ) AS nm_obat,
				( SELECT expire_date FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS expire_date,
				A.batch_no,
				(SELECT bentuk_sediaan from master_subkelompok_obat h where h.kode = e.subkelompok) as subkel,
				SUM (
					(
					SELECT
						hi_old.stok_akhir 
					FROM
						history_obat hi_old 
					WHERE
						hi_old.batch_no = A.batch_no 
						AND TO_CHAR( hi_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					) 
				) AS stok_awal,
				SUM (
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat','Penerimaan Obat','Hapus Pembelian') THEN
							COALESCE ( A.pembelian, 0 ) + COALESCE ( A.retur_pembelian, 0 ) ELSE 0 
						END 
						) 
					) AS masuk_gd,
					SUM (
					(
					CASE
							WHEN keterangan IN ('Adjusment_Tambah','Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) +  COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) 
					) AS masuk_mutasi,
					
					
					(
					SUM (
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat','Penerimaan Obat','Hapus Pembelian') THEN
							COALESCE ( A.pembelian, 0 ) + COALESCE ( A.retur_pembelian, 0 ) ELSE 0 
						END 
						) 
						
					)+
						SUM (
					(
					CASE
							WHEN keterangan IN ('Adjusment_Tambah','Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) +  COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) 
					)
					)as total_masuk,
					SUM (
					CASE
							
							WHEN keterangan IN ('Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) AS keluar_gd,
						
						SUM (
					CASE
							
							WHEN keterangan IN ('Transaksi Penjualan') THEN
							COALESCE ( A.penjualan, 0 )  ELSE 0 
						END 
						) AS keluar_pemakaian,
						
						(
						SUM (
					CASE
							
							WHEN keterangan IN ('Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) +
						
							SUM (
					CASE
							
							WHEN keterangan IN ('Transaksi Penjualan') THEN
							COALESCE ( A.penjualan, 0 )  ELSE 0 
						END 
						)
						)as total_keluar,
						
						
				-- sisa
						(
							SUM (
								(
								SELECT
									hi_old.stok_akhir 
								FROM
									history_obat hi_old 
								WHERE
									hi_old.batch_no = A.batch_no 
									AND TO_CHAR( hi_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
								ORDER BY
									created_date DESC 
									LIMIT 1 
								) 
								) + SUM (
								(
								CASE
										
										WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
										COALESCE ( A.pembelian, 0 ) + COALESCE ( A.adjustment, 0 ) + COALESCE ( A.retur_pembelian, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
									END 
									) 
									) - SUM (
								CASE
										
										WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
										COALESCE ( A.penjualan, 0 ) + COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
									END 
									) 
								) AS sisa 
							FROM
								history_obat A left join master_obat e on a.id_obat = e.id_obat
							WHERE
							 '[$date1,$date2]'::daterange @> cast(A.created_date as date)
								AND gudang1 = $gd 
							GROUP BY
							A.batch_no,e.subkelompok,
				A.id_obat
				");
			}else if($gd == 'semua' && $kel != 'semua'){
				return $this->db->query("SELECT
				( SELECT satuan FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS satuan_kecil,
				( SELECT hargabeli FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS hargabeli,
				( SELECT nm_obat FROM master_obat WHERE id_obat = A.id_obat ) AS nm_obat,
				( SELECT kelompok FROM master_obat WHERE id_obat = A.id_obat ) AS kel_obat,
				( SELECT expire_date FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS expire_date,
				(SELECT bentuk_sediaan from master_subkelompok_obat h where h.kode = e.subkelompok) as subkel,
				A.batch_no,
				E.kelompok,
				SUM (
					(
					SELECT
						hi_old.stok_akhir 
					FROM
						history_obat hi_old 
					WHERE
						hi_old.batch_no = A.batch_no 
						AND TO_CHAR( hi_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					) 
				) AS stok_awal,
				SUM (
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat','Penerimaan Obat','Hapus Pembelian') THEN
							COALESCE ( A.pembelian, 0 ) + COALESCE ( A.retur_pembelian, 0 ) ELSE 0 
						END 
						) 
					) AS masuk_gd,
					SUM (
					(
					CASE
							WHEN keterangan IN ('Adjusment_Tambah','Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) +  COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) 
					) AS masuk_mutasi,
					
					
					(
					SUM (
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat','Penerimaan Obat','Hapus Pembelian') THEN
							COALESCE ( A.pembelian, 0 ) + COALESCE ( A.retur_pembelian, 0 ) ELSE 0 
						END 
						) 
						
					)+
						SUM (
					(
					CASE
							WHEN keterangan IN ('Adjusment_Tambah','Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) +  COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) 
					)
					)as total_masuk,
					SUM (
					CASE
							
							WHEN keterangan IN ('Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) AS keluar_gd,
						
						SUM (
					CASE
							
							WHEN keterangan IN ('Transaksi Penjualan') THEN
							COALESCE ( A.penjualan, 0 )  ELSE 0 
						END 
						) AS keluar_pemakaian,
						
						(
						SUM (
					CASE
							
							WHEN keterangan IN ('Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) +
						
							SUM (
					CASE
							
							WHEN keterangan IN ('Transaksi Penjualan') THEN
							COALESCE ( A.penjualan, 0 )  ELSE 0 
						END 
						)
						)as total_keluar,
						
						
				-- sisa
						(
							SUM (
								(
								SELECT
									hi_old.stok_akhir 
								FROM
									history_obat hi_old 
								WHERE
									hi_old.batch_no = A.batch_no 
									AND TO_CHAR( hi_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
								ORDER BY
									created_date DESC 
									LIMIT 1 
								) 
								) + SUM (
								(
								CASE
										
										WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
										COALESCE ( A.pembelian, 0 ) + COALESCE ( A.adjustment, 0 ) + COALESCE ( A.retur_pembelian, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
									END 
									) 
									) - SUM (
								CASE
										
										WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
										COALESCE ( A.penjualan, 0 ) + COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
									END 
									) 
								) AS sisa 
							FROM
							history_obat A left join master_obat e on a.id_obat = e.id_obat
							WHERE
							 '[$date1,$date2]'::daterange @> cast(A.created_date as date)
							 and e.kelompok = '$kel'
							GROUP BY
							A.batch_no,e.kelompok,e.subkelompok,
				A.id_obat
				");
			}else if($gd != 'semua' && $kel != 'semua'){
				return $this->db->query("SELECT
				( SELECT satuan FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS satuan_kecil,
				( SELECT hargabeli FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS hargabeli,
				( SELECT nm_obat FROM master_obat WHERE id_obat = A.id_obat ) AS nm_obat,
				( SELECT kelompok FROM master_obat WHERE id_obat = A.id_obat ) AS kel_obat,
				( SELECT expire_date FROM gudang_inventory gi WHERE gi.batch_no = A.batch_no LIMIT 1 ) AS expire_date,
				(SELECT bentuk_sediaan from master_subkelompok_obat h where h.kode = e.subkelompok) as subkel,
				A.batch_no,
				E.kelompok,
				SUM (
					(
					SELECT
						hi_old.stok_akhir 
					FROM
						history_obat hi_old 
					WHERE
						hi_old.batch_no = A.batch_no 
						AND TO_CHAR( hi_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					) 
				) AS stok_awal,
				SUM (
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat','Penerimaan Obat','Hapus Pembelian') THEN
							COALESCE ( A.pembelian, 0 ) + COALESCE ( A.retur_pembelian, 0 ) ELSE 0 
						END 
						) 
					) AS masuk_gd,
					SUM (
					(
					CASE
							WHEN keterangan IN ('Adjusment_Tambah','Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) +  COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) 
					) AS masuk_mutasi,
					
					
					(
					SUM (
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat','Penerimaan Obat','Hapus Pembelian') THEN
							COALESCE ( A.pembelian, 0 ) + COALESCE ( A.retur_pembelian, 0 ) ELSE 0 
						END 
						) 
						
					)+
						SUM (
					(
					CASE
							WHEN keterangan IN ('Adjusment_Tambah','Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) +  COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) 
					)
					)as total_masuk,
					SUM (
					CASE
							
							WHEN keterangan IN ('Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) AS keluar_gd,
						
						SUM (
					CASE
							
							WHEN keterangan IN ('Transaksi Penjualan') THEN
							COALESCE ( A.penjualan, 0 )  ELSE 0 
						END 
						) AS keluar_pemakaian,
						
						(
						SUM (
					CASE
							
							WHEN keterangan IN ('Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
							COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
						END 
						) +
						
							SUM (
					CASE
							
							WHEN keterangan IN ('Transaksi Penjualan') THEN
							COALESCE ( A.penjualan, 0 )  ELSE 0 
						END 
						)
						)as total_keluar,
						
						
				-- sisa
						(
							SUM (
								(
								SELECT
									hi_old.stok_akhir 
								FROM
									history_obat hi_old 
								WHERE
									hi_old.batch_no = A.batch_no 
									AND TO_CHAR( hi_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
								ORDER BY
									created_date DESC 
									LIMIT 1 
								) 
								) + SUM (
								(
								CASE
										
										WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
										COALESCE ( A.pembelian, 0 ) + COALESCE ( A.adjustment, 0 ) + COALESCE ( A.retur_pembelian, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
									END 
									) 
									) - SUM (
								CASE
										
										WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
										COALESCE ( A.penjualan, 0 ) + COALESCE ( A.adjustment, 0 ) + COALESCE ( A.distribusi, 0 ) + COALESCE ( A.produksi, 0 ) + COALESCE ( A.distribusi, 0 ) ELSE 0 
									END 
									) 
								) AS sisa 
							FROM
							history_obat A left join master_obat e on a.id_obat = e.id_obat
							WHERE
							 '[$date1,$date2]'::daterange @> cast(A.created_date as date)
							 and e.kelompok = '$kel' and gudang1 = $gd
							GROUP BY
							A.batch_no,e.kelompok,e.subkelompok,
				A.id_obat
				");
			}	
		}


		public function get_lap_mutasi_by_gudang_all($bulan_old,$date1,$date2,$kel){
			if($kel =='semua'){
				return $this->db->query("SELECT
				batch_no,
				( SELECT nm_obat FROM master_obat WHERE master_obat.id_obat = history_obat.id_obat ) AS nm_obat,
				( SELECT expire_date FROM gudang_inventory WHERE history_obat.batch_no = gudang_inventory.batch_no LIMIT 1 ) AS expire_date,
				( SELECT hargabeli FROM gudang_inventory WHERE history_obat.batch_no = gudang_inventory.batch_no LIMIT 1 ) AS hargabeli,
				( SELECT satuan FROM gudang_inventory WHERE history_obat.batch_no = gudang_inventory.batch_no LIMIT 1 ) AS satuan,
				(SELECT bentuk_sediaan from master_subkelompok_obat h where h.kode = e.subkelompok) as subkel,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 1 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_farm,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 4 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_neuro,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 8 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_B,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 5 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_C,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 2 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_rj,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 7 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_pro,
				(
					COALESCE (
						(
						SELECT
							stok_akhir 
						FROM
							history_obat ho_old 
						WHERE
							TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
							AND ho_old.id_obat = history_obat.id_obat 
							AND ho_old.batch_no = history_obat.batch_no 
							AND gudang1 = 1 
						ORDER BY
							created_date DESC 
							LIMIT 1 
						),
						0 
						) + COALESCE (
						(
						SELECT
							stok_akhir 
						FROM
							history_obat ho_old 
						WHERE
							TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
							AND ho_old.id_obat = history_obat.id_obat 
							AND ho_old.batch_no = history_obat.batch_no 
							AND gudang1 = 4 
						ORDER BY
							created_date DESC 
							LIMIT 1 
						),
						0 
						) + COALESCE (
						(
						SELECT
							stok_akhir 
						FROM
							history_obat ho_old 
						WHERE
							TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
							AND ho_old.id_obat = history_obat.id_obat 
							AND ho_old.batch_no = history_obat.batch_no 
							AND gudang1 = 8 
						ORDER BY
							created_date DESC 
							LIMIT 1 
						),
						0 
						) + COALESCE (
						(
						SELECT
							stok_akhir 
						FROM
							history_obat ho_old 
						WHERE
							TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
							AND ho_old.id_obat = history_obat.id_obat 
							AND ho_old.batch_no = history_obat.batch_no 
							AND gudang1 = 5 
						ORDER BY
							created_date DESC 
							LIMIT 1 
						),
						0 
						) + COALESCE (
						(
						SELECT
							stok_akhir 
						FROM
							history_obat ho_old 
						WHERE
							TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
							AND ho_old.id_obat = history_obat.id_obat 
							AND ho_old.batch_no = history_obat.batch_no 
							AND gudang1 = 2 
						ORDER BY
							created_date DESC 
							LIMIT 1 
						),
						0 
						) + COALESCE (
						(
						SELECT
							stok_akhir 
						FROM
							history_obat ho_old 
						WHERE
							TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
							AND ho_old.id_obat = history_obat.id_obat 
							AND ho_old.batch_no = history_obat.batch_no 
							AND gudang1 = 7 
						ORDER BY
							created_date DESC 
							LIMIT 1 
						),
						0 
					) 
				) AS sa_tot,
				(
				SELECT SUM
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
						END 
						) 
					FROM
						history_obat ho 
					WHERE
						'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
						AND ho.id_obat = history_obat.id_obat 
						AND ho.batch_no = history_obat.batch_no 
						AND gudang1 = 1 
					) AS mafarm,
					(
					SELECT COALESCE
						(
							SUM (
							CASE
									
									WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
									COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
								END 
								),
								0 
							) 
						FROM
							history_obat ho 
						WHERE
							'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
							AND ho.id_obat = history_obat.id_obat 
							AND ho.batch_no = history_obat.batch_no 
							AND gudang1 = 4 
						) AS maneuro,
						(
						SELECT COALESCE
							(
								SUM (
								CASE
										
										WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
										COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
									END 
									),
									0 
								) 
							FROM
								history_obat ho 
							WHERE
								'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
								AND ho.id_obat = history_obat.id_obat 
								AND ho.batch_no = history_obat.batch_no 
								AND gudang1 = 8 
							) AS ma_b,
							(
							SELECT COALESCE
								(
									SUM (
									CASE
											
											WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
											COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
										END 
										),
										0 
									) 
								FROM
									history_obat ho 
								WHERE
									'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
									AND ho.id_obat = history_obat.id_obat 
									AND ho.batch_no = history_obat.batch_no 
									AND gudang1 = 5 
								) AS ma_c,
								(
								SELECT COALESCE
									(
										SUM (
										CASE
												
												WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
												COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
											END 
											),
											0 
										) 
									FROM
										history_obat ho 
									WHERE
										'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
										AND ho.id_obat = history_obat.id_obat 
										AND ho.batch_no = history_obat.batch_no 
										AND gudang1 = 2 
									) AS ma_rj,
									(
									SELECT COALESCE
										(
											SUM (
											CASE
													
													WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
													COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
												END 
												),
												0 
											) 
										FROM
											history_obat ho 
										WHERE
											'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
											AND ho.id_obat = history_obat.id_obat 
											AND ho.batch_no = history_obat.batch_no 
											AND gudang1 = 7 
										) AS ma_pro,
										(
										SELECT COALESCE
											(
												SUM (
												CASE
														
														WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
														COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
													END 
													),
													0 
												) 
											FROM
												history_obat ho 
											WHERE
												'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
												AND ho.id_obat = history_obat.id_obat 
												AND ho.batch_no = history_obat.batch_no 
												AND gudang1 = 1 
											) AS ke_farm,
											(
											SELECT COALESCE
												(
													SUM (
													CASE
															
															WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
															COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
														END 
														),
														0 
													) 
												FROM
													history_obat ho 
												WHERE
													'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
													AND ho.id_obat = history_obat.id_obat 
													AND ho.batch_no = history_obat.batch_no 
													AND gudang1 = 4 
												) AS ke_neuro,
												(
												SELECT COALESCE
													(
														SUM (
														CASE
																
																WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
															END 
															),
															0 
														) 
													FROM
														history_obat ho 
													WHERE
														'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
														AND ho.id_obat = history_obat.id_obat 
														AND ho.batch_no = history_obat.batch_no 
														AND gudang1 = 8 
													) AS ke_b,
													(
													SELECT COALESCE
														(
															SUM (
															CASE
																	
																	WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																	COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																END 
																),
																0 
															) 
														FROM
															history_obat ho 
														WHERE
															'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
															AND ho.id_obat = history_obat.id_obat 
															AND ho.batch_no = history_obat.batch_no 
															AND gudang1 = 5 
														) AS ke_c,
														(
														SELECT COALESCE
															(
																SUM (
																CASE
																		
																		WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																		COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																	END 
																	),
																	0 
																) 
															FROM
																history_obat ho 
															WHERE
																'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																AND ho.id_obat = history_obat.id_obat 
																AND ho.batch_no = history_obat.batch_no 
																AND gudang1 = 2 
															) AS ke_rj,
															(
															SELECT COALESCE
																(
																	SUM (
																	CASE
																			
																			WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																			COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																		END 
																		),
																		0 
																	) 
																FROM
																	history_obat ho 
																WHERE
																	'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																	AND ho.id_obat = history_obat.id_obat 
																	AND ho.batch_no = history_obat.batch_no 
																	AND gudang1 = 7 
																) AS ke_pro,
																COALESCE (
																	(
																		(
																		SELECT
																			stok_akhir 
																		FROM
																			history_obat ho_old 
																		WHERE
																			TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																			AND ho_old.id_obat = history_obat.id_obat 
																			AND ho_old.batch_no = history_obat.batch_no 
																			AND gudang1 = 1 
																		ORDER BY
																			created_date DESC 
																			LIMIT 1 
																			) + (
																		SELECT SUM
																			(
																			CASE
																					
																					WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																					COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																				END 
																				) 
																			FROM
																				history_obat ho 
																			WHERE
																				'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																				AND ho.id_obat = history_obat.id_obat 
																				AND ho.batch_no = history_obat.batch_no 
																				AND gudang1 = 1 
																				) - (
																			SELECT COALESCE
																				(
																					SUM (
																					CASE
																							
																							WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																							COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																						END 
																						),
																						0 
																					) 
																				FROM
																					history_obat ho 
																				WHERE
																					'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																					AND ho.id_obat = history_obat.id_obat 
																					AND ho.batch_no = history_obat.batch_no 
																					AND gudang1 = 1 
																				) 
																			),
																			0 
																		) AS sifarm,
																		COALESCE (
																			(
																				(
																				SELECT
																					stok_akhir 
																				FROM
																					history_obat ho_old 
																				WHERE
																					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																					AND ho_old.id_obat = history_obat.id_obat 
																					AND ho_old.batch_no = history_obat.batch_no 
																					AND gudang1 = 4 
																				ORDER BY
																					created_date DESC 
																					LIMIT 1 
																					) + (
																				SELECT SUM
																					(
																					CASE
																							
																							WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																							COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																						END 
																						) 
																					FROM
																						history_obat ho 
																					WHERE
																						'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																						AND ho.id_obat = history_obat.id_obat 
																						AND ho.batch_no = history_obat.batch_no 
																						AND gudang1 = 4 
																						) - (
																					SELECT COALESCE
																						(
																							SUM (
																							CASE
																									
																									WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																									COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																								END 
																								),
																								0 
																							) 
																						FROM
																							history_obat ho 
																						WHERE
																							'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																							AND ho.id_obat = history_obat.id_obat 
																							AND ho.batch_no = history_obat.batch_no 
																							AND gudang1 = 4 
																						) 
																					),
																					0 
																				) AS si_neuro,
																				COALESCE (
																					(
																						(
																						SELECT
																							stok_akhir 
																						FROM
																							history_obat ho_old 
																						WHERE
																							TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																							AND ho_old.id_obat = history_obat.id_obat 
																							AND ho_old.batch_no = history_obat.batch_no 
																							AND gudang1 = 8 
																						ORDER BY
																							created_date DESC 
																							LIMIT 1 
																							) + (
																						SELECT SUM
																							(
																							CASE
																									
																									WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																									COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																								END 
																								) 
																							FROM
																								history_obat ho 
																							WHERE
																								'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																								AND ho.id_obat = history_obat.id_obat 
																								AND ho.batch_no = history_obat.batch_no 
																								AND gudang1 = 8 
																								) - (
																							SELECT COALESCE
																								(
																									SUM (
																									CASE
																											
																											WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																											COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																										END 
																										),
																										0 
																									) 
																								FROM
																									history_obat ho 
																								WHERE
																									'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																									AND ho.id_obat = history_obat.id_obat 
																									AND ho.batch_no = history_obat.batch_no 
																									AND gudang1 = 8 
																								) 
																							),
																							0 
																						) AS si_b,
																						COALESCE (
																							(
																								(
																								SELECT
																									stok_akhir 
																								FROM
																									history_obat ho_old 
																								WHERE
																									TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																									AND ho_old.id_obat = history_obat.id_obat 
																									AND ho_old.batch_no = history_obat.batch_no 
																									AND gudang1 = 5 
																								ORDER BY
																									created_date DESC 
																									LIMIT 1 
																									) + (
																								SELECT SUM
																									(
																									CASE
																											
																											WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																											COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																										END 
																										) 
																									FROM
																										history_obat ho 
																									WHERE
																										'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																										AND ho.id_obat = history_obat.id_obat 
																										AND ho.batch_no = history_obat.batch_no 
																										AND gudang1 = 5 
																										) - (
																									SELECT COALESCE
																										(
																											SUM (
																											CASE
																													
																													WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																													COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																												END 
																												),
																												0 
																											) 
																										FROM
																											history_obat ho 
																										WHERE
																											'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																											AND ho.id_obat = history_obat.id_obat 
																											AND ho.batch_no = history_obat.batch_no 
																											AND gudang1 = 5 
																										) 
																									),
																									0 
																								) AS si_c,
																								COALESCE (
																									(
																										(
																										SELECT
																											stok_akhir 
																										FROM
																											history_obat ho_old 
																										WHERE
																											TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																											AND ho_old.id_obat = history_obat.id_obat 
																											AND ho_old.batch_no = history_obat.batch_no 
																											AND gudang1 = 2 
																										ORDER BY
																											created_date DESC 
																											LIMIT 1 
																											) + (
																										SELECT SUM
																											(
																											CASE
																													
																													WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																													COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																												END 
																												) 
																											FROM
																												history_obat ho 
																											WHERE
																												'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																												AND ho.id_obat = history_obat.id_obat 
																												AND ho.batch_no = history_obat.batch_no 
																												AND gudang1 = 2 
																												) - (
																											SELECT COALESCE
																												(
																													SUM (
																													CASE
																															
																															WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																															COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																														END 
																														),
																														0 
																													) 
																												FROM
																													history_obat ho 
																												WHERE
																													'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																													AND ho.id_obat = history_obat.id_obat 
																													AND ho.batch_no = history_obat.batch_no 
																													AND gudang1 = 2 
																												) 
																											),
																											0 
																										) AS si_rj,
																										COALESCE (
																											(
																												(
																												SELECT
																													stok_akhir 
																												FROM
																													history_obat ho_old 
																												WHERE
																													TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																													AND ho_old.id_obat = history_obat.id_obat 
																													AND ho_old.batch_no = history_obat.batch_no 
																													AND gudang1 = 7 
																												ORDER BY
																													created_date DESC 
																													LIMIT 1 
																													) + (
																												SELECT SUM
																													(
																													CASE
																															
																															WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																															COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																														END 
																														) 
																													FROM
																														history_obat ho 
																													WHERE
																														'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																														AND ho.id_obat = history_obat.id_obat 
																														AND ho.batch_no = history_obat.batch_no 
																														AND gudang1 = 7 
																														) - (
																													SELECT COALESCE
																														(
																															SUM (
																															CASE
																																	
																																	WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																																	COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																																END 
																																),
																																0 
																															) 
																														FROM
																															history_obat ho 
																														WHERE
																															'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																															AND ho.id_obat = history_obat.id_obat 
																															AND ho.batch_no = history_obat.batch_no 
																															AND gudang1 = 7 
																														) 
																													),
																													0 
																												) AS si_pro 
																											FROM
																											history_obat left join master_obat e on history_obat.id_obat = e.id_obat
			
																											WHERE
																											'[$date1,$date2]'::daterange @> cast(history_obat.created_date as date)
																											GROUP BY
																											batch_no,e.subkelompok,
				history_obat.id_obat");
			}else{
				return $this->db->query("SELECT
				batch_no,
				( SELECT nm_obat FROM master_obat WHERE master_obat.id_obat = history_obat.id_obat ) AS nm_obat,
				( SELECT expire_date FROM gudang_inventory WHERE history_obat.batch_no = gudang_inventory.batch_no LIMIT 1 ) AS expire_date,
				( SELECT hargabeli FROM gudang_inventory WHERE history_obat.batch_no = gudang_inventory.batch_no LIMIT 1 ) AS hargabeli,
				( SELECT satuan FROM gudang_inventory WHERE history_obat.batch_no = gudang_inventory.batch_no LIMIT 1 ) AS satuan,
				(SELECT bentuk_sediaan from master_subkelompok_obat h where h.kode = master_obat.subkelompok) as subkel,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 1 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_farm,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 4 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_neuro,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 8 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_B,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 5 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_C,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 2 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_rj,
				(
				SELECT
					stok_akhir 
				FROM
					history_obat ho_old 
				WHERE
					TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
					AND ho_old.id_obat = history_obat.id_obat 
					AND ho_old.batch_no = history_obat.batch_no 
					AND gudang1 = 7 
				ORDER BY
					created_date DESC 
					LIMIT 1 
				) AS sa_pro,
				(
				COALESCE (
					(
					SELECT
						stok_akhir 
					FROM
						history_obat ho_old 
					WHERE
						TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
						AND ho_old.id_obat = history_obat.id_obat 
						AND ho_old.batch_no = history_obat.batch_no 
						AND gudang1 = 1 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					),
					0 
					) + COALESCE (
					(
					SELECT
						stok_akhir 
					FROM
						history_obat ho_old 
					WHERE
						TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
						AND ho_old.id_obat = history_obat.id_obat 
						AND ho_old.batch_no = history_obat.batch_no 
						AND gudang1 = 4 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					),
					0 
					) + COALESCE (
					(
					SELECT
						stok_akhir 
					FROM
						history_obat ho_old 
					WHERE
						TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
						AND ho_old.id_obat = history_obat.id_obat 
						AND ho_old.batch_no = history_obat.batch_no 
						AND gudang1 = 8 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					),
					0 
					) + COALESCE (
					(
					SELECT
						stok_akhir 
					FROM
						history_obat ho_old 
					WHERE
						TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
						AND ho_old.id_obat = history_obat.id_obat 
						AND ho_old.batch_no = history_obat.batch_no 
						AND gudang1 = 5 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					),
					0 
					) + COALESCE (
					(
					SELECT
						stok_akhir 
					FROM
						history_obat ho_old 
					WHERE
						TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
						AND ho_old.id_obat = history_obat.id_obat 
						AND ho_old.batch_no = history_obat.batch_no 
						AND gudang1 = 2 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					),
					0 
					) + COALESCE (
					(
					SELECT
						stok_akhir 
					FROM
						history_obat ho_old 
					WHERE
						TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
						AND ho_old.id_obat = history_obat.id_obat 
						AND ho_old.batch_no = history_obat.batch_no 
						AND gudang1 = 7 
					ORDER BY
						created_date DESC 
						LIMIT 1 
					),
					0 
				) 
				) AS sa_tot,
				(
				SELECT SUM
					(
					CASE
							
							WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
							COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
						END 
						) 
				FROM
					history_obat ho 
				WHERE
					'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
					AND ho.id_obat = history_obat.id_obat 
					AND ho.batch_no = history_obat.batch_no 
					AND gudang1 = 1 
				) AS mafarm,
				(
				SELECT COALESCE
					(
						SUM (
						CASE
								
								WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
								COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
							END 
							),
							0 
						) 
					FROM
						history_obat ho 
					WHERE
						'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
						AND ho.id_obat = history_obat.id_obat 
						AND ho.batch_no = history_obat.batch_no 
						AND gudang1 = 4 
					) AS maneuro,
					(
					SELECT COALESCE
						(
							SUM (
							CASE
									
									WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
									COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
								END 
								),
								0 
							) 
						FROM
							history_obat ho 
						WHERE
							'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
							AND ho.id_obat = history_obat.id_obat 
							AND ho.batch_no = history_obat.batch_no 
							AND gudang1 = 8 
						) AS ma_b,
						(
						SELECT COALESCE
							(
								SUM (
								CASE
										
										WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
										COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
									END 
									),
									0 
								) 
							FROM
								history_obat ho 
							WHERE
								'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
								AND ho.id_obat = history_obat.id_obat 
								AND ho.batch_no = history_obat.batch_no 
								AND gudang1 = 5 
							) AS ma_c,
							(
							SELECT COALESCE
								(
									SUM (
									CASE
											
											WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
											COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
										END 
										),
										0 
									) 
								FROM
									history_obat ho 
								WHERE
									'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
									AND ho.id_obat = history_obat.id_obat 
									AND ho.batch_no = history_obat.batch_no 
									AND gudang1 = 2 
								) AS ma_rj,
								(
								SELECT COALESCE
									(
										SUM (
										CASE
												
												WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
												COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
											END 
											),
											0 
										) 
									FROM
										history_obat ho 
									WHERE
										'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
										AND ho.id_obat = history_obat.id_obat 
										AND ho.batch_no = history_obat.batch_no 
										AND gudang1 = 7 
									) AS ma_pro,
									(
									SELECT COALESCE
										(
											SUM (
											CASE
													
													WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
													COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
												END 
												),
												0 
											) 
										FROM
											history_obat ho 
										WHERE
											'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
											AND ho.id_obat = history_obat.id_obat 
											AND ho.batch_no = history_obat.batch_no 
											AND gudang1 = 1 
										) AS ke_farm,
										(
										SELECT COALESCE
											(
												SUM (
												CASE
														
														WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
														COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
													END 
													),
													0 
												) 
											FROM
												history_obat ho 
											WHERE
												'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
												AND ho.id_obat = history_obat.id_obat 
												AND ho.batch_no = history_obat.batch_no 
												AND gudang1 = 4 
											) AS ke_neuro,
											(
											SELECT COALESCE
												(
													SUM (
													CASE
															
															WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
															COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
														END 
														),
														0 
													) 
												FROM
													history_obat ho 
												WHERE
													'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
													AND ho.id_obat = history_obat.id_obat 
													AND ho.batch_no = history_obat.batch_no 
													AND gudang1 = 8 
												) AS ke_b,
												(
												SELECT COALESCE
													(
														SUM (
														CASE
																
																WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
															END 
															),
															0 
														) 
													FROM
														history_obat ho 
													WHERE
														'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
														AND ho.id_obat = history_obat.id_obat 
														AND ho.batch_no = history_obat.batch_no 
														AND gudang1 = 5 
													) AS ke_c,
													(
													SELECT COALESCE
														(
															SUM (
															CASE
																	
																	WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																	COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																END 
																),
																0 
															) 
														FROM
															history_obat ho 
														WHERE
															'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
															AND ho.id_obat = history_obat.id_obat 
															AND ho.batch_no = history_obat.batch_no 
															AND gudang1 = 2 
														) AS ke_rj,
														(
														SELECT COALESCE
															(
																SUM (
																CASE
																		
																		WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																		COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																	END 
																	),
																	0 
																) 
															FROM
																history_obat ho 
															WHERE
																'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																AND ho.id_obat = history_obat.id_obat 
																AND ho.batch_no = history_obat.batch_no 
																AND gudang1 = 7 
															) AS ke_pro,
															COALESCE (
																(
																	(
																	SELECT
																		stok_akhir 
																	FROM
																		history_obat ho_old 
																	WHERE
																		TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																		AND ho_old.id_obat = history_obat.id_obat 
																		AND ho_old.batch_no = history_obat.batch_no 
																		AND gudang1 = 1 
																	ORDER BY
																		created_date DESC 
																		LIMIT 1 
																		) + (
																	SELECT SUM
																		(
																		CASE
																				
																				WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																				COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																			END 
																			) 
																		FROM
																			history_obat ho 
																		WHERE
																			'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																			AND ho.id_obat = history_obat.id_obat 
																			AND ho.batch_no = history_obat.batch_no 
																			AND gudang1 = 1 
																			) - (
																		SELECT COALESCE
																			(
																				SUM (
																				CASE
																						
																						WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																						COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																					END 
																					),
																					0 
																				) 
																			FROM
																				history_obat ho 
																			WHERE
																				'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																				AND ho.id_obat = history_obat.id_obat 
																				AND ho.batch_no = history_obat.batch_no 
																				AND gudang1 = 1 
																			) 
																		),
																		0 
																	) AS sifarm,
																	COALESCE (
																		(
																			(
																			SELECT
																				stok_akhir 
																			FROM
																				history_obat ho_old 
																			WHERE
																				TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																				AND ho_old.id_obat = history_obat.id_obat 
																				AND ho_old.batch_no = history_obat.batch_no 
																				AND gudang1 = 4 
																			ORDER BY
																				created_date DESC 
																				LIMIT 1 
																				) + (
																			SELECT SUM
																				(
																				CASE
																						
																						WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																						COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																					END 
																					) 
																				FROM
																					history_obat ho 
																				WHERE
																					'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																					AND ho.id_obat = history_obat.id_obat 
																					AND ho.batch_no = history_obat.batch_no 
																					AND gudang1 = 4 
																					) - (
																				SELECT COALESCE
																					(
																						SUM (
																						CASE
																								
																								WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																								COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																							END 
																							),
																							0 
																						) 
																					FROM
																						history_obat ho 
																					WHERE
																						'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																						AND ho.id_obat = history_obat.id_obat 
																						AND ho.batch_no = history_obat.batch_no 
																						AND gudang1 = 4 
																					) 
																				),
																				0 
																			) AS si_neuro,
																			COALESCE (
																				(
																					(
																					SELECT
																						stok_akhir 
																					FROM
																						history_obat ho_old 
																					WHERE
																						TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																						AND ho_old.id_obat = history_obat.id_obat 
																						AND ho_old.batch_no = history_obat.batch_no 
																						AND gudang1 = 8 
																					ORDER BY
																						created_date DESC 
																						LIMIT 1 
																						) + (
																					SELECT SUM
																						(
																						CASE
																								
																								WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																								COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																							END 
																							) 
																						FROM
																							history_obat ho 
																						WHERE
																							'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																							AND ho.id_obat = history_obat.id_obat 
																							AND ho.batch_no = history_obat.batch_no 
																							AND gudang1 = 8 
																							) - (
																						SELECT COALESCE
																							(
																								SUM (
																								CASE
																										
																										WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																										COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																									END 
																									),
																									0 
																								) 
																							FROM
																								history_obat ho 
																							WHERE
																								'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																								AND ho.id_obat = history_obat.id_obat 
																								AND ho.batch_no = history_obat.batch_no 
																								AND gudang1 = 8 
																							) 
																						),
																						0 
																					) AS si_b,
																					COALESCE (
																						(
																							(
																							SELECT
																								stok_akhir 
																							FROM
																								history_obat ho_old 
																							WHERE
																								TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																								AND ho_old.id_obat = history_obat.id_obat 
																								AND ho_old.batch_no = history_obat.batch_no 
																								AND gudang1 = 5 
																							ORDER BY
																								created_date DESC 
																								LIMIT 1 
																								) + (
																							SELECT SUM
																								(
																								CASE
																										
																										WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																										COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																									END 
																									) 
																								FROM
																									history_obat ho 
																								WHERE
																									'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																									AND ho.id_obat = history_obat.id_obat 
																									AND ho.batch_no = history_obat.batch_no 
																									AND gudang1 = 5 
																									) - (
																								SELECT COALESCE
																									(
																										SUM (
																										CASE
																												
																												WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																												COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																											END 
																											),
																											0 
																										) 
																									FROM
																										history_obat ho 
																									WHERE
																										'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																										AND ho.id_obat = history_obat.id_obat 
																										AND ho.batch_no = history_obat.batch_no 
																										AND gudang1 = 5 
																									) 
																								),
																								0 
																							) AS si_c,
																							COALESCE (
																								(
																									(
																									SELECT
																										stok_akhir 
																									FROM
																										history_obat ho_old 
																									WHERE
																										TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																										AND ho_old.id_obat = history_obat.id_obat 
																										AND ho_old.batch_no = history_obat.batch_no 
																										AND gudang1 = 2 
																									ORDER BY
																										created_date DESC 
																										LIMIT 1 
																										) + (
																									SELECT SUM
																										(
																										CASE
																												
																												WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																												COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																											END 
																											) 
																										FROM
																											history_obat ho 
																										WHERE
																											'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																											AND ho.id_obat = history_obat.id_obat 
																											AND ho.batch_no = history_obat.batch_no 
																											AND gudang1 = 2 
																											) - (
																										SELECT COALESCE
																											(
																												SUM (
																												CASE
																														
																														WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																														COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																													END 
																													),
																													0 
																												) 
																											FROM
																												history_obat ho 
																											WHERE
																												'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																												AND ho.id_obat = history_obat.id_obat 
																												AND ho.batch_no = history_obat.batch_no 
																												AND gudang1 = 2 
																											) 
																										),
																										0 
																									) AS si_rj,
																									COALESCE (
																										(
																											(
																											SELECT
																												stok_akhir 
																											FROM
																												history_obat ho_old 
																											WHERE
																												TO_CHAR( ho_old.created_date, 'YYYY-MM' ) = '$bulan_old' 
																												AND ho_old.id_obat = history_obat.id_obat 
																												AND ho_old.batch_no = history_obat.batch_no 
																												AND gudang1 = 7 
																											ORDER BY
																												created_date DESC 
																												LIMIT 1 
																												) + (
																											SELECT SUM
																												(
																												CASE
																														
																														WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian', 'Produksi Tambah', 'Penambahan Distribusi Langsung' ) THEN
																														COALESCE ( pembelian, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( retur_pembelian, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																													END 
																													) 
																												FROM
																													history_obat ho 
																												WHERE
																													'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																													AND ho.id_obat = history_obat.id_obat 
																													AND ho.batch_no = history_obat.batch_no 
																													AND gudang1 = 7 
																													) - (
																												SELECT COALESCE
																													(
																														SUM (
																														CASE
																																
																																WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi', 'Produksi Kurang', 'Pengurangan Distribusi Langsung' ) THEN
																																COALESCE ( penjualan, 0 ) + COALESCE ( adjustment, 0 ) + COALESCE ( distribusi, 0 ) + COALESCE ( produksi, 0 ) + COALESCE ( distribusi, 0 ) ELSE 0 
																															END 
																															),
																															0 
																														) 
																													FROM
																														history_obat ho 
																													WHERE
																														'[$date1,$date2]'::daterange @> cast(ho.created_date as date) 
																														AND ho.id_obat = history_obat.id_obat 
																														AND ho.batch_no = history_obat.batch_no 
																														AND gudang1 = 7 
																													) 
																												),
																												0 
																											) AS si_pro 
																										FROM
																										history_obat left join master_obat on master_obat.id_obat = history_obat.id_obat
																										WHERE
																										'[$date1,$date2]'::daterange @> cast(history_obat.created_date as date)
																										and master_obat.kelompok = '$kel'
																										GROUP BY
																										batch_no,master_obat.kelompok,master_obat.subkelompok,
				history_obat.id_obat");
			}
		}

		public function get_gudang()
    {
    	return $this->db->get('master_gudang');
    }

	public function master_kelompok_obat()
		{
			return $this->db->query("SELECT * from master_kelompok_obat");
		}

		public function get_lap_narkotik_psikotropik($date1,$date2,$kode)
		{

			if($kode == ''){

				return $this->db->query("SELECT
				* 
					FROM
						lap_narkotik_psikotropik A 
					WHERE
					'[$date1,$date2]'::daterange @> cast(A.tgl_amprah as date)");

			}else{
				return $this->db->query("SELECT
				*
					FROM
						lap_narkotik_psikotropik A 
					WHERE
					'[$date1,$date2]'::daterange @> cast(A.tgl_amprah as date);");

			}
			
		}

		function ambil_id_obat($nama)
		{
			return $this->db->select('id_obat')->where('nm_obat',$nama)->where('deleted','0')->get('master_obat');
		}
}
?>