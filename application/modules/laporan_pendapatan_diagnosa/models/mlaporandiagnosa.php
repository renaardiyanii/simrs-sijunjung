<?php
class Mlaporandiagnosa extends CI_Model {
    function laporan_pendapatan_diagnosa_rajal($tgl_awal, $tgl_akhir, $cara_bayar, $kelPelayanan){
        // $query = "";
        if ($kelPelayanan == "rawat_jalan") {
        //    $query = "
        //     SELECT sum(a.vtot) as total_pendapatan, count(*) as total_kasus, a.cara_bayar, b.id_diagnosa, b.diagnosa 
        //     FROM daftar_ulang_irj as a , diagnosa_pasien as b 
        //     WHERE a.no_register = b.no_register 
        //     AND a.cara_bayar = '$cara_bayar'
        //     AND a.tgl_kunjungan between '$tgl_awal 00:00:00+07' and '$tgl_akhir 00:00:00+07'
        //     GROUP BY a.cara_bayar, b.id_diagnosa, b.diagnosa
        //     order by total_kasus desc
        //    ";
            $query ="
                SELECT * FROM (
                    SELECT sum(a.vtot) as total_pendapatan, count(*) as total_kasus, a.cara_bayar, b.id_diagnosa, b.diagnosa 
                                FROM daftar_ulang_irj as a , diagnosa_pasien as b 
                                WHERE a.no_register = b.no_register 
                                AND a.cara_bayar = '$cara_bayar'
                                AND a.tgl_kunjungan between '$tgl_awal 00:00:00' and '$tgl_akhir 00:00:00'
                                GROUP BY a.cara_bayar, b.id_diagnosa, b.diagnosa
                    ) AS A
                    ORDER BY a.total_kasus desc
            ";
            return $this->db->query($query);
        }
        else{
        //     $query = "
        //     SELECT sum(c.vtot) as total_pendapatan, count(*) as total_kasus, b.id_diagnosa, b.diagnosa, a.carabayar
        //     FROM pasien_iri a, diagnosa_iri b, daftar_ulang_irj c
        //     WHERE a.no_ipd = b.no_register
        //     AND a.noregasal = c.no_register
        //     AND a.carabayar = '$cara_bayar'
        //     AND c.tgl_kunjungan between '$tgl_awal 00:00:00+07' and '$tgl_akhir 00:00:00+07'
        //     GROUP BY a.cara_bayar, b.id_diagnosa, b.diagnosa
        //     order by total_kasus desc
        //    ";
            $query = "
                SELECT * FROM 
                (
                SELECT sum(c.vtot) as total_pendapatan, count(*) as total_kasus, b.id_diagnosa, b.diagnosa, a.carabayar as cara_bayar
                    FROM pasien_iri a, diagnosa_iri b, daftar_ulang_irj c
                    WHERE a.no_ipd = b.no_register
                    AND a.noregasal = c.no_register
                    AND a.carabayar = '$cara_bayar'
                    AND c.tgl_kunjungan between '$tgl_awal' and '$tgl_akhir'
                    GROUP BY a.carabayar, b.id_diagnosa, b.diagnosa
                ) AS a
                order by  a.total_kasus desc
            ";
            return $this->db->query($query);
        }    
    }

    function laporan_pendapatan_per_dokter(){

    }

    function getAllDokter(){
        return $this->db->query("SELECT * FROM data_dokter WHERE deleted = '0'");
    }

    function getDokterByPoli($id_poli){
        return $this->db->query("SELECT dd.nm_dokter,dd.id_dokter
            FROM
                data_dokter AS dd, dokter_poli as dp
            WHERE
                dd.id_dokter =  dp.id_dokter and
                dp.id_poli = '$id_poli'
                    AND dd.deleted != '1'
                    group by dd.nm_dokter,dd.id_dokter
            ORDER BY dd.nm_dokter");
    }

    function getAllKSM(){
        return $this->db->query("SELECT * FROM poliklinik WHERE active = '1'");
    }

    function getLaporanPendapatanPerDokter($startTime, $endTime, $ksm){
        return $this->db->query("
        select 
            a.id_dokter,
            a.nm_dokter,
            a.id_ksm,
            a.ksm,
            sum(iribpjs) as iri_bpjs,
            sum(iriumum) as iri_umum,
            sum(iriiks) as iri_iks,
            sum(irjbpjs) as irj_bpjs,
            sum(irjumum) as irj_umum,
            sum(irjiks) as irj_iks,
            sum(okbpjs) as ok_bpjs,
            sum(okumum) as ok_umum,
            sum(okiks) as ok_iks,
            sum(nonokbpjs) as no_ok_bpjs,
            sum(nonokumum) as non_ok_umum,
            sum(nonokiks) as non_ok_iks,
            sum(total_ok+total_nonok) as total_tarif
        from realisasi_kasus_tindakan_dokter a
        WHERE TO_DATE(a.tgl_layanan, 'yyyy-mm-dd') BETWEEN '$startTime'
		AND  '$endTime'
       	AND a.id_ksm IN($ksm) 
        group by 
            a.id_dokter,
            a.nm_dokter,
                a.id_ksm,
                a.ksm
        ");
    }
}
?>