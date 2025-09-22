<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class mperusahaan extends CI_Model {

    public function get_perusahaan(){
		$data=$this->db->query("SELECT * from kontraktor where bpjs='KERJASAMA' and deleted = 0 order by id_kontraktor");
		return $data->result();
	  }

    public function get_perusahaan_by_tgl($date1,$date2){
      $data=$this->db->query("SELECT DISTINCT
        b.id_kontraktor,
        ( SELECT nmkontraktor FROM kontraktor WHERE kontraktor.id_kontraktor = b.id_kontraktor ) AS nmkontraktor 
      FROM
        daftar_ulang_irj b 
      WHERE
        b.id_kontraktor IS NOT NULL 
        AND b.tgl_kunjungan BETWEEN '$date1' 
        AND '$date2' 
        AND b.cara_bayar = 'KERJASAMA' 
        AND b.cetak_kwitansi != '1' 
        AND b.tgl_cetak_kw IS NULL");
        return $data->result();
      }

    public function get_list_pasien_iks($id,$date1,$date2){
		$data=$this->db->query("SELECT
        no_register,
        no_medrec,
        ( SELECT nama FROM data_pasien WHERE data_pasien.no_medrec = daftar_ulang_irj.no_medrec ) AS nama,
        tgl_kunjungan,
        cara_bayar,
        id_kontraktor,
        (SELECT sum(vtot) from pelayanan_poli where pelayanan_poli.no_register = daftar_ulang_irj.no_register) as biaya_poli,
        (SELECT sum(vtot) from pemeriksaan_laboratorium where pemeriksaan_laboratorium.no_register = daftar_ulang_irj.no_register) as biaya_lab,
        (SELECT sum(vtot::float) from pemeriksaan_radiologi where pemeriksaan_radiologi.no_register = daftar_ulang_irj.no_register) as biaya_rad,
        (SELECT sum(vtot) from pemeriksaan_elektromedik where pemeriksaan_elektromedik.no_register = daftar_ulang_irj.no_register) as biaya_em,
        (SELECT sum(vtot) from pemeriksaan_operasi where pemeriksaan_operasi.no_register = daftar_ulang_irj.no_register) as biaya_ok,
        (SELECT sum(vtot) from resep_pasien where resep_pasien.no_register = daftar_ulang_irj.no_register) as biaya_resep
    FROM
        daftar_ulang_irj 
    WHERE
        cara_bayar = 'KERJASAMA' 
        AND cetak_kwitansi != '1' 
        AND tgl_cetak_kw IS NULL 
        AND id_kontraktor = '$id' 
        AND tgl_kunjungan BETWEEN '$date1' 
        AND '$date2' 
    ORDER BY
        tgl_kunjungan DESC");
		return $data->result();
	}


    public function get_nm_perusahaan($id){
		$data=$this->db->query("SELECT nmkontraktor from kontraktor where id_kontraktor = '$id'");
		return $data->row();
	}


  function insert_saldo($data){
    $this->db->insert('saldo_perusahaan', $data);
    return $this->db->insert_id();
  }

  public function get_saldo($id){
		$data=$this->db->query("SELECT * from saldo_perusahaan where id_kontraktor='$id'  order by id desc limit 1");
		return $data->row();
	  }

    public function get_list_pasien_iks_by_noreg($noreg){
      $data=$this->db->query("SELECT
          no_register,
          no_medrec,
          ( SELECT nama FROM data_pasien WHERE data_pasien.no_medrec = daftar_ulang_irj.no_medrec ) AS nama,
          tgl_kunjungan,
          cara_bayar,
          id_kontraktor,
          (SELECT sum(vtot) from pelayanan_poli where pelayanan_poli.no_register = daftar_ulang_irj.no_register) as biaya_poli,
          (SELECT sum(vtot) from pemeriksaan_laboratorium where pemeriksaan_laboratorium.no_register = daftar_ulang_irj.no_register) as biaya_lab,
          (SELECT sum(vtot::float) from pemeriksaan_radiologi where pemeriksaan_radiologi.no_register = daftar_ulang_irj.no_register) as biaya_rad,
          (SELECT sum(vtot) from pemeriksaan_elektromedik where pemeriksaan_elektromedik.no_register = daftar_ulang_irj.no_register) as biaya_em,
          (SELECT sum(vtot) from pemeriksaan_operasi where pemeriksaan_operasi.no_register = daftar_ulang_irj.no_register) as biaya_ok,
          (SELECT sum(vtot) from resep_pasien where resep_pasien.no_register = daftar_ulang_irj.no_register) as biaya_resep
      FROM
          daftar_ulang_irj 
      WHERE
          no_register = '$noreg'");
      return $data->row();
    }

    public function get_list_pasien_iks_ranap($id,$date1,$date2){
      $data=$this->db->query("SELECT
          no_ipd,
          no_medrec,
          ( SELECT nama FROM data_pasien WHERE data_pasien.no_medrec = pasien_iri.no_medrec ) AS nama,
          tgl_masuk as tgl_kunjungan,
          carabayar,
          id_kontraktor,
          tgl_keluar,
          ( SELECT SUM ( vtot ) FROM pelayanan_iri WHERE pelayanan_iri.no_ipd = pasien_iri.no_ipd ) AS biaya_poli,
          ( SELECT SUM ( vtot ) FROM pemeriksaan_laboratorium WHERE pemeriksaan_laboratorium.no_register = pasien_iri.no_ipd ) AS biaya_lab,
          ( SELECT SUM ( vtot :: FLOAT ) FROM pemeriksaan_radiologi WHERE pemeriksaan_radiologi.no_register = pasien_iri.no_ipd ) AS biaya_rad,
          ( SELECT SUM ( vtot ) FROM pemeriksaan_elektromedik WHERE pemeriksaan_elektromedik.no_register = pasien_iri.no_ipd ) AS biaya_em,
          ( SELECT SUM ( vtot ) FROM pemeriksaan_operasi WHERE pemeriksaan_operasi.no_register = pasien_iri.no_ipd ) AS biaya_ok,
          ( SELECT SUM ( vtot ) FROM resep_pasien WHERE resep_pasien.no_register = pasien_iri.no_ipd ) AS biaya_resep 
        FROM
          pasien_iri 
        WHERE
          carabayar = 'KERJASAMA' 
          AND cetak_kwitansi IS NULL 
          AND tgl_cetak_kw IS NULL 
          AND id_kontraktor = '$id' 
          AND tgl_keluar BETWEEN '$date1' 
          AND '$date2' 
        ORDER BY
          tgl_keluar DESC");
      return $data->result();
    }

    public function get_list_pasien_iks_by_ipd($ipd){
          $data=$this->db->query("SELECT
          no_ipd,
          no_medrec,
          ( SELECT nama FROM data_pasien WHERE data_pasien.no_medrec = pasien_iri.no_medrec ) AS nama,
          tgl_masuk,
          carabayar,
          id_kontraktor,
          (SELECT sum(vtot) from pelayanan_iri where pelayanan_iri.no_ipd = pasien_iri.no_ipd) as biaya_poli,
          (SELECT sum(vtot) from pemeriksaan_laboratorium where pemeriksaan_laboratorium.no_register = pasien_iri.no_ipd) as biaya_lab,
          (SELECT sum(vtot::float) from pemeriksaan_radiologi where pemeriksaan_radiologi.no_register = pasien_iri.no_ipd) as biaya_rad,
          (SELECT sum(vtot) from pemeriksaan_elektromedik where pemeriksaan_elektromedik.no_register = pasien_iri.no_ipd) as biaya_em,
          (SELECT sum(vtot) from pemeriksaan_operasi where pemeriksaan_operasi.no_register = pasien_iri.no_ipd) as biaya_ok,
          (SELECT sum(vtot) from resep_pasien where resep_pasien.no_register = pasien_iri.no_ipd) as biaya_resep
      FROM
          pasien_iri
      WHERE
          no_ipd = '$ipd'");
          return $data->row();
    }

    public function get_perusahaan_kwitansi_by_tgl($date1,$date2){
      $data=$this->db->query("SELECT DISTINCT
        b.id_kontraktor,
        ( SELECT nmkontraktor FROM kontraktor WHERE kontraktor.id_kontraktor = b.id_kontraktor ) AS nmkontraktor 
      FROM
        daftar_ulang_irj b 
      WHERE
        b.id_kontraktor IS NOT NULL 
        AND b.tgl_kunjungan BETWEEN '$date1' 
        AND '$date2' 
        AND b.cara_bayar = 'KERJASAMA' 
        AND b.cetak_kwitansi = '1' 
        AND b.tgl_cetak_kw IS NOT NULL");
        return $data->result();
      }

      public function get_list_pasien_ct_kw_iks($id,$date1,$date2){
        $data=$this->db->query("SELECT
            no_register,
            no_medrec,
            ( SELECT nama FROM data_pasien WHERE data_pasien.no_medrec = daftar_ulang_irj.no_medrec ) AS nama,
            tgl_kunjungan,
            cara_bayar,
            id_kontraktor,
            (SELECT sum(vtot) from pelayanan_poli where pelayanan_poli.no_register = daftar_ulang_irj.no_register) as biaya_poli,
            (SELECT sum(vtot) from pemeriksaan_laboratorium where pemeriksaan_laboratorium.no_register = daftar_ulang_irj.no_register) as biaya_lab,
            (SELECT sum(vtot::float) from pemeriksaan_radiologi where pemeriksaan_radiologi.no_register = daftar_ulang_irj.no_register) as biaya_rad,
            (SELECT sum(vtot) from pemeriksaan_elektromedik where pemeriksaan_elektromedik.no_register = daftar_ulang_irj.no_register) as biaya_em,
            (SELECT sum(vtot) from pemeriksaan_operasi where pemeriksaan_operasi.no_register = daftar_ulang_irj.no_register) as biaya_ok,
            (SELECT sum(vtot) from resep_pasien where resep_pasien.no_register = daftar_ulang_irj.no_register) as biaya_resep
        FROM
            daftar_ulang_irj 
        WHERE
            cara_bayar = 'KERJASAMA' 
            AND cetak_kwitansi = '1' 
            AND tgl_cetak_kw IS NOT NULL 
            AND id_kontraktor = '$id' 
            AND tgl_kunjungan BETWEEN '$date1' 
            AND '$date2' 
        ORDER BY
            tgl_kunjungan DESC");
        return $data->result();
      }

      function getdata_tindakan_pasien_faktur($no_register){
        return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register'  order by xupdate desc");
      }

      function getdata_labor_pasien_faktur($no_register){
        return $this->db->query("SELECT * FROM pemeriksaan_laboratorium where no_register='$no_register'  order by xupdate desc");
      }

      function getdata_rad_pasien_faktur($no_register){
        return $this->db->query("SELECT * FROM pemeriksaan_radiologi where no_register='$no_register'  order by xupdate desc");
      }

      function getdata_em_pasien_faktur($no_register){
        return $this->db->query("SELECT * FROM pemeriksaan_elektromedik where no_register='$no_register'  order by xupdate desc");
      }

      function getdata_resep_pasien_faktur($no_register){
        return $this->db->query("SELECT * FROM resep_pasien where no_register='$no_register'  order by xupdate desc");
      }

      public function get_perusahaan_ranap_by_tgl($date1,$date2){
        $data=$this->db->query("SELECT DISTINCT
          b.id_kontraktor,
          ( SELECT nmkontraktor FROM kontraktor WHERE kontraktor.id_kontraktor = b.id_kontraktor) AS nmkontraktor 
        FROM
          pasien_iri b 
        WHERE
          b.id_kontraktor IS NOT NULL 
          AND b.id_kontraktor != 0
          AND b.tgl_keluar BETWEEN '$date1' 
          AND '$date2' 
          AND b.carabayar = 'KERJASAMA'
          AND b.cetak_kwitansi IS NULL 
          AND b.tgl_cetak_kw IS NULL");
            return $data->result();
        }

        public function get_tagihan_ruangan_ranap($no_ipd){
          $data=$this->db->query("SELECT DISTINCT A
              .*,
              C.total_tarif,
              c.tarif_iks,
              (select nmruang from ruang where a.idrg = ruang.idrg) as nmruang
            FROM
              ruang_iri A,
              tarif_tindakan C 
            WHERE
              C.id_tindakan = concat ( '1A', A.idrg ) 
              AND C.kelas = A.kelas 
              AND A.no_ipd = '$no_ipd'");
              return $data->result_array();
          }

          public function get_perusahaan_ranap_ct_kw_by_tgl($date1,$date2){
            $data=$this->db->query("SELECT DISTINCT
              b.id_kontraktor,
              ( SELECT nmkontraktor FROM kontraktor WHERE kontraktor.id_kontraktor = b.id_kontraktor) AS nmkontraktor 
            FROM
              pasien_iri b 
            WHERE
              b.id_kontraktor IS NOT NULL 
              AND b.id_kontraktor != 0
              AND b.tgl_keluar BETWEEN '$date1' 
              AND '$date2' 
              AND b.carabayar = 'KERJASAMA'
              AND b.cetak_kwitansi IS NOT NULL 
              AND b.tgl_cetak_kw IS NOT NULL");
                return $data->result();
            }


            public function get_list_pasien_iks_ranap_ct_kw($id,$date1,$date2){
              $data=$this->db->query("SELECT
                  no_ipd,
                  no_medrec,
                  ( SELECT nama FROM data_pasien WHERE data_pasien.no_medrec = pasien_iri.no_medrec ) AS nama,
                  tgl_masuk as tgl_kunjungan,
                  carabayar,
                  id_kontraktor,
                  tgl_keluar
                FROM
                  pasien_iri 
                WHERE
                  carabayar = 'KERJASAMA' 
                  AND cetak_kwitansi IS NOT  NULL 
                  AND tgl_cetak_kw IS NOT NULL 
                  AND id_kontraktor = '$id' 
                  AND tgl_keluar BETWEEN '$date1' 
                  AND '$date2' 
                ORDER BY
                  tgl_keluar DESC");
              return $data->result();
            }


            function getdata_tindakan_pasien_faktur_iri($no_ipd){
              return $this->db->query("SELECT *,(select nmtindakan from jenis_tindakan where jenis_tindakan.idtindakan = pelayanan_iri.id_tindakan) as nmtindakan FROM pelayanan_iri where no_ipd='$no_ipd'  order by xupdate desc");
            }
      
            function getdata_labor_pasien_faktur_iri($no_ipd){
              return $this->db->query("SELECT * FROM pemeriksaan_laboratorium where no_register='$no_ipd'  order by xupdate desc");
            }
      
            function getdata_rad_pasien_faktur_iri($no_ipd){
              return $this->db->query("SELECT * FROM pemeriksaan_radiologi where no_register='$no_ipd'  order by xupdate desc");
            }
      
            function getdata_em_pasien_faktur_iri($no_ipd){
              return $this->db->query("SELECT * FROM pemeriksaan_elektromedik where no_register='$no_ipd'  order by xupdate desc");
            }
      
            function getdata_resep_pasien_faktur_iri($no_ipd){
              return $this->db->query("SELECT * FROM resep_pasien where no_register='$no_ipd'  order by xupdate desc");
            }
    


       
  }
  