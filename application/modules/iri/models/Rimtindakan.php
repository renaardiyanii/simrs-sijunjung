<?php
class Rimtindakan extends CI_Model
{
	var $diagnosa_order = array(null, 'klasifikasi_diagnos', 'id_diagnosa');
	var $diagnosa_search = array('diagnosa_iri.klasifikasi_diagnos', 'diagnosa_iri.id_diagnosa', 'diagnosa_iri.diagnosa');
	var $default_order_diagnosa = array('diagnosa_iri.klasifikasi_diagnos' => 'desc', 'diagnosa_iri.id_diagnosa_pasien' => 'desc');

	var $procedure_order = array(null, 'klasifikasi_procedure', 'id_procedure');
	var $procedure_search = array('icd9cm_iri.id_procedure', 'icd9cm_iri.klasifikasi_procedure', 'icd9cm_iri.nm_procedure');
	var $default_order_procedure = array('icd9cm_iri.klasifikasi_procedure' => 'desc', 'icd9cm_iri.id' => 'desc');

	//ini buat save bener bener //

	public function insert_tindakan($data)
	{
		$this->db->insert('pelayanan_iri', $data);
	}

	//end hapus komengnya

	public function insert_tindakan_real($data)
	{
		$querynoantrian = "(SELECT IFNULL(CONCAT('T', LPAD (max(right(id_jns_layanan2,7))+1 ,7,0) ),'T0000001') 
						FROM (SELECT * FROM pelayanan_iri) AS a)";
		// $this->db->set('id_jns_layanan', $querynoantrian , FALSE);
		return $this->db->insert('pelayanan_iri', $data);
	}

	public function select_icd_1_like($value)
	{

		// $data=$this->db->query("select *
		// 	from icd1 as a
		// 	where a.nm_diagnosa like '%$value%'
		// 	order by nm_diagnosa asc
		// 	");

		// $data=$this->db->query("select *
		// 	from icd1 as a
		// 	where a.id_icd like '%$value%'
		// 	order by id_icd asc
		// 	");

		// $data=$this->db->query("
		// 			SELECT * from (
		// 			select *
		// 			from icd1 as a
		// 			where a.id_icd like '%$value%'
		// 			UNION
		// 			select *
		// 			from icd1 as b
		// 			where b.nm_diagnosa like '%$value%') c
		// 			GROUP BY c.id_icd
		// 			limit 20
		// 	");
		$data = $this->db->query("SELECT * FROM icd1 WHERE id_icd LIKE '%$value%'
					UNION
					SELECT * FROM icd1 WHERE nm_diagnosa LIKE '%$value%' limit 20");
		return $data->result_array();
	}

	public function select_all_tindakan()
	{
		$data = $this->db->query("select * from pelayanan_iri");
		return $data->result_array();
	}

	public function delete_pelayanan_iri_temp($no_ipd)
	{
		$data = $this->db->query("
			DELETE FROM pelayanan_iri_temp
			WHERE no_ipd = '$no_ipd' ; 
			");
	}

	public function delete_pelayanan_iri_temp_by_id($id)
	{
		$data = $this->db->query("
			DELETE FROM pelayanan_iri_temp
			WHERE id_jns_layanan = '$id' ; 
			");
	}

	public function delete_pelayanan_iri_by_id($id)
	{
		$data = $this->db->query("
			DELETE FROM pelayanan_iri
			WHERE id_jns_layanan = '$id' ; 
			");
	}

	public function select_all_tindakan_temp()
	{
		$data = $this->db->query("select * from pelayanan_iri_temp");
		return $data->result_array();
	}

	function hapus_konsul_pasien_iri($id)
	{
		$this->db->query("DELETE FROM konsultasi_pasien_iri WHERE CAST(id AS VARCHAR) = '$id'");
		return true;
	}

	function hapus_data_dokter_konsul_pasien_iri($no_ipd, $id_dokter_penerima)
	{
		$this->db->query("DELETE FROM drtambahan_iri WHERE no_register = '$no_ipd' AND id_dokter = '$id_dokter_penerima'");
		return true;
	}

	public function select_tindakan_temp_by_id($id_jns_layanan)
	{
		$data = $this->db->query("select * 
			from pelayanan_iri_temp
			where id_jns_layanan = '$id_jns_layanan'
			");
		return $data->result_array();
	}

	public function select_tindakan_by_id($id_jns_layanan)
	{
		$data = $this->db->query("select * 
			from pelayanan_iri
			where id_jns_layanan = '$id_jns_layanan'
			");
		return $data->result_array();
	}

	function get_rujukan_penunjang($no_ipd)
	{
		return $this->db->query("SELECT 
	COALESCE(ok,'0')as ok, 
	COALESCE(lab,'0') as lab, 
	COALESCE(rad,'0') as rad, 
	COALESCE(em,'0') as em, 
	COALESCE(pa,'0') as pa, 
	COALESCE(obat,'0') as obat, 
	COALESCE(status_ok,'0') as status_ok, 
	COALESCE(status_lab,'0') as status_lab, 
	COALESCE(status_pa,'0') as status_pa, 
	COALESCE(status_rad,'0') as status_rad, 
	COALESCE(status_em,'0') as status_em, 
	COALESCE(status_obat,'0') as status_obat 
FROM pasien_iri 
WHERE no_ipd='$no_ipd' order by tgldaftarri DESC
Limit 1");
	}
	function update_rujukan_penunjang($data, $no_ipd)
	{
		/*$this->db->where('no_ipd', $no_ipd)
				->update('pasien_iri', $data);*/
		if ($no_ipd == null) {
			return false;
		} else {
			$this->db->where('no_ipd', $no_ipd);
			$this->db->update('pasien_iri', $data);
			return true;
		}
	}



	public function get_list_tindakan_pasien_by_no_ipd_temp($no_ipd)
	{
		// $data=$this->db->query("
		// 	select * 
		// 	from pelayanan_iri_temp as a inner join data_pasien as b on a.nomederec = b.no_medrec
		// 	inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
		// 	where a.no_ipd = '$no_ipd' 
		// 	order by tgl_layanan asc");

		// $data=$this->db->query("
		// 	select *, (SELECT nmruang from ruang where idrg=a.idrg) as nmruang,a.xuser as user_input, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nmdokter
		// 	from pelayanan_iri_temp as a inner join data_pasien as b on a.nomederec = b.no_medrec
		// 	inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
		// 	where a.no_ipd = '$no_ipd' 
		// 	order by tgl_layanan asc");
		// return $data->result_array();

		$data = $this->db->query("
		select *,a.xuser as nm_pelaksana, (SELECT nmruang from ruang where idrg=a.idrg LIMIT 1) 
		as nmruang,a.xuser as user_input, 
		 (select ttd from hmis_users where userid=CAST(a.idoprtr AS INTEGER)) as ttd_pelaksana
		 			from pelayanan_iri_temp as a inner join data_pasien as 
		 			b on CAST(a.nomederec AS INTEGER) = b.no_medrec
		 			inner join jenis_tindakan_new as c on a.id_tindakan = c.idtindakan
		 			where a.no_ipd = '$no_ipd' 
		 			order by tgl_layanan asc");

		return $data->result_array();
	}

	public function select_icd9cm_like($value)
	{
		$data = $this->db->query("SELECT * FROM icd9cm WHERE id_tind LIKE '%$value%' UNION SELECT * FROM icd9cm WHERE nm_tindakan LIKE '%$value%' GROUP BY id_tind LIMIT 30");
		return $data->result_array();
	}

	function update_bed($data_bed, $idrgasal, $bedasal, $kelasasal)
	{
		return $this->db->query("update bed set isi = '$data_bed' where idrg = '$idrgasal' and bed = '$bedasal' and kelas = '$kelasasal'");
	}

	public function get_all_tindakan($kelas)
	{


		// $data=$this->db->query("
		// 	select * 
		// 	from jenis_tindakan_inap as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
		// 	left join jenis_tindakan as c on a.idtindakan = c.id_tindakan
		// 	where a.nmtindakan <> '' and b.kelas = '$kelas'
		// 	order by a.nmtindakan asc");

		// echo "
		// select a.*,b.*,c.paket 
		// 	from jenis_tindakan_inap as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
		// 	left join jenis_tindakan as c on a.idtindakan = c.idtindakan
		// 	where a.nmtindakan <> '' and b.kelas = '$kelas'
		// 	order by a.nmtindakan asc
		// 	";exit;

		// $data=$this->db->query("
		// 		select a.*,b.*,c.paket 
		// 	from jenis_tindakan as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
		// 	inner join jenis_tindakan as c on a.idtindakan = c.idtindakan
		// 	where a.nmtindakan <> '' and b.kelas = '$kelas' and a.idpok1 not in ('H','L','1')
		// 	and a.idpok1!='D' and a.idpok1!='F' and a.idpok1!='B'
		// 	order by a.nmtindakan asc
		// 	");

		$data = $this->db->query("
			select a.*,b.*
			from jenis_tindakan as a, 
			tarif_tindakan as b
			where a.idtindakan = b.id_tindakan
			and b.kelas != 'NA' and
			substr(a.idtindakan,1,1) not in ('H','L','M','D')
			and b.kelas = '$kelas'
			order by a.nmtindakan asc
			");

		return $data->result_array();
	}

	public function get_all_tindakan_vk($kelas)
	{

		$data = $this->db->query("
				select a.*,b.*,c.paket 
			from jenis_tindakan_vk as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
			inner join jenis_tindakan as c on a.idtindakan = c.idtindakan
			where a.nmtindakan <> '' and b.kelas = '$kelas' and a.deleted=0
			order by a.nmtindakan asc
			");

		return $data->result_array();
	}

	public function get_all_tindakan_icu($kelas)
	{

		$data = $this->db->query("
				select a.*,b.*,c.paket 
			from jenis_tindakan_inap as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
			left join jenis_tindakan as c on a.idtindakan = c.idtindakan
			where a.nmtindakan <> '' and b.kelas = '$kelas' and a.deleted=0
			and a.idpok1!='D' and a.idpok1!='N'
			order by a.nmtindakan asc
			");

		return $data->result_array();
	}

	public function get_tarif_tindakan_by_id_kelas($id_tindakan, $kelas)
	{
		$data = $this->db->query("
			select * 
			from jenis_tindakan as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
			where a.nmtindakan <> '' and b.kelas = '$kelas' and b.id_tindakan = '$id_tindakan' ");
		return $data->result_array();
	}
	/*SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket!='Perawat' and pelayanan_iri.no_ipd='RI00000013'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and jenis_tindakan.nmtindakan not like '%MATKES%'*/
	public function get_list_tindakan_pasien_by_no_ipd($no_ipd)
	{
		// $data=$this->db->query("
		// 	select *, IF(c.idkel_tind=0,'',(select nama_kel from kel_tind where idkel_tind=c.idkel_tind)) as nama_kel, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nmdokter, (SELECT nmruang from ruang where idrg=a.idrg) as nmruang 
		// 	from pelayanan_iri as a inner join data_pasien as b on a.nomederec = b.no_medrec
		// 	inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
		// 	where a.no_ipd = '$no_ipd' 
		// 	order by a.idoprtr asc
		// 	");
		// return $data->result_array();

		$data = $this->db->query("SELECT
			*,
		CASE
			WHEN C.idkel_tind = '0' THEN
			'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind limit 1) 
		END AS nama_kel,
			( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
			( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
			(SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1) AS ttd_pelaksana,
			(SELECT name FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1) AS pelaksana
		FROM
			pelayanan_iri
			AS A INNER JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
			INNER JOIN jenis_tindakan_new AS C ON A.id_tindakan = C.idtindakan,
			pasien_iri AS y,
			ruang AS d 
		WHERE
			A.no_ipd = '$no_ipd' 
			AND a.no_ipd = y.no_ipd
			AND a.idrg = d.idrg
		ORDER BY
			A.tgl_layanan DESC
				");
		return $data->result_array();
	}

	public function get_list_tindakan_pasien_by_no_ipd_backup($no_ipd)
	{
		$data = $this->db->query("SELECT DISTINCT
			a.*,
			b.nmruang,
			( SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS ttd_pelaksana,
			( SELECT NAME FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS pelaksana,
			c.nmtindakan,
			d.carabayar,
			d.titip,
			d.klsiri,
			d.jatahklsiri,
			e.tarif_iks
		FROM
			pelayanan_iri AS a,
			ruang AS b,
			jenis_tindakan AS c,
			pasien_iri AS d,
			tarif_tindakan AS e
		WHERE 
			a.idrg = b.idrg
			AND a.id_tindakan = e.id_tindakan
			AND d.no_ipd = a.no_ipd
			AND a.no_ipd = '$no_ipd'
			AND c.idtindakan = a.id_tindakan
		ORDER BY a.tgl_layanan DESC");

		return $data->result_array();
	}

	public function get_list_sumtindakan_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("select a.id_tindakan, a.kelas, a.idoprtr, a.tgl_layanan, c.nmtindakan, SUM(a.vtot) as vtot, a.tarifalkes, a.tumuminap, sum(a.qtyyanri) as qtyyanri, (select nm_dokter from data_dokter where id_dokter= CAST(a.idoprtr AS INTEGER)) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=CAST(a.idoprtr AS INTEGER)) as nmdokter 
		from pelayanan_iri as a inner join data_pasien as b on CAST(a.nomederec AS INTEGER) = b.no_medrec
		inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
		where a.no_ipd = '$no_ipd' 
		group by a.id_tindakan, a.idoprtr, a.kelas, a.tgl_layanan,c.nmtindakan,a.tarifalkes, a.tumuminap");
		return $data->result_array();
	}

	public function get_list_tindakan_dokter_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT pelayanan_iri.id_tindakan, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.vtot) as vtot, pelayanan_iri.tarifalkes, pelayanan_iri.kelas, pelayanan_iri.tumuminap, sum(pelayanan_iri.qtyyanri) as qtyyanri, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nmdokter  
			FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket!='Perawat' and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan not like '%MATKES%'
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
        group by pelayanan_iri.id_tindakan, pelayanan_iri.idoprtr, pelayanan_iri.kelas
		order by data_dokter.nm_dokter asc");
		return $data->result_array();
	}

	public function get_list_tindakan_dokter_pasien_by_no_ipd_kw($no_ipd)
	{
		$data = $this->db->query("SELECT pelayanan_iri.id_tindakan,
jenis_tindakan.idkel_tind,
    jenis_tindakan.nmtindakan,
    SUM(pelayanan_iri.tarifalkes) as tarifalkes,
    pelayanan_iri.kelas,
    SUM(pelayanan_iri.qtyyanri) AS qtyyanri,
    SUM(pelayanan_iri.tumuminap) as tumuminap,
    SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) as nm_dokter, 
    IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) AS nmdokter    
     from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 
where
		pelayanan_iri.idoprtr=data_dokter.id_dokter 
		and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
        and pelayanan_iri.no_ipd='RI00000470'
        AND data_dokter.ket != 'Perawat'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        GROUP BY pelayanan_iri.id_tindakan , pelayanan_iri.idoprtr , jenis_tindakan.idkel_tind
		ORDER BY data_dokter.nm_dokter ASC
        
   ");
		return $data->result_array();
	}

	public function get_list_tindakan_dokter_pasien_by_no_ipd_newest($no_ipd, $case)
	{
		// 		SELECT ruang.nmruang as nmruang,pelayanan_iri.id_tindakan, jenis_tindakan.idkel_tind, jenis_tindakan.nmtindakan, kel_tind.nama_kel, SUM(pelayanan_iri.tarifalkes*pelayanan_iri.qtyyanri) as tarifalkes, pelayanan_iri.kelas, SUM(pelayanan_iri.qtyyanri) AS qtyyanri, SUM(pelayanan_iri.tumuminap) AS tumuminap, SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, 
		// 	case when
		// 		(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))
		// 			NOT IN ('Spesialis','Operasi','Dokter Jaga') and 
		// 		(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then

		// 		'' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) end as nm_dokter, 

		// 	case when 
		// 	(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) 
		// 		NOT IN ('Spesialis','Operasi','Dokter Jaga') and 
		// 	(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then
		// 	   '' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) end AS nmdokter 
		// from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien , ruang
		// where cast(pelayanan_iri.idoprtr as integer)=data_dokter.id_dokter 
		// and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
		// and ruang.idrg=pelayanan_iri.idrg
		// and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan 
		// and cast(pelayanan_iri.nomederec as integer)=data_pasien.no_medrec 
		// and pelayanan_iri.no_ipd='RI00000169' 
		// AND (data_dokter.ket != 'Perawat' and data_dokter.ket != 'Bidan')
		// GROUP BY pelayanan_iri.idoprtr, jenis_tindakan.idkel_tind ,nmruang,pelayanan_iri.id_tindakan,jenis_tindakan.nmtindakan, kel_tind.nama_kel, pelayanan_iri.kelas
		$query = '';
		if ($case == 'kelompok') {
			// $query="and kel_tind.idkel_tind IN (0,25) GROUP BY pelayanan_iri.idoprtr, jenis_tindakan.idkel_tind ";
			// $query="and cast(kel_tind.idkel_tind as integer) IN (3,18,24,25,26,27,28,29,30)  GROUP BY pelayanan_iri.idoprtr, jenis_tindakan.idkel_tind ,nmruang,pelayanan_iri.id_tindakan,jenis_tindakan.nmtindakan, kel_tind.nama_kel, pelayanan_iri.kelas";
			$query = "GROUP BY pelayanan_iri.idoprtr, jenis_tindakan.idkel_tind ,nmruang,pelayanan_iri.id_tindakan,jenis_tindakan.nmtindakan, kel_tind.nama_kel, pelayanan_iri.kelas";
		} else {
			// $query="and kel_tind.idkel_tind=3 GROUP BY pelayanan_iri.idoprtr";
			// $query="and cast(kel_tind.idkel_tind as integer)=0 GROUP BY pelayanan_iri.idoprtr, jenis_tindakan.idkel_tind ,nmruang,pelayanan_iri.id_tindakan,jenis_tindakan.nmtindakan, kel_tind.nama_kel, pelayanan_iri.kelas";
			$query = "GROUP BY pelayanan_iri.idoprtr, jenis_tindakan.idkel_tind ,nmruang,pelayanan_iri.id_tindakan,jenis_tindakan.nmtindakan, kel_tind.nama_kel, pelayanan_iri.kelas";
		}

		$data = $this->db->query("	SELECT ruang.nmruang as nmruang,pelayanan_iri.id_tindakan, jenis_tindakan.idkel_tind, jenis_tindakan.nmtindakan, kel_tind.nama_kel, SUM(pelayanan_iri.tarifalkes*pelayanan_iri.qtyyanri) as tarifalkes, pelayanan_iri.kelas, SUM(pelayanan_iri.qtyyanri) AS qtyyanri, SUM(pelayanan_iri.tumuminap) AS tumuminap, SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, 
		case when
			(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))
				NOT IN ('Spesialis','Operasi','Dokter Jaga') and 
			(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then
			
			'' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) end as nm_dokter, 
				
		case when 
		(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) 
			NOT IN ('Spesialis','Operasi','Dokter Jaga') and 
		(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then
		   '' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) end AS nmdokter 
	from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien , ruang
	where cast(pelayanan_iri.idoprtr as integer)=data_dokter.id_dokter 
	and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
	and ruang.idrg=pelayanan_iri.idrg
	and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan 
	and cast(pelayanan_iri.nomederec as integer)=data_pasien.no_medrec 
	and pelayanan_iri.no_ipd='$no_ipd' 
	AND (data_dokter.ket != 'Perawat' and data_dokter.ket != 'Bidan')
	       
        $query        ");
		return $data->result_array();
	}

	public function get_list_tindakan_perawat_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket='Perawat' and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan not like '%MATKES%'
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
	}

	public function get_list_tindakan_perawat_pasien_by_no_ipd_newest($no_ipd)
	{ //, $case  $query
		/*$query='';
		if($case=='anyelir'){
			$query="and ((SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) like '%Bersalin%'
        or (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) like '%Anyelir%')";
		} else {
			$query="and ((SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) not like '%Bersalin%'
        and (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) not like '%Anyelir%')";
		}*/

		$data = $this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang,
		(SELECT lokasi from ruang where idrg=pelayanan_iri.idrg) as lokasi,
		pelayanan_iri.id_tindakan,
jenis_tindakan.idkel_tind,
jenis_tindakan.nmtindakan,
SUM(pelayanan_iri.tarifalkes*pelayanan_iri.qtyyanri) as tarifalkes,
pelayanan_iri.kelas,
SUM(pelayanan_iri.qtyyanri) AS qtyyanri,
SUM(pelayanan_iri.tumuminap) AS tumuminap,
SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, 
case when
	(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) 
		NOT IN ('Spesialis','Operasi','Dokter Jaga') and 
	(SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) !='' then
	'' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) end as nm_dokter, (SELECT  nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) AS nmdokter 
from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 

where cast(pelayanan_iri.idoprtr as integer)=data_dokter.id_dokter 
	and pelayanan_iri.no_ipd='$no_ipd'
	AND (data_dokter.ket = 'Perawat'
	or data_dokter.ket = 'Bidan')
	and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
	and cast(pelayanan_iri.nomederec as integer)=data_pasien.no_medrec
	and cast(kel_tind.idkel_tind as integer)=0       
	GROUP BY pelayanan_iri.idoprtr,nmdokter,nmruang,lokasi, pelayanan_iri.id_tindakan,jenis_tindakan.nmtindakan, pelayanan_iri.kelas,jenis_tindakan.idkel_tind
	ORDER BY nm_dokter DESC");
		return $data->result_array();
	}

	public function get_list_alat_pasien_by_no_ipd($no_ipd, $case)
	{
		$query = '';

		if ($case != 0) {
			$query = 'and kel_tind.idkel_tind IN (1,2,4,5,6,7,8,9,10)';
		} else {
			$query = 'and kel_tind.idkel_tind IN (22)';
		}
		$data = $this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang, (SELECT lokasi from ruang where idrg=pelayanan_iri.idrg) as lokasi, pelayanan_iri.id_tindakan, jenis_tindakan.idkel_tind, kel_tind.nama_kel, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.tarifalkes*pelayanan_iri.qtyyanri) as tarifalkes, pelayanan_iri.kelas, SUM(pelayanan_iri.qtyyanri) AS qtyyanri, SUM(pelayanan_iri.tumuminap) AS tumuminap, SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, 
		case when (SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='Spesialis' and (SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then '' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) end as nm_dokter, 
		case when (SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='Spesialis' and (SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then '' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) end AS nmdokter 
	from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 
	where cast(pelayanan_iri.idoprtr as integer)=data_dokter.id_dokter 
	and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
	and pelayanan_iri.no_ipd='$no_ipd' 
	and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan 
	and cast(pelayanan_iri.nomederec as integer)=data_pasien.no_medrec 
	
	GROUP BY jenis_tindakan.idkel_tind ,nmruang,pelayanan_iri.idrg,pelayanan_iri.id_tindakan,kel_tind.nama_kel,jenis_tindakan.nmtindakan,pelayanan_iri.kelas,nm_dokter,nmdokter
	ORDER BY nm_dokter DESC");
		return $data->result_array();
		//AND (data_dokter.ket = 'Perawat' or data_dokter.ket = 'Bidan')
	}

	public function get_list_tindakan_perawat_pasien_by_no_ipd_kw($no_ipd)
	{
		$data = $this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang, SUM(tarifalkes) as tarifalkes, SUM(tumuminap*qtyyanri) as vtot, SUM(qtyyanri) as qtyyanri, SUM(tumuminap) as tumuminap FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket='Perawat' and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan not like '%MATKES%'
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        group by pelayanan_iri.idrg
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
	}

	public function get_list_oksigen_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket='Rumah Sakit' and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan like '%oksigen%'
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
		//        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
		//and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
	}

	public function get_list_oksigen_pasien_by_no_ipd_newest($no_ipd)
	{
		$data = $this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang,pelayanan_iri.id_tindakan,
		jenis_tindakan.idkel_tind,
			jenis_tindakan.nmtindakan,
			SUM(pelayanan_iri.tarifalkes) as tarifalkes,
			pelayanan_iri.kelas,
			SUM(pelayanan_iri.qtyyanri) AS qtyyanri,
			pelayanan_iri.tumuminap,
			SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, 
			case when (SELECT 
					ket
				FROM
					data_dokter
				WHERE
					id_dokter = cast(pelayanan_iri.idoprtr as integer))!='Spesialis' and (SELECT 
					ket
				FROM
					data_dokter
				WHERE
					id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then '' else (SELECT 
					nm_dokter
				FROM
					data_dokter
				WHERE
					id_dokter = cast(pelayanan_iri.idoprtr as integer)) end as nm_dokter, 
			case when (SELECT 
					ket
				FROM
					data_dokter
				WHERE
					id_dokter = cast(pelayanan_iri.idoprtr as integer))!='Spesialis' and (SELECT 
					ket
				FROM
					data_dokter
				WHERE
					id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then '' else (SELECT 
					nm_dokter
				FROM
					data_dokter
				WHERE
					id_dokter = cast(pelayanan_iri.idoprtr as integer)) end AS nmdokter    
			 from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 
		where
				cast(pelayanan_iri.idoprtr as integer)=data_dokter.id_dokter 
				and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
				and pelayanan_iri.no_ipd='$no_ipd'
				and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
				and cast(pelayanan_iri.nomederec as integer)=data_pasien.no_medrec
		GROUP BY jenis_tindakan.idkel_tind ,nmruang,pelayanan_iri.idrg,pelayanan_iri.id_tindakan,kel_tind.nama_kel,jenis_tindakan.nmtindakan,pelayanan_iri.kelas,nm_dokter,nmdokter		,pelayanan_iri.tumuminap");
		return $data->result_array();
		//        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
		//and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
	}

	public function get_list_tindakan_perawat_ruang_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien 
		where cast(pelayanan_iri.idoprtr as integer)=data_dokter.id_dokter 
		and data_dokter.ket='Perawat' 
		and pelayanan_iri.no_ipd='$no_ipd' 
		and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan 
		and cast(pelayanan_iri.nomederec as integer)=data_pasien.no_medrec 
		and jenis_tindakan.nmtindakan not like '%MATKES%' 
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
	}

	//matkes ruang
	public function get_list_tindakan_matkes_pasien_by_no_ipd_newest($no_ipd)
	{
		$data = $this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang,pelayanan_iri.id_tindakan, jenis_tindakan.idkel_tind, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.tarifalkes) as tarifalkes, pelayanan_iri.kelas, SUM(pelayanan_iri.qtyyanri) AS qtyyanri, pelayanan_iri.tumuminap, SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, 
		case when (SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='Spesialis' and (SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then '' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) end as nm_dokter, 
		case when (SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='Spesialis' and (SELECT ket FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer))!='' then '' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = cast(pelayanan_iri.idoprtr as integer)) end AS nmdokter 
	from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 
	where cast(pelayanan_iri.idoprtr as integer)=data_dokter.id_dokter 
	and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
	and pelayanan_iri.no_ipd='$no_ipd' 
	and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan 
	and cast(pelayanan_iri.nomederec as integer)=data_pasien.no_medrec 
	
	GROUP BY jenis_tindakan.idkel_tind ,nmruang,pelayanan_iri.idrg,pelayanan_iri.id_tindakan,kel_tind.nama_kel,jenis_tindakan.nmtindakan,pelayanan_iri.kelas,nm_dokter,nmdokter,pelayanan_iri.tumuminap");
		return $data->result_array();
		//and data_dokter.ket!='Perawat' 
	}

	//matkes icu
	public function get_list_tindakan_matkes_icu_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan like '%MATKES%'
        and pelayanan_iri.idrg = (SELECT idrg FROM ruang WHERE lokasi = 'Ruang ICU')
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
		//and data_dokter.ket!='Perawat' 
	}

	//matkes vk
	public function get_list_tindakan_matkes_vk_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan like '%MATKES%'
        and pelayanan_iri.idrg = (SELECT idrg FROM ruang WHERE lokasi = 'Ruang Bersalin')
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
		//and data_dokter.ket!='Perawat' 
	}



	//ruang
	public function get_list_ruang_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT *, 
		case when b.tglkeluarrg is not null then DATE_PART('year', b.tglkeluarrg::date) - DATE_PART('year', b.tglmasukrg::date) else
			 DATE_PART('year', b.tglkeluarrg::date) - DATE_PART('year', b.tglmasukrg::date) end as days, 
		case when b.tglkeluarrg is not null then DATE_PART('year', b.tglkeluarrg::date) - DATE_PART('year', b.tglmasukrg::date) else
		   DATE_PART('year', b.tglkeluarrg::date) - DATE_PART('year', b.tglmasukrg::date) end *nullif(b.vtot,0) as vtot_ruang 
	FROM ruang_iri b, pasien_iri a 
	WHERE b.idrg != (SELECT idrg FROM ruang WHERE lokasi = 'Ruang ICU') 
	and b.idrg != (SELECT idrg FROM ruang WHERE lokasi = 'Ruang Bersalin') 
	and b.no_ipd='$no_ipd' 
	and b.no_ipd=a.no_ipd
			");
		return $data->result_array();
	}

	public function get_list_tindakan_iri($no_ipd)
	{
		$data = $this->db->query("SELECT
		a.*,y.*, x.total_tarif AS tarif_jatah, d.nmtindakan, e.nmruang,
		(select nm_dokter from data_dokter AS b, pelayanan_iri AS c where CAST (a.idoprtr AS INTEGER) = b.id_dokter AND c.no_ipd = '$no_ipd') AS nm_dokter
	FROM
		pelayanan_iri AS a,
		tarif_tindakan AS x,
		pasien_iri AS y,
		jenis_tindakan AS d,
		ruang AS e
	WHERE
		x.kelas = y.jatahklsiri 
		AND a.idrg = e.idrg
		AND a.id_tindakan = d.idtindakan
		AND a.id_tindakan = x.id_tindakan 
		AND a.no_ipd = y.no_ipd
		AND a.no_ipd = '$no_ipd' 
	ORDER BY
		a.idoprtr ASC");

		return $data->result_array();
	}

	//icu
	public function get_list_tindakan_icu_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT 
		    *,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg)) as days,
		    SUM(a.vtot) AS vtot,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg))*IFNULL(b.vtot,0)+SUM(a.vtot) as vtot_icu,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg))*IFNULL(b.vtot,0) as vtot_ruang
			FROM
			    pelayanan_iri a,
			    ruang_iri b
			WHERE
			    a.idrg = (SELECT 
			            idrg
			        FROM
			            ruang
			        WHERE
			            lokasi = 'Ruang ICU')
			And a.no_ipd='$no_ipd'
			and a.no_ipd=b.no_ipd
			");
		return $data->result_array();
	}

	public function get_vk_room($no_ipd)
	{
		$data = $this->db->query("SELECT 
		    *, (SELECT nmruang from ruang where idrg=b.idrg) as nmruang
			FROM
			    ruang_iri b
			WHERE
			    b.idrg = (SELECT 
			            idrg
			        FROM
			            ruang
			        WHERE
			            lokasi = 'Ruang Bersalin')
			And b.no_ipd='$no_ipd'");
		return $data->result_array();
	}
	//vk
	public function get_list_tindakan_vk_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT 
		    *,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg)) as days,
		    SUM(a.vtot) AS vtot,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg))*IFNULL(b.vtot,0)+SUM(a.vtot) as vtot_vk,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg))*IFNULL(b.vtot,0) as vtot_ruang
			FROM
			    pelayanan_iri a,
			    ruang_iri b
			WHERE
			    a.idrg = (SELECT 
			            idrg
			        FROM
			            ruang
			        WHERE
			            lokasi = 'Ruang Bersalin')
			And a.no_ipd='$no_ipd'
			and a.no_ipd=b.no_ipd
			");
		return $data->result_array();
	}

	public function get_list_tindakan_vk_pasien_by_no_ipd_kw($no_ipd)
	{
		$data = $this->db->query("SELECT pelayanan_iri.id_tindakan, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.vtot) as vtot, pelayanan_iri.tarifalkes, pelayanan_iri.kelas, pelayanan_iri.tumuminap, sum(pelayanan_iri.qtyyanri) as qtyyanri, 
		IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) as nm_dokter, 
        IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) AS nmdokter  
			FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec        
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
        group by pelayanan_iri.id_tindakan, pelayanan_iri.idoprtr, pelayanan_iri.kelas
		order by data_dokter.nm_dokter asc
		");
		return $data->result_array();
	}

	public function get_list_tindakan_vk_pasien_by_no_ipd_new($no_ipd)
	{
		$data = $this->db->query("SELECT pelayanan_iri.id_tindakan, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.vtot) as vtot, pelayanan_iri.tarifalkes, pelayanan_iri.kelas, pelayanan_iri.tumuminap, sum(pelayanan_iri.qtyyanri) as qtyyanri, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nmdokter  
			FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec        
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
        group by pelayanan_iri.id_tindakan, pelayanan_iri.idoprtr, pelayanan_iri.kelas
		order by data_dokter.nm_dokter asc
		");
		return $data->result_array();
	}

	//icu
	public function get_list_tindakan_icu_pasien_by_no_ipd_new($no_ipd)
	{
		$data = $this->db->query("SELECT pelayanan_iri.id_tindakan, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.vtot) as vtot, pelayanan_iri.tarifalkes, pelayanan_iri.kelas, pelayanan_iri.tumuminap, sum(pelayanan_iri.qtyyanri) as qtyyanri, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nmdokter  
			FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec        
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
        group by pelayanan_iri.id_tindakan, pelayanan_iri.idoprtr, pelayanan_iri.kelas
		order by data_dokter.nm_dokter asc
		");
		return $data->result_array();
	}


	public function get_paket_tindakan($no_ipd)
	{
		$data = $this->db->query("
			SELECT * 
			FROM pelayanan_iri
			WHERE no_ipd = '$no_ipd' AND paket = 1

			");
		return $data->result_array();
	}
	public function getdata_perusahaan($no_register)
	{
		return $this->db->query("SELECT A.id_kontraktor, B.nmkontraktor FROM pasien_iri A, kontraktor B  where no_ipd='$no_register' and A.id_kontraktor=B.id_kontraktor");
	}
	public function get_pasien_by_no_ipd_new($no_ipd)
	{
		$data = $this->db->query("
		select a.titip,a.noregasal,EXTRACT(YEAR FROM AGE(CURRENT_DATE, b.tgl_lahir)) as birth_date,a.idrg as idruangiri, a.jasa_perawat as jasaperawat,c.vtot as vtot_ruang, 
		f.nm_diagnosa as nm_diagmasuk, d.nmruang, g.nmkontraktor, a.id_dokter as dr_dpjp, a.tuslah,h.nm_dokter,
		a.anamakwitansi,b.nama,b.alamat,a.tgl_masuk,b.no_cm,a.no_ipd,a.carabayar,a.tgl_keluar,a.tgl_keluar_resume,a.tgl_masuk
		from pasien_iri as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		left join ruang_iri as c on a.no_ipd = c.no_ipd
		left join ruang as d on c.idrg = d.idrg
		left join icd1 as e on a.diagnosa1 = e.id_icd
		left join icd1 as f on a.diagmasuk = f.id_icd
		left join kontraktor g on g.id_kontraktor=a.id_kontraktor
		left join data_dokter h on h.id_dokter=a.id_dokter
		where a.no_ipd = '$no_ipd' 
		Order by c.idrgiri DESC");
		return $data->row();
	}

	public function get_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("
		select a.idrg as idruangiri,a.*, a.jasa_perawat as jasaperawat, b.*, c.vtot as vtot_ruang, c.*,d.*,e.*, 
		f.nm_diagnosa as nm_diagmasuk, d.nmruang, g.nmkontraktor, a.id_dokter as dr_dpjp, a.tuslah,h.nm_dokter
		from pasien_iri as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		left join ruang_iri as c on a.no_ipd = c.no_ipd
		left join ruang as d on c.idrg = d.idrg
		left join icd1 as e on a.diagnosa1 = e.id_icd
		left join icd1 as f on a.diagmasuk = f.id_icd
		left join kontraktor g on g.id_kontraktor=a.id_kontraktor
		left join data_dokter h on h.id_dokter=a.id_dokter
		where a.no_ipd = '$no_ipd' 
		Order by c.idrgiri DESC");
		return $data->result_array();
	}

	public function get_pasien_by_no_ipd_for_resume($no_ipd)
	{
		$data = $this->db->query("
		select a.*, a.jasa_perawat as jasaperawat, b.*, c.vtot as vtot_ruang, c.*,d.*,e.*, 
		f.nm_diagnosa as nm_diagmasuk, d.nmruang, g.nmkontraktor, a.id_dokter as dr_dpjp, a.tuslah
		from pasien_iri as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		left join ruang_iri as c on a.no_ipd = c.no_ipd
		left join ruang as d on c.idrg = d.idrg
		left join icd1 as e on a.diagnosa1 = e.id_icd
		left join icd1 as f on a.diagmasuk = f.id_icd
		left join kontraktor g on g.id_kontraktor=a.id_kontraktor
		where a.no_ipd = '$no_ipd' 
		Order by c.idrgiri DESC");
		return $data->result();
	}

	public function get_note_iri_for_resume($no_ipd)
	{
		$data = $this->db->query("
			SELECT * FROM soap_pasien_ri WHERE no_ipd = '$no_ipd'
		");
		return $data->result();
	}

	public function get_obat_for_resume($no_ipd)
	{
		$data = $this->db->query("
			SELECT * FROM resep_pasien WHERE no_register = '$no_ipd'
		");
		return $data->result();
	}

	public function get_radiologi_for_resume($no_ipd)
	{
		$data = $this->db->query("
			SELECT * FROM pemeriksaan_radiologi WHERE no_register = '$no_ipd'
		");
		return $data->result();
	}

	public function get_elektromedik_for_resume($no_ipd)
	{
		$data = $this->db->query("
			SELECT * FROM pemeriksaan_elektromedik WHERE no_register = '$no_ipd'
		");
		return $data->result();
	}

	public function get_lab_for_resume($no_ipd)
	{
		$data = $this->db->query("
			SELECT * FROM pemeriksaan_laboratorium WHERE no_register = '$no_ipd'
		");
		return $data->result();
	}

	public function get_pasien_by_no_ipd_newest($no_ipd)
	{
		$data = $this->db->query("select a.*, a.jasa_perawat as jasaperawat, b.*, c.vtot as vtot_ruang, c.*,d.*,
    		(SELECT nmruang from ruang where idrg=d.idrg) as nmruang, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor			
			from pasien_iri as a , data_pasien as b, ruang_iri as c
            , ruang as d
            where a.no_medrec = b.no_medrec
			 and a.no_ipd = c.no_ipd
			 and c.idrg = d.idrg
             and a.idrg = c.idrg
			 and a.no_ipd ='$no_ipd'");
		return $data->result_array();
	}

	public function get_old_pasien($no_register)
	{
		$data = $this->db->query("select * from daftar_ulang_irj where no_register='$no_register'");
		return $data->result_array();
	}

	public function get_ruang_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("
			select * 
			from ruang_iri, ruang
			where ruang_iri.no_ipd = '$no_ipd' 
			and ruang_iri.idrg=ruang.idrg
			order by ruang_iri.idrgiri desc
			");
		return $data->result_array();
	}

	public function insert_tindakan_temp($data)
	{
		// var_dump($data);die();
		$querynoantrian = "(SELECT IFNULL(CONCAT('T', LPAD (max(right(id_jns_layanan2,7))+1 ,7,0) ),'T0000001') 
						FROM (SELECT * FROM pelayanan_iri_temp) AS a)";
		// $this->db->set('id_jns_layanan', $querynoantrian , FALSE);
		$this->db->insert('pelayanan_iri_temp', $data);
		// if(!$this->db->insert('pelayanan_iri_temp', $data)){
		// 	print_r($this->db->error());
		// 	exit; 
		// }else{
		// 	$this->db->insert_id();
		// 	//$data['status']='0';
		// 	return '0';
		// }
	}

	function insert_diagnosa($data)
	{
		return $this->db->insert('diagnosa_iri', $data);
	}

	

	public function hapus_diagnosa_by_id($id)
	{
		$data = $this->db->query("
			delete 
			from diagnosa_iri
			where id_diagnosa_pasien = '$id' ");
	}

	public function get_diagnosa_by_id($id)
	{
		$data = $this->db->query("
			select * 
			from icd1
			where id_icd = '$id'");
		// var_dump($data);
		return $data->result_array();
	}

	//assesment medis iri
	function get_assesment_medis_iri($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->get('assesment_medis_iri');
	}

	function get_assesment_medis_iribytgl($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->where('DATE(tanggal_pemeriksaan)', date('Y-m-d'));
		return $this->db->get('assesment_medis_iri');
	}

	function insert_assesment_medis_iri($data_insert)
	{
		return $this->db->insert('assesment_medis_iri', $data_insert);
	}
	function update_assesment_medis_iri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('assesment_medis_iri', $data);
	}

	function getdata_tindakan_fisik($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->get('pemeriksaan_fisik_ri');
	}

	function getdata_tindakan_fisik_all($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->order_by('tanggal_pemeriksaan', 'DESC');
		return $this->db->get('pemeriksaan_fisik_ri');
	}

	function getdata_tindakan_fisik_datenow($no_ipd, $tgl, $idpemeriksa)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_fisik_ri WHERE id_pemeriksa=$idpemeriksa AND no_ipd='$no_ipd' AND DATE(tanggal_pemeriksaan) = TO_DATE('$tgl','YYYY-MM-DD')");
	}

	function insert_data_fisik_ri($data)
	{
		$this->db->insert('pemeriksaan_fisik_ri', $data);
		return true;
	}

	function update_data_fisik_ri($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('pemeriksaan_fisik_ri', $data);
		return true;
	}

	function get_nmttd_dokter_by_noipd($no_ipd)
	{
		return $this->db->query("SELECT b.nm_dokter,ttd as ttd_dokter FROM pasien_iri a 
		LEFT JOIN data_dokter b on a.id_dokter = b.id_dokter
		WHERE a.no_ipd='$no_ipd'
		");
	}

	function get_assesment_awal_keperawatan_bynoipdtgl($no_ipd)
	{
		return $this->db->query("SELECT * FROM assesment_keperawatan_iri where no_ipd='$no_ipd' AND DATE(tgl_input_perawat_1) = current_date");
	}

	function get_assesment_awal_keperawatan_bynoipd($no_ipd)
	{
		return $this->db->query("SELECT * FROM assesment_keperawatan_iri WHERE no_ipd='$no_ipd'");
	}

	function insert_assesment_awal_keperawatan_iri($data)
	{
		return $this->db->insert('assesment_keperawatan_iri', $data);
	}

	function update_assesment_awal_keperawatan_iri($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('assesment_keperawatan_iri', $data);
		return true;
	}

	function get_catatan_edukasi($noipd)
	{
		return $this->db->query("SELECT * FROM catatan_edukasi WHERE no_ipd='$noipd'");
	}

	
	function insert_catatan_edukasi($data)
	{
		return $this->db->insert('catatan_edukasi', $data);
	}

	function update_catatan_edukasi($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('catatan_edukasi', $data);
		return true;
	}

	function insert_konsultasi_pasien_iri($data)
	{
		return $this->db->insert('konsultasi_pasien_iri', $data);
	}

	function update_konsultasi_pasien_iri($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('konsultasi_pasien_iri', $data);
		return true;
	}

	function get_dpjp_iri($no_ipd)
	{
		return $this->db->query("SELECT pasien_iri.id_dokter,dokter.nm_dokter FROM pasien_iri left join data_dokter dokter on dokter.id_dokter = pasien_iri.id_dokter WHERE no_ipd='$no_ipd'");
	}

	function history_konsultasi_pasien_iri_by_noipd($no_ipd)
	{
		return $this->db->query("SELECT a.*,b.nm_poli FROM konsultasi_pasien_iri a, poliklinik b 
		where substring(a.id_poli_tujuan,1,4) = b.id_poli
		and no_ipd='$no_ipd'");
	}

	function get_id_konsul_rehab_medik($no_ipd)
	{
		return $this->db->query("SELECT 
			id 
		FROM 
			konsultasi_pasien_iri 
		WHERE 
			no_ipd = '$no_ipd' 
			AND id_poli_tujuan = 'BK00NK'
			AND tgl_jawaban IS NULL");
	}

	function get_soap_pasien_bynoipd($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->order_by("id", "DESC");
		return $this->db->get('soap_pasien_ri');
	}

	function get_soap_pasien_for_cppt($no_ipd)
	{
		return $this->db->query("SELECT * FROM soap_pasien_ri where no_ipd ='$no_ipd' AND role != 'Case Manager'order by tanggal_pemeriksaan DESC");
	}

	function get_soap_ri_by_idandshift_no_ipd($no_ipd, $userid, $shift)
	{
		return $this->db->query("SELECT * FROM soap_pasien_ri WHERE no_ipd='$no_ipd' AND id_pemeriksa=$userid AND shift='$shift'");
	}

	function get_pemeriksaan_fisik_by_idandshift_no_ipd($no_ipd, $userid, $shift)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_fisik_ri WHERE no_ipd='$no_ipd' AND id_pemeriksa=$userid AND shift='$shift'");
	}

	function get_soap_pasien_bynoipdbytgl($no_ipd, $userid)
	{
		// echo $no_ipd;die();
		return $this->db->query("SELECT * FROM soap_pasien_ri WHERE no_ipd='$no_ipd' AND DATE(tanggal_pemeriksaan) = current_date and id_pemeriksa=$userid ORDER BY id DESC");
	}

	function get_ruang_mutasi_iri($no_ipd)
	{
		$data = $this->db->query("SELECT 
			b.nmruang, a.tglmasukrg
		FROM 
			ruang_iri AS a
			INNER JOIN ruang AS b ON a.idrg = b.idrg
		WHERE 
			a.no_ipd = '$no_ipd' 
			AND a.tglkeluarrg IS NOT NULL");

		return $data->result_array();
	}

	function get_ruang_mutasi_iri_baru($no_ipd)
	{
		$data = $this->db->query("SELECT 
			b.nmruang, a.tglmasukrg
		FROM 
			ruang_iri AS a
			INNER JOIN ruang AS b ON a.idrg = b.idrg
		WHERE 
			a.no_ipd = '$no_ipd' 
			AND a.tglkeluarrg IS NULL");

		return $data->result_array();
	}

	function update_soap_pasien_ri($data, $id, $send_log = 0)
	{
		$this->db->query("set session my.vars.id = $send_log");
		$this->db->where('id', $id);
		$this->db->update('soap_pasien_ri', $data);
		return true;
	}

	function update_soap_pasien_ri_noipd($data, $id, $send_log = 0)
	{
		$this->db->query("set session my.vars.id = $send_log");
		$this->db->where('no_ipd', $id);
		$this->db->update('soap_pasien_ri', $data);
		return true;
	}


	function insert_soap_pasien_ri($data)
	{
		return $this->db->insert('soap_pasien_ri', $data);
	}

	function get_pemeriksaan_fisik_by_id($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('pemeriksaan_fisik_ri');
	}

	function insert_jawaban_konsultasi_pasien_iri($data, $noipd)
	{
		$this->db->where('id', $noipd);
		return $this->db->update('konsultasi_pasien_iri', $data);
	}

	function get_rencana_pemulangan($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->get('rencana_pemulangan_iri');
	}

	function update_rencana_pemulangan($data, $no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('rencana_pemulangan_iri', $data);
	}

	function insert_rencana_pemulangan($data)
	{
		return $this->db->insert('rencana_pemulangan_iri', $data);
	}

	function get_jadwal_dpjp_case_manager_by_now_by_userid($noipd, $userid)
	{
		// $this->db->where('no_ipd',$noipd);
		// $this->db->where('userid',$userid);
		// $this->db->where('DATE(tgl_input)',"TO_DATE('".date('Y-m-d')."','YYYY-MM-DD')");
		// return $this->db->get('jadwal_dpjp_case_manager');
		return $this->db->query("SELECT * FROM jadwal_dpjp_case_manager WHERE no_ipd='$noipd' and userid='$userid' and DATE(tgl_input) = current_date");
	}

	function update_jadwal_dpjp_case_manager($jadwal, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->update('jadwal_dpjp_case_manager', $jadwal);
	}

	function insert_jadwal_dpjp_case_manager($jadwal)
	{
		return $this->db->insert('jadwal_dpjp_case_manager', $jadwal);
	}

	function get_assesment_awal_keperawatan_igd($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('assesment_keperawatan_ird');
	}

	function get_ppa_userid($userid)
	{
		$this->db->where('userid', $userid);
		return $this->db->get('user_ppa');
	}

	function select2_perawat()
	{
		$query = $this->db->query("SELECT * 
        FROM hmis_users
        LEFT JOIN user_ppa on hmis_users.userid = user_ppa.userid
		WHERE user_ppa.ppa=1
		
		");
		return $query->result();
	}

	function get_pemeriksaan_fisik_old($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('pemeriksaan_fisik');
	}

	function get_soap_pasien_rj_old($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('soap_pasien_rj');
	}

	function get_assesment_keperawatan_igd($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('assesment_keperawatan_ird');
	}

	function get_assesment_medis_ird($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('assesment_medik_igd');
	}

	function get_drtambahan_iri($noipd)
	{
		$this->db->where('no_register', $noipd);
		return $this->db->get('drtambahan_iri');
	}

	function get_drtambahan_iri_new($noipd, $noregasal)
	{
		return $this->db->query("SELECT  cast(id_drtambahan as integer), cast(id_dokter as integer), no_register,ket,
		(select nm_dokter from data_dokter where id_dokter=cast(drtambahan_iri.id_dokter as integer)) as nm_dokter 
		from drtambahan_iri where no_register='$noipd' or no_register='$noregasal'");
	}

	function get_forma_evaluasi($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('form_a_evaluasi');
	}

	function get_intruksi_obat($noipd, $haritini)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->where("to_char(tgl_input,'YYYY-MM-DD')", $haritini);
		return $this->db->get('intruksi_obat_iri');
	}

	function get_intruksi_obat_all($noipd)
	{
		return $this->db->query("SELECT * FROM intruksi_obat_iri WHERE no_ipd='$noipd' order by id desc limit 1");
		// $this->db->where('no_ipd',$noipd);
		// return $this->db->get('intruksi_obat_iri');
	}

	function get_fungsional_all($noipd)
	{
		return $this->db->query("SELECT * FROM fungsional_tambahan_iri WHERE no_ipd='$noipd' order by id desc limit 1");
		// $this->db->where('no_ipd',$noipd);
		// return $this->db->get('intruksi_obat_iri');
	}


	function update_intruksi_obat($data, $noipd, $tgl)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->where("to_char(tgl_input,'YYYY-MM-DD')", $tgl);
		$this->db->update('intruksi_obat_iri', $data);
		return true;
	}

	function insert_intruksi_obat($data)
	{
		return $this->db->insert('intruksi_obat_iri', $data);
	}



	function get_asuhan_gizi($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('asuhan_gizi');
	}

	function update_forma_evaluasi($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('form_a_evaluasi', $data);
		return true;
	}

	function insert_forma_evaluasi($data)
	{
		return $this->db->insert('form_a_evaluasi', $data);
	}

	function insert_cppt_case_manager($data)
	{
		return $this->db->insert('soap_pasien_ri', $data);
	}

	function get_formb_evaluasi($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('form_b_evaluasi');
	}

	function update_formb_evaluasi($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('form_b_evaluasi', $data);
		return true;
	}

	function insert_formb_evaluasi($data)
	{
		return $this->db->insert('form_b_evaluasi', $data);
	}

	function get_catatan_serah_terima($noipd, $noreglama)
	{
		if ($noreglama != '') {
			return $this->db->query("SELECT 
				* 
			FROM 
				serah_terima 
			WHERE 
				no_register='$noipd' UNION ALL
			SELECT 
				* 
			FROM 
				serah_terima 
			WHERE 
				no_register='$noreglama'
			ORDER BY id ASC ");
		} else {
			return $this->db->query("SELECT 
				* 
			FROM 
				serah_terima 
			WHERE 
				no_register='$noipd'
			ORDER BY id ASC");
		}
	}

	function insert_serah_terima($data)
	{
		return $this->db->insert('serah_terima', $data);
	}

	function update_serah_terima($data, $no_register)
	{
		$this->db->where('no_register', $no_register);
		return $this->db->update('serah_terima', $data);
		// return true;
	}
	function update_serah_terima_id($data, $id)
	{
		$this->db->where('id', $id);
		return $this->db->update('serah_terima', $data);
		// return true;
	}


	function getdata_tindakan_igd($no_register)
	{
		return $this->db->query("SELECT formjson
		                         FROM assesment_medik_igd 
		                         where no_register='" . $no_register . "'");
	}

	function getdata_resep_pasien_ri($no_ipd, $datenow)
	{
		return $this->db->query("SELECT * FROM resep_pasien as a
			WHERE a.no_register = '$no_ipd' 
			order by tgl_kunjungan desc");
	}

	function getdata_em_pasien_ri($no_ipd, $datenow)
	{
		// return $this->db->query("SELECT * FROM pemeriksaan_elektromedik as a
		// WHERE a.no_register = '$no_ipd' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow'
		// ");
		return $this->db->query("SELECT * FROM pemeriksaan_elektromedik as a
			WHERE a.no_register = '$no_ipd' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
			");
	}

	function getdata_lab_pasien_ri($no_ipd, $datenow)
	{
		// return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
		// WHERE a.no_register = '$no_ipd' and 
		// ");
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
			WHERE a.no_register = '$no_ipd' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
			");
	}

	function getdata_ok_pasien_ri($no_ipd, $datenow)
	{
		return $this->db->query("SELECT po.no_ok, 
			po.id_pemeriksaan_ok, po.id_tindakan, po.jenis_tindakan, po.id_dokter, po.id_opr_anes, 
			po.id_dok_anes, po.jns_anes, po.id_dok_anak, po.vtot, oh.tgl_jadwal_ok, 
			( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dokter limit 1) AS nm_dokter, 
			( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_opr_anes limit 1) AS nm_opr_anes, 
			( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anes limit 1) AS nm_dok_anes, 
			( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anak limit 1) AS nm_dok_anak 
			FROM pemeriksaan_operasi po LEFT JOIN operasi_header oh ON oh.idoperasi_header = po.idoperasi_header  
			WHERE po.no_register = '$no_ipd' and to_char(po.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' ");
	}

	function getdata_rad_pasien_ri($no_ipd, $datenow)
	{
		// return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
		// WHERE a.no_register = '$no_ipd' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow'
		// ");
		return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
			WHERE a.no_register = '$no_ipd' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
			");
	}

	function update_asuhan_gizi($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('asuhan_gizi', $data);
		return true;
	}

	function insert_asuhan_gizi($data)
	{
		return $this->db->insert('asuhan_gizi', $data);
	}

	function get_assesment_gizi($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('assesment_gizi');
	}

	function update_assesment_gizi($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('assesment_gizi', $data);
		return true;
	}

	function insert_assesment_gizi($data)
	{
		return $this->db->insert('assesment_gizi', $data);
	}

	function get_ceklis_pasien_mpp($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('ceklis_pasien_mpp');
	}

	function update_ceklis_pasien_mpp($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('ceklis_pasien_mpp', $data);
		return true;
	}

	function insert_ceklis_pasien_mpp($data)
	{
		return $this->db->insert('ceklis_pasien_mpp', $data);
	}

	function insert_fungsional($data)
	{
		return $this->db->insert('fungsional_tambahan_iri', $data);
	}

	function get_fungsional($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('fungsional_tambahan_iri');
	}

	function update_fungsional($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('fungsional_tambahan_iri', $data);
		return true;
	}

	function insert_dekubitus($data)
	{
		return $this->db->insert('dekubitus_tambahan_iri', $data);
	}

	function get_dekubitus($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('dekubitus_tambahan_iri');
	}

	function update_dekubitus($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('dekubitus_tambahan_iri', $data);
		return true;
	}

	function insert_skala_morse($data)
	{
		return $this->db->insert('skala_morse_tambahan_iri', $data);
	}

	function get_skala_morse($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('skala_morse_tambahan_iri');
	}

	function get_rekonsiliasi_obat($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('rekonsiliasi_obat');
	}

	// function update_rekonsiliasi_obat($data, $noipd)
	// {
	// 	$this->db->where('no_ipd', $noipd);
	// 	$this->db->update('rekonsiliasi_obat', $data);
	// 	return true;
	// }
	function update_rekonsiliasi_obat($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('rekonsiliasi_obat', $data);
	}

	function insert_rekonsiliasi_obat($data)
	{
		return $this->db->insert('rekonsiliasi_obat', $data);
	}

	function get_daftar_pemberian_obat($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('daftar_pemberian_obat');
	}

	function update_daftar_pemberian_obat($data, $noipd)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('daftar_pemberian_obat', $data);
		return true;
	}

	function insert_pemberian_obat($data)
	{
		return $this->db->insert('daftar_pemberian_obat', $data);
	}
	//added putri function get ews
	function get_lembar_ews($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('lembar_ews_ri');
	}
	//added putri update get ews
	function update_lembar_ews($noipd, $data)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('lembar_ews_ri', $data);
		return true;
	}

	function insert_lembar_ews($data)
	{
		return $this->db->insert('lembar_ews_ri', $data);
	}

	function get_data_resep_pasien($noipd)
	{
		$this->db->where('no_register', $noipd);
		return $this->db->get('resep_pasien');
	}

	public function get_data_kwitansi($no_register)
	{
		return $this->db->query("SELECT DISTINCT * FROM no_kwitansi WHERE no_register = '$no_register' AND status IS NULL");
	}

	function get_data_pemberian_obat($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('daftar_pemberian_obat');
	}

	function gantiDPJP($noipd, $data)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('pasien_iri', $data);
		return true;
	}

	function get_catatan_persalinan($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->get('catatan_persalinan');
	}

	function update_catatan_persalinan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('catatan_persalinan', $data);
	}

	function insert_catatan_persalinan($data_insert)
	{
		return $this->db->insert('catatan_persalinan', $data_insert);
	}

	function get_laporan_persalinan($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->get('laporan_persalinan');
	}

	function update_laporan_persalinan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('laporan_persalinan', $data);
	}

	function insert_laporan_persalinan($data_insert)
	{
		return $this->db->insert('laporan_persalinan', $data_insert);
	}

	function update_pasien_iri_mutasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pasien_iri', $data);
	}

	function get_idrgiri($no_ipd, $idrg, $kelas, $bed)
	{
		return $this->db->query("SELECT * FROM ruang_iri as a
			WHERE a.no_ipd = '$no_ipd' 
			and a.idrg = '$idrg'
			and a.kelas = '$kelas'
			and a.bed = '$bed'
		");
	}

	function get_idrgiri_baru($no_ipd)
	{
		return $this->db->query("SELECT * FROM ruang_iri WHERE no_ipd = '$no_ipd' ORDER BY idrgiri DESC LIMIT 1");
	}

	function get_idrgiri_new($no_ipd)
	{
		return $this->db->where('no_ipd', $no_ipd)->get('ruang_iri')->order_by('idrgiri', 'desc');
	}

	function update_ruang_iri_mutasi($no_ipd, $idrgiri, $data)
	{
		$this->db->where('idrgiri', $idrgiri);
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('ruang_iri', $data);
	}

	function get_all_diagnosa()
	{
		return $this->db->query("SELECT * FROM icd1 ");
	}

	public function diagnosa_iri_utama($id)
	{
		return $this->db->query("select id_diagnosa,diagnosa from diagnosa_iri where no_register = '$id' and klasifikasi_diagnos = 'utama' ");
	}

	public function count_utama_procedure($no_register)
	{
		$this->db->select('*');
		$this->db->from('icd9cm_iri');
		$this->db->where('klasifikasi_procedure', 'utama');
		$this->db->where('no_register', $no_register);
		return $this->db->count_all_results();
	}

	function insert_procedure($data_insert)
	{
		return $this->db->insert('icd9cm_iri', $data_insert);
	}

	function check_transfer_ruangan($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('transfer_ruangan');
	}

	function check_transfer_ruangan_id($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('transfer_ruangan');
	}

	function check_transfer_ruangan_iri_irj_ird($noreg, $noregasal)
	{
		$where = "no_register='$noreg' OR no_register='$noregasal'";
		$this->db->where($where);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('transfer_ruangan');
	}

	public function get_list_tindakan_pelayanan_iri($no_ipd)
	{
		// $data=$this->db->query("
		// 	select *, IF(c.idkel_tind=0,'',(select nama_kel from kel_tind where idkel_tind=c.idkel_tind)) as nama_kel, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nmdokter, (SELECT nmruang from ruang where idrg=a.idrg) as nmruang 
		// 	from pelayanan_iri as a inner join data_pasien as b on a.nomederec = b.no_medrec
		// 	inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
		// 	where a.no_ipd = '$no_ipd' 
		// 	order by a.idoprtr asc
		// 	");
		// return $data->result_array();

		return $this->db->query("SELECT
			*,
		CASE
			WHEN C.idkel_tind = '0' THEN
			'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind ) 
		END AS nama_kel,
			( SELECT name FROM hmis_users WHERE userid = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
			( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
			x.total_tarif AS tarif_jatah,
			x.tarif_iks AS tarif_iks,
			e.ttd AS ttd_pelaksana
		FROM
			pelayanan_iri
			AS A INNER JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
			INNER JOIN jenis_tindakan AS C ON A.id_tindakan = C.idtindakan,
			tarif_tindakan AS x,
			pasien_iri AS y,
			ruang AS d,
			hmis_users AS e
		WHERE
			A.no_ipd = '$no_ipd' 
			AND e.userid = CAST ( A.idoprtr AS INTEGER )
			AND a.no_ipd = y.no_ipd
			AND a.idrg = d.idrg
			AND x.kelas = y.jatahklsiri 
			AND A.id_tindakan = x.id_tindakan 
		ORDER BY
			A.tgl_layanan ASC
				");
	}

	function insert_transfer_ruangan($data)
	{
		return $this->db->insert('transfer_ruangan', $data);
	}
	function update_transfer_ruangan($data, $noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('transfer_ruangan', $data);
	}

	function update_transfer_ruangan_id($data, $id)
	{
		$this->db->where('id', $id);
		return $this->db->update('transfer_ruangan', $data);
	}

	private function diagnosa_query($no_register)
	{
		$this->db->FROM('diagnosa_iri');
		$this->db->JOIN('pasien_iri', 'pasien_iri.no_ipd = diagnosa_iri.no_register', 'left');
		$this->db->where('diagnosa_iri.no_register', $no_register);
		$this->db->select('diagnosa_iri.diagnosa_text,diagnosa_iri.klasifikasi_diagnos,diagnosa_iri.id_diagnosa,diagnosa_iri.diagnosa,diagnosa_iri.id_diagnosa_pasien');

		$i = 0;
		foreach ($this->diagnosa_search as $item) {
			if ($_POST['search']['value']) {

				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->diagnosa_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->diagnosa_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->default_order_diagnosa)) {
			$order = $this->default_order_diagnosa;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		//  }
	}

	public function get_diagnosa_pasien($no_register)
	{
		$this->diagnosa_query($no_register);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function diagnosa_filtered($no_register)
	{
		$this->diagnosa_query($no_register);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function diagnosa_count_all($no_register)
	{
		$this->db->FROM('diagnosa_iri');
		$this->db->JOIN('pasien_iri', 'pasien_iri.no_ipd = diagnosa_iri.no_register', 'left');
		$this->db->where('diagnosa_iri.no_register', $no_register);
		return $this->db->count_all_results();
	}

	private function _get_datatables_query($no_register)
	{
		$this->db->FROM('icd9cm_iri');
		$this->db->JOIN('pasien_iri', 'pasien_iri.no_ipd = icd9cm_iri.no_register', 'left');
		$this->db->where('icd9cm_iri.no_register', $no_register);

		$i = 0;
		foreach ($this->procedure_search as $item) {
			if ($_POST['search']['value']) {

				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->procedure_search) - 1 == $i) {
					$this->db->group_end();
				}
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->procedure_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->default_order_procedure)) {
			$order = $this->default_order_procedure;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_procedure_pasien($no_register)
	{
		$this->_get_datatables_query($no_register);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function procedure_filtered($no_register)
	{
		$this->_get_datatables_query($no_register);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function procedure_count_all($no_register)
	{
		$this->db->FROM('icd9cm_iri');
		$this->db->JOIN('pasien_iri', 'pasien_iri.no_ipd = icd9cm_iri.no_register', 'left');
		$this->db->where('icd9cm_iri.no_register', $no_register);
		return $this->db->count_all_results();
	}

	function set_utama_procedure($id, $no_register)
	{
		$this->db->trans_begin();
		$this->db->query("UPDATE icd9cm_iri SET klasifikasi_procedure='tambahan' WHERE klasifikasi_procedure = 'utama' AND no_register = '$no_register'");
		$this->db->query("UPDATE icd9cm_iri SET klasifikasi_procedure='utama' WHERE id = '$id' ");
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return true;
	}

	function hapus_procedure($id_procedure_pasien)
	{
		$this->db->query("DELETE FROM icd9cm_iri WHERE id='$id_procedure_pasien'");
		return true;
	}

	function get_data_resume($no_ipd)
	{
		return $this->db->query("SELECT * FROM resume_pulang_iri where no_ipd ='$no_ipd' ");
	}

	function auto_utama($no_register)
	{
		$this->db->trans_begin();


		$get_diagnosa = $this->db->query("SELECT id FROM icd9cm_iri WHERE no_register = '$no_register' ORDER BY id ASC LIMIT 1")->row();
		if ($get_diagnosa && $get_diagnosa != NULL) {
			$this->db->query("UPDATE icd9cm_iri SET klasifikasi_procedure='utama' WHERE no_register = '$no_register' AND id='$get_diagnosa->id'");
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return true;
	}

	function get_soap_pasien_ri($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('soap_pasien_ri');
	}

	function delete_soap_pasien_ri($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('soap_pasien_ri');
	}

	function get_gudang_ruangsd($idrg)
	{
		return $this->db->query("SELECT * FROM ruang where idrg ='$idrg' ");
	}

	public function getlistkonsul($noreg)
	{
		return $this->db->query("SELECT a.id,concat(nm_poli,' | ',to_char(tgl_konsultasi,'DD-MM-YYYY HH24:MI:SS')) as nm_list from konsultasi_pasien_iri a, poliklinik b 
		where substring(a.id_poli_tujuan,1,4) = b.id_poli
		and no_ipd = '$noreg' ");
	}

	function insert_assesment_prasedasi($data)
	{
		return $this->db->insert('assesment_pra_sedasi', $data);
	}

	function get_assesment_pra_prasedasi($no_ipd)
	{
		return $this->db->query("select * from assesment_pra_sedasi where no_ipd = '$no_ipd' ");
	}

	function update_assesment_pra_prasedasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('assesment_pra_sedasi', $data);
	}

	function insert_assesment_pra_anastesi($data)
	{
		return $this->db->insert('assesment_pra_anestesi', $data);
	}

	function get_assesment_pra_anastesi($id_ok)
	{
		return $this->db->query("select * from assesment_pra_anestesi where id_ok = '$id_ok' ");
	}

	function get_assesment_pra_anastesi_by_noreg($id_ok)
	{
		return $this->db->query("select * from assesment_pra_anestesi where no_ipd = '$id_ok' ");
	}

	function update_assesment_pra_anastesi($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('assesment_pra_anestesi', $data);
	}

	function update_assesment_pra_anastesi_by_noreg($id_ok, $data)
	{
		$this->db->where('no_ipd', $id_ok);
		return $this->db->update('assesment_pra_anestesi', $data);
	}

	function insert_checklist_persiapan_operasi($data)
	{
		return $this->db->insert('checklist_persiapan_operasi', $data);
	}

	function get_checklist_persiapan_operasi($id)
	{
		return $this->db->query("select * from checklist_persiapan_operasi where id_ok = '$id' ");
	}

	function update_checklist_persiapan_operasi($id, $data)
	{
		$this->db->where('id_ok', $id);
		return $this->db->update('checklist_persiapan_operasi', $data);
	}

	function insert_laporan_medik_lokal_anastesi($data)
	{
		return $this->db->insert('lap_medik_lokal_anestesi', $data);
	}

	function get_lap_medik_lokal_anestesi($no_ipd)
	{
		return $this->db->query("select * from lap_medik_lokal_anestesi where no_ipd = '$no_ipd' ");
	}

	function update_lap_medik_lokal_anestesi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('lap_medik_lokal_anestesi', $data);
	}

	function insert_checklist_keselamatan_pasien_operasi($data)
	{
		return $this->db->insert('checklist_keselamatan_pasien_operasi', $data);
	}

	function get_checklist_keselamatan_pasien_operasi($id)
	{
		return $this->db->query("select * from checklist_keselamatan_pasien_operasi where id_ok = '$id' ");
	}

	function update_checklist_keselamatan_pasien_operasi($id, $data)
	{
		$this->db->where('id_ok', $id);
		return $this->db->update('checklist_keselamatan_pasien_operasi', $data);
	}

	function insert_asuhan_keperawatan_peri_operatif($data)
	{
		return $this->db->insert('asuhan_keperawatan_peri_operatif', $data);
	}

	function get_asuhan_keperawatan_peri_operatif($id_ok)
	{
		return $this->db->query("select * from asuhan_keperawatan_peri_operatif where id_ok = '$id_ok' ");
	}

	function update_asuhan_keperawatan_peri_operatif($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('asuhan_keperawatan_peri_operatif', $data);
	}

	function insert_catatan_observasi_khusus($data)
	{
		return $this->db->insert('catatan_observasi_khusus', $data);
	}

	function get_catatan_observasi_khusus($no_ipd)
	{
		return $this->db->query("select * from catatan_observasi_khusus where no_ipd = '$no_ipd' ");
	}

	function update_catatan_observasi_khusus($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('catatan_observasi_khusus', $data);
	}

	function get_persalinan_normal($no_ipd)
	{
		return $this->db->query("SELECT * FROM persalinan_normal where no_ipd='$no_ipd'");
	}

	function insert_persalinan_normal($data)
	{
		return $this->db->insert('persalinan_normal', $data);
	}

	function update_persalinan_normal($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('persalinan_normal', $data);
	}

	

	function get_catatan_neonatus($no_ipd)
	{
		return $this->db->query("SELECT * FROM catatan_awal_medis_neonetus where no_ipd='$no_ipd'");
	}

	function insert_catatan_neonetus($data)
	{
		return $this->db->insert('catatan_awal_medis_neonetus', $data);
	}

	function update_catatan_neonetus($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('catatan_awal_medis_neonetus', $data);
	}

	function get_assesment_resiko_jatuh($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_resiko_jatuh_anak where no_ipd='$no_ipd'");
	}

	function insert_assesment_resiko_jatuh($data)
	{
		return $this->db->insert('assesment_resiko_jatuh', $data);
	}

	function update_assesment_resiko_jatuh($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('assesment_resiko_jatuh', $data);
	}
	//
	function get_assesment_resiko_jatuh_dewasa($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_resiko_jatuh_dewasa where no_ipd='$no_ipd'");
	}

	function insert_assesment_resiko_jatuh_dewasa($data)
	{
		return $this->db->insert('pengkajian_resiko_jatuh_dewasa', $data);
	}

	function update_assesment_resiko_jatuh_dewasa($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_resiko_jatuh_dewasa', $data);
	}
	//

	function get_selisih_tarif($no_ipd)
	{
		return $this->db->query("SELECT * FROM selisih_tarif where no_ipd='$no_ipd'");
	}

	function insert_selisih_tarif($data)
	{
		return $this->db->insert('selisih_tarif', $data);
	}

	function update_selisih_tarif($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('selisih_tarif', $data);
	}

	function get_pengkajian_resiko_jatuh_anak($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_resiko_jatuh_anak where no_ipd='$no_ipd'");
	}

	function insert_pengkajian_resiko_jatuh_anak($data)
	{
		return $this->db->insert('pengkajian_resiko_jatuh_anak', $data);
	}

	function update_pengkajian_resiko_jatuh_anak($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_resiko_jatuh_anak', $data);
	}

	function get_pengkajian_rehab_medik($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_rehab_medik where no_ipd='$no_ipd'");
	}

	function insert_pengkajian_rehab_medik($data)
	{
		return $this->db->insert('pengkajian_rehab_medik', $data);
	}

	function update_pengkajian_rehab_medik($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_rehab_medik', $data);
	}

	function insert_persetujuan_anestesi($data)
	{
		return $this->db->insert('persetujuan_anestesi_ri', $data);
	}

	function update_persetujuan_anestesi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('persetujuan_anestesi_ri', $data);
	}

	function get_persetujuan_anestesi($no_ipd)
	{
		return $this->db->query("SELECT * FROM persetujuan_anestesi_ri where no_ipd='$no_ipd'");
	}

	function insert_gizi_anak($data)
	{
		return $this->db->insert('gizi_anak_ri', $data);
	}

	function update_gizi_anak($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('gizi_anak_ri', $data);
	}

	function get_gizi_anak($no_ipd)
	{
		return $this->db->query("SELECT * FROM gizi_anak_ri where no_ipd='$no_ipd'");
	}

	function insert_nyeri_komprehensif($data)
	{
		return $this->db->insert('pengkajian_nyeri_komprehensif', $data);
	}

	function update_nyeri_komprehensif($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_nyeri_komprehensif', $data);
	}

	function get_nyeri_komprehensif($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_nyeri_komprehensif where no_ipd='$no_ipd'");
	}

	function insert_persetujuan_dokter($data)
	{
		return $this->db->insert('persetujuan_kedokteran', $data);
	}

	function update_persetujuan_dokter($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('persetujuan_kedokteran', $data);
	}

	function get_persetujuan_dokter($no_ipd)
	{
		return $this->db->query("SELECT * FROM persetujuan_kedokteran where no_ipd='$no_ipd'");
	}

	function insert_penolakan_kedokteran($data)
	{
		return $this->db->insert('penolakan_kedokteran_ri', $data);
	}
	function update_penolakan_kedokteran($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('penolakan_kedokteran_ri', $data);
	}
	function get_penolakan_kedokteran($no_ipd)
	{
		return $this->db->query("SELECT * FROM penolakan_kedokteran_ri where no_ipd='$no_ipd'");
	}
	function insert_edukasi_anestesi($data)
	{
		return $this->db->insert('edukasi_anestesi_ri', $data);
	}
	function update_edukasi_anestesi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('edukasi_anestesi_ri', $data);
	}
	function get_edukasi_anestesi($no_ipd)
	{
		return $this->db->query("SELECT * FROM edukasi_anestesi_ri where no_ipd='$no_ipd'");
	}
	function insert_status_sedasi($data)
	{
		return $this->db->insert('status_sedasi_ri', $data);
	}
	function update_status_sedasi_by_noreg($id, $data)
	{
		$this->db->where('no_ipd', $id);
		return $this->db->update('status_sedasi_ri', $data);
	}
	function update_status_sedasi($id, $data)
	{
		$this->db->where('no_ipd', $id);
		return $this->db->update('status_sedasi_ri', $data);
	}
	function get_status_sedasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM status_sedasi_ri where no_ipd='$no_ipd'");
	}

	function get_status_sedasi_by_noreg($id)
	{
		return $this->db->query("SELECT * FROM status_sedasi_ri where no_ipd='$id'");
	}

	function insert_pre_operatif($data)
	{
		return $this->db->insert('keperawatan_preoperatif_ri', $data);
	}

	function update_pre_operatif($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('keperawatan_preoperatif_ri', $data);
	}
	function get_pre_operatif($no_ipd)
	{
		return $this->db->query("SELECT * FROM keperawatan_preoperatif_ri where no_ipd='$no_ipd'");
	}

	function insert_laporan_anestesi($data)
	{
		return $this->db->insert('laporan_anestesi', $data);
	}

	function update_laporan_anestesi($id, $data)
	{
		$this->db->where('id_ok', $id);

		return $this->db->update('laporan_anestesi', $data);
	}

	function update_laporan_anestesi_by_noreg($id, $data)
	{
		$this->db->where('no_ipd', $id);

		return $this->db->update('laporan_anestesi', $data);
	}
	function get_laporan_anestesi($id_ok)
	{
		return $this->db->query("SELECT * FROM laporan_anestesi where id_ok='$id_ok'");
	}

	function get_laporan_anestesi_by_noreg($id_ok)
	{
		return $this->db->query("SELECT * FROM laporan_anestesi where no_ipd='$id_ok'");
	}


	function insert_surat_rujukan($data)
	{
		return $this->db->insert('surat_rujukan', $data);
	}

	function update_surat_rujukan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);

		return $this->db->update('surat_rujukan', $data);
	}
	function get_surat_rujukan($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_rujukan where no_ipd='$no_ipd'");
	}

	function insert_permintaan_pulang_sendiri($data)
	{
		return $this->db->insert('permintaan_pulang_sendiri', $data);
	}

	function update_permintaan_pulang_sendiri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);

		return $this->db->update('permintaan_pulang_sendiri', $data);
	}
	function get_permintaan_pulang_sendiri($no_ipd)
	{
		return $this->db->query("SELECT * FROM permintaan_pulang_sendiri where no_ipd='$no_ipd'");
	}

	function insert_surat_pernyataan_dnr($data)
	{
		return $this->db->insert('surat_pernyataan_dnr', $data);
	}

	function update_surat_pernyataan_dnr($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);

		return $this->db->update('surat_pernyataan_dnr', $data);
	}
	function get_surat_pernyataan_dnr($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_pernyataan_dnr where no_ipd='$no_ipd'");
	}

	function insert_penundaan_pelayanan($data)
	{
		return $this->db->insert('penundaan_pelayanan', $data);
	}

	function update_penundaan_pelayanan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);

		return $this->db->update('penundaan_pelayanan', $data);
	}
	function get_penundaan_pelayanan($no_ipd)
	{
		return $this->db->query("SELECT * FROM penundaan_pelayanan where no_ipd='$no_ipd'");
	}


	function insert_pembedahan_anestesi_lokal($data)
	{
		return $this->db->insert('pembedahan_anestesi_lokal_ri', $data);
	}

	function get_laporan_pembedahan_anestesi_lokal($no_ipd)
	{
		return $this->db->query("SELECT * FROM pembedahan_anestesi_lokal_ri where no_ipd='$no_ipd'");
	}

	function update_laporan_pembedahan_anestesi_lokal($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pembedahan_anestesi_lokal_ri', $data);
	}

	function insert_pemberian_infus($data)
	{
		return $this->db->insert('pemberian_infus_ri', $data);
	}

	function get_pemberian_infus($no_ipd)
	{
		return $this->db->query("SELECT * FROM pemberian_infus_ri where no_ipd='$no_ipd'");
	}

	function update_pemberian_infus($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pemberian_infus_ri', $data);
	}

	function insert_monitoring_nyeri($data)
	{
		return $this->db->insert('monitoring_nyeri_ri', $data);
	}

	function get_monitoring_nyeri($no_ipd)
	{
		return $this->db->query("SELECT * FROM monitoring_nyeri_ri where no_ipd='$no_ipd'");
	}

	function update_monitoring_nyeri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('monitoring_nyeri_ri', $data);
	}

	function insert_surveilans($data)
	{
		return $this->db->insert('surveilans_ri', $data);
	}

	function get_surveilans($no_ipd)
	{
		return $this->db->query("SELECT * FROM surveilans_ri where no_ipd='$no_ipd'");
	}

	function update_surveilans($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('surveilans_ri', $data);
	}

	function insert_site_marking_ri($data)
	{
		return $this->db->insert('site_marking_ri', $data);
	}

	function update_site_marking_ri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);

		return $this->db->update('site_marking_ri', $data);
	}
	function get_site_marking_ri($no_ipd)
	{
		return $this->db->query("SELECT * FROM site_marking_ri where no_ipd='$no_ipd'");
	}

	function insert_asesmen_resiko_kejadian_dekubitus($data)
	{
		return $this->db->insert('asesmen_resiko_kejadian_dekubitus', $data);
	}

	function update_asesmen_resiko_kejadian_dekubitus($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('asesmen_resiko_kejadian_dekubitus', $data);
	}

	function get_asesmen_resiko_kejadian_dekubitus($no_ipd)
	{
		return $this->db->query("SELECT * FROM asesmen_resiko_kejadian_dekubitus where no_ipd='$no_ipd'");
	}

	function insert_tindakan_keperawatan($data)
	{
		return $this->db->insert('tindakan_keperawatan_iri', $data);
	}

	function update_tindakan_keperawatan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('tindakan_keperawatan_iri', $data);
	}

	function get_tindakan_keperawatan($no_ipd)
	{
		return $this->db->query("SELECT * FROM tindakan_keperawatan_iri where no_ipd='$no_ipd' ORDER BY tgl_input DESC");
	}

	function insert_asesmen_ginekologi_kebidanan($data)
	{
		return $this->db->insert('asesmen_ginekologi_kebidanan', $data);
	}

	function update_asesmen_ginekologi_kebidanan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('asesmen_ginekologi_kebidanan', $data);
	}

	function get_asesmen_ginekologi_kebidanan($no_ipd)
	{
		return $this->db->query("SELECT * FROM asesmen_ginekologi_kebidanan where no_ipd='$no_ipd'");
	}

	function insert_observasi_harian($data)
	{
		return $this->db->insert('lembar_observasi_harian', $data);
	}

	function get_observasi_harian($no_ipd)
	{
		return $this->db->query("SELECT * FROM lembar_observasi_harian where no_ipd='$no_ipd'");
	}

	function update_observasi_harian($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('lembar_observasi_harian', $data);
	}

	function insert_geriatri_ri($data)
	{
		return $this->db->insert('asesmen_awal_geriatri', $data);
	}

	function get_geriatri_ri($no_ipd)
	{
		return $this->db->query("SELECT * FROM asesmen_awal_geriatri where no_ipd='$no_ipd'");
	}

	function update_geriatri_ri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('asesmen_awal_geriatri', $data);
	}

	function get_laporan_operasi($id)
	{
		return $this->db->query("SELECT * FROM laporan_operasi where id_ok='$id'");
	}

	function get_laporan_operasi_by_noreg($no_ipd)
	{
		return $this->db->query("SELECT * FROM laporan_operasi where no_ipd='$no_ipd'");
	}

	function update_laporan_operasi($id, $data)
	{
		$this->db->where('id_ok', $id);
		return $this->db->update('laporan_operasi', $data);
	}

	function insert_laporan_operasi($data)
	{
		return $this->db->insert('laporan_operasi', $data);
	}

	function get_id_ok($no_ipd)
	{
		return $this->db->query("SELECT idoperasi_header from operasi_header where no_register = '$no_ipd' and status = 0");
	}

	function count_ket_raber($no_ipd)
	{
		return $this->db->query("SELECT ket FROM drtambahan_iri where ket like '%DPJP%' and no_register ='$no_ipd'");
	}

	function get_ipd_for_konsul($no_ipd)
	{
		return $this->db->query("SELECT id_dokter,dokter,no_ipd from pasien_iri where noregasal = '$no_ipd'");
	}

	function get_role($id)
	{
		return $this->db->query("SELECT roleid from dyn_role_user where userid = '$id'");
	}

	function insert_kio_resep_iri($data)
	{
		return $this->db->insert('kio_resep_iri', $data);
	}
	function update_kio_resep_iri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('kio_resep_iri', $data);
	}
	function get_kio_resep_iri_by_today($no_ipd, $tgl)
	{
		return $this->db->query("SELECT * FROM kio_resep_iri where no_ipd='$no_ipd' and tgl_resep = '$tgl'");
	}

	function get_kio_resep_iri($no_ipd)
	{
		return $this->db->query("SELECT * FROM kio_resep_iri where no_ipd='$no_ipd' order by tgl_resep desc limit 1");
	}


	function get_obat_racikan($noreg)
	{
		return $this->db->where('no_register', $noreg)->get('obat_racikan');
	}

	function get_kio_resep_igd($no_reg)
	{
		return $this->db->query("SELECT nm_obat as nama_obat,id_obat as item_obat,kali_harian,cara_pakai,obat_racikan from resep_dokter where no_register = '$no_reg'");
	}

	function get_kio_resep_igd_new($no_reg)
	{
		return $this->db->query("SELECT * from resep_dokter where no_register = '$no_reg'");
	}

	function update_kio_resep_iri_libur($no_ipd, $data, $Tgl)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->where('tgl_resep', $Tgl);
		return $this->db->update('kio_resep_iri', $data);
	}

	function get_data_obat_dpo($id, $id_gudang)
	{
		return $this->db->query("SELECT  *,(select nm_obat from master_obat where master_obat.id_obat = gudang_inventory.id_obat limit 1) from gudang_inventory where id_obat = $id and id_gudang = $id_gudang and deleted != 1");
	}

	function get_data_obat_sub($id)
	{
		return $this->db->query("SELECT a.id_obat,a.id_obat_sub,(select b.nm_obat from master_obat b where a.id_obat_sub = b.id_obat ) from obat_substitusi a where a.id_obat = $id");
	}

	function get_dokter()
	{
		return $this->db->query("SELECT distinct a.nm_dokter,b.userid from data_dokter a join dyn_user_dokter b on a.id_dokter = b.id_dokter order by a.nm_dokter asc");
	}

	function get_farmasi()
	{
		return $this->db->select('a.name as nm_dokter,a.userid')->from('hmis_users as a')->join('dyn_role_user as b', 'b.userid = a.userid')->where('b.role = \'Farmakologis\'')->get();
	}
	function get_perawat()
	{
		return $this->db->select('a.name as nm_dokter,a.userid')->from('hmis_users as a')->join('dyn_role_user as b', 'b.userid = a.userid')->where('b.role LIKE \'Perawat%\'')->get();
	}

	function get_perawat_kebidanan_ranap()
	{
		return $this->db->select('a.name as nm_dokter, a.userid')->from('hmis_users as a')->join('dyn_role_user as b', 'b.userid = a.userid')->where('b.roleid=\'1023\' or b.roleid = \'1021\'')->get();
	}


	function get_resep_psien_iri($noipd, $tgl)
	{
		return $this->db->query("SELECT * from resep_pasien where no_register = '$noipd' and tgl_resep = '$tgl'");
	}

	function get_resep_psien_iri_all($no_ipd)
	{
		return $this->db->query("SELECT * from resep_pasien where no_register = '$no_ipd'");
	}

	function get_data_gudang_dpo($id)
	{
		return $this->db->query("SELECT * FROM gudang_inventory where id_inventory = $id and deleted = 0");
	}

	function get_data_gudang_dpo_pergudang($id, $gudang_id)
	{
		return $this->db->query("SELECT * FROM gudang_inventory where id_inventory = $id and id_gudang = $gudang_id and deleted = 0");
	}



	function get_dpo_surveilans($no_ipd)
	{
		return $this->db->query("SELECT DISTINCT id_obat, nm_obat FROM dpo_iri WHERE no_ipd = '$no_ipd'");
	}

	function get_checklist_persiapan_operasi_by_noreg($id)
	{
		return $this->db->query("select * from checklist_persiapan_operasi where no_ipd = '$id' ");
	}

	function insert_gudang_dpo($data)
	{
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->name;
		$cek_gd1 = $this->check_stock_gd_asal($data['datagd']->id_inventory)->row()->jml;
		$stock_akhir = $cek_gd1 - $data['qty'];

		$this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, 
		keterangan, gudang1, stok_awal, penjualan, stok_akhir, created_by,expire_date,no_medrec)
		VALUES ('0', '" . $data['id_obat'] . "', '" . $data['datagd']->batch_no . "', 
		'" . date('Y-m-d H:i:s') . "', 
		'Transaksi Penjualan', '" . $data['datagd']->id_gudang . "', '" . $cek_gd1 . "', '" . $data['qty'] . "', '" . $stock_akhir . "', 
		'" . $user . "','" . $data['datagd']->expire_date . "','" . $data['no_medrec'] . "')");
		$stock_gd = $cek_gd1 - $data['qty'];

		$this->db->query("UPDATE gudang_inventory SET qty = $stock_gd
		WHERE id_inventory = '" . $data['datagd']->id_inventory . "'
		");

		return true;
	}

	function check_stock_gd_asal($id_inventory)
	{
		$query = $this->db->query("
        select qty as jml
                from gudang_inventory 
                where id_inventory = $id_inventory");

		return $query;
	}

	function insert_dpo($data)
	{
		$this->db->insert('dpo_iri', $data);
		return $this->db->insert_id();
	}

	function cek_obat_dpo($noreg, $tgl, $id)
	{
		return $this->db->query("SELECT id_obat from dpo_iri where no_ipd = '$noreg' and tgl_dpo = '$tgl' and id_obat = $id");
	}

	function update_dpo_batch($data)
	{
		return $this->db->update_batch('dpo_iri', $data, 'id');
	}

	function update_dpo($data, $no_ipd, $id_obat, $tgl)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->where('id_obat', $id_obat);
		$this->db->where('tgl_dpo', $tgl);
		$this->db->update('dpo_iri', $data);
		return true;
	}

	function get_obat_dpo($noreg, $tgl)
	{
		return $this->db->query("SELECT * from dpo_iri where no_ipd = '$noreg' and tgl_dpo = '$tgl'");
	}

	function get_data_punya_bayi()
	{
		return $this->db->query("SELECT no_ipd,nama,no_medrec,idrg,bed,tgl_masuk,nm_ruang,noregasal FROM pasien_iri where punya_bayi = 1 and daftar_bayi = 0");
	}

	function insert_pasien_bayi($data)
	{
		$this->db->insert('data_pasien', $data);
		$no_medrec = $this->db->insert_id();
		$no_cm = sprintf("%08d", $no_medrec);
		$this->db->set('no_cm', $no_cm);
		$this->db->where('no_medrec', $no_medrec);
		$this->db->update('data_pasien');
		return $no_medrec;
	}

	function get_data_pasien_by_no_cm($no_cm)
	{
		return $this->db->query("SELECT * FROM data_pasien a where a.no_medrec = $no_cm ");
	}

	function get_users()
	{
		return $this->db->query("SELECT
			hmis_users.username,
			hmis_users.NAME,
			dyn_role_user.userid
		FROM
			hmis_users,
			dyn_role_user
		WHERE 
			hmis_users.userid = dyn_role_user.userid");
	}

	function get_data_edit_tindakan($id)
	{
		return $this->db->query("SELECT
			b.nmtindakan,
			a.id_tindakan,
			a.qtyyanri,
			a.xuser,
			a.idoprtr,
			a.id_jns_layanan
		FROM
			pelayanan_iri_temp AS a,
			jenis_tindakan AS b
		WHERE 
			a.id_tindakan = b.idtindakan AND
			a.id_jns_layanan = '$id'");
	}

	function edit_tindakan($id, $data)
	{
		$this->db->where('id_jns_layanan', $id);
		$this->db->update('pelayanan_iri_temp', $data);
		return true;
	}

	function get_history_kio($no_ipd)
	{
		return $this->db->query("SELECT * FROM kio_resep_iri WHERE no_ipd = '$no_ipd'");
	}

	function get_history_dpo($no_ipd)
	{
		return $this->db->query("SELECT A
			.nm_obat,
			a.frekuensi,
			a.cara_pakai,
			a.dokter AS nmdokter,
			a.farmasi AS nmfarmasi,
			a.perawat AS nmperawat,
			a.tgl_dpo,
			resep_pasien.qty,
			resep_pasien.biaya_obat,
			resep_pasien.vtot
		FROM
			dpo_iri AS a
			join resep_pasien on resep_pasien.id_resep_dokter = a.id
		WHERE
			a.no_ipd = '$no_ipd' and resep_pasien.no_register = '$no_ipd'");
	}

	function get_data_tindakan_dpo()
	{
		return $this->db->query("SELECT distinct a.idtindakan,a.nmtindakan,b.total_tarif from jenis_tindakan a left join tarif_tindakan b 
		on a.idtindakan = b.id_tindakan 
		where idtindakan ='1B0205' OR 
		idtindakan ='1B0206' OR idtindakan ='1B0207' OR idtindakan ='1B0208' 
		OR idtindakan ='1B0210' OR idtindakan ='1B0213'
		OR idtindakan ='1B0211' OR idtindakan ='1B0214'");
	}

	function update_irna_antrian_pindah_ruang($no_reg, $no_medrec, $data)
	{
		$this->db->where('no_register_asal', $no_reg);
		$this->db->where('no_medrec', $no_medrec);
		return $this->db->update('irna_antrian', $data);
	}

	function get_no_ipd($noregasal)
	{
		return $this->db->query("SELECT no_ipd from pasien_iri where noregasal = '$noregasal' ");
	}

	function get_data_vtot_obat($noipd)
	{
		return $this->db->query("SELECT vtot_obat from pasien_iri where no_ipd = '$noipd'");
	}
	function get_catatan_serah_terima_ok($noipd)
	{
		return $this->db->query("SELECT * FROM serah_terima WHERE no_register='$noipd' 
		 ");
	}

	function hapus_data_obat_dpo($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('dpo_iri');
		return true;
	}

	function hapus_data_obat_resep_dpo($id)
	{
		$this->db->where('id_resep_dokter', $id);
		$this->db->delete('resep_pasien');
		return true;
	}

	function get_last_obat_kio($no_ipd)
	{
		return $this->db->where('no_ipd', $no_ipd)
			->order_by('id', 'desc')->limit(1)->get('kio_resep_iri');
	}

	function update_obat_pasien_iri($noipd)
	{
		return $this->db->where('no_ipd', $noipd)->update('pasien_iri', ['obat' => null]);
	}

	function get_master_obat_cara_pakai()
	{
		return $this->db->get('obat_cara_pakai');
	}

	function get_idrg_pasien_iri($no_ipd)
	{
		return $this->db->query("SELECT idrg FROM pasien_iri WHERE no_ipd = '$no_ipd'");
	}

	function get_surveilans_iri($no_ipd)
	{
		return $this->db->query("SELECT * FROM surveilans_ri WHERE no_ipd = '$no_ipd'");
	}

	function update_surveilans_iri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('surveilans_ri', $data);
		return true;
	}

	function get_surveilans_by_ok($idok)
	{
		return $this->db->query("SELECT * FROM surveilans_ri where id_ok='$idok'");
	}

	function get_noregasal($no_ipd)
	{
		return $this->db->query("SELECT noregasal FROM pasien_iri WHERE no_ipd = '$no_ipd'");
	}

	function get_suhu_from_pem_fisik($noregasal)
	{
		return $this->db->query("SELECT suhu FROM pemeriksaan_fisik WHERE no_register = '$noregasal'");
	}

	function get_data_obat_master_dpo()
	{
		return $this->db->query("SELECT id_obat,nm_obat from master_obat where deleted = 0 and id_obat >= 7000");
	}

	function get_signa_obat()
	{
		return $this->db->get('signa');
	}

	// grafik pemantauan laporan anestesi
	function insert_laporan_anestesi_grafik_pemantauan($data)
	{
		return $this->db->insert('laporan_anestesi_grafik_pemantauan', $data);
	}
	function update_laporan_anestesi_grafik_pemantauan($id, $data)
	{
		$this->db->where('id_ok', $id);
		return $this->db->update('laporan_anestesi_grafik_pemantauan', $data);
	}
	function get_laporan_anestesi_grafik_pemantauan($id_ok)
	{
		return $this->db->query("SELECT * FROM laporan_anestesi_grafik_pemantauan where id_ok='$id_ok'");
	}

	// grafik pemantauan status sedasi
	function insert_status_sedasi_grafik_pemantauan($data)
	{
		return $this->db->insert('status_sedasi_grafik_pemantauan', $data);
	}
	function update_status_sedasi_grafik_pemantauan($id, $data)
	{
		$this->db->where('id_ok', $id);
		return $this->db->update('status_sedasi_grafik_pemantauan', $data);
	}
	function get_status_sedasi_grafik_pemantauan($id_ok)
	{
		return $this->db->query("SELECT * FROM status_sedasi_grafik_pemantauan where id_ok='$id_ok'");
	}

	function get_id_konsul($id_dokter, $no_ipd)
	{
		return $this->db->query("SELECT id FROM konsultasi_pasien_iri WHERE no_ipd = '$no_ipd' AND id_dokter_penerima = '$id_dokter' AND tgl_jawaban IS NULL LIMIT 1");
	}

	function get_iddokter_noipd($no_ipd)
	{
		return $this->db->query("SELECT id_dokter FROM pasien_iri WHERE no_ipd = '$no_ipd'");
	}

	function get_diagnosa_pasien_iri($no_ipd)
	{
		return $this->db->query("SELECT diagnosa, klasifikasi_diagnos FROM diagnosa_iri WHERE no_register = '$no_ipd'");
	}

	function count_ket_dpjp($no_ipd)
	{
		return $this->db->query("SELECT ket FROM drtambahan_iri where ket like '%DPJP%' and no_register ='$no_ipd'");
	}

	function get_history_gizi($no_ipd)
	{
		return $this->db->query("SELECT * FROM gizi_permintaan_diet WHERE no_ipd = '$no_ipd'");
	}

	function get_asesmen_ulang_terminal_keluarga($no_ipd)
	{
		return $this->db->query("SELECT * FROM asesmen_ulang_terminal_keluarga WHERE no_ipd = '$no_ipd'");
	}

	function update_asesmen_ulang_terminal_keluarga($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('asesmen_ulang_terminal_keluarga', $data);
		return true;
	}

	function insert_asesmen_ulang_terminal_keluarga($data)
	{
		return $this->db->insert('asesmen_ulang_terminal_keluarga', $data);
	}

	function get_cuti_perawatan($no_ipd)
	{
		return $this->db->query("SELECT * FROM cuti_perawatan WHERE no_ipd = '$no_ipd'");
	}

	function update_cuti_perawatan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('cuti_perawatan', $data);
		return true;
	}

	function insert_cuti_perawatan($data)
	{
		return $this->db->insert('cuti_perawatan', $data);
	}

	function get_nihss($no_ipd)
	{
		return $this->db->query("SELECT * FROM nihss WHERE no_ipd = '$no_ipd'");
	}

	function update_nihss($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('nihss', $data);
		return true;
	}

	function insert_nihss($data)
	{
		return $this->db->insert('nihss', $data);
	}

	function get_patologi_klinik($no_ipd)
	{
		return $this->db->query("SELECT * FROM patologi_klinik WHERE no_register = '$no_ipd'");
	}

	function update_patologi_klinik($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('patologi_klinik', $data);
		return true;
	}

	function insert_patologi_klinik($data)
	{
		return $this->db->insert('patologi_klinik', $data);
	}

	function get_suket_sakit($no_ipd)
	{
		return $this->db->query("SELECT * FROM suket_sakit WHERE no_register = '$no_ipd'");
	}

	function update_suket_sakit($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('suket_sakit', $data);
		return true;
	}

	function insert_suket_sakit($data)
	{
		return $this->db->insert('suket_sakit', $data);
	}

	function get_pernyataan_cara_bayar_umum($no_ipd)
	{
		return $this->db->query("SELECT * FROM pernyataan_cara_bayar_umum WHERE no_register = '$no_ipd'");
	}

	function update_pernyataan_cara_bayar_umum($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('pernyataan_cara_bayar_umum', $data);
		return true;
	}

	function insert_pernyataan_cara_bayar_umum($data)
	{
		return $this->db->insert('pernyataan_cara_bayar_umum', $data);
	}

	function get_pernyataan_titip($no_ipd)
	{
		return $this->db->query("SELECT * FROM pernyataan_titip WHERE no_register = '$no_ipd'");
	}

	function update_pernyataan_titip($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('pernyataan_titip', $data);
		return true;
	}



	function get_keperawatan_geriatri($no_ipd)
	{
		return $this->db->query("SELECT * FROM keperawatan_geriatri WHERE no_register = '$no_ipd'");
	}

	function update_keperawatan_geriatri($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('keperawatan_geriatri', $data);
		return true;
	}

	function insert_keperawatan_geriatri($data)
	{
		return $this->db->insert('keperawatan_geriatri', $data);
	}

	function get_formulir_disfagia($no_ipd, $noreg)
	{
		return $this->db->query("SELECT * FROM formulir_disfagia WHERE no_register = '$no_ipd' or no_register = '$noreg'");
	}

	function update_formulir_disfagia($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('formulir_disfagia', $data);
		return true;
	}

	function insert_formulir_disfagia($data)
	{
		return $this->db->insert('formulir_disfagia', $data);
	}

	function get_data_rasal($noreg)
	{
		return $this->db->query("SELECT * FROM rasal where no_register='$noreg'");
	}

	function insert_rasal($data)
	{
		return $this->db->insert('rasal', $data);
	}

	function update_rasal($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('rasal', $data);
	}

	function get_data_raslan($noreg)
	{
		return $this->db->query("SELECT * FROM raslan where no_register='$noreg'");
	}

	function insert_raslan($data)
	{
		return $this->db->insert('raslan', $data);
	}

	function update_raslan($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('raslan', $data);
	}

	function get_edukasi_penolakan_rencana_asuhan($no_ipd)
	{
		return $this->db->query("SELECT * FROM edukasi_penolakan_rencana_asuhan WHERE no_register = '$no_ipd'");
	}

	function update_edukasi_penolakan_rencana_asuhan($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('edukasi_penolakan_rencana_asuhan', $data);
		return true;
	}

	function insert_edukasi_penolakan_rencana_asuhan($data)
	{
		return $this->db->insert('edukasi_penolakan_rencana_asuhan', $data);
	}

	function get_data_gyssens($noreg)
	{
		return $this->db->query("SELECT * FROM gyssens where no_register='$noreg'");
	}

	function insert_gyssens($data)
	{
		return $this->db->insert('gyssens', $data);
	}

	function update_gyssens($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('gyssens', $data);
	}

	function get_info_batch_retur($batch, $id_gudang, $id_obat)
	{
		return $this->db->query("SELECT * from gudang_inventory 
		where batch_no = '$batch' and id_gudang = '$id_gudang' 
		and id_obat = '$id_obat' and deleted != 1");
	}

	function update_stok_obat_retur($data)
	{
		$cek_gd1 = $this->get_info_batch_retur($data['batch_no'], $data['id_gudang'], $data['id_obat'])->row()->qty;

		$stock_akhir = $cek_gd1 + $data['qty'];
		$this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, 
		keterangan, gudang1, stok_awal, retur_pembelian, stok_akhir, created_by,expire_date)
		VALUES ('0', '" . $data['id_obat'] . "', '" . $data['batch_no'] . "', 
		'" . date('Y-m-d H:i:s') . "', 
		'Retur Penjualan', '" . $data['id_gudang'] . "', '" . $cek_gd1 . "', '" . $data['qty'] . "', '" . $stock_akhir . "', 
		'" . $this->session->userdata('username') . "','" . $data['expire_date'] . "')");
		return $this->db->query("UPDATE gudang_inventory SET qty = qty+'" . $data['qty'] . "' WHERE id_obat = '" . $data['id_obat'] . "' and id_gudang ='" . $data['id_gudang'] . "' and batch_no ='" . $data['batch_no'] . "' and deleted != 1");
	}

	function insert_stok_obat_retur($data)
	{
		// var_dump($data['id_gudang']);die();
		$this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date, hargajual)
		VALUES(
				'" . $data['id_gudang'] . "',
				'" . $data['id_obat'] . "',
				'" . $data['batch_no'] . "',
				'" . $data['qty'] . "',
				'" . $data['expire_date'] . "',
				'" . $data['hargajual'] . "'
			)");

		return $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, 
		keterangan, gudang1, stok_awal, retur_pembelian, stok_akhir, created_by,expire_date)
		VALUES ('0', '" . $data['id_obat'] . "', '" . $data['batch_no'] . "', 
		'" . date('Y-m-d H:i:s') . "', 
		'Retur Penjualan', '" . $data['id_gudang'] . "', '0', '" . $data['qty'] . "', '" . $data['qty'] . "', 
		'" . $this->session->userdata('username') . "','" . $data['expire_date'] . "')");
	}

	public function get_resep_pasien_last_day($no_ipd)
	{
		$tgl_terakhir = $this->db->query("SELECT tgl_resep from resep_pasien where no_register = '$no_ipd' ORDER BY id_resep_pasien desc limit 1")->row();
		return $this->db->query(
			"SELECT * from resep_pasien where no_register = '$no_ipd' and tgl_resep ='$tgl_terakhir->tgl_resep'"
		)->result();
	}

	public function get_batch_pasien_retur($id_inventory, $id_resep_pasien)
	{
		$batch = $this->db->query("SELECT batch_no,expire_date FROM gudang_inventory where id_inventory = $id_inventory")->row();
		$resep = $this->db->query(
			"SELECT * from resep_pasien where id_resep_pasien = $id_resep_pasien "
		)->row();
		return ['batch' => $batch, 'resep' => $resep];
	}

	function update_resep_pasien($data, $id_resep_pasien)
	{
		$this->db->where('id_resep_pasien', $id_resep_pasien);
		return $this->db->update('resep_pasien', $data);
	}


	function insert_pernyataan_titip($data)
	{
		return $this->db->insert('pernyataan_titip', $data);
	}

	function insert_header_piutang($data)
	{
		return $this->db->insert('header_piutang', $data);
	}

	function get_nosep_pasien($no_ipd)
	{
		return $this->db->query("SELECT no_sep FROM bpjs_sep WHERE no_register = '$no_ipd'");
	}

	function get_jaminan_pasien($no_ipd)
	{
		return $this->db->query("SELECT carabayar FROM pasien_iri WHERE no_ipd = '$no_ipd'");
	}

	function get_name_user_verif($userid)
	{
		return $this->db->query("SELECT name FROM hmis_users WHERE userid = $userid");
	}

	function getverifh_1($no_ipd)
	{
		return $this->db->query("SELECT * FROM verifpulangh_1 where no_ipd = '$no_ipd' ORDER BY id DESC LIMIT 1 ");
	}

	function insert_verifh_1($data)
	{
		return $this->db->insert('verifpulangh_1', $data);
	}

	function update_verifh_1($data, $no_ipd)
	{
		$this->db->where('no_ipd',$no_ipd);
		return $this->db->update('verifpulangh_1', $data);
	}

	public function get_list_perawat_pasien_by_no_ipd($no_ipd)
	{
		// $data=$this->db->query("
		// 	select *, IF(c.idkel_tind=0,'',(select nama_kel from kel_tind where idkel_tind=c.idkel_tind)) as nama_kel, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nmdokter, (SELECT nmruang from ruang where idrg=a.idrg) as nmruang 
		// 	from pelayanan_iri as a inner join data_pasien as b on a.nomederec = b.no_medrec
		// 	inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
		// 	where a.no_ipd = '$no_ipd' 
		// 	order by a.idoprtr asc
		// 	");
		// return $data->result_array();

		$data = $this->db->query("SELECT
			c.nmtindakan,
			SUM(a.qtyyanri) AS qtyyanri,
			SUM(a.vtot) AS vtot
		FROM
			pelayanan_iri AS a 
			LEFT JOIN jenis_tindakan AS C ON A.id_tindakan = C.idtindakan
		WHERE
			A.no_ipd = '$no_ipd' 
			AND SUBSTR(A.id_tindakan,0,3) NOT IN ('BK') 
			AND A.id_tindakan NOT IN ( '1B0134', '1B0137','PK0012','PK0013') 
			AND c.nmtindakan NOT LIKE '%darah%'
			AND c.nmtindakan NOT LIKE '%Darah%'
			AND c.idkel_inacbg != 2
			AND (c.idkel_inacbg != 14 OR c.id_kel != 1 )
		GROUP BY 
			c.nmtindakan");
		return $data->result_array();
	}

	public function get_list_rehab_pasien_by_no_ipd($no_ipd)
	{
		// $data=$this->db->query("
		// 	select *, IF(c.idkel_tind=0,'',(select nama_kel from kel_tind where idkel_tind=c.idkel_tind)) as nama_kel, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nmdokter, (SELECT nmruang from ruang where idrg=a.idrg) as nmruang 
		// 	from pelayanan_iri as a inner join data_pasien as b on a.nomederec = b.no_medrec
		// 	inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
		// 	where a.no_ipd = '$no_ipd' 
		// 	order by a.idoprtr asc
		// 	");
		// return $data->result_array();

		$data = $this->db->query("SELECT
			*,
		CASE
			WHEN C.idkel_tind = '0' THEN
			'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind ) 
		END AS nama_kel,
			( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
			( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
			(SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1) AS ttd_pelaksana,
			(SELECT name FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1) AS pelaksana,
			x.total_tarif AS tarif_jatah,
			x.tarif_bpjs AS tarif_jatah_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_bpjs,
			a.vtot AS total_per_tindakan
		FROM
			pelayanan_iri
			AS A INNER JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
			INNER JOIN jenis_tindakan AS C ON A.id_tindakan = C.idtindakan,
			tarif_tindakan AS x,
			pasien_iri AS y,
			ruang AS d 
		WHERE
			A.no_ipd = '$no_ipd' 
			AND a.no_ipd = y.no_ipd
			AND a.idrg = d.idrg
			AND x.kelas = y.jatahklsiri 
			AND A.id_tindakan = x.id_tindakan 
			AND SUBSTR(A.id_tindakan,0,3) = 'BK'
		ORDER BY
			A.tgl_layanan DESC
				");
		return $data->result_array();
	}

	function get_all_tindakan_new()
	{
		return $this->db->query("SELECT
				idtindakan,nmtindakan,tarif as total_tarif,tmno
			FROM
				jenis_tindakan_new 
			WHERE
				instalasi = 'IRI' 
				AND idtindakan NOT LIKE'AC%' 
			ORDER BY
				nmtindakan ASC");
	}

	function get_all_tindakan_new_by_jenis_hcu_icu($kls)
	{
		return $this->db->query("SELECT A
		.*,
		b.total_tarif 
	FROM
		jenis_tindakan_new
		A LEFT JOIN tarif_tindakan_new b ON A.idtindakan = b.id_tindakan 
	WHERE
		A.instalasi = 'IRI' 
		AND b.kelas = '$kls'
		AND (A.idtindakan LIKE'AC%' or A.idtindakan like '1A%')
		ORDER BY A.idtindakan");
	}

	function get_pemeriksaan_fisik_last($no_ipd)
	{
		return $this->db->query("select * from pemeriksaan_fisik_ri where no_ipd = '$no_ipd' order by id desc limit 1");
	}

	// addeded putri 06-02-2025
	function get_askep_general($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	asuhan_keperawatan_general where no_ipd='$no_ipd'");
	}

    function insert_askep_general($data)
	{
		return $this->db->insert('asuhan_keperawatan_general', $data);
	}

    function update_askep_general($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('asuhan_keperawatan_general', $data);
	}

	function get_pengkajian_decubitus($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	pengkajian_decubitus where no_ipd='$no_ipd'");
	}

    function insert_pengkajian_decubitus($data)
	{
		return $this->db->insert('pengkajian_decubitus', $data);
	}

    function update_pengkajian_decubitus($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_decubitus', $data);
	}

	function get_jatuh_neonatus($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	pengkajian_jatuh_neonatus where no_ipd='$no_ipd'");
	}

    function insert_jatuh_neonatus($data)
	{
		return $this->db->insert('pengkajian_jatuh_neonatus', $data);
	}

    function update_jatuh_neonatus($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_jatuh_neonatus', $data);
	}

	function get_keperawatan_perina($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	keperawatan_perina where no_ipd='$no_ipd'");
	}

    function insert_keperawatan_perina($data)
	{
		return $this->db->insert('keperawatan_perina', $data);
	}

    function update_keperawatan_perina($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('keperawatan_perina', $data);
	}

	function get_pengkajian_medis($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	pengkajian_medis_iri where no_ipd='$no_ipd'");
	}

    function insert_pengkajian_medis($data)
	{
		return $this->db->insert('pengkajian_medis_iri', $data);
	}

    function update_pengkajian_medis($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_medis_iri', $data);
	}

	function get_medis_kecanduan($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	pengkajian_medis_kecanduan where no_ipd='$no_ipd'");
	}

    function insert_medis_kecanduan($data)
	{
		return $this->db->insert('pengkajian_medis_kecanduan', $data);
	}

    function update_medis_kecanduan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_medis_kecanduan', $data);
	}

	function get_pengajuan_pembedahan($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	pengajuan_pembedahan where no_ipd='$no_ipd'");
	}

    function insert_pengajuan_pembedahan($data)
	{
		return $this->db->insert('pengajuan_pembedahan', $data);
	}

    function update_pengajuan_pembedahan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengajuan_pembedahan', $data);
	}

	function get_patologi_anatomi($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	patologi_anatomi where no_ipd='$no_ipd'");
	}

    function insert_patologi_anatomi($data)
	{
		return $this->db->insert('patologi_anatomi', $data);
	}

    function update_patologi_anatomi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('patologi_anatomi', $data);
	}

	function get_daftar_pemberian_terapi($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	daftar_pemberian_terapi where no_ipd='$no_ipd'");
	}

    function insert_daftar_pemberian_terapi($data)
	{
		return $this->db->insert('daftar_pemberian_terapi', $data);
	}

    function update_daftar_pemberian_terapi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('daftar_pemberian_terapi', $data);
	}

	function get_dischard_planing($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	dischard_planing where no_ipd='$no_ipd'");
	}

    function insert_dischard_planing($data)
	{
		return $this->db->insert('dischard_planing', $data);
	}

    function update_dischard_planing($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('dischard_planing', $data);
	}

	//added putri 07-02-2025

	function get_lembar_observasi_harian($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	lembar_observasi_harian where no_ipd='$no_ipd'");
	}

    function insert_lembar_observasi_harian($data)
	{
		return $this->db->insert('lembar_observasi_harian', $data);
	}

    function update_lembar_observasi_harian($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('lembar_observasi_harian', $data);
	}

	function get_pemantauan_pemberian_cairan($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	pemantauan_pemberian_cairan where no_ipd='$no_ipd'");
	}

    function insert_pemantauan_pemberian_cairan($data)
	{
		return $this->db->insert('pemantauan_pemberian_cairan', $data);
	}

    function update_pemantauan_pemberian_cairan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pemantauan_pemberian_cairan', $data);
	}

	function get_keperawatan_anak($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	pengkajian_keperawatan_anak where no_ipd='$no_ipd'");
	}

    function insert_keperawatan_anak($data)
	{
		return $this->db->insert('pengkajian_keperawatan_anak', $data);
	}

    function update_keperawatan_anak($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_keperawatan_anak', $data);
	}

	//added putri 10-02-2025
	function get_checklist_keselamatan_ok($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	checklist_keselamatan_pasien_operasi where no_ipd='$no_ipd'");
	}

    function insert_checklist_keselamatan_ok($data)
	{
		return $this->db->insert('checklist_keselamatan_pasien_operasi', $data);
	}

    function update_checklist_keselamatan_ok($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('checklist_keselamatan_pasien_operasi', $data);
	}

	function get_rencana_tindakan_keperawatan($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	rencana_tindakan_keperawatan where no_ipd='$no_ipd'");
	}

    function insert_rencana_tindakan_keperawatan($data)
	{
		return $this->db->insert('rencana_tindakan_keperawatan', $data);
	}

    function update_rencana_tindakan_keperawatan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('rencana_tindakan_keperawatan', $data);
	}

	function get_pengkajian_medis_anak($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	pengkajian_medik_anak where no_ipd='$no_ipd'");
	}

    function insert_pengkajian_medis_anak($data)
	{
		return $this->db->insert('pengkajian_medik_anak', $data);
	}

    function update_pengkajian_medis_anak($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_medik_anak', $data);
	}

	function get_pengkajian_medis_kb($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	pengkajian_medik_kb where no_ipd='$no_ipd'");
	}

    function insert_pengkajian_medis_kb($data)
	{
		return $this->db->insert('pengkajian_medik_kb', $data);
	}

    function update_pengkajian_medis_kb($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_medik_kb', $data);
	}

	function get_edukasi_anastesi_sedasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	edukasi_anastesi_sedasi where no_ipd='$no_ipd'");
	}

    function insert_edukasi_anastesi_sedasi($data)
	{
		return $this->db->insert('edukasi_anastesi_sedasi', $data);
	}

    function update_edukasi_anastesi_sedasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('edukasi_anastesi_sedasi', $data);
	}

	function get_kep_perioperatif($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	keperawatan_peri_operaktif where no_ipd='$no_ipd'");
	}

    function insert_kep_perioperatif($data)
	{
		return $this->db->insert('keperawatan_peri_operaktif', $data);
	}

    function update_kep_perioperatif($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('keperawatan_peri_operaktif', $data);
	}

	function get_cat_pemindahan_pasien($no_ipd)
	{
		return $this->db->query("SELECT * FROM 	catatan_pemindahan_pasien where no_ipd='$no_ipd'");
	}

    function insert_cat_pemindahan_pasien($data)
	{
		return $this->db->insert('catatan_pemindahan_pasien', $data);
	}

    function update_cat_pemindahan_pasien($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('catatan_pemindahan_pasien', $data);
	}

	function get_keperawatan_obgyn($no_ipd)
	{
		return $this->db->query("SELECT * FROM keperawatan_obgyn where no_ipd='$no_ipd'");
	}

    function insert_keperawatan_obgyn($data)
	{
		return $this->db->insert('keperawatan_obgyn', $data);
	}

    function update_keperawatan_obgyn($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('keperawatan_obgyn', $data);
	}

	function get_askep_hcu($no_ipd)
	{
		return $this->db->query("SELECT * FROM asuhan_keperawatan_hcu where no_ipd='$no_ipd'");
	}

    function insert_askep_hcu($data)
	{
		return $this->db->insert('asuhan_keperawatan_hcu', $data);
	}

    function update_askep_hcu($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('asuhan_keperawatan_hcu', $data);
	}

	function get_askep_kebidanan($no_ipd)
	{
		return $this->db->query("SELECT * FROM asuhan_keperawatan_kebidanan where no_ipd='$no_ipd'");
	}

    function insert_askep_kebidanan($data)
	{
		return $this->db->insert('asuhan_keperawatan_kebidanan', $data);
	}

    function update_askep_kebidanan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('asuhan_keperawatan_kebidanan', $data);
	}

	function get_medis_neonatus($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_medik_neonatus where no_ipd='$no_ipd'");
	}

    function insert_medis_neonatus($data)
	{
		return $this->db->insert('pengkajian_medik_neonatus', $data);
	}

    function update_medis_neonatus($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_medik_neonatus', $data);
	}

	function get_pra_anastesi_sedasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_pra_anastesi_sedasi where no_ipd='$no_ipd'");
	}

    function insert_pra_anastesi_sedasi($data)
	{
		return $this->db->insert('pengkajian_pra_anastesi_sedasi', $data);
	}

    function update_pra_anastesi_sedasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_pra_anastesi_sedasi', $data);
	}

	function get_resume_keperawatan($no_ipd)
	{
		return $this->db->query("SELECT * FROM resume_keperawatan where no_ipd='$no_ipd'");
	}

    function insert_resume_keperawatan($data)
	{
		return $this->db->insert('resume_keperawatan', $data);
	}

    function update_resume_keperawatan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('resume_keperawatan', $data);
	}

	function get_resume_pulang($no_ipd)
	{
		return $this->db->query("SELECT * FROM resume_pulang_iri where no_ipd='$no_ipd'");
	}

    function insert_resume_pulang($data)
	{
		return $this->db->insert('resume_pulang_iri', $data);
	}

    function update_resume_pulang($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('resume_pulang_iri', $data);
	}
	//table gabung dengan rj

	function get_pengantar_ranap($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengantar_rawat_inap where no_register='$no_ipd'");
	}

    function insert_pengantar_ranap($data)
	{
		return $this->db->insert('pengantar_rawat_inap', $data);
	}

    function update_pengantar_ranap($no_ipd, $data)
	{ 
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('pengantar_rawat_inap', $data);
	}
	// end

	function get_ringkasan_masuk_keluar($no_ipd)
	{
		return $this->db->query("SELECT * FROM ringkasan_masuk_keluar_ri where no_ipd='$no_ipd'");
	}

    function insert_ringkasan_masuk_keluar($data)
	{
		return $this->db->insert('ringkasan_masuk_keluar_ri', $data);
	}

    function update_ringkasan_masuk_keluar($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('ringkasan_masuk_keluar_ri', $data);
	}

	function get_paps($no_ipd)
	{
		return $this->db->query("SELECT * FROM paps where no_ipd='$no_ipd'");
	}

    function insert_paps($data)
	{
		return $this->db->insert('paps', $data);
	}

    function update_paps($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('paps', $data);
	}

	function get_penolakan_tindakan_medis($no_ipd)
	{
		return $this->db->query("SELECT * FROM penolakan_tindakan_medik where no_register='$no_ipd'");
	}

    function insert_penolakan_tindakan_medis($data)
	{
		return $this->db->insert('penolakan_tindakan_medik', $data);
	}

    function update_penolakan_tindakan_medis($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('penolakan_tindakan_medik', $data);
	}

	function get_persetujuan_tindakan_medis($no_ipd)
	{
		return $this->db->query("SELECT * FROM persetujuan_tindakan_medik where no_register='$no_ipd'");
	}

    function insert_persetujuan_tindakan_medis($data)
	{
		return $this->db->insert('persetujuan_tindakan_medik', $data);
	}

    function update_persetujuan_tindakan_medis($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('persetujuan_tindakan_medik', $data);
	}

	//added putri 11-02-2025
	function get_bayi_baru_lahir($no_ipd)
	{
		return $this->db->query("SELECT * FROM bayi_baru_lahir where no_ipd='$no_ipd'");
	}

    function insert_bayi_baru_lahir($data)
	{
		return $this->db->insert('bayi_baru_lahir', $data);
	}

    function update_bayi_baru_lahir($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('bayi_baru_lahir', $data);
	}

	function get_catatan_kamar_pemulihan($no_ipd)
	{
		return $this->db->query("SELECT * FROM catatan_kamar_pemulihan where no_ipd='$no_ipd'");
	}

    function insert_catatan_kamar_pemulihan($data)
	{
		return $this->db->insert('catatan_kamar_pemulihan', $data);
	}

    function update_catatan_kamar_pemulihan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('catatan_kamar_pemulihan', $data);
	}

	function get_catatan_pem_darah($no_ipd)
	{
		return $this->db->query("SELECT * FROM catatan_pemberian_darah where no_ipd='$no_ipd'");
	}

    function insert_catatan_pem_darah($data)
	{
		return $this->db->insert('catatan_pemberian_darah', $data);
	}

    function update_catatan_pem_darah($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('catatan_pemberian_darah', $data);
	}

	function get_grafik_vital($no_ipd)
	{
		return $this->db->query("SELECT * FROM catatan_grafik_vital where no_ipd='$no_ipd'");
	}

    function insert_grafik_vital($data)
	{
		return $this->db->insert('catatan_grafik_vital', $data);
	}

    function update_grafik_vital($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('catatan_grafik_vital', $data);
	}

	function get_identifikasi_bayi($no_ipd)
	{
		return $this->db->query("SELECT * FROM identifikasi_bayi where no_ipd='$no_ipd'");
	}

    function insert_identifikasi_bayi($data)
	{
		return $this->db->insert('identifikasi_bayi', $data);
	}

    function update_identifikasi_bayi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('identifikasi_bayi', $data);
	}

	function get_kontrol_intensive($no_ipd)
	{
		return $this->db->query("SELECT * FROM kontrol_intensive where no_ipd='$no_ipd'");
	}

    function insert_kontrol_intensive($data)
	{
		return $this->db->insert('kontrol_intensive', $data);
	}

    function update_kontrol_intensive($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('kontrol_intensive', $data);
	}

	function get_ppi($no_ipd)
	{
		return $this->db->query("SELECT * FROM penerapan_pencegahan_infeksi where no_ipd='$no_ipd'");
	}

    function insert_ppi($data)
	{
		return $this->db->insert('penerapan_pencegahan_infeksi', $data);
	}

    function update_ppi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('penerapan_pencegahan_infeksi', $data);
	}

	
	function get_keperawatan_hcu($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_kep_hcu where no_ipd='$no_ipd'");
	}

    function insert_keperawatan_hcu($data)
	{
		return $this->db->insert('pengkajian_kep_hcu', $data);
	}

    function update_keperawatan_hcu($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_kep_hcu', $data);
	}

	function get_resiko_infeksi($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_resiko_infeksi where no_ipd='$no_ipd'");
	}

    function insert_resiko_infeksi($data)
	{
		return $this->db->insert('pengkajian_resiko_infeksi', $data);
	}

    function update_resiko_infeksi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_resiko_infeksi', $data);
	}

	function get_resiko_geriatri($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_resiko_geriatri where no_ipd='$no_ipd'");
	}

    function insert_resiko_geriatri($data)
	{
		return $this->db->insert('pengkajian_resiko_geriatri', $data);
	}

    function update_resiko_geriatri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pengkajian_resiko_geriatri', $data);
	}

	function get_perawatan_dirumah($no_ipd)
	{
		return $this->db->query("SELECT * FROM perawatan_dirumah where no_ipd='$no_ipd'");
	}

    function insert_perawatan_dirumah($data)
	{
		return $this->db->insert('perawatan_dirumah', $data);
	}

    function update_perawatan_dirumah($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('perawatan_dirumah', $data);
	}

	function get_catatan_perawat($no_ipd)
	{
		return $this->db->query("SELECT * FROM catatan_perawat where no_ipd='$no_ipd'");
	}

    function insert_catatan_perawat($data)
	{
		return $this->db->insert('catatan_perawat', $data);
	}

    function update_catatan_perawat($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('catatan_perawat', $data);
	}
	//end

	//added putri 12-02-2025
	
	function get_pernyataan_radkontras($no_ipd)
	{
		return $this->db->query("SELECT * FROM pernyataan_radkontras where no_ipd='$no_ipd'");
	}

    function insert_pernyataan_radkontras($data)
	{
		return $this->db->insert('pernyataan_radkontras', $data);
	}

    function update_pernyataan_radkontras($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pernyataan_radkontras', $data);
	}

	function get_lodium_radioaktif($no_ipd)
	{
		return $this->db->query("SELECT * FROM lodium_radioaktif where no_ipd='$no_ipd'");
	}

    function insert_lodium_radioaktif($data)
	{
		return $this->db->insert('lodium_radioaktif', $data);
	}

    function update_lodium_radioaktif($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('lodium_radioaktif', $data);
	}

	function get_surat_resusitasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM pernyataan_resusitasi where no_ipd='$no_ipd'");
	}

    function insert_surat_resusitasi($data)
	{
		return $this->db->insert('pernyataan_resusitasi', $data);
	}

    function update_surat_resusitasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pernyataan_resusitasi', $data);
	}

	function get_suket_kelahiran($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_kelahiran where no_ipd='$no_ipd'");
	}

    function insert_suket_kelahiran($data)
	{
		return $this->db->insert('surat_kelahiran', $data);
	}

    function update_suket_kelahiran($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('surat_kelahiran', $data);
	}

	function get_ijin_op($no_ipd)
	{
		return $this->db->query("SELECT * FROM persetujuan_operasi where no_ipd='$no_ipd'");
	}

    function insert_ijin_op($data)
	{
		return $this->db->insert('persetujuan_operasi', $data);
	}

    function update_ijin_op($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('persetujuan_operasi', $data);
	}
	function get_serah_terima_bayi($no_ipd)
	{
		return $this->db->query("SELECT * FROM serah_terima_bayi where no_ipd='$no_ipd'");
	}

    function insert_serah_terima_bayi($data)
	{
		return $this->db->insert('serah_terima_bayi', $data);
	}

    function update_serah_terima_bayi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('serah_terima_bayi', $data);
	}

	function get_second_option($no_ipd)
	{
		return $this->db->query("SELECT * FROM second_options where no_ipd='$no_ipd'");
	}

    function insert_second_option($data)
	{
		return $this->db->insert('second_options', $data);
	}

    function update_second_option($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('second_options', $data);
	}

	function get_bayi_tabung($no_ipd)
	{
		return $this->db->query("SELECT * FROM bayi_tabung where no_ipd='$no_ipd'");
	}

    function insert_bayi_tabung($data)
	{
		return $this->db->insert('bayi_tabung', $data);
	}

    function update_bayi_tabung($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('bayi_tabung', $data);
	}

	function get_transfusi_darah($no_ipd)
	{
		return $this->db->query("SELECT * FROM permintaan_transfusi_darah where no_register='$no_ipd'");
	}

    function insert_transfusi_darah($data)
	{
		return $this->db->insert('permintaan_transfusi_darah', $data);
	}

    function update_transfusi_darah($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('permintaan_transfusi_darah', $data);
	}

	//end
	//added putri 13-02-2025
	function get_tindakan_hemodialisa($no_ipd)
	{
		return $this->db->query("SELECT * FROM tindakan_hemodialisa where no_ipd='$no_ipd'");
	}

    function insert_tindakan_hemodialisa($data)
	{
		return $this->db->insert('tindakan_hemodialisa', $data);
	}

    function update_tindakan_hemodialisa($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('tindakan_hemodialisa', $data);
	}
	
	function get_anastesi_sedasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM pernyataan_anastesi_sedasi where no_ipd='$no_ipd'");
	}

    function insert_anastesi_sedasi($data)
	{
		return $this->db->insert('pernyataan_anastesi_sedasi', $data);
	}

    function update_anastesi_sedasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pernyataan_anastesi_sedasi', $data);
	}

	function get_pernyataan_resistrain($no_ipd)
	{
		return $this->db->query("SELECT * FROM pernyataan_resistrain where no_ipd='$no_ipd'");
	}

    function insert_pernyataan_resistrain($data)
	{
		return $this->db->insert('pernyataan_resistrain', $data);
	}

    function update_pernyataan_resistrain($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pernyataan_resistrain', $data);
	}

	function get_permintaan_privasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM permintaan_privasi where no_ipd='$no_ipd'");
	}

    function insert_permintaan_privasi($data)
	{
		return $this->db->insert('permintaan_privasi', $data);
	}

    function update_permintaan_privasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('permintaan_privasi', $data);
	}

	function get_leaflet_hak($no_ipd)
	{
		return $this->db->query("SELECT * FROM tanda_terima_leaflet where no_ipd='$no_ipd'");
	}

    function insert_leaflet_hak($data)
	{
		return $this->db->insert('tanda_terima_leaflet', $data);
	}

    function update_leaflet_hak($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('tanda_terima_leaflet', $data);
	}

	function get_premedi_pasca_bedah($no_ipd)
	{
		return $this->db->query("SELECT * FROM premedi_pasca_bedah where no_ipd='$no_ipd'");
	}

    function insert_premedi_pasca_bedah($data)
	{
		return $this->db->insert('premedi_pasca_bedah', $data);
	}

    function update_premedi_pasca_bedah($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('premedi_pasca_bedah', $data);
	}
	function get_lembar_intruksi($no_ipd)
	{
		return $this->db->query("SELECT * FROM lembar_intruksi where no_ipd='$no_ipd'");
	}

    function insert_lembar_intruksi($data)
	{
		return $this->db->insert('lembar_intruksi', $data);
	}

    function update_lembar_intruksi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('lembar_intruksi', $data);
	}

	function get_laporan_pembedahan($no_ipd)
	{
		return $this->db->query("SELECT * FROM laporan_pembedahan where no_register='$no_ipd'");
	}

    function insert_laporan_pembedahan($data)
	{
		return $this->db->insert('laporan_pembedahan', $data);
	}

    function update_laporan_pembedahan($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('laporan_pembedahan', $data);
	}

	//end
	//added putri 14-02-2025
	function get_catatan_paliatif($no_ipd)
	{
		return $this->db->query("SELECT * FROM catatan_paliatif where no_ipd='$no_ipd'");
	}

    function insert_catatan_paliatif($data)
	{
		return $this->db->insert('catatan_paliatif', $data);
	}

    function update_catatan_paliatif($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('catatan_paliatif', $data);
	}

	function get_pembedahan_anastesi($no_ipd)
	{
		return $this->db->query("SELECT * FROM laporan_anestesi where no_ipd='$no_ipd'");
	}

    function insert_pembedahan_anastesi($data)
	{
		return $this->db->insert('laporan_anestesi', $data);
	}

    function update_pembedahan_anastesi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('laporan_anestesi', $data);
	}
	function get_pembedahan_anastesi_lokal($no_ipd)
	{
		return $this->db->query("SELECT * FROM laporan_anestesi_lokal where no_ipd='$no_ipd'");
	}

    function insert_pembedahan_anastesi_lokal($data)
	{
		return $this->db->insert('laporan_anestesi_lokal', $data);
	}

    function update_pembedahan_anastesi_lokal($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('laporan_anestesi_lokal', $data);
	}

	function get_hand_over($no_ipd)
	{
		return $this->db->query("SELECT * FROM hand_over where no_ipd='$no_ipd'");
	}

    function insert_hand_over($data)
	{
		return $this->db->insert('hand_over', $data);
	}

    function update_hand_over($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('hand_over', $data);
	}

	function get_assesment_nyeri($no_ipd)
	{
		return $this->db->query("SELECT * FROM assesment_nyeri where no_ipd='$no_ipd'");
	}

    function insert_assesment_nyeri($data)
	{
		return $this->db->insert('assesment_nyeri', $data);
	}

    function update_assesment_nyeri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('assesment_nyeri', $data);
	}

	function get_lembar_konsul_ri($no_ipd)
	{
		return $this->db->query("SELECT
				*,
				(select nm_dokter from data_dokter where lembar_konsul_ri.dokter_konsul = data_dokter.id_dokter) as dokter_konsulen,
				(select nm_dokter from data_dokter where lembar_konsul_ri.dokter_dpjp = data_dokter.id_dokter) as dokter
			FROM
				lembar_konsul_ri 
			WHERE
				no_ipd = '$no_ipd'");
	}

    function insert_lembar_konsul_ri($data)
	{
		return $this->db->insert('lembar_konsul_ri', $data);
	}

    function update_lembar_konsul_ri($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('lembar_konsul_ri', $data);
	}

	function get_diagnosa_igd($no_ipd)
	{
		return $this->db->query("SELECT
				* 
			FROM
				diagnosa_pasien 
			WHERE
				no_register = '$no_ipd' ");
	}
	function get_penandaan_lokasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM penandaan_lokasi where no_ipd='$no_ipd'");
	}

    function insert_penandaan_lokasi($data)
	{
		return $this->db->insert('penandaan_lokasi', $data);
	}

    function update_penandaan_lokasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('penandaan_lokasi', $data);
	}

	function get_monitoring_darah($no_ipd)
	{
		return $this->db->query("SELECT * FROM monitoring_transfusi_darah where no_ipd='$no_ipd'");
	}

    function insert_monitoring_darah($data)
	{
		return $this->db->insert('monitoring_transfusi_darah', $data);
	}

    function update_monitoring_darah($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('monitoring_transfusi_darah', $data);
	}

	function get_gizi($no_ipd)
	{
		return $this->db->query("SELECT * FROM daftar_pemberian_makanan where no_ipd='$no_ipd'");
	}

    function insert_gizi($data)
	{
		return $this->db->insert('daftar_pemberian_makanan', $data);
	}

    function update_gizi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('daftar_pemberian_makanan', $data);
	}

	function get_edukasi_terintegrasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM edukasi_terintegrasi where no_ipd='$no_ipd'");
	}

    function insert_edukasi_terintegrasi($data)
	{
		return $this->db->insert('edukasi_terintegrasi', $data);
	}

    function update_edukasi_terintegrasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('edukasi_terintegrasi', $data);
	}

	function get_transfer_pasien($no_ipd)
	{
		return $this->db->query("SELECT * FROM transfer_pasien where no_ipd='$no_ipd'");
	}

    function insert_transfer_pasien($data)
	{
		return $this->db->insert('transfer_pasien', $data);
	}

    function update_transfer_pasien($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('transfer_pasien', $data);
	}

	function get_surat_tugas($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_perintah_tugas where no_ipd='$no_ipd'");
	}

    function insert_surat_tugas($data)
	{
		return $this->db->insert('surat_perintah_tugas', $data);
	}

    function update_surat_tugas($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('surat_perintah_tugas', $data);
	}

	function get_intruksi_hcu($no_ipd)
	{
		return $this->db->query("SELECT * FROM intruksi_harian_hcu where no_ipd='$no_ipd'");
	}

    function insert_intruksi_hcu($data)
	{
		return $this->db->insert('intruksi_harian_hcu', $data);
	}

    function update_intruksi_hcu($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('intruksi_harian_hcu', $data);
	}

	function get_ews_dewasa($no_ipd)
	{
		return $this->db->query("SELECT * FROM ews_dewasa where no_ipd='$no_ipd'");
	}

    function insert_ews_dewasa($data)
	{
		return $this->db->insert('ews_dewasa', $data);
	}

    function update_ews_dewasa($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('ews_dewasa', $data);
	}

	function get_rencana_askep_hcu($no_ipd)
	{
		return $this->db->query("SELECT * FROM rencana_askep_hcu where no_ipd='$no_ipd'");
	}

    function insert_rencana_askep_hcu($data)
	{
		return $this->db->insert('rencana_askep_hcu', $data);
	}

    function update_rencana_askep_hcu($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('rencana_askep_hcu', $data);
	}

	function get_pews($no_ipd)
	{
		return $this->db->query("SELECT * FROM pews where no_ipd='$no_ipd'");
	}

    function insert_pews($data)
	{
		return $this->db->insert('pews', $data);
	}

    function update_pews($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pews', $data);
	}

	function get_surat_rujukan_new($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_rujukan where no_ipd='$no_ipd'");
	}

    function insert_surat_rujukan_new($data)
	{
		return $this->db->insert('surat_rujukan', $data);
	}

    function update_surat_rujukan_new($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('surat_rujukan', $data);
	}

	function get_surat_kematian($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_kematian where no_ipd='$no_ipd'");
	}

    function insert_surat_kematian($data)
	{
		return $this->db->insert('surat_kematian', $data);
	}

    function update_surat_kematian($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('surat_kematian', $data);
	}

	function get_persetujuan_penolakan_rujukan($no_ipd)
	{
		return $this->db->query("SELECT * FROM persetujuan_penolakan_rujukan where no_ipd='$no_ipd'");
	}

    function insert_persetujuan_penolakan_rujukan($data)
	{
		return $this->db->insert('persetujuan_penolakan_rujukan', $data);
	}

    function update_persetujuan_penolakan_rujukan($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('persetujuan_penolakan_rujukan', $data);
	}

	function get_pra_anastesi_sedasi_ok($id_ok)
	{
		return $this->db->query("SELECT * FROM pengkajian_pra_anastesi_sedasi where id_ok='$id_ok'");
	}

    function insert_pra_anastesi_sedasi_ok($data)
	{
		return $this->db->insert('pengkajian_pra_anastesi_sedasi', $data);
	}

    function update_pra_anastesi_sedasi_ok($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('pengkajian_pra_anastesi_sedasi', $data);
	}

	function get_kep_perioperatif_ok($id_ok)
	{
		return $this->db->query("SELECT * FROM 	keperawatan_peri_operaktif where id_ok='$id_ok'");
	}

    function insert_kep_perioperatif_ok($data)
	{
		return $this->db->insert('keperawatan_peri_operaktif', $data);
	}

    function update_kep_perioperatif_ok($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('keperawatan_peri_operaktif', $data);
	}

	function get_catatan_kamar_pemulihan_ok($id_ok)
	{
		return $this->db->query("SELECT * FROM catatan_kamar_pemulihan where id_ok='$id_ok'");
	}

    function insert_catatan_kamar_pemulihan_ok($data)
	{
		return $this->db->insert('catatan_kamar_pemulihan', $data);
	}

    function update_catatan_kamar_pemulihan_ok($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('catatan_kamar_pemulihan', $data);
	}

	function insert_pembedahan_anestesi_lokal_ok($data)
	{
		return $this->db->insert('pembedahan_anestesi_lokal_ri', $data);
	}

	function get_laporan_pembedahan_anestesi_lokal_ok($id_ok)
	{
		return $this->db->query("SELECT * FROM pembedahan_anestesi_lokal_ri where id_ok='$id_ok'");
	}

	function update_laporan_pembedahan_anestesi_lokal_ok($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('pembedahan_anestesi_lokal_ri', $data);
	}

	function get_pembedahan_anastesi_ok($id_ok)
	{
		return $this->db->query("SELECT * FROM laporan_anestesi where id_ok='$id_ok'");
	}

    function insert_pembedahan_anastesi_ok($data)
	{
		return $this->db->insert('laporan_anestesi', $data);
	}

    function update_pembedahan_anastesi_ok($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('laporan_anestesi', $data);
	}

	function get_premedi_pasca_bedah_ok($id_ok)
	{
		return $this->db->query("SELECT * FROM premedi_pasca_bedah where id_ok='$id_ok'");
	}

    function insert_premedi_pasca_bedah_ok($data)
	{
		return $this->db->insert('premedi_pasca_bedah', $data);
	}

    function update_premedi_pasca_bedah_ok($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('premedi_pasca_bedah', $data);
	}

	function insert_status_sedasi_ok($data)
	{
		return $this->db->insert('status_sedasi_ri', $data);
	}
	function update_status_sedasi_ok($id, $data)
	{
		$this->db->where('id_ok', $id);
		return $this->db->update('status_sedasi_ri', $data);
	}
	function get_status_sedasi_ok($id_ok)
	{
		return $this->db->query("SELECT * FROM status_sedasi_ri where id_ok='$id_ok'");
	}

	function get_anastesi_sedasi_ok($id_ok)
	{
		return $this->db->query("SELECT * FROM pernyataan_anastesi_sedasi where id_ok='$id_ok'");
	}

    function insert_anastesi_sedasi_ok($data)
	{
		return $this->db->insert('pernyataan_anastesi_sedasi', $data);
	}

    function update_anastesi_sedasi_ok($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('pernyataan_anastesi_sedasi', $data);
	}

	function insert_edukasi_anestesi_ok($data)
	{
		return $this->db->insert('edukasi_anestesi_ri', $data);
	}
	function update_edukasi_anestesi_ok($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('edukasi_anestesi_ri', $data);
	}
	function get_edukasi_anestesi_ok($id_ok)
	{
		return $this->db->query("SELECT * FROM edukasi_anestesi_ri where id_ok='$id_ok'");
	}

	function insert_kio_resep_dokter($data)
	{
		return $this->db->insert('resep_dokter', $data);
	}

	function getdata_pa_pasien_ri($no_ipd, $datenow)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi as a
			WHERE a.no_register = '$no_ipd' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
			");
	}

	function getdata_utd_pasien_ri($no_ipd, $datenow)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_unitdarah as a
			WHERE a.no_register = '$no_ipd' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
			");
	}

	function get_askep_anak($no_ipd)
	{
		return $this->db->query("SELECT * FROM askep_anak where no_ipd='$no_ipd'");
	}

    function insert_askep_anak($data)
	{
		return $this->db->insert('askep_anak', $data);
	}

    function update_askep_anak($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('askep_anak', $data);
	}

	function get_meows($no_ipd)
	{
		return $this->db->query("SELECT * FROM meows where no_ipd='$no_ipd'");
	}

    function insert_meows($data)
	{
		return $this->db->insert('meows', $data);
	}

    function update_meows($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('meows', $data);
	}

	function get_lembar_konsul_ri_tgl($no_ipd)
	{
		return $this->db->query("SELECT * FROM lembar_konsul_ri where tgl_jawaban is null and no_ipd='$no_ipd'");
	}

	function cek_resep_pasien_dokter($no_reg,$tgl_now,$id_obat)
	{
		return $this->db->query("select * from resep_dokter where no_register = '$no_reg' and tgl_kunjungan = '$tgl_now' and id_obat='$id_obat'");
	}

	function cek_resep_pasien_dokter_racikan($no_reg,$tgl_now,$nmracikan)
	{
		return $this->db->query("select * from resep_dokter where no_register = '$no_reg' and tgl_kunjungan = '$tgl_now' and nm_obat='$nmracikan'");
	}

	function cek_resep_pasien_dokter_racikan_pulang($no_reg,$tgl_now,$nmracikan)
	{
		return $this->db->query("select * from resep_dokter where no_register = '$no_reg' and obat_pulang = '1' and nm_obat='$nmracikan'");
	}

	function get_nm_obat_for_racikan($id_obat)
	{
		return $this->db->query("select id_obat,nm_obat from master_obat where id_obat ='$id_obat'");
	}
	function get_data_from_igd($no_reg)
	{
		return $this->db->query("SELECT
				formjson ->> 'keluhan' AS keluhan ,
				formjson ->> 'diagnosa' AS diagnosa ,
				formjson ->> 'rencana' AS rencana
			FROM
				pengkajian_medis_igd 
			WHERE
				no_register = '$no_reg';");
	}

	function insert_kio_resep_dokter_racikan($data)
	{
		$this->db->insert('resep_dokter', $data);
		return $this->db->insert_id();
	}

	function insert_item_resep_dokter_racikan($data)
	{
		return $this->db->insert('obat_racikan', $data);
	}

	function getdata_form_json($no_ipd)
	{
		return $this->db->query("SELECT
				formjson ->> 'keluhan' AS keluhan,
				formjson ->> 'pemeriksaan_penunjang' AS pem_fisik,
				formjson ->> 'riwayat' AS riwayat_penyakit,
				formjson ->> 'question4' AS diagnosa_kerja,
				formjson ->> 'question3' AS pem_penunjang,
				formjson ->> 'question8' AS rencana_pengobatan

			FROM
				pengkajian_medis_iri where no_ipd = '$no_ipd'
		");
	}
	function getdata_form_json2($no_ipd)
	{
		return $this->db->query("SELECT
				formjson ->> 'keluhan_utama' AS keluhan,
				formjson ->> 'riwayat_penyakit_sekarang' AS riwayat_penyakit,
				formjson ->> 'question18' AS diagnosa_kerja,
				formjson ->> 'question17' AS pem_penunjang

			FROM
				pengkajian_medik_anak where no_ipd = '$no_ipd'
		");
	}
	function getdata_form_json3($no_ipd)
	{
		return $this->db->query("SELECT
				formjson ->> 'keluhan' AS keluhan,
				formjson ->> 'riwayat' AS riwayat_penyakit,
				formjson ->> 'diagnosis_kerja' AS diagnosa_kerja,
				formjson ->> 'question3' AS pem_penunjang

			FROM
				pengkajian_medik_neonatus where no_ipd = '$no_ipd'
		");
	}
	function get_data_from_irj($no_reg)
	{
		return $this->db->query("SELECT
				formjson -> 'question1' -> 'kel_utama' ->> 'anamnesis1' AS keluhan,
				formjson ->> 'question4' AS diagnosa
			FROM
				pengkajian_medis_rj
			WHERE
				no_register = '$no_reg';
			");
	}

	function get_pemakaian_ventilator($no_ipd)
	{
		return $this->db->query("SELECT * FROM pemakaian_ventilator where no_ipd='$no_ipd'");
	}

    function insert_pemakaian_ventilator($data)
	{
		return $this->db->insert('pemakaian_ventilator', $data);
	}

    function update_pemakaian_ventilator($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('pemakaian_ventilator', $data);
	}
	
	function get_data_from_igd2($no_reg)
	{
		return $this->db->query("SELECT
				formjson ->> 'mohon' AS mohon ,
				formjson ->> 'ruangan' AS ruangan ,
				formjson ->> 'terapi' AS terapi ,
				formjson ->> 'ttd_hormat' AS ttd_hormat ,
				formjson ->> 'ttd' AS ttd ,
				formjson ->> 'ruangan4' AS ruangan4 ,
				formjson ->> 'question3' AS question3 ,
				formjson ->> 'question4' AS question4 ,
				formjson ->> 'ruangan6' AS ruangan6 ,
				formjson ->> 'question2' AS question2 ,
				formjson ->> 'question5' AS question5 
			FROM
				pengantar_rawat_inap 
			WHERE
				no_register = '$no_reg';");
	}
	function get_diag_for_pengkajian_medis($noreg)
	{
		return $this->db->query("SELECT id_diagnosa,diagnosa,klasifikasi_diagnos FROM diagnosa_pasien where no_register = '$noreg'");
	}
	function get_lab_pasien($noreg)
	{
		return $this->db->query("SELECT jenis_tindakan FROM pemeriksaan_laboratorium where no_register='$noreg'");
	}

	function get_rad_pasien($noreg)
	{
		return $this->db->query("SELECT jenis_tindakan FROM pemeriksaan_radiologi where no_register='$noreg'");
	}

	function update_konsultasi($no_ipd,$id, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->where('id', $id);
		return $this->db->update('lembar_konsul_ri', $data);
	}
	function get_persetujuan_transfusi_darah($no_ipd)
	{
		return $this->db->query("SELECT * FROM persetujuan_transfusi_darah where no_ipd='$no_ipd'");
	}

    function insert_persetujuan_transfusi_darah($data)
	{
		return $this->db->insert('persetujuan_transfusi_darah', $data);
	}

    function update_persetujuan_transfusi_darah($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('persetujuan_transfusi_darah', $data);
	}

	function get_obat_pulang($no_ipd)
	{
		return $this->db->query("SELECT
				elem ->> 'nm_obat' AS nm_obat 
			FROM
				kio_resep_iri,
				LATERAL json_array_elements ( kio -> 'question2' ) AS elem 
			WHERE
				no_ipd = '$no_ipd' order by id desc");
	}
	
	function get_assesment_pra_induksi($id_ok)
	{
		return $this->db->query("SELECT * FROM assesment_pra_induksi where id_ok='$id_ok'");
	}

    function insert_assesment_pra_induksi($data)
	{
		return $this->db->insert('assesment_pra_induksi', $data);
	}

    function update_assesment_pra_induksi($id_ok, $data)
	{
		$this->db->where('id_ok', $id_ok);
		return $this->db->update('assesment_pra_induksi', $data);
	}
	function getdata_form_json_ok($no_ipd)
	{
		return $this->db->query("SELECT
			formjson -> 'question4' ->> 'text1' AS tb,
			formjson -> 'question4' ->> 'text2' AS bb,
			formjson -> 'question13' ->> 'text1' AS td,
			formjson -> 'question13' ->> 'text2' AS n,
			formjson -> 'question13' ->> 'text3' AS rr,
			formjson -> 'question13' ->> 'text4' AS suhu,
			formjson -> 'question10' ->> 'text1' AS jenis,
			formjson -> 'question2' AS diagnosa
	FROM
		pengkajian_pra_anastesi_sedasi 
	WHERE
		no_ipd = '$no_ipd';
		");
	}

	function get_skrining_pasien($no_ipd)
	{
		return $this->db->query("SELECT * FROM skrining_pasien where no_ipd='$no_ipd'");
	}

    function insert_skrining_pasien($data)
	{
		return $this->db->insert('skrining_pasien', $data);
	}

    function update_skrining_pasien($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('skrining_pasien', $data);
	}

	function get_formulir_mpp($no_ipd)
	{
		return $this->db->query("SELECT * FROM formulir_mpp where no_ipd='$no_ipd'");
	}

    function insert_formulir_mpp($data)
	{
		return $this->db->insert('formulir_mpp', $data);
	}

    function update_formulir_mpp($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('formulir_mpp', $data);
	}

	function get_form_a_mpp($no_ipd)
	{
		return $this->db->query("SELECT * FROM form_a_mpp where no_ipd='$no_ipd'");
	}

    function insert_form_a_mpp($data)
	{
		return $this->db->insert('form_a_mpp', $data);
	}

    function update_form_a_mpp($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('form_a_mpp', $data);
	}
	function get_upload_penunjang($no_ipd)
	{
		return $this->db->query("SELECT * FROM upload_pemeriksaan_penunjang where no_register='$no_ipd'");
	}

    function insert_upload_penunjang($data)
	{
		return $this->db->insert('upload_pemeriksaan_penunjang', $data);
	}

    function update_upload_penunjang($no_ipd, $data)
	{ 
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('upload_pemeriksaan_penunjang', $data);
	}

	function get_jenis_ruang($idrg)
	{
		return $this->db->query("select * from ruang where idrg = '$idrg'");
	}

	function get_id_poli($noreg)
	{
		return $this->db->query("select id_poli from daftar_ulang_irj where no_register = '$noreg'");
	}

	function get_subjective_last($ipd)
	{
		return $this->db->query("select * from soap_pasien_ri where no_ipd = '$ipd' order by id desc limit 1");
	}

	function get_pengantar_ranap_igd($no_reg)
	{
		return $this->db->query("SELECT
				formjson ->> 'terapi' AS terapi 
			FROM
				pengantar_rawat_inap 
			WHERE
				no_register = '$no_reg'");
	}
	function get_fisik_igd($no_reg)
	{
		return $this->db->query("SELECT
				formjson ->> 'fisikgamab' AS fisik 
			FROM
				pengkajian_medis_igd 
			WHERE
				no_register = '$no_reg'");
	}
	function get_surat_kontrol($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_kontrol where no_ipd='$no_ipd'");
	}

    function insert_surat_kontrol($data)
	{
		return $this->db->insert('surat_kontrol', $data);
	}

    function update_surat_kontrol($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('surat_kontrol', $data);
	}
	function getdata_resume_json($no_ipd)
	{
		return $this->db->query("SELECT
				formjson ->> 'question4' AS pemeriksaan_fisik,
				formjson ->> 'question13' AS anjuran,
				formjson ->> 'question5' AS penunjang,
				formjson ->> 'question6' AS diagnosa,
				formjson ->> 'question15' AS terapi

			FROM
				resume_pulang_iri where no_ipd = '$no_ipd'
		");
	}

	function get_masuk_icu($no_ipd)
	{
		return $this->db->query("SELECT * FROM kriteria_masuk_icu where no_ipd='$no_ipd'");
	}

    function insert_masuk_icu($data)
	{
		return $this->db->insert('kriteria_masuk_icu', $data);
	}

    function update_masuk_icu($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('kriteria_masuk_icu', $data);
	}

	function get_keluar_perina($no_ipd)
	{
		return $this->db->query("SELECT * FROM kriteria_keluar_perina where no_ipd='$no_ipd'");
	}

    function insert_keluar_perina($data)
	{
		return $this->db->insert('kriteria_keluar_perina', $data);
	}

    function update_keluar_perina($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('kriteria_keluar_perina', $data);
	}

	function get_masuk_perina($no_ipd)
	{
		return $this->db->query("SELECT * FROM kriteria_masuk_perina where no_ipd='$no_ipd'");
	}

    function insert_masuk_perina($data)
	{
		return $this->db->insert('kriteria_masuk_perina', $data);
	}

    function update_masuk_perina($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('kriteria_masuk_perina', $data);
	}

	function get_prosedur_non_bedah($ipd)
	{
		return $this->db->query("SELECT
				*,
			CASE
					
					WHEN C.idkel_tind = '0' THEN
					'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind limit 1 ) 
				END AS nama_kel,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
				( SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS ttd_pelaksana,
				( SELECT NAME FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS pelaksana 
			FROM
				pelayanan_iri
				AS A LEFT JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
				INNER JOIN jenis_tindakan_new AS C ON A.id_tindakan = C.idtindakan,
				pasien_iri AS y,
				ruang AS d 
			WHERE
				A.no_ipd = '$ipd' 
				AND A.no_ipd = y.no_ipd 
				AND A.idrg = d.idrg 
				AND (C.idkel_inacbg = '13' or C.idkel_inacbg is null)
			ORDER BY
				A.tgl_layanan DESC");
	}

	function get_prosedur_bedah($ipd)
	{
		return $this->db->query("SELECT A
			.*,
			b.nm_dokter AS dok_ok
		FROM
			pemeriksaan_operasi AS A,
			data_dokter AS b,
			pasien_iri AS y 
		WHERE
			A.no_register = y.no_ipd 
			AND A.id_dokter = b.id_dokter 
			AND A.no_ok IS NOT NULL 
			AND A.no_register = '$ipd'");
	}

	function get_konsultasi($ipd)
	{
		return $this->db->query("SELECT
				*,
			CASE
					
					WHEN C.idkel_tind = '0' THEN
					'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind limit 1 ) 
				END AS nama_kel,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
				( SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS ttd_pelaksana,
				( SELECT NAME FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS pelaksana 
			FROM
				pelayanan_iri
				AS A LEFT JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
				INNER JOIN jenis_tindakan_new AS C ON A.id_tindakan = C.idtindakan,
				pasien_iri AS y,
				ruang AS d 
			WHERE
				A.no_ipd = '$ipd' 
				AND A.no_ipd = y.no_ipd 
				AND A.idrg = d.idrg 
				AND C.idkel_inacbg = '6'
			ORDER BY
				A.tgl_layanan DESC");
	}


	function get_tenaga_ahli($ipd)
	{
		return $this->db->query("SELECT
				*,
			CASE
					
					WHEN C.idkel_tind = '0' THEN
					'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind limit 1 ) 
				END AS nama_kel,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
				( SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS ttd_pelaksana,
				( SELECT NAME FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS pelaksana 
			FROM
				pelayanan_iri
				AS A LEFT JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
				INNER JOIN jenis_tindakan_new AS C ON A.id_tindakan = C.idtindakan,
				pasien_iri AS y,
				ruang AS d 
			WHERE
				A.no_ipd = '$ipd' 
				AND A.no_ipd = y.no_ipd 
				AND A.idrg = d.idrg 
				AND C.idkel_inacbg = '1'
			ORDER BY
				A.tgl_layanan DESC");
	}

	function get_keperawatan($ipd)
	{
		return $this->db->query("SELECT
				*,
			CASE
					
					WHEN C.idkel_tind = '0' THEN
					'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind limit 1) 
				END AS nama_kel,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
				( SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS ttd_pelaksana,
				( SELECT NAME FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS pelaksana 
			FROM
				pelayanan_iri
				AS A LEFT JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
				INNER JOIN jenis_tindakan_new AS C ON A.id_tindakan = C.idtindakan,
				pasien_iri AS y,
				ruang AS d 
			WHERE
				A.no_ipd = '$ipd' 
				AND A.no_ipd = y.no_ipd 
				AND A.idrg = d.idrg 
				AND C.idkel_inacbg = '11'
			ORDER BY
				A.tgl_layanan DESC");
	}

	function get_akomodasi($ipd)
	{
		return $this->db->query("SELECT
				*,
			CASE
					
					WHEN C.idkel_tind = '0' THEN
					'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind limit 1) 
				END AS nama_kel,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
				( SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS ttd_pelaksana,
				( SELECT NAME FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS pelaksana 
			FROM
				pelayanan_iri
				AS A LEFT JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
				INNER JOIN jenis_tindakan_new AS C ON A.id_tindakan = C.idtindakan,
				pasien_iri AS y,
				ruang AS d 
			WHERE
				A.no_ipd = '$ipd' 
				AND A.no_ipd = y.no_ipd 
				AND A.idrg = d.idrg 
				AND C.idkel_inacbg = '8'
			ORDER BY
				A.tgl_layanan DESC");
	}

	function get_rad($ipd)
	{
		return $this->db->query("SELECT A
			.* 
		FROM
			pemeriksaan_radiologi AS A,
			jenis_tindakan_new AS x,
			pasien_iri AS y 
		WHERE
			A.id_tindakan = x.idtindakan 
			AND A.no_register = y.no_ipd 
			AND A.no_register = '$ipd' 
			AND A.no_rad IS NOT NULL 
		ORDER BY
			A.xupdate ASC");
	}

	function get_labor($ipd)
	{
		return $this->db->query("SELECT A
			.*
		FROM
			pemeriksaan_laboratorium AS A,
			jenis_tindakan_new AS x,
			pasien_iri AS y 
		WHERE
			A.id_tindakan = x.idtindakan 
			AND A.no_register = y.no_ipd 
			AND y.no_ipd = '$ipd' 
			AND no_lab IS NOT NULL");
	}

	public function get_resep($no_ipd)
	{
		$data = $this->db->query("SELECT 
			a.*, 
			b.kategori6 
		FROM 
			resep_pasien AS a 
			LEFT OUTER JOIN master_obat AS b ON a.item_obat::int = b.id_obat
		WHERE a.no_register = '$no_ipd'");
		return $data->result_array();
	}

	function get_penunjang($ipd)
	{
		return $this->db->query("SELECT
				*,
			CASE
					
					WHEN C.idkel_tind = '0' THEN
					'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind limit 1 ) 
				END AS nama_kel,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
				( SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS ttd_pelaksana,
				( SELECT NAME FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS pelaksana 
			FROM
				pelayanan_iri
				AS A LEFT JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
				INNER JOIN jenis_tindakan_new AS C ON A.id_tindakan = C.idtindakan,
				pasien_iri AS y,
				ruang AS d 
			WHERE
				A.no_ipd = '$ipd' 
				AND A.no_ipd = y.no_ipd 
				AND A.idrg = d.idrg 
				AND C.idkel_inacbg = '5'
			ORDER BY
				A.tgl_layanan DESC");
	}

	function get_unitdarah($ipd)
	{
		return $this->db->query("SELECT A
				.* 
			FROM
				pemeriksaan_unitdarah AS A,
				jenis_tindakan_new AS x,
				pasien_iri AS y 
			WHERE
				A.id_tindakan = x.idtindakan 
				AND A.no_register = y.no_ipd 
				AND y.no_ipd = 'RI00003773' 
				AND no_utdrs IS NOT NULL");
	}

	function get_rehabilitasi($ipd)
	{
		return $this->db->query("SELECT
				*,
			CASE
					
					WHEN C.idkel_tind = '0' THEN
					'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind limit 1 ) 
				END AS nama_kel,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
				( SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS ttd_pelaksana,
				( SELECT NAME FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS pelaksana 
			FROM
				pelayanan_iri
				AS A LEFT JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
				INNER JOIN jenis_tindakan_new AS C ON A.id_tindakan = C.idtindakan,
				pasien_iri AS y,
				ruang AS d 
			WHERE
				A.no_ipd = '$ipd' 
				AND A.no_ipd = y.no_ipd 
				AND A.idrg = d.idrg 
				AND C.idkel_inacbg = '16'
			ORDER BY
				A.tgl_layanan DESC");
	}

	function get_rawat_intensif($ipd)
	{
		return $this->db->query("SELECT
				*,
			CASE
					
					WHEN C.idkel_tind = '0' THEN
					'' ELSE ( SELECT nama_kel FROM kel_tind WHERE idkel_tind = C.idkel_tind limit 1) 
				END AS nama_kel,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nm_dokter,
				( SELECT nm_dokter FROM data_dokter WHERE id_dokter = CAST ( A.idoprtr AS INTEGER ) LIMIT 1 ) AS nmdokter,
				( SELECT ttd FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS ttd_pelaksana,
				( SELECT NAME FROM hmis_users WHERE CAST ( A.idoprtr AS INTEGER ) = userid LIMIT 1 ) AS pelaksana 
			FROM
				pelayanan_iri
				AS A LEFT JOIN data_pasien AS b ON CAST ( A.nomederec AS INTEGER ) = b.no_medrec
				INNER JOIN jenis_tindakan_new AS C ON A.id_tindakan = C.idtindakan,
				pasien_iri AS y,
				ruang AS d 
			WHERE
				A.no_ipd = '$ipd' 
				AND A.no_ipd = y.no_ipd 
				AND A.idrg = d.idrg 
				AND C.idkel_inacbg = '3'
			ORDER BY
				A.tgl_layanan DESC");
	}

	function delete_resume($ipd)
	{
		$this->db->where('no_ipd', $ipd);
		return $this->db->delete('resume_pulang_iri');
	}

	function update_tgl_resep_pulang($noipd, $data)
	{
		$this->db->where('no_ipd', $noipd);
		$this->db->update('pasien_iri', $data);
		return true;
	}

	function cek_resep_pasien_dokter_plg($no_reg,$id_obat)
	{
		return $this->db->query("select * from resep_dokter where no_register = '$no_reg'  and id_obat='$id_obat' and obat_pulang = '1'");
	}
	public function get_pasien_id_ok($no_ipd)
	{
				$data = $this->db->query("SELECT
			idoperasi_header 
		FROM
			operasi_header 
		WHERE
			no_register = '$no_ipd';");
				return $data->row();
	}
	function get_asuhan_gizi_ri($no_ipd)
	{
		return $this->db->query("SELECT * FROM asuhan_gizi where no_register='$no_ipd'");
	}

    function insert_asuhan_gizi_ri($data)
	{
		return $this->db->insert('asuhan_gizi', $data);
	}

    function update_asuhan_gizi_ri($no_ipd, $data)
	{ 
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('asuhan_gizi', $data);
	}

	function get_resiko_jatuh_new($no_ipd)
	{
		return $this->db->query("SELECT * FROM resiko_jatuh_general where no_register='$no_ipd'");
	}

    function insert_resiko_jatuh_new($data)
	{
		return $this->db->insert('resiko_jatuh_general', $data);
	}

    function update_resiko_jatuh_new($no_ipd, $data)
	{ 
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('resiko_jatuh_general', $data);
	}
	
}
