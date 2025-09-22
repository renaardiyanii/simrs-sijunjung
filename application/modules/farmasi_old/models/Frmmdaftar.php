<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//daftar resep pasien
		function get_biaya_obat($id){
            return $this->db->query("SELECT  hargajual from gudang_inventory where id_inventory = $id and deleted = 0");
        }

		function get_daftar_resep_pasien($date){
			return $this->db->query("SELECT *,(SELECT no_resep FROM resep_pasien WHERE  no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep FROM permintaan_obat WHERE obat = '1' and TO_CHAR(tgl_kunjungan,'YYYY-MM-DD')='$date' order by tgl_kunjungan desc ");
		}

		function get_daftar_resep_pasien_bpjs($date){
			return $this->db->query("SELECT * FROM permintaan_obat WHERE LEFT(tgl_kunjungan,10)='$date' and cara_bayar='BPJS'");
		}

		function get_daftar_resep_pasien_rj($date){
			return $this->db->query("SELECT * FROM permintaan_obat_umum_irj WHERE LEFT(tgl_kunjungan,10)='$date'");
		}

		function get_daftar_resep_pasien_rj_bpjs($date){
			return $this->db->query("SELECT * FROM permintaan_obat_bpjs_irj WHERE LEFT(tgl_kunjungan,10)='$date'");
		}

		function get_daftar_resep_pasien_ri($date){
			return $this->db->query("SELECT * FROM permintaan_obat_umum_iri WHERE LEFT(tgl_kunjungan,10) <= '$date' and LEFT(tgl_kunjungan,10) >= '$date' - INTERVAL 4 DAY");
		}

		function get_daftar_resep_pasien_ri_bpjs($date){
			return $this->db->query("SELECT * FROM permintaan_obat_bpjs_iri WHERE LEFT(tgl_kunjungan,10) <= '$date' and LEFT(tgl_kunjungan,10) >= '$date' - INTERVAL 4 DAY");
		}

		function get_daftar_resep_koreksi($date){
			return $this->db->query("SELECT * FROM koreksi_obat WHERE LEFT(tgl_kunjungan,10)='$date' and cara_bayar <> 'BPJS' ");
		}

        function get_daftar_resep_pasien_noreg($noreg){
            return $this->db->query("SELECT * FROM permintaan_obat WHERE no_register LIKE '%$noreg%' and cara_bayar!='BPJS'");
        }

        function get_daftar_resep_pasien_noreg_bpjs($noreg){
            return $this->db->query("SELECT * FROM permintaan_obat_bpjs_irj WHERE no_register LIKE '%$noreg%' and cara_bayar!='BPJS'");
        }
        function get_daftar_resep_pasien_noreg_rj($noreg){
            return $this->db->query("SELECT * FROM permintaan_obat_umum_irj WHERE no_register LIKE '%$noreg%'");
        }
        function get_daftar_resep_pasien_noreg_rj_bpjs($noreg){
            return $this->db->query("SELECT * FROM permintaan_obat_bpjs_irj WHERE no_register LIKE '%$noreg%'");
        }
        function get_daftar_resep_pasien_noreg_ri($noreg){
            return $this->db->query("SELECT * FROM permintaan_obat_umum_iri WHERE no_register LIKE '%$noreg%'");
        }
        function get_daftar_resep_pasien_noreg_ri_bpjs($noreg){
            return $this->db->query("SELECT * FROM permintaan_obat_bpjs_iri WHERE no_register LIKE '%$noreg%'");
        }

		function get_resep_pasien($id_resep_pasien){
			return $this->db->query("SELECT * FROM resep_pasien WHERE id_resep_pasien='$id_resep_pasien'");
		}

		function get_resep_pasien_racikan($id_obat_racikan){
			return $this->db->query("SELECT * from obat_racikan a, master_obat b
			where a.item_obat = b.id_obat and id_obat_racikan='$id_obat_racikan'");
		}

		function get_all_resep_pasien($no_register,$no_medrec){
			return $this->db->query("SELECT * FROM resep_pasien WHERE no_register='$no_register' and no_medrec = '$no_medrec' ");
		}


		function get_pengambilan_resep_pasien($date){
			// return $this->db->query("SELECT no_resep, no_register, (
			// IF(LEFT(no_register,2)='PL', (SELECT nama FROM pasien_luar WHERE no_register=resep_pasien.no_register)
			// , (SELECT nama FROM data_pasien WHERE no_medrec=resep_pasien.no_medrec)) ) as nama,
			// tgl_kunjungan, kelas, (select idrg from resep_header where no_resep=resep_pasien.no_resep) as idrg,
            // (select bed from resep_header where no_resep=resep_pasien.no_resep) as bed, cetak_kwitansi, cara_bayar, (SELECT no_cm FROM data_pasien WHERE no_medrec=resep_pasien.no_medrec) as no_cm
			// FROM resep_pasien
			// WHERE ambil_resep='0' AND no_resep IS NOT NULL AND tgl_kunjungan='$date'
			// GROUP BY no_resep
			// ORDER BY no_resep");

			return $this->db->query("SELECT DISTINCT no_resep, no_register,
			CASE WHEN LEFT(no_register,2)='PL'
			THEN  (SELECT nama FROM pasien_luar WHERE no_register=resep_pasien.no_register)
			ELSE 	(SELECT nama FROM data_pasien WHERE CAST(no_medrec AS TEXT)=resep_pasien.no_medrec)
		END as nama,
					tgl_kunjungan, kelas, (select idrg from resep_header where no_resep=resep_pasien.no_resep) as idrg,
					(select bed from resep_header where no_resep=resep_pasien.no_resep) as bed, cetak_kwitansi, cara_bayar,
					(SELECT no_cm FROM data_pasien WHERE cast(no_medrec as text)=resep_pasien.no_medrec) as no_cm
					FROM resep_pasien
					WHERE ambil_resep = 0 AND no_resep IS NOT NULL AND tgl_kunjungan='".$date."'

					ORDER BY no_resep");
		}

		function get_rekap_obat($date){
            // return $this->db->query("SELECT resep_pasien.no_resep, resep_pasien.no_register, data_pasien.no_cm, (
			// 	IF(LEFT(no_register,2)='PL', (SELECT nama FROM pasien_luar WHERE no_register=resep_pasien.no_register)
			// 	, (SELECT nama FROM data_pasien WHERE no_medrec=resep_pasien.no_medrec)) ) as nama,
			// 	tgl_kunjungan, kelas, (select idrg from resep_header where no_resep=resep_pasien.no_resep) as idrg,
			// 	(select bed from resep_header where no_resep=resep_pasien.no_resep) as bed, cetak_kwitansi, cara_bayar
			// 	FROM resep_pasien
			// 	JOIN data_pasien on data_pasien.no_medrec=resep_pasien.no_medrec
			// 	WHERE cetak_kwitansi = 0 AND no_resep IS NOT NULL AND LEFT(tgl_kunjungan,10)='$date'
			// 	GROUP BY no_register
			// 	ORDER BY no_register");

			return $this->db->query("SELECT DISTINCT resep_pasien.no_resep, resep_pasien.no_register, data_pasien.no_cm, resep_pasien.no_medrec,
			CASE WHEN LEFT(no_register,2)='PL'
						THEN
						   (SELECT nama FROM pasien_luar WHERE no_register=resep_pasien.no_register)
						ELSE  (SELECT nama FROM data_pasien WHERE CAST(no_medrec AS TEXT)=resep_pasien.no_medrec)  end
						as nama,
						tgl_kunjungan, kelas, (select idrg from resep_header where no_resep=resep_pasien.no_resep) as idrg,
						(select bed from resep_header where no_resep=resep_pasien.no_resep) as bed, cetak_kwitansi, cara_bayar
						FROM resep_pasien
						JOIN data_pasien on CAST(data_pasien.no_medrec AS TEXT)=resep_pasien.no_medrec
						WHERE cetak_kwitansi is null AND no_resep IS NOT NULL AND to_char(tgl_kunjungan,'YYYY-MM-DD')='$date'

						ORDER BY no_register");
		}

        function get_rekap_obat_noreg($noreg){
            return $this->db->query("SELECT no_resep, no_register, no_medrec,
			case when substring(no_register,2)='PL' then
				(SELECT nama FROM pasien_luar WHERE no_register=resep_pasien.no_register) else
				(SELECT nama FROM data_pasien WHERE no_medrec=cast(resep_pasien.no_medrec as integer)) end
			as nama, tgl_kunjungan, kelas, (select idrg from resep_header where no_resep=resep_pasien.no_resep) as idrg, (select bed from resep_header where no_resep=resep_pasien.no_resep) as bed, cetak_kwitansi, cara_bayar
			FROM resep_pasien
			WHERE cetak_kwitansi is null
			AND no_resep IS NOT NULL
			AND no_register
			LIKE '%$noreg%'
			ORDER BY no_resep");
        }

        function get_data_rekap_detail($no_register){
           // return $this->db->query("SELECT tgl_kunjungan ,nama_obat,item_obat, biaya_obat, signa, qty, cara_bayar, vtot, xupdate FROM resep_pasien where no_register='$no_register'");
			return $this->db->query("SELECT * FROM resep_pasien where no_register='$no_register'");
        }

		function get_daftar_pasien_resep_by_date($date){
			return $this->db->query("SELECT * FROM permintaan_obat
										WHERE left(tgl_kunjungan,10)  = '$date'
										ORDER BY tgl_kunjungan DESC");
		}

		function get_daftar_pasien_resep_by_no($key){
			return $this->db->query("SELECT * FROM permintaan_obat
				WHERE  (permintaan_obat.no_register like '%$key%')
				ORDER BY tgl_kunjungan ASC");
		}

		function get_data_pasien_luar($no_register){
			return $this->db->query("SELECT * FROM permintaan_obat, pasien_luar WHERE permintaan_obat.no_register=pasien_luar.no_register AND permintaan_obat.no_register='$no_register'");
		}

		function get_data_resep(){
			return $this->db->query("SELECT * FROM master_obat");
		}

		function get_biaya($id_inventory){
			return $this->db->query("SELECT hargajual FROM master_obat as a, gudang_inventory as b WHERE a.id_obat=b.id_obat and b.id_inventory='".$id_inventory."'");
		}

		function get_biaya_markup($kodemarkup){
			return $this->db->query("SELECT markup FROM kebijakan_obat");
		}

		function get_data_pasien_resep($no_register){
			return $this->db->query("SELECT * FROM permintaan_obat, data_pasien WHERE permintaan_obat.no_medrec=data_pasien.no_medrec AND permintaan_obat.no_register='$no_register'");
		}

		// added @aldi , kebutuhan rawat inap
		function get_data_pasien_resep_ri($no_register){
			return $this->db->query("SELECT *,noregasal FROM permintaan_obat, data_pasien,pasien_iri WHERE pasien_iri.no_medrec = permintaan_obat.no_medrec AND permintaan_obat.no_medrec=data_pasien.no_medrec AND pasien_iri.noregasal='$no_register'");
		}

		function get_data_pasien_resep_koreksi($no_register){
			return $this->db->query("SELECT * FROM koreksi_obat, data_pasien WHERE koreksi_obat.no_medrec=data_pasien.no_medrec AND koreksi_obat.no_register='$no_register'");
		}

        function get_data_pasien_luar_koreksi($no_register){
			return $this->db->query("SELECT * FROM koreksi_obat, pasien_luar WHERE koreksi_obat.no_register=pasien_luar.no_register AND koreksi_obat.no_register='$no_register'");
		}

		function get_data_pasien_iri($no_register){
			return $this->db->query("SELECT * FROM permintaan_obat WHERE no_register='".$no_register."'");
		}

		function get_data_markup(){
			return $this->db->query("SELECT * FROM kebijakan_obat");
		}

		function get_harga_obat($nama_obat){
			return $this->db->query("SELECT nm_obat,hargajual,satuank FROM master_obat WHERE nm_obat like '%$nama_obat%' limit 0,10");
		}



		//function get_daftar_pasien_lab(){
		//	return $this->db->query("SELECT * FROM permintaan_obat, data_pasien WHERE permintaan_obat.no_medrec=data_pasien.no_medrec");
		//}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM permintaan_obat, data_pasien WHERE permintaan_obat.no_medrec=data_pasien.no_medrec 	and resep_pasien.no_register='".$no_register."'");

		}

		//function getjenis_tindakan($id_tindakan){
		//	return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		//}

		// function getitem_obat($id_obat){
		// 	return $this->db->query("SELECT * FROM master_obat WHERE id_obat='".$id_obat."'");
		// }

		function getitem_obat($id_inventory){
			return $this->db->query("SELECT *, (SELECT nm_obat FROM master_obat WHERE id_obat=a.id_obat limit 1) as nm_obat,
			 (SELECT satuank FROM master_obat WHERE id_obat=a.id_obat limit 1) as satuank
					FROM gudang_inventory as a WHERE id_inventory=CAST('".$id_inventory."' AS INTEGER)");
		}

		function getdata_resep_pasien($no_register){
			return $this->db->query("SELECT * FROM resep_pasien where no_register='$no_register' and no_resep is null");
		}

		function getdata_resep_pasien_soap($id){
			return $this->db->query("SELECT * FROM soap_pasien_rj where id='".$id."'");
		}

		function getdata_resep_pasien_koreksi($no_register){
			return $this->db->query("SELECT * FROM resep_pasien where no_register='".$no_register."'");
		}

		function getdata_resep_racik($no_register){
			return $this->db->query("SELECT *, (SELECT nm_obat FROM master_obat WHERE id_obat=a.item_obat limit 1) as nm_obat
				FROM obat_racikan AS a where no_register='".$no_register."' AND no_resep IS NULL");
		}

		function getdata_resep_racikan($no_register){
			// return $this->db->query("select *,(select hargajual from master_obat where obat_racikan.item_obat=master_obat.id_obat AND no_register='".$no_register."' ) from obat_racikan where no_register='".$no_register."' ");
			return $this->db->query("SELECT * FROM obat_racikan, master_obat where obat_racikan.item_obat=master_obat.id_obat AND no_register='".$no_register."' AND id_resep_pasien is null");
		}

		function racikracik($no_register){
			return $this->db->query("select *,(select hargajual from gudang_inventory where obat_racikan.id_inventory=gudang_inventory.id_inventory AND gudang_inventory.deleted= 0 AND no_register='$no_register') as hargajual from obat_racikan where no_register='$no_register' ");
			// return $this->db->query("SELECT * FROM obat_racikan where  no_register='".$no_register."' AND id_resep_pasien is null");
		}

		//function getdata_tindakan_pasien($no_register){
		//	return $this->db->query("SELECT * FROM jenis_tindakan_lab");
		//}

		function get_biaya_tindakan($id){
			return $this->db->query("SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan='".$id."'");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT * FROM data_dokter");
		}

		function getdata_cara(){
			return $this->db->query("SELECT * FROM cara_bayar WHERE cara_bayar");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."'");
		}

		function getnama_dokter_poli($no_register){
			if(substr($no_register, 0,2)=="RJ"){
				return $this->db->query("SELECT *, (SELECT nm_dokter from data_dokter where id_dokter=daftar_ulang_irj.id_dokter limit 1) as nmdokter FROM daftar_ulang_irj,data_dokter
					where daftar_ulang_irj.no_register='$no_register' AND data_dokter.id_dokter=daftar_ulang_irj.id_dokter");
			} if(substr($no_register, 0,2)=="RI"){
				return $this->db->query("SELECT *, (SELECT nm_dokter from data_dokter where id_dokter=pasien_iri.id_dokter) as nmdokter FROM pasien_iri,data_dokter
					Where pasien_iri.no_ipd='$no_register' AND data_dokter.id_dokter=pasien_iri.id_dokter");
			} if(substr($no_register, 0,2)=="RD"){
				return $this->db->query("SELECT *, (SELECT nm_dokter from data_dokter where id_dokter=irddaftar_ulang.id_dokter) as nmdokter FROM irddaftar_ulang,data_dokter
					Where irddaftar_ulang.no_register='$no_register' AND data_dokter.id_dokter=irddaftar_ulang.id_dokter");
			} else {
				return $this->db->query("SELECT 'UMUM' as nmdokter FROM pasien_luar WHERE  no_register='$no_register'");
			}
		}

		function cek_resep_obat($no_register,$id_obat){
			return $this->db->query("SELECT * FROM resep_pasien WHERE no_register='".$no_register."' and item_obat = '".$id_obat."' ");
		}

		function insert_permintaan($data){
			// var_dump($data);die();
			// if($data['no_resep'] == ''){
			// 	$data['no_resep'] = NULL;
			// }
			// var_dump($data['no_resep']);die();
			$this->db->insert('resep_pasien', $data);
			return true;
		}

		function cek_plan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_fisik WHERE no_register='".$no_register."'");
		}

		function insert_data_fisik($data,$no_resep){
			// var_dump($data);die();
			if($no_resep == ''){
				$no_resep = intval($no_resep);
			}
			// var_dump($no_resep);die();
			$this->db->insert('pemeriksaan_fisik', $data);
			return true;
		}

		function insert_data_fisik_live($data){
			$this->db->insert('pemeriksaan_fisik', $data);
			return true;
		}

		function update_data_fisik($no_register,$data,$no_resep){
			// var_dump($data);die();
			if($no_resep == ''){
				$no_resep = intval($no_resep);
			}
			// var_dump($no_resep);die();
			$this->db->where('no_register',$no_register);
			$this->db->update('pemeriksaan_fisik', $data);
			return true;
		}

		function update_data_fisik_live($no_register,$data){
			$this->db->where('no_register',$no_register);
			$this->db->update('pemeriksaan_fisik', $data);
			return true;
		}

		function insert_update_plan($no_register,$data){
			$this->db->where('no_register',$no_register);
			$this->db->update('soap_pasien_rj', $data);
			return true;
		}

		function insert_racikan($id_inventory,$item_obat,$qty,$no_register,$dosis,$satuan,$nama_obat){
			$this->db->query("INSERT INTO obat_racikan (id_inventory,item_obat,qty,no_register,dosis,satuan,nama_obat) values ('$id_inventory','$item_obat','$qty','$no_register','$dosis','$satuan','$nama_obat')");
			return true;
		}

		function insert_racikan_petugas($id_resep_pasien,$id_inventory,$item_obat,$qty,$no_register,$dosis,$satuan){
			$this->db->query("INSERT INTO obat_racikan (id_resep_pasien,id_inventory,item_obat,qty,no_register,dosis,satuan) values ('$id_resep_pasien','$id_inventory','$item_obat','$qty','$no_register','$dosis','$satuan')");
			return true;
		}

		function insert_pasien_luar($data){
			$tahun = date('Y');
			$depan = substr($tahun,2,2);
			$this->db->set('no_register',"(select 'PLF".$depan."' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_register),6) FROM pasien_luar where \"jenis_PL\" = 'FARMASI' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function selesai_pengambilan($no_resep,$xambil){
			$this->db->query("UPDATE resep_pasien SET ambil_resep=1, xambil='$xambil' WHERE no_resep='$no_resep'");
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max( RIGHT ( no_register, 6 ) ) AS counter, RIGHT(TO_CHAR( now(),'YYYY' ),2) AS year FROM pasien_luar WHERE LEFT ( no_register, 5 ) = 'PLFAR' AND substring( no_register, 6, 2 ) = ( SELECT RIGHT(TO_CHAR( now( ),'YYYY' ), 2) )");
		}
		// SELECT max( RIGHT ( no_register, 6 )  ) AS counter, mid( now(), 3, 2 ) AS year FROM pasien_luar WHERE LEFT ( no_register, 5 ) = 'PLFAR' AND mid( no_register, 6, 2 ) = ( SELECT mid( now( ), 3, 2 ) )

		function get_new_register_lab(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}

		function get_new_register_rad(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}

		function getbiaya_obat_racik($no_register){
			return $this->db->query("SELECT sum(a.qty*b.hargajual) as total FROM obat_racikan a, gudang_inventory b WHERE a.id_inventory=b.id_inventory AND a.no_register='$no_register' AND a.id_resep_pasien is null");
		}

		function getbiaya_obat_racik_petugas($no_register,$id_resep_pasien){
			return $this->db->query("SELECT sum(qty*hargajual) as total FROM obat_racikan a, master_obat b WHERE a.item_obat=b.id_obat AND a.no_register='".$no_register."' AND a.id_resep_pasien = '$id_resep_pasien' ");
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotobat,$no_resep){
			$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET obat=0, vtot_obat='$getvtotobat' WHERE no_register='$no_register'");
			return true;
		}

		function force_selesai_daftar_pemeriksaan_PL($no_register,$getvtotobat){
			$this->db->query("UPDATE resep_pasien SET cetak_faktur='1' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET obat=0, vtot_obat='$getvtotobat' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat,$no_resep, $tuslah='0', $koreksi=0, $cara_bayar=''){
		//	if ($koreksi==1) {
		//		$this->db->query('DELETE FROM resep_pasien WHERE no_register="$no_register" ');
		//	}else{
				$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
		//	}

		//	if ($cara_bayar == "BPJS") {
				$this->db->query("UPDATE daftar_ulang_irj SET vtot_obat='$getvtotobat' , obat=0, status_obat=1, tuslah='$tuslah' WHERE no_register='$no_register'");
		//	}else{
	//			$this->db->query("UPDATE daftar_ulang_irj SET vtot_obat='$getvtotobat' , obat=0, status_obat=1 tuslah='$tuslah' WHERE no_register='$no_register'");
	//		}
			return true;
		}

		function force_selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat,  $tuslah='0',$status_obat){
			//$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");

			$this->db->query("UPDATE resep_pasien SET cetak_faktur='1' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET vtot_obat='$getvtotobat' , obat=0, status_obat='$status_obat', tuslah='$tuslah' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat,$no_resep){
			$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
			//$this->db->query("UPDATE irddaftar_ulang SET vtot_obat='$getvtotobat' , status_obat=1 WHERE no_register='$no_register'");
			return true;
		}

		function force_selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat,$no_resep,$status_obat){
			$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET vtot_obat='$getvtotobat' , status_obat='$status_obat' WHERE no_register='$no_register'");
			return true;
		}


		function selesai_daftar_pemeriksaan_IRI($no_register,$getvtotobat,$no_resep, $tuslah='0', $koreksi=0){
			// if ($koreksi) {
			// 	$this->db->query('DELETE FROM resep_pasien WHERE no_register="$no_register" ');
			// }else{
				$this->db->query("UPDATE resep_pasien SET no_resep = '$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
			// }
			$this->db->query("UPDATE pasien_iri SET obat=0, status_obat=1, tuslah='$tuslah',
			vtot_obat='$getvtotobat' WHERE no_ipd='$no_register'");
			return true;
		}

		function force_selesai_daftar_pemeriksaan_IRI($no_register,$getvtotobat,$status_obat, $tuslah='0'){
			$this->db->query("UPDATE resep_pasien SET cetak_faktur='1' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_iri SET vtot_obat='$getvtotobat', obat=0, status_obat='$status_obat', tuslah='$tuslah' WHERE no_ipd='$no_register'");
			return true;
		}

		function get_vtot_obat($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_obat FROM resep_pasien WHERE no_register='".$no_register."'");
		}

		function hapus_data_obat($id_resep_pasien){
			$this->db->where('id_resep_pasien', $id_resep_pasien);
       		$this->db->delete('resep_pasien');
			return true;
		}

		function hapus_data_obat_racik($id_resep_pasien){
			$this->db->where('id_resep_pasien', $id_resep_pasien);
       		$this->db->delete('obat_racikan');
			return true;
		}

		function hapus_data_racikan($id_obat_racikan){
			$this->db->where('id_obat_racikan', $id_obat_racikan);
       		$this->db->delete('obat_racikan');
			return true;
		}

		function hapus_data_pemeriksaan($id_resep_pasien){
			$this->db->where('id_resep_pasien', $id_resep_pasien);
       		$this->db->delete('resep_pasien');
			return true;
		}

		function insert_data_header($no_register,$idrg='',$bed='',$kelas=''){
			return $this->db->query("INSERT INTO resep_header (no_resgister, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}

		function update_data_header($no_resep, $nm_dokter, $tot_tuslah){
			return $this->db->query("UPDATE resep_header SET nm_dokter='$nm_dokter', tot_tuslah='$tot_tuslah', tuslah='$tot_tuslah' WHERE no_resep='$no_resep'");
		}

		function get_data_dokter($no_resep){
			return $this->db->query("SELECT nm_dokter FROM resep_header WHERE no_resep='$no_resep'");
		}

		function get_data_header($no_resgister,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_resep FROM resep_header WHERE no_resgister='$no_resgister' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas'  ORDER BY no_resep DESC LIMIT 1");
		}

		function get_vtot_racikan($no_register){
			return $this->db->query("SELECT sum(hargajual*obat_racikan.qty) as vtot_racikan_obat FROM obat_racikan, gudang_inventory WHERE obat_racikan.id_inventory=gudang_inventory.id_inventory AND no_register='$no_register' AND id_resep_pasien is null");
		}

		function get_id_resep($no_register, $nama_obat){
			return $this->db->query("SELECT id_resep_pasien FROM resep_pasien WHERE no_register='$no_register' AND nama_obat='$nama_obat'LIMIT 1");
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_obat FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function getdata_rj($no_register){
			return $this->db->query("SELECT status_obat FROM daftar_ulang_irj WHERE no_register='".$no_register."'");
		}


		function get_no_resep($no_register){
			return $this->db->query("SELECT no_resep FROM resep_pasien WHERE  no_register='$no_register' GROUP BY no_resep");
		}

		function get_roleid($userid){
			return $this->db->query("SELECT roleid FROM dyn_role_user WHERE userid = '".$userid."'");
		}

	    function get_gudangid($userid){
	      return $this->db->query("Select nama_gudang, id_gudang from dyn_gudang_user where userid = '".$userid."'");
	    }

	    function get_data_resep_by_role($role){
	      return $this->db->query("SELECT * , (SELECT nm_obat FROM master_obat WHERE id_obat=a.id_obat) as nm_obat , (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang) as nama_gudang
	        FROM gudang_inventory as a WHERE a.id_gudang='$role' order by batch_no");
	    }


		function get_cara_bayar($no_register){
			if(substr($no_register, 0,2)=="RD"){
				return $this->db->query("SELECT cara_bayar FROM irddaftar_ulang WHERE  no_register='$no_register'");
			}if(substr($no_register, 0,2)=="RJ"){
				return $this->db->query("SELECT cara_bayar FROM daftar_ulang_irj WHERE  no_register='$no_register'");
			}if(substr($no_register, 0,2)=="RI"){
				return $this->db->query("SELECT cara_bayar FROM pasien_iri WHERE  no_register='$no_register'");
			} else {
				return $this->db->query("SELECT 'UMUM' as cara_bayar FROM pasien_luar WHERE  no_register='$no_register'");
			}
		}

		function get_kontraktor($no_register){
			if(substr($no_register, 0,2)=="RD"){
				return $this->db->query("SELECT *,(SELECT nmkontraktor from kontraktor where id_kontraktor=irddaftar_ulang.id_kontraktor) as nmkontraktor
					FROM irddaftar_ulang,data_pasien
					where irddaftar_ulang.no_medrec=data_pasien.no_medrec and irddaftar_ulang.no_register='$no_register'");
			}if(substr($no_register, 0,2)=="RJ"){
				return $this->db->query("SELECT *, (SELECT nmkontraktor from kontraktor where id_kontraktor=daftar_ulang_irj.id_kontraktor) as nmkontraktor
					FROM daftar_ulang_irj,data_pasien
					where daftar_ulang_irj.no_medrec=data_pasien.no_medrec and daftar_ulang_irj.no_register='$no_register'");
			}if(substr($no_register, 0,2)=="RI"){
				return $this->db->query("SELECT *, (SELECT nmkontraktor from kontraktor where id_kontraktor=pasien_iri.id_kontraktor) as nmkontraktor FROM pasien_iri,data_pasien
					Where pasien_iri.no_medrec=data_pasien.no_medrec and pasien_iri.no_ipd='$no_register'");
			} else {
				return $this->db->query("SELECT 'UMUM' as nmkontraktor FROM pasien_luar WHERE  no_register='$no_register'");
			}
		}

		function update_racikan($no_register,$id_resep){
			return $this->db->query("UPDATE obat_racikan SET id_resep_pasien='$id_resep' WHERE no_register='$no_register' AND id_resep_pasien is null ");
		}

		function update_racikan_selesai($no_register,$no_resep){
			return $this->db->query("UPDATE obat_racikan SET no_resep='$no_resep' WHERE no_register='$no_register' AND no_resep = '0' ");
		}

		function selesai_bayar_PL($no_register){
			return $this->db->query("UPDATE pasien_luar SET obat=0 WHERE no_register='$no_register'");
		}

		function selesai_bayar_IRJ($no_register){
			return $this->db->query("UPDATE daftar_ulang_irj SET status_obat=1 WHERE no_register='$no_register'");
		}

		function selesai_bayar_IRI($no_register, $status_obat){
			return $this->db->query("UPDATE pasien_iri SET obat='0' , status_obat='$status_obat' WHERE no_ipd='$no_register'");
		}

		function selesai_bayar_IRD($no_register){
			return $this->db->query("UPDATE irddaftar_ulang SET status_obat=1 WHERE no_register='$no_register'");
		}

		function cek_stok_obat($id_inventory, $qty){
			return $this->db->query("SELECT a.*, b.nm_obat as nama_obat FROM gudang_inventory as a LEFT JOIN master_obat as b ON a.id_obat=b.id_obat WHERE id_inventory=CAST($id_inventory AS double precision) and qty >= '$qty'");
		}

		function cek_qty_obat($no_register){
			return $this->db->query("SELECT id_inventory as id_inventory, qty as qty FROM resep_pasien WHERE no_register='$no_register' and racikan is null and cetak_faktur is null
					UNION
					SELECT id_inventory as id_inventory, qty as qty FROM obat_racikan WHERE no_register='$no_register'");
		}

		function cek_qty_gudang($id_inventory){
			return $this->db->query("SELECT * FROM gudang_inventory WHERE id_inventory= '$id_inventory' ");
		}

		function update_stok_obat($id_inventory, $qty){
			return $this->db->query("UPDATE gudang_inventory SET qty = qty-'$qty' WHERE id_inventory='$id_inventory'");
		}

		//update stok obat bila hapus
		function update_stok_obat_hapus($id_inventory, $qty){
			return $this->db->query("UPDATE gudang_inventory SET qty = qty+'$qty' WHERE id_inventory='$id_inventory'");
		}

		function edit_obat($id_resep_pasien, $data){
			$this->db->where('id_resep_pasien', $id_resep_pasien);
			$this->db->update('resep_pasien', $data);
			return true;
		}

		function get_margin_obat($carabayar){
            return $this->db->query("SELECT*FROM margin_obat WHERE cara_bayar = '$carabayar'");
        }

        function update_qty_pelayanan($data, $where){
			return $this->db->update('resep_pasien', $data, $where);
		}

		function cek_kronis_klaim($idobat, $poli, $kronis){
        	// return $this->db->query("SELECT * FROM master_obat_kronis_bpjs WHERE id_obat = $idobat AND poli = '".$poli."' AND kronis = $kronis");
        	return $this->db->query("SELECT * FROM master_obat_kronis_bpjs WHERE id_obat = $idobat AND poli = '".$poli."'");
		}

		function get_idpoli($noregister){
			return $this->db->query("SELECT id_poli FROM daftar_ulang_irj WHERE no_register = '$noregister'");
		}

		function get_satuan(){
			return $this->db->query("SELECT * FROM obat_satuan ORDER BY nm_satuan ASC");
		}

		function get_cara_pakai(){
			return $this->db->query("SELECT * FROM obat_cara_pakai where deleted = '0' ORDER BY cara_pakai ASC");
		}

		function get_qtx(){
			return $this->db->query("SELECT * FROM obat_qtx where deleted = '0' ORDER BY qtx ASC");
		}

		function get_signa(){
			return $this->db->query("SELECT * FROM signa WHERE deleted  = '0' order by signa asc ");
		}


		function check_stock_awal($id_inventory){
	        $query = $this->db->query("SELECT * FROM gudang_inventory WHERE id_inventory = '".$id_inventory."'");
	        if($query->num_rows() > 0){
	            return $query->row();
	        }else{
	            return 0;
	        }
    	}

	   function update_history_stok($no_resep){

	        $data = $this->db->query("SELECT item_obat, id_inventory, qty FROM resep_pasien WHERE no_resep =".$no_resep)->result();
	        foreach ($data as $item) {
	            //mohon ubah bila salah logic
	            if($item->item_obat==NULL OR $item->item_obat==''){
	                return true;
	            }else{
	            $stok = $this->check_stock_awal($item->id_inventory);
	        //    print_r($stok);die();
	            $stok_awal = $stok->qty + $item->qty;
	            $stok_akhir = $stok_awal - $item->qty;
	            $item_obat= $item->item_obat;
	            $batch_no= $stok->batch_no;
	            $id_gudang = $stok->id_gudang;

	            $this->db->query("INSERT INTO history_obat (id_obat, batch_no, no_transaksi, keterangan, stok_awal, penjualan, stok_akhir, created_by, created_date,gudang1)
	                    VALUES ('".$item_obat."', '0', '".$no_resep."', 'Transaksi Penjualan', '".$stok_awal."', '".$item->qty."', '".$stok_akhir."', '".$this->load->get_var("user_info")->username."', '".date('Y-m-d H:i:s')."',".$id_gudang.")");
	            }
	        }

	        return true;
	    }

		function get_data_permintaan($no_resep,$no_medrec,$no_register,$item_obat){
			//return $this->db->query("SELECT nama_obat,item_obat, biaya_obat, qty, cara_bayar, signa, vtot, racikan, id_resep_pasien FROM resep_pasien b where no_resep='$no_resep'");
			return $this->db->query("SELECT * FROM resep_pasien b
			where no_resep='".$no_resep."' and no_medrec = '".$no_medrec."' and no_register = '".$no_register."'
			and item_obat = '".$item_obat."'");
		}

		function get_data_permintaan_by_noreg($no_register){
			//return $this->db->query("SELECT nama_obat,item_obat, biaya_obat, qty, cara_bayar, signa, vtot, racikan, id_resep_pasien FROM resep_pasien b where no_resep='$no_resep'");
			return $this->db->query("SELECT * FROM resep_dokter b
			where no_register = '".$no_register."' ");
		}

		function get_tgl_kadaluarsa($item_obat,$id_gudang){
			//return $this->db->query("SELECT nama_obat,item_obat, biaya_obat, qty, cara_bayar, signa, vtot, racikan, id_resep_pasien FROM resep_pasien b where no_resep='$no_resep'");
			return $this->db->query("SELECT to_char(expire_date,'DD-MM-YYYY') as expire_date FROM gudang_inventory where id_obat ='".$item_obat."' and id_gudang = 1 ");
		}

		function get_resep_obat($date){

			return $this->db->query("SELECT resep_pasien.no_resep, resep_pasien.no_register, data_pasien.no_cm,
			CASE WHEN LEFT(no_register,2)='PL'
						THEN
						   (SELECT nama FROM pasien_luar WHERE no_register=resep_pasien.no_register)
						ELSE  (SELECT nama FROM data_pasien WHERE CAST(no_medrec AS TEXT)=resep_pasien.no_medrec)  end
						as nama,
						tgl_kunjungan, kelas, (select idrg from resep_header where no_resep=resep_pasien.no_resep) as idrg,
						(select bed from resep_header where no_resep=resep_pasien.no_resep) as bed, cetak_kwitansi, cara_bayar
						FROM resep_pasien
						JOIN data_pasien on CAST(data_pasien.no_medrec AS TEXT)=resep_pasien.no_medrec
						WHERE no_resep IS NOT NULL
						and no_resep != 0
						AND to_char(tgl_kunjungan,'YYYY-MM-DD')='".$date."'
						ORDER BY no_register");
		}

		function get_obat_cari($ids)
		{
			return $this->db->select('o.id_obat,
			o.nm_obat,
			o.hargabeli,
			o.hargajual,
			g.batch_no,
			g.expire_date,
			g.qty,
			o.jenis_obat,
			g.id_inventory')
			->from('gudang_inventory g')
			->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
			->where('g.id_gudang', $ids)->limit(10, 0)->get();

			// return $this->db->query("SELECT o.id_obat,o.nm_obat,o.hargabeli,
			// o.hargajual,g.batch_no,g.expire_date,g.qty,o.jenis_obat,g.id_inventory
			// FROM gudang_inventory g INNER JOIN master_obat o , o.id_obat = g.id_obat
			// WHERE g.id_gudang = $ids LIMIT 10");
		}

		public function get_data_obat_query_poli($id_poli){
			return $this->db->select('b.id_obat,
			b.nm_obat,
			b.jenis_obat,')
					->from('master_obat b', 'b.id_obat = c.id_obat', 'inner')
					->join('obat_poli c', 'c.id_obat = b.id_obat')
					->where('b.id_obat = b.id_obat')
					->where('b.deleted = 0')
					->where('c.id_poli',$id_poli)
					->get();
		}

		public function get_data_obat_query_all(){
			return $this->db->select('id_obat,
			nm_obat,
			jenis_obat,')
					->from('master_obat')
					->where('deleted = 0')
					->get();
		}

		public function get_data_obat_query_diag($id_diagnosa){
			return $this->db->select('b.id_obat,
			b.nm_obat,
			b.jenis_obat,
			')
					->from('master_obat b')
					->join('obat_diagnosa c', 'c.id_obat = b.id_obat')
					->where('c.id_obat = b.id_obat')
					->where('b.deleted = 0')
					->where('c.id_diagnosa',$id_diagnosa)
					->get();
		}

		public function get_data_obat_query_history($ids,$userid,$no_medrec){
			return $this->db->select('a.id_resep_pasien,
			a.signa,
			a.qty as resep_qty,
			a.Satuan_obat,
			a.cara_pakai,
			a.qtx,
			a.kali_harian,
			a.nama_obat as nm_obat,
			a.biaya_obat as hargajual,
			a.id_inventory,
			a.item_obat as id_obat')
				->from('resep_pasien a')
				->where('a.no_medrec',$no_medrec)
				->group_by(array("a.id_resep_pasien","a.signa","a.Satuan_obat",
							"a.cara_pakai","a.qtx","a.kali_harian", "resep_qty","a.nama_obat",
							"a.biaya_obat","a.id_inventory","a.item_obat"))
				->get();
			// return $this->db->select('a.id_resep_pasien,a.signa,
			// 	a.qty as resep_qty,
			// 	b.id_obat,
			// 	c.nm_obat,
			// 	c.hargabeli,
			// 	c.hargajual,
			// 	b.batch_no,
			// 	b.expire_date,
			// 	b.qty,
			// 	c.jenis_obat,
			// 	b.id_inventory')
			// 		->from('resep_pasien a')
			// 		->join('gudang_inventory b', 'b.id_obat = cast(a.item_obat as integer)', 'inner')
			// 		->join('master_obat c', 'c.id_obat = cast(a.item_obat as integer)', 'inner')
			// 		->join('dyn_gudang_user d', 'd.id_gudang = b.id_gudang', 'inner')
			// 		->where('b.id_obat = cast(a.item_obat as integer)')
			// 		->where('c.id_obat = cast(a.item_obat as integer)')
			// 		->where('d.id_gudang = b.id_gudang')
			// 		->where('c.deleted = 0 ')
			// 		->where('b.id_gudang',$ids)
			// 		->where('d.userid',$userid)
			// 		->where('a.no_medrec',$no_medrec)
			// 		->group_by(array("a.id_resep_pasien","a.signa", "resep_qty","b.id_obat","c.nm_obat","c.hargabeli",
			// 					"c.hargajual",
			// 					"b.batch_no",
			// 					"b.expire_date",
			// 					"b.qty",
			// 					"c.jenis_obat",
			// 					"b.id_inventory"))
			// 		->get();
		}

		public function get_data_obat_query(){
			return $this->db->select('id_obat,
			nm_obat,
			jenis_obat,')
					->from('master_obat')
					->where('deleted = 0')
					->get();
		}
		public function get_data_obat_query_for_dpo(){
			return $this->db->select('id_obat,
			nm_obat,
			jenis_obat,
			')
					->from('master_obat')
					->where('deleted = 0')
					->get();
		}

		public function get_data_obat_query_edit($ids,$userid,$id_obat){
			return $this->db->select('a.id_obat,
			b.nm_obat,
			b.hargabeli,
			b.hargajual,
			a.batch_no,
			a.expire_date,
			a.qty,
			b.jenis_obat,
			a.id_inventory')
					->from('gudang_inventory a')
					->join('master_obat b', 'b.id_obat = a.id_obat', 'inner')
					->join('dyn_gudang_user d', 'd.id_gudang = a.id_gudang', 'inner')
					->where('b.id_obat = a.id_obat')
					->where('d.id_gudang = a.id_gudang')
					->where('a.id_gudang',$ids)
					->where('d.userid',$userid)
					->where('b.id_obat',$id_obat)
					->get();
		}

		var $column_order = array(null,'o.nm_obat'); //set column field database for datatable orderable
		var $column_search = array('o.nm_obat'); //set column field database for datatable searchable
		var $order = array('id_obat' => 'desc'); // default order '


		private function get_data_obat_query_ajax($ids){
			return $this->db->select('o.id_obat,
			o.nm_obat,
			o.hargabeli,
			o.hargajual,
			g.batch_no,
			g.expire_date,
			g.qty,
			o.jenis_obat,
			g.id_inventory')
					->from('gudang_inventory g')
					->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
					->join('obat_poli p', 'o.id_obat = p.id_obat', 'inner')
					->where('o.id_obat = p.id_obat');

					$i = 0;
            foreach ($this->column_search as $item)
            {
                if($_POST['search']['value'])
                {

                    if($i===0)
                    {
                        $this->db->group_start();
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }

                    if(count($this->column_search) - 1 == $i)
                        $this->db->group_end();
                }
	                $i++;
	        }

	        if(isset($_POST['order'])) // here order processing
	        {
	            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        }
	        else if(isset($this->order))
	        {
	            $order = $this->order;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
		}


		function data_obat($ids){
			$this->get_data_obat_query_ajax($ids);
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
			// $this->db->query("SELECT * FROM ")
			// return $this->db->select('o.id_obat,
			// o.nm_obat,
			// o.hargabeli,
			// o.hargajual,
			// g.batch_no,
			// g.expire_date,
			// g.qty,
			// o.jenis_obat,
			// g.id_inventory')
			// 		->from('gudang_inventory g')
			// 		->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
			// 		->where('g.id_gudang', $ids);

			// return $this->db->query("select o.id_obat,o.nm_obat,o.hargabeli,o.hargajual,g.batch_no,g.expire_date,g.qty,o.jenis_obat,g.id_inventory from gudang_inventory g
			// inner join master_obat o on o.id_obat = g.id_obat where g.id_gudang=$ids")->result();
		}

		function count_filtered($ids)
		{
			$this->get_data_obat_query_ajax($ids);
			$query = $this->db->get();
			return $query->num_rows();
		}

		public function count_all($ids)
		{
			$this->get_data_obat_query_ajax($ids);
			//$this->db->from($this->table);
			return $this->db->count_all_results();
		}

		public function insert_telaah($data)
		{
			return $this->db->insert('telaah_obat',$data);
		}

		function update_data_telaah($noreg,$data)
		{
			$this->db->where('no_register',$noreg);
			return $this->db->update('telaah_obat',$data);
		}

		function getnama_dokter_by_noreg($no_reg){
			return $this->db->query("SELECT a.id_dokter,b.nm_dokter,ttd FROM daftar_ulang_irj a
			LEFT JOIN data_dokter b on a.id_dokter = b.id_dokter
			WHERE a.no_register='$no_reg'");
		}

		function get_obat_poli($id_poli){
			// return $this->db->query("SELECT * FROM obat_poli,master_obat WHERE obat_poli.id_obat = master_obat.id_obat and obat_poli.id_poli = '$id_poli' and master_obat.deleted = '0' ");
			return $this->db->query("SELECT
			a.id_obat,a.qty,a.batch_no,a.expire_date,b.nm_obat,a.id_inventory
			FROM
				gudang_inventory as a
			LEFT JOIN master_obat as b  ON a.id_obat = b.id_obat
			LEFT JOIN obat_poli as c ON a.id_obat = c.id_obat WHERE c.id_poli = '$id_poli' and b.deleted = '0' ");
		}

		function get_obat_poli_new($id_poli){
			// return $this->db->query("SELECT * FROM obat_poli,master_obat WHERE obat_poli.id_obat = master_obat.id_obat and obat_poli.id_poli = '$id_poli' and master_obat.deleted = '0' ");
			return $this->db->query("SELECT
			b.nm_obat,b.id_obat
			FROM
				 master_obat as b 
			LEFT JOIN obat_poli as c ON b.id_obat = c.id_obat WHERE c.id_poli = '$id_poli' and b.deleted = '0' ");
		}

		function get_noreg_asal($no_register){
			return $this->db->query("SELECT * FROM pasien_iri WHERE  no_ipd = '$no_register'");
		}

		function get_id_poli_by_noreg($no_register){
			return $this->db->query("SELECT * FROM daftar_ulang_irj WHERE no_register = '$no_register'");
		}

		function get_poliklinik(){
			return $this->db->query("SELECT * FROM poliklinik WHERE active  = '1' ");
		}

		function get_obat_pilih_poli($id_poli){

			return $this->db->select('b.id_obat,
			b.nm_obat,
			b.jenis_obat,
			')
					->from('master_obat b')
					->join('obat_poli c', 'c.id_obat = b.id_obat')
					->where('b.id_obat = c.id_obat')
					->where('b.deleted = 0')
					->where('c.id_poli',$id_poli)
					->limit(10)
					->get();
		}

		function get_obat_pilih_poli_search($id_poli,$text){

			return $this->db->select('b.id_obat,
			b.nm_obat,
			b.jenis_obat,
			')
					->from('master_obat b')
					->join('obat_poli c', 'c.id_obat = b.id_obat')
					->where('b.id_obat = c.id_obat')
					->where('b.deleted = 0')
					->where('c.id_poli',$id_poli)
					->like('UPPER(b.nm_obat)',strtoupper($text))
					->limit(10)
					->get();
		}

		function get_diagnosa(){
			return $this->db->query("SELECT * FROM icd1 WHERE deleted  = '0 ' ");
		}

		function get_obat_pilih_diag($id_icd){

			return $this->db->select('b.id_obat,
			b.nm_obat,
			b.jenis_obat,')
					->from('master_obat b')
					->join('obat_diagnosa c', 'c.id_obat = b.id_obat')
					->where('c.id_obat = b.id_obat')
					->where('c.id_obat >= 7000')
					->where('b.deleted = 0')
					->where('c.id_diagnosa',$id_icd)
					->limit(10)
					->get();
		}

		function get_obat_pilih_diag_search($id_icd,$text){

			return $this->db->select('b.id_obat,
			b.nm_obat,
			b.jenis_obat,')
					->from('master_obat b')
					->join('obat_diagnosa c', 'c.id_obat = b.id_obat')
					->where('c.id_obat = b.id_obat')
					->where('b.deleted = 0')
					->where('c.id_diagnosa',$id_icd)
					->like('UPPER(b.nm_obat)',$text)
					->limit(10)
					->get();
		}

		function get_obat_pilih_all_search($text){

			return $this->db->select('id_obat,
			nm_obat,
			jenis_obat,
			')
					->from('master_obat')
					->where('deleted = 0')
					->like('UPPER(nm_obat)',strtoupper($text))
					->limit(10)
					->get();
		}



		function get_obat_history($no_medrec,$ids,$userid){
			return $this->db->select('a.id_resep_pasien,
			a.signa,
			a.qty as resep_qty,
			a.Satuan_obat,
			a.cara_pakai,
			a.qtx,
			a.kali_harian,
			a.nama_obat as nm_obat,
			a.biaya_obat as hargajual,
			a.id_inventory,
			a.item_obat as id_obat ')
				->from('resep_pasien a')
				->where('a.no_medrec',$no_medrec)
				->group_by(array("a.id_resep_pasien","a.signa","a.Satuan_obat",
							"a.cara_pakai","a.qtx","a.kali_harian", "resep_qty","a.nama_obat",
							"a.biaya_obat","a.id_inventory","a.item_obat"))
				->get();
			// return $this->db->select('a.id_resep_pasien,
			// 	a.signa,
			// 	a.qty as resep_qty,
			// 	a.Satuan_obat,
			// 	a.cara_pakai,
			// 	a.qtx,
			// 	a.kali_harian,
			// 	b.id_obat,
			// 	c.nm_obat,
			// 	c.hargabeli,
			// 	c.hargajual,
			// 	b.batch_no,
			// 	b.expire_date,
			// 	b.qty,
			// 	c.jenis_obat,
			// 	b.id_inventory')
			// 		->from('resep_pasien a')
			// 		->join('gudang_inventory b', 'b.id_obat = cast(a.item_obat as integer)', 'inner')
			// 		->join('master_obat c', 'c.id_obat = cast(a.item_obat as integer)', 'inner')
			// 		->join('dyn_gudang_user d', 'd.id_gudang = b.id_gudang', 'inner')
			// 		->where('b.id_obat = cast(a.item_obat as integer)')
			// 		->where('c.id_obat = cast(a.item_obat as integer)')
			// 		->where('d.id_gudang = b.id_gudang')
			// 		->where('c.deleted = 0 ')
			// 		->where('b.id_gudang',$ids)
			// 		->where('d.userid',$userid)
			// 		->where('a.no_medrec',$no_medrec)
			// 		->group_by(array("a.id_resep_pasien","a.signa","a.Satuan_obat",
			// 					"a.cara_pakai","a.qtx","a.kali_harian", "resep_qty","b.id_obat","c.nm_obat","c.hargabeli",
			// 					"c.hargajual",
			// 					"b.batch_no",
			// 					"b.expire_date",
			// 					"b.qty",
			// 					"c.jenis_obat",
			// 					"b.id_inventory"))
			// 		->get();
		}


		function get_obat_history_asal($noregasal,$ids,$userid){
			return $this->db->select('a.id_resep_pasien,
			a.signa,
			a.qty as resep_qty,
			a.Satuan_obat,
			a.cara_pakai,
			a.qtx,
			a.kali_harian,
			a.nama_obat as nm_obat,
			a.biaya_obat as hargajual,
			a.id_inventory,
			a.item_obat as id_obat')
				->from('resep_pasien a')
				->where('a.no_register',$noregasal)
				->group_by(array("a.id_resep_pasien","a.signa","a.Satuan_obat",
							"a.cara_pakai","a.qtx","a.kali_harian", "resep_qty","a.nama_obat",
							"a.biaya_obat","a.id_inventory","a.item_obat"))
				->get();

			// return $this->db->select('a.id_resep_pasien,
			// 	a.signa,
			// 	a.qty as resep_qty,
			// 	a.Satuan_obat,
			// 	a.cara_pakai,
			// 	a.qtx,
			// 	a.kali_harian,
			// 	b.id_obat,
			// 	c.nm_obat,
			// 	c.hargabeli,
			// 	c.hargajual,
			// 	b.batch_no,
			// 	b.expire_date,
			// 	b.qty,
			// 	c.jenis_obat,
			// 	b.id_inventory')
			// 		->from('resep_pasien a')
			// 		->join('gudang_inventory b', 'b.id_obat = cast(a.item_obat as integer)', 'inner')
			// 		->join('master_obat c', 'c.id_obat = cast(a.item_obat as integer)', 'inner')
			// 		->join('dyn_gudang_user d', 'd.id_gudang = b.id_gudang', 'inner')
			// 		->where('b.id_obat = cast(a.item_obat as integer)')
			// 		->where('c.id_obat = cast(a.item_obat as integer)')
			// 		->where('d.id_gudang = b.id_gudang')
			// 		->where('c.deleted = 0 ')
			// 		->where('b.id_gudang',$ids)
			// 		->where('d.userid',$userid)
			// 		->where('a.no_register',$noregasal)
			// 		->group_by(array("a.id_resep_pasien","a.signa","a.Satuan_obat",
			// 					"a.cara_pakai","a.qtx","a.kali_harian", "resep_qty","b.id_obat","c.nm_obat","c.hargabeli",
			// 					"c.hargajual",
			// 					"b.batch_no",
			// 					"b.expire_date",
			// 					"b.qty",
			// 					"c.jenis_obat",
			// 					"b.id_inventory"))
			// 		->get();
		}



		function get_obat_pilih_history_search($no_medrec,$ids,$userid,$text){
			return $this->db->select('a.id_resep_pasien,
			a.signa,
			a.qty as resep_qty,
			a.Satuan_obat,
			a.cara_pakai,
			a.qtx,
			a.kali_harian,
			a.nama_obat as nm_obat,
			a.biaya_obat as hargajual,
			a.id_inventory,
			a.item_obat as id_obat')
				->from('resep_pasien a')
				->where('a.no_medrec',$no_medrec)
				->like('UPPER(a.nama_obat)',$text)
				->group_by(array("a.id_resep_pasien","a.signa","a.Satuan_obat",
							"a.cara_pakai","a.qtx","a.kali_harian", "resep_qty","a.nama_obat",
							"a.biaya_obat","a.id_inventory","a.item_obat"))
				->get();
			// return $this->db->select('a.id_resep_pasien,a.signa,
			// 	a.qty as resep_qty,
			// 	a.Satuan_obat,
			// 	a.cara_pakai,
			// 	a.qtx,
			// 	a.kali_harian,
			// 	b.id_obat,
			// 	c.nm_obat,
			// 	c.hargabeli,
			// 	c.hargajual,
			// 	b.batch_no,
			// 	b.expire_date,
			// 	b.qty,
			// 	c.jenis_obat,
			// 	b.id_inventory')
			// 		->from('resep_pasien a')
			// 		->join('gudang_inventory b', 'b.id_obat = cast(a.item_obat as integer)', 'inner')
			// 		->join('master_obat c', 'c.id_obat = cast(a.item_obat as integer)', 'inner')
			// 		->join('dyn_gudang_user d', 'd.id_gudang = b.id_gudang', 'inner')
			// 		->where('b.id_obat = cast(a.item_obat as integer)')
			// 		->where('c.id_obat = cast(a.item_obat as integer)')
			// 		->where('d.id_gudang = b.id_gudang')
			// 		->where('c.deleted = 0 ')
			// 		->where('b.id_gudang',$ids)
			// 		->where('d.userid',$userid)
			// 		->where('a.no_medrec',$no_medrec)
			// 		->like('UPPER(c.nm_obat)',$text)
			// 		->group_by(array("a.id_resep_pasien","a.signa","a.Satuan_obat",
			// 						"a.cara_pakai","a.qtx","a.kali_harian", "resep_qty","b.id_obat","c.nm_obat","c.hargabeli",
			// 						"c.hargajual",
			// 						"b.batch_no",
			// 						"b.expire_date",
			// 						"b.qty",
			// 						"c.jenis_obat",
			// 						"b.id_inventory"))
			// 		->limit(10)
			// 		->get();
		}


		function get_no_medrec_pl_by_noreg($no_register){
			return $this->db->query("SELECT * FROM pasien_luar WHERE no_register = '$no_register' ");
		}

		function get_no_medrec_rj_by_noreg($no_register){
			return $this->db->query("SELECT * FROM daftar_ulang_irj WHERE no_register = '$no_register' ");
		}

		function get_no_medrec_ri_by_noreg($no_register){
			return $this->db->query("SELECT * FROM pasien_iri WHERE no_ipd = '$no_register' ");
		}

		function get_id_obat_by_resep_pasien($id_resep_pasien){
			return $this->db->query("SELECT item_obat FROM resep_pasien WHERE id_resep_pasien = '$id_resep_pasien' ");
		}

		function get_no_resep_by_noreg($no_register){
			return $this->db->query("SELECT no_resep FROM resep_header WHERE no_resgister = '$no_register' ");
		}

		function update_no_resep($no_resep,$no_register){
			return $this->db->query("UPDATE resep_pasien set no_resep = '$no_resep' WHERE no_register = '$no_register' and no_resep='0' ");
		}

		function data_telaah($no_register){
			return $this->db->query("SELECT * FROM telaah_obat WHERE no_register ='$no_register'");
		}

		function edit_obat_racikan($id_obat_racikan, $data){
			$this->db->where('id_obat_racikan', $id_obat_racikan);
			$this->db->update('obat_racikan', $data);
			return true;
		}

		function get_resep_pasien_racikan_petugas($id_resep_pasien){
			return $this->db->query("SELECT * from obat_racikan a, master_obat b
			where a.item_obat = b.id_obat
			and  id_resep_pasien='$id_resep_pasien'");
		}

		function update_racikan_petugas($no_register,$id_resep_pasien,$data){
			$this->db->where('no_register',$no_register);
			$this->db->where('id_resep_pasien',$id_resep_pasien);
			$this->db->update('resep_pasien', $data);
			return true;
		}

		function get_resep_pasien_racikan_selesai_petugas($id_resep_pasien){
			return $this->db->query("SELECT * from resep_pasien
			where id_resep_pasien='$id_resep_pasien'");
		}

		function get_obat_igd($id_gudang){
			return $this->db->query("
			select c.id_obat,
						b.nm_obat,
						b.hargabeli,
						b.hargajual,
						c.batch_no,
						c.expire_date,
						c.qty,
						b.jenis_obat,
						c.id_inventory
			from obat_poli a,master_obat b,gudang_inventory c
			where a.id_obat = b.id_obat
			and a.id_obat = c.id_obat
			and c.id_gudang = '$id_gudang'
			and a.id_poli = 'BA00'");
		}

		function detail_obat_igd($id_gudang,$id_inventory){
			return $this->db->query("
			select c.id_obat,
						b.nm_obat,
						b.hargabeli,
						b.hargajual,
						c.batch_no,
						c.expire_date,
						c.qty,
						b.jenis_obat,
						c.id_inventory
			from obat_poli a,master_obat b,gudang_inventory c
			where a.id_obat = b.id_obat
			and a.id_obat = c.id_obat
			and c.id_gudang = '$id_gudang'
			and a.id_poli = 'BA00'
			and c.id_inventory = '$id_inventory' ");
		}

		function last_obat($no_register){
			return $this->db->query("SELECT * from resep_pasien
			where no_register = '$no_register'
			and no_resep != '0'
			and no_resep = (select no_resep from resep_pasien where no_register = '$no_register' and no_resep != 0 order by no_resep desc limit 1) ");
		}

		function get_noreg_by_medrec_poli($medrec,$poli){
			return $this->db->query("SELECT * from daftar_ulang_irj where no_medrec = '$medrec' and id_poli = '$poli' order by tgl_kunjungan desc limit 1 ");
		}

		function get_noreg_by_medrec_poli_rj($medrec,$poli){
			return $this->db->query("SELECT * from daftar_ulang_irj where no_medrec = '$medrec' and id_poli = '$poli' and status_obat != 0 order by tgl_kunjungan desc limit 1 ");
		}

		// function get_ngobat($gudangalxbd){
		// 	return $this->db->query("SELECT * FROM gudang_inventory a, master_obat b
		// 	where a.id_obat = b.id_obat and id_gudang = '$gudangalxbd' order by b.nm_obat asc ");
		// }
		function get_ngobat(){
			return $this->db->query("SELECT * FROM master_obat b order by b.id_obat asc ");
		}

		function get_all_obat_today($no_reg){
			return $this->db->query("SELECT * FROM resep_pasien where no_register = '$no_reg' and to_char(tgl_kunjungan,'YYYY-MM-DD') = to_char(now(),'YYYY-MM-DD') order by no_resep ");
		}

		function update_no_resep_racik($no_resep,$no_register){
			return $this->db->query("UPDATE obat_racikan set no_resep = '$no_resep' WHERE no_register = '$no_register' and no_resep is null ");
		}

		function get_racik_last($id_resep_pasien){
			return $this->db->query("SELECT * FROM obat_racikan where id_resep_pasien = '$id_resep_pasien' ");
		}

		public function insert_racik_last($data)
		{
			return $this->db->insert('obat_racikan',$data);
		}

		function insert_permintaan_last($data){
			//  var_dump($data);die();
			if($data['no_resep'] == ''){
				$data['no_resep'] = intval($data['no_resep']);
			}
			// var_dump($data['no_resep']);die();
			$this->db->insert('resep_pasien', $data);
			return $this->db->insert_id();
		}

		function insert_permintaan_last_dokter($data){
			//  var_dump($data);die();
			if($data['no_resep'] == ''){
				$data['no_resep'] = intval($data['no_resep']);
			}
			// var_dump($data['no_resep']);die();
			$this->db->insert('resep_dokter', $data);
			return $this->db->insert_id();
		}

		function get_pengambilan_resep_pasien_selesai(){
            return $this->db->query("SELECT no_resep, no_register,tgl_kunjungan,kelas,cetak_kwitansi,cara_bayar,(SELECT idrg FROM resep_header WHERE no_resep=resep_pasien.no_resep) AS idrg, (SELECT bed FROM resep_header WHERE no_resep=resep_pasien.no_resep) AS bed,
			CASE
			WHEN LEFT(no_register,2)='PL' then (SELECT nama FROM pasien_luar WHERE no_cm=cast(resep_pasien.no_medrec as int))
			else
				(SELECT nama FROM data_pasien WHERE no_medrec=cast(resep_pasien.no_medrec as int))
			END
			as nama
			FROM resep_pasien
			WHERE no_resep IS NOT NULL
			ORDER BY no_resep DESC LIMIT 500");
        }

		function get_detail_obat_retur($noresep){
            return $this->db->query("SELECT r.*
            FROM resep_pasien r
            WHERE r.no_resep = ".$noresep);
        }

		function get_detail_resep($idresep){
            return $this->db->query("SELECT * FROM resep_pasien WHERE id_resep_pasien = ".$idresep);
        }

		function update_data($data){
            $detail = $this->get_detail_resep($data['id_resep_pasien'])->row();
            $newqty = $detail->qty - $data['qty'];
            $vtot = $newqty * $detail->biaya_obat;

            return $this->db->query("UPDATE resep_pasien SET qty = ".$newqty.", vtot = ".$vtot."
                            WHERE id_resep_pasien = ".$data['id_resep_pasien']);
        }

		function hapus_data_obat_penjualan($data){
            $detail = $this->get_detail_resep($data['id_resep_pasien'])->row();

            $this->update_stok($detail->qty, $data['id_inventory']);
            return $this->db->query("DELETE FROM resep_pasien WHERE id_resep_pasien = ".$data['id_resep_pasien']);
        }

        function update_stok($qty, $idinventory){
            return $this->db->query("UPDATE gudang_inventory SET qty = qty + ".$qty." WHERE id_inventory = ".$idinventory);
        }

		function get_tarif_embalase() {
			return $this->db->query("SELECT
				a.idtindakan,
				a.nmtindakan,
				b.total_tarif 
			FROM
				jenis_tindakan AS A,
				tarif_tindakan AS b
			WHERE 
				a.idtindakan = b.id_tindakan
				AND a.idtindakan IN ('1B0205', '1B0206',  '1B0207',  '1B0208', '1B0210',  '1B0213',  '1B0211',  '1B0214' )
				AND b.kelas = 'NK'");
		}

		function get_data_resep_by_id($id) {
			return $this->db->query("SELECT * FROM resep_pasien WHERE id_resep_pasien = '$id'");
		}

		function insert_tarif_embalase($id, $data) {
			$this->db->where('id_resep_pasien', $id);
			$this->db->update('resep_pasien', $data);
			return true;
		}

		function insert_permintaan_dokter($data){
			// var_dump($data);die();
			if(isset($data['no_resep'])){
				$data['no_resep'] = intval($data['no_resep']);
			}
			// var_dump($data['no_resep']);die();
			$this->db->insert('resep_dokter', $data);
			return true;
		}

		function get_resep_pasien_dokter($id_resep_dokter){
			return $this->db->query("SELECT * FROM resep_dokter WHERE id_resep_dokter='$id_resep_dokter'");
		}

		

		function edit_obat_dokter($id_resep_dokter, $data){
			$this->db->where('id_resep_dokter', $id_resep_dokter);
			$this->db->update('resep_dokter', $data);
			return true;
		}

		function update_resep_dokter($id,$data){
			$this->db->where('id_resep_dokter',$id);
			$this->db->update('resep_dokter', $data);
			return true;
		}

		function get_resep_pasien_farmasi($id_resep_dokter,$id_gudang){
			return $this->db->query("SELECT a.*,b.batch_no,b.expire_date,b.id_inventory,b.qty as stock,b.hargajual,b.satuan as satuan_obat 
			FROM resep_dokter a left join gudang_inventory b on a.id_obat = b.id_obat  
			WHERE id_resep_dokter= $id_resep_dokter and b.id_gudang = $id_gudang");
		}

		function get_resep_pasien_farmasi_racik($id_racikan,$id_gudang){
			return $this->db->query("SELECT a.*,b.batch_no,b.expire_date,b.id_inventory,b.qty as stock,b.hargajual,b.satuan as satuan_obat 
			FROM obat_racikan a left join gudang_inventory b on a.item_obat = b.id_obat  
			WHERE id_obat_racikan = $id_racikan and b.id_gudang = $id_gudang");
		}

		function update_obat_racik($id_obat_racik, $id_obat, $nm_obat){
            return $this->db->query("UPDATE obat_racikan SET item_obat = $id_obat , nama_obat = '$nm_obat' WHERE id_obat_racikan = $id_obat_racik ");
        }

		function update_stok_racik($qty, $idinventory){
            return $this->db->query("UPDATE gudang_inventory SET qty = qty - ".$qty." WHERE id_inventory = ".$idinventory);
        }

		function getdata_resep_pasien_dokter($no_register){
			return $this->db->query("SELECT * FROM resep_dokter where no_register='$no_register' and inputfarmasi = '0'");
		}

		function getdata_resep_pasien_farmasi($no_register){
			return $this->db->query("SELECT a.*,b.hargajual,b.batch_no,b.expire_date,
			(select signa from resep_dokter where resep_dokter.id_resep_dokter = a.id_resep_dokter ) as signa_all 
			FROM resep_pasien a left join gudang_inventory b on a.id_inventory = b.id_inventory   and b.deleted = 0
			where a.no_register = '$no_register' and a.no_resep is null");
		}
		function hapus_data_obat_dokter($id_resep_dokter){
			$this->db->where('id_resep_dokter', $id_resep_dokter);
       		$this->db->delete('resep_dokter');
			return true;
		}
		public function get_data_obat_query_resep($ids,$userid){
			return $this->db->select('a.id_obat,
			b.nm_obat,
			a.hargabeli,
			a.hargajual,
			a.batch_no,
			a.expire_date,
			a.qty,
			b.jenis_obat,
			a.id_inventory')
					->from('gudang_inventory a')
					->join('master_obat b', 'b.id_obat = a.id_obat', 'inner')
					->join('dyn_gudang_user d', 'd.id_gudang = a.id_gudang', 'inner')
					->where('b.id_obat = a.id_obat')
					->where('d.id_gudang = a.id_gudang')
					->where('b.deleted = 0')
					->where('a.id_gudang',$ids)
					->where('d.userid',$userid)
					->get();
		}

		function getdata_resep_racikan2($id_paket){
			return $this->db->query("SELECT * FROM obat_racikan, master_obat where obat_racikan.item_obat=master_obat.id_obat AND id_paket='".$id_paket."' AND id_paket_detail IS NULL");
		}

		function insert_racikan2($item_obat,$qty,$id_paket){
			$this->db->query("INSERT INTO obat_racikan (item_obat,qty,id_paket) values ('$item_obat','$qty','$id_paket')");
			return true;
		}

		function update_racikan2($id_paket,$id_resep){
			return $this->db->query("UPDATE obat_racikan SET id_paket_detail='$id_resep' WHERE id_paket='$id_paket' AND id_paket_detail IS NULL");
		}

		function hapus_data_obat2($id){
			$this->db->where('id', $id);
       		$this->db->delete('paket_obat_detail');			
			return true;
		}

		function hapus_data_obat_racik2($id){
			$this->db->where('id_paket_detail', $id);
       		$this->db->delete('obat_racikan');			
			return true;
		}

		function get_paket_obat(){
			return $this->db->query("SELECT * FROM paket_obat order by id_paket asc");
		}
		
		
		function get_paket_obat_id($id){
			return $this->db->query("SELECT * FROM paket_obat where id_paket = $id");
		}

		function get_detail_paket_obat($id_paket){
			return $this->db->query("SELECT *,(select nm_obat from master_obat where paket_obat_detail.id_obat = master_obat.id_obat)
			 FROM paket_obat_detail where id_paket = $id_paket");
		}

		function get_detail_paket_obat_racik($id_paket_detail){
			return $this->db->query("select *,(select nm_obat from master_obat 
			where master_obat.id_obat = obat_racikan.item_obat) from obat_racikan where id_paket_detail = $id_paket_detail");
		}

		function get_obat_for_luar($id_gd){
			return $this->db->query("SELECT o.id_obat, o.nm_obat,g.hargajual,
			g.qty, g.expire_date,g.batch_no,g.quantity_retur,g.id_inventory
			FROM master_obat o
			LEFT JOIN gudang_inventory g ON g.id_obat = o.id_obat
			WHERE g.id_gudang = '$id_gd' and o.deleted = '0' and g.deleted = 0 and g.qty > 0");
		}

		function get_item_obat_luar($id_inven){
			return $this->db->query("SELECT id_obat,(select nm_obat from master_obat 
			where gudang_inventory.id_obat = master_obat.id_obat) 
			from gudang_inventory where id_inventory = $id_inven and deleted = 0");
		}

		function update_flag_daftar_ulang_irj($noreg,$data)
		{
			return $this->db->where('no_register',$noreg)->update('daftar_ulang_irj',$data);
		}
	}
?>
