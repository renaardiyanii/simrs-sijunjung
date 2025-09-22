<?php
class Rimreservasi extends CI_Model {

	public function select_pasien_irj_like($value){
		
		// $data=$this->db->query("
		// 	select a.*, b.no_cm as no_cm_real, b.*,c.*,d.*,e.*,f.id_diagnosa,f.diagnosa as diagnosa_utama, g.nm_dokter as nama_dokter
		// 	from pasien_rujuk_inap as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join daftar_ulang_irj as d on a.no_register = d.no_register
		// 	left join poliklinik as c on d.id_poli = c.id_poli
		// 	left join icd1 as e on d.diagnosa = e.id_icd
		// 	left join diagnosa_pasien as f on a.no_register = f.no_register
		// 	left join data_dokter as g on g.id_dokter = d.id_dokter
		// 	where a.no_register like '%$value%'
		// 	and (f.klasifikasi_diagnos = 'utama' or f.klasifikasi_diagnos is NULL)
		// 	");
		// return $data->result_array();

		$data=$this->db->query("
		select a.*, b.no_cm as no_cm_real, b.*,c.*,d.*,e.*,f.id_diagnosa,f.diagnosa as diagnosa_utama, g.nm_dokter as nama_dokter
		from pasien_rujuk_inap as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		left join daftar_ulang_irj as d on a.no_register = d.no_register
		left join poliklinik as c on d.id_poli = c.id_poli
		left join icd1 as e on d.diagnosa = e.id_icd
		left join diagnosa_pasien as f on a.no_register = f.no_register
		left join data_dokter as g on g.id_dokter = d.id_dokter
		
		and (f.klasifikasi_diagnos = 'utama' or f.klasifikasi_diagnos is NULL)
			");
		return $data->result_array();
	}

	public function batal_iri_reservasi($value){
		$data=$this->db->query("UPDATE daftar_ulang_irj set ket_pulang='DIRUJUK_RAWATINAP_BATAL'
			where no_register='$value'");
		return true;
	}

	public function undo_pasien_batal_antrian($value){
		$data=$this->db->query("UPDATE irna_antrian set batal='N'
			where noreservasi='$value'");
		return true;
	}

	public function undo_pasien_batal_reservasi($value){
		$data=$this->db->query("UPDATE daftar_ulang_irj set ket_pulang='DIRUJUK_RAWATINAP'
			where no_register='$value'");
		return true;
	}

	public function select_pasien_batal_reservasi_new($date0,$date1){
		//$data=$this->db->query("SELECT *, (select nm_poli from poliklinik where id_poli=a.id_poli) as nmruang, (select count(*) from pasien_iri where no_cm=a.no_medrec and tgl_keluar is null) as stat FROM daftar_ulang_irj a, data_pasien b where a.no_medrec=b.no_medrec and a.ket_pulang='DIRUJUK_RAWATINAP_BATAL' and a.tgl_kunjungan>='$date0' and a.tgl_kunjungan<='$date1'");

		$data=$this->db->query("SELECT *, (select nm_poli from poliklinik where cast(id_poli as text)=a.id_poli) as nmruang, 
		(select count(*) from pasien_iri where cast(no_cm as integer)=a.no_medrec and tgl_keluar is null) as stat 
		FROM daftar_ulang_irj a, data_pasien b where a.no_medrec=b.no_medrec and a.ket_pulang='DIRUJUK_RAWATINAP_BATAL' 
		and a.tgl_kunjungan>='$date0' and a.tgl_kunjungan<='$date1'");
		return $data->result_array();
	}

	public function select_pasien_batal_antrian($date0,$date1){
		// $data=$this->db->query("SELECT *,(select nmruang from ruang where idrg=a.ruangpilih) as nmruang, (select count(*) from pasien_iri where no_cm=a.no_cm and tgl_keluar is null) as stat FROM irna_antrian as a, data_pasien b where a.no_cm=b.no_medrec 
		// and a.batal='Y'
		// and a.tglreserv>='$date0' and a.tglreserv<='$date1'");


		$data=$this->db->query("SELECT *,(select nmruang from ruang where idrg=a.ruangpilih) as nmruang, 
		(select count(*) from pasien_iri where cast(no_cm as integer)=a.no_medrec and tgl_keluar is null) as stat 
		FROM irna_antrian as a, data_pasien b where a.no_medrec=b.no_medrec and a.batal='Y' 
		and a.tglreserv>='$date0' and a.tglreserv<='$date1'");
		return $data->result_array();
	}

	public function select_pasien_irj($value){
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data=$this->db->query("
		select a.*,b.*,c.*,d.*,e.*,f.id_diagnosa,f.diagnosa as diagnosa_utama, g.nm_dokter as nama_dokter
		from pasien_rujuk_inap as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		left join daftar_ulang_irj as d on a.no_register = d.no_register
		left join poliklinik as c on d.id_poli = c.id_poli
		left join icd1 as e on d.diagnosa = e.id_icd
		left join diagnosa_pasien as f on a.no_register = f.no_register
		left join data_dokter as g on g.id_dokter = d.id_dokter
		where a.no_register like '$value'
		and (f.klasifikasi_diagnos = 'utama' or f.klasifikasi_diagnos is NULL)
			");
		return $data->result_array();
	}

	public function check_iri($noreg){
			//return $this->db->query("SELECT * FROM pasien_iri WHERE no_cm='".$noreg."' AND tgl_keluar is null ");
			return $this->db->query("SELECT * FROM pasien_iri WHERE CAST(no_medrec AS TEXT)='$noreg' AND tgl_keluar is null ");
	}

	public function select_pasien_ird($value){
		// $data=$this->db->query("
		// 	select * 
		// 	from irddaftar_ulang as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	where a.no_register like '%$value%'");

		$data=$this->db->query("
			select a.*,b.*,c.*,d.id_diagnosa, d.diagnosa as diagnosa_utama
			from pasien_rujuk_inap as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join irddaftar_ulang as c on a.no_register = c.no_register
			left join icd1 as e on c.diagnosa = e.id_icd
			left join diagnosa_ird as d on a.no_register = d.no_register
			where a.no_register like '$value'
			and (d.klasifikasi_diagnos = 'utama' or d.klasifikasi_diagnos is null)
			");
		return $data->result_array();
	}

	public function select_pasien_iri_like($value){
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data=$this->db->query("
			select a.*, b.*, c.*, d.*
			from pasien_iri as a inner join data_pasien as b on a.no_cm = b.no_medrec
			left join icd1 as c on c.id_icd = a.diagmasuk
			left join ruang as d on d.idrg = a.idrg
			where a.no_ipd like '%$value%' and a.tgl_keluar is NULL
			");
		return $data->result_array();
	}

	//moris up

	public function select_pasien_ird_like($value){
		// $data=$this->db->query("
		// 	select * 
		// 	from irddaftar_ulang as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	where a.no_register like '%$value%'");

		$data=$this->db->query("
			select a.*,b.*,c.*,d.id_diagnosa, d.diagnosa as diagnosa_utama,g.nm_dokter
			from pasien_rujuk_inap as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join irddaftar_ulang as c on a.no_register = c.no_register
			left join icd1 as e on c.diagnosa = e.id_icd
			left join diagnosa_ird as d on a.no_register = d.no_register
			left join data_dokter as g on g.id_dokter = c.id_dokter
			where a.no_register like '%$value%'
			and (d.klasifikasi_diagnos = 'utama' or d.klasifikasi_diagnos is null)
			");
		return $data->result_array();
	}

	

	public function select_pasien_irj_by_ipd($value){
		$data=$this->db->query("select *
			from pasien_iri as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			inner join ruang_iri as c on a.no_ipd = c.no_ipd
			inner join ruang as d on c.idrg = d.idrg
			left join icd1 as e on e.id_icd = a.diagmasuk
			where a.no_ipd = '$value'
			ORDER BY c.idrgiri DESC");
		return $data->result_array();
	}
	//moris up

	public function select_pasien_batal_reservasi($value){
		$data=$this->db->query("select *
			from irna_antrian as a data_pasien as b on a.no_cm = b.no_medrec
			inner join ruang_iri as c on a.no_ipd = c.no_ipd
			inner join ruang as d on c.idrg = d.idrg
			left join icd1 as e on e.id_icd = a.diagmasuk
			where a.no_ipd = '$value'
			ORDER BY c.idrgiri DESC");
		return $data->result_array();
	}

	public function select_irna_antrian_by_noreservasi($value){
		$data=$this->db->query("select * from irna_antrian where noreservasi like '%$value%'");
		return $data->result_array();
	}
	
	public function select_ruang_like($value){
		$data=$this->db->query("select * from ruang ");
		return $data->result_array();
	}
	
	public function insert_reservasi($data){
		$this->db->insert('irna_antrian', $data);				
	}

	function getemptyroom_date($tglbooking){
    	if($tglbooking!=date('Y-m-d')){
    		return $this->db->query("select *, (select count(*) from bed where idrg=a.idrg) as qtybed, 
			(select count(*) from irna_antrian where ruangpilih=a.idrg and tglrencanamasuk='$tglbooking' and (batal!='Y' and confirm=0)) as countbed,
			((select count(*) from bed where idrg=a.idrg)-(select count(*) from irna_antrian where ruangpilih=a.idrg and tglrencanamasuk='$tglbooking' and (batal!='Y' and confirm=0))) as emptybed,
			IF((select count(*) from bed where idrg=a.idrg)=(select count(*) from irna_antrian where ruangpilih=a.idrg and tglrencanamasuk='$tglbooking' and (batal!='Y' and confirm=0)),'FULL','OK') as status
			from ruang a right join bed as b on a.idrg = b.idrg
			where a.lokasi!='Kamar Operasi'
			group by b.kelas,a.idrg,a.nmruang 
			ORDER BY a.idrg");
    	} else{
    		return $this->db->query("select *, 
			(select count(*) from bed where idrg=a.idrg) as qtybed, 
			(select count(*) from irna_antrian where ruangpilih=a.idrg and TO_CHAR(tglrencanamasuk,'YYYY-MM-DD')='$tglbooking' and (batal!='Y' and confirm='0')) as countbed, 
			((select count(*) from bed where idrg=a.idrg)-(select count(*) from irna_antrian where ruangpilih=a.idrg and TO_CHAR(tglrencanamasuk,'YYYY-MM-DD')='$tglbooking' and (batal!='Y' and confirm='0'))-
			(select count(*) from pasien_iri where idrg=a.idrg and tgl_keluar is NULL)) as emptybed,
			  case when 
			  (select count(*) from bed where idrg=a.idrg) = 
			  (select count(*) from irna_antrian where ruangpilih=a.idrg 
					and TO_CHAR(tglrencanamasuk,'YYYY-MM-DD')='$tglbooking' 
					and (batal!='Y' and confirm='0')
				   ) then 'FULL' else 'OK'
				end   as status
			  
			 from ruang a 
			 right join bed as b on a.idrg = b.idrg 
			 where a.lokasi!='Kamar Operasi' ORDER BY a.idrg");
    	}
    }

    function getemptybed_date($idrg,$kelas,$tglbooking){
    	if($tglbooking!=date('Y-m-d')){
    		return $this->db->query("select a.* from bed a 
			where (select count(*) from irna_antrian where bed=a.bed and tglrencanamasuk='$tglbooking')=0
	        and a.idrg=$idrg
			and a.kelas='$kelas'");
    	}else{
    		return $this->db->query("select a.* from bed a 
			where (select count(*) from irna_antrian where bed=a.bed and tglrencanamasuk='$tglbooking')=0
			and (select count(*) from pasien_iri where bed=a.bed and tgl_keluar is NULL)=0
	        and a.idrg='$idrg'
			and a.kelas='$kelas'");
    	}
    	
    }

    function  get_operation_schedule($tglok){
		if($tglok!=''){
			return $this->db->query("
		select a.*, b.nama, b.no_cm, c.carabayar as cara_bayar,(select nm_dokter from data_dokter where id_dokter=a.id_dokter limit 1)as nm_dokter, (select nmruang from ruang where idrg=a.idkamar_operasi limit 1)as nm_ruang 
		from operasi_header a, data_pasien b, irna_antrian c 
		where a.no_reservasi=c.noreservasi 
		and a.status=0 
		and b.no_medrec=c.no_medrec 
		and a.tgl_jadwal_ok = '".$tglok."'

		UNION
		select a.*, b.nama, b.no_cm, c.carabayar as cara_bayar, (select nm_dokter from data_dokter where id_dokter=a.id_dokter limit 1) as nm_dokter,(select nmruang from ruang where idrg=a.idkamar_operasi limit 1) as nm_ruang 
		from operasi_header a, data_pasien b, pasien_iri c 
		where a.status=0 
		and a.no_register=c.no_ipd
		and b.no_medrec=c.no_medrec 
		and a.tgl_jadwal_ok = '".$tglok."'

		UNION 
		select a.*, b.nama, b.no_cm, c.cara_bayar, (select nm_dokter from data_dokter where id_dokter=a.id_dokter limit 1) as nm_dokter,(select nmruang from ruang where idrg=a.idkamar_operasi limit 1) as nm_ruang 
		from operasi_header a, data_pasien b, daftar_ulang_irj c 
		where a.status=0 
		and a.no_register=c.no_register 
		and b.no_medrec=c.no_medrec
		and a.tgl_jadwal_ok = '".$tglok."'	 ")->result();
		}else{
			return $this->db->query("
		select a.*, b.nama, b.no_cm, c.carabayar as cara_bayar,(select nm_dokter from data_dokter where id_dokter=a.id_dokter limit 1)as nm_dokter, (select nmruang from ruang where idrg=a.idkamar_operasi limit 1)as nm_ruang 
		from operasi_header a, data_pasien b, irna_antrian c 
		where a.no_reservasi=c.noreservasi 
		and a.status=0 
		and b.no_medrec=c.no_medrec 
		and a.tgl_jadwal_ok = '".date('Y-m-d')."'

		UNION
		select a.*, b.nama, b.no_cm, c.carabayar as cara_bayar, (select nm_dokter from data_dokter where id_dokter=a.id_dokter limit 1) as nm_dokter,(select nmruang from ruang where idrg=a.idkamar_operasi limit 1) as nm_ruang 
		from operasi_header a, data_pasien b, pasien_iri c 
		where a.status=0 
		and a.no_register=c.no_ipd
		and b.no_medrec=c.no_medrec 
		and a.tgl_jadwal_ok = '".date('Y-m-d')."'

		UNION 
		select a.*, b.nama, b.no_cm, c.cara_bayar, (select nm_dokter from data_dokter where id_dokter=a.id_dokter limit 1) as nm_dokter,(select nmruang from ruang where idrg=a.idkamar_operasi limit 1) as nm_ruang 
		from operasi_header a, data_pasien b, daftar_ulang_irj c 
		where a.status=0 
		and a.no_register=c.no_register 
		and b.no_medrec=c.no_medrec
		and a.tgl_jadwal_ok = '".date('Y-m-d')."'	 ")->result();
		}
		
    }


	

    function  get_reservation_schedule($tglbooking){
		if($tglbooking!=''){
			$txtbooking="and a.tglrencanamasuk='".$tglbooking."'";
		}else{
			$txtbooking='';
		}
		return $this->db->query("SELECT *, a.carabayar as cara_bayar, 
		case when a.tppri='rawatjalan' then
		(Select nm_poli from poliklinik where id_poli = 
				(select id_poli from daftar_ulang_irj where no_register=a.no_register_asal) 
			) else 'Rawat Inap' end as nm_poli 
	
	FROM irna_antrian a, ruang b, data_pasien c 
	where b.idrg=a.ruangpilih 
	and (a.batal!='Y' and a.confirm='0') 
	and a.no_medrec=c.no_medrec")->result();
    }

	function delete_jadwal_ok($id)
	{
		$this->db->where('idoperasi_header', $id);
		return $this->db->delete('operasi_header');
	}
}
?>
