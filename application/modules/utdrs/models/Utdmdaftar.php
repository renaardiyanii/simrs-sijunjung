<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Utdmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		} 
    
        function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT *  FROM pemeriksaan_utdrs, data_pasien WHERE pemeriksaan_utdrs.no_medrec=data_pasien.no_medrec AND pemeriksaan_utdrs.no_register='$no_register'");
		}

		function get_daftar_pasien_pa_by_date($date){
			return $this->db->query("SELECT
				pemeriksaan_utdrs.no_register,
				data_pasien.no_cm AS no_medrec,
				pemeriksaan_utdrs.tgl_kunjungan,
				pemeriksaan_utdrs.kelas,
				pemeriksaan_utdrs.idrg,
				pemeriksaan_utdrs.bed,
				data_pasien.nama AS nama 
			FROM
				pemeriksaan_utdrs,
				data_pasien 
			WHERE
				pemeriksaan_utdrs.no_medrec = data_pasien.no_medrec 
				AND to_char( pemeriksaan_utdrs.tgl_kunjungan, 'YYYY-MM-DD' ) = '$date' 
				AND pemeriksaan_utdrs.utdrs = '1'");
		}

        function get_data_pasien_kontraktor_irj($no_register){
			return $this->db->query("SELECT nmkontraktor FROM daftar_ulang_irj, kontraktor WHERE daftar_ulang_irj.id_kontraktor=kontraktor.id_kontraktor AND daftar_ulang_irj.no_register='$no_register'");
		}

        function get_data_pasien_kontraktor_iri($no_register){
			return $this->db->query("SELECT nmkontraktor FROM pasien_iri, kontraktor WHERE pasien_iri.id_kontraktor=kontraktor.id_kontraktor AND pasien_iri.no_ipd='$no_register'");
		}

		function get_data_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_unitdarah WHERE no_register='$no_register' AND no_utdrs IS NULL");
		}

		function getdata_tindakan_utdrs(){
			return $this->db->query("SELECT * FROM jenis_tindakan_new where instalasi = 'UTDRS' ORDER BY nmtindakan asc");
		}

		function get_roleid($userid){
			return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT A
					.id_dokter,
					A.nm_dokter 
				FROM
					data_dokter
					AS A LEFT JOIN dokter_poli AS b ON A.id_dokter = b.id_dokter 
				WHERE
				A.deleted =0");
		}

		function insert_pemeriksaan($data)
		{
			$this->db->insert('pemeriksaan_unitdarah', $data);
			return true;
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."' ");
		}

		function getjenis_tindakan($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan_new WHERE idtindakan='".$id_tindakan."' ");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_utd){
			$this->db->where('id_pemeriksaan_utdrs', $id_pemeriksaan_utd);
       		$this->db->delete('pemeriksaan_unitdarah');			
			return true;
		}

		function update_rujukan_penunjang_irj($data, $no_register)
		{
			if ($no_register == null) {
				return false;
			} else {
				$this->db->where('no_register', $no_register);
				$this->db->update('daftar_ulang_irj', $data);
				return true;
			}
		}

		function update_rujukan_penunjang_iri($data, $no_ipd)
		{
			if ($no_ipd == null) {
				return false;
			} else {
				$this->db->where('no_ipd', $no_ipd);
				$this->db->update('pasien_iri', $data);
				return true;
			}
		}

		function get_vtot_utd($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_utd FROM pemeriksaan_unitdarah WHERE no_register='".$no_register."'");
		}

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO utdrs_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_utdrs FROM utdrs_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_utdrs DESC LIMIT 1");
		}

		
		function selesai_daftar_pemeriksaan_IRJ($no_register,$no_utdrs){
			$this->db->query("UPDATE pemeriksaan_unitdarah SET no_utdrs='$no_utdrs' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET utdrs=0, status_utdrs=1 WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$no_utdrs){
			$this->db->query("UPDATE pemeriksaan_unitdarah SET no_utdrs='$no_utdrs' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET utdrs=0, status_utdrs=1 WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$status_pa,$no_utdrs){
			$this->db->query("UPDATE pemeriksaan_unitdarah 
				SET no_utdrs = COALESCE(no_utdrs, '$no_utdrs') 
				WHERE no_register = '$no_register';");
			$this->db->query("UPDATE pasien_iri SET utdrs=0, status_utdrs='$status_pa' WHERE no_ipd='$no_register'");
			return true;
		}

		function get_vtot_no_utdrs($no_utdrs){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_utdrs FROM pemeriksaan_unitdarah WHERE no_utdrs='".$no_utdrs."'");
		}

		function get_data_pasien($no_utdrs){
			return $this->db->query("
			SELECT 
					dp.no_cm AS no_cm, 
					a.no_medrec, 
					a.no_register, 
					dp.nama, 
					dp.alamat AS alamat, 
					a.tgl_kunjungan AS tgl, 
					a.kelas, 
					a.cara_bayar, 
					a.idrg AS ruang, 
					DATE_PART('day', a.tgl_kunjungan - dp.tgl_lahir) AS tgl_lahir 
				FROM 
					pemeriksaan_unitdarah a
				JOIN 
					data_pasien dp ON a.no_medrec::int = dp.no_medrec 
				WHERE 
					a.no_utdrs = $no_utdrs
				GROUP BY 
					a.no_utdrs, dp.no_cm, a.no_medrec, a.no_register, dp.nama, dp.alamat, 
					a.tgl_kunjungan, a.kelas, a.cara_bayar, a.idrg, dp.tgl_lahir;

			");
		}

		function get_data_pemeriksaan_faktur($no_utdrs){
			return $this->db->query("SELECT jenis_tindakan, biaya_utd, qty, vtot FROM pemeriksaan_unitdarah WHERE no_utdrs='$no_utdrs'");
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_utdrs FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}
}