<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frmmreturjual extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    function get_daftar_pasien($data){
        $where = "";
        if ($data["no_registrasi"] != "") {
            $where .= " AND no_register = '".$data["no_registrasi"]."'";
        }
        if (($data["tgl0"] != "") && ($data["tgl1"] == "")){
            $where .= " AND tgl_kunjungan = '".$data["tgl0"]."'";
        }
        if (($data["tgl0"] != "") && ($data["tgl1"] != "")){
            $where .= " AND tgl_kunjungan BETWEEN ('".$data["tgl0"]."') AND ('".$data["tgl1"]."')";
        }


        return $this->db->query("SELECT no_resep, no_register, (
			IF(LEFT(no_register,2)='PL', (SELECT nama FROM pasien_luar WHERE no_register=resep_pasien.no_register)
			, (SELECT nama FROM data_pasien WHERE no_medrec=resep_pasien.no_medrec)) ) as nama, 
			tgl_kunjungan, kelas, (select idrg from resep_header where no_resep=resep_pasien.no_resep) as idrg,
            (select bed from resep_header where no_resep=resep_pasien.no_resep) as bed, cetak_kwitansi, cara_bayar 
			FROM resep_pasien 
			/*WHERE ambil_resep='1' AND cetak_kwitansi = '1' AND no_resep IS NOT NULL*/
			WHERE ambil_resep='1' AND no_resep IS NOT NULL $where
			GROUP BY no_resep
			ORDER BY no_resep");
    }

    function get_detail_pasien($noregister){
        return $this->db->query("SELECT no_resep, no_register,tgl_kunjungan,kelas,cetak_kwitansi,cara_bayar,(SELECT idrg FROM resep_header WHERE no_resep=resep_pasien.no_resep) AS idrg, (SELECT bed FROM resep_header WHERE no_resep=resep_pasien.no_resep) AS bed,
        CASE
                WHEN LEFT(no_register,2)='PL' then (SELECT nama FROM pasien_luar WHERE no_cm=cast(resep_pasien.no_medrec as int))
                else
                 (SELECT nama FROM data_pasien WHERE no_medrec=cast(resep_pasien.no_medrec as int))
                END
                as nama
                FROM resep_pasien WHERE no_register = '$noregister'  ORDER BY no_resep");
    }

    function get_list_resep($noresep){
        // return $this->db->query("SELECT r.*, rp.`qty_retur`
        //     FROM resep_pasien r
        //     LEFT JOIN retur_penjualan rp ON rp.`id_resep` = r.`id_resep_pasien`
        //     WHERE no_register = '".$noresep."' ");

        return $this->db->query("SELECT *
        FROM resep_pasien 
        WHERE no_register = '".$noresep."' ");
    }

    function get_detail_item_retur($idresep, $idgudang){
        return $this->db->query("SELECT r.*, g.qty AS stok FROM resep_pasien r INNER JOIN gudang_inventory g ON g.id_inventory = r.id_inventory WHERE r.id_resep_pasien = '$idresep' AND g.id_gudang = $idgudang");
    }

    function edit_stok($data, $idgudang){
        $this->db->query("UPDATE resep_pasien 
                            SET qty_retur = '".$data['edit_quantity']."',biaya_retur = '".$data['biaya_retur_hide']."'
                            WHERE item_obat = '".$data['item_obat']."' AND no_resep ='".$data['no_resep']."'
                        ");

        return $this->db->query("UPDATE gudang_inventory 
                            SET qty = qty + '".$data['edit_quantity']."'
                            WHERE id_obat = '".$data['item_obat']."' AND id_gudang = ".$idgudang);
    }
}
?>