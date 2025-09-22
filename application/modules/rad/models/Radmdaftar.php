<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Radmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul for radcdaftar
		function get_daftar_pasien_rad($date){
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register ,
				data_pasien.no_cm as no_medrec ,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad
			FROM
				pemeriksaan_rad,
				data_pasien
			WHERE
				pemeriksaan_rad.medrec = data_pasien.no_medrec
				and pemeriksaan_rad.rad = '1'
				and to_char(pemeriksaan_rad.tgl_kunjungan,'YYYY-MM-DD') = '$date'
			ORDER BY 
				pemeriksaan_rad.jadwal_rad DESC");
		}

		function get_daftar_pasien_rad_by_date($date){
			return $this->db->query("SELECT 
				pemeriksaan_rad.no_register, 
				data_pasien.no_cm as no_medrec, 
				pemeriksaan_rad.tgl_kunjungan, 
				pemeriksaan_rad.kelas, 
				pemeriksaan_rad.idrg, 
				pemeriksaan_rad.bed, 
				data_pasien.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.jadwal_rad,
				pemeriksaan_rad.rad
			FROM 
				pemeriksaan_rad, 
				data_pasien 
			WHERE 
				pemeriksaan_rad.medrec=data_pasien.no_medrec 
				and pemeriksaan_rad.rad = '1'
				AND to_char(pemeriksaan_rad.jadwal_rad,'YYYY-MM-DD')='$date'");
		}

		function get_daftar_pasien_rad_by_no($key){
			return $this->db->query("SELECT 
				pemeriksaan_rad.no_register, 
				data_pasien.no_cm as no_medrec, 
				pemeriksaan_rad.tgl_kunjungan, 
				pemeriksaan_rad.kelas, 
				pemeriksaan_rad.idrg, 
				pemeriksaan_rad.bed, 
				data_pasien.nama as nama, 
				pemeriksaan_rad.jadwal_rad, 
				pemeriksaan_rad.waktu_masuk_rad  
			FROM 
				pemeriksaan_rad, 
				data_pasien 
			WHERE 
				pemeriksaan_rad.medrec=data_pasien.no_medrec 
				and pemeriksaan_rad.rad = '1'
				AND (pemeriksaan_rad.nama LIKE '%$key%' OR pemeriksaan_rad.no_medrec LIKE '%$key%')");
		}
		
		function get_daftar_pasien_rad_new() {
			//per pemeriksaan tindakan
			$date = date("Y-m-d");
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register,
				pemeriksaan_rad.medrec,
				pemeriksaan_rad.no_medrec,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.rad,
				pemeriksaan_rad.billing_rad,
				a.accesion_number,
				a.jenis_tindakan,
				a.id_tindakan,
				a.id_pemeriksaan_rad,
				a.no_rad,
				a.jadwal,
				a.modality,
				a.selesai
			FROM
				pemeriksaan_rad, pemeriksaan_radiologi AS a
			WHERE
				pemeriksaan_rad.no_register = a.no_register
				AND pemeriksaan_rad.rad IS NOT NULL
				-- AND pemeriksaan_rad.cetak_rad = 0
				AND to_char(pemeriksaan_rad.billing_rad, 'YYYY-MM-DD') = '$date'
				AND a.accesion_number IS NOT NULL
			ORDER BY 
				a.selesai DESC,
				a.jadwal DESC");
		}

		function get_daftar_pasien_rad_by_no_new($key) {
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register,
				pemeriksaan_rad.medrec,
				pemeriksaan_rad.no_medrec,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.rad,
				pemeriksaan_rad.billing_rad,
				a.accesion_number,
				a.jenis_tindakan,
				a.id_tindakan,
				a.id_pemeriksaan_rad,
				a.no_rad,
				a.jadwal,
				a.modality,
				a.selesai
			FROM
				pemeriksaan_rad, pemeriksaan_radiologi AS a
			WHERE
				pemeriksaan_rad.no_register = a.no_register
				AND pemeriksaan_rad.rad IS NOT NULL
				and pemeriksaan_rad.cetak_rad = 0
				AND (pemeriksaan_rad.nama LIKE '%$key%' OR pemeriksaan_rad.no_medrec LIKE '%$key%')
			ORDER BY 
				a.selesai DESC,
				a.jadwal DESC");
		}

		function get_daftar_pasien_rad_by_date_new($date) {
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register,
				pemeriksaan_rad.medrec,
				pemeriksaan_rad.no_medrec,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.rad,
				pemeriksaan_rad.billing_rad,
				a.accesion_number,
				a.jenis_tindakan,
				a.id_tindakan,
				a.id_pemeriksaan_rad,
				a.no_rad,
				a.jadwal,
				a.modality,
				a.selesai
			FROM
				pemeriksaan_rad, pemeriksaan_radiologi AS a
			WHERE
				pemeriksaan_rad.no_register = a.no_register
				AND pemeriksaan_rad.rad IS NOT NULL
				and pemeriksaan_rad.cetak_rad = 0
				and to_char(pemeriksaan_rad.billing_rad, 'YYYY-MM-DD') = '$date'
			ORDER BY 
				a.selesai DESC,
				a.jadwal DESC");
		}

		function get_daftar_pasien_rad_by_modality($modality) {
			if($modality == 'CR/DX') {
				return $this->db->query("SELECT
					pemeriksaan_rad.no_register,
					pemeriksaan_rad.medrec,
					pemeriksaan_rad.no_medrec,
					pemeriksaan_rad.tgl_kunjungan,
					pemeriksaan_rad.jadwal_rad AS jadwal_rad,
					pemeriksaan_rad.kelas,
					pemeriksaan_rad.idrg,
					pemeriksaan_rad.bed,
					pemeriksaan_rad.nama AS nama,
					pemeriksaan_rad.waktu_masuk_rad,
					pemeriksaan_rad.rad,
					pemeriksaan_rad.billing_rad,
					a.accesion_number,
					a.jenis_tindakan,
					a.id_tindakan,
					a.id_pemeriksaan_rad,
					a.no_rad,
					a.jadwal,
					a.modality,
					a.selesai
				FROM
					pemeriksaan_rad,
					pemeriksaan_radiologi AS a
				WHERE
					pemeriksaan_rad.rad IS NOT NULL 
					AND pemeriksaan_rad.cetak_rad = 0 
					AND a.modality IN ('DX','CR')
					AND pemeriksaan_rad.no_register = a.no_register
				ORDER BY
					a.selesai DESC,
					a.jadwal DESC");
			} else {
				return $this->db->query("SELECT
					pemeriksaan_rad.no_register,
					pemeriksaan_rad.medrec,
					pemeriksaan_rad.no_medrec,
					pemeriksaan_rad.tgl_kunjungan,
					pemeriksaan_rad.jadwal_rad AS jadwal_rad,
					pemeriksaan_rad.kelas,
					pemeriksaan_rad.idrg,
					pemeriksaan_rad.bed,
					pemeriksaan_rad.nama AS nama,
					pemeriksaan_rad.waktu_masuk_rad,
					pemeriksaan_rad.rad,
					pemeriksaan_rad.billing_rad,
					a.accesion_number,
					a.jenis_tindakan,
					a.id_tindakan,
					a.id_pemeriksaan_rad,
					a.no_rad,
					a.jadwal,
					a.modality,
					a.selesai
				FROM
					pemeriksaan_rad,
					pemeriksaan_radiologi AS a
				WHERE
					pemeriksaan_rad.rad IS NOT NULL 
					AND pemeriksaan_rad.cetak_rad = 0 
					AND a.modality = '$modality'
					AND pemeriksaan_rad.no_register = a.no_register
				ORDER BY 
					a.selesai DESC,
					a.jadwal DESC");
			}
		}

		function get_data_list_order() {
			$date = date("Y-m-d");
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register ,
				data_pasien.no_cm as no_medrec ,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.cetak_rad
			FROM
				pemeriksaan_rad,
				data_pasien
			WHERE
				pemeriksaan_rad.medrec = data_pasien.no_medrec
				and pemeriksaan_rad.rad IS NOT NULL
				and pemeriksaan_rad.cetak_rad IS NOT NULL
				and to_char(pemeriksaan_rad.jadwal_rad, 'YYYY-MM-DD') = '$date'
			ORDER BY 
				pemeriksaan_rad.cetak_rad DESC,
				pemeriksaan_rad.jadwal_rad DESC");
		}

		function get_data_list_order_pl() {
			$date = date("Y-m-d");
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register ,
				data_pasien.no_cm as no_medrec ,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.cetak_rad
			FROM
				pemeriksaan_rad,
				data_pasien
			WHERE
				pemeriksaan_rad.medrec = data_pasien.no_medrec
				and pemeriksaan_rad.rad IS NOT NULL
				and pemeriksaan_rad.cetak_rad IS NOT NULL
				and substr(pemeriksaan_rad.no_register,1,2) = 'PL'
				and to_char(pemeriksaan_rad.jadwal_rad, 'YYYY-MM-DD') = '$date'
			ORDER BY 
				pemeriksaan_rad.cetak_rad DESC,
				pemeriksaan_rad.jadwal_rad DESC");
		}

		function get_list_order_rad_by_no($key) {
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register ,
				data_pasien.no_cm as no_medrec ,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.cetak_rad
			FROM
				pemeriksaan_rad,
				data_pasien
			WHERE
				pemeriksaan_rad.medrec = data_pasien.no_medrec
				and pemeriksaan_rad.rad IS NOT NULL
				and pemeriksaan_rad.cetak_rad IS NOT NULL
				-- and substr(pemeriksaan_rad.no_register,1,2) != 'PL'
				and (data_pasien.nama LIKE '%$key%' OR pemeriksaan_rad.no_medrec LIKE '%$key%')
			ORDER BY 
				pemeriksaan_rad.cetak_rad DESC,
				pemeriksaan_rad.jadwal_rad DESC");
		}

		function get_list_order_rad_by_no_pl($key) {
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register ,
				data_pasien.no_cm as no_medrec ,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.cetak_rad
			FROM
				pemeriksaan_rad,
				data_pasien
			WHERE
				pemeriksaan_rad.medrec = data_pasien.no_medrec
				and pemeriksaan_rad.rad IS NOT NULL
				and pemeriksaan_rad.cetak_rad IS NOT NULL
				and substr(pemeriksaan_rad.no_register,1,2) = 'PL'
				and (data_pasien.nama LIKE '%$key%' OR pemeriksaan_rad.no_medrec LIKE '%$key%')
			ORDER BY 
				pemeriksaan_rad.cetak_rad DESC,
				pemeriksaan_rad.jadwal_rad DESC");
		}

		function get_list_order_rad_by_date($date) {
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register ,
				data_pasien.no_cm as no_medrec ,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.cetak_rad
			FROM
				pemeriksaan_rad,
				data_pasien
			WHERE
				pemeriksaan_rad.medrec = data_pasien.no_medrec
				and pemeriksaan_rad.rad IS NOT NULL
				and pemeriksaan_rad.cetak_rad IS NOT NULL
				and to_char(pemeriksaan_rad.jadwal_rad, 'YYYY-MM-DD') = '$date'
			ORDER BY 
				pemeriksaan_rad.cetak_rad DESC,
				pemeriksaan_rad.jadwal_rad DESC");
		}

		function get_list_order_rad_by_date_pl($date) {
			return $this->db->query("SELECT
				pemeriksaan_rad.no_register ,
				data_pasien.no_cm as no_medrec ,
				pemeriksaan_rad.tgl_kunjungan ,
				pemeriksaan_rad.jadwal_rad as jadwal_rad ,
				pemeriksaan_rad.kelas ,
				pemeriksaan_rad.idrg ,
				pemeriksaan_rad.bed ,					
				pemeriksaan_rad.nama as nama,
				pemeriksaan_rad.waktu_masuk_rad,
				pemeriksaan_rad.cetak_rad
			FROM
				pemeriksaan_rad,
				data_pasien
			WHERE
				pemeriksaan_rad.medrec = data_pasien.no_medrec
				and pemeriksaan_rad.rad IS NOT NULL
				and pemeriksaan_rad.cetak_rad IS NOT NULL
				and substr(pemeriksaan_rad.no_register,1,2) = 'PL'
				and to_char(pemeriksaan_rad.jadwal_rad, 'YYYY-MM-DD') = '$date'
			ORDER BY 
				pemeriksaan_rad.cetak_rad DESC,
				pemeriksaan_rad.jadwal_rad DESC");
		}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_rad, data_pasien WHERE pemeriksaan_rad.medrec=data_pasien.no_medrec AND pemeriksaan_rad.no_register='$no_register'");
		}

		function getdata_hasil_pemeriksaan_radiologi_all($no_medrec){
			return $this->db->query("SELECT a.*, b.* FROM pemeriksaan_radiologi as a LEFT JOIN hasil_pemeriksaan_rad as b 
			on a.id_pemeriksaan_rad = b.id_pemeriksaan_rad WHERE no_medrec = '$no_medrec' and no_rad is not null and b.id_pemeriksaan_rad is not null order by tgl_kunjungan desc");
		}

		function get_data_pasien_iri_pemeriksaan($no_register){
			return $this->db->query("SELECT
				pasien_iri.*, data_pasien.nama, data_pasien.no_cm, data_pasien.foto
			FROM
				pasien_iri,
				data_pasien 
			WHERE
				pasien_iri.no_medrec = data_pasien.no_medrec 
				AND pasien_iri.no_ipd = '$no_register'");
		}

		function get_data_pasien_luar($no_register) {
			return $this->db->query("SELECT * FROM pasien_luar WHERE no_register = '$no_register'");
		}

		function get_data_pasien_luar_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM  pasien_luar WHERE  pasien_luar.no_register='$no_register'");
		}

		function get_kontraktor_kerjasama() {
			return $this->db->query("SELECT * FROM kontraktor WHERE bpjs = 'KERJASAMA'");
		}

		function get_kontraktor_bpjs() {
			return $this->db->query("SELECT * FROM kontraktor WHERE bpjs = 'BPJS'");
		}

		function get_jenis_rad(){
			return $this->db->query("SELECT * FROM jenis_rad");
		}

		function get_roleid($userid){
			return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
		}

		function get_data_pemeriksaan_by_reg($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register='$no_register' and no_rad is null ");
		}

		function get_data_pemeriksaan_by_reg_new($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register='$no_register' and no_rad is not null ");
		}

		function get_data_pemeriksaan_new($no_register) {
			return $this->db->query("SELECT A
				.*,
				b.rad 
			FROM
				pemeriksaan_radiologi AS A 
				INNER JOIN daftar_ulang_irj AS b ON a.no_register = b.no_register
			WHERE
				A.no_register = '$no_register' UNION
			SELECT A
				.*,
				b.rad 
			FROM
				pemeriksaan_radiologi AS A 
				INNER JOIN pasien_iri AS b ON a.no_register = b.no_ipd
			WHERE
				A.no_register = '$no_register' UNION
			SELECT A
				.*,
				b.rad 
			FROM
				pemeriksaan_radiologi AS A 
				INNER JOIN pasien_luar AS b ON a.no_register = b.no_register
			WHERE
				A.no_register = '$no_register'");
		}

		function get_data_pemeriksaan($no_medrec){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_medrec='$no_medrec'");
		}

		function get_data_diagnosa_rj($no_register){
			return $this->db->query("SELECT b.id_icd as id_diagnosa, concat(b.id_icd, ' - ', b.nm_diagnosa) as diagnosa FROM daftar_ulang_irj as a left join icd1 as b on a.diagnosa=b.id_icd WHERE no_register='$no_register'");
		}

		function get_data_diagnosa_ri($no_ipd){
			return $this->db->query("SELECT b.id_icd as id_diagnosa , concat(b.id_icd , ' - ' , b.nm_diagnosa) as diagnosa FROM pasien_iri as a left join icd1 as b on a.diagmasuk = b.id_icd WHERE no_ipd='$no_ipd'");
		}

		function getdata_tindakan_pasien2($no_register){
			return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_rad where pemeriksaan_rad.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_rad.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
		}

		function getdata_tindakan_pasien(){
			return $this->db->query("SELECT * FROM jenis_tindakan_rad order by nmtindakan");
		}

		function getdata_tindakan_pasien_new(){
			return $this->db->query("SELECT * FROM jenis_tindakan_new where idtindakan LIKE 'LA%'order by nmtindakan asc");
		}

		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif, tarif_iks, tarif_bpjs FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}

		function get_biaya_tindakan_new($id){
			return $this->db->query("SELECT tarif FROM jenis_tindakan_new WHERE idtindakan='".$id."'");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT a.id_dokter, a.nm_dokter,a.deleted FROM data_dokter
			as a LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter WHERE a.ket = 'Radiologi' and a.deleted != '1' or b.id_poli='BZ02' ");
		}

		function get_row_register_by_norad($no_rad){
			return $this->db->query("SELECT no_register FROM pemeriksaan_radiologi WHERE no_rad='$no_rad' LIMIT 1");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='$id_dokter'");
		}

		function getjenis_tindakan($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		}

		function getjenis_tindakan_new($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan_new WHERE idtindakan='".$id_tindakan."' ");
		}

		function insert_pemeriksaan($data){
			return $this->db->insert('pemeriksaan_radiologi', $data);
		}

		function insert_pemeriksaan_radiografer($data){
			return $this->db->insert('pemeriksaan_radiologi', $data);
		}

		function selesai_pemeriksaan($id, $data) {
			$this->db->where('id_pemeriksaan_rad', $id);
			$this->db->update('pemeriksaan_radiologi', $data);
			return true;
		}

		function update_accession_number($no_register,$id_pemeriksaan_rad,$accesion_number)
		{
			if($id_pemeriksaan_rad!=""){
				$this->db->query("UPDATE pemeriksaan_radiologi SET accesion_number='$accesion_number'
				WHERE id_pemeriksaan_rad=$id_pemeriksaan_rad AND no_register='$no_register'");
			}else{
				$this->db->query("UPDATE pemeriksaan_radiologi SET accesion_number='$accesion_number'
				WHERE no_register='$no_register'");
			}
			return true;
		}

		function selesai_daftar_pemeriksaan_PL_header($no_register,$getvtotrad,$no_rad,$accesion_number,$id_pemeriksaan_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad',accesion_number='$accesion_number' WHERE id_pemeriksaan_rad=$id_pemeriksaan_rad AND no_register='$no_register'"); //masukin accession number
			return true;
		}

		function selesai_daftar_pemeriksaan_PL($no_register){
			$this->db->query("UPDATE pasien_luar SET rad=0 WHERE no_register='$no_register'");
			return true;
		}

		function selesai_faktur_pemeriksaan_PL($no_register,$getvtotrad,$no_rad,$accesion_number,$id_pemeriksaan_rad){
			$date = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad',accesion_number='$accesion_number', tgl_generate = '$date' WHERE id_pemeriksaan_rad=$id_pemeriksaan_rad AND no_register='$no_register'");

			$this->db->query("UPDATE pasien_luar SET rad=0, cetak_rad=0, vtot_rad='$getvtotrad', billing_rad='$date' WHERE no_register='$no_register'");

			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ_header($no_register,$getvtotrad,$no_rad,$accesion_number,$id_pemeriksaan_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad',accesion_number='$accesion_number' WHERE id_pemeriksaan_rad=$id_pemeriksaan_rad AND no_register='$no_register' and no_rad is null ");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register){
			$this->db->query("UPDATE daftar_ulang_irj SET rad=0 WHERE no_register='$no_register'");
			return true;
		}

		function selesai_faktur_pemeriksaan_IRJ($no_register,$getvtotrad,$no_rad,$accesion_number,$id_pemeriksaan_rad,$cetak_status_rad){
			$date = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad',accesion_number='$accesion_number', tgl_generate = '$date' WHERE id_pemeriksaan_rad=$id_pemeriksaan_rad AND no_register='$no_register' and no_rad is null ");

			$this->db->query("UPDATE daftar_ulang_irj SET billing_rad='$date', rad=0, cetak_rad=0, status_cetak_rad='$cetak_status_rad', vtot_rad='$getvtotrad' WHERE no_register='$no_register'");

			return true;
		}

		function selesai_daftar_pemeriksaan_IRD_header($no_register,$getvtotrad,$no_rad,$accesion_number,$id_pemeriksaan_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad',accesion_number='$accesion_number' WHERE id_pemeriksaan_rad=$id_pemeriksaan_rad AND no_register='$no_register' and no_rad is null ");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register){
			$this->db->query("UPDATE daftar_ulang_irj SET rad=0 WHERE no_register='$no_register'");
			return true;
		}

		function selesai_faktur_pemeriksaan_IRD($no_register,$getvtotrad,$no_rad,$accesion_number,$id_pemeriksaan_rad,$cetak_status_rad){
			$date = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pemeriksaan_radiologi SET accesion_number='$accesion_number',no_rad='$no_rad', tgl_generate = '$date' WHERE id_pemeriksaan_rad=$id_pemeriksaan_rad AND no_register='$no_register' and no_rad is null ");

			$this->db->query("UPDATE daftar_ulang_irj SET billing_rad='$date', rad=0,cetak_rad=0, status_cetak_rad='$cetak_status_rad', vtot_rad='$getvtotrad' WHERE no_register='$no_register'");

			return true;
		}

		function selesai_daftar_pemeriksaan_IRI_header($no_register,$status_rad,$vtot_rad,$no_rad,$accesion_number,$id_pemeriksaan_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET accesion_number='$accesion_number', no_rad='$no_rad' WHERE id_pemeriksaan_rad=$id_pemeriksaan_rad AND no_register='$no_register' and no_rad is null ");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register){
			$this->db->query("UPDATE pasien_iri SET rad=0 WHERE no_ipd='$no_register'");
			return true;
		}

		function selesai_faktur_pemeriksaan_IRI($no_register,$cetak_status_rad,$vtot_rad,$no_rad,$accesion_number,$id_pemeriksaan_rad){
			$date = date("Y-m-d H:i:s");
			$this->db->query("UPDATE pemeriksaan_radiologi SET accesion_number='$accesion_number',no_rad='$no_rad', tgl_generate = '$date' WHERE id_pemeriksaan_rad=$id_pemeriksaan_rad AND no_register='$no_register' and no_rad is null ");

			$this->db->query("UPDATE pasien_iri SET billing_rad='$date', rad=0,cetak_rad=0, status_cetak_rad='$cetak_status_rad', vtot_rad='$vtot_rad' WHERE no_ipd='$no_register'");

			return true;
		}

		function selesai_per_pemeriksaan_iri($no_register,$status_rad){
			$this->db->query("UPDATE pasien_iri SET status_rad='$status_rad' WHERE no_ipd='$no_register'");
			return true;
		}

		function selesai_per_pemeriksaan_irj($no_register,$status_rad){
			$this->db->query("UPDATE daftar_ulang_irj SET status_rad='$status_rad' WHERE no_register='$no_register'");
			return true;
		}

		function get_accesion_number ($no_register) {
			return $this->db->query("SELECT accesion_number FROM pemeriksaan_radiologi WHERE no_register = '$no_register' AND accesion_number is not null ORDER BY accesion_number DESC");
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_rad FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function getdata_rj($no_register){
			return $this->db->query("SELECT status_rad FROM daftar_ulang_irj WHERE no_register='".$no_register."'");
		}

		function getdata_faktur_iri($no_register){
			return $this->db->query("SELECT status_cetak_rad FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function getdata_faktur_rj($no_register){
			return $this->db->query("SELECT status_cetak_rad FROM daftar_ulang_irj WHERE no_register='".$no_register."'");
		}

		function get_vtot_rad($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_rad FROM pemeriksaan_radiologi WHERE no_register='".$no_register."'");
		}

		function get_vtot_no_rad($no_rad){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_rad FROM pemeriksaan_radiologi WHERE no_rad='".$no_rad."'");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_rad){
			$this->db->where('id_pemeriksaan_rad', $id_pemeriksaan_rad);
       		$this->db->delete('pemeriksaan_radiologi');			
			return true;
		}	

		function get_data_pasien_pemeriksaan_header($id_pemeriksaan_rad) {
			return $this->db->query("SELECT
				b.nama,
				b.no_cm,
				a.no_register,
				b.tgl_lahir,
				b.alamat,
				a.jadwal_rad,
				a.cara_bayar,
				c.nm_dokter AS dokter,
				d.jenis_tindakan,
				d.id_tindakan,
				d.accesion_number,
				d.modality,
				d.kelas,
				a.no_medrec,
				d.kelas
			FROM
				daftar_ulang_irj AS a
				INNER JOIN data_pasien AS b ON a.no_medrec = b.no_medrec
				INNER JOIN data_dokter AS c ON a.id_dokter = c.id_dokter
				INNER JOIN pemeriksaan_radiologi AS d ON a.no_register = d.no_register
			WHERE
				d.id_pemeriksaan_rad = '$id_pemeriksaan_rad' UNION
			SELECT
				b.nama,
				b.no_cm,
				a.no_ipd AS no_register,
				b.tgl_lahir,
				b.alamat,
				a.jadwal_rad,
				a.carabayar AS cara_bayar,
				a.dokter AS dokter,
				d.jenis_tindakan,
				d.id_tindakan,
				d.accesion_number,
				d.modality,
				d.kelas,
				a.no_medrec,
				d.kelas
			FROM
				pasien_iri AS a
				INNER JOIN data_pasien AS b ON a.no_medrec = b.no_medrec
				INNER JOIN pemeriksaan_radiologi AS d ON a.no_ipd = d.no_register
			WHERE
				d.id_pemeriksaan_rad = '$id_pemeriksaan_rad' UNION
			SELECT
				a.nama,
				CAST(a.no_cm AS VARCHAR),
				a.no_register,
				a.tgl_lahir,
				a.alamat,
				a.tgl_kunjungan AS jadwal_rad,
				a.cara_bayar,
				'-' AS dokter,
				d.jenis_tindakan,
				d.id_tindakan,
				d.accesion_number,
				d.modality,
				d.kelas,
				a.no_cm AS no_medrec,
				d.kelas
			FROM
				pasien_luar AS a
				INNER JOIN pemeriksaan_radiologi AS d ON a.no_register = d.no_register
			WHERE
				d.id_pemeriksaan_rad = '$id_pemeriksaan_rad'");
		}

		function get_master_bhp() {
			return $this->db->query("SELECT * FROM master_bhp_radiologi");
		}

		function insert_bhp($data) {
			return $this->db->insert('bhp_radiologi', $data);
		}

		function get_bhp_pasien_radiologi($id_pemeriksaan_rad) {
			return $this->db->query("SELECT * FROM bhp_radiologi WHERE id_pemeriksaan_rad = '$id_pemeriksaan_rad'");
		}

		function get_bhp_pasien_radiologi_byid($id_bhp) {
			return $this->db->query("SELECT * FROM bhp_radiologi WHERE id_bhp_rad = '$id_bhp'");
		}

		function hapus_pemeriksaan_bhp($id_bhp) {
			$this->db->query("DELETE FROM bhp_radiologi WHERE id_bhp_rad = '$id_bhp'");
			return true;
		}

		function edit_bhp_pemeriksaan($id_bhp, $data) {
			$this->db->where('id_bhp_rad', $id_bhp);
			$this->db->update('bhp_radiologi', $data);
			return true;
		}

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO rad_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_rad FROM rad_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_rad DESC LIMIT 1");
		}

		function insert_pasien_luar($data){
			$tahun = date('Y');
			$depan = substr($tahun,2,2);
			$this->db->set('no_register',"(select 'PLR".$depan."' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_register),6) FROM pasien_luar where \"jenis_PL\" = 'RAD' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, substring(to_char(now(),'YYYY-MM-DD'),3,2) as year 
			from pasien_luar where substring(no_register,3,2) = (select substring(to_char(now(),'YYYY-MM-DD'),3,2))");
		}


		//modul for radcpengisianhasil /////////////////////////////////////////////////////////////

		function get_hasil_rad(){
			return $this->db->query("SELECT
			data_pasien.nama,
			A.no_rad,
			A.cara_bayar,
			A.no_register,
			A.tgl_kunjungan AS tgl,
			COUNT ( 1 ) AS banyak,
			(
			SELECT COUNT
				( hasil_pemeriksaan_rad.id_hasil_rad ) AS hasil 
			FROM
				pemeriksaan_radiologi,
				hasil_pemeriksaan_rad 
			WHERE
				pemeriksaan_radiologi.id_pemeriksaan_rad = hasil_pemeriksaan_rad.id_pemeriksaan_rad 
				AND pemeriksaan_radiologi.no_rad = A.no_rad 
				AND hasil_pemeriksaan_rad.id_hasil_rad != 0 
			) AS selesai,
			a.cetak_kwitansi,
			SUM ( a.vtot ) AS vtot,
			A.no_medrec,
			data_pasien.no_cm,
			A.jenis_tindakan,
			A.accesion_number,
			A.hasil_pacs,
			A.hasil_simpan,
			b.jadwal_rad,
			a.tgl_generate,
			a.jadwal
		FROM
			pemeriksaan_radiologi A,
			data_pasien,
			daftar_ulang_irj AS b
		WHERE
			A.no_medrec = data_pasien.no_medrec 
			AND a.no_register = b.no_register
			AND cetak_hasil = '0' 
			AND no_rad IS NOT NULL 
			AND SUBSTRING ( A.no_register, 1, 2 ) = 'RJ' 
			and TO_CHAR(A.jadwal,'YYYY-MM-dd') <= TO_CHAR(now(),'YYYY-MM-dd')
			and to_char(A.jadwal,'YYYY-MM-dd') >= TO_CHAR(now() - INTERVAL '14 DAYS','YYYY-MM-dd')
		GROUP BY
			no_rad,
			nama,
			A.cara_bayar,
			A.no_register,
			A.tgl_kunjungan,
			a.cetak_kwitansi,
			A.no_medrec,
			A.cetak_hasil,
			data_pasien.no_cm,
			A.jenis_tindakan,
			A.accesion_number,
			A.hasil_pacs,
			A.hasil_simpan,
			b.jadwal_rad,
			a.tgl_generate,
			a.jadwal
			UNION
		SELECT
			pasien_luar.nama,
			b.no_rad,
			b.cara_bayar,
			b.no_register,
			b.tgl_kunjungan AS tgl,
			COUNT ( 1 ) AS banyak,
			(
			SELECT COUNT
				( hasil_pemeriksaan_rad.id_hasil_rad ) AS hasil 
			FROM
				pemeriksaan_radiologi,
				hasil_pemeriksaan_rad 
			WHERE
				pemeriksaan_radiologi.id_pemeriksaan_rad = hasil_pemeriksaan_rad.id_pemeriksaan_rad 
				AND pemeriksaan_radiologi.no_rad = b.no_rad 
				AND hasil_pemeriksaan_rad.id_hasil_rad != 0 
			) AS selesai,
			pasien_luar.cetak_kwitansi AS cetak_kwitansi,
			vtot_rad AS vtot,
			b.no_medrec,
			CAST ( pasien_luar.no_cm AS VARCHAR ),
			b.jenis_tindakan,
			b.accesion_number,
			b.hasil_pacs,
			b.hasil_simpan,
			pasien_luar.tgl_kunjungan AS jadwal_rad,
			b.tgl_generate,
			b.jadwal
		FROM
			pemeriksaan_radiologi b,
			pasien_luar 
		WHERE
			b.no_medrec = pasien_luar.no_cm 
			AND b.no_register = pasien_luar.no_register 
			AND cetak_hasil = '0' 
			AND no_rad IS NOT NULL 
			AND SUBSTRING ( b.no_register, 1, 2 ) = 'PL' 
			AND TO_CHAR(b.jadwal,'YYYY-MM-dd') <= TO_CHAR(now(),'YYYY-MM-dd')
			and to_char(b.jadwal,'YYYY-MM-dd') >= TO_CHAR(now() - INTERVAL '14 DAYS','YYYY-MM-dd')
		GROUP BY
			no_rad,
			nama,
			b.cara_bayar,
			b.no_register,
			b.tgl_kunjungan,
			pasien_luar.cetak_kwitansi,
			vtot_rad,
			b.no_medrec,
			b.cetak_hasil,
			pasien_luar.no_cm,
			b.jenis_tindakan,
			b.accesion_number,
			b.hasil_pacs,
			b.hasil_simpan,
			pasien_luar.tgl_kunjungan,
			b.tgl_generate,
			b.jadwal
		ORDER BY
			jadwal_rad DESC");
		}

		function get_hasil_rad_ri() {
			return $this->db->query("SELECT
				data_pasien.nama,
				A.no_rad,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan AS tgl,
				COUNT ( 1 ) AS banyak,
				(
				SELECT COUNT
					( hasil_pemeriksaan_rad.id_hasil_rad ) AS hasil 
				FROM
					pemeriksaan_radiologi,
					hasil_pemeriksaan_rad 
				WHERE
					pemeriksaan_radiologi.id_pemeriksaan_rad = hasil_pemeriksaan_rad.id_pemeriksaan_rad 
					AND pemeriksaan_radiologi.no_rad = A.no_rad 
					AND hasil_pemeriksaan_rad.id_hasil_rad != 0 
				) AS selesai,
				A.cetak_kwitansi,
				SUM ( A.vtot ) AS vtot,
				A.no_medrec,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate
			FROM
				pemeriksaan_radiologi A,
				data_pasien,
				pasien_iri AS b 
			WHERE
				A.no_medrec = data_pasien.no_medrec 
				AND A.no_register = b.no_ipd 
				AND cetak_hasil = '0' 
				AND no_rad IS NOT NULL 
				AND SUBSTRING ( A.no_register, 1, 2 ) = 'RI' 
				AND TO_CHAR( A.jadwal, 'YYYY-MM-dd' ) <= TO_CHAR( now( ), 'YYYY-MM-dd' ) 
				AND to_char( A.jadwal, 'YYYY-MM-dd' ) >= TO_CHAR( now( ) - INTERVAL '14 DAYS', 'YYYY-MM-dd' ) 
			GROUP BY
				no_rad,
				data_pasien.nama,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan,
				A.cetak_kwitansi,
				A.no_medrec,
				A.cetak_hasil,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate
			ORDER BY jadwal_rad DESC");
		}

		function get_hasil_rad_by_date($date){
			return $this->db->query("SELECT
				data_pasien.nama,
				A.no_rad,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan AS tgl,
				COUNT ( 1 ) AS banyak,
				(
				SELECT COUNT
					( hasil_pemeriksaan_rad.id_hasil_rad ) AS hasil 
				FROM
					pemeriksaan_radiologi,
					hasil_pemeriksaan_rad 
				WHERE
					pemeriksaan_radiologi.id_pemeriksaan_rad = hasil_pemeriksaan_rad.id_pemeriksaan_rad 
					AND pemeriksaan_radiologi.no_rad = A.no_rad 
					AND hasil_pemeriksaan_rad.id_hasil_rad != 0 
				) AS selesai,
				A.cetak_kwitansi,
				SUM ( A.vtot ) AS vtot,
				A.no_medrec,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate,
				a.jadwal
			FROM
				pemeriksaan_radiologi A,
				data_pasien,
				daftar_ulang_irj AS b 
			WHERE
				A.no_medrec = data_pasien.no_medrec 
				AND A.no_register = b.no_register 
				AND cetak_hasil = '0' 
				AND no_rad IS NOT NULL 
				AND SUBSTRING ( A.no_register, 1, 2 ) = 'RJ' 
				AND to_char(a.jadwal, 'YYYY-MM-DD') = '$date'
			GROUP BY
				no_rad,
				nama,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan,
				A.cetak_kwitansi,
				A.no_medrec,
				A.cetak_hasil,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate,
				a.jadwal
				UNION
			SELECT
				pasien_luar.nama,
				b.no_rad,
				b.cara_bayar,
				b.no_register,
				b.tgl_kunjungan AS tgl,
				COUNT ( 1 ) AS banyak,
				(
				SELECT COUNT
					( hasil_pemeriksaan_rad.id_hasil_rad ) AS hasil 
				FROM
					pemeriksaan_radiologi,
					hasil_pemeriksaan_rad 
				WHERE
					pemeriksaan_radiologi.id_pemeriksaan_rad = hasil_pemeriksaan_rad.id_pemeriksaan_rad 
					AND pemeriksaan_radiologi.no_rad = b.no_rad 
					AND hasil_pemeriksaan_rad.id_hasil_rad != 0 
				) AS selesai,
				pasien_luar.cetak_kwitansi AS cetak_kwitansi,
				vtot_rad AS vtot,
				b.no_medrec,
				CAST ( pasien_luar.no_cm AS VARCHAR ),
				b.jenis_tindakan,
				b.accesion_number,
				b.hasil_pacs,
				b.hasil_simpan,
				pasien_luar.tgl_kunjungan AS jadwal_rad,
				b.tgl_generate,
				b.jadwal
			FROM
				pemeriksaan_radiologi b,
				pasien_luar 
			WHERE
				b.no_medrec = pasien_luar.no_cm 
				AND b.no_register = pasien_luar.no_register 
				AND cetak_hasil = '0' 
				AND no_rad IS NOT NULL 
				AND SUBSTRING ( b.no_register, 1, 2 ) = 'PL' 
				AND to_char(b.jadwal, 'YYYY-MM-DD') = '$date'
			GROUP BY
				no_rad,
				nama,
				b.cara_bayar,
				b.no_register,
				b.tgl_kunjungan,
				pasien_luar.cetak_kwitansi,
				vtot_rad,
				b.no_medrec,
				b.cetak_hasil,
				pasien_luar.no_cm,
				b.jenis_tindakan,
				b.accesion_number,
				b.hasil_pacs,
				b.hasil_simpan,
				pasien_luar.tgl_kunjungan,
				b.tgl_generate,
				b.jadwal
			ORDER BY
				jadwal_rad DESC");
		}

		function get_hasil_rad_by_date_ri($date) {
			return $this->db->query("SELECT
				data_pasien.nama,
				A.no_rad,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan AS tgl,
				COUNT ( 1 ) AS banyak,
				(
				SELECT COUNT
					( hasil_pemeriksaan_rad.id_hasil_rad ) AS hasil 
				FROM
					pemeriksaan_radiologi,
					hasil_pemeriksaan_rad 
				WHERE
					pemeriksaan_radiologi.id_pemeriksaan_rad = hasil_pemeriksaan_rad.id_pemeriksaan_rad 
					AND pemeriksaan_radiologi.no_rad = A.no_rad 
					AND hasil_pemeriksaan_rad.id_hasil_rad != 0 
				) AS selesai,
				A.cetak_kwitansi,
				SUM ( A.vtot ) AS vtot,
				A.no_medrec,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate
			FROM
				pemeriksaan_radiologi A,
				data_pasien,
				pasien_iri AS b 
			WHERE
				A.no_medrec = data_pasien.no_medrec 
				AND A.no_register = b.no_ipd 
				AND cetak_hasil = '0' 
				AND no_rad IS NOT NULL 
				AND SUBSTRING ( A.no_register, 1, 2 ) = 'RI' 
				AND to_char(a.jadwal, 'YYYY-MM-DD') = '$date'
			GROUP BY
				no_rad,
				data_pasien.nama,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan,
				A.cetak_kwitansi,
				A.no_medrec,
				A.cetak_hasil,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate
			ORDER BY jadwal_rad DESC");
		}

		function get_hasil_rad_by_no($key){
			return $this->db->query("SELECT nama, a.no_rad, a.cara_bayar, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_pemeriksaan_rad.id_hasil_rad) AS hasil FROM pemeriksaan_radiologi,hasil_pemeriksaan_rad WHERE pemeriksaan_radiologi.id_pemeriksaan_rad=hasil_pemeriksaan_rad.id_pemeriksaan_rad AND pemeriksaan_radiologi.no_rad=a.no_rad AND hasil_pemeriksaan_rad.id_hasil_rad is not null) as selesai, cetak_kwitansi, sum(vtot) as vtot ,a.no_medrec
			FROM pemeriksaan_radiologi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_rad is not null 
			AND a.no_register LIKE '%$key%'
			and substring(a.no_register,1,2) != 'PL'
			GROUP BY no_rad ,nama,a.cara_bayar, a.no_register,tgl,cetak_kwitansi,a.no_medrec
			UNION
			SELECT nama, b.no_rad, b.cara_bayar, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_pemeriksaan_rad.id_hasil_rad) AS hasil FROM pemeriksaan_radiologi,hasil_pemeriksaan_rad WHERE pemeriksaan_radiologi.id_pemeriksaan_rad=hasil_pemeriksaan_rad.id_pemeriksaan_rad AND pemeriksaan_radiologi.no_rad=b.no_rad AND hasil_pemeriksaan_rad.id_hasil_rad is not null) as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_rad as vtot ,b.no_medrec
			FROM pemeriksaan_radiologi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_rad is not null 
			AND b.no_register LIKE '%$key%'
			and substring(b.no_register,1,2) = 'PL'
			GROUP BY no_rad ,nama,b.cara_bayar, b.no_register,tgl, pasien_luar.cetak_kwitansi,vtot_rad,b.no_medrec 
			ORDER BY no_rad asc");
		}

		function get_hasil_rad_by_no_new($key) {
			return $this->db->query("SELECT
				data_pasien.nama,
				A.no_rad,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan AS tgl,
				COUNT ( 1 ) AS banyak,
				(
				SELECT COUNT
					( hasil_pemeriksaan_rad.id_hasil_rad ) AS hasil 
				FROM
					pemeriksaan_radiologi,
					hasil_pemeriksaan_rad 
				WHERE
					pemeriksaan_radiologi.id_pemeriksaan_rad = hasil_pemeriksaan_rad.id_pemeriksaan_rad 
					AND pemeriksaan_radiologi.no_rad = A.no_rad 
					AND hasil_pemeriksaan_rad.id_hasil_rad != 0 
				) AS selesai,
				A.cetak_kwitansi,
				SUM ( A.vtot ) AS vtot,
				A.no_medrec,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate
			FROM
				pemeriksaan_radiologi A,
				data_pasien,
				daftar_ulang_irj AS b 
			WHERE
				A.no_medrec = data_pasien.no_medrec 
				AND A.no_register = b.no_register 
				AND cetak_hasil = '0' 
				AND A.selesai = 1 
				AND no_rad IS NOT NULL 
				AND SUBSTRING ( A.no_register, 1, 2 ) = 'RJ' 
				AND (data_pasien.no_cm LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
			GROUP BY
				no_rad,
				nama,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan,
				A.cetak_kwitansi,
				A.no_medrec,
				A.cetak_hasil,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate UNION
			SELECT
				pasien_luar.nama,
				b.no_rad,
				b.cara_bayar,
				b.no_register,
				b.tgl_kunjungan AS tgl,
				COUNT ( 1 ) AS banyak,
				(
				SELECT COUNT
					( hasil_pemeriksaan_rad.id_hasil_rad ) AS hasil 
				FROM
					pemeriksaan_radiologi,
					hasil_pemeriksaan_rad 
				WHERE
					pemeriksaan_radiologi.id_pemeriksaan_rad = hasil_pemeriksaan_rad.id_pemeriksaan_rad 
					AND pemeriksaan_radiologi.no_rad = b.no_rad 
					AND hasil_pemeriksaan_rad.id_hasil_rad != 0 
				) AS selesai,
				pasien_luar.cetak_kwitansi AS cetak_kwitansi,
				vtot_rad AS vtot,
				b.no_medrec,
				CAST ( pasien_luar.no_cm AS VARCHAR ),
				b.jenis_tindakan,
				b.accesion_number,
				b.hasil_pacs,
				b.hasil_simpan,
				pasien_luar.tgl_kunjungan AS jadwal_rad,
				b.tgl_generate
			FROM
				pemeriksaan_radiologi b,
				pasien_luar 
			WHERE
				b.no_medrec = pasien_luar.no_cm 
				AND b.no_register = pasien_luar.no_register 
				AND cetak_hasil = '0' 
				AND no_rad IS NOT NULL 
				AND SUBSTRING ( b.no_register, 1, 2 ) = 'PL' 
				AND b.selesai = 1 
				AND (CAST(pasien_luar.no_cm AS VARCHAR) LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
			GROUP BY
				no_rad,
				nama,
				b.cara_bayar,
				b.no_register,
				b.tgl_kunjungan,
				pasien_luar.cetak_kwitansi,
				vtot_rad,
				b.no_medrec,
				b.cetak_hasil,
				pasien_luar.no_cm,
				b.jenis_tindakan,
				b.accesion_number,
				b.hasil_pacs,
				b.hasil_simpan,
				pasien_luar.tgl_kunjungan,
				b.tgl_generate
			ORDER BY
				jadwal_rad DESC");
		}

		function get_hasil_rad_by_no_new_ri($key) {
			return $this->db->query("SELECT
				data_pasien.nama,
				A.no_rad,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan AS tgl,
				COUNT ( 1 ) AS banyak,
				(
				SELECT COUNT
					( hasil_pemeriksaan_rad.id_hasil_rad ) AS hasil 
				FROM
					pemeriksaan_radiologi,
					hasil_pemeriksaan_rad 
				WHERE
					pemeriksaan_radiologi.id_pemeriksaan_rad = hasil_pemeriksaan_rad.id_pemeriksaan_rad 
					AND pemeriksaan_radiologi.no_rad = A.no_rad 
					AND hasil_pemeriksaan_rad.id_hasil_rad != 0 
				) AS selesai,
				A.cetak_kwitansi,
				SUM ( A.vtot ) AS vtot,
				A.no_medrec,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate
			FROM
				pemeriksaan_radiologi A,
				data_pasien,
				pasien_iri AS b 
			WHERE
				A.no_medrec = data_pasien.no_medrec 
				AND A.no_register = b.no_ipd 
				AND cetak_hasil = '0' 
				AND A.selesai = 1 
				AND no_rad IS NOT NULL 
				AND SUBSTRING ( A.no_register, 1, 2 ) = 'RI' 
				AND (data_pasien.no_cm LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
			GROUP BY
				no_rad,
				data_pasien.nama,
				A.cara_bayar,
				A.no_register,
				A.tgl_kunjungan,
				A.cetak_kwitansi,
				A.no_medrec,
				A.cetak_hasil,
				data_pasien.no_cm,
				A.jenis_tindakan,
				A.accesion_number,
				A.hasil_pacs,
				A.hasil_simpan,
				b.jadwal_rad,
				a.tgl_generate
			ORDER BY jadwal_rad DESC");
		}

		function get_no_hasil_rad() {
			return $this->db->query("SELECT a.id_hasil_rad FROM hasil_pemeriksaan_rad AS a, pemeriksaan_radiologi AS b WHERE a.id_pemeriksaan_rad = b.id_pemeriksaan_rad");
		}

		function getrow_hasil_rad($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi, data_pasien WHERE pemeriksaan_radiologi.no_medrec=data_pasien.no_medrec AND pemeriksaan_radiologi.no_register='".$no_register."' ");
		}	

		function get_data_pengisian_hasil($no_rad){
			return $this->db->query("SELECT a.*, c.id_hasil_rad, c.hasil_pengirim FROM pemeriksaan_radiologi as a LEFT JOIN hasil_pemeriksaan_rad AS c ON a.id_pemeriksaan_rad=c.id_pemeriksaan_rad WHERE a.no_rad='".$no_rad."' ORDER BY a.no_rad");
		}

		function get_banyak_hasil_rad($no_register){
			return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_radiologi WHERE no_register=".$no_register."' ");
		}

		function get_data_hasil_pemeriksaan($no_rad){
			return $this->db->query("SELECT 
				a.*,
				c.*,
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') as tgl,
				b.tgl_kunjungan AS tglkunj
			FROM 
				pemeriksaan_radiologi AS a, data_pasien AS c, daftar_ulang_irj AS b
			WHERE 
				a.no_medrec=c.no_medrec 
				AND a.no_rad='$no_rad' 
				AND a.no_register = b.no_register UNION
			SELECT 
				a.*, 
				c.*,
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') as tgl,
				b.tgl_masuk AS tglkunj
			FROM 
				pemeriksaan_radiologi AS a, data_pasien AS c, pasien_iri AS b
			WHERE 
				a.no_medrec=c.no_medrec 
				AND a.no_rad='$no_rad'
				AND a.no_register = b.no_ipd LIMIT 1");
		}

		function get_data_hasil_pemeriksaan_pasien_luar($no_rad){
			return $this->db->query("SELECT 
				*, 
				TO_CHAR(pemeriksaan_radiologi.tgl_kunjungan, 'YYYY-MM-DD') as tgl,
				pasien_luar.tgl_kunjungan AS tglkunj 
			FROM 
				pemeriksaan_radiologi, 
				pasien_luar 
			WHERE 
				pemeriksaan_radiologi.no_register=pasien_luar.no_register 
				AND pemeriksaan_radiologi.no_rad='$no_rad' LIMIT 1");
		}

		function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_rad){
			return $this->db->query("SELECT
				b.sex,
				b.tgl_lahir,
				A.*,
				b.no_cm AS no_cm,
				b.nama AS nama,
				b.foto AS foto,
				to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
				C.* ,
				d.tgl_kunjungan AS tglkunj,
				d.diag_klinis_rad as diag_klinis_rad
			FROM
				pemeriksaan_radiologi
				AS A LEFT JOIN data_pasien AS b ON A.no_medrec = b.no_medrec
				LEFT JOIN hasil_pemeriksaan_rad AS C ON A.id_pemeriksaan_rad = C.id_pemeriksaan_rad 
				LEFT JOIN daftar_ulang_irj AS d ON a.no_register = d.no_register
			WHERE
				A.id_pemeriksaan_rad = '$id_pemeriksaan_rad' UNION
			SELECT
				b.sex,
				b.tgl_lahir,
				A.*,
				b.no_cm AS no_cm,
				b.nama AS nama,
				b.foto AS foto,
				to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
				C.* ,
				d.tgl_masuk AS tglkunj,
				'dignosa' as diag_klinis_rad

			FROM
				pemeriksaan_radiologi
				AS A LEFT JOIN data_pasien AS b ON A.no_medrec = b.no_medrec
				LEFT JOIN hasil_pemeriksaan_rad AS C ON A.id_pemeriksaan_rad = C.id_pemeriksaan_rad 
				LEFT JOIN pasien_iri AS d ON a.no_register = d.no_ipd
			WHERE
				A.id_pemeriksaan_rad = '$id_pemeriksaan_rad' LIMIT 1");
		}

		function get_dokter_pengirim_rj($no_register) {
				return $this->db->query("SELECT
					b.nm_dokter 
				FROM
					daftar_ulang_irj AS A,
					data_dokter AS b 
				WHERE
					A.id_dokter = b.id_dokter 
					AND A.no_register = '$no_register'");
			
		}

		function get_dokter_pengirim_ri($no_register) {
			return $this->db->query("SELECT dokter FROM pasien_iri WHERE no_ipd = '$no_register'");
		}

		function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_rad){
			return $this->db->query("SELECT a.*,b.jk,b.tgl_lahir,b.no_cm AS no_cm,b.dokter,b.alamat,b.nama AS nama,to_char 
			(a.tgl_kunjungan,'YYYY-MM-DD') AS tgl,c.*, b.diagnosa, b.rs_perujuk, b.tgl_kunjungan AS tglkunj FROM pemeriksaan_radiologi AS a LEFT JOIN pasien_luar
			AS b ON a.no_medrec=b.no_cm LEFT JOIN hasil_pemeriksaan_rad AS c ON 
			a.id_pemeriksaan_rad=c.id_pemeriksaan_rad WHERE a.id_pemeriksaan_rad='$id_pemeriksaan_rad'");
		}

		function get_data_tindakan_rad($id_tindakan){
			return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_rad.* FROM jenis_hasil_rad, jenis_tindakan WHERE  jenis_hasil_rad.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
		}

		function get_data_tindakan_rad_id($id_pemeriksaan_rad){
			return $this->db->query("SELECT
				*
			FROM
				pemeriksaan_radiologi
			WHERE
				id_pemeriksaan_rad = '$id_pemeriksaan_rad'");
		}

		function isi_hasil($data){
			$this->db->insert('hasil_pemeriksaan_rad', $data);
			return true;	
		}

		function update_hasil($id_pemeriksaan_rad, $data){
			$this->db->where('id_pemeriksaan_rad', $id_pemeriksaan_rad);
			$this->db->update('hasil_pemeriksaan_rad', $data);
			return true;	
		}

		function insert_tgl_tindak_perawat($tgl_tindak, $no_register) {
			$this->db->where('no_register', $no_register);
			$this->db->update('pemeriksaan_radiologi', $tgl_tindak);
			return true;
		}

		function set_hasil_periksa($id_pemeriksaan_rad, $data){
			$this->db->where('id_pemeriksaan_rad', $id_pemeriksaan_rad);
			$this->db->update('pemeriksaan_radiologi', $data);
			return true;
		}

		function edit_diag_masuk_rj($no_register, $data){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}

		function edit_diag_masuk_ri($no_ipd, $data){
			$this->db->where('no_ipd', $no_ipd);
			$this->db->update('pasien_iri', $data);
			return true;
		}

		function get_row_register($id_pemeriksaan_rad){
			return $this->db->query("SELECT no_register FROM pemeriksaan_radiologi WHERE id_pemeriksaan_rad='$id_pemeriksaan_rad'");
		}

		function get_data_edit_tindakan_rad($id_pemeriksaan_rad, $no_rad){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_rad WHERE  id_pemeriksaan_rad='$id_pemeriksaan_rad' AND no_rad='$no_rad'");
		}

		function get_no_register($no_rad){
			return $this->db->query("SELECT no_register FROM pemeriksaan_radiologi WHERE  no_rad='$no_rad' GROUP BY no_register");
		}

		function get_no_register_by_id($no_rad){
			return $this->db->query("SELECT no_register FROM pemeriksaan_radiologi WHERE  id_pemeriksaan_rad='$no_rad' GROUP BY no_register");
		}

		function get_no_medrec_hasil($no_rad){
			return $this->db->query("SELECT no_medrec FROM pemeriksaan_radiologi WHERE  no_rad='$no_rad' GROUP BY no_medrec");
		}

		function get_no_medrec_hasil_by_id($no_rad){
			return $this->db->query("SELECT no_medrec FROM pemeriksaan_radiologi WHERE  id_pemeriksaan_rad='$no_rad' GROUP BY no_medrec");
		}

		function get_idrg_hasil($no_rad){
			return $this->db->query("SELECT idrg FROM pemeriksaan_radiologi WHERE  no_rad='$no_rad' GROUP BY idrg");
		}

		function get_idrg_hasil_by_id($no_rad){
			return $this->db->query("SELECT idrg FROM pemeriksaan_radiologi WHERE  id_pemeriksaan_rad='$no_rad' GROUP BY idrg");
		}

		function get_no_rm_hasil($no_medrec) {
			return $this->db->query("SELECT no_cm FROM data_pasien WHERE no_medrec = '$no_medrec'");
		}

		function edit_hasil($id_hasil_pemeriksaan, $hasil_rad){
			return $this->db->query("UPDATE hasil_pemeriksaan_rad SET hasil_rad='$hasil_rad' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		}

		function update_status_cetak_hasil($id_pemeriksaan){
			$this->db->query("UPDATE pemeriksaan_radiologi SET cetak_hasil='1' where id_pemeriksaan_rad = '$id_pemeriksaan'");
			return true;
		}

		function get_data_hasil_rad($no_rad){
			return $this->db->query("SELECT a.id_tindakan,a.no_rad,a.jenis_tindakan,a.hasil_periksa,b.* FROM pemeriksaan_radiologi AS a LEFT JOIN hasil_pemeriksaan_rad AS b ON a.id_pemeriksaan_rad=b.id_pemeriksaan_rad WHERE a.no_rad='$no_rad'");
		
			// return $this->db->query("SELECT A
			// 	.id_tindakan,
			// 	A.no_rad,
			// 	A.jenis_tindakan,
			// 	A.hasil_periksa,
			// 	b.* 
			// FROM
			// 	pemeriksaan_radiologi AS a,
			// 	hasil_pemeriksaan_rad AS b
			// WHERE
			// 	A.no_rad = '$no_rad'
			// 	AND b.id_pemeriksaan_rad = a.id_pemeriksaan_rad");
		}

		function get_data_hasil_rad_by_noreg($no_register){
			return $this->db->query("SELECT 
				a.id_tindakan,
				a.no_rad,
				a.jenis_tindakan,
				a.hasil_periksa,
				b.* 
			FROM 
				pemeriksaan_radiologi AS a 
				LEFT JOIN hasil_pemeriksaan_rad AS b ON a.id_pemeriksaan_rad=b.id_pemeriksaan_rad 
			WHERE 
				a.no_register='$no_register'");
		}

		function get_data_hasil_rad_pemeriksaan($id_pemeriksaan){
			return $this->db->query("SELECT 
				id_tindakan,
				no_rad,
				jenis_tindakan
			FROM
				pemeriksaan_radiologi
			WHERE
				id_pemeriksaan_rad = CAST('$id_pemeriksaan' AS INT)");
		}

		function get_data_hasil_rad_pertindakan($id_pemeriksaan_rad){
			return $this->db->query("SELECT a.id_tindakan,a.no_rad,a.jenis_tindakan,a.hasil_periksa,b.*FROM pemeriksaan_radiologi AS a LEFT JOIN hasil_pemeriksaan_rad AS b ON a.id_pemeriksaan_rad=b.id_pemeriksaan_rad WHERE a.id_pemeriksaan_rad='$id_pemeriksaan_rad'");
		}

		function get_gambar_hasil_rad($id_pemeriksaan_rad){
			return $this->db->query("SELECT a.name, a.id_pemeriksaan_rad FROM hasil_pemeriksaan_rad_detail AS a LEFT JOIN hasil_pemeriksaan_rad AS b ON a.id_pemeriksaan_rad=b.id_pemeriksaan_rad WHERE a.id_pemeriksaan_rad='$id_pemeriksaan_rad'");

			// return $this->db->query("SELECT A
			// 	.id_tindakan,
			// 	A.no_rad,
			// 	A.jenis_tindakan,
			// 	A.hasil_periksa,
			// 	b.* 
			// FROM
			// 	pemeriksaan_radiologi AS a,
			// 	hasil_pemeriksaan_rad AS b
			// WHERE
			// 	A.no_rad = '18270'
			// 	AND b.id_pemeriksaan_rad = a.id_pemeriksaan_rad")
		}

		function get_data_pasien_cetak($no_rad){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_rad='$no_rad'");
		}

		function get_data_pasien_cetak_by_noreg($no_register){
			return $this->db->query("SELECT 
				* 
			FROM 
				pemeriksaan_radiologi a, 
				data_pasien 
			WHERE 
				a.no_medrec=data_pasien.no_medrec 
				AND a.no_register='$no_register'");
		}

		function get_norad_by_noreg($no_register) {
			return $this->db->query("SELECT no_rad FROM pemeriksaan_radiologi WHERE no_register = '$no_register'");
		}

		function get_data_pasien_luar_cetak($no_rad){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi a, pasien_luar WHERE a.no_register=pasien_luar.no_register AND no_rad='$no_rad'");
		}

		//modul for labcdaftarhasil /////////////////////////////////////////////////////////////

		function get_hasil_rad_selesai(){
			$date = date("Y-m-d");
			return $this->db->query("SELECT
				nama ,
				a.accesion_number,
				a.jenis_tindakan,
				a.id_pemeriksaan_rad,
				a.no_medrec ,
				a.no_rad ,
				a.no_register ,
				a.tgl_kunjungan as tgl ,
				cetak_kwitansi ,
				data_pasien.no_cm,
				data_pasien.no_hp,
				data_pasien.email,
				b.tanggal_isi AS tgl_baca,
				a.tgl_generate,
				a.jadwal
			FROM
				pemeriksaan_radiologi a ,
				data_pasien,
				hasil_pemeriksaan_rad b
			WHERE
				a.no_medrec = data_pasien.no_medrec
				AND a.id_pemeriksaan_rad = b.id_pemeriksaan_rad
				and substr(A.no_register,1,2) <> 'PL'
				AND no_rad is not null
				AND to_char(a.jadwal, 'YYYY-MM-DD') = '$date' UNION 
			SELECT 
				nama, 
				a.accesion_number, 
				a.jenis_tindakan, 
				a.id_pemeriksaan_rad,
				a.no_medrec , 
				a.no_rad, 
				a.no_register,
				a.tgl_kunjungan as tgl, 
				a.cetak_kwitansi, 
				CAST(b.no_cm AS VARCHAR), 
				b.no_hp, 
				b.email,
				c.tanggal_isi AS tgl_baca,
				a.tgl_generate,
				a.jadwal
			FROM 
				pemeriksaan_radiologi a, 
				pasien_luar b,
				hasil_pemeriksaan_rad c
			WHERE 
				a.no_register=b.no_register 
				AND a.id_pemeriksaan_rad = c.id_pemeriksaan_rad 
				AND no_rad is not null 
				AND to_char(a.tgl_generate,'YYYY-MM-DD')='$date'
			ORDER BY tgl DESC");

			// $date = date("Y-m-d");
			// 						return $this->db->query("SELECT
			// 						nama ,
			// 						a.accesion_number,
			// 						a.no_medrec ,
			// 						a.no_rad ,
			// 						a.no_register ,
			// 						a.tgl_kunjungan as tgl_baca ,
			// 						count(1) as banyak ,
			// 						(
			// 							SELECT
			// 								COUNT(hasil_periksa) as hasil
			// 							FROM
			// 								pemeriksaan_radiologi
			// 							WHERE
			// 								no_rad = a.no_rad
			// 							AND hasil_periksa != '0'
			// 						) as selesai ,
			// 						cetak_kwitansi ,
			// 						sum(vtot) as vtot,
			// 						data_pasien.no_cm,
			// 						data_pasien.no_hp,
			// 						data_pasien.email
			// 					FROM
			// 						pemeriksaan_radiologi a ,
			// 						data_pasien
			// 					WHERE
			// 						a.no_medrec = data_pasien.no_medrec
			// 					AND cetak_hasil = '1'
			// 					and substr(A.no_register,1,2) <> 'PL'
			// 					AND no_rad is not null
			// 					AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
			// 					GROUP BY
			// 					a.accesion_number,
			// 						no_rad,nama,RIGHT(a.no_register , 6),a.no_register,tgl_baca,cetak_kwitansi,a.no_medrec, data_pasien.no_cm, data_pasien.no_hp, data_pasien.email
								
			// 	UNION 
			// 	SELECT nama, a.accesion_number,
			// 						a.no_medrec , a.no_rad, a.no_register,
			// 				a.tgl_kunjungan as tgl_baca, count(1) as banyak, (SELECT COUNT(hasil_periksa) 
			// 	as hasil FROM pemeriksaan_radiologi 
			// 	WHERE no_rad=a.no_rad AND hasil_periksa!='0') as selesai, 
			// 	a.cetak_kwitansi, sum(vtot) as vtot, CAST(b.no_cm AS VARCHAR), b.no_hp, b.email
			// 	FROM pemeriksaan_radiologi a, pasien_luar b 
			// 	WHERE a.no_register=b.no_register AND cetak_hasil='1' 
			// 	AND no_rad is not null AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')='$date'
			// 	GROUP BY a.accesion_number,no_rad,nama,RIGHT(a.no_register,6),a.no_register,tgl_baca,a.cetak_kwitansi,a.no_medrec,b.no_cm, b.no_hp, b.email
			// 	ORDER BY tgl_baca DESC");
		}

		function get_hasil_rad_by_date_selesai($date){
			return $this->db->query("SELECT
				nama ,
				a.accesion_number,
				a.jenis_tindakan,
				a.id_pemeriksaan_rad,
				a.no_medrec ,
				a.no_rad ,
				a.no_register ,
				a.tgl_kunjungan as tgl ,
				cetak_kwitansi ,
				data_pasien.no_cm,
				data_pasien.no_hp,
				data_pasien.email,
				b.tanggal_isi AS tgl_baca,
				a.tgl_generate
			FROM
				pemeriksaan_radiologi a ,
				data_pasien,
				hasil_pemeriksaan_rad b
			WHERE
				a.no_medrec = data_pasien.no_medrec
				AND b.id_pemeriksaan_rad = a.id_pemeriksaan_rad
				and substr(A.no_register,1,2) <> 'PL'
				AND no_rad is not null 
				AND to_char(a.tgl_generate,'YYYY-MM-DD')='$date' UNION 
			SELECT
				nama,
				a.accesion_number,
				a.jenis_tindakan,
				a.id_pemeriksaan_rad,
				a.no_medrec ,
				a.no_rad ,
				a.no_register ,
				a.tgl_kunjungan as tgl ,
				a.cetak_kwitansi ,
				CAST(pasien_luar.no_cm AS VARCHAR),
				pasien_luar.no_hp,
				pasien_luar.email,
				c.tanggal_isi AS tgl_baca,
				a.tgl_generate
			FROM
				pemeriksaan_radiologi a ,
				pasien_luar,
				hasil_pemeriksaan_rad c
			WHERE
				a.no_register = pasien_luar.no_register
				AND a.id_pemeriksaan_rad = c.id_pemeriksaan_rad
				AND no_rad is not null 
				AND to_char(a.tgl_generate,'YYYY-MM-DD')='$date'
			ORDER BY
				tgl DESC");

// return $this->db->query("SELECT
// nama ,
// a.accesion_number,
// a.no_medrec ,
// a.no_rad ,
// a.no_register ,
// a.tgl_kunjungan as tgl_baca ,
// count(1) as banyak ,
// (
// 	SELECT
// 		COUNT(hasil_periksa) as hasil
// 	FROM
// 		pemeriksaan_radiologi
// 	WHERE
// 		no_rad = a.no_rad
// 	AND hasil_periksa is not null
// ) as selesai ,
// cetak_kwitansi ,
// sum(vtot) as vtot,
// data_pasien.no_cm,
// data_pasien.no_hp,
// data_pasien.email
// FROM
// pemeriksaan_radiologi a ,
// data_pasien
// WHERE
// a.no_medrec = data_pasien.no_medrec
// AND cetak_hasil = '1'
// and substr(A.no_register,1,2) <> 'PL'
// AND no_rad is not null 
// AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')='$date'
// GROUP BY
// no_rad,nama ,
// a.no_medrec ,
// a.no_register ,
// tgl_baca,
// cetak_kwitansi,										
// a.accesion_number,
// data_pasien.no_cm,
// data_pasien.no_hp,
// data_pasien.email
// 	UNION 
// 	SELECT
// nama,
// a.accesion_number,
// a.no_medrec ,
// a.no_rad ,
// a.no_register ,
// a.tgl_kunjungan as tgl_baca ,
// count(1) as banyak ,
// (
// 	SELECT
// 		COUNT(hasil_periksa) as hasil
// 	FROM
// 		pemeriksaan_radiologi
// 	WHERE
// 		no_rad = a.no_rad
// 	AND hasil_periksa is not null
// ) as selesai ,
// a.cetak_kwitansi ,
// sum(vtot) as vtot,
// CAST(pasien_luar.no_cm AS VARCHAR),
// pasien_luar.no_hp,
// pasien_luar.email
// FROM
// pemeriksaan_radiologi a ,
// pasien_luar
// WHERE
// a.no_register = pasien_luar.no_register
// AND cetak_hasil = '1'
// AND no_rad is not null 
// AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')='$date'
// GROUP BY
// no_rad,nama ,
// a.no_medrec ,
// a.no_register ,
// tgl_baca,
// a.cetak_kwitansi,										
// a.accesion_number,
// CAST(pasien_luar.no_cm AS VARCHAR),
// pasien_luar.no_hp,
// pasien_luar.email
// ORDER BY
// 	tgl_baca DESC");
		}

		function get_hasil_rad_by_no_selesai($key){
			return $this->db->query("SELECT
				nama ,
				a.no_medrec  as no_medrec ,
				a.no_rad ,
				a.no_register ,
				a.tgl_kunjungan as tgl ,
				count(1) as banyak ,
				(SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_radiologi WHERE no_rad = a.no_rad AND hasil_periksa is not null) as selesai ,
				cetak_kwitansi ,
				sum(vtot) as vtot,
				(SELECT tanggal_isi FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = min(a.id_pemeriksaan_rad) LIMIT 1) AS tgl_baca
			FROM
				pemeriksaan_radiologi a,
				data_pasien
			WHERE
				a.no_medrec = data_pasien.no_medrec
				AND cetak_hasil = '1'
				AND no_rad is not null
				AND  a.no_register LIKE '%$key%'
			GROUP BY
				no_rad,nama ,
				a.no_medrec ,
				a.no_register ,
				tgl,
				cetak_kwitansi
			ORDER BY
				tgl asc");
		}

		function get_hasil_rad_by_no_selesai_new($key){
			return $this->db->query("SELECT
				nama ,
				a.accesion_number,
				a.jenis_tindakan,
				a.id_pemeriksaan_rad,
				a.no_medrec ,
				a.no_rad ,
				a.no_register ,
				a.tgl_kunjungan as tgl ,
				cetak_kwitansi ,
				data_pasien.no_cm,
				data_pasien.no_hp,
				data_pasien.email,
				b.tanggal_isi AS tgl_baca,
				a.tgl_generate
			FROM
				pemeriksaan_radiologi a ,
				data_pasien,
				hasil_pemeriksaan_rad b
			WHERE
				a.no_medrec = data_pasien.no_medrec
				AND a.id_pemeriksaan_rad = b.id_pemeriksaan_rad
				and substr(A.no_register,1,2) <> 'PL'
				AND no_rad is not null 
				AND (data_pasien.no_cm LIKE '%$key%' OR data_pasien.nama LIKE '%$key%') UNION 
			SELECT
				nama,
				a.accesion_number,
				a.jenis_tindakan,
				a.id_pemeriksaan_rad,
				a.no_medrec ,
				a.no_rad ,
				a.no_register ,
				a.tgl_kunjungan as tgl ,
				a.cetak_kwitansi ,
				CAST(pasien_luar.no_cm AS VARCHAR),
				pasien_luar.no_hp,
				pasien_luar.email,
				c.tanggal_isi AS tgl_baca,
				a.tgl_generate
			FROM
				pemeriksaan_radiologi a ,
				pasien_luar,
				hasil_pemeriksaan_rad c
			WHERE
				a.no_register = pasien_luar.no_register
				AND a.id_pemeriksaan_rad = c.id_pemeriksaan_rad
				AND no_rad is not null 
				AND (CAST(pasien_luar.no_cm AS VARCHAR) LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
			ORDER BY
				tgl DESC");

			// return $this->db->query("SELECT
			// 	nama,
			// 	a.accesion_number,
			// 	a.no_medrec ,
			// 	a.no_rad ,
			// 	a.no_register ,
			// 	a.tgl_kunjungan as tgl_baca ,
			// 	count(1) as banyak ,
			// 	(
			// 		SELECT
			// 			COUNT(hasil_periksa) as hasil
			// 		FROM
			// 			pemeriksaan_radiologi
			// 		WHERE
			// 			no_rad = a.no_rad
			// 		AND hasil_periksa is not null
			// 	) as selesai ,
			// 	cetak_kwitansi ,
			// 	sum(vtot) as vtot,
			// 	data_pasien.no_cm,
			// 	data_pasien.no_hp,
			// 	data_pasien.email
			// FROM
			// 	pemeriksaan_radiologi a ,
			// 	data_pasien
			// WHERE
			// 	a.no_medrec = data_pasien.no_medrec
			// AND cetak_hasil = '1'
			// and substr(A.no_register,1,2) <> 'PL'
			// AND no_rad is not null 
			// AND (data_pasien.no_cm LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
			// GROUP BY
			// 	no_rad,nama ,
			// 	a.no_medrec ,
			// 	a.no_register ,
			// 	tgl_baca,
			// 	cetak_kwitansi,										
			// a.accesion_number,
			// data_pasien.no_cm,
			// data_pasien.no_hp,
			// data_pasien.email
			// 		UNION 
			// 		SELECT
			// 	nama,
			// a.accesion_number,
			// 	a.no_medrec ,
			// 	a.no_rad ,
			// 	a.no_register ,
			// 	a.tgl_kunjungan as tgl_baca ,
			// 	count(1) as banyak ,
			// 	(
			// 		SELECT
			// 			COUNT(hasil_periksa) as hasil
			// 		FROM
			// 			pemeriksaan_radiologi
			// 		WHERE
			// 			no_rad = a.no_rad
			// 		AND hasil_periksa is not null
			// 	) as selesai ,
			// 	a.cetak_kwitansi ,
			// 	sum(vtot) as vtot,
			// 	CAST(pasien_luar.no_cm AS VARCHAR),
			// 	pasien_luar.no_hp,
			// 	pasien_luar.email
			// FROM
			// 	pemeriksaan_radiologi a ,
			// 	pasien_luar
			// WHERE
			// 	a.no_register = pasien_luar.no_register
			// AND cetak_hasil = '1'
			// AND no_rad is not null 
			// AND (CAST(pasien_luar.no_cm AS VARCHAR) LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
			// GROUP BY
			// 	no_rad,nama ,
			// 	a.no_medrec ,
			// 	a.no_register ,
			// 	tgl_baca,
			// 	a.cetak_kwitansi,										
			// a.accesion_number,
			// CAST(pasien_luar.no_cm AS VARCHAR),
			// pasien_luar.no_hp,
			// pasien_luar.email
			// ORDER BY
			// 		tgl_baca DESC");
		}

		function getnm_dokter_rj($no_register){
			return $this->db->query("SELECT b.nm_dokter FROM daftar_ulang_irj as a
				LEFT JOIN data_dokter as b
				ON b.id_dokter=a.id_dokter
				WHERE no_register='$no_register'");
		}

		function getnm_dokter_ri($no_register){
			return $this->db->query("SELECT dokter as nm_dokter FROM pasien_iri
				WHERE no_ipd='$no_register'");
		}

		public function insert_file_hasil($data = array()){
	        $insert = $this->db->insert_batch('hasil_pemeriksaan_rad_detail',$data);
	        return $insert?true:false;
	    }

		function insert_data_soap($data){
			$this->db->insert('soap_pasien_rj', $data);
			return true;
		}
		
		function update_data_soap($data,$id){
			$this->db->where('id',$id);
			$this->db->update('soap_pasien_rj', $data);
			return true;
		}
	
		function getdata_tindakan_fisik($no_register)
		{
			return $this->db->query("SELECT 
				*
			FROM 
				pemeriksaan_fisik 
			where 
				no_register='" . $no_register . "'");
		}

		function cek_radiologirj($no_register)
		{
			return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='".$no_register."'");
		}

		function cek_radiologi($no_register){
			return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='$no_register' AND DATE(tgl_input) = current_date ORDER BY tgl_input DESC");
		}

		function get_diagnosa_by_noreg_rj($no_register){
			return $this->db->query("SELECT * FROM diagnosa_pasien WHERE no_register='".$no_register."'");
		}

		function get_nama_diagnosa($id_icd){
			return $this->db->query("SELECT * FROM icd1 WHERE id_icd='".$id_icd."'");
		}

		function get_data_pasien_iri($no_register){
			return $this->db->query("SELECT * FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function edit_dokter_pemeriksaan_rad($no_register, $data){
			$this->db->where('no_register', $no_register);
			$this->db->update('pemeriksaan_radiologi', $data);
			return true;
		}

		function get_satuan(){
			return $this->db->query("SELECT nm_satuan FROM obat_satuan ORDER BY nm_satuan ASC");
		}

		function get_obat_rad(){
			return $this->db->query("SELECT * FROM gudang_inventory  a
			inner join master_obat b on a.id_obat = b.id_obat
			where a.id_gudang = '1'
			and b.id_obat = '2002'   ");
		}

		function get_data_obat_resep_rad($no_register){
			return $this->db->query("SELECT * FROM resep_pasien
			where no_register = '$no_register'
			and item_obat = '2002'   ");
		}

		function hapus_resep_rad($no_register,$id_resep_pasien){
			return $this->db->query("DELETE FROM resep_pasien
			where no_register = '$no_register'
			and id_resep_pasien = '$id_resep_pasien'
			and item_obat = '2002'   ");
		}

		function get_idpoli($nm_poli){
			return $this->db->query("SELECT * FROM poliklinik where nm_poli = '$nm_poli' ");
		}

		public function get_detail_tindakan($id_tindakan){
			return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
			and b.kelas='NK'");
		}

		function get_data_pasien_form_pacs($nocm)
		{
			return $this->db->query("SELECT a.nama,a.sex,a.tgl_lahir FROM data_pasien as a
			where a.no_cm='$nocm'");
		}
		
		function get_data_pasien_form_pacs_luar($nocm)
		{
			return $this->db->query("SELECT a.nama,a.jk as sex,a.tgl_lahir FROM pasien_luar as a
			where a.no_register='$nocm'");
		}

		function get_dpjp_by_noreg($noreg)
		{
			return $this->db->query("SELECT a.id_dokter,b.nm_dokter
			FROM daftar_ulang_irj as a LEFT JOIN data_dokter as
			b on a.id_dokter = b.id_dokter");
		}

		function get_no_lab_last($noreg)
		{
			return $this->db->query("SELECT * from pemeriksaan_laboratorium where no_register = '$noreg' order by tgl_kunjungan desc limit 1");
		}
		
		function update_rujukan_penunjang_irj($data, $no_register){
			if($no_register == null){
				return false;
			}else{
				$this->db->where('no_register',$no_register);
				$this->db->update('daftar_ulang_irj', $data);
				return true;
			}						
		}
		
		function update_rujukan_penunjang_iri($data, $no_ipd){
			if($no_ipd == null){
				return false;
			}else{
				$this->db->where('no_ipd',$no_ipd);
				$this->db->update('pasien_iri', $data);
				return true;
			}						
		}

		function get_data_pasien_by_noreg($noreg){
			return $this->db->query("SELECT data_pasien.no_identitas,data_pasien.sex,TO_CHAR(data_pasien.tgl_lahir, 'YYYY-MM-DD') as tgl_lahir,cast(data_pasien.no_cm as integer) AS no_cm,a.no_medrec,a.no_register,data_pasien.nama,data_pasien.alamat AS alamat,a.tgl_kunjungan AS tgl,a.kelas,a.cara_bayar,a.idrg AS ruang FROM pemeriksaan_radiologi a,data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_register='$noreg' limit 1 ");				
		}

		function get_data_pasien_order_bhp($noreg) {
			return $this->db->query("SELECT
				data_pasien.no_identitas,
				data_pasien.sex,
				CAST ( data_pasien.no_cm AS INTEGER ) AS no_cm,
				A.no_medrec,
				A.no_register,
				data_pasien.nama,
				data_pasien.alamat AS alamat,
				A.tgl_kunjungan AS tgl,
				A.kelas,
				A.cara_bayar,
				A.idrg AS ruang,
				a.bed,
				b.dokter AS dokter,
				b.id_dokter,
				d.ttd,
				data_pasien.tgl_lahir
			FROM
				pemeriksaan_radiologi A,
				data_pasien,
				pasien_iri AS b,
				dyn_user_dokter AS c,
				hmis_users AS d
			WHERE
				A.no_medrec = data_pasien.no_medrec 
				AND A.no_register = b.no_ipd
				AND b.id_dokter = c.id_dokter
				AND d.userid = c.userid 
				AND A.id_pemeriksaan_rad = '$noreg' UNION
			SELECT
				data_pasien.no_identitas,
				data_pasien.sex,
				CAST ( data_pasien.no_cm AS INTEGER ) AS no_cm,
				A.no_medrec,
				A.no_register,
				data_pasien.nama,
				data_pasien.alamat AS alamat,
				A.tgl_kunjungan AS tgl,
				A.kelas,
				A.cara_bayar,
				A.idrg AS ruang,
				a.bed,
				C.nm_dokter AS dokter,
				b.id_dokter,
				e.ttd,
				data_pasien.tgl_lahir
			FROM
				pemeriksaan_radiologi A,
				data_pasien,
				daftar_ulang_irj AS b,
				data_dokter AS C,
				dyn_user_dokter AS d,
				hmis_users AS e
			WHERE
				A.no_medrec = data_pasien.no_medrec 
				AND A.no_register = b.no_register 
				AND b.id_dokter = C.id_dokter
				AND b.id_dokter = d.id_dokter
				AND d.userid = e.userid 
				AND A.id_pemeriksaan_rad = '$noreg' UNION
			SELECT
				b.nik AS no_identitas,
				b.jk AS sex,
				b.no_cm AS no_cm,
				b.no_cm AS no_medrec,
				A.no_register,
				b.nama,
				b.alamat AS alamat,
				A.tgl_kunjungan AS tgl,
				A.kelas,
				A.cara_bayar,
				A.idrg AS ruang,
				a.bed,
				b.dokter AS dokter,
				b.no_cm AS id_dokter,
				b.nmkontraktor AS ttd,
				b.tgl_lahir
			FROM
				pemeriksaan_radiologi A,
				pasien_luar AS b
			WHERE
				A.no_register = b.no_register 
				AND A.id_pemeriksaan_rad = '$noreg'
				LIMIT 1");
		}

		function get_jenis_tindakan($id_pemeriksaan) {
			return $this->db->query("SELECT jenis_tindakan FROM pemeriksaan_radiologi WHERE id_pemeriksaan_rad = '$id_pemeriksaan'");
		}

		function get_data_pasien_order($noreg) {
			return $this->db->query("SELECT
				data_pasien.no_identitas,
				data_pasien.sex,
				CAST ( data_pasien.no_cm AS INTEGER ) AS no_cm,
				A.no_medrec,
				A.no_register,
				data_pasien.nama,
				data_pasien.alamat AS alamat,
				A.tgl_kunjungan AS tgl,
				A.kelas,
				A.cara_bayar,
				A.idrg AS ruang,
				a.bed,
				b.dokter AS dokter,
				b.id_dokter,
				d.ttd,
				data_pasien.tgl_lahir
			FROM
				pemeriksaan_radiologi A,
				data_pasien,
				pasien_iri AS b,
				dyn_user_dokter AS c,
				hmis_users AS d
			WHERE
				A.no_medrec = data_pasien.no_medrec 
				AND A.no_register = b.no_ipd
				-- AND b.id_dokter = c.id_dokter
				AND d.userid = c.userid 
				AND A.no_register = '$noreg' UNION
			SELECT
				data_pasien.no_identitas,
				data_pasien.sex,
				CAST ( data_pasien.no_cm AS INTEGER ) AS no_cm,
				A.no_medrec,
				A.no_register,
				data_pasien.nama,
				data_pasien.alamat AS alamat,
				A.tgl_kunjungan AS tgl,
				A.kelas,
				A.cara_bayar,
				A.idrg AS ruang,
				a.bed,
				C.nm_dokter AS dokter,
				b.id_dokter,
				e.ttd,
				data_pasien.tgl_lahir
			FROM
				pemeriksaan_radiologi A,
				data_pasien,
				daftar_ulang_irj AS b,
				data_dokter AS C,
				dyn_user_dokter AS d,
				hmis_users AS e
			WHERE
				A.no_medrec = data_pasien.no_medrec 
				AND A.no_register = b.no_register 
				AND b.id_dokter = C.id_dokter
				-- AND b.id_dokter = d.id_dokter
				AND d.userid = e.userid 
				AND A.no_register = '$noreg'
				LIMIT 1");
		}

		function get_diagnosa_order($noreg) {
			return $this->db->query("SELECT
				id_diagnosa,
				diagnosa,
				klasifikasi_diagnos 
			FROM
				diagnosa_iri 
			WHERE
				no_register = '$noreg' UNION
			SELECT
				id_diagnosa,
				diagnosa,
				klasifikasi_diagnos 
			FROM
				diagnosa_pasien 
			WHERE
				no_register = '$noreg'");
		}

		function get_data_pemeriksaan_by_noreg($noreg){
			return $this->db->query("SELECT jenis_tindakan, id_tindakan,tgl_kunjungan,xinput,jadwal, komen FROM pemeriksaan_radiologi WHERE no_register='$noreg' and (to_char(tgl_kunjungan,'YYYY-MM-DD') = to_char(now(),'YYYY-MM-DD') or tgl_kunjungan is null) order by tgl_kunjungan asc ");
		}
		function get_data_pemeriksaan_by_noreg_new($noreg){
			return $this->db->query("SELECT jenis_tindakan, id_tindakan,tgl_kunjungan,xinput,jadwal, komen FROM pemeriksaan_radiologi WHERE no_register='$noreg' and (to_char(tgl_kunjungan,'YYYY-MM-DD') = to_char(now(),'YYYY-MM-DD') or tgl_kunjungan is null) and tgl_generate is null order by tgl_kunjungan asc ");
		}

		function get_data_pemeriksaan_bhp($id_pemeriksaan) {
			return $this->db->query("SELECT
				a.jenis_tindakan,
				a.id_tindakan,
				a.alasan_ulang,
				b.*
			FROM
				pemeriksaan_radiologi AS a,
				bhp_radiologi AS b
			WHERE
				a.id_pemeriksaan_rad = b.id_pemeriksaan_rad
				AND a.id_pemeriksaan_rad = '$id_pemeriksaan'");
		}

		function get_ttd_by_userid($userid){
			return $this->db->query("SELECT name,ttd from hmis_users where userid = '$userid' ");
		}

		function getdata_deskripsi_rad(){
			return $this->db->query("SELECT * from master_desk_rad order by judul asc ");
		}

		function getdata_deskripsi_rad_detail($id){
			return $this->db->query("SELECT * from master_desk_rad where id = '$id' ");
		}

		function batal_kunjungan($no_register){
			if(substr($no_register,0,2) == 'RJ'){
				return $this->db->query("UPDATE daftar_ulang_irj set rad = '0' where no_register='$no_register' ");
			}elseif(substr($no_register,0,2) == 'RI'){
				return $this->db->query("UPDATE pasien_iri set rad = '0' where no_ipd='$no_register' ");
			}else{
				return $this->db->query("DELETE FROM pasien_luar where no_register='$no_register' ");
			}

		}

		function delete_order_batal($no_register){
			return $this->db->query("DELETE FROM pemeriksaan_radiologi where no_register = '$no_register' and no_rad is null ");
		}

		function get_data_bius($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi where no_register = '$no_register' and no_rad is null  ");
		}
		
		function get_data_pemeriksaan_by_reg_PACSMAN($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register='$no_register' and no_rad is null and id_tindakan != 'BA0312' ");
		}

		function get_data_pemeriksaan_by_reg_PACSMAN_new($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register='$no_register' and no_rad is not null and id_tindakan != 'BA0312' ");
		}

		function delete_order_batalsdada($no_register,$no_rad){
			return $this->db->query("DELETE FROM pemeriksaan_radiologi 
			where no_register = '$no_register' and no_rad = '$no_rad' ");
		}
		
		function get_radiografer() {
			return $this->db->query("SELECT A
				.userid,
				b.roleid,
				b.ROLE,
				A.NAME,
				A.username
			FROM
				hmis_users AS A,
				dyn_role_user AS b 
			WHERE
				A.userid = b.userid 
				AND b.roleid = 1016 ");
		}

		function get_data_pemeriksaan_rad($id) {
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE id_pemeriksaan_rad = CAST('$id' AS INT)");
		}

		function get_data_pemeriksaan_rad_by_noreg($no_register) {
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register = '$no_register'");
		}

		function get_data_pemeriksaan_rad_by_noreg_pl($no_register) {
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register = '$no_register'");
		}

		function tunda_tindakan_pl($noreg, $data) {
			$this->db->where('no_register', $noreg);
			$this->db->update('pasien_luar', $data);
			return true;
		}

		function tunda_tindakan_rj($noreg, $data) {
			$this->db->where('no_register', $noreg);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}

		function tunda_tindakan_ri($noreg, $data) {
			$this->db->where('no_ipd', $noreg);
			$this->db->update('pasien_iri', $data);
			return true;
		}

		function update_waktu_masuk_rj($noreg, $data) {
			$this->db->where('no_register', $noreg);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}

		function update_waktu_masuk_ri($noreg, $data) {
			$this->db->where('no_ipd', $noreg);
			$this->db->update('pasien_iri', $data);
			return true;
		}

		function update_waktu_masuk_pl($noreg, $data) {
			$this->db->where('no_register', $noreg);
			$this->db->update('pasien_luar', $data);
			return true;
		}

		function insert_petugas_tindakan($noreg, $data) {
			$this->db->where('id_pemeriksaan_rad', $noreg);
			$this->db->update('pemeriksaan_radiologi', $data);
			return true;
		}

		function insert_catatan_bhp($noreg, $data) {
			$this->db->where('id_pemeriksaan_rad', $noreg);
			$this->db->update('pemeriksaan_radiologi', $data);
			return true;
		}

		function insert_ulang_tindakan($noreg, $data) {
			$this->db->where('id_pemeriksaan_rad', $noreg);
			$this->db->update('pemeriksaan_radiologi', $data);
			return true;
		}

		function get_id_pemeriksaan_rad_for_jadwal($noreg) {
			return $this->db->query("SELECT
				* 
			FROM
				pemeriksaan_radiologi 
			WHERE
				no_register = '$noreg' 
				AND tgl_kunjungan IS NULL 
				AND no_rad IS NULL");
		}

		function insert_jadwal_rad_iri($no_register, $data) {
			$this->db->where('no_ipd', $no_register);
			$this->db->update('pasien_iri', $data);
			return true;
		}

		function insert_jadwal_rad_irj($no_register, $data) {
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}

		function get_data_pasien($no_cm) {
			return $this->db->query("SELECT * FROM data_pasien WHERE no_cm = '$no_cm'");
		}

		function get_tindakan_bius($kelas) {
			return $this->db->query("SELECT A
				.*,
				b.* 
			FROM
				jenis_tindakan AS A,
				tarif_tindakan AS b 
			WHERE
				A.idtindakan = b.id_tindakan 
				AND b.kelas != 'NA' 
				AND a.idtindakan = 'BA0312' 
				AND b.kelas = '$kelas' 
			ORDER BY
				A.nmtindakan ASC");
		}

		function get_dokter_anestesi() {
			return $this->db->query("SELECT A
				.userid,
				b.nm_dokter,
				a.id_dokter
			FROM
				dyn_user_dokter AS A,
				data_dokter AS b 
			WHERE
				a.id_dokter = b.id_dokter AND
				A.userid IN ( 1466, 1020 )");
		}

		function get_dokter_rad() {
			return $this->db->query("SELECT A
				.userid,
				b.nm_dokter,
				a.id_dokter
			FROM
				dyn_user_dokter AS A,
				data_dokter AS b 
			WHERE
				a.id_dokter = b.id_dokter AND
				A.userid IN ( 1083, 1084 )");
		}

		function update_flag_pengisian($id_pemeriksaan_rad, $data3) {
			$this->db->where('id_pemeriksaan_rad', $id_pemeriksaan_rad);
			$this->db->update('pemeriksaan_radiologi', $data3);
			return true;
		}

		function update_flag_pacs($id_pemeriksaan_rad) {
			return $this->db->query("UPDATE pemeriksaan_radiologi SET hasil_pacs = 1 WHERE id_pemeriksaan_rad = '$id_pemeriksaan_rad'");
		}

		function get_pasien_by_no_ipd($no_ipd) {
			return $this->db->query("SELECT A
				.nama,
				b.no_register,
				b.no_medrec,
				a.tgl_lahir,
				a.no_identitas,
				a.sex
			FROM
				data_pasien AS A,
				daftar_ulang_irj AS b
			WHERE
				a.no_medrec = b.no_medrec
				AND b.no_register = '$no_ipd'
			UNION
				SELECT A
				.nama,
				b.no_ipd,
				b.no_medrec,
				a.tgl_lahir,
				a.no_identitas,
				a.sex
			FROM
				data_pasien AS A,
				pasien_iri AS b
			WHERE
				a.no_medrec = b.no_medrec
				AND b.no_ipd = '$no_ipd'
			UNION
				SELECT A
				.nama,
				a.no_register,
				a.no_cm AS no_medrec,
				a.tgl_lahir,
				a.nik AS no_identitas,
				a.jk AS sex
			FROM
				pasien_luar AS A
			WHERE
				a.no_register = '$no_ipd'");
		}

		function update_pasien_luar($data, $no_register) {
			$this->db->where('no_register', $no_register);
			$this->db->update('pasien_luar', $data);
			return true;
		}

		function batal_pemeriksaan($id_pemeriksaan) {
			$this->db->where('id_pemeriksaan_rad', $id_pemeriksaan);
			$this->db->delete('pemeriksaan_radiologi');
			return true;
		}

		function get_data_titip_iri($no_register) {
			return $this->db->query("SELECT titip, jatahklsiri FROM pasien_iri WHERE no_ipd = '$no_register'");
		}

		function get_no_register_by_id_pemeriksaan($id_pemeriksaan) {
			return $this->db->query("SELECT no_register FROM pemeriksaan_radiologi WHERE id_pemeriksaan_rad = '$id_pemeriksaan'");
		}

		function get_data_pemeriksaan_by_id_pemeriksaan($id_pemeriksaan) {
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE id_pemeriksaan_rad = '$id_pemeriksaan' and no_rad is not null ");
		}

		//start
		//update data di db manual
		function get_update_flag_dokter() {
			return $this->db->query("SELECT
				a.id_pemeriksaan_rad
			FROM
				pemeriksaan_radiologi AS a,
				hasil_pemeriksaan_rad AS b
			WHERE
				to_char( a.jadwal, 'YYYY-MM' ) = '2023-01'
				AND a.id_pemeriksaan_rad = b.id_pemeriksaan_rad
				AND a.hasil_simpan is null");
		}

		function update_flag_hasil_simpan($id_pemeriksaan, $data) {
			$this->db->where('id_pemeriksaan_rad', $id_pemeriksaan);
			$this->db->update('pemeriksaan_radiologi', $data);
			return true;
		}
		//end

		function selesai_daftar_pemeriksaan_IRJ_new($no_register,$getvtotrad,$no_rad){
			if($getvtotrad == ''){
				$vtot_rad = 0;
			}else{
				$vtot_rad = $getvtotrad;
			}
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET rad=0, status_rad=1, vtot_rad='$vtot_rad' WHERE no_register='$no_register'");
			return true;
		}
	
		function selesai_daftar_pemeriksaan_IRD_new($no_register,$getvtotrad,$no_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad' WHERE no_register='$no_register'");
			$this->db->query("UPDATE irddaftar_ulang SET rad=0, status_rad=1, vtot_rad='$getvtotrad' WHERE no_register='$no_register'");
			return true;
		}
	
		function selesai_daftar_pemeriksaan_IRI_new($no_register,$status_rad,$vtot_rad,$no_rad){
			if($vtot_rad == ''){
				$harga_rad = 0;
			}else{
				$harga_rad = $vtot_rad;
			}
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad' WHERE no_register='$no_register' and no_rad is null");
			$this->db->query("UPDATE pasien_iri SET rad=0, status_rad='$status_rad', vtot_rad='$harga_rad' WHERE no_ipd='$no_register'");
			return true;
		}

		function getdata_tindakan_request(){
			return $this->db->query("SELECT * FROM rad_tindakan_request");
		}

		function getdata_tindakan_request_kel(){
			return $this->db->query("SELECT kel_tindakan FROM rad_tindakan_request GROUP BY kel_tindakan");
		}
	}

	
?>