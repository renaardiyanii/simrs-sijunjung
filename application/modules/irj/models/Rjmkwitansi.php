<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rjmkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_nomor_kwitansi_by_noregister($no_register)
		{
			return $this->db->query("SELECT * FROM nomor_kwitansi where no_register='$no_register' ");
		}

		function get_pasien_kwitansi_bpjs($date){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi = '0' and daftar_ulang_irj.status = '0' and daftar_ulang_irj.cara_bayar in ('BPJS') and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-DD')='$date' order by daftar_ulang_irj.cara_bayar desc");
		}

		function get_pasien_kwitansi($date){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi_st is null and daftar_ulang_irj.cara_bayar in ('UMUM','KERJASAMA','BPJS') and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-DD')='$date' order by daftar_ulang_irj.cara_bayar desc");
		}
		function get_pasien_kwitansi_by_nocm($no_medrec){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='1' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and data_pasien.no_medrec='$no_medrec' order by daftar_ulang_irj.cara_bayar desc");
		}
		function get_pasien_kwitansi_by_noregister($no_register){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='1' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.no_register='$no_register' order by daftar_ulang_irj.cara_bayar desc");
		}
		function get_pasien_kwitansi_by_date($date){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where  daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and left(daftar_ulang_irj.tgl_kunjungan,10)='$date' order by daftar_ulang_irj.cara_bayar desc");
		}
		/////////////////////////////////////////////////////////////////////////////////////kwitansi semua
		function getdata_pasien($no_register){
			if(substr($no_register,0,2) == 'RJ'){
				return $this->db->query("SELECT data_pasien.nama,data_pasien.alamat,*, (select nm_dokter from data_dokter where id_dokter=a.id_dokter limit 1) as nm_dokter 
						FROM daftar_ulang_irj as a, data_pasien, poliklinik 
							where data_pasien.no_medrec=a.no_medrec 
							and poliklinik.id_poli=a.id_poli 
							and a.no_register='$no_register' ");
			}elseif (substr($no_register,0,2) == 'RI') {
				return $this->db->query("SELECT data_pasien.nama,data_pasien.alamat,*, (select nm_dokter from data_dokter where id_dokter=a.id_dokter limit 1) as nm_dokter 
							FROM pasien_iri as a, data_pasien, ruang 
								where data_pasien.no_medrec=a.no_medrec 
								and ruang.idrg=a.idrg 
								and a.no_ipd='$no_register' ");
			}else{
				return $this->db->query("SELECT a.*,a.jk as sex,a.dokter as nm_dokter,CONCAT  ('PL', '-', a.no_cm) AS no_medrec
					FROM pasien_luar as a
						where a.no_register='$no_register' ");
			}
			
		}

  

		function getdata_pasien_nokwitansi($id_kwitansi){
			return $this->db->query("SELECT
				*, a.xuser as user_cetak from nomor_kwitansi a 
				JOIN daftar_ulang_irj b ON a.no_register=b.no_register
				LEFT JOIN poliklinik c ON c.id_poli=b.id_poli
				JOIN data_pasien d ON d.no_medrec=b.no_medrec
				LEFT JOIN data_dokter e ON e.id_dokter=b.id_dokter
				where a.idno_kwitansi=$id_kwitansi");
		}

		function getdata_tindakan_pasien($no_register){
			return $this->db->query("SELECT 
				* 
			FROM 
				pelayanan_poli 
			where 
				no_register='$no_register' 
				and bayar is null 
				and idtindakan != '1B0105'
				and idtindakan != '1B0101'
				and idtindakan != '1B0104'
				and idtindakan != '1B0135'
				and idtindakan != '1B0106'
				and idtindakan != '1B0107'
				and idtindakan != '1B0134'
				and idtindakan != '1B1010'
				and idtindakan != '1B1011'
				and idtindakan != '1B1012'
				and idtindakan != '1B1013'
				and idtindakan != '1B1014'
				and idtindakan != '1B1015'
			order by xupdate desc");
		}

		

		
		function getdata_tindakan_pasien_faktur($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register' and bayar = '1' order by xupdate desc");
		}

		function getdata_tindakan_pasien_kwitansi($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register' and bayar = '1' order by xupdate desc");
		}

		function getdata_tindakan_pasien_kwitansi_setelah($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register' and bayar = '2' order by xupdate desc");
		}

		function getdata_tindakan_pasien_kwitansi_new($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register'  order by xupdate desc");
		}


		function getdata_tindakan_pasienumum($no_register){
			return $this->db->query("SELECT 
				* 
			FROM 
				pelayanan_poli 
			where 
				no_register='$no_register' 
				and bayar is null 
				and idtindakan NOT IN ('1B0105','1B0101','1B0104','1B0135','1B0106','1B0107','1B0134','1B0108','1B0102','1B1010','1B1011','1B1012','1B1013','1B1014','1B1015')
			order by xupdate desc");
		}

		function getdata_tindakan_pasienumumretur($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register' and bayar = 1 order by xupdate desc");
		}
		
		function getdata_unpaid_finish_tindakan_pasien($no_register){			
			return $this->db->query("SELECT *, 
			(select COUNT(bpjs) from pelayanan_poli where bpjs= '0' and no_register='$no_register') as noncover 
			FROM pelayanan_poli 
			where no_register='$no_register' 
			and bayar=0 and idtindakan NOT LIKE '1B01%'
			order by xupdate desc
			");
			//SELECT * FROM pelayanan_poli where no_register='$no_register' and bayar=0 and idtindakan NOT LIKE '1B01%' order by xupdate desc
		}

		function getdata_unpaid_tindakan_pasien($no_register){			
			return $this->db->query("SELECT * FROM pelayanan_poli 
				where no_register='$no_register' 
				and bayar is null 
				and (idtindakan = '1B0105' or idtindakan = '1B0101' or idtindakan = '1B0104' or idtindakan = '1B0135' or idtindakan = '1B0106' or idtindakan = '1B0107' or idtindakan = '1B0134' or idtindakan = '1B1010' or idtindakan = '1B1011' or idtindakan = '1B1012' or idtindakan = '1B1013' or idtindakan = '1B1014' or idtindakan = '1B1015' or idtindakan = '1B0108' or idtindakan = '1B0102')

				-- and (idtindakan = '1B0105' or idtindakan = '1B0101' or idtindakan = '1B0104' or idtindakan = '1B0135')
				order by xupdate desc");
		}

		function get_detail_daful($no_register){
			return $this->db->query("SELECT *,(SELECT nm_poli from poliklinik where id_poli=daftar_ulang_irj.id_poli limit 1) as nm_poli,
			(SELECT nm_dokter from data_dokter where id_dokter=daftar_ulang_irj.id_dokter limit 1) as nm_dokter, 
			(select nmkontraktor from kontraktor where daftar_ulang_irj.id_kontraktor=kontraktor.id_kontraktor limit 1) as kontraktor, 
			CASE WHEN extract('hour' from xupdate)>=7 and extract('hour' from xupdate)<=14 THEN 'Pagi' ELSE 'Sore' END as shift 
			FROM daftar_ulang_irj where no_register='$no_register' order by xupdate desc");
		}

		function get_no_kwitansi($no_register){
			return $this->db->query("SELECT no_kwitansi FROM no_kwitansi WHERE no_registrasi='$no_register'");
		}

		function get_no_kwitansi_loket($idloket){
			return $this->db->query("SELECT NULLIF(MAX(idno_kwitansi),000000) as no_kwitansi from no_kwitansi");
		}

		function getdata_perusahaan($no_register){
			return $this->db->query("SELECT A.id_kontraktor, B.nmkontraktor FROM daftar_ulang_irj A, kontraktor B  where no_register='$no_register' and A.id_kontraktor=B.id_kontraktor");
		}
		function get_vtot($no_register){
			return $this->db->query("SELECT vtot, vtot_ok, vtot_lab, vtot_rad, vtot_obat, vtot_pa, diskon FROM daftar_ulang_irj WHERE no_register='$no_register'");
		}
		/////////////////////////////////////////////////////////////////////////////////
		function get_new_kwkt($no_register){
			return $this->db->query("select max(right(nokwitansi_kt,6)) as counter, mid(now(),3,2) as year from daftar_ulang_irj where mid(nokwitansi_kt,3,2) = (select mid(now(),3,2)) and no_register not like '$no_register'");
		}
		function update_kwkt($nokwitansi_kt,$no_register){
			$this->db->query("update daftar_ulang_irj set nokwitansi_kt='$nokwitansi_kt', tglcetak_kwitansi=now() where no_register='$no_register'");
			return true;
		}
		function getdata_tgl_kw($no_register){
			return $this->db->query("select date_format(tglcetak_kwitansi, '%d-%m-%Y %h:%m:%s') as tglcetak_kwitansi, date_format(tglcetak_kwitansi, '%d-%m-%Y') as tgl_kwitansi  from daftar_ulang_irj where no_register='$no_register'");
		}
		function update_kw_penunjang($no_register, $data, $table){
			$this->db->where('no_register', $no_register);
			$this->db->update($table, $data);
			return true;
		}
		function get_pasien_pertind_kwitansi($date){ //pendaftaran
			return $this->db->query("SELECT
			to_char(b.tgl_kunjungan,'YYYY-MM-DD') tgl_kunjungan,
			b.cara_bayar,
			b.id_poli,
			d.nm_poli,
			A.no_register,
			C.nama AS nama,
			A.bayar,
			A.xcetak,
			C.no_cm AS no_cm 
		FROM
			pelayanan_poli A,
			daftar_ulang_irj b,
			data_pasien C,
			poliklinik d 
		WHERE
			A.bayar IS NULL 
			and A.xcetak IS NULL 
			and a.idtindakan IN ('1B0105','1B0101','1B0104','1B0135','1B0108','1B0102','1B0106')
			AND to_char( b.tgl_kunjungan, 'YYYY-MM-DD' ) = '$date' 
			AND A.no_register = b.no_register 
			AND b.xcetak IS NULL 
			AND b.no_medrec = C.no_medrec 
			and b.id_poli = d.id_poli
		GROUP BY
			A.bayar,
			A.no_register,
			C.nama,
			d.nm_poli,
			C.no_cm,
			to_char(b.tgl_kunjungan,'YYYY-MM-DD'),
			b.cara_bayar,
			b.id_poli,
			A.bayar,
			A.xcetak");
		}
		/////////////////////////////////////////////////////////////////////////////////////kwitansi tindakan
		function get_new_kwkk($id_pelayanan_poli){
			return $this->db->query("select max(right(nokwitansi_kk,6)) as counter, mid(now(),3,2) as year from pelayanan_poli where mid(nokwitansi_kk,3,2) = (select mid(now(),3,2)) and id_pelayanan_poli not like '$id_pelayanan_poli'");
		}
		function update_kwkk($nokwitansi_kk,$id_pelayanan_poli){
			$this->db->query("update pelayanan_poli set nokwitansi_kk='$nokwitansi_kk', tglcetak_kwitansi=now() where id_pelayanan_poli=$id_pelayanan_poli");
			return true;
		}
		function getdata_tgl_kk($id_pelayanan_poli){
			return $this->db->query("select date_format(tglcetak_kwitansi, '%d-%m-%Y %h:%m:%s') as tglcetak_kwitansi, date_format(tglcetak_kwitansi, '%d-%m-%Y') as tgl_kwitansi from pelayanan_poli where id_pelayanan_poli='$id_pelayanan_poli'");
		}
		function getdata_kwitansikk($id_pelayanan_poli){
			return $this->db->query("select * from daftar_ulang_irj, pelayanan_poli, operator, data_pasien, poliklinik where pelayanan_poli.id_pelayanan_poli=$id_pelayanan_poli and  daftar_ulang_irj.no_medrec=data_pasien.no_medrec and daftar_ulang_irj.no_register=pelayanan_poli.no_register and operator.id_dokter=pelayanan_poli.id_dokter and poliklinik.id_poli=daftar_ulang_irj.id_poli");
		}
		/////////////////////////////////////////////////////////////////////////////////////
		function getdata_rs($koders){
			return $this->db->query("select * from data_rs where koders='$koders'");
		}
		/////////////////////////////////////////////////////////////////////////////////////status kwitansi
		function update_pembayaran($no_register,$data){
			$this->db->where('no_register', $no_register);
			return $this->db->update('daftar_ulang_irj', $data);;
		}

		function update_pembayaran_nokwitansi($idno_kwitansi,$data){
			$this->db->where('idno_kwitansi', $idno_kwitansi);
			return $this->db->update('nomor_kwitansi', $data);
		}

		function update_daftar_ulang_irj($no_register,$data_irj){
			$this->db->where('no_register', $no_register);
			return $this->db->update('daftar_ulang_irj', $data_irj);
		}

		function update_pembayaran_idkwitansi($idno_kwitansi,$data){
			$this->db->where('idno_kwitansi', $idno_kwitansi);
			return $this->db->update('nomor_kwitansi', $data);
		}

		function getdata_nomor_kwitansi($nomor_kwitansi,$idloket){
			return $this->db->query("select * from nomor_kwitansi where no_kwitansi=$nomor_kwitansi and id_loket='$idloket'");
		}

		function getdata_detail_kwitansi($noreg){
			return $this->db->query("select * from nomor_kwitansi where no_register='$noreg'");
		}

		function update_pembayaran_detail($no_register,$data){
			$this->db->where('no_register', $no_register);					
			/*$query="update daftar_ulang_irj  
set tunai=(IFNULL((SELECT a.tunai from (select * from daftar_ulang_irj) as a 
where a.no_register='$no_register'),0)+".$data['tunai']."),  diskon=(IFNULL((SELECT a.diskon from (select * from daftar_ulang_irj) as a 
where a.no_register='$no_register'),0)+".$data['diskon']."), no_kkkd=".$data['no_kkkd'].", nilai_kkkd=(IFNULL((SELECT a.nilai_kkkd from (select * from daftar_ulang_irj) as a where a.no_register='$no_register'),0)+".$data['nilai_kkkd'].") where no_register='$no_register'";
			echo $query;
			$this->db->query();*/
			return $this->db->update('daftar_ulang_irj', $data);
		}

		function update_counter_kwitansi($no_register){
			return $this->db->query("UPDATE daftar_ulang_irj
										SET counter_kwitansi=counter_kwitansi+1
										WHERE no_register='$no_register'");
		}

		function update_pelayanan($no_register,$data){
			$this->db->where('no_register', $no_register);
			return $this->db->update('id_pelayanan_poli', $data);
		}

		function update_status_kwitansi_kt($no_register,$data){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}
		//update_status_kwitansi_detail_kt
		function update_status_kwitansi_detail_kt($id,$data){
			$this->db->where('id_pelayanan_poli', $id);
			$this->db->update('pelayanan_poli', $data);
			return true;
		}		

		function update_bayar_pelayanan_poli($no_register){
			// $where = "no_register='$no_register' AND idtindakan NOT IN ('1B0105','1B0101','1B0104','1B0135','1B0106','1B0107','1B0134','1B1010','1B1011','1B1012','1B1013','1B1014','1B1015')";
			// $this->db->where($where);
			// // $this->db->where('no_register', $no_register);
			// // $this->db->where('bayar',NULL,TRUE);
			// $this->db->update('pelayanan_poli', $data1);
			// return true;
			$today = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pelayanan_poli SET bayar = '2', bayar_umum = '2', tgl_cetak = '$today' WHERE no_register = '$no_register' AND idtindakan NOT IN ('1B0102''1B0105','1B0101','1B0104','1B0135','1B0106','1B0107','1B0134','1B1010','1B1011','1B1012','1B1013','1B1014','1B1015')");
			return true;
		}

		function update_bayar_mrpoli($no_register){
			// $where = "no_register='$no_register' AND (idtindakan = '1B0105' or idtindakan = '1B0101' or idtindakan = '1B0104' or idtindakan = '1B0135' or idtindakan = '1B0106' or idtindakan = '1B0107' or idtindakan = '1B0134')";
			// $this->db->where($where);
			// $this->db->where('no_register', $no_register);
			// $this->db->where('idtindakan', '1B0105');
			// $this->db->where('idtindakan', '1B0101');
			// $this->db->where('idtindakan', '1B0104');
			// $this->db->where('idtindakan', '1B0135');
		//	$this->db->where('bayar <> 1');
			// $this->db->where('no_register', $no_register);
			// $this->db->where('bayar',NULL,TRUE);
			// $where = "no_register='$no_register' AND (idtindakan = '1B0105' or idtindakan = '1B0101' or idtindakan = '1B0104' or idtindakan = '1B0135' or idtindakan = '1B0106' or idtindakan = '1B0107' or idtindakan = '1B0134' or idtindakan = '1B1010' or idtindakan = '1B1011' or idtindakan = '1B1012' or idtindakan = '1B1013' or idtindakan = '1B1014' or idtindakan = '1B1015')";
			// $this->db->where($where);
			// $this->db->update('pelayanan_poli', $data1);
			// return true;
			$today = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pelayanan_poli SET bayar = '1', bayar_umum = '1', tgl_cetak = '$today' WHERE no_register = '$no_register' AND idtindakan IN ('1B0105','1B0101','1B0104','1B0135','1B0106','1B0107','1B0134','1B1010','1B1011','1B1012','1B1013','1B1014','1B1015','1B0108','1B0102')");
			return true;
		}

		function update_diskon_poli($data2, $no_register, $idtindakan){
			$this->db->where('no_register', $no_register);
			$this->db->where('bayar',NULL,TRUE);
			$this->db->where('idtindakan', $idtindakan);
			$this->db->update('pelayanan_poli', $data2);
			return true;
		}

		function update_diskon($diskon,$no_register){
			$this->db->query("update daftar_ulang_irj set diskon='$diskon' where no_register='$no_register'");
			return true;
		}
		function update_status_kwitansi_kk($id_pelayanan_poli){
			$this->db->query("update pelayanan_poli set cetak_kwitansi='1' where id_pelayanan_poli='$id_pelayanan_poli'");
			return true;
		}

		//nomor kwitansi loket
		function insert_nomorkwitansi($data){
			return $this->db->insert('nomor_kwitansi', $data);
		}
		function insert_nokwitansi($data){
			$tahun = date('Y');
			$depan = substr($tahun,2,2);
			$this->db->set('no_kwitansi',"(select 'RJ".$depan."-' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_kwitansi),6) FROM no_kwitansi where jenis_kwitansi = 'Rawat Jalan' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
			
			return $this->db->insert('no_kwitansi', $data);
		}

		function insert_nokwitansi_ri($data){
			$tahun = date('Y');
			$depan = substr($tahun,2,2);
			$this->db->set('no_kwitansi',"(select 'RI".$depan."-' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_kwitansi),6) FROM no_kwitansi where jenis_kwitansi = 'Rawat Inap' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
			return $this->db->insert('no_kwitansi', $data);
		}

		//unpaid
		function getdata_unpaid_lab_pasien($no_register){
			return $this->db->query("SELECT A.no_lab, A.no_register, B.id_tindakan, 
					B.biaya_lab, B.jenis_tindakan, B.qty, B.vtot 
					FROM lab_header A, pemeriksaan_laboratorium B
					where A.no_register='$no_register' 
					and A.no_lab=B.no_lab");
		}
		function getdata_unpaid_rad_pasien($no_register){
			return $this->db->query("SELECT A.no_rad, A.no_register, B.id_tindakan, 
			B.biaya_rad, B.jenis_tindakan, B.qty, B.vtot 
			FROM rad_header A, pemeriksaan_radiologi B
			where A.no_register='$no_register'
			and A.no_rad=B.no_rad");
		}
		function getdata_unpaid_resep_pasien($no_register){
			return $this->db->query("SELECT A.no_resep, A.no_resgister, B.item_obat, 
			.biaya_obat, B.nama_obat, B.qty, B.vtot 
			FROM resep_header A, resep_pasien B
			where A.no_resgister='$no_register'
			and A.no_resep=B.no_resep");
		}
		// Pasien SJP JAMSOSKES
		
		function get_pasien_sjp(){
			return $this->db->query("SELECT a.tgl_kunjungan, a.no_register, b.no_cm, b.nama, a.cara_bayar, d.nmkontraktor, d.id_kontraktor, c.nm_poli, c.id_poli 
				FROM daftar_ulang_irj as a
				LEFT JOIN data_pasien as b ON a.no_medrec=b.no_medrec
				LEFT JOIN poliklinik as c ON a.id_poli=c.id_poli 
				LEFT JOIN kontraktor as d ON a.id_kontraktor=d.id_kontraktor 
				where (cara_bayar='DIJAMIN' or cara_bayar='BPJS') and a.status='0' 
				order by a.xupdate desc");
		}
		
		function getdata_pasien_sjp($no_register){
			return $this->db->query("SELECT a.*, b.no_cm, 
				b.nama, b.alamat, b.tgl_lahir, b.sex, 
				c.nm_poli,
				d.nmkontraktor,
				e.nm_ppk
				FROM daftar_ulang_irj as a 
				LEFT JOIN data_pasien as b ON a.no_medrec=b.no_medrec 
				LEFT JOIN poliklinik as c ON a.id_poli=c.id_poli 
				LEFT JOIN kontraktor as d ON a.id_kontraktor=d.id_kontraktor 
				LEFT JOIN data_ppk as e ON a.asal_rujukan=e.kd_ppk 
				WHERE no_register='$no_register'");
		}

		//lunas
		function get_pasien_kwitansi_lunas($date0,$date1){
			return $this->db->query("SELECT
				d.*, a.id_poli, b.no_cm, b.nama, a.tgl_kunjungan, a.cara_bayar, c.nm_poli
			FROM nomor_kwitansi d
			JOIN daftar_ulang_irj a ON a.no_register=d.no_register
			JOIN data_pasien b ON a.no_medrec=b.no_medrec
			LEFT JOIN poliklinik c ON a.id_poli=c.id_poli
			WHERE
				a.cara_bayar = 'UMUM' 
				AND TO_CHAR ( d.xcreate, 'YYYY-MM-DD' ) >= '$date0'
				AND TO_CHAR ( d.xcreate, 'YYYY-MM-DD' ) <= '$date1'
				");
		}

		public function getdata_no_kwitansi_by_no_register($no_register)
		{
			// return $this->db->query("SELECT *
			// 	FROM no_kwitansi
			// 	where no_register='$no_register'");

			return $this->db->query("SELECT *
			FROM no_kwitansi
			where no_register='$no_register' and Jenis_kwitansi = 'Rawat Jalan' order by idno_kwitansi desc");
		}

		public function get_no_kwitansi_by_id($idno_kwitansi)
		{
			return $this->db->query("SELECT no_kwitansi
			FROM no_kwitansi
			where idno_kwitansi='$idno_kwitansi'");
		}
		
		function insert_registrasi($data){
			return $this->db->insert('registrasi', $data);
		}
		
		function update_cetak_kwitansi($du, $no_register) {
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $du);
			return true;
		}

		function get_pasien_kwitansi_all($date,$no){
			if($no == null){
				return $this->db->query("SELECT * FROM daftar_kwitansi_all where 
				to_char(tgl,'YYYY-MM-DD') = '$date'");
			}else{
				return $this->db->query("SELECT * FROM daftar_kwitansi_all where 
			  to_char(tgl,'YYYY-MM-DD') = '$date' and no_medrec = '$no'");
			}
			
		}

		function insert_header_piutang($data){
			return $this->db->insert('header_piutang', $data);
		}

		function update_bayar_pelayanan_poli_piutang($no_register){
			$today = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pelayanan_poli SET piutang = '1' WHERE no_register = '$no_register' AND idtindakan NOT IN ('1B0105','1B0101','1B0104','1B0135','1B0106','1B0107','1B0134','1B1010','1B1011','1B1012','1B1013','1B1014','1B1015')");
			return true;
		}

		function getdata_tindakan_pasien_kwitansi_piutang($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register' and piutang = '1' order by xupdate desc");
		}

		function update_bayar_pelayanan_poli_piutang_lunas($no_register){
			$today = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pelayanan_poli SET bayar = '2', piutang = '2', tgl_cetak_kw = '$today' WHERE no_register = '$no_register' AND idtindakan NOT IN ('1B0105','1B0101','1B0104','1B0135','1B0106','1B0107','1B0134','1B1010','1B1011','1B1012','1B1013','1B1014','1B1015')");
			return true;
		}

		function update_piutang_mrpoli($no_register){
			$this->db->query("UPDATE pelayanan_poli SET piutang = '1',bayar = '5' WHERE no_register = '$no_register' AND idtindakan IN ('1B0105','1B0101','1B0104','1B0135','1B0106','1B0107','1B0134','1B1010','1B1011','1B1012','1B1013','1B1014','1B1015','1B0108','1B0102')");
			return true;
		}


		function update_piutang_lunas_mrpoli($no_register){
			$today = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pelayanan_poli SET bayar = '1', piutang = '2', tgl_cetak_kw = '$today' WHERE no_register = '$no_register' AND idtindakan IN ('1B0105','1B0101','1B0104','1B0135','1B0106','1B0107','1B0134','1B1010','1B1011','1B1012','1B1013','1B1014','1B1015','1B0108','1B0102')");
			return true;
		}

		function insert_nokwitansi_iks($data){
			$tahun = date('Y');
			$depan = substr($tahun,2,2);
			$this->db->set('no_kwitansi',"(select 'IKS".$depan."-' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_kwitansi),6) FROM no_kwitansi where jenis_kwitansi = 'Rawat Jalan' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
			
			return $this->db->insert('no_kwitansi', $data);
		}

		function get_no_kwitansi_setelah($no_register) {
			return $this->db->query("SELECT no_kwitansi, jenis_bayar FROM no_kwitansi WHERE no_register = '$no_register' AND referensi = '2' ORDER BY tgl_cetak DESC LIMIT 1");
		}

		function get_nm_dokter_kwitansi($no_register) {
			return $this->db->query("SELECT
				a.id_dokter,
				c.nm_dokter
			FROM 
				daftar_ulang_irj AS a,
				data_dokter AS c
			WHERE
				a.id_dokter = c.id_dokter
				AND a.no_register = '$no_register'
			LIMIT 1");
		}

		function getdata_tindakan_pasien_kwitansi_sblm_poli($no_register) {
			return $this->db->query("SELECT 
				* 
			FROM 
				pelayanan_poli 
			WHERE 
				no_register = '$no_register' 
				AND bayar_umum = '1'");
		}

		function getdata_tindakan_pasien_kwitansi_stlh_poli($no_register) {
			return $this->db->query("SELECT 
				* 
			FROM 
				pelayanan_poli 
			WHERE 
				no_register = '$no_register' 
				AND bayar_umum = '2'");
		}

		function get_no_kwitansi_sblm($no_register) {
			return $this->db->query("SELECT
				jenis_bayar,
				no_kwitansi
			FROM
				no_kwitansi
			WHERE 
				no_register = '$no_register'
				AND referensi = 1
				AND user_cetak != 'APM'
				AND status IS NULL");
		}

		function get_no_kwitansi_stlh($no_register) {
			return $this->db->query("SELECT
				jenis_bayar,
				no_kwitansi
			FROM
				no_kwitansi
			WHERE 
				no_register = '$no_register'
				AND referensi = 2
				AND user_cetak != 'APM'
				AND status IS NULL");
		}

		function get_poli_by_regist($no_register) {
			return $this->db->query("SELECT id_poli FROM daftar_ulang_irj WHERE no_register = '$no_register'");
		}

		function getdata_tindakan_pasien_new($no_register){
			return $this->db->query("SELECT 
				* 
			FROM 
				pelayanan_poli 
			where 
				no_register='$no_register' 
			order by xupdate desc");
		}

		function getdata_lab_pasien($no_register){
			return $this->db->query("SELECT A.no_lab, A.no_register, B.id_tindakan, 
				B.biaya_lab, B.jenis_tindakan, B.qty, B.vtot 
				FROM lab_header A, pemeriksaan_laboratorium B
				where A.no_register='$no_register' 
				and CAST(A.no_lab as INT)=B.no_lab");
		}

		function getdata_rad_pasien($no_register){
			return $this->db->query("SELECT A.no_rad, A.no_register, B.id_tindakan, 
			B.biaya_rad, B.jenis_tindakan, B.qty, B.vtot 
			FROM rad_header A, pemeriksaan_radiologi B
			where A.no_register='$no_register'  
			and A.no_rad=B.no_rad");
		}

		function update_bayar_pelayanan_poli_new($no_register){
			$today = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pelayanan_poli SET bayar = '1', bayar_umum = '1', tgl_cetak_kw = '$today' WHERE no_register = '$no_register'");
			return true;
		}

		function update_status_cetak_kwitansi_lab($no_register, $xuser){
			$today = date('Y-m-d H:i:s');
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_laboratorium SET cetak_kwitansi='1', bayar_umum = '1', tgl_cetak_kw = '$today' WHERE no_register='$no_register'");
			// $this->db->query("UPDATE lab_header SET diskon='$diskon' WHERE no_lab='$no_lab'");
			return true;
		}

		function update_status_cetak_kwitansi_rad( $no_register, $xuser){
			$today = date('Y-m-d H:i:s');
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_radiologi SET cetak_kwitansi='1', bayar_umum = '1', tgl_cetak_kw = '$today' WHERE no_register='$no_register'");
			// $this->db->query("UPDATE rad_header SET diskon='$diskon' WHERE no_rad='$no_rad'");
			return true;
		}


		function getdata_tindakan_pasien_new_kw($no_register){
			return $this->db->query("SELECT 
				* 
			FROM 
				pelayanan_poli 
			where 
				no_register='$no_register' 
			order by xupdate desc");
		}

		function getdata_lab_pasien_kw($no_register){
			return $this->db->query("SELECT A.no_lab, A.no_register, B.id_tindakan, 
				B.biaya_lab, B.jenis_tindakan, B.qty, B.vtot 
				FROM lab_header A, pemeriksaan_laboratorium B
				where A.no_register='$no_register'
				and CAST(A.no_lab as INT)=B.no_lab");
		}

		function getdata_rad_pasien_kw($no_register){
			return $this->db->query("SELECT A.no_rad, A.no_register, B.id_tindakan, 
			B.biaya_rad, B.jenis_tindakan, B.qty, B.vtot 
			FROM rad_header A, pemeriksaan_radiologi B
			where A.no_register='$no_register'
			and A.no_rad=B.no_rad");
		}

		function getdata_resep_pasien_kw($no_register){
			return $this->db->query("SELECT A.no_resep, A.no_resgister, B.item_obat, 
				B.biaya_obat, B.nama_obat, B.qty, B.vtot 
				FROM resep_header A, resep_pasien B
				where A.no_resgister='$no_register'
				and A.no_resep=B.no_resep");
		}

		function get_pasien_kwitansi_bpjs_rj($date1,$date2){
			return $this->db->query("
			SELECT
					* 
				FROM
					daftar_ulang_irj
					JOIN data_pasien ON daftar_ulang_irj.no_medrec = data_pasien.no_medrec
					JOIN poliklinik ON poliklinik.id_poli = daftar_ulang_irj.id_poli 
				WHERE
					daftar_ulang_irj.cara_bayar = 'BPJS' 
					AND TO_CHAR( daftar_ulang_irj.tgl_kunjungan, 'YYYY-MM-DD' ) BETWEEN '$date1' 
					AND '$date2' 
				ORDER BY
					daftar_ulang_irj.cara_bayar DESC;
			");
		}

		function get_ttd_dir(){
			return $this->db->query("
				SELECT name,ttd FROM hmis_users where userid = '398'
			");
		}

		function get_ttd_wen(){
			return $this->db->query("
			SELECT name,ttd FROM hmis_users where userid = '380'
			");
		}
	}
?>
