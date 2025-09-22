<?php
class Mlaporantxtbpjs extends CI_Model {

    function getTxtRawatJalan($startTime, $endTime){
        return $this->db->query("
        SELECT * FROM laporan_txt_rawat_jalan_bpjs 
        WHERE TO_DATE(tanggal_layanan, 'yyyy-mm-dd') 
        BETWEEN '$startTime'
		AND  '$endTime'
        ");
    }

    function getTxtEklaim($startMonth, $endMonth) {
        return $this->db->query("SELECT * FROM txt_eklaim WHERE tgl_pulang BETWEEN '$startMonth' AND '$endMonth'");
    }
}
?>