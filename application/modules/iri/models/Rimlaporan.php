<?php
class Rimlaporan extends CI_Model
{

    function get_data_keu_tind_tgl($tglawal, $tglakhir, $status)
    {
        if ($status == '1') {
            return $this->db->query("
SELECT 
    b.no_cm,
    b.nama,    
    c.no_ipd,
    c.vtot,
    c.vtot_kamar,
    c.vtot_ruang,
    c.vtot_medis,
    c.vtot_paramedis,
    c.tunai,
    IF(c.lunas='1','LUNAS','-') as lunas,
    (SELECT nmruang
        FROM
            ruang            
        WHERE
            ruang.idrg = c.idrg
        ) AS ruang,
    IF(c.tgl_keluar,datediff(c.tgl_keluar,c.tgldaftarri),'-') as rawat,
    SUM(a.jasa_perawat) as jasa_perawat,
    ifnull(c.vtot_lab,0) as vtot_lab,
    ifnull(c.vtot_rad,0) as vtot_rad,
    ifnull(c.vtot_obat,0) as vtot_obat,
    ifnull(c.vtot_pa,0) as vtot_pa,
    ifnull(c.vtot_ok,0) as vtot_ok,
    ifnull(c.vtot_vk,0) as vtot_vk,
    ifnull(c.vtot_icu,0) as vtot_icu,
    c.vtot_kamaricu,
    c.vtot_kamarvk,
    c.biaya_daftar,
    c.biaya_administrasi,
    ifnull(c.matkes_iri,0) as matkes_iri,
    IF(c.tgl_keluar IS NOT NULL, 'PULANG', 'DIRAWAT') AS status,
    c.carabayar,
    IFNULL(IF(c.diskon = '', NULL, c.diskon), 0) AS diskon,
    ifnull(c.total,0) AS total,
    c.tgl_keluar,
    (SELECT nmkontraktor from kontraktor where id_kontraktor=c.id_kontraktor) as nmkontraktor
FROM
    ruang_iri AS a,
    pasien_iri AS c,
    data_pasien b
WHERE
    a.no_ipd = c.no_ipd
        AND b.no_medrec = c.no_cm and c.tgl_keluar>='$tglawal' and c.tgl_keluar<='$tglakhir'
GROUP BY a.no_ipd 
");
            //SELECT b.no_cm, b.nama, c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar FROM ruang_iri as a, pasien_iri as c, data_pasien b WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and c.tgl_masuk='$tgl' and c.tgl_keluar is not null GROUP BY a.no_ipd ORDER BY a.no_ipd

            //SELECT B.no_cm ,  IF(A.tgl_keluar is not null,'1','0') as status, B.nama, IFNULL(A.vtot,0) as total, A.carabayar, A.tgl_masuk, A.no_ipd, A.tgl_keluar, IFNULL(A.diskon,0) as diskon FROM `pasien_iri` A, `data_pasien` B where A.no_cm = B.no_medrec and tgl_keluar is not null and A.tgl_masuk='$tgl' ORDER BY A.no_ipd
        } else if ($status == '0') {
            return $this->db->query("
SELECT 
    b.no_cm,
    b.nama,    
    c.no_ipd,
    c.vtot,
    c.vtot_ruang,
    c.tunai,
    IF(c.lunas='1','LUNAS','-') as lunas,
    (select GROUP_CONCAT(nmruang SEPARATOR ', ') from ruang, ruang_iri
    where ruang.idrg=ruang_iri.idrg
    ) as ruang,
    c.vtot_kamaricu,
    c.vtot_kamarvk,
    c.biaya_daftar,
    c.vtot_medis,
    c.vtot_paramedis,
    IF(c.tgl_keluar,datediff(c.tgl_keluar,c.tgldaftarri),'-') as rawat,
    SUM(a.jasa_perawat) as jasa_perawat,
    c.vtot_kamar,
    ifnull(c.vtot_lab,0) as vtot_lab,
    ifnull(c.vtot_rad,0) as vtot_rad,
    ifnull(c.vtot_obat,0) as vtot_obat,
    ifnull(c.vtot_pa,0) as vtot_pa,
    ifnull(c.vtot_ok,0) as vtot_ok,
    ifnull(c.vtot_vk,0) as vtot_vk,
    ifnull(c.vtot_icu,0) as vtot_icu,
    c.biaya_administrasi,
    ifnull(c.matkes_iri,0) as matkes_iri,
    IF(c.tgl_keluar IS NOT NULL, 'PULANG', 'DIRAWAT') AS status,
    c.carabayar,
    IFNULL(IF(c.diskon = '', NULL, c.diskon), 0) AS diskon,
    ifnull(c.total,0) AS total,
    c.tgl_keluar,
    (SELECT nmkontraktor from kontraktor where id_kontraktor=c.id_kontraktor) as nmkontraktor
FROM
    ruang_iri AS a,
    pasien_iri AS c,
    data_pasien b
WHERE
    a.no_ipd = c.no_ipd
        AND b.no_medrec = c.no_cm and c.tgl_masuk>='$tglawal' and c.tgl_masuk<='$tglakhir' and c.tgl_keluar is null
GROUP BY a.no_ipd
 ");
            //SELECT b.no_cm, b.nama, c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar FROM ruang_iri as a, pasien_iri as c, data_pasien b WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and c.tgl_masuk='$tgl' and c.tgl_keluar is null GROUP BY a.no_ipd ORDER BY a.no_ipd

            //SELECT B.no_cm ,  IF(A.tgl_keluar is not null,'1','0') as status, B.nama, A.carabayar, IFNULL(A.vtot,0) as total, A.tgl_masuk, A.no_ipd, A.tgl_keluar, IFNULL(A.diskon,0) as diskon FROM `pasien_iri` A, `data_pasien` B where A.no_cm = B.no_medrec and tgl_keluar is null and A.tgl_masuk='$tgl' ORDER BY A.no_ipd
        } else {
            return $this->db->query("
SELECT 
    b.no_cm,
    b.nama,    
    c.no_ipd,
    c.vtot,
    c.tunai,
    c.vtot_kamar,
    c.vtot_ruang,
    c.vtot_kamaricu,
    c.vtot_kamarvk,
    c.biaya_daftar,
    c.vtot_medis,
    c.vtot_paramedis,
    IF(c.lunas='1','LUNAS','-') as lunas,
    (SELECT nmruang
        FROM
            ruang            
        WHERE
            ruang.idrg = c.idrg
        ) AS ruang,
    IF(c.tgl_keluar,datediff(c.tgl_keluar,c.tgldaftarri),'-') as rawat,
    SUM(a.jasa_perawat) as jasa_perawat,
    ifnull(c.vtot_lab,0) as vtot_lab,
    ifnull(c.vtot_rad,0) as vtot_rad,
    ifnull(c.vtot_obat,0) as vtot_obat,
    ifnull(c.vtot_pa,0) as vtot_pa,
    ifnull(c.vtot_ok,0) as vtot_ok,
    ifnull(c.vtot_vk,0) as vtot_vk,
    ifnull(c.vtot_icu,0) as vtot_icu,
    c.biaya_administrasi,
    ifnull(c.matkes_iri,0) as matkes_iri,
    IF(c.tgl_keluar IS NOT NULL, 'PULANG', 'DIRAWAT') AS status,
    c.carabayar,
    IFNULL(IF(c.diskon = '', NULL, c.diskon), 0) AS diskon,
    ifnull(c.total,0) AS total,
    c.tgl_keluar,
    (SELECT nmkontraktor from kontraktor where id_kontraktor=c.id_kontraktor) as nmkontraktor
FROM
    ruang_iri AS a,
    pasien_iri AS c,
    data_pasien b
WHERE
    a.no_ipd = c.no_ipd
        AND b.no_medrec = c.no_cm and c.tgl_masuk>='$tglawal' and c.tgl_masuk<='$tglakhir' and c.tgl_keluar is null
GROUP BY a.no_ipd
UNION
SELECT 
    b.no_cm,
    b.nama,    
    c.no_ipd,
    c.vtot,
    c.tunai,
    c.vtot_kamar,
    c.vtot_ruang,
    c.vtot_kamaricu,
    c.vtot_kamarvk,
    c.biaya_daftar,
    c.vtot_medis,
    c.vtot_paramedis,
    IF(c.lunas='1','LUNAS','-') as lunas,
    (SELECT nmruang
        FROM
            ruang            
        WHERE
            ruang.idrg = c.idrg
        ) AS ruang,
    IF(c.tgl_keluar,datediff(c.tgl_keluar,c.tgldaftarri),'-') as rawat,
    SUM(a.jasa_perawat) as jasa_perawat,
    ifnull(c.vtot_lab,0) as vtot_lab,
    ifnull(c.vtot_rad,0) as vtot_rad,
    ifnull(c.vtot_obat,0) as vtot_obat,
    ifnull(c.vtot_pa,0) as vtot_pa,
    ifnull(c.vtot_ok,0) as vtot_ok,
    ifnull(c.vtot_vk,0) as vtot_vk,
    ifnull(c.vtot_icu,0) as vtot_icu,
    c.biaya_administrasi,
    ifnull(c.matkes_iri,0) as matkes_iri,
    IF(c.tgl_keluar IS NOT NULL, 'PULANG', 'DIRAWAT') AS status,
    c.carabayar,
    IFNULL(IF(c.diskon = '', NULL, c.diskon), 0) AS diskon,
    ifnull(c.total,0) AS total,
    c.tgl_keluar,
    (SELECT nmkontraktor from kontraktor where id_kontraktor=c.id_kontraktor) as nmkontraktor
FROM
    ruang_iri AS a,
    pasien_iri AS c,
    data_pasien b
WHERE
    a.no_ipd = c.no_ipd
        AND b.no_medrec = c.no_cm and c.tgl_keluar>='$tglawal' and c.tgl_keluar<='$tglakhir'
GROUP BY a.no_ipd");
            //SELECT b.no_cm, b.nama, c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar FROM ruang_iri as a, pasien_iri as c, data_pasien b WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and c.tgl_masuk='$tgl' GROUP BY a.no_ipd ORDER BY a.no_ipd

            //SELECT B.no_cm ,  IF(A.tgl_keluar is not null,'1','0') as status, A.carabayar, B.nama, IFNULL(A.vtot,0) as total, A.tgl_masuk, A.no_ipd, A.tgl_keluar, IFNULL(A.diskon,0) as diskon FROM `pasien_iri` A, `data_pasien` B where A.no_cm = B.no_medrec and A.tgl_masuk='$tgl' ORDER BY A.no_ipd

        }
    }

    function getdata_perusahaan($no_ipd)
    {
        return $this->db->query("SELECT A.id_kontraktor, B.nmkontraktor FROM pasien_iri A, kontraktor B  where no_ipd='$no_ipd' and A.id_kontraktor=B.id_kontraktor");
    }

    function getdata_perusahaan_irj($no_ipd)
    {
        return $this->db->query("SELECT A.id_kontraktor, B.nmkontraktor FROM daftar_ulang_irj A, kontraktor B  where no_register='$no_ipd' and A.id_kontraktor=B.id_kontraktor");
    }

    function get_data_keu_tind_bln($bln, $status, $psn)
    {
        if ($status == '1') {
            if ($psn == '0') {
                return $this->db->query("
SELECT SUM(a.total) as total, a.carabayar, SUM(a.diskon) as diskon, date_format(a.tgl_keluar,'%d-%m-%Y') as hari, count(*) as jum_tind, a.tgl_keluar as tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,7)='$bln' 
GROUP BY a.no_ipd) as a GROUP by hari");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_keluar,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(d.tgl_keluar,7)='$bln' GROUP by hari

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is not null and left(B.tgl_layanan,7)='$bln' GROUP by hari
            } else {
                return $this->db->query("
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_keluar,'%d-%m-%Y') as hari, SUM(a.diskon) as diskon, count(*) as jum_tind, a.tgl_keluar as tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,7)='$bln' and c.carabayar='$psn' 
GROUP BY a.no_ipd) as a GROUP by hari");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_keluar,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(d.tgl_keluar,7)='$bln' and c.carabayar='$psn' GROUP by hari

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is not null and left(B.tgl_layanan,7)='$bln' and A.carabayar='$psn' GROUP by hari
            }
        } else if ($status == '3') {
            if ($psn == '0') {
                return $this->db->query("SELECT SUM(v.total) as total, Sum(v.diskon) as diskon, v.hari, sum(v.jum_tind) as jum_tind from 
(SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_keluar,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,7)='$bln' 
GROUP BY a.no_ipd) as a GROUP by hari
UNION
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_masuk 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,7)='$bln' and c.tgl_keluar is null GROUP BY a.no_ipd) as a GROUP by hari) as v GROUP by v.hari");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_masuk,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(c.tgl_masuk,7)='$bln' GROUP by hari UNION SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_keluar,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(c.tgl_keluar,7)='$bln' GROUP by hari

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where left(B.tgl_layanan,7)='$bln' GROUP by hari
            } else {
                return $this->db->query("
SELECT SUM(v.total) as total, Sum(v.diskon) as diskon, v.hari, sum(v.jum_tind) as jum_tind, v.tgl_layanan from 
(SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_layanan,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon, a.tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar as tgl_layanan
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,7)='$bln' and c.carabayar='$psn'
GROUP BY a.no_ipd) as a GROUP by hari
UNION
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_layanan,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon, a.tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_masuk as tgl_layanan
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,7)='$bln' and c.carabayar='$psn' and c.tgl_keluar is null and c.carabayar='BPJS' GROUP BY a.no_ipd) as a GROUP by hari) as v GROUP by v.hari");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(c.tgl_masuk,7)='$bln' and c.carabayar='$psn' GROUP by hari UNION SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(c.tgl_keluar,7)='$bln' and c.carabayar='$psn' GROUP by hari

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where left(B.tgl_layanan,7)='$bln' and A.carabayar='$psn' GROUP by hari
            }
        } else {
            if ($psn == '0') {
                return $this->db->query("
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon, a.tgl_masuk as tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar, c.tgl_masuk 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,7)='$bln'
GROUP BY a.no_ipd) as a GROUP by hari");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is null and left(c.tgl_masuk,7)='$bln' GROUP by hari

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is null and left(B.tgl_layanan,7)='$bln' GROUP by hari
            } else {
                return $this->db->query("
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon, a.tgl_masuk as tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar, c.tgl_masuk 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,7)='$bln' and c.carabayar='$psn' 
GROUP BY a.no_ipd) as a GROUP by hari");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is null and left(c.tgl_masuk,7)='$bln' and c.carabayar='$psn' GROUP by hari

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is null and left(B.tgl_layanan,7)='$bln' and A.carabayar='$psn' GROUP by hari
            }
        }
    }
    function get_data_keu_tind_thn($thn, $status, $psn)
    {
        if ($status == '1') {
            if ($psn == '0') {
                return $this->db->query("
SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_keluar,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(c.tgl_keluar,4)='$thn' GROUP by bulan ORDER by Month(c.tgl_keluar)");
                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is not null and left(B.tgl_layanan,4)='$thn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
            } else {
                return $this->db->query("
SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(c.tgl_keluar,4)='$thn' and c.carabayar='$psn' GROUP by bulan ORDER by Month(c.tgl_keluar)");
                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is not null and left(B.tgl_layanan,4)='$thn' and A.carabayar='$psn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
            }
        } else if ($status == '3') {
            if ($psn == '0') {
                return $this->db->query("SELECT SUM(v.total) as total, SUM(v.jum_tind) as jum_tind, v.bulan, SUM(v.diskon) as diskon from 
(SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_keluar,'%M') as bulan, a.tgl_keluar as tgl, SUM(a.diskon) as diskon, count(*) as jum_tind from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total,  c.tgl_keluar,  c.tgl_masuk FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,4)='$thn' 
GROUP BY a.no_ipd) as a GROUP by bulan 
UNION
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%M') as bulan, SUM(a.diskon) as diskon, a.tgl_masuk as tgl, count(*) as jum_tind from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar,  c.tgl_masuk
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,4)='$thn' and c.tgl_keluar is null 
GROUP BY a.no_ipd) as a GROUP by bulan) 
as v GROUP by v.bulan order by Month(v.tgl)");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(d.tgl_layanan,4)='$thn' GROUP by bulan ORDER by Month(d.tgl_layanan)

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where left(B.tgl_layanan,4)='$thn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
            } else {
                return $this->db->query("
SELECT SUM(v.total) as total, SUM(v.jum_tind) as jum_tind, v.bulan, SUM(v.diskon) as diskon from 
(SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_keluar,'%M') as bulan, a.tgl_keluar as tgl, SUM(a.diskon) as diskon, count(*) as jum_tind from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total,  c.tgl_keluar,  c.tgl_masuk FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,4)='$thn' and c.carabayar='$psn'
GROUP BY a.no_ipd) as a GROUP by bulan 
UNION
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%M') as bulan, SUM(a.diskon) as diskon, a.tgl_masuk as tgl, count(*) as jum_tind from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar,  c.tgl_masuk
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,4)='$thn' and c.tgl_keluar is null and c.carabayar='$psn'
GROUP BY a.no_ipd) as a GROUP by bulan) 
as v GROUP by v.bulan order by Month(v.tgl)");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(d.tgl_layanan,4)='$thn' and c.carabayar='$psn' GROUP by bulan ORDER by Month(d.tgl_layanan)

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where left(B.tgl_layanan,4)='$thn' and A.carabayar='$psn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
            }
        } else {
            if ($psn == '0') {
                return $this->db->query("
SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_masuk,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is null and left(c.tgl_masuk,4)='$thn' GROUP by bulan ORDER by Month(c.tgl_masuk)");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(d.tgl_layanan,4)='$thn' and c.tgl_keluar is null GROUP by bulan ORDER by Month(d.tgl_layanan)

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is null and left(B.tgl_layanan,4)='$thn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
            } else {
                return $this->db->query("
SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_masuk,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is null and left(c.tgl_masuk,4)='$thn' and c.carabayar='$psn' GROUP by bulan ORDER by Month(c.tgl_masuk)");
                //SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(d.tgl_layanan,4)='$thn' and c.tgl_keluar is null and c.carabayar='$psn' GROUP by bulan ORDER by Month(d.tgl_layanan)

                //SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is null and left(B.tgl_layanan,4)='$thn' and A.carabayar='$psn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
            }
        }
    }

    function get_data_keu_tindakan_today()
    {
        return $this->db->query("
SELECT b.no_cm, b.nama, c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and c.tgl_masuk=left(now(),10) and c.tgl_keluar is not null
GROUP BY a.no_ipd ORDER BY c.no_ipd");
        //SELECT B.no_cm , B.nama, IFNULL(A.vtot,0) as total, A.tgl_masuk, A.no_ipd, A.tgl_keluar, IFNULL(A.diskon,0) as diskon FROM `pasien_iri` A, `data_pasien` B where A.no_cm = B.no_medrec and tgl_keluar is not null and A.tgl_masuk=left(now(),10) Group BY A.no_ipd
    }
    // Pasien SJP

    function get_pasien_sjp()
    {
        return $this->db->query("SELECT a.tgl_masuk, a.no_ipd, a.carabayar, b.no_cm, a.nama, a.noregasal
				FROM pasien_iri as a
				LEFT JOIN data_pasien as b ON a.no_medrec=b.no_medrec 
				where (a.carabayar='DIJAMIN' or a.carabayar='BPJS') and (a.keadaanpulang IS NULL or a.keadaanpulang='') 
				order by a.xupdate desc");
    }

    function getdata_pasien_sjp($no_register)
    {
        return $this->db->query("SELECT a.*, 
				b.no_cm, b.alamat, b.tgl_lahir, b.sex
				FROM pasien_iri as a
				LEFT JOIN data_pasien as b ON a.no_medrec=b.no_medrec 
				WHERE a.no_ipd='$no_register'");
    }

    function get_lap_data_pasien_pulang_iri($tgl)
    {
        $data = $this->db->query("SELECT 
                a.*, b.nm_dokter, c.*,
                CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
                (SELECT diagnosa FROM diagnosa_iri WHERE a.no_ipd = no_register AND a.tgl_keluar = '$tgl' LIMIT 1) AS diag1,
                (SELECT id_diagnosa FROM diagnosa_iri WHERE a.no_ipd = no_register AND a.tgl_keluar = '$tgl' LIMIT 1) AS id_diag
            FROM
                pasien_iri AS a 
                INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
                INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
            WHERE
                a.tgl_keluar = '$tgl'");

        return $data->result_array();
    }

    function get_lap_data_pasien_pulang_iri_bulan($bulan)
    {
        $data = $this->db->query("SELECT 
                a.*, b.nm_dokter, c.*,
                CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
                (SELECT diagnosa FROM diagnosa_iri WHERE a.no_ipd = no_register AND a.tgl_keluar LIKE '$bulan%' LIMIT 1) AS diag1,
                (SELECT id_diagnosa FROM diagnosa_iri WHERE a.no_ipd = no_register AND a.tgl_keluar LIKE '$bulan%' LIMIT 1) AS id_diag
            FROM
                pasien_iri AS a 
                INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
                INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
            WHERE
                a.tgl_keluar LIKE '$bulan%'");

        return $data->result_array();
    }

    function get_lap_data_pasien_pulang_iri_tahun($tahun)
    {
        $data = $this->db->query("SELECT 
                a.*, b.nm_dokter, c.*,
                CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
                (SELECT diagnosa FROM diagnosa_iri WHERE a.no_ipd = no_register AND a.tgl_keluar LIKE '$tahun%' LIMIT 1) AS diag1,
                (SELECT id_diagnosa FROM diagnosa_iri WHERE a.no_ipd = no_register AND a.tgl_keluar LIKE '$tahun%' LIMIT 1) AS id_diag
            FROM
                pasien_iri AS a 
                INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
                INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
            WHERE
                a.tgl_keluar LIKE '$tahun%'");

        return $data->result_array();
    }

    function get_jml_pasien_pulang_iri($tgl_awal, $tgl_akhir)
    {
        $data = $this->db->query("SELECT count(*) AS jumlah, tgl_keluar 
            FROM 
                pasien_iri 
            WHERE 
                tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir' 
            GROUP BY 
                tgl_keluar");

        return $data->result_array();
    }

    public function get_pasien_pulang($tgl_awal, $tgl_akhir)
    {
        $data = $this->db->query("SELECT *
            FROM 
                pasien_iri
            WHERE
                 tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'
            ORDER BY
                no_ipd ASC");

        return $data->result_array();
    }

    function getdata_pasien_sjp_rd($no_register)
    {
        return $this->db->query("SELECT * FROM irddaftar_ulang WHERE no_register='$no_register'");
    }

    function getdata_pasien_sjp_rj($no_register)
    {
        return $this->db->query("SELECT * FROM daftar_ulang_irj WHERE no_register='$no_register'");
    }

    function getdata_asal_rujukan($kd_ppk)
    {
        return $this->db->query("SELECT nm_ppk FROM data_ppk WHERE kd_ppk='$kd_ppk'");
    }

    function get_ruang($idrg)
    {
        return $this->db->query("SELECT * FROM ruang WHERE idrg='$idrg'");
    }

    function get_kunj_masuk_iri($tampil, $date)
    {
        if ($tampil == 'TGL') {
            return $this->db->query("SELECT
                    *,
                    (SELECT nm_poli FROM poliklinik WHERE poliklinik.id_poli = lap_rawat_inap.id_poli) AS pintu_masuk
                FROM
                    lap_rawat_inap 
                WHERE
                    to_char(tgl_masuk, 'YYYY-MM-DD') = '$date'");
        } else {
            return $this->db->query("SELECT
                    *,
                    (SELECT nm_poli FROM poliklinik WHERE poliklinik.id_poli = lap_rawat_inap.id_poli) AS pintu_masuk
                FROM
                    lap_rawat_inap 
                WHERE
                    to_char(tgl_masuk, 'YYYY-MM') = '$date'");
        }
    }

    function get_dirawat_iri()
    {
        return $this->db->query("select * FROM  lap_rawat_inap where tgl_keluar is null");
    }

    function get_pindah_ruang_iri()
    {
        return $this->db->query("SELECT A
                .*,
                ( SELECT nmruang FROM ruang WHERE ruang.idrg = A.idrg_asal LIMIT 1 ) AS nm_ruang_asal,
                ( SELECT nmruang FROM ruang WHERE ruang.idrg = A.idrg_pindah LIMIT 1 ) AS nm_ruang_pindah 
            FROM
                lap_pindah_ruang_ri AS A 
            WHERE
                idrg_asal IS NOT NULL 
                AND idrg_pindah IS NOT NULL");
    }

    function get_pindah_ruang_iri_date($tgl1, $tgl2)
    {
        return $this->db->query("SELECT A
                .*,
                ( SELECT nmruang FROM ruang WHERE ruang.idrg = A.idrg_asal LIMIT 1 ) AS nm_ruang_asal,
                ( SELECT nmruang FROM ruang WHERE ruang.idrg = A.idrg_pindah LIMIT 1 ) AS nm_ruang_pindah 
            FROM
                lap_pindah_ruang_ri AS A 
            WHERE
                idrg_asal IS NOT NULL 
                AND idrg_pindah IS NOT NULL
                AND to_char(a.tgl_keluar,'YYYY-MM-DD') BETWEEN '$tgl1' AND '$tgl2'");
    }

    function get_count_dpjp_utama_bln_pulang($date)
    {
        return $this->db->query("SELECT
                id_dokter,
                dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304','0707','0408')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504','0809','0810','0712','0509','0608')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603','0607')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704','0708','0707')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705','0709','0710')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703','0711')) AS jml_irnac_lt3
            FROM
                pasien_iri
            WHERE
                to_char(tgldaftarri,'YYYY-MM') = '$date'
                AND tgl_keluar IS NOT NULL
            GROUP BY
                id_dokter, dokter");
    }

    function get_count_dpjp_utama_bln($date)
    {
        return $this->db->query("SELECT
                id_dokter,
                dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3
            FROM
                pasien_iri
            WHERE
                to_char(tgldaftarri,'YYYY-MM') = '$date'
            GROUP BY
                id_dokter, dokter");
    }

    function get_count_dpjp_utama_tgl_pulang($date)
    {
        return $this->db->query("SELECT
                id_dokter,
                dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304','0707','0408')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504','0809','0810','0712','0509','0608')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603','0607')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704','0708','0707')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705','0709','0710')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703','0711')) AS jml_irnac_lt3
            FROM
                pasien_iri
            WHERE
                to_char(tgldaftarri,'YYYY-MM-DD') = '$date'
                AND tgl_keluar IS NOT NULL
            GROUP BY
                id_dokter, dokter");
    }

    function get_count_dpjp_utama_tgl($date)
    {
        return $this->db->query("SELECT
                id_dokter,
                dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3
            FROM
                pasien_iri
            WHERE
                to_char(tgldaftarri,'YYYY-MM-DD') = '$date'
            GROUP BY
                id_dokter, dokter");
    }

    function get_count_raber_bln_pulang($date)
    {
        return $this->db->query("SELECT
                b.id_dokter,
                c.nm_dokter AS dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304','0707','0408')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504','0809','0810','0712','0509','0608')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603','0607')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704','0708','0707')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705','0709','0710')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703','0711')) AS jml_irnac_lt3
            FROM
                pasien_iri AS a,
                drtambahan_iri AS b,
                data_dokter AS c
            WHERE
                to_char(b.xcreate,'YYYY-MM') = '$date'
                AND a.no_ipd = b.no_register
                AND b.ket IN ('Dokter Bersama','Dokter Bersama 1','Dokter Bersama 2','Dokter Bersama 3')
                AND CAST(b.id_dokter AS INT) = c.id_dokter
                AND a.tgl_keluar IS NOT NULL
            GROUP BY
                b.id_dokter, c.nm_dokter");
    }

    function get_count_raber_bln($date)
    {
        return $this->db->query("SELECT
                b.id_dokter,
                c.nm_dokter AS dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3
            FROM
                pasien_iri AS a,
                drtambahan_iri AS b,
                data_dokter AS c
            WHERE
                to_char(b.xcreate,'YYYY-MM') = '$date'
                AND a.no_ipd = b.no_register
                AND b.ket IN ('Dokter Bersama','Dokter Bersama 1','Dokter Bersama 2','Dokter Bersama 3')
                AND CAST(b.id_dokter AS INT) = c.id_dokter
            GROUP BY
                b.id_dokter, c.nm_dokter");
    }

    function get_count_raber_tgl_pulang($date)
    {
        return $this->db->query("SELECT
                b.id_dokter,
                c.nm_dokter AS dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304','0707','0408')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504','0809','0810','0712','0509','0608')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603','0607')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704','0708','0707')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705','0709','0710')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703','0711')) AS jml_irnac_lt3
            FROM
                pasien_iri AS a,
                drtambahan_iri AS b,
                data_dokter AS c
            WHERE
                to_char(b.xcreate,'YYYY-MM-DD') = '$date'
                AND a.no_ipd = b.no_register
                AND b.ket IN ('Dokter Bersama','Dokter Bersama 1','Dokter Bersama 2','Dokter Bersama 3')
                AND CAST(b.id_dokter AS INT) = c.id_dokter
                AND a.tgl_keluar IS NOT NULL
            GROUP BY
                b.id_dokter, c.nm_dokter");
    }

    function get_count_raber_tgl($date)
    {
        return $this->db->query("SELECT
                b.id_dokter,
                c.nm_dokter AS dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3
            FROM
                pasien_iri AS a,
                drtambahan_iri AS b,
                data_dokter AS c
            WHERE
                to_char(b.xcreate,'YYYY-MM-DD') = '$date'
                AND a.no_ipd = b.no_register
                AND b.ket IN ('Dokter Bersama','Dokter Bersama 1','Dokter Bersama 2','Dokter Bersama 3')
                AND CAST(b.id_dokter AS INT) = c.id_dokter
            GROUP BY
                b.id_dokter, c.nm_dokter");
    }

    function get_count_konsul_sekali_bln_pulang($date)
    {
        return $this->db->query("SELECT
                b.id_dokter,
                c.nm_dokter AS dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304','0707','0408')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504','0809','0810','0712','0509','0608')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603','0607')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704','0708','0707')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705','0709','0710')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703','0711')) AS jml_irnac_lt3
            FROM
                pasien_iri AS a,
                drtambahan_iri AS b,
                data_dokter AS c
            WHERE
                to_char(b.xcreate,'YYYY-MM') = '$date'
                AND a.no_ipd = b.no_register
                AND b.ket IN ('Konsultasi 1x','Kosultasi 1x')
                AND CAST(b.id_dokter AS INT) = c.id_dokter
                AND a.tgl_keluar IS NOT NULL
            GROUP BY
                b.id_dokter, c.nm_dokter");
    }

    function get_count_konsul_sekali_bln($date, $tampil)
    {
        if ($tampil == 'BLN') {
            return $this->db->query("SELECT
                    b.id_dokter,
                    c.nm_dokter AS dokter,
                    COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                    COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                    COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                    COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                    COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                    COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                    COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                    COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                    COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                    COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                    COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                    COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                    COUNT(*) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                    COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                    COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                    COUNT(*) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3
                FROM
                    pasien_iri AS a,
                    drtambahan_iri AS b,
                    data_dokter AS c
                WHERE
                    to_char(b.xcreate,'YYYY-MM') = '$date'
                    AND a.no_ipd = b.no_register
                    AND b.ket IN ('Konsultasi 1x','Kosultasi 1x')
                    AND CAST(b.id_dokter AS INT) = c.id_dokter
                GROUP BY
                    b.id_dokter, c.nm_dokter");
        } else {
            return $this->db->query("SELECT
                    b.id_dokter,
                    c.nm_dokter AS dokter,
                    COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                    COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                    COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                    COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                    COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                    COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                    COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                    COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                    COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                    COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                    COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                    COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                    COUNT(*) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                    COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                    COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                    COUNT(*) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3
                FROM
                    pasien_iri AS a,
                    drtambahan_iri AS b,
                    data_dokter AS c
                WHERE
                    to_char(b.xcreate,'YYYY-MM-DD') = '$date'
                    AND a.no_ipd = b.no_register
                    AND b.ket IN ('Konsultasi 1x','Kosultasi 1x')
                    AND CAST(b.id_dokter AS INT) = c.id_dokter
                GROUP BY
                    b.id_dokter, c.nm_dokter");
        }
    }

    function get_count_konsul_sekali_tgl_pulang($date)
    {
        return $this->db->query("SELECT
                b.id_dokter,
                c.nm_dokter AS dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304','0707','0408')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504','0809','0810','0712','0509','0608')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803','0806','0807','0808') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502','0505','0506') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602','0605') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603','0607')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704','0708','0707')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705','0709','0710')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303','0703','0711')) AS jml_irnac_lt3
            FROM
                pasien_iri AS a,
                drtambahan_iri AS b,
                data_dokter AS c
            WHERE
                to_char(b.xcreate,'YYYY-MM-DD') = '$date'
                AND a.no_ipd = b.no_register
                AND b.ket IN ('Konsultasi 1x','Kosultasi 1x')
                AND CAST(b.id_dokter AS INT) = c.id_dokter
                AND a.tgl_keluar IS NOT NULL
            GROUP BY
                b.id_dokter, c.nm_dokter");
    }

    function get_count_konsul_sekali_tgl($date)
    {
        return $this->db->query("SELECT
                b.id_dokter,
                c.nm_dokter AS dokter,
                COUNT(*) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                COUNT(*) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(*) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(*) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(*) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(*) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(*) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                COUNT(*) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                COUNT(*) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                COUNT(*) FILTER (WHERE idrg IN ('0303'.'0703')) AS jml_irnac_lt3
            FROM
                pasien_iri AS a,
                drtambahan_iri AS b,
                data_dokter AS c
            WHERE
                to_char(b.xcreate,'YYYY-MM-DD') = '$date'
                AND a.no_ipd = b.no_register
                AND b.ket IN ('Konsultasi 1x','Kosultasi 1x')
                AND CAST(b.id_dokter AS INT) = c.id_dokter
            GROUP BY
                b.id_dokter, c.nm_dokter");
    }

    function get_list_pasien_masuk($week_awal, $week_akhir)
    {
        return $this->db->query("SELECT A
                .no_ipd,
                b.nama,
                a.no_medrec,
                b.no_cm,
                c.nmruang,
                b.sex,
                a.tgl_masuk,
                a.dokter
            FROM
                pasien_iri AS a
                INNER JOIN data_pasien AS b ON a.no_medrec = b.no_medrec
                INNER JOIN ruang AS c ON a.idrg = c.idrg
                INNER JOIN ruang_iri AS d ON a.no_ipd = d.no_ipd
            WHERE 
                to_char(a.tgldaftarri,'YYYY-MM-DD') BETWEEN '$week_awal' AND '$week_akhir'
                AND d.tglkeluarrg IS NULL
                AND d.statkeluarrg IS NULL
                AND a.tgl_keluar IS NULL");
    }

    function get_list_pasien_masuk_by_medrec($medrec)
    {
        return $this->db->query("SELECT A
                .no_ipd,
                b.nama,
                a.no_medrec,
                b.no_cm,
                c.nmruang,
                b.sex,
                a.tgl_masuk,
                a.dokter
            FROM
                pasien_iri AS a
                INNER JOIN data_pasien AS b ON a.no_medrec = b.no_medrec
                INNER JOIN ruang AS c ON a.idrg = c.idrg
                INNER JOIN ruang_iri AS d ON a.no_ipd = d.no_ipd
            WHERE 
                b.no_cm LIKE '%$medrec%'
                AND d.tglkeluarrg IS NULL
                AND d.statkeluarrg IS NULL
                AND a.tgl_keluar IS NULL");
    }

    function get_list_pasien_mutasi($tgl_awal, $tgl_akhir)
    {
        return $this->db->query("SELECT DISTINCT A
                .no_ipd,
                b.nama,
                a.no_medrec,
                b.no_cm,
                c.nmruang,
                b.sex,
                a.tgl_masuk,
                a.dokter
            FROM
                pasien_iri AS a
                INNER JOIN data_pasien AS b ON a.no_medrec = b.no_medrec
                INNER JOIN ruang AS c ON a.idrg = c.idrg
                INNER JOIN ruang_iri AS d ON a.no_ipd = d.no_ipd
            WHERE 
                d.tglkeluarrg BETWEEN '$tgl_awal' AND '$tgl_akhir'
                AND d.statkeluarrg = 'pindah'");
    }

    function get_data_detail_mutasi($no_register)
    {
        return $this->db->query("SELECT 
                a.no_ipd,
                a.nama,
                c.nmruang,
                b.kelas,
                b.tglmasukrg,
                b.tglkeluarrg,
                b.statkeluarrg
            FROM
                pasien_iri AS A
                INNER JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
                INNER JOIN ruang AS c ON b.idrg = c.idrg
            WHERE
                b.no_ipd = '$no_register'
            ORDER BY
                b.tglkeluarrg DESC");
    }

    function get_count_visite_dpjp($date1)
    {
        // return $this->db->query("SELECT
        //     id_pemeriksa,
        //     nama_pemeriksa,
        //     COUNT( id_pemeriksa ) AS jml
        // FROM
        //     soap_pasien_ri
        // WHERE
        //     role = 'Dokter DPJP'
        //     AND to_char(tanggal_pemeriksaan, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
        // GROUP BY
        //     nama_pemeriksa, id_pemeriksa");
        return $this->db->query("SELECT A
                .id_pemeriksa, A.nama_pemeriksa,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3
            FROM
                soap_pasien_ri AS A,
                pasien_iri AS b 
            WHERE
                a.ROLE = 'Dokter DPJP' 
                AND a.no_ipd = b.no_ipd
                AND to_char( a.tanggal_pemeriksaan, 'YYYY-MM-DD' ) = '$date1' 
            GROUP BY
                a.nama_pemeriksa, a.id_pemeriksa");
    }

    function get_count_visite_dpjp_bln($bln)
    {
        return $this->db->query("SELECT A
                .id_pemeriksa, A.nama_pemeriksa,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3 
            FROM
                soap_pasien_ri AS A,
                pasien_iri AS b 
            WHERE
                a.ROLE = 'Dokter DPJP' 
                AND a.no_ipd = b.no_ipd
                AND to_char( a.tanggal_pemeriksaan, 'YYYY-MM' ) = '$bln' 
            GROUP BY
                a.nama_pemeriksa, a.id_pemeriksa");
    }

    function get_count_visite_raber_tgl($date1)
    {
        // return $this->db->query("SELECT
        //     id_pemeriksa,
        //         nama_pemeriksa,
        //         COUNT( id_pemeriksa ) AS jml
        //     FROM
        //         soap_pasien_ri
        //     WHERE
        //         role IN ('Dokter Bersama 1','Dokter Bersama 2')
        //         AND to_char(tanggal_pemeriksaan, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
        //     GROUP BY
        //         nama_pemeriksa, id_pemeriksa");
        return $this->db->query("SELECT A
                .id_pemeriksa, A.nama_pemeriksa,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3
            FROM
                soap_pasien_ri AS A,
                pasien_iri AS b 
            WHERE
                a.ROLE IN ('Dokter Bersama','Dokter Bersama 1','Dokter Bersama 2','Dokter Bersama 3')
                AND a.no_ipd = b.no_ipd
                AND to_char( a.tanggal_pemeriksaan, 'YYYY-MM-DD' ) = '$date1'
            GROUP BY
                a.nama_pemeriksa, a.id_pemeriksa");
    }

    function get_count_visite_raber_bln($bln)
    {
        return $this->db->query("SELECT A
                .id_pemeriksa, A.nama_pemeriksa,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0404','0704','0304')) AS jml_icu,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0106','0604','0706','0804','0805','0504')) AS jml_hcu,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'I') AS jml_neuro_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0401','0402','0403','0801','0802','0803') AND klsiri = 'II') AS jml_neuro_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'I') AS jml_anak_bedah_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'II') AS jml_anak_bedah_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0101','0103','0501','0502') AND klsiri = 'III') AS jml_anak_bedah_3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'I') AS jml_interne_1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'II') AS jml_interne_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg = '0102' AND klsiri = 'III') AS jml_interne_3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'II') AS jml_irnab_lt12_2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0201','0203','0601','0602') AND klsiri = 'VIP') AS jml_irnab_lt12_vip,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0202','0603')) AS jml_irnab_lt3,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0301','0701','0704')) AS jml_irnac_lt1,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0302','0702','0705')) AS jml_irnac_lt2,
                COUNT(a.id_pemeriksa) FILTER (WHERE idrg IN ('0303','0703')) AS jml_irnac_lt3
            FROM
                soap_pasien_ri AS A,
                pasien_iri AS b 
            WHERE
                a.ROLE IN ('Dokter Bersama','Dokter Bersama 1','Dokter Bersama 2','Dokter Bersama 3')
                AND a.no_ipd = b.no_ipd
                AND to_char( a.tanggal_pemeriksaan, 'YYYY-MM' ) = '$bln'
            GROUP BY
                a.nama_pemeriksa, a.id_pemeriksa");
    }

    function get_diagnosa()
    {
        return $this->db->query("SELECT * from icd1 where deleted = '0'");
    }

    function get_wilayah()
    {
        return $this->db->query("SELECT * from wilayah WHERE kotakabupaten IS NOT NULL");
    }

    public function get_wilayah_detail($date, $lap_per, $layanan)
    {
        if ($layanan == 'rj') {
            if ($date == '' || $lap_per == '') {
                return $this->db->query("SELECT
                    CASE  
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_pasien A,
                            daftar_ulang_irj b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_register
                            AND b.no_medrec = C.no_medrec 
                            AND b.id_poli != 'BA00'
                        GROUP BY
                            C.provinsi,
                        C.kotakabupaten,
                        A.id_diagnosa");
            } elseif ($lap_per == 'TGL') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_pasien A,
                            daftar_ulang_irj b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_register
                            AND b.no_medrec = C.no_medrec 
                            and b.id_poli != 'BA00'
                            AND to_char(b.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
                        GROUP BY
                            C.provinsi,
                        C.kotakabupaten,
                        A.id_diagnosa");
            } elseif ($lap_per == 'BLN') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_pasien A,
                            daftar_ulang_irj b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_register
                            AND b.no_medrec = C.no_medrec 
                            and b.id_poli != 'BA00'
                            AND to_char(b.tgl_kunjungan, 'YYYY-MM') = '$date'
                        GROUP BY
                            C.provinsi,
                        C.kotakabupaten,
                        A.id_diagnosa");
            } elseif ($lap_per == 'THN') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_iri A,
                            pasien_iri b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_ipd
                            AND b.no_medrec = C.no_medrec 
                            AND to_char(b.tgldaftarri, 'YYYY') = '$date'
                        GROUP BY
                            C.provinsi,
                            C.kotakabupaten,
                            A.id_diagnosa");
            } else {
                return $this->db->query("SELECT kotakabupaten,id_diagnosa,sum(jmlh_pasien) as jmlh_pasien from wilayah_detail group by kotakabupaten,id_diagnosa order by sum(jmlh_pasien) desc ");
            }
        } else if ($layanan == 'rd') {
            if ($date == '' || $lap_per == '') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_iri A,
                            pasien_iri b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_ipd
                            AND b.no_medrec = C.no_medrec 
                        GROUP BY
                            C.provinsi,
                            C.kotakabupaten,
                            A.id_diagnosa ");
            } elseif ($lap_per == 'TGL') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_pasien A,
                            daftar_ulang_irj b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_register
                            AND b.no_medrec = C.no_medrec 
                            and b.id_poli = 'BA00'
                            AND to_char(b.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
                        GROUP BY
                            C.provinsi,
                        C.kotakabupaten,
                        A.id_diagnosa");
            } elseif ($lap_per == 'BLN') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_pasien A,
                            daftar_ulang_irj b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_register
                            AND b.no_medrec = C.no_medrec 
                            and b.id_poli = 'BA00'
                            AND to_char(b.tgl_kunjungan, 'YYYY-MM') = '$date'
                        GROUP BY
                            C.provinsi,
                        C.kotakabupaten,
                        A.id_diagnosa");
            } elseif ($lap_per == 'THN') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_iri A,
                            pasien_iri b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_ipd
                            AND b.no_medrec = C.no_medrec 
                            AND to_char(b.tgldaftarri, 'YYYY') = '$date'
                        GROUP BY
                            C.provinsi,
                            C.kotakabupaten,
                            A.id_diagnosa");
            } else {
                return $this->db->query("SELECT kotakabupaten,id_diagnosa,sum(jmlh_pasien) as jmlh_pasien from wilayah_detail group by kotakabupaten,id_diagnosa order by sum(jmlh_pasien) desc ");
            }
        } else {
            if ($date == '' || $lap_per == '') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_iri A,
                            pasien_iri b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_ipd
                            AND b.no_medrec = C.no_medrec 
                        GROUP BY
                            C.provinsi,
                            C.kotakabupaten,
                            A.id_diagnosa ");
            } elseif ($lap_per == 'TGL') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_iri A,
                            pasien_iri b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_ipd
                            AND b.no_medrec = C.no_medrec 
                            AND to_char(b.tgldaftarri, 'YYYY-MM-DD') = '$date'
                        GROUP BY
                            C.provinsi,
                            C.kotakabupaten,
                            A.id_diagnosa");
            } elseif ($lap_per == 'BLN') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_iri A,
                            pasien_iri b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_ipd
                            AND b.no_medrec = C.no_medrec 
                            AND to_char(b.tgldaftarri, 'YYYY-MM') = '$date'
                        GROUP BY
                            C.provinsi,
                            C.kotakabupaten,
                            A.id_diagnosa");
            } elseif ($lap_per == 'THN') {
                return $this->db->query("SELECT
                    CASE
                        WHEN C
                            .provinsi :: TEXT = 'SUMATERA BARAT' :: TEXT THEN
                                C.kotakabupaten ELSE C.provinsi 
                                END AS kotakabupaten,
                            A.id_diagnosa,
                            COUNT ( A.id_diagnosa ) AS jmlh_pasien 
                        FROM
                            diagnosa_iri A,
                            pasien_iri b,
                            data_pasien C 
                        WHERE
                            A.no_register = b.no_ipd
                            AND b.no_medrec = C.no_medrec 
                            AND to_char(b.tgldaftarri, 'YYYY') = '$date'
                        GROUP BY
                            C.provinsi,
                            C.kotakabupaten,
                            A.id_diagnosa");
            } else {
                return $this->db->query("SELECT kotakabupaten,id_diagnosa,sum(jmlh_pasien) as jmlh_pasien from wilayah_detail group by kotakabupaten,id_diagnosa order by sum(jmlh_pasien) desc ");
            }
        }
    }

    function get_kunj_diagnosa_kasus_jenkel($date, $lap_per)
    {
        if ($date == '' || $lap_per == '') {
            return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
				SUM(l) as l,
				SUM(p) as p,
				sum(l) + sum(p) as jumlah
				from lap_kunj_poli_diagnosa_kasus_jenkel_ri
					GROUP BY id_diagnosa,nm_diagnosa
				");
        } elseif ($lap_per == 'TGL') {
            return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
				SUM(l) as l,
				SUM(p) as p,
				sum(baru) + sum(lama) as jumlah
				from lap_kunj_poli_diagnosa_kasus_jenkel_ri
					where to_char(tgldaftarri,'YYYY-MM-DD') = '$date'
					GROUP BY id_diagnosa,nm_diagnosa
				");
        } elseif ($lap_per == 'BLN') {
            return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
				SUM(l) as l,
				SUM(p) as p,
				sum(baru) + sum(lama) as jumlah
				from lap_kunj_poli_diagnosa_kasus_jenkel_ri
					where to_char(tgldaftarri,'YYYY-MM') = '$date'
					GROUP BY id_diagnosa,nm_diagnosa
				");
        } elseif ($lap_per == 'THN') {
            return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
				SUM(l) as l,
				SUM(p) as p,
				sum(baru) + sum(lama) as jumlah
				from lap_kunj_poli_diagnosa_kasus_jenkel_ri
					where to_char(tgldaftarri,'YYYY') = '$date'
					GROUP BY id_diagnosa,nm_diagnosa
				");
        } else {
            return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
				SUM(l) as l,
				SUM(p) as p,
				sum(baru) + sum(lama) as jumlah
				from lap_kunj_poli_diagnosa_kasus_jenkel_ri
					GROUP BY id_diagnosa,nm_diagnosa
				");
        }
    }

    function get_realisasi_pendapatan_pasien_pulang_bpjs_new($date1, $date2)
    {
        return $this->db->query("SELECT 
                a.no_sep,
                b.no_ipd,
                c.no_cm,
                'BPJS' AS carabayar,
                b.tgl_keluar_resume AS tgl,
                b.kd_inacbg,
                b.no_medrec,
                c.nama,
                (SELECT nmruang FROM ruang WHERE idrg = b.idrg LIMIT 1) AS ruang,
                b.klsiri,
                (SELECT vtot FROM total_lab_iri WHERE b.no_ipd = no_register LIMIT 1) AS lab_iri,
                (SELECT vtot FROM total_lab_irj_non_rujuk WHERE b.noregasal = no_register LIMIT 1) AS lab_igd,
                (SELECT vtot FROM total_rad_iri WHERE b.no_ipd = no_register LIMIT 1) AS rad_iri,
                (SELECT vtot FROM total_rad_irj_non_rujuk WHERE b.noregasal = no_register LIMIT 1) AS rad_igd,
                (SELECT vtot FROM total_ok_iri WHERE b.no_ipd = no_register LIMIT 1) AS ok_iri,
                (SELECT vtot FROM total_ok_irj_non_rujuk WHERE b.noregasal = no_register LIMIT 1) AS ok_igd,
                (SELECT vtot FROM total_em_iri WHERE b.no_ipd = no_register LIMIT 1) AS em_iri,
                (SELECT vtot FROM total_em_irj_non_rujuk WHERE b.noregasal = no_register LIMIT 1) AS em_igd,
                (SELECT vtot FROM mrm WHERE b.noregasal = no_register LIMIT 1) AS mr,
                (SELECT vtot FROM gizi_iri WHERE b.no_ipd = no_ipd LIMIT 1) AS gizi_iri,
                (SELECT vtot FROM gizi_irj WHERE b.noregasal = no_register LIMIT 1) AS gizi_igd,
                (SELECT vtot FROM rehab_iri WHERE b.no_ipd = no_ipd LIMIT 1) AS rehab_iri,
                (SELECT vtot FROM rehab_irj WHERE b.noregasal = no_register LIMIT 1) AS rehab_igd,
                (SELECT vtot FROM tindakan_iri WHERE b.no_ipd = no_ipd LIMIT 1) AS iri,
                (SELECT vtot FROM tindakan_irj WHERE b.noregasal = no_register LIMIT 1) AS irj,
                (SELECT vtot FROM tindakan_igd WHERE b.noregasal = no_register LIMIT 1) AS igd,
                (SELECT SUM(vtot) + embalase::integer FROM resep_pasien WHERE b.no_ipd = no_register GROUP BY embalase LIMIT 1) AS farmasi_iri,
                (SELECT SUM(vtot) + embalase::integer FROM resep_pasien WHERE b.noregasal = no_register GROUP BY embalase LIMIT 1) AS farmasi_irj
            FROM 
                umbal_pasien AS A
                LEFT OUTER JOIN pasien_iri AS b ON a.no_sep = b.no_sep 
                LEFT JOIN data_pasien AS c ON b.no_medrec = c.no_medrec
            WHERE 
                to_char(b.tgl_keluar_resume, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2' UNION 
            SELECT 
                a.no_sep,
                b.no_register AS no_ipd,
                c.no_cm,
                'BPJS' AS carabayar,
                b.tgl_kunjungan::date AS tgl,
                b.kode_inacbg AS kd_inacbg,
                b.no_medrec,
                c.nama,
                (SELECT nm_poli FROM poliklinik WHERE id_poli = b.id_poli LIMIT 1) AS ruang,
                b.kelas_pasien AS klsiri,
                0 AS lab_iri,
                (SELECT vtot FROM total_lab_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1) AS lab_igd,
                0 AS rad_iri,
                (SELECT vtot FROM total_rad_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1) AS rad_igd,
                0 AS ok_iri,
                (SELECT vtot FROM total_ok_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1) AS ok_igd,
                0 AS em_iri,
                (SELECT vtot FROM total_em_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1) AS em_igd,
                (SELECT vtot FROM mrm WHERE b.no_register = no_register LIMIT 1) AS mr,
                0 AS gizi_iri,
                (SELECT vtot FROM gizi_irj WHERE b.no_register = no_register LIMIT 1) AS gizi_igd,
                0 AS rehab_iri,
                (SELECT vtot FROM rehab_irj WHERE b.no_register = no_register LIMIT 1) AS rehab_igd,
                0 AS iri,
                (SELECT vtot FROM tindakan_irj WHERE b.no_register = no_register LIMIT 1) AS irj,
                (SELECT vtot FROM tindakan_igd WHERE b.no_register = no_register LIMIT 1) AS igd,
                0 AS farmasi_iri,
                (SELECT SUM(vtot) + embalase::integer FROM resep_pasien WHERE b.no_register = no_register GROUP BY embalase LIMIT 1) AS farmasi_irj
            FROM 
                umbal_pasien AS A
                LEFT OUTER JOIN daftar_ulang_irj AS b ON a.no_sep = b.no_sep 
                LEFT JOIN data_pasien AS c ON b.no_medrec = c.no_medrec
            WHERE 
                to_char(b.tgl_kunjungan, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'");
    }

    function get_realisasi_pendapatan_pasien_pulang_bpjs($date1, $date2)
    {
        // return $this->db->query("SELECT 
        //     a.no_register,
        //     a.carabayar,
        //     a.tgl_keluar_resume,
        //     b.no_cm,
        //     b.nama,
        //     (SELECT no_kwitansi FROM no_kwitansi WHERE a.no_register = no_register LIMIT 1) AS no_kwitansi,
        //     CASE
        //         WHEN (substr(a.no_register,1,2) = 'RJ') THEN (SELECT kelas_pasien FROM daftar_ulang_irj WHERE a.no_register = no_register LIMIT 1)
        //         ELSE (SELECT klsiri FROM pasien_iri WHERE a.no_register = no_ipd LIMIT 1)
        //     END AS kelas,
        //     CASE
        //         WHEN (substr(a.no_register,1,2) = 'RI') THEN (SELECT ruang.nmruang FROM ruang, pasien_iri WHERE a.no_register = pasien_iri.no_ipd AND ruang.idrg = pasien_iri.idrg LIMIT 1)
        //         ELSE (SELECT poliklinik.nm_poli FROM poliklinik, daftar_ulang_irj WHERE a.no_register = daftar_ulang_irj.no_register AND poliklinik.id_poli = daftar_ulang_irj.id_poli LIMIT 1)
        //     END AS asal,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.id_tindakan IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304') AND a.ins = 'akomodasi') AS ruang_intensif,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.ins = 'tind_igd' AND a.id_tindakan NOT IN ('BM0006','BM0007','1B0101','1B0105','1B0104') AND substr(a.id_tindakan,1,2) != 'BK') AS igd,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.ins = 'ok') AS ok,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.kel_tindakan = 'Farmasi') AS resep,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.id_tindakan IN ('BM0006','BM0007')) AS gizi,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.ins = 'lab') AS lab,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.ins = 'rad') AS rad,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.id_tindakan IN ('1B0101','1B0105','1B0104')) AS mr,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.ins = 'tind_iri' AND a.id_tindakan NOT IN ('BM0006','BM0007','1B0101','1B0105','1B0104') AND substr(a.id_tindakan,1,2) != 'BK') AS iri,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.id_tindakan NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304') AND a.ins = 'akomodasi') AS ruang,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE a.ins = 'tind_irj' AND a.id_tindakan NOT IN ('BM0006','BM0007','1B0101','1B0105','1B0104') AND substr(a.id_tindakan,1,2) != 'BK') AS irj,
        //     SUM(CAST(a.vtot AS FLOAT)) FILTER (WHERE substr(a.id_tindakan,1,2) = 'BK') AS rehab,
        //     (SELECT kd_inacbg FROM pasien_iri WHERE no_ipd = a.no_register LIMIT 1) AS kd_inacbg
        // FROM 
        //     realisasi_tindakan AS a,
        //     data_pasien AS b
        // WHERE 
        //     a.ins IS NOT NULL 
        //     AND to_char(a.tgl_keluar_resume,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
        //     AND carabayar = '$jaminan'
        //     AND a.no_medrec = b.no_medrec
        // GROUP BY 
        //     a.no_register, a.carabayar, a.tgl_keluar_resume, b.no_cm, b.nama");

        $month = explode("-", $date)[1];
        $thn = explode("-", $date)[0];
        return $this->db->query("SELECT 
                a.no_sep,
                b.no_register AS no_ipd,
                c.no_cm,
                'BPJS' AS carabayar,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT tgl_keluar_resume FROM pasien_iri WHERE no_ipd = b.no_register LIMIT 1) 
                    ELSE (SELECT tgl_kunjungan::date FROM daftar_ulang_irj WHERE no_register = b.no_register LIMIT 1)
                END AS tgl,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT kd_inacbg FROM pasien_iri WHERE no_ipd = b.no_register LIMIT 1) 
                    ELSE (SELECT kode_inacbg FROM daftar_ulang_irj WHERE no_register = b.no_register LIMIT 1)
                END AS kd_inacbg,
                b.no_medrec,
                c.nama,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT ruang.nmruang FROM ruang, pasien_iri WHERE pasien_iri.no_ipd = b.no_register AND ruang.idrg = pasien_iri.idrg LIMIT 1) 
                    ELSE (SELECT poliklinik.nm_poli FROM poliklinik, daftar_ulang_irj WHERE daftar_ulang_irj.no_register = b.no_register AND daftar_ulang_irj.id_poli = poliklinik.id_poli LIMIT 1)
                END AS ruang,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT klsiri FROM pasien_iri WHERE no_ipd = b.no_register LIMIT 1) 
                    ELSE (SELECT kelas_pasien FROM daftar_ulang_irj WHERE no_register = b.no_register LIMIT 1)
                END AS klsiri,
                (SELECT vtot FROM total_lab_iri WHERE b.no_register = no_register LIMIT 1) AS lab_iri,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT total_lab_irj_non_rujuk.vtot FROM total_lab_irj_non_rujuk, pasien_iri WHERE pasien_iri.noregasal = total_lab_irj_non_rujuk.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1)
                    ELSE (SELECT vtot FROM total_lab_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1)
                END AS lab_igd,
                (SELECT vtot FROM total_rad_iri WHERE b.no_register = no_register LIMIT 1) AS rad_iri,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT total_rad_irj_non_rujuk.vtot FROM total_rad_irj_non_rujuk, pasien_iri WHERE pasien_iri.noregasal = total_rad_irj_non_rujuk.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1)
                    ELSE (SELECT vtot FROM total_rad_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1)
                END AS rad_igd,
                (SELECT vtot FROM total_ok_iri WHERE b.no_register = no_register LIMIT 1) AS ok_iri,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT total_ok_irj_non_rujuk.vtot FROM total_ok_irj_non_rujuk, pasien_iri WHERE pasien_iri.noregasal = total_ok_irj_non_rujuk.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1)
                    ELSE (SELECT vtot FROM total_ok_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1)
                END AS ok_igd,
                (SELECT vtot FROM total_em_iri WHERE b.no_register = no_register LIMIT 1) AS em_iri,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT total_em_irj_non_rujuk.vtot FROM total_em_irj_non_rujuk, pasien_iri WHERE pasien_iri.noregasal = total_em_irj_non_rujuk.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1)
                    ELSE (SELECT vtot FROM total_em_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1)
                END AS em_igd,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT mrm.vtot FROM mrm, pasien_iri WHERE pasien_iri.noregasal = mrm.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1)
                    ELSE (SELECT vtot FROM mrm WHERE b.no_register = no_register LIMIT 1)
                END AS mr,
                (SELECT vtot FROM gizi_iri WHERE b.no_register = no_ipd LIMIT 1) AS gizi_iri,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT gizi_irj.vtot FROM gizi_irj, pasien_iri WHERE pasien_iri.noregasal = gizi_irj.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1)
                    ELSE (SELECT vtot FROM gizi_irj WHERE b.no_register = no_register LIMIT 1)
                END AS gizi_igd,
                (SELECT vtot FROM rehab_iri WHERE b.no_register = no_ipd LIMIT 1) AS rehab_iri,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT rehab_irj.vtot FROM rehab_irj, pasien_iri WHERE pasien_iri.noregasal = rehab_irj.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1)
                    ELSE (SELECT vtot FROM rehab_irj WHERE b.no_register = no_register LIMIT 1)
                END AS rehab_igd,
                (SELECT vtot FROM tindakan_iri WHERE b.no_register = no_ipd LIMIT 1) AS iri,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT tindakan_irj.vtot FROM tindakan_irj, pasien_iri WHERE pasien_iri.noregasal = tindakan_irj.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1)
                    ELSE (SELECT vtot FROM tindakan_irj WHERE b.no_register = no_register LIMIT 1)
                END AS irj,
                CASE 
                    WHEN(SUBSTRING(b.no_register,1,2) = 'RI') THEN (SELECT tindakan_igd.vtot FROM tindakan_igd, pasien_iri WHERE pasien_iri.noregasal = tindakan_igd.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1)
                    ELSE (SELECT vtot FROM tindakan_igd WHERE b.no_register = no_register LIMIT 1)
                END AS igd
            FROM 
                umbal_pasien AS A
                LEFT OUTER JOIN bpjs_sep AS b ON a.no_sep = b.no_sep 
                LEFT JOIN data_pasien AS c ON b.no_medrec = c.no_medrec
            WHERE 
                a.bln_klaim = '$month'
                AND a.tahun = '$thn' UNION");
    }

    function get_realisasi_pendapatan_pasien_pulang($date1, $date2, $jaminan)
    {
        // return $this->db->query("SELECT
        //     *
        // FROM
        //     lap_pendapatan_pasien_pulang_m 
        // WHERE
        //     carabayar = '$jaminan'
        //     AND to_char(tgl, 'YYYY-MM') BETWEEN '$date1' AND '$date2'");

        if ($jaminan == 'UMUM') {
            $akom = "(SELECT SUM(total_tarif * diff) FROM akomodasi_realisasi WHERE no_ipd = a.no_register AND idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
            $intensif = "(SELECT SUM(total_tarif * diff) FROM akomodasi_realisasi WHERE no_ipd = a.no_register AND idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
        } else {
            $akom = "(SELECT SUM(tarif_iks * diff) FROM akomodasi_realisasi WHERE no_ipd = a.no_register AND idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
            $intensif = "(SELECT SUM(tarif_iks * diff) FROM akomodasi_realisasi WHERE no_ipd = a.no_register AND idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
        }

        return $this->db->query("SELECT 
                a.no_register,
                a.nama,
                a.cara_bayar,
                a.no_medrec,
                a.tgl_kunjungan,
                a.nm_poli,
                a.kelas_pasien,
                b.id_poli,
                SUM(a.igd::int) AS igd,
                SUM(a.ok::int) AS ok,
                (SELECT SUM(vtot::int) FROM pelayanan_poli WHERE a.no_register = no_register AND SUBSTRING(idtindakan,1,2) = 'BM' AND b.id_poli = 'BA00' LIMIT 1) AS gizi_igd,
                (SELECT SUM(vtot::int) FROM pelayanan_poli WHERE a.no_register = no_register AND SUBSTRING(idtindakan,1,2) = 'BM' AND b.id_poli != 'BA00' LIMIT 1) AS gizi_irj,
                SUM(a.lab::int) AS lab,
                SUM(a.mr::int) AS mr,
                SUM(a.rad::int) AS rad,
                SUM(a.em::int) AS em,
                0 AS iri,
                0 AS ruang,
                0 AS intensif,
                (SELECT SUM(vtot::int) FROM pelayanan_poli WHERE a.no_register = no_register AND SUBSTRING(idtindakan,1,2) = 'BK' AND b.id_poli = 'BA00' LIMIT 1) AS rehab_igd,
                (SELECT SUM(vtot::int) FROM pelayanan_poli WHERE a.no_register = no_register AND SUBSTRING(idtindakan,1,2) = 'BK' AND b.id_poli != 'BA00' LIMIT 1) AS rehab_irj,
                SUM(a.irj::int) AS irj,
                SUM(a.farmasi::int) AS farmasi
            FROM 
                pendapatan_pasien_pulang AS a
                LEFT JOIN daftar_ulang_irj AS b ON a.no_register = b.no_register
            WHERE 
                to_char(a.tgl_cetak, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
                AND a.cara_bayar = '$jaminan'
            GROUP BY 
                a.no_register,
                a.nama,
                a.cara_bayar,
                a.no_medrec,
                a.tgl_kunjungan,
                a.nm_poli,
                a.kelas_pasien,
                b.id_poli UNION 
            SELECT 
                a.no_register,
                a.nama,
                a.carabayar AS cara_bayar,
                a.no_medrec,
                a.tgl_kunjungan,
                a.nmruang AS nm_poli,
                a.klsiri AS kelas_pasien,
                'ranap' AS id_poli,
                SUM(a.igd::int) AS igd,
                SUM(COALESCE(a.ok_igd::int, 0)) + SUM(COALESCE(a.ok_iri::int, 0)) AS ok,
                SUM(COALESCE(a.gizi_igd::int, 0)) AS gizi_igd,
                SUM(COALESCE(a.gizi_iri::int, 0)) AS gizi_irj,
                SUM(COALESCE(a.lab_igd::int, 0)) + SUM(COALESCE(a.lab_iri::int, 0)) AS lab,
                SUM(a.mr::int) AS mr,
                SUM(COALESCE(a.rad_igd::int, 0)) + SUM(COALESCE(a.rad_iri::int, 0)) AS rad,
                SUM(COALESCE(a.em_igd::int, 0)) + SUM(COALESCE(a.em_iri::int, 0)) AS em,
                SUM(a.iri::int) AS iri,
                $akom AS ruang,
                $intensif AS intensif,
                SUM(COALESCE(a.rehab_igd::int, 0)) AS rehab_igd,
                SUM(COALESCE(a.rehab_iri::int, 0)) AS rehab_irj,
                SUM(a.irj::int) AS irj,
                SUM(COALESCE(a.farmasi_iri::int, 0)) + SUM(COALESCE(a.farmasi_irj::int, 0)) AS farmasi
            FROM 
                pendapatan_pasien_pulang_iri AS a 
            WHERE 
                to_char(a.tgl_cetak, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
                AND a.carabayar = '$jaminan'
            GROUP BY 
                a.no_register,
                a.nama,
                a.carabayar,
                a.no_medrec,
                a.tgl_kunjungan,
                a.nmruang,
                a.klsiri");
    }

    function get_realisasi_pendapatan_pasien_pulang_umum($date1, $date2)
    {
        return $this->db->query("SELECT
                *
            FROM
                lap_pendapatan_pasien_pulang_m 
            WHERE
                carabayar = 'UMUM'
                AND tgl BETWEEN '$date1' AND '$date2'");
    }

    function get_realisasi_pendapatan_pasien_pulang_selisih_tarif($date1, $date2)
    {
        // return $this->db->query("SELECT
        //     a.*,
        //     b.no_sep
        // FROM
        //     lap_pendapatan_pasien_pulang_m AS a
        //     LEFT OUTER JOIN bpjs_sep AS b ON a.no_ipd = b.no_register
        // WHERE
        //     carabayar = 'BPJS'
        //     AND selisih_tarif = '1'
        //     AND to_char( tgl, 'YYYY-MM' ) = '$date'");

        return $this->db->query("SELECT 
                b.no_sep,
                b.no_ipd,
                c.no_cm,
                'BPJS' AS carabayar,
                b.tgl_keluar_resume AS tgl,
                b.kd_inacbg,
                b.no_medrec,
                c.nama,
                (SELECT nmruang FROM ruang WHERE idrg = b.idrg LIMIT 1) AS ruang,
                b.klsiri,
                (SELECT vtot FROM total_lab_iri WHERE b.no_ipd = no_register LIMIT 1) AS lab_iri,
                (SELECT vtot FROM total_lab_irj_non_rujuk WHERE b.noregasal = no_register LIMIT 1) AS lab_igd,
                (SELECT vtot FROM total_rad_iri WHERE b.no_ipd = no_register LIMIT 1) AS rad_iri,
                (SELECT vtot FROM total_rad_irj_non_rujuk WHERE b.noregasal = no_register LIMIT 1) AS rad_igd,
                (SELECT vtot FROM total_ok_iri WHERE b.no_ipd = no_register LIMIT 1) AS ok_iri,
                (SELECT vtot FROM total_ok_irj_non_rujuk WHERE b.noregasal = no_register LIMIT 1) AS ok_igd,
                (SELECT vtot FROM total_em_iri WHERE b.no_ipd = no_register LIMIT 1) AS em_iri,
                (SELECT vtot FROM total_em_irj_non_rujuk WHERE b.noregasal = no_register LIMIT 1) AS em_igd,
                (SELECT vtot FROM mrm WHERE b.noregasal = no_register LIMIT 1) AS mr,
                (SELECT vtot FROM gizi_iri WHERE b.no_ipd = no_ipd LIMIT 1) AS gizi_iri,
                (SELECT vtot FROM gizi_irj WHERE b.noregasal = no_register LIMIT 1) AS gizi_igd,
                (SELECT vtot FROM rehab_iri WHERE b.no_ipd = no_ipd LIMIT 1) AS rehab_iri,
                (SELECT vtot FROM rehab_irj WHERE b.noregasal = no_register LIMIT 1) AS rehab_igd,
                (SELECT vtot FROM tindakan_iri WHERE b.no_ipd = no_ipd LIMIT 1) AS iri,
                (SELECT vtot FROM tindakan_irj WHERE b.noregasal = no_register LIMIT 1) AS irj,
                (SELECT vtot FROM tindakan_igd WHERE b.noregasal = no_register LIMIT 1) AS igd,
                (SELECT SUM(vtot) + embalase::integer FROM resep_pasien WHERE b.no_ipd = no_register GROUP BY embalase LIMIT 1) AS farmasi_iri,
                (SELECT SUM(vtot) + embalase::integer FROM resep_pasien WHERE b.noregasal = no_register GROUP BY embalase LIMIT 1) AS farmasi_irj
            FROM 
                pasien_iri AS b 
                LEFT JOIN data_pasien AS c ON b.no_medrec = c.no_medrec
                LEFT JOIN no_kwitansi AS a ON a.no_register = b.no_ipd
            WHERE 
                to_char(a.tgl_cetak, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
                AND b.carabayar = 'BPJS'
                AND b.selisih_tarif = 1
                AND b.cetak_kwitansi = '1'");
    }

    function get_ruang_intensif_non_intensif($no_ipd)
    {
        return $this->db->query("SELECT A
                .*,
                b.nmruang,
                C.total_tarif,
                (
                SELECT
                    x.total_tarif
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah,
                d.tgl_keluar_resume
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND a.no_ipd = '$no_ipd'
                AND a.no_ipd = d.no_ipd");
    }

    function get_ruang_intensif($no_ipd)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                c.tarif_bpjs,
                c.tarif_iks,
                (
                SELECT
                    x.total_tarif
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah,
                (
                SELECT
                    x.tarif_bpjs
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah_bpjs,
                (
                SELECT
                    x.tarif_iks
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah_iks,
                d.tgl_keluar_resume,
                d.titip
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND a.idrg IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304')
                AND a.no_ipd = '$no_ipd'
                AND a.no_ipd = d.no_ipd");

        return $data->result_array();
    }

    function get_ruang_non_intensif($no_ipd)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                c.tarif_bpjs,
                c.tarif_iks,
                (
                SELECT
                    x.total_tarif
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah,
                (
                SELECT
                    x.tarif_bpjs
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah_bpjs,
                (
                SELECT
                    x.tarif_iks
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah_iks,
                d.tgl_keluar_resume,
                d.titip
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND a.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304')
                AND a.no_ipd = '$no_ipd'
                AND a.no_ipd = d.no_ipd");

        return $data->result_array();
    }

    function get_data_list_rincian_bil_pasien($date)
    {
        return $this->db->query("SELECT
                a.no_ipd,
                a.noregasal,
                a.tgl_keluar_resume,
                b.no_cm,
                b.nama,
                (SELECT no_kwitansi FROM no_kwitansi WHERE a.no_ipd = no_register LIMIT 1) AS no_kwitansi,
                (SELECT nmruang FROM ruang WHERE a.idrg = idrg LIMIT 1) AS ruang,
                a.klsiri,
                a.carabayar
            FROM
                pasien_iri AS a,
                data_pasien AS b
            WHERE
                a.no_medrec = b.no_medrec
                AND a.cetak_kwitansi = '1'
                AND to_char(a.tgl_keluar_resume,'YYYY-MM-DD') = '$date'");
    }

    function get_noregasal_pasien($no_ipd)
    {
        return $this->db->query("SELECT noregasal FROM pasien_iri WHERE no_ipd = '$no_ipd'");
    }

    function get_data_pasien_rincian_bill($no_ipd)
    {
        return $this->db->query("SELECT
                a.no_ipd,
                b.nama,
                b.no_cm,
                a.no_medrec,
                b.tgl_lahir,
                a.klsiri,
                b.sex,
                a.carabayar,
                a.dokter,
                a.id_dokter,
                a.tgl_keluar_resume,
                b.alamat,
                a.dokter,
                a.noregasal,
                a.id_kontraktor,
                a.selisih_tarif,
                (SELECT nmruang FROM ruang WHERE a.idrg = idrg LIMIT 1) AS ruang,
                (SELECT nmkontraktor FROM kontraktor WHERE a.id_kontraktor = id_kontraktor LIMIT 1) AS nmkontraktor,
                (SELECT tarif_kls1_inacbg FROM no_kwitansi WHERE no_register = a.no_ipd LIMIT 1) AS inacbg,
                a.titip
            FROM
                pasien_iri AS a,
                data_pasien AS b
            WHERE 
                a.no_medrec = b.no_medrec
                AND a.no_ipd = '$no_ipd'");
    }

    function get_ttd_dpjp($id_dokter)
    {
        return $this->db->query("SELECT 
                a.ttd, c.nm_dokter 
            FROM 
                hmis_users AS a, 
                dyn_user_dokter AS b,
                data_dokter AS c
            WHERE 
                a.userid = b.userid 
                AND b.id_dokter = c.id_dokter
                AND b.id_dokter = '$id_dokter'");
    }

    function get_rincian_lab_pasien($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT A
                .id_tindakan,
                -- a.no_register,
                A.jenis_tindakan,
                y.klsiri,
                y.jatahklsiri,
                y.titip,
                x.tarif_iks,
                x.total_tarif AS tarif_jatah,
                y.carabayar,
                SUM ( A.qty ) AS qtx,
                SUM ( A.vtot ) AS total_rekap,
                A.biaya_lab,
                a.nm_dokter
            FROM
                pemeriksaan_laboratorium AS A,
                tarif_tindakan AS x,
                pasien_iri AS y 
            WHERE
                x.kelas = y.jatahklsiri 
                AND A.id_tindakan = x.id_tindakan 
                AND (A.no_register = y.no_ipd OR a.no_register = y.noregasal)
                AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal') 
                AND A.no_lab IS NOT NULL 
            GROUP BY
                A.id_tindakan,
                A.jenis_tindakan,
                y.klsiri,
                y.jatahklsiri,
                y.titip,
                x.tarif_iks,
                tarif_jatah,
                y.carabayar,
                A.biaya_lab,
                -- a.no_register,
                a.nm_dokter");
    }

    function get_rincian_em_pasien($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT A
                .id_tindakan,
                A.jenis_tindakan,
                y.klsiri,
                y.jatahklsiri,
                y.titip,
                x.tarif_iks,
                x.total_tarif AS tarif_jatah,
                y.carabayar,
                SUM ( A.qty ) AS qtx,
                SUM ( A.vtot ) AS total_rekap,
                A.biaya_em,
                a.nm_dokter
            FROM
                pemeriksaan_elektromedik AS A,
                tarif_tindakan AS x,
                pasien_iri AS y 
            WHERE
                x.kelas = y.jatahklsiri 
                AND A.id_tindakan = x.id_tindakan 
                AND (A.no_register = y.no_ipd OR a.no_register = y.noregasal)
                AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal') 
                AND A.no_em IS NOT NULL 
            GROUP BY
                A.id_tindakan,
                A.jenis_tindakan,
                y.klsiri,
                y.jatahklsiri,
                y.titip,
                x.tarif_iks,
                tarif_jatah,
                y.carabayar,
                A.biaya_em,
                a.nm_dokter");
    }

    function get_rincian_ok_pasien($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT A
                .id_tindakan,
                A.jenis_tindakan,
                y.klsiri,
                y.jatahklsiri,
                y.titip,
                x.tarif_iks,
                x.total_tarif AS tarif_jatah,
                y.carabayar,
                SUM ( A.qty ) AS qtx,
                SUM ( A.vtot ) AS total_rekap,
                A.biaya_ok,
                b.nm_dokter
            FROM
                pemeriksaan_operasi AS A,
                tarif_tindakan AS x,
                pasien_iri AS y ,
                data_dokter AS b
            WHERE
                x.kelas = y.jatahklsiri 
                AND A.id_tindakan = x.id_tindakan 
                AND (A.no_register = y.no_ipd OR a.no_register = y.noregasal) 
                AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal')
                AND A.no_ok IS NOT NULL 
                AND a.id_dokter = b.id_dokter
            GROUP BY
                A.id_tindakan,
                A.jenis_tindakan,
                y.klsiri,
                y.jatahklsiri,
                y.titip,
                x.tarif_iks,
                tarif_jatah,
                y.carabayar,
                A.biaya_ok,
                b.nm_dokter");
    }

    function get_rincian_rad_pasien($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT A
                .id_tindakan,
                A.jenis_tindakan,
                y.klsiri,
                y.jatahklsiri,
                y.titip,
                x.tarif_iks,
                x.total_tarif AS tarif_jatah,
                y.carabayar,
                SUM ( A.qty ) AS qtx,
                SUM ( A.vtot ) AS total_rekap,
                A.biaya_rad,
                a.nm_dokter
            FROM
                pemeriksaan_radiologi AS A,
                tarif_tindakan AS x,
                pasien_iri AS y 
            WHERE
                x.kelas = y.jatahklsiri 
                AND A.id_tindakan = x.id_tindakan 
                AND (A.no_register = y.no_ipd OR a.no_register = y.noregasal)
                AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal') 
                AND A.no_rad IS NOT NULL 
            GROUP BY
                A.id_tindakan,
                A.jenis_tindakan,
                y.klsiri,
                y.jatahklsiri,
                y.titip,
                x.tarif_iks,
                tarif_jatah,
                y.carabayar,
                A.biaya_rad,
                a.nm_dokter");
    }

    function get_tind_gizi_pasien($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT 
                b.nmtindakan,
                a.tumuminap AS biaya,
                SUM(a.qtyyanri) AS qtx,
                SUM(a.vtot) AS total_rekap,
                (SELECT name FROM hmis_users WHERE min(a.idoprtr::INT) = userid LIMIT 1) AS pelaksana
            FROM
                pelayanan_iri AS a,
                jenis_tindakan AS b 
            WHERE 
                a.id_tindakan = b.idtindakan
                AND a.no_ipd = '$no_ipd' 
                AND a.id_tindakan IN ('BM0006','BM0007')
            GROUP BY b.nmtindakan, a.tumuminap UNION
            SELECT 
                a.nmtindakan,
                a.biaya_tindakan AS biaya,
                SUM(a.qtyind) AS qtx,
                SUM(a.vtot) AS total_rekap,
            ( SELECT NAME FROM hmis_users WHERE min(A.userid) = userid LIMIT 1 ) AS pelaksana
            FROM
                pelayanan_poli AS a
            WHERE 
                a.no_register = '$noregasal'
                AND a.idtindakan IN ('BM0006','BM0007')
            GROUP BY
                a.nmtindakan, a.biaya_tindakan");
    }

    function get_tind_igd_pasien($noregasal)
    {
        return $this->db->query("SELECT 
                a.idtindakan,
                a.nmtindakan,
                a.biaya_tindakan,
                SUM(a.qtyind) AS qtx,
                SUM(a.vtot) AS total_rekap,
                (SELECT name FROM hmis_users WHERE min(a.userid) = userid LIMIT 1) AS pelaksana
            FROM
                pelayanan_poli AS a,
                daftar_ulang_irj AS b
            WHERE
                a.no_register = '$noregasal'
                AND a.no_register = b.no_register
                AND substr(a.idtindakan,1,2) != 'BK'
                AND b.id_poli = 'BA00'
                AND a.idtindakan NOT IN ('BM0006','BM0007','1B0101','1B0104','1B0105')
            GROUP BY 
                a.idtindakan, a.nmtindakan, a.biaya_tindakan");
    }

    function get_tind_mr_pasien($noregasal)
    {
        return $this->db->query("SELECT 
                a.idtindakan,
                a.nmtindakan,
                a.biaya_tindakan,
                SUM(a.qtyind) AS qtx,
                SUM(a.vtot) AS total_rekap,
                (SELECT name FROM hmis_users WHERE min(a.userid) = userid LIMIT 1) AS pelaksana
            FROM
                pelayanan_poli AS a
            WHERE
                a.no_register = '$noregasal'
                AND a.idtindakan IN ('1B0101','1B0104','1B0105')
            GROUP BY 
                a.idtindakan, a.nmtindakan, a.biaya_tindakan");
    }

    function get_tind_irj_pasien($noregasal)
    {
        return $this->db->query("SELECT 
                a.idtindakan,
                a.nmtindakan,
                a.biaya_tindakan,
                SUM(a.qtyind) AS qtx,
                SUM(a.vtot) AS total_rekap,
                (SELECT name FROM hmis_users WHERE min(a.userid) = userid LIMIT 1) AS pelaksana
            FROM
                pelayanan_poli AS a,
                daftar_ulang_irj AS b
            WHERE
                a.no_register = '$noregasal'
                AND a.no_register = b.no_register
                AND substr(a.idtindakan,1,2) != 'BK'
                AND b.id_poli != 'BA00'
                AND a.idtindakan NOT IN ('BM0006','BM0007','1B0101','1B0104','1B0105')
            GROUP BY 
                a.idtindakan, a.nmtindakan, a.biaya_tindakan");
    }

    function get_tind_rehab_pasien($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT 
                b.nmtindakan,
                a.tumuminap AS biaya,
                SUM(a.qtyyanri) AS qtx,
                SUM(a.vtot) AS total_rekap,
                (SELECT name FROM hmis_users WHERE min(a.idoprtr::INT) = userid LIMIT 1) AS pelaksana
            FROM
                pelayanan_iri AS a,
                jenis_tindakan AS b 
            WHERE 
                a.id_tindakan = b.idtindakan
                AND a.no_ipd = '$no_ipd' 
                AND substr(a.id_tindakan,1,2) = 'BK'
            GROUP BY b.nmtindakan, a.tumuminap UNION
            SELECT 
                a.nmtindakan,
                a.biaya_tindakan AS biaya,
                SUM(a.qtyind) AS qtx,
                SUM(a.vtot) AS total_rekap,
            ( SELECT NAME FROM hmis_users WHERE min(A.userid) = userid LIMIT 1 ) AS pelaksana
            FROM
                pelayanan_poli AS a
            WHERE 
                a.no_register = '$noregasal'
                AND substr(a.idtindakan,1,2) = 'BK'
            GROUP BY
                a.nmtindakan, a.biaya_tindakan");
    }

    function get_resep_bill_pasien_new($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT dgu.nama_gudang, A.nama_obat,A.qty,A.biaya_obat,A.embalase,A.vtot from resep_pasien A
            join hmis_users on hmis_users.username = A.xuser 
            join dyn_gudang_user dgu on dgu.userid = hmis_users.userid
             where A.no_register = '$no_ipd'
            UNION ALL
            SELECT dgu.nama_gudang,A.nama_obat,A.qty,A.biaya_obat,A.embalase,A.vtot  from resep_pasien A 
            join hmis_users on hmis_users.username = A.xuser 
            join dyn_gudang_user dgu on dgu.userid = hmis_users.userid
            where A.no_register = '$noregasal'");
    }

    function get_resep_bill_pasien($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT A
                .id_inventory,
                A.nama_obat,
                a.biaya_obat,
                SUM ( A.qty ) AS qtx,
                SUM ( A.vtot ) AS total_rekap
            FROM
                resep_pasien AS A,
                pasien_iri AS y 
            WHERE
                ( A.no_register = y.no_ipd OR A.no_register = y.noregasal ) 
                AND ( A.no_register = '$no_ipd' OR A.no_register = '$noregasal' ) 
            GROUP BY
                a.id_inventory, a.nama_obat, a.biaya_obat");
    }

    function get_ruang_intensif_bill_pasien($no_ipd)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                (
                SELECT
                    x.total_tarif
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah,
                C.tarif_bpjs,
                (
                SELECT
                    x.tarif_bpjs
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah_bpjs,
                C.tarif_iks,
                (
                SELECT
                    x.tarif_iks
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah_iks
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C 
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND a.idrg IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304')
                AND A.no_ipd = '$no_ipd'");

        return $data->result_array();
    }

    function get_ruang_non_intensif_bill_pasien($no_ipd)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                (
                SELECT
                    x.total_tarif
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah,
                C.tarif_bpjs,
                (
                SELECT
                    x.tarif_bpjs
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah_bpjs,
                C.tarif_iks,
                (
                SELECT
                    x.total_tarif
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y
                WHERE
                    a.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', a.idrg ) 
                    AND x.kelas = y.jatahklsiri
                    AND y.no_ipd = a.no_ipd 
                    AND a.no_ipd = '$no_ipd' LIMIT 1
                ) AS tarif_jatah_iks
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C 
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND a.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304')
                AND A.no_ipd = '$no_ipd'");

        return $data->result_array();
    }

    function get_tind_iri_pasien($no_ipd)
    {
        return $this->db->query("SELECT 
                a.id_tindakan,
                b.nmtindakan,
                a.tumuminap,
                SUM(a.qtyyanri) AS qtx,
                SUM(a.vtot) AS total_rekap,
                (SELECT name FROM hmis_users WHERE min(CAST(a.idoprtr AS INT)) = userid LIMIT 1) AS pelaksana
            FROM
                pelayanan_iri AS a,
                jenis_tindakan AS b
            WHERE
                a.no_ipd = '$no_ipd'
                AND a.id_tindakan = b.idtindakan
                AND substr(a.id_tindakan,1,2) != 'BK'
                AND a.id_tindakan NOT IN ('BM0006','BM0007','1B0101','1B0104','1B0105')
            GROUP BY 
                a.id_tindakan, b.nmtindakan, a.tumuminap");
    }

    function get_pendapatan_perhari($date1, $date2)
    {
        return $this->db->query("SELECT
                tgl,
                SUM ( igd ) AS tot_igd,
                SUM ( ok_igd ) AS tot_ok_igd,
                SUM ( ok_iri ) AS tot_ok_iri,
                SUM ( lab_igd ) AS tot_lab_igd,
                SUM ( lab_iri ) AS tot_lab_iri,
                SUM ( resep_igd ) AS tot_resep_igd,
                SUM ( resep_iri ) AS tot_resep_iri,
                SUM ( gizi_igd ) AS tot_gizi_igd,
                SUM ( gizi_iri ) AS tot_gizi_iri,
                SUM ( mr ) AS tot_mr,
                SUM (rad_igd) AS tot_rad_igd,
                SUM (rad_iri) AS tot_rad_iri,
                SUM ( irj ) AS tot_irj,
                SUM ( rehab_igd ) AS tot_rehab_igd,
                SUM ( rehab_iri ) AS tot_rehab_iri,
                SUM ( iri ) AS tot_iri
            FROM
                lap_pendapatan_pasien_pulang_m 
            WHERE
                to_char( tgl, 'YYYY-MM-DD' ) BETWEEN '$date1' AND '$date2'  
                -- AND carabayar IN ('UMUM','KERJASAMA') 
            GROUP BY
                tgl
            ORDER BY 
                tgl ASC");
    }

    function get_pendapatan_perhari_bpjs($date)
    {
        // return $this->db->query("SELECT 
        //     A.tgl_keluar_resume,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.id_tindakan IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) AND A.ins = 'akomodasi') AS ruang_intensif,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.ins = 'tind_igd' AND A.id_tindakan NOT IN ( 'BM0006', 'BM0007', '1B0101', '1B0105', '1B0104' ) AND substr( A.id_tindakan, 1, 2 ) != 'BK') AS igd,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.ins = 'ok') AS ok,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.kel_tindakan = 'Farmasi') AS resep,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.id_tindakan IN ('BM0006','BM0007')) AS gizi,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.ins = 'lab') AS lab,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.ins = 'rad') AS rad,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.id_tindakan IN ('1B0101','1B0105','1B0104')) AS mr,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.ins = 'tind_iri' AND A.id_tindakan NOT IN ( 'BM0006', 'BM0007', '1B0101', '1B0105', '1B0104' ) AND substr( A.id_tindakan, 1, 2 ) != 'BK') AS iri,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.id_tindakan NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) AND A.ins = 'akomodasi') AS ruang,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE A.ins = 'tind_irj' AND A.id_tindakan NOT IN ( 'BM0006', 'BM0007', '1B0101', '1B0105', '1B0104' ) AND substr( A.id_tindakan, 1, 2 ) != 'BK') AS irj,
        //     SUM (CAST(A.vtot AS FLOAT)) FILTER (WHERE substr( A.id_tindakan, 1, 2 ) = 'BK') AS rehab 
        // FROM
        //     realisasi_tindakan AS A
        // WHERE
        //     A.ins IS NOT NULL 
        //     AND to_char( A.tgl_keluar_resume, 'YYYY-MM-DD' ) BETWEEN '$date1' 
        //     AND '$date2'
        //     AND a.carabayar = '$carabayar'
        // GROUP BY
        //     A.tgl_keluar_resume");
        $month = explode("-", $date)[1];
        $tahun = explode("-", $date)[0];
        return $this->db->query("SELECT 
                A.tgl_verif :: DATE AS tgl_keluar_resume,
                SUM(COALESCE((SELECT vtot FROM total_ok_iri WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT vtot FROM total_ok_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT total_ok_irj_non_rujuk.vtot FROM total_ok_irj_non_rujuk, pasien_iri WHERE pasien_iri.noregasal = total_ok_irj_non_rujuk.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1), 0)) AS ok,
                SUM(COALESCE((SELECT vtot FROM gizi_iri WHERE b.no_register = no_ipd LIMIT 1), 0)) + SUM(COALESCE((SELECT vtot FROM gizi_irj WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT gizi_irj.vtot FROM gizi_irj, pasien_iri WHERE pasien_iri.noregasal = gizi_irj.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1), 0)) AS gizi,
                SUM(COALESCE((SELECT vtot FROM total_lab_iri WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT vtot FROM total_lab_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT total_lab_irj_non_rujuk.vtot FROM total_lab_irj_non_rujuk, pasien_iri WHERE pasien_iri.noregasal = total_lab_irj_non_rujuk.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1), 0)) AS lab,
                SUM(COALESCE((SELECT vtot FROM mrm WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT mrm.vtot FROM mrm, pasien_iri WHERE pasien_iri.noregasal = mrm.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1), 0)) AS mr,
                SUM(COALESCE((SELECT vtot FROM total_rad_iri WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT vtot FROM total_rad_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT total_rad_irj_non_rujuk.vtot FROM total_rad_irj_non_rujuk, pasien_iri WHERE pasien_iri.noregasal = total_rad_irj_non_rujuk.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1), 0)) AS rad,
                SUM(COALESCE((SELECT vtot FROM total_em_iri WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT vtot FROM total_em_irj_non_rujuk WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT total_em_irj_non_rujuk.vtot FROM total_em_irj_non_rujuk, pasien_iri WHERE pasien_iri.noregasal = total_em_irj_non_rujuk.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1), 0)) AS em,
                SUM(COALESCE((SELECT vtot FROM tindakan_iri WHERE b.no_register = no_ipd LIMIT 1), 0)) AS iri,
                SUM(COALESCE((SELECT vtot FROM tindakan_irj WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT tindakan_irj.vtot FROM tindakan_irj, pasien_iri WHERE pasien_iri.noregasal = tindakan_irj.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1), 0)) AS irj,
                SUM(COALESCE((SELECT vtot FROM tindakan_igd WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT tindakan_igd.vtot FROM tindakan_igd, pasien_iri WHERE pasien_iri.noregasal = tindakan_igd.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1), 0)) AS igd,
                SUM(COALESCE((SELECT vtot FROM rehab_iri WHERE b.no_register = no_ipd LIMIT 1), 0)) + SUM(COALESCE((SELECT vtot FROM rehab_irj WHERE b.no_register = no_register LIMIT 1), 0)) + SUM(COALESCE((SELECT rehab_irj.vtot FROM rehab_irj, pasien_iri WHERE pasien_iri.noregasal = rehab_irj.no_register AND pasien_iri.no_ipd = b.no_register LIMIT 1), 0)) AS rehab
            FROM
                umbal_pasien
                AS A LEFT OUTER JOIN bpjs_sep AS b ON A.no_sep = b.no_sep 
            WHERE
                A.bln_klaim = '$month' 
                AND A.tahun = '$tahun'
            GROUP BY 
                tgl_keluar_resume");
    }

    function get_pendapatan_perhari_bpjs_new($date1, $date2)
    {
        return $this->db->query("SELECT 
                tgl_keluar_resume,
                SUM(ok) AS ok,
                SUM(gizi) AS gizi,
                SUM(lab) AS lab,
                SUM(mr) AS mr,
                SUM(rad) AS rad,
                SUM(em) AS em,
                SUM(iri) AS iri,
                SUM(irj) AS irj,
                SUM(igd) AS igd,
                SUM(rehab) AS rehab
                -- (SELECT SUM(tarif_bpjs * diff) FROM akomodasi_realisasi WHERE a.tgl = to_char(tgl_cetak, 'YYYY-MM-DD') AND carabayar = 'BPJS' AND selisih_tarif = 1 AND idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)
            FROM
                pendapatan_perhari_bpjs
            WHERE
                to_char(tgl_keluar_resume, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
            GROUP BY 
                tgl_keluar_resume");
    }

    function get_pendapatan_perhari_umum($date1, $date2, $jaminan)
    {
        // return $this->db->query("SELECT 
        //     tgl AS tgl_keluar_resume,
        //     0 AS ruang_intensif,
        //     SUM(igd) AS igd,
        //     SUM(COALESCE(ok_iri, 0)) + SUM(COALESCE(ok_igd, 0)) AS ok,
        //     SUM(COALESCE(resep_iri, 0)) + SUM(COALESCE(resep_igd, 0)) AS resep,
        //     SUM(COALESCE(gizi_iri, 0)) + SUM(COALESCE(gizi_igd, 0)) AS gizi,
        //     SUM(COALESCE(lab_iri, 0)) + SUM(COALESCE(lab_igd, 0)) AS lab,
        //     SUM(COALESCE(rad_iri, 0)) + SUM(COALESCE(rad_igd, 0)) AS rad,
        //     SUM(mr) AS mr,
        //     SUM(iri) AS iri,
        //     0 AS ruang,
        //     SUM(irj) AS irj,
        //     SUM(COALESCE(rehab_iri, 0)) + SUM(COALESCE(rehab_igd, 0)) AS rehab
        // FROM 
        //     lap_pendapatan_pasien_pulang_m
        // WHERE 
        //     carabayar = 'UMUM'
        //     AND to_char(tgl,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
        // GROUP BY 
        //     tgl");
        if ($jaminan == 'selisih_tarif') {
            $carabayar = 'BPJS';
            $akom = "(SELECT SUM(tarif_bpjs * diff) FROM akomodasi_realisasi WHERE a.tgl = to_char(tgl_cetak, 'YYYY-MM-DD') AND carabayar = 'BPJS' AND selisih_tarif = 1 AND idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
            $intensif = "(SELECT SUM(tarif_bpjs * diff) FROM akomodasi_realisasi WHERE a.tgl = to_char(tgl_cetak, 'YYYY-MM-DD') AND carabayar = 'BPJS' AND selisih_tarif = 1 AND idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
        } else {
            if ($jaminan == 'UMUM') {
                $intensif = "(SELECT SUM(total_tarif * diff) FROM akomodasi_realisasi WHERE a.tgl = to_char(tgl_cetak, 'YYYY-MM-DD') AND carabayar = 'UMUM' AND idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
                $akom = "(SELECT SUM(total_tarif * diff) FROM akomodasi_realisasi WHERE a.tgl = to_char(tgl_cetak, 'YYYY-MM-DD') AND carabayar = 'UMUM' AND idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
            } else {
                $akom = "(SELECT SUM(tarif_iks * diff) FROM akomodasi_realisasi WHERE a.tgl = to_char(tgl_cetak, 'YYYY-MM-DD') AND carabayar = 'KERJASAMA' AND selisih_tarif = 1  AND idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
                $intensif = "(SELECT SUM(tarif_iks * diff) FROM akomodasi_realisasi WHERE a.tgl = to_char(tgl_cetak, 'YYYY-MM-DD') AND carabayar = 'KERJASAMA' AND selisih_tarif = 1  AND idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) LIMIT 1)";
            }
            $carabayar = $jaminan;
        }
        return $this->db->query("SELECT
                tgl,
                SUM ( A.igd :: INT ) AS igd,
                SUM ( A.ok :: INT ) AS ok,
                SUM ( A.gizi_igd :: INT ) AS gizi_igd, 
                SUM ( A.gizi_irj :: INT ) AS gizi_irj, 
                SUM ( A.lab :: INT ) AS lab,
                SUM ( A.mr :: INT ) AS mr,
                SUM ( A.rad :: INT ) AS rad,
                SUM ( A.em :: INT ) AS em,
                SUM (a.iri) AS iri,
                SUM ( A.rehab_igd :: INT ) AS rehab_igd,
                SUM ( A.rehab_irj :: INT ) AS rehab_irj,
                SUM ( A.irj :: INT ) AS irj,
                SUM(a.farmasi::INT) AS farmasi,
                SUM(a.non_pasien) AS non_pasien,
                $akom AS ruang,
                $intensif AS intensif
            FROM
                pendapatan_perhari AS A 
            WHERE
                tgl BETWEEN '$date1' AND '$date2' 
                AND A.cara_bayar = '$carabayar' 
            GROUP BY
                tgl ");
    }

    function get_pendapatan_perhari_selisih_tarif($date1, $date2)
    {
        return $this->db->query("SELECT 
                tgl AS tgl_keluar_resume,
                0 AS ruang_intensif,
                SUM(igd) AS igd,
                SUM(COALESCE(ok_iri, 0)) + SUM(COALESCE(ok_igd, 0)) AS ok,
                SUM(COALESCE(resep_iri, 0)) + SUM(COALESCE(resep_igd, 0)) AS resep,
                SUM(COALESCE(gizi_iri, 0)) + SUM(COALESCE(gizi_igd, 0)) AS gizi,
                SUM(COALESCE(lab_iri, 0)) + SUM(COALESCE(lab_igd, 0)) AS lab,
                SUM(COALESCE(rad_iri, 0)) + SUM(COALESCE(rad_igd, 0)) AS rad,
                SUM(mr) AS mr,
                SUM(iri) AS iri,
                0 AS ruang,
                SUM(irj) AS irj,
                SUM(COALESCE(rehab_iri, 0)) + SUM(COALESCE(rehab_igd, 0)) AS rehab
            FROM 
                lap_pendapatan_pasien_pulang_m
            WHERE 
                selisih_tarif = '1'
                AND to_char(tgl,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
            GROUP BY 
                tgl");
    }

    function get_pendapatan_perhari_gabungan($date1)
    {
        return $this->db->query("SELECT 
                A.tgl_keluar_resume,
                SUM (A.ruang_intensif) AS ruang_intensif,
                SUM (A.igd) AS igd,
                SUM (A.ok) AS ok,
                SUM (A.resep) AS resep,
                SUM (A.gizi) AS gizi,
                SUM (A.lab) AS lab,
                SUM (A.rad) AS rad,
                SUM (A.mr) AS mr,
                SUM (A.iri) AS iri,
                SUM (A.ruang) AS ruang,
                SUM (a.irj) AS irj,
                SUM (A.rehab) AS rehab 
            FROM
                lap_pendapatan_perhari_gabungan AS A
            WHERE 
                to_char( A.tgl_keluar_resume, 'YYYY-MM' ) = '$date1'
            GROUP BY
                A.tgl_keluar_resume");
    }

    function get_ruang_intensif_pendapatan_perhari($date)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                (
                SELECT
                    x.total_tarif 
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y 
                WHERE
                    A.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', A.idrg ) 
                    AND x.kelas = y.jatahklsiri 
                    AND y.no_ipd = A.no_ipd  
                    LIMIT 1 
                ) AS tarif_jatah,
                d.tgl_keluar_resume
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND A.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) 
                AND A.no_ipd = d.no_ipd
                AND (d.carabayar = 'UMUM' OR (d.carabayar = 'BPJS' AND d.selisih_tarif = '1'))
                AND to_char(d.tgl_keluar_resume,'YYYY-MM-DD') = '$date'
                AND d.cetak_kwitansi = '1'");

        return $data->result_array();
    }

    function get_ruang_intensif_pendapatan_perhari_umum($date)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                (
                SELECT
                    x.total_tarif 
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y 
                WHERE
                    A.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', A.idrg ) 
                    AND x.kelas = y.jatahklsiri 
                    AND y.no_ipd = A.no_ipd  
                    LIMIT 1 
                ) AS tarif_jatah,
                d.tgl_keluar_resume
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND A.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) 
                AND A.no_ipd = d.no_ipd
                AND to_char(d.tgl_keluar_resume,'YYYY-MM-DD') = '$date'
                AND d.cetak_kwitansi = '1'");

        return $data->result_array();
    }

    function get_ruang_intensif_pendapatan_perhari_selisih_tarif($date)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                (
                SELECT
                    x.total_tarif 
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y 
                WHERE
                    A.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', A.idrg ) 
                    AND x.kelas = y.jatahklsiri 
                    AND y.no_ipd = A.no_ipd  
                    LIMIT 1 
                ) AS tarif_jatah,
                d.tgl_keluar_resume
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND A.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) 
                AND A.no_ipd = d.no_ipd
                AND d.carabayar = 'BPJS' AND d.selisih_tarif = '1'
                AND to_char(d.tgl_keluar_resume,'YYYY-MM-DD') = '$date'
                AND d.cetak_kwitansi = '1'");

        return $data->result_array();
    }

    function get_ruang_non_intensif_pendapatan_perhari($date)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                (
                SELECT
                    x.total_tarif 
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y 
                WHERE
                    A.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', A.idrg ) 
                    AND x.kelas = y.jatahklsiri 
                    AND y.no_ipd = A.no_ipd  
                    LIMIT 1 
                ) AS tarif_jatah,
                d.tgl_keluar_resume
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) 
                AND A.no_ipd = d.no_ipd
                AND (d.carabayar = 'UMUM' OR (d.carabayar = 'BPJS' AND d.selisih_tarif = '1'))
                AND to_char(d.tgl_keluar_resume,'YYYY-MM-DD') = '$date'
                AND d.cetak_kwitansi = '1'");

        return $data->result_array();
    }

    function get_ruang_non_intensif_pendapatan_perhari_umum($date)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                (
                SELECT
                    x.total_tarif 
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y 
                WHERE
                    A.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', A.idrg ) 
                    AND x.kelas = y.jatahklsiri 
                    AND y.no_ipd = A.no_ipd  
                    LIMIT 1 
                ) AS tarif_jatah,
                d.tgl_keluar_resume
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d,
                no_kwitansi AS e
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) 
                AND A.no_ipd = d.no_ipd
                -- AND d.carabayar = 'UMUM'
                AND d.no_ipd = e.no_register
                AND to_char(e.tgl_cetak,'YYYY-MM-DD') = '$date'
                AND d.cetak_kwitansi = '1'");

        return $data->result_array();
    }

    function get_ruang_non_intensif_pendapatan_perhari_selisih_tarif($date)
    {
        $data = $this->db->query("SELECT DISTINCT A
                .*,
                b.nmruang,
                C.total_tarif,
                (
                SELECT
                    x.total_tarif 
                FROM
                    tarif_tindakan AS x,
                    pasien_iri AS y 
                WHERE
                    A.idrg = b.idrg 
                    AND x.id_tindakan = concat ( '1A', A.idrg ) 
                    AND x.kelas = y.jatahklsiri 
                    AND y.no_ipd = A.no_ipd  
                    LIMIT 1 
                ) AS tarif_jatah,
                d.tgl_keluar_resume
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304' ) 
                AND A.no_ipd = d.no_ipd
                AND d.carabayar = 'BPJS' AND d.selisih_tarif = '1'
                AND to_char(d.tgl_keluar_resume,'YYYY-MM-DD') = '$date'
                AND d.cetak_kwitansi = '1'");

        return $data->result_array();
    }

    function get_lap_realisasi_tindakan($tgl)
    {
        return $this->db->query("SELECT a.*
            FROM
                lap_pendapatan_pasien_pulang AS a,
                kontraktor AS b
            WHERE 
                to_char(a.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
                AND a.id_kontraktor = b.id_kontraktor");
    }

    function get_realisasi_tindakan_lab($tgl)
    {
        return $this->db->query("SELECT
                A.id_tindakan,
                A.jenis_tindakan,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'BPJS') AS total_rekap_bpjs,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'UMUM') AS total_rekap_umum,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'KERJASAMA' AND y.id_kontraktor = '67') AS total_rekap_iks_pln,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'KERJASAMA' AND (y.id_kontraktor != '67' OR y.id_kontraktor IS NULL)) AS total_rekap_iks,
                'Penujang Medik' AS kel_tindakan,
                'Laboratorium' AS kategori,
                'Per Pemeriksaan' AS satuan,
                (SELECT nama_jenis FROM jenis_lab WHERE kode_jenis = substr(a.id_tindakan,1,2) LIMIT 1) AS nama_jenis
            FROM
                pemeriksaan_laboratorium AS A,
                pasien_iri AS y
            WHERE
                ( A.no_register = y.no_ipd OR A.no_register = y.noregasal ) 
                AND to_char(y.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
                AND y.cetak_kwitansi = '1'
                AND A.no_lab IS NOT NULL 
            GROUP BY
                A.id_tindakan,
                A.jenis_tindakan");
    }

    function get_realisasi_tindakan_rad($tgl)
    {
        return $this->db->query("SELECT
                A.id_tindakan,
                A.jenis_tindakan,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'BPJS') AS total_rekap_bpjs,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'UMUM') AS total_rekap_umum,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'KERJASAMA' AND y.id_kontraktor = '67') AS total_rekap_iks_pln,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'KERJASAMA' AND (y.id_kontraktor != '67' OR y.id_kontraktor IS NULL)) AS total_rekap_iks,
                'Penujang Medik' AS kel_tindakan,
                'Radiologi' AS kategori,
                'Per Pemeriksaan' AS satuan,
                (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS sub_kelompok
            FROM
                pemeriksaan_radiologi AS A,
                pasien_iri AS y
            WHERE
                ( A.no_register = y.no_ipd OR A.no_register = y.noregasal ) 
                AND to_char(y.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
                AND y.cetak_kwitansi = '1'
                AND A.no_rad IS NOT NULL 
            GROUP BY
                A.id_tindakan,
                A.jenis_tindakan");
    }

    function get_realisasi_tindakan_ok($tgl)
    {
        return $this->db->query("SELECT
                A.id_tindakan,
                A.jenis_tindakan,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'BPJS') AS total_rekap_bpjs,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'UMUM') AS total_rekap_umum,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'KERJASAMA' AND y.id_kontraktor = '67') AS total_rekap_iks_pln,
                SUM ( A.vtot ) FILTER (WHERE y.carabayar = 'KERJASAMA' AND (y.id_kontraktor != '67' OR y.id_kontraktor IS NULL)) AS total_rekap_iks,
                (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS kel_tindakan,
                (SELECT kategori FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS kategori,
                (SELECT satuan FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS satuan,
                (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS sub_kelompok
            FROM
                pemeriksaan_operasi AS A,
                pasien_iri AS y
            WHERE
                ( A.no_register = y.no_ipd OR A.no_register = y.noregasal ) 
                AND to_char(y.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
                AND y.cetak_kwitansi = '1'
                AND A.no_ok IS NOT NULL 
            GROUP BY
                A.id_tindakan,
                A.jenis_tindakan");
    }

    function get_realisasi_tindakan_igd($tgl)
    {
        return $this->db->query("SELECT
                a.nmtindakan,
                a.idtindakan,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'BPJS') AS total_bpjs,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'UMUM') AS total_umum,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND b.id_kontraktor = '67') AS total_iks_pln,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND (b.id_kontraktor != '67' OR b.id_kontraktor IS NULL)) AS total_iks,
                (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kel_tindakan,
                (SELECT kategori FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kategori,
                (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS sub_kelompok,
                (SELECT satuan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS satuan
            FROM
                pelayanan_poli AS A,
                pasien_iri AS b 
            WHERE
                A.no_register = b.noregasal 
                AND substr( A.idtindakan, 1, 2 ) != 'BK' 
                AND A.id_poli = 'BA00' 
                AND A.idtindakan NOT IN ('BM0006','BM0007','1B0101','1B0104','1B0105')
                AND to_char(b.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
                AND b.cetak_kwitansi = '1'
            GROUP BY 
                a.nmtindakan, a.idtindakan");
    }

    function get_realisasi_tindakan_irj($tgl)
    {
        return $this->db->query("SELECT
                a.nmtindakan,
                a.idtindakan,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'BPJS') AS total_bpjs,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'UMUM') AS total_umum,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND b.id_kontraktor = '67') AS total_iks_pln,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND (b.id_kontraktor != '67' OR b.id_kontraktor IS NULL)) AS total_iks,
                (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kel_tindakan,
                (SELECT kategori FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kategori,
                (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS sub_kelompok,
                (SELECT satuan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS satuan
            FROM
                pelayanan_poli AS A,
                pasien_iri AS b 
            WHERE
                A.no_register = b.noregasal 
                AND substr( A.idtindakan, 1, 2 ) != 'BK' 
                AND A.id_poli != 'BA00' 
                AND A.idtindakan NOT IN ('BM0006','BM0007','1B0101','1B0104','1B0105')
                AND to_char(b.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
                AND b.cetak_kwitansi = '1'
            GROUP BY 
                a.nmtindakan, a.idtindakan");
    }

    function get_realisasi_tindakan_rehab($tgl)
    {
        return $this->db->query("SELECT
                a.nmtindakan,
                a.idtindakan,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'BPJS') AS total_bpjs,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'UMUM') AS total_umum,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND b.id_kontraktor = '67') AS total_iks_pln,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND (b.id_kontraktor != '67' OR b.id_kontraktor IS NULL)) AS total_iks,
                (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kel_tindakan,
                (SELECT kategori FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kategori,
                (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS sub_kelompok,
                (SELECT satuan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS satuan
            FROM
                pelayanan_poli AS A,
                pasien_iri AS b 
            WHERE
                A.no_register = b.noregasal 
                AND substr( A.idtindakan, 1, 2 ) = 'BK' 
                AND to_char(b.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
            AND b.cetak_kwitansi = '1'
            GROUP BY 
                a.nmtindakan, a.idtindakan UNION
            SELECT
                c.nmtindakan,
                a.id_tindakan,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'BPJS') AS total_bpjs,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'UMUM') AS total_umum,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND b.id_kontraktor = '67') AS total_iks_pln,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND (b.id_kontraktor != '67' OR b.id_kontraktor IS NULL)) AS total_iks,
                (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS kel_tindakan,
                (SELECT kategori FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS kategori,
                (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS sub_kelompok,
                (SELECT satuan FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS satuan
            FROM
                pelayanan_iri AS A,
                pasien_iri AS b,
                jenis_tindakan AS c
            WHERE
                A.no_ipd = b.no_ipd 
                AND a.id_tindakan = c.idtindakan
                AND substr( A.id_tindakan, 1, 2 ) = 'BK' 
                AND to_char(b.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
                AND b.cetak_kwitansi = '1'
            GROUP BY 
                c.nmtindakan, a.id_tindakan");
    }

    function get_realisasi_tindakan_gizi($tgl)
    {
        return $this->db->query("SELECT
                a.nmtindakan,
                a.idtindakan,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'BPJS') AS total_bpjs,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'UMUM') AS total_umum,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND b.id_kontraktor = '67') AS total_iks_pln,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND (b.id_kontraktor != '67' OR b.id_kontraktor IS NULL)) AS total_iks,
                (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kel_tindakan,
                (SELECT kategori FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kategori,
                (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS sub_kelompok,
                (SELECT satuan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS satuan
            FROM
                pelayanan_poli AS A,
                pasien_iri AS b 
            WHERE
                A.no_register = b.noregasal 
                AND a.idtindakan IN ('BM0006','BM0007')
                AND to_char(b.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
            AND b.cetak_kwitansi = '1'
            GROUP BY 
                a.nmtindakan, a.idtindakan UNION
            SELECT
                c.nmtindakan,
                a.id_tindakan,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'BPJS') AS total_bpjs,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'UMUM') AS total_umum,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND b.id_kontraktor = '67') AS total_iks_pln,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND (b.id_kontraktor != '67' OR b.id_kontraktor IS NULL)) AS total_iks,
                (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS kel_tindakan,
                (SELECT kategori FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS kategori,
                (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS sub_kelompok,
                (SELECT satuan FROM jenis_tindakan WHERE idtindakan = a.id_tindakan LIMIT 1) AS satuan
            FROM
                pelayanan_iri AS A,
                pasien_iri AS b,
                jenis_tindakan AS c
            WHERE
                A.no_ipd = b.no_ipd 
                AND a.id_tindakan = c.idtindakan
                AND a.id_tindakan IN ('BM0006','BM0007')
                AND to_char(b.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
                AND b.cetak_kwitansi = '1'
            GROUP BY 
                c.nmtindakan, a.id_tindakan");
    }

    function get_realisasi_tindakan_mr($tgl)
    {
        return $this->db->query("SELECT 
                a.idtindakan,
                a.nmtindakan,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'BPJS') AS total_bpjs,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'UMUM') AS total_umum,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND b.id_kontraktor = '67') AS total_iks_pln,
                SUM(a.vtot) FILTER(WHERE b.carabayar = 'KERJASAMA' AND (b.id_kontraktor != '67' OR b.id_kontraktor IS NULL)) AS total_iks,
                (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kel_tindakan,
                (SELECT kategori FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS kategori,
                (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS sub_kelompok,
                (SELECT satuan FROM jenis_tindakan WHERE idtindakan = a.idtindakan LIMIT 1) AS satuan
            FROM
                pelayanan_poli AS a,
                pasien_iri AS b
            WHERE
                a.no_register = b.noregasal
                AND a.idtindakan IN ('1B0101','1B0104','1B0105')
                AND to_char(b.tgl_keluar_resume,'YYYY-MM-DD') = '$tgl'
                AND b.cetak_kwitansi = '1'
            GROUP BY 
                a.idtindakan, a.nmtindakan");
    }

    function get_realisasi_tindakan_iri($tgl)
    {
        return $this->db->query("SELECT c
                .nmtindakan,
                A.id_tindakan,
                SUM ( A.vtot ) FILTER ( WHERE b.carabayar = 'BPJS' ) AS total_bpjs,
                SUM ( A.vtot ) FILTER ( WHERE b.carabayar = 'UMUM' ) AS total_umum,
                SUM ( A.vtot ) FILTER ( WHERE b.carabayar = 'KERJASAMA' AND b.id_kontraktor = '67' ) AS total_iks_pln,
                SUM ( A.vtot ) FILTER ( WHERE b.carabayar = 'KERJASAMA' AND ( b.id_kontraktor != '67' OR b.id_kontraktor IS NULL ) ) AS total_iks,
                ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
                ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
                ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
                ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan 
            FROM
                pelayanan_iri AS A,
                pasien_iri AS b,
                jenis_tindakan AS c
            WHERE
                A.no_ipd = b.no_ipd 
                AND substr( A.id_tindakan, 1, 2 ) != 'BK' 
                AND a.id_tindakan = c.idtindakan
                AND A.id_tindakan NOT IN ( 'BM0006', 'BM0007', '1B0101', '1B0104', '1B0105' ) 
                AND to_char( b.tgl_keluar_resume, 'YYYY-MM-DD' ) = '$tgl' 
                AND b.cetak_kwitansi = '1' 
            GROUP BY
                c.nmtindakan,
                A.id_tindakan");
    }

    function get_realisasi_tindakan_ruang($tgl)
    {
        return $this->db->query("SELECT
                a.idrg,
                a.kelas,
                a.tglmasukrg,
                a.tglkeluarrg,
                b.nmruang,
                c.total_tarif,
                d.titip,
                d.tgl_keluar_resume,
                d.carabayar,
                CASE 
                    WHEN(a.kelas = 'VIP' AND A.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304','0405','0107') AND b.nmruang NOT LIKE '%Isolasi%') THEN 'VIP'
                    WHEN(a.kelas = 'I' AND A.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304','0405','0107') AND b.nmruang NOT LIKE '%Isolasi%') THEN 'Kelas I'
                    WHEN(a.kelas = 'II' AND A.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304','0405','0107') AND b.nmruang NOT LIKE '%Isolasi%') THEN 'Kelas II'
                    WHEN(a.kelas = 'III' AND A.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304','0405','0107') AND b.nmruang NOT LIKE '%Isolasi%') THEN 'Kelas III'
                    WHEN(A.idrg IN ('0404','0704','0304')) THEN 'ICU'
                    WHEN(A.idrg IN ('0106','0604','0706','0804','0805','0504')) THEN 'HCU'
                    WHEN(b.nmruang LIKE '%Isolasi%') THEN 'Ruang Isolasi'
                    WHEN(A.idrg = '0107') THEN 'Terminal Care'
                    WHEN(A.idrg = '0405') THEN 'Akomodasi Bayi'
                END AS tindakan
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d 
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND A.no_ipd = d.no_ipd 
                AND to_char( d.tgl_keluar_resume, 'YYYY-MM-DD' ) = '$tgl' 
                AND d.cetak_kwitansi = '1'");
    }

    function get_realisasi_tindakan_ruang_by_kelas($tgl)
    {
        return $this->db->query("SELECT DISTINCT
                d.tgl_keluar_resume,
                a.kelas,
                CASE 
                    WHEN(a.kelas = 'VIP' AND A.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304','0405','0107') AND b.nmruang NOT LIKE '%Isolasi%') THEN 'VIP'
                    WHEN(a.kelas = 'I' AND A.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304','0405','0107') AND b.nmruang NOT LIKE '%Isolasi%') THEN 'Kelas I'
                    WHEN(a.kelas = 'II' AND A.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304','0405','0107') AND b.nmruang NOT LIKE '%Isolasi%') THEN 'Kelas II'
                    WHEN(a.kelas = 'III' AND A.idrg NOT IN ('0106','0604','0706','0804','0805','0504','0404','0704','0304','0405','0107') AND b.nmruang NOT LIKE '%Isolasi%') THEN 'Kelas III'
                    WHEN(A.idrg IN ('0404','0704','0304')) THEN 'ICU'
                    WHEN(A.idrg IN ('0106','0604','0706','0804','0805','0504')) THEN 'HCU'
                    WHEN(b.nmruang LIKE '%Isolasi%') THEN 'Ruang Isolasi'
                    WHEN(A.idrg = '0107') THEN 'Terminal Care'
                    WHEN(A.idrg = '0405') THEN 'Akomodasi Bayi'
                END AS tindakan
            FROM
                ruang_iri A,
                ruang b,
                tarif_tindakan C,
                pasien_iri AS d 
            WHERE
                A.idrg = b.idrg 
                AND C.id_tindakan = concat ( '1A', A.idrg ) 
                AND C.kelas = A.kelas 
                AND A.no_ipd = d.no_ipd 
                AND to_char( d.tgl_keluar_resume, 'YYYY-MM-DD' ) = '$tgl' 
                AND d.cetak_kwitansi = '1'");
    }

    function get_pasien_input_realisasi_tindakan($date1, $date2)
    {
        return $this->db->query("SELECT 
            *
        FROM 
            v_input_realisasi_tindakan_iri
        WHERE 
            to_char(tgl_keluar_resume,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
        ORDER BY 
            tgl_keluar_resume ASC");
    }

    function get_tindakan_umbal($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT
            A.id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan 
        FROM
            pemeriksaan_laboratorium AS A 
        WHERE
            A.no_lab IS NOT NULL 
            AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal') 
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION 
        SELECT 
            A.id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan 
        FROM
            pemeriksaan_radiologi AS A 
        WHERE
            A.no_rad IS NOT NULL 
            AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal')
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION 
        SELECT 
            A.id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan 
        FROM
            pemeriksaan_operasi AS A 
        WHERE
            A.no_ok IS NOT NULL 
            AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal')
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION
        SELECT 
            A.idtindakan AS id_tindakan,
            A.nmtindakan AS jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS satuan 
        FROM
            pelayanan_poli AS A
        WHERE
            a.no_register = '$noregasal' 
        GROUP BY
            A.idtindakan,
            A.nmtindakan UNION
        SELECT 
            A.id_tindakan,
            (SELECT nmtindakan FROM jenis_tindakan WHERE a.id_tindakan = idtindakan LIMIT 1) AS jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan 
        FROM
            pelayanan_iri AS A
        WHERE
            A.no_ipd = '$no_ipd' 
        GROUP BY
            A.id_tindakan");
    }

    function get_data_tindakan($id_tindakan, $no_register, $noregasal)
    {
        return $this->db->query("SELECT 
            A.id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
            (SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$id_tindakan' AND (no_register = '$no_register' OR noregasal = '$no_register') LIMIT 1) AS vtot
        FROM
            pemeriksaan_laboratorium AS A 
        WHERE
            A.no_lab IS NOT NULL 
            AND (A.no_register = '$no_register' OR a.no_register = '$noregasal')
            AND a.id_tindakan = '$id_tindakan'
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION 
        SELECT 
            A.id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
            (SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$id_tindakan' AND (no_register = '$no_register' OR noregasal = '$no_register') LIMIT 1) AS vtot
        FROM
            pemeriksaan_radiologi AS A 
        WHERE
            A.no_rad IS NOT NULL 
            AND (A.no_register = '$no_register' OR a.no_register = '$noregasal')
            AND a.id_tindakan = '$id_tindakan'
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION 
        SELECT 
            A.id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
            (SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$id_tindakan' AND (no_register = '$no_register' OR noregasal = '$no_register') LIMIT 1) AS vtot 
        FROM
            pemeriksaan_operasi AS A 
        WHERE
            A.no_ok IS NOT NULL 
            AND (A.no_register = '$no_register' OR a.no_register = '$noregasal')
            AND a.id_tindakan = '$id_tindakan'
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION
        SELECT 
            A.idtindakan AS id_tindakan,
            A.nmtindakan AS jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS satuan,
            (SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$id_tindakan' AND (no_register = '$no_register' OR noregasal = '$no_register') LIMIT 1) AS vtot 
        FROM
            pelayanan_poli AS A
        WHERE
            a.no_register = '$noregasal'
            AND a.idtindakan = '$id_tindakan' 
        GROUP BY
            A.idtindakan,
            A.nmtindakan UNION
        SELECT 
            A.id_tindakan,
            (SELECT nmtindakan FROM jenis_tindakan WHERE a.id_tindakan = idtindakan LIMIT 1) AS jenis_tindakan,
            SUM ( A.vtot ) AS total,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
            (SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$id_tindakan' AND (no_register = '$no_register' OR noregasal = '$no_register') LIMIT 1) AS vtot 
        FROM
            pelayanan_iri AS A
        WHERE
            A.no_ipd = '$no_register' 
            AND a.id_tindakan = '$id_tindakan'
        GROUP BY
            A.id_tindakan");
    }

    function get_tarif_inacbg($no_ipd)
    {
        return $this->db->query("SELECT
            a.tarif_kls_inacbg, a.tarif_jatahkls_inacbg
        FROM
            no_kwitansi AS a
        WHERE
            a.no_register = '$no_ipd'
            AND a.status IS NULL");
    }

    function get_resep_umbal_pasien($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT
            item_obat,
            nama_obat,
            'Farmasi' AS kel_tindakan,
            '' AS sub_kelompok,
            '' AS kategori,
            \"Satuan_obat\" AS satuan,
            SUM(vtot) AS total 
        FROM 
            resep_pasien 
        WHERE 
            no_register = '$no_ipd'
            OR no_register = '$noregasal'
        GROUP BY 
            no_register, item_obat, nama_obat, \"Satuan_obat\"");
    }

    function get_data_tindakan_obat($item_obat, $no_register, $noregasal)
    {
        return $this->db->query("SELECT
            a.item_obat,
            a.nama_obat,
            'Farmasi' AS kel_tindakan,
            '' AS sub_kelompok,
            '' AS kategori,
            \"Satuan_obat\" AS satuan,
            SUM(a.vtot) AS total,
            (SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$item_obat' AND (no_register = '$no_register' OR noregasal = '$no_register') LIMIT 1) AS vtot
        FROM 
            resep_pasien AS a 
        WHERE 
            (a.no_register = '$no_register' OR a.no_register = '$noregasal')
            AND a.item_obat = '$item_obat'
        GROUP BY 
            a.item_obat, a.nama_obat, \"Satuan_obat\"");
    }

    function get_ruang_umbal_pasien($no_ipd)
    {
        return $this->db->query("SELECT DISTINCT
            a.no_ipd,
            A.kelas,
            a.idrg,
            b.nmruang,
            CASE
                WHEN (A.kelas = 'VIP' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'VIP' 
                WHEN (A.kelas = 'I' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'Kelas I' 
                WHEN (A.kelas = 'II' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'Kelas II' 
                WHEN (A.kelas = 'III' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'Kelas III' 
                WHEN ( A.idrg IN ( '0404', '0704', '0304' ) ) THEN 'ICU' WHEN ( A.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504' ) ) THEN 'HCU' 
                WHEN ( b.nmruang LIKE'%Isolasi%' ) THEN 'Ruang Isolasi' 
                WHEN ( A.idrg = '0107' ) THEN 'Terminal Care' 
                WHEN ( A.idrg = '0405' ) THEN 'Akomodasi Bayi' 
            END AS tindakan,
            (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS kel_tindakan,
            (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS sub_kelompok,
            (SELECT kategori FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS kategori,
            (SELECT satuan FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS satuan
        FROM
            ruang_iri A,
            ruang b,
            tarif_tindakan C
        WHERE
            A.idrg = b.idrg 
            AND C.id_tindakan = concat ( '1A', A.idrg ) 
            AND C.kelas = A.kelas 
            AND a.no_ipd = '$no_ipd'");
    }

    function get_data_tindakan_ruang($no_ipd, $idrg)
    {
        return $this->db->query("SELECT DISTINCT A
            .*,
            b.nmruang,
            C.total_tarif,
            (
            SELECT
                x.total_tarif 
            FROM
                tarif_tindakan AS x,
                pasien_iri AS y 
            WHERE
                A.idrg = b.idrg 
                AND x.id_tindakan = concat ( '1A', A.idrg ) 
                AND x.kelas = y.jatahklsiri 
                AND y.no_ipd = A.no_ipd 
                AND A.no_ipd = '$no_ipd' 
                AND a.idrg = '$idrg'
                LIMIT 1 
            ) AS tarif_jatah,
            CASE
                WHEN (A.kelas = 'VIP' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'VIP' 
                WHEN (A.kelas = 'I' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'Kelas I' 
                WHEN (A.kelas = 'II' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'Kelas II' 
                WHEN (A.kelas = 'III' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'Kelas III' 
                WHEN ( A.idrg IN ( '0404', '0704', '0304' ) ) THEN 'ICU' WHEN ( A.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504' ) ) THEN 'HCU' 
                WHEN ( b.nmruang LIKE'%Isolasi%' ) THEN 'Ruang Isolasi' 
                WHEN ( A.idrg = '0107' ) THEN 'Terminal Care' 
                WHEN ( A.idrg = '0405' ) THEN 'Akomodasi Bayi' 
            END AS tindakan,
            (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS kel_tindakan,
            (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS sub_kelompok,
            (SELECT kategori FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS kategori,
            (SELECT satuan FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS satuan,
            (SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$idrg' AND no_register = '$no_ipd' LIMIT 1) AS vtot,
            d.tgl_keluar_resume
        FROM
            ruang_iri A,
            ruang b,
            tarif_tindakan C,
            pasien_iri AS d 
        WHERE
            A.idrg = b.idrg 
            AND C.id_tindakan = concat ( '1A', A.idrg ) 
            AND C.kelas = A.kelas 
            AND d.no_ipd = a.no_ipd
            AND A.no_ipd = '$no_ipd'
            AND a.idrg = '$idrg'");
    }

    function insert_realisasi_tindakan($data)
    {
        $this->db->insert('realisasi_tindakan', $data);
    }

    function get_realisasi_tindakan($date1, $date2)
    {
        // return $this->db->query("SELECT 
        //     nama_tindakan,
        //     kel_tindakan,
        //     sub_kelompok,
        //     kategori,
        //     satuan,
        //     SUM(CAST(qty AS FLOAT)) FILTER (WHERE carabayar = 'BPJS') AS vol_bpjs,
        //     SUM(CAST(vtot AS FLOAT)) FILTER (WHERE carabayar = 'BPJS') AS vtot_bpjs,
        //     SUM(CAST(qty AS FLOAT)) FILTER (WHERE carabayar = 'KERJASAMA' AND id_kontraktor = '67') AS vol_iks_pln,
        //     SUM(CAST(vtot AS FLOAT)) FILTER (WHERE carabayar = 'KERJASAMA' AND id_kontraktor = '67') AS vtot_iks_pln,
        //     SUM(CAST(qty AS FLOAT)) FILTER (WHERE carabayar = 'KERJASAMA' AND (id_kontraktor != '67' OR id_kontraktor IS NULL)) AS vol_iks,
        //     SUM(CAST(vtot AS FLOAT)) FILTER (WHERE carabayar = 'KERJASAMA' AND (id_kontraktor != '67' OR id_kontraktor IS NULL)) AS vtot_iks,
        //     SUM(CAST(qty AS FLOAT)) FILTER (WHERE carabayar = 'UMUM') AS vol_umum,
        //     SUM(CAST(vtot AS FLOAT)) FILTER (WHERE carabayar = 'UMUM') AS vtot_umum
        // FROM 
        //     sum_realisasi_tindakan 
        // WHERE 
        //     to_char(tgl_keluar_resume,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
        // GROUP BY 
        //     nama_tindakan,
        //     kel_tindakan,
        //     sub_kelompok,
        //     satuan,
        //     kategori");

        return $this->db->query("SELECT A
            .kel_tindakan,
            A.sub_kelompok,
            A.kategori,
            A.satuan,
            A.idtindakan,
            A.nmtindakan,
            SUM ( A.qty ) FILTER ( WHERE A.cara_bayar = 'BPJS' ) AS qty_bpjs,
            SUM ( A.qty ) FILTER ( WHERE A.cara_bayar = 'UMUM' ) AS qty_umum,
            SUM ( A.qty ) FILTER ( WHERE A.cara_bayar = 'KERJASAMA' AND ( A.id_kontraktor != 67 OR A.id_kontraktor IS NULL ) ) AS qty_iks,
            SUM ( A.qty ) FILTER ( WHERE A.cara_bayar = 'KERJASAMA' AND A.id_kontraktor = 67 ) AS qty_iks_pln,
            SUM ( A.vtot ) FILTER ( WHERE A.cara_bayar = 'BPJS' ) AS vtot_bpjs,
            SUM ( A.vtot ) FILTER ( WHERE A.cara_bayar = 'UMUM' ) AS vtot_umum,
            SUM ( A.vtot ) FILTER ( WHERE A.cara_bayar = 'KERJASAMA' AND ( A.id_kontraktor != 67 OR A.id_kontraktor IS NULL ) ) AS vtot_iks,
            SUM ( A.vtot ) FILTER ( WHERE A.cara_bayar = 'KERJASAMA' AND A.id_kontraktor = 67 ) AS vtot_iks_pln 
        FROM
            realisasi_tindakan_umum_umbal AS A 
        WHERE
            to_char( A.tgl, 'YYYY-MM-DD' ) BETWEEN '$date1' 
            AND '$date2' AND a.idtindakan IS NOT NULL
        GROUP BY
            A.kel_tindakan,
            A.sub_kelompok,
            A.kategori,
            A.satuan,
            A.idtindakan,
            A.nmtindakan");
    }

    function get_ruang_umum_realisasi_tindakan($date1, $date2)
    {
        // return $this->db->query("SELECT 
        //     a.tgl_keluar_resume,
        //     b.tglkeluarrg,
        //     b.tglmasukrg,
        //     c.total_tarif,
        //     (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = concat('1A',b.idrg) LIMIT 1) AS kel_tindakan,
        //     (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = concat('1A',b.idrg) LIMIT 1) AS sub_kelompok,
        //     (SELECT kategori FROM jenis_tindakan WHERE idtindakan = concat('1A',b.idrg) LIMIT 1) AS kategori,
        //     (SELECT satuan FROM jenis_tindakan WHERE idtindakan = concat('1A',b.idrg) LIMIT 1) AS satuan,
        //     (SELECT nmtindakan FROM jenis_tindakan WHERE idtindakan = c.id_tindakan LIMIT 1) AS tindakan,
        // 	b.kelas
        // FROM
        //     ruang_iri AS b,
        //     pasien_iri AS A,
        //     tarif_tindakan AS c,
        //     ruang AS d,
        //     no_kwitansi AS no
        // WHERE
        //     A.cetak_kwitansi = '1' 
        //     AND (a.carabayar = 'UMUM' OR (a.carabayar = 'BPJS' AND a.selisih_tarif = '1'))
        //     AND a.no_ipd = b.no_ipd
        //     AND c.id_tindakan = concat('1A',b.idrg)
        //     AND b.kelas = c.kelas
        //     AND b.idrg = d.idrg
        //     AND a.no_ipd = no.no_register
        //     AND to_char( no.tgl_cetak, 'YYYY-MM-DD' ) BETWEEN '$date1' AND '$date2'");

        return $this->db->query("SELECT
            kel_tindakan,
            kategori,
            satuan,
            sub_kelompok,
            nmruang,
            kelas,
            SUM(diff) FILTER (WHERE carabayar = 'UMUM') AS qty_umum,
            SUM(diff) FILTER (WHERE carabayar = 'KERJASAMA' AND (id_kontraktor != 67 OR id_kontraktor IS NULL)) AS qty_iks,
            SUM(diff) FILTER (WHERE carabayar = 'KERJASAMA' AND id_kontraktor = 67) AS qty_iks_pln,
            SUM(diff) FILTER (WHERE carabayar = 'BPJS') AS qty_bpjs,
            SUM(total_tarif * diff) FILTER (WHERE carabayar = 'UMUM') AS vtot_umum,
            SUM(tarif_iks * diff) FILTER (WHERE carabayar = 'KERJASAMA' AND (id_kontraktor != 67 OR id_kontraktor IS NULL)) AS vtot_iks,
            SUM(tarif_iks * diff) FILTER (WHERE carabayar = 'KERJASAMA' AND id_kontraktor = 67) AS vtot_iks_pln,
            SUM(tarif_bpjs * diff) FILTER (WHERE carabayar = 'BPJS') AS vtot_bpjs
        FROM 
            akomodasi_realisasi 
        WHERE 
            to_char(tgl_cetak, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
        GROUP BY 
            kel_tindakan,
            kategori,
            satuan,
            sub_kelompok,
            nmruang,
            kelas");
    }

    function get_tindakan_input_total($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT A
            .id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            SUM(a.qty) AS qty,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
            'lab' AS ins
        FROM
            pemeriksaan_laboratorium AS A 
        WHERE
            A.no_lab IS NOT NULL 
            AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal')
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION
        SELECT A
            .id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            SUM(a.qty) AS qty,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
            'rad' AS ins 
        FROM
            pemeriksaan_radiologi AS A 
        WHERE
            A.no_rad IS NOT NULL 
            AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal')
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION
        SELECT A
            .id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            SUM(a.qty) AS qty,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
            'ok' AS ins 
        FROM
            pemeriksaan_operasi AS A 
        WHERE
            A.no_ok IS NOT NULL 
            AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal') 
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION
        SELECT A
            .id_tindakan,
            A.jenis_tindakan,
            SUM ( A.vtot ) AS total,
            SUM(a.qty) AS qty,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
            'em' AS ins 
        FROM
            pemeriksaan_elektromedik AS A 
        WHERE
            A.no_em IS NOT NULL 
            AND (A.no_register = '$no_ipd' OR a.no_register = '$noregasal') 
        GROUP BY
            A.id_tindakan,
            A.jenis_tindakan UNION
        SELECT A
            .idtindakan AS id_tindakan,
            A.nmtindakan AS jenis_tindakan,
            SUM ( A.vtot ) AS total,
            SUM ( A.qtyind ) AS qty,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS satuan,
            CASE  
                WHEN (b.id_poli = 'BA00') THEN 'tind_igd'
                ELSE 'tind_irj'
            END AS ins
        FROM
            pelayanan_poli AS A,
            daftar_ulang_irj AS b
        WHERE
            A.no_register = '$noregasal' 
            AND a.no_register = b.no_register
        GROUP BY
            A.idtindakan,
            A.nmtindakan,
            b.id_poli UNION
        SELECT 
            A.id_tindakan,
            (SELECT nmtindakan FROM jenis_tindakan WHERE a.id_tindakan = idtindakan LIMIT 1) AS jenis_tindakan,
            SUM ( A.vtot ) AS total,
            SUM(a.qtyyanri) AS qty,
            ( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
            ( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
            ( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
            ( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
            'tind_iri' AS ins
        FROM
            pelayanan_iri AS A 
        WHERE
            A.no_ipd = '$no_ipd' 
        GROUP BY
            A.id_tindakan");
    }

    function get_obat_input_total($no_ipd, $noregasal)
    {
        return $this->db->query("SELECT
			item_obat,
			nama_obat,
			'Farmasi' AS kel_tindakan,
			'' AS sub_kelompok,
			'' AS kategori,
			\"Satuan_obat\" AS satuan,
			SUM(vtot) AS total,
            SUM(qty) AS qty
		FROM 
			resep_pasien 
		WHERE 
			no_register = '$no_ipd' OR no_register = '$noregasal'
		GROUP BY 
			item_obat, nama_obat, \"Satuan_obat\"");
    }

    function get_ruang_input_total($no_ipd)
    {
        return $this->db->query("SELECT DISTINCT A
            .*,
            b.nmruang,
            C.total_tarif,
            (
            SELECT
                x.total_tarif 
            FROM
                tarif_tindakan AS x,
                pasien_iri AS y 
            WHERE
                A.idrg = b.idrg 
                AND x.id_tindakan = concat ( '1A', A.idrg ) 
                AND x.kelas = y.jatahklsiri 
                AND y.no_ipd = A.no_ipd 
                AND A.no_ipd = '$no_ipd' 
                LIMIT 1 
            ) AS tarif_jatah,
            CASE
                WHEN (A.kelas = 'VIP' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'VIP' 
                WHEN (A.kelas = 'I' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'Kelas I' 
                WHEN (A.kelas = 'II' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'Kelas II' 
                WHEN (A.kelas = 'III' AND A.idrg NOT IN ( '0106', '0604', '0706', '0804', '0805', '0504', '0404', '0704', '0304', '0405', '0107' ) AND b.nmruang NOT LIKE'%Isolasi%') THEN 'Kelas III' 
                WHEN ( A.idrg IN ( '0404', '0704', '0304' ) ) THEN 'ICU' WHEN ( A.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504' ) ) THEN 'HCU' 
                WHEN ( b.nmruang LIKE'%Isolasi%' ) THEN 'Ruang Isolasi' 
                WHEN ( A.idrg = '0107' ) THEN 'Terminal Care' 
                WHEN ( A.idrg = '0405' ) THEN 'Akomodasi Bayi' 
            END AS tindakan,
            (SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS kel_tindakan,
            (SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS sub_kelompok,
            (SELECT kategori FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS kategori,
            (SELECT satuan FROM jenis_tindakan WHERE idtindakan = concat('1A',a.idrg) LIMIT 1) AS satuan,
            d.tgl_keluar_resume,
            'akomodasi' AS ins
        FROM
            ruang_iri A,
            ruang b,
            tarif_tindakan C,
            pasien_iri AS d 
        WHERE
            A.idrg = b.idrg 
            AND C.id_tindakan = concat ( '1A', A.idrg ) 
            AND C.kelas = A.kelas 
            AND d.no_ipd = a.no_ipd
            AND A.no_ipd = '$no_ipd'");
    }

    function insert_detail_tindakan_pasien($data)
    {
        $this->db->insert('realisasi_tindakan', $data);
    }

    function insert_total_tindakan_pasien($datot)
    {
        $this->db->insert('total_realisasi_tindakan', $datot);
    }

    function get_count_remun_dpjp_bln($date, $tampil)
    {
        if ($tampil == 'BLN') {
            return $this->db->query("SELECT 
                a.no_ipd,
                a.tgl_keluar_resume,
                b.tglmasukrg,
                b.tglkeluarrg,
                a.dokter,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0404', '0704', '0304' ) ) AS jml_icu,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504' ) ) AS jml_hcu,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0401', '0402', '0403', '0801', '0802', '0803' ) AND a.klsiri = 'I' ) AS jml_neuro_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0401', '0402', '0403', '0801', '0802', '0803' ) AND a.klsiri = 'II' ) AS jml_neuro_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'I' ) AS jml_anak_bedah_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'II' ) AS jml_anak_bedah_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'III' ) AS jml_anak_bedah_3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'I' ) AS jml_interne_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'II' ) AS jml_interne_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'III' ) AS jml_interne_3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0201', '0203', '0601', '0602' ) AND a.klsiri = 'II' ) AS jml_irnab_lt12_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0201', '0203', '0601', '0602' ) AND a.klsiri = 'VIP' ) AS jml_irnab_lt12_vip,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0202', '0603' ) ) AS jml_irnab_lt3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0301', '0701', '0704' ) ) AS jml_irnac_lt1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0302', '0702', '0705' ) ) AS jml_irnac_lt2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0303', '0703' ) ) AS jml_irnac_lt3
            FROM 
                pasien_iri AS a,
                ruang_iri AS b,
                soap_pasien_ri AS c 
            WHERE 
                to_char(c.tanggal_pemeriksaan,'YYYY-MM') = '$date'
                AND a.no_ipd = b.no_ipd 
                AND a.idrg = b.idrg 
                AND a.no_ipd = c.no_ipd 
                AND c.role = 'Dokter DPJP'
            GROUP BY 
                a.dokter, a.tgl_keluar_resume, b.tglmasukrg, b.tglkeluarrg, a.no_ipd");
        } else {
            return $this->db->query("SELECT 
                a.no_ipd,
                a.tgl_keluar_resume,
                b.tglmasukrg,
                b.tglkeluarrg,
                a.dokter,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0404', '0704', '0304' ) ) AS jml_icu,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504' ) ) AS jml_hcu,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0401', '0402', '0403', '0801', '0802', '0803' ) AND a.klsiri = 'I' ) AS jml_neuro_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0401', '0402', '0403', '0801', '0802', '0803' ) AND a.klsiri = 'II' ) AS jml_neuro_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'I' ) AS jml_anak_bedah_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'II' ) AS jml_anak_bedah_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'III' ) AS jml_anak_bedah_3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'I' ) AS jml_interne_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'II' ) AS jml_interne_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'III' ) AS jml_interne_3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0201', '0203', '0601', '0602' ) AND a.klsiri = 'II' ) AS jml_irnab_lt12_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0201', '0203', '0601', '0602' ) AND a.klsiri = 'VIP' ) AS jml_irnab_lt12_vip,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0202', '0603' ) ) AS jml_irnab_lt3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0301', '0701', '0704' ) ) AS jml_irnac_lt1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0302', '0702', '0705' ) ) AS jml_irnac_lt2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0303', '0703' ) ) AS jml_irnac_lt3
            FROM 
                pasien_iri AS a,
                ruang_iri AS b,
                soap_pasien_ri AS c 
            WHERE 
                to_char(c.tanggal_pemeriksaan,'YYYY-MM-DD') = '$date'
                AND a.no_ipd = b.no_ipd 
                AND a.idrg = b.idrg 
                AND a.no_ipd = c.no_ipd 
                AND c.role = 'Dokter DPJP'
            GROUP BY 
                a.dokter, a.tgl_keluar_resume, b.tglmasukrg, b.tglkeluarrg, a.no_ipd");
        }
    }

    function get_count_remun_raber_bln($date, $tampil)
    {
        if ($tampil == 'BLN') {
            return $this->db->query("SELECT 
                a.no_ipd,
                a.tgl_keluar_resume,
                b.tglmasukrg,
                b.tglkeluarrg,
                a.dokter,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0404', '0704', '0304' ) ) AS jml_icu,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504' ) ) AS jml_hcu,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0401', '0402', '0403', '0801', '0802', '0803' ) AND a.klsiri = 'I' ) AS jml_neuro_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0401', '0402', '0403', '0801', '0802', '0803' ) AND a.klsiri = 'II' ) AS jml_neuro_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'I' ) AS jml_anak_bedah_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'II' ) AS jml_anak_bedah_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'III' ) AS jml_anak_bedah_3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'I' ) AS jml_interne_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'II' ) AS jml_interne_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'III' ) AS jml_interne_3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0201', '0203', '0601', '0602' ) AND a.klsiri = 'II' ) AS jml_irnab_lt12_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0201', '0203', '0601', '0602' ) AND a.klsiri = 'VIP' ) AS jml_irnab_lt12_vip,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0202', '0603' ) ) AS jml_irnab_lt3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0301', '0701', '0704' ) ) AS jml_irnac_lt1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0302', '0702', '0705' ) ) AS jml_irnac_lt2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0303', '0703' ) ) AS jml_irnac_lt3
            FROM 
                pasien_iri AS a,
                ruang_iri AS b,
                soap_pasien_ri AS c 
            WHERE 
                to_char(a.tgldaftarri,'YYYY-MM') = '$date'
                AND a.no_ipd = b.no_ipd 
                AND a.idrg = b.idrg 
                AND a.no_ipd = c.no_ipd 
                AND c.role LIKE '%Dokter Bersama%'
            GROUP BY 
                a.dokter, a.tgl_keluar_resume, b.tglmasukrg, b.tglkeluarrg, a.no_ipd");
        } else {
            return $this->db->query("SELECT 
                a.no_ipd,
                a.tgl_keluar_resume,
                b.tglmasukrg,
                b.tglkeluarrg,
                a.dokter,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0404', '0704', '0304' ) ) AS jml_icu,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0106', '0604', '0706', '0804', '0805', '0504' ) ) AS jml_hcu,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0401', '0402', '0403', '0801', '0802', '0803' ) AND a.klsiri = 'I' ) AS jml_neuro_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0401', '0402', '0403', '0801', '0802', '0803' ) AND a.klsiri = 'II' ) AS jml_neuro_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'I' ) AS jml_anak_bedah_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'II' ) AS jml_anak_bedah_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0101', '0103', '0501', '0502' ) AND a.klsiri = 'III' ) AS jml_anak_bedah_3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'I' ) AS jml_interne_1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'II' ) AS jml_interne_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg = '0102' AND a.klsiri = 'III' ) AS jml_interne_3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0201', '0203', '0601', '0602' ) AND a.klsiri = 'II' ) AS jml_irnab_lt12_2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0201', '0203', '0601', '0602' ) AND a.klsiri = 'VIP' ) AS jml_irnab_lt12_vip,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0202', '0603' ) ) AS jml_irnab_lt3,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0301', '0701', '0704' ) ) AS jml_irnac_lt1,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0302', '0702', '0705' ) ) AS jml_irnac_lt2,
                COUNT ( c.id_pemeriksa ) FILTER ( WHERE a.idrg IN ( '0303', '0703' ) ) AS jml_irnac_lt3
            FROM 
                pasien_iri AS a,
                ruang_iri AS b,
                soap_pasien_ri AS c 
            WHERE 
                to_char(a.tgldaftarri,'YYYY-MM-DD') = '$date'
                AND a.no_ipd = b.no_ipd 
                AND a.idrg = b.idrg 
                AND a.no_ipd = c.no_ipd 
                AND c.role LIKE '%Dokter Bersama%'
            GROUP BY 
                a.dokter, a.tgl_keluar_resume, b.tglmasukrg, b.tglkeluarrg, a.no_ipd");
        }
    }

    function update_total_tindakan_pasien($data, $no_register)
    {
        $this->db->where('no_register', $no_register);
        $this->db->update('total_realisasi_tindakan', $data);
        return true;
    }

    function update_detail_tindakan_pasien($data, $id_tindakan, $no_register)
    {
        $this->db->where('id_tindakan', $id_tindakan);
        $this->db->where('no_register', $no_register);
        $this->db->update('realisasi_tindakan', $data);
        return true;
    }

    function get_kwitansi_umum($date1, $date2)
    {
        return $this->db->query("SELECT
            a.no_ipd,
            b.tunai
        FROM
            pasien_iri AS a,
            no_kwitansi AS b
        WHERE
            a.no_ipd = b.no_register
            AND to_char(a.tgl_keluar_resume,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'");
    }

    function get_ketepatan_visite_dpjp($tampil, $date)
    {
        if ($tampil == 'TGL') {
            return $this->db->query("SELECT 
                a.nama_pemeriksa,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0404','0704','0304','0405')) AS kurang_10_icu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0404','0704','0304','0405')) AS lebih_12_icu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0406','0105')) AS kurang_10_nicu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0406','0105')) AS lebih_12_nicu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0501','0101','0103')) AS kurang_10_anak,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0501','0101','0103')) AS lebih_12_anak,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0504','0502')) AS kurang_10_bedah,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0504','0502')) AS lebih_12_bedah,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH23:MI') <= '12:00' AND b.idrg IN ('0503','0107')) AS kurang_10_bidan,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH23:MI') > '12:00' AND b.idrg IN ('0503','0107')) AS lebih_12_bidan,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0401','0402','0801','0802','0804')) AS kurang_10_limpapeh23,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0401','0402','0801','0802','0804')) AS lebih_12_limpapeh23,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0403','0803','0805')) AS kurang_10_limpapeh4,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0403','0803','0805')) AS lebih_12_limpapeh4,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0601','0602','0201','0203','0205')) AS kurang_10_singgalang12,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0601','0602','0201','0203','0205')) AS lebih_12_singgalang12,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0204','0603')) AS kurang_10_singgalang3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0204','0603')) AS lebih_12_singgalang3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0701','309')) AS kurang_10_merapi1,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0701','309')) AS lebih_12_merapi1,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0702','0705','0307','0310','0308','0305')) AS kurang_10_merapi2,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0702','0705','0307','0310','0308','0305')) AS lebih_12_merapi2,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0703','0306')) AS kurang_10_merapi3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0703','0306')) AS lebih_12_merapi3
            FROM 
                soap_pasien_ri AS a,
                ruang_iri AS b 
            WHERE 
                a.no_ipd = b.no_ipd 
                AND to_char(a.tanggal_pemeriksaan,'YYYY-MM-DD') = '$date'
                AND a.role = 'Dokter DPJP'
            GROUP BY 
                a.nama_pemeriksa");
        } else {
            return $this->db->query("SELECT 
                a.nama_pemeriksa,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0404','0704','0304','0405')) AS kurang_10_icu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0404','0704','0304','0405')) AS lebih_12_icu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0406','0105')) AS kurang_10_nicu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0406','0105')) AS lebih_12_nicu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0501','0101','0103')) AS kurang_10_anak,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0501','0101','0103')) AS lebih_12_anak,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0504','0502')) AS kurang_10_bedah,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0504','0502')) AS lebih_12_bedah,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH23:MI') <= '12:00' AND b.idrg IN ('0503','0107')) AS kurang_10_bidan,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH23:MI') > '12:00' AND b.idrg IN ('0503','0107')) AS lebih_12_bidan,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0401','0402','0801','0802','0804')) AS kurang_10_limpapeh23,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0401','0402','0801','0802','0804')) AS lebih_12_limpapeh23,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0403','0803','0805')) AS kurang_10_limpapeh4,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0403','0803','0805')) AS lebih_12_limpapeh4,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0601','0602','0201','0203','0205')) AS kurang_10_singgalang12,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0601','0602','0201','0203','0205')) AS lebih_12_singgalang12,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0204','0603')) AS kurang_10_singgalang3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0204','0603')) AS lebih_12_singgalang3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0701','309')) AS kurang_10_merapi1,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0701','309')) AS lebih_12_merapi1,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0702','0705','0307','0310','0308','0305')) AS kurang_10_merapi2,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0702','0705','0307','0310','0308','0305')) AS lebih_12_merapi2,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') <= '12:00' AND b.idrg IN ('0703','0306')) AS kurang_10_merapi3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '12:00' AND b.idrg IN ('0703','0306')) AS lebih_12_merapi3
            FROM 
                soap_pasien_ri AS a,
                ruang_iri AS b 
            WHERE 
                a.no_ipd = b.no_ipd 
                AND to_char(a.tanggal_pemeriksaan,'YYYY-MM') = '$date'
                AND a.role = 'Dokter DPJP'
            GROUP BY 
                a.nama_pemeriksa");
        }
    }

    function get_ketepatan_visite_dpjp_imn($date, $tampil)
    {
        if ($tampil == 'TGL') {
            return $this->db->query("SELECT 
                a.nama_pemeriksa,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0404','0704','0304','0405')) AS kurang_14_icu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0404','0704','0304','0405')) AS lebih_14_icu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI')  BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0406','0105')) AS kurang_14_nicu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0406','0105')) AS lebih_14_nicu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0501','0101','0103')) AS kurang_14_anak,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0501','0101','0103')) AS lebih_14_anak,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0504','0502')) AS kurang_14_bedah,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0504','0502')) AS lebih_14_bedah,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH23:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0503','0107')) AS kurang_14_bidan,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH23:MI') > '14:00' AND b.idrg IN ('0503','0107')) AS lebih_14_bidan,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0401','0402','0801','0802','0804')) AS kurang_14_limpapeh23,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0401','0402','0801','0802','0804')) AS lebih_14_limpapeh23,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0403','0803','0805')) AS kurang_14_limpapeh4,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0403','0803','0805')) AS lebih_14_limpapeh4,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0601','0602','0201','0203','0205')) AS kurang_14_singgalang12,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0601','0602','0201','0203','0205')) AS lebih_14_singgalang12,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0204','0603')) AS kurang_14_singgalang3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0204','0603')) AS lebih_14_singgalang3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0701','309')) AS kurang_14_merapi1,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0701','309')) AS lebih_14_merapi1,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0702','0705','0307','0310','0308','0305')) AS kurang_14_merapi2,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0702','0705','0307','0310','0308','0305')) AS lebih_14_merapi2,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0703','0306')) AS kurang_14_merapi3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0703','0306')) AS lebih_14_merapi3
            FROM 
                soap_pasien_ri AS a,
                ruang_iri AS b 
            WHERE 
                a.no_ipd = b.no_ipd 
                AND to_char(a.tanggal_pemeriksaan,'YYYY-MM-DD') = '$date'
                AND a.role = 'Dokter DPJP'
            GROUP BY 
                a.nama_pemeriksa");
        } else {
            return $this->db->query("SELECT 
                a.nama_pemeriksa,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0404','0704','0304','0405')) AS kurang_14_icu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0404','0704','0304','0405')) AS lebih_14_icu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI')  BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0406','0105')) AS kurang_14_nicu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0406','0105')) AS lebih_14_nicu,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0501','0101','0103')) AS kurang_14_anak,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0501','0101','0103')) AS lebih_14_anak,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0504','0502')) AS kurang_14_bedah,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0504','0502')) AS lebih_14_bedah,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH23:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0503','0107')) AS kurang_14_bidan,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH23:MI') > '14:00' AND b.idrg IN ('0503','0107')) AS lebih_14_bidan,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0401','0402','0801','0802','0804')) AS kurang_14_limpapeh23,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0401','0402','0801','0802','0804')) AS lebih_14_limpapeh23,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0403','0803','0805')) AS kurang_14_limpapeh4,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0403','0803','0805')) AS lebih_14_limpapeh4,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0601','0602','0201','0203','0205')) AS kurang_14_singgalang12,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0601','0602','0201','0203','0205')) AS lebih_14_singgalang12,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0204','0603')) AS kurang_14_singgalang3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0204','0603')) AS lebih_14_singgalang3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0701','309')) AS kurang_14_merapi1,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0701','309')) AS lebih_14_merapi1,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0702','0705','0307','0310','0308','0305')) AS kurang_14_merapi2,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0702','0705','0307','0310','0308','0305')) AS lebih_14_merapi2,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') BETWEEN '06:00' AND '14:00' AND b.idrg IN ('0703','0306')) AS kurang_14_merapi3,
                COUNT(a.nama_pemeriksa) FILTER (WHERE to_char(a.tanggal_pemeriksaan,'HH24:MI') > '14:00' AND b.idrg IN ('0703','0306')) AS lebih_14_merapi3
            FROM 
                soap_pasien_ri AS a,
                ruang_iri AS b 
            WHERE 
                a.no_ipd = b.no_ipd 
                AND to_char(a.tanggal_pemeriksaan,'YYYY-MM') = '$date'
                AND a.role = 'Dokter DPJP'
            GROUP BY 
                a.nama_pemeriksa");
        }
    }

    function get_pasien_pulang_iri($date, $tampil)
    {
        if ($tampil == 'TGL') {
            return $this->db->query("SELECT
                *,
                (SELECT nm_poli FROM poliklinik WHERE poliklinik.id_poli = lap_rawat_inap.id_poli) AS pintu_masuk,
                (SELECT q.formjson ->> 'tanggal_perencanaan_pemulangan' AS tgl FROM rencana_pemulangan_iri AS q WHERE q.no_ipd = lap_rawat_inap.no_ipd) as tgl_rencana_pulang
            FROM
                lap_rawat_inap 
            WHERE
                tgl_keluar = '$date'");
        } else {
            return $this->db->query("SELECT
                *,
                (SELECT nm_poli FROM poliklinik WHERE poliklinik.id_poli = lap_rawat_inap.id_poli) AS pintu_masuk,
                (SELECT q.formjson ->> 'tanggal_perencanaan_pemulangan' AS tgl FROM rencana_pemulangan_iri AS q WHERE q.no_ipd = lap_rawat_inap.no_ipd) as tgl_rencana_pulang
            FROM
                lap_rawat_inap 
            WHERE
                tgl_keluar LIKE '$date%'");
        }
    }

    function get_bulan_pertahun()
    {
        return $this->db->query("SELECT * FROM bulan");
    }

    function insert_umbal($data)
    {
        $this->db->insert('umbal_pasien', $data);
    }

    function get_data_verif_dokter()
    {
        return $this->db->query("SELECT DISTINCT
            a.no_ipd,
            a.id_dokter,
            a.dokter,
            a.tgl_keluar
        FROM 
            pasien_iri AS a,
            soap_pasien_ri AS b
        WHERE 
            a.no_ipd = b.no_ipd
            AND a.tgl_keluar IS NOT NULL 
            AND a.tgl_keluar != ''
            AND b.tgl_acc_pjp IS NULL");
    }

    function update_cppt_verif_dokter($no_ipd, $data)
    {
        $this->db->where('no_ipd', $no_ipd);
        $this->db->update('soap_pasien_ri', $data);
        return true;
    }

    function update_cppt_verif_dokter2($no_ipd, $id_dokter, $dokter, $tgl)
    {
        return $this->db->query("UPDATE soap_pasien_ri SET id_pjp = '$id_dokter', nama_pjp = '$dokter', tgl_acc_pjp = '$tgl' WHERE no_ipd = '$no_ipd'");
    }

    function get_list_petugas_mpp()
    {
        return $this->db->query("SELECT A
        .userid,
        A.NAME,
        A.username 
    FROM
        hmis_users A
    
    WHERE
        A.userid = '1113' or a.userid = '1197' or a.userid = '1109'
        ");
    }

    function get_lap_kegiatan_mpp_pasien($tampil, $date, $petugas)
    {
        if ($tampil == 'TGL') {
            if ($petugas == 'semua') {
                return $this->db->query("SELECT 
                    c.nama,
                    a.no_medrec,
                    b.formjson,
                    a.tgl_masuk,
                    a.tgl_keluar,
                    d.nmruang,
                    (SELECT name FROM hmis_users WHERE userid = CAST(b.id_pemeriksa AS INT) LIMIT 1) AS petugas_mpp,
                    a.keadaanpulang,
                    a.status_pulang,
                    a.cara_pulang
                FROM 
                    pasien_iri a,
                    form_a_evaluasi b,
                    data_pasien c,
                    ruang d
                WHERE 
                    a.no_ipd = b.no_ipd 
                    AND a.no_medrec = c.no_medrec 
                    AND a.idrg = d.idrg
                    AND A.tgl_masuk = '$date'
                ORDER BY 
                    a.tgl_masuk DESC");
            } else {
                $userid = explode("-", $petugas)[0];
                return $this->db->query("SELECT 
                    c.nama,
                    a.no_medrec,
                    b.formjson,
                    a.tgl_masuk,
                    a.tgl_keluar,
                    d.nmruang,
                    (SELECT name FROM hmis_users WHERE userid = CAST(b.id_pemeriksa AS INT) LIMIT 1) AS petugas_mpp,
                    a.keadaanpulang,
                    a.status_pulang,
                    a.cara_pulang
                FROM 
                    pasien_iri a,
                    form_a_evaluasi b,
                    data_pasien c,
                    ruang d
                WHERE 
                    a.no_ipd = b.no_ipd 
                    AND a.no_medrec = c.no_medrec 
                    AND a.idrg = d.idrg
                    AND a.tgl_masuk = '$date'
                    AND b.id_pemeriksa = '$userid'
                ORDER BY 
                    a.tgl_masuk DESC");
            }
        } else {
            if ($petugas == 'semua') {
                return $this->db->query("SELECT 
                    c.nama,
                    a.no_medrec,
                    b.formjson,
                    a.tgl_masuk,
                    a.tgl_keluar,
                    d.nmruang,
                    (SELECT name FROM hmis_users WHERE userid = CAST(b.id_pemeriksa AS INT) LIMIT 1) AS petugas_mpp,
                    a.keadaanpulang,
                    a.status_pulang,
                    a.cara_pulang
                FROM 
                    pasien_iri a,
                    form_a_evaluasi b,
                    data_pasien c,
                    ruang d
                WHERE 
                    a.no_ipd = b.no_ipd 
                    AND a.no_medrec = c.no_medrec 
                    AND a.idrg = d.idrg
                    AND a.tgl_masuk LIKE '$date%'
                ORDER BY 
                    a.tgl_masuk DESC");
            } else {
                $userid = explode("-", $petugas)[0];
                return $this->db->query("SELECT 
                    c.nama,
                    a.no_medrec,
                    b.formjson,
                    a.tgl_masuk,
                    a.tgl_keluar,
                    d.nmruang,
                    (SELECT name FROM hmis_users WHERE userid = CAST(b.id_pemeriksa AS INT) LIMIT 1) AS petugas_mpp,
                    a.keadaanpulang,
                    a.status_pulang,
                    a.cara_pulang
                FROM 
                    pasien_iri a,
                    form_a_evaluasi b,
                    data_pasien c,
                    ruang d
                WHERE 
                    a.no_ipd = b.no_ipd 
                    AND a.no_medrec = c.no_medrec 
                    AND a.idrg = d.idrg
                    AND a.tgl_masuk LIKE '$date%'
                    AND b.id_pemeriksa = '$userid'
                ORDER BY 
                    a.tgl_masuk DESC");
            }
        }
    }

    function get_lap_tindakan_gizi($tampil, $date)
    {
        if ($tampil == 'TGL') {
            return $this->db->query("SELECT 
                a.no_medrec,
                b.nama,
                b.sex,
                A.carabayar,
                d.nmruang AS ruangan,
                A.klsiri,
                C.kelas,
                jt.nmtindakan,
                C.tumuminap,
                C.tgl_layanan AS tanggal,
                f.formjson::jsonb AS json,
                hm.name AS petugas,
                COUNT ( C.id_tindakan ) AS jumlah_tindakan 
            FROM
                pasien_iri A
                INNER JOIN data_pasien b ON a.no_medrec = b.no_medrec
                INNER JOIN pelayanan_iri C ON a.no_ipd = c.no_ipd
                LEFT JOIN jenis_tindakan jt ON c.id_tindakan = jt.idtindakan
                LEFT OUTER JOIN asuhan_gizi f ON a.no_ipd = f.no_ipd
                LEFT JOIN ruang AS d ON c.idrg = d.idrg
                FULL OUTER JOIN hmis_users hm ON hm.userid = c.idoprtr::INT
            WHERE
                to_char( C.tgl_layanan, 'YYYY-MM-DD' ) = '$date' 
                --AND C.id_tindakan IN ( 'BM0001', 'BM0002', 'BM0003', 'BM0004', 'BM0006', 'BM0007' ) 
                AND jt.kategori IN ('Gizi','Konseling ')
            GROUP BY
                A.no_medrec,
                b.nama,
                b.sex,
                A.carabayar,
                A.klsiri,
                C.kelas,
                jt.nmtindakan,
                C.tumuminap,
                tanggal,
                json,
                petugas,
                ruangan
            ORDER BY
                tanggal DESC");
        } else {
            return $this->db->query("SELECT
                a.no_medrec,
                b.nama,
                b.sex,
                A.carabayar,
                d.nmruang AS ruangan,
                A.klsiri,
                C.kelas,
                jt.nmtindakan,
                C.tumuminap,
                C.tgl_layanan AS tanggal,
                f.formjson::jsonb AS json,
                hm.name AS petugas,
                COUNT ( C.id_tindakan ) AS jumlah_tindakan 
            FROM
                pasien_iri A
                INNER JOIN data_pasien b ON a.no_medrec = b.no_medrec
                INNER JOIN pelayanan_iri C ON a.no_ipd = c.no_ipd
                LEFT JOIN jenis_tindakan jt ON c.id_tindakan = jt.idtindakan
                LEFT OUTER JOIN asuhan_gizi f ON a.no_ipd = f.no_ipd
                LEFT JOIN ruang AS d ON c.idrg = d.idrg
                FULL OUTER JOIN hmis_users hm ON hm.userid = c.idoprtr::INT
            WHERE
                to_char( C.tgl_layanan, 'YYYY-MM' ) = '$date' 
                --AND C.id_tindakan IN ( 'BM0001', 'BM0002', 'BM0003', 'BM0004', 'BM0006', 'BM0007' ) 
                AND jt.kategori IN ('Gizi','Konseling ')
            GROUP BY
                A.no_medrec,
                b.nama,
                b.sex,
                A.carabayar,
                A.klsiri,
                C.kelas,
                jt.nmtindakan,
                C.tumuminap,
                tanggal,
                json,
                petugas,
                ruangan
            ORDER BY
                tanggal DESC");
        }
    }

    function get_lap_porsi_makanan_gizi($date)
    {
        return $this->db->query("SELECT
            'I' AS kelas,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'BPJS') AS tgl_bpjs,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'UMUM') AS tgl_umum,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'KERJASAMA') AS tgl_iks
        FROM 
            ruang_iri A 
            LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd
        WHERE 
            b.tgl_keluar LIKE '$date%'
            AND a.kelas = 'I'
            AND a.idrg NOT IN ('0404','0704','0604','0504','0804','0805','0706','309','0701','0705') UNION 
        SELECT
            'II' AS kelas,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'BPJS') AS tgl_bpjs,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'UMUM') AS tgl_umum,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'KERJASAMA') AS tgl_iks
        FROM 
            ruang_iri A 
            LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd
        WHERE 
            b.tgl_keluar LIKE '$date%'
            AND a.kelas = 'II'
            AND a.idrg NOT IN ('0404','0704','0604','0504','0804','0805','0706','309','0701','0705') UNION 
        SELECT
            'III' AS kelas,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'BPJS') AS tgl_bpjs,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'UMUM') AS tgl_umum,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'KERJASAMA') AS tgl_iks
        FROM 
            ruang_iri A 
            LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd
        WHERE 
            b.tgl_keluar LIKE '$date%'
            AND a.kelas = 'III'
            AND a.idrg NOT IN ('0404','0704','0604','0504','0804','0805','0706','309','0701','0705') UNION 
        SELECT
            'VIP' AS kelas,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'BPJS') AS tgl_bpjs,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'UMUM') AS tgl_umum,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'KERJASAMA') AS tgl_iks
        FROM 
            ruang_iri A 
            LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd
        WHERE 
            b.tgl_keluar LIKE '$date%'
            AND a.kelas = 'VIP'
            AND a.idrg NOT IN ('0404','0704','0604','0504','0804','0805','0706','309','0701','0705') UNION 
        SELECT
            'ICU' AS kelas,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'BPJS') AS tgl_bpjs,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'UMUM') AS tgl_umum,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'KERJASAMA') AS tgl_iks
        FROM 
            ruang_iri A 
            LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd
        WHERE 
            b.tgl_keluar LIKE '$date%'
            AND a.idrg IN ('0404','0704') UNION 
        SELECT
            'HCU' AS kelas,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'BPJS') AS tgl_bpjs,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'UMUM') AS tgl_umum,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'KERJASAMA') AS tgl_iks
        FROM 
            ruang_iri A 
            LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd
        WHERE 
            b.tgl_keluar LIKE '$date%'
            AND a.idrg IN ('0604','0504','0804','0805','0706','0106') UNION 
        SELECT
            'Isolasi' AS kelas,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'BPJS') AS tgl_bpjs,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'UMUM') AS tgl_umum,
            SUM(
                CASE 
                    WHEN(A.tglkeluarrg = A.tglmasukrg) THEN 1
                    ELSE A.tglkeluarrg - A.tglmasukrg
                END) FILTER (WHERE b.carabayar = 'KERJASAMA') AS tgl_iks
        FROM 
            ruang_iri A 
            LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd
        WHERE 
            b.tgl_keluar LIKE '$date%'
            AND a.idrg IN ('309','0701','0705')");
    }

    function get_lap_pasien_pulang_v2($tampil, $date)
    {
        if ($tampil == 'TGL') {
            return $this->db->query("SELECT
                a.no_ipd,
                a.no_medrec,
                b.nama,
                b.sex,
                b.kotakabupaten,
                a.carabayar,
                c.nmruang,
                a.klsiri,
                a.jatahklsiri,
                a.dokter,
                d.nm_diagnosa,
                a.titip,
                a.selisih_tarif,
                a.tgldaftarri,
                a.wkt_masuk_rg,
                a.tgl_masuk,
                a.tgl_keluar,
                f.nm_poli,
                g.formjson::jsonb
            FROM 
                pasien_iri a
                INNER JOIN data_pasien b ON a.no_medrec = b.no_medrec
                LEFT JOIN ruang c ON a.idrg = c.idrg
                LEFT OUTER JOIN icd1 d ON a.diagmasuk = d.id_icd
                LEFT OUTER JOIN daftar_ulang_irj e ON a.noregasal = e.no_register 
                LEFT OUTER JOIN poliklinik f ON f.id_poli = e.id_poli
                LEFT OUTER JOIN rencana_pemulangan_iri g ON a.no_ipd = g.no_ipd
            WHERE 
                a.tgl_keluar IS NOT NULL
                AND a.tgl_keluar = '$date'
            ORDER BY 
                a.tgl_keluar DESC");
        } else {
            return $this->db->query("SELECT
                a.no_ipd,
                a.no_medrec,
                b.nama,
                b.sex,
                b.kotakabupaten,
                a.carabayar,
                c.nmruang,
                a.klsiri,
                a.jatahklsiri,
                a.dokter,
                d.nm_diagnosa,
                a.titip,
                a.selisih_tarif,
                a.tgldaftarri,
                a.wkt_masuk_rg,
                a.tgl_masuk,
                a.tgl_keluar,
                f.nm_poli,
                g.formjson::jsonb
            FROM 
                pasien_iri a
                INNER JOIN data_pasien b ON a.no_medrec = b.no_medrec
                LEFT JOIN ruang c ON a.idrg = c.idrg
                LEFT OUTER JOIN icd1 d ON a.diagmasuk = d.id_icd
                LEFT OUTER JOIN daftar_ulang_irj e ON a.noregasal = e.no_register 
                LEFT OUTER JOIN poliklinik f ON f.id_poli = e.id_poli
                LEFT OUTER JOIN rencana_pemulangan_iri g ON a.no_ipd = g.no_ipd
            WHERE 
                a.tgl_keluar IS NOT NULL
                AND a.tgl_keluar LIKE '$date%'
            ORDER BY 
                a.tgl_keluar DESC");
        }
    }

    public function get_ruang_active_non_ok()
    {
        return $this->db->query("SELECT idrg, nmruang FROM ruang WHERE aktif = 'Active' AND idrg NOT IN ('901','902','903') ORDER BY nmruang");
    }

    public function get_nm_ruang($idrg)
    {
        return $this->db->query("SELECT nmruang FROM ruang WHERE idrg = '$idrg'");
    }

    public function get_lap_list_tindakan_ri($date, $tampil, $idrg)
    {
        if ($tampil == 'TGL') {
            if ($idrg == 'semua') {
                return $this->db->query("SELECT
                    a.id_tindakan,
                    c.nmtindakan,
                    d.nmruang,
                    a.kelas,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'BPJS') AS bpjs,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'UMUM') AS umum,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'KERJASAMA') AS iks,
                    (SELECT total_tarif FROM tarif_tindakan WHERE a.kelas = kelas AND a.id_tindakan = id_tindakan LIMIT 1) AS tarif_rs
                FROM 
                    pelayanan_iri a 
                    LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd 
                    LEFT JOIN jenis_tindakan c ON a.id_tindakan = c.idtindakan 
                    LEFT JOIN ruang d ON a.idrg = d.idrg 
                WHERE 	
                    b.tgl_keluar = '$date'
                GROUP BY 
                    a.id_tindakan,
                    c.nmtindakan,
                    d.nmruang,
                    a.kelas
                ORDER BY 
                    d.nmruang");
            } else {
                return $this->db->query("SELECT
                    a.id_tindakan,
                    c.nmtindakan,
                    d.nmruang,
                    a.kelas,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'BPJS') AS bpjs,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'UMUM') AS umum,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'KERJASAMA') AS iks,
                    (SELECT total_tarif FROM tarif_tindakan WHERE a.kelas = kelas AND a.id_tindakan = id_tindakan LIMIT 1) AS tarif_rs
                FROM 
                    pelayanan_iri a 
                    LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd 
                    LEFT JOIN jenis_tindakan c ON a.id_tindakan = c.idtindakan 
                    LEFT JOIN ruang d ON a.idrg = d.idrg 
                WHERE 	
                    b.tgl_keluar = '$date'
                    AND a.idrg = '$idrg'
                GROUP BY 
                    a.id_tindakan,
                    c.nmtindakan,
                    d.nmruang,
                    a.kelas
                ORDER BY 
                    d.nmruang");
            }
        } else {
            if ($idrg == 'semua') {
                return $this->db->query("SELECT
                    a.id_tindakan,
                    c.nmtindakan,
                    d.nmruang,
                    a.kelas,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'BPJS') AS bpjs,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'UMUM') AS umum,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'KERJASAMA') AS iks,
                    (SELECT total_tarif FROM tarif_tindakan WHERE a.kelas = kelas AND a.id_tindakan = id_tindakan LIMIT 1) AS tarif_rs
                FROM 
                    pelayanan_iri a 
                    LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd 
                    LEFT JOIN jenis_tindakan c ON a.id_tindakan = c.idtindakan 
                    LEFT JOIN ruang d ON a.idrg = d.idrg 
                WHERE 	
                    b.tgl_keluar LIKE '$date%'
                GROUP BY 
                    a.id_tindakan,
                    c.nmtindakan,
                    d.nmruang,
                    a.kelas
                ORDER BY 
                    d.nmruang");
            } else {
                return $this->db->query("SELECT
                    a.id_tindakan,
                    c.nmtindakan,
                    d.nmruang,
                    a.kelas,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'BPJS') AS bpjs,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'UMUM') AS umum,
                    COUNT(a.id_tindakan) FILTER (WHERE b.carabayar = 'KERJASAMA') AS iks,
                    (SELECT total_tarif FROM tarif_tindakan WHERE a.kelas = kelas AND a.id_tindakan = id_tindakan LIMIT 1) AS tarif_rs
                FROM 
                    pelayanan_iri a 
                    LEFT JOIN pasien_iri b ON a.no_ipd = b.no_ipd 
                    LEFT JOIN jenis_tindakan c ON a.id_tindakan = c.idtindakan 
                    LEFT JOIN ruang d ON a.idrg = d.idrg 
                WHERE 	
                    b.tgl_keluar LIKE '$date%'
                    AND a.idrg = '$idrg'
                GROUP BY 
                    a.id_tindakan,
                    c.nmtindakan,
                    d.nmruang,
                    a.kelas
                ORDER BY 
                    d.nmruang");
            }
        }
    }

    public function get_lap_list_tindakan($date, $tampil, $idrg)
    {
        if ($tampil == 'TGL') {
            if ($idrg == 'semua') {
                $where = "b.tgl_keluar = '$date'";
            } else {
                $where = "b.tgl_keluar = '$date' AND a.idrg = '$idrg'";
            }
        } else {
            if ($idrg == 'semua') {
                $where = "b.tgl_keluar LIKE '$date%'";
            } else {
                $where = "b.tgl_keluar LIKE '$date%' AND a.idrg = '$idrg'";
            }
        }

        return $this->db->query("SELECT 
            A.id_tindakan,
            C.nmtindakan,
            CASE 
                WHEN(a.idrg = '0801') THEN 'Gedung Limpapeh Lantai 2'
                WHEN(a.idrg IN ('0802','0804')) THEN 'Gedung Limpapeh Lantai 3'
                WHEN(a.idrg IN ('0803','0805')) THEN 'Gedung Limpapeh Lantai 4'
                WHEN(a.idrg = '0601') THEN 'Gedung Singgalang Lantai 1'
                WHEN(a.idrg = '0602') THEN 'Gedung Singgalang Lantai 2'
                WHEN(a.idrg IN ('0603','0604')) THEN 'Gedung Singgalang Lantai 3'
                WHEN(a.idrg IN ('0701','0704')) THEN 'Gedung Merapi Lantai 1'
                WHEN(a.idrg IN ('0702','0705')) THEN 'Gedung Merapi Lantai 2'
                WHEN(a.idrg IN ('0703','0706')) THEN 'Gedung Merapi Lantai 3'
                WHEN(a.idrg = '0501') THEN 'Gedung Panorama (Ruang Anak)'
                WHEN(a.idrg IN ('0502','0504')) THEN 'Gedung Panorama (Ruang Bedah)'
                WHEN(a.idrg IN ('0503','0107')) THEN 'Gedung Panorama (Ruang Kebidanan)'
                WHEN(a.idrg = '0404') THEN 'ICU'
            END AS nmruang,
            a.kelas,
            SUM ( A.qtyyanri ) FILTER ( WHERE b.carabayar = 'BPJS' ) AS bpjs,
            SUM ( A.qtyyanri ) FILTER ( WHERE b.carabayar = 'UMUM' ) AS umum,
            SUM ( A.qtyyanri ) FILTER ( WHERE b.carabayar = 'KERJASAMA' ) AS iks,
            (SELECT total_tarif FROM tarif_tindakan WHERE A.kelas = kelas AND A.id_tindakan = id_tindakan LIMIT 1) AS tarif_rs
        FROM
            pelayanan_iri
            A LEFT JOIN pasien_iri b ON A.no_ipd = b.no_ipd
            LEFT JOIN jenis_tindakan C ON A.id_tindakan = C.idtindakan
        WHERE
            $where
        GROUP BY 
            a.id_tindakan,
            c.nmtindakan,
            a.idrg,
            a.kelas
        ORDER BY 
            nmruang");
    }

    function get_dokter_umum()
    {
        return $this->db->query("SELECT 
            a.id_dokter,
            b.nm_dokter 
        FROM 
            dyn_user_dokter a
            LEFT JOIN data_dokter b ON a.id_dokter = b.id_dokter
            LEFT JOIN dyn_role_user c ON a.userid = c.userid 
        WHERE 
            c.role LIKE '%Dokter Umum%'");
    }

    function get_lap_list_dokter_ruang_jaga($date, $tampil, $id_dokter)
    {
        if ($tampil == 'TGL') {
            if ($id_dokter == 'semua') {
                $where = "to_char( tgl, 'YYYY-MM-DD') = '$date'";
            } else {
                $where = "to_char( tgl, 'YYYY-MM-DD') = '$date' AND id_dokter = '$id_dokter'";
            }
        } else {
            if ($id_dokter == 'semua') {
                $where = "to_char( tgl, 'YYYY-MM') LIKE '$date%'";
            } else {
                $where = "to_char( tgl, 'YYYY-MM') LIKE '$date%' AND id_dokter = '$id_dokter'";
            }
        }

        return $this->db->query("SELECT
                tgl,
                no_medrec,
                nama,
                sex,
                carabayar,
                nm_ruang,
                klsiri,
                MAX ( soap ) AS soap,
                MAX ( medis ) AS medis,
                MAX ( diagnosa ) AS diagnosa,
                MAX ( soap_emergency ) AS soap_emergency,
                MAX ( tebak ) AS tebak,
                MAX ( sisrute ) AS sisrute,
                MAX ( rm ) AS rm,
                ( SELECT nm_dokter FROM data_dokter WHERE data_dokter.id_dokter = list_pasien_dokter_jaga_ruangan.id_dokter ) AS petugas,
                tgl_masuk,
                tgl_keluar 
            FROM
                list_pasien_dokter_jaga_ruangan 
            WHERE
                $where 
                AND id_dokter IS NOT NULL 
            GROUP BY
                tgl,
                no_medrec,
                nama,
                sex,
                carabayar,
                nm_ruang,
                klsiri,
                petugas,
                tgl_masuk,
                tgl_keluar");
    }

    function get_lap_rekapitulasi_kinerja_dokter_igd($date, $tampil)
    {
        if ($tampil == 'TGL') {
            $where1 = "AND TO_CHAR(TO_DATE(soap_pasien_rj.tgl_input,'YYYY-MM-DD'),'YYYY-MM-DD') = '$date'";
            $where2 = "AND TO_CHAR(soap_pasien_ri.tanggal_pemeriksaan,'YYYY-MM-DD') = '$date'";
            $where3 = "AND TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-DD') = '$date'";
            $where4 = "AND TO_CHAR(pasien_iri.tgl_keluar_resume,'YYYY-MM-DD') = '$date'";
            $where5 = "AND TO_CHAR(assesment_medik_igd.tgl_input,'YYYY-MM-DD') = '$date'";
        } else {
            $where1 = "AND TO_CHAR(TO_DATE(soap_pasien_rj.tgl_input,'YYYY-MM-DD'),'YYYY-MM') = '$date'";
            $where2 = "AND TO_CHAR(soap_pasien_ri.tanggal_pemeriksaan,'YYYY-MM') = '$date'";
            $where3 = "AND TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM') = '$date'";
            $where4 = "AND TO_CHAR(pasien_iri.tgl_keluar_resume,'YYYY-MM') = '$date'";
            $where5 = "AND TO_CHAR(assesment_medik_igd.tgl_input,'YYYY-MM') = '$date'";
        }
        return $this->db->query("
        select (select name from hmis_users where hmis_users.userid = dyn_user_dokter.userid) as nama_petugas ,
        (
        SELECT count(soap_pasien_rj.*)
                FROM soap_pasien_rj
                            RIGHT JOIN daftar_ulang_irj on daftar_ulang_irj.no_register = soap_pasien_rj.no_register
                            WHERE daftar_ulang_irj.id_poli != 'BA00' AND
                dyn_user_dokter.userid = soap_pasien_rj.id_pemeriksa::integer
                            $where1
        ) as soap_rj,
        (
        SELECT count(soap_pasien_rj.*)
                FROM soap_pasien_rj
                            RIGHT JOIN daftar_ulang_irj on daftar_ulang_irj.no_register = soap_pasien_rj.no_register
                            WHERE daftar_ulang_irj.id_poli = 'BA00' AND
                dyn_user_dokter.userid = soap_pasien_rj.id_pemeriksa::integer
                            $where1
        ) as soap_rd,
        (SELECT COUNT(soap_pasien_ri.*)
                FROM soap_pasien_ri
                            INNER JOIN pasien_iri on pasien_iri.no_ipd = soap_pasien_ri.no_ipd
                WHERE dyn_user_dokter.userid = soap_pasien_ri.id_pemeriksa::integer
                            AND pasien_iri.idrg != '0404'
                            $where2
                            ) as soap_ri,
                            (SELECT COUNT(soap_pasien_ri.*)
                FROM soap_pasien_ri
                            INNER JOIN pasien_iri on pasien_iri.no_ipd = soap_pasien_ri.no_ipd
                WHERE dyn_user_dokter.userid = soap_pasien_ri.id_pemeriksa::integer
                            AND pasien_iri.idrg = '0404'
                            $where2
                            ) as soap_icu,
        (
        SELECT COUNT(diagnosa_pasien.*)
                FROM diagnosa_pasien
                            LEFT JOIN daftar_ulang_irj on daftar_ulang_irj.no_register = diagnosa_pasien.no_register
                WHERE  diagnosa_pasien.klasifikasi_diagnos::text = 'utama'::text
                            AND diagnosa_pasien.xuser = hmis_users.username
                            AND daftar_ulang_irj.id_poli != 'BA00'
                            $where3
        ) as diagnosa_rj,
        (
        SELECT COUNT(diagnosa_pasien.*)
                FROM diagnosa_pasien
                            LEFT JOIN daftar_ulang_irj on daftar_ulang_irj.no_register = diagnosa_pasien.no_register
                WHERE  diagnosa_pasien.klasifikasi_diagnos::text = 'utama'::text
                            AND diagnosa_pasien.xuser = hmis_users.username
                            AND daftar_ulang_irj.id_poli = 'BA00'
                            $where3
        ) as diagnosa_rd,
        (
        SELECT count(*)
                FROM diagnosa_iri
                            LEFT JOIN pasien_iri on pasien_iri.no_ipd = diagnosa_iri.no_register
                WHERE diagnosa_iri.klasifikasi_diagnos::text = 'utama'::text
                            AND pasien_iri.id_dokter = dyn_user_dokter.id_dokter
                            AND pasien_iri.idrg != '0404'
                            $where4
                            
        ) as diagnosa_iri,
        (
        SELECT count(*)
                FROM diagnosa_iri
                            LEFT JOIN pasien_iri on pasien_iri.no_ipd = diagnosa_iri.no_register
                WHERE diagnosa_iri.klasifikasi_diagnos::text = 'utama'::text
                            AND pasien_iri.id_dokter = dyn_user_dokter.id_dokter
                            AND pasien_iri.idrg = '0404'
                            $where4
        ) as diagnosa_icu,
        (
        SELECT count(soap_pasien_rj.plan_perawat)
                FROM soap_pasien_rj
                            RIGHT JOIN daftar_ulang_irj on daftar_ulang_irj.no_register = soap_pasien_rj.no_register
                            WHERE daftar_ulang_irj.id_poli != 'BA00' AND
                dyn_user_dokter.userid = soap_pasien_rj.id_pemeriksa::integer
                            $where1
        ) as plan_rj,
        (
        SELECT count(soap_pasien_rj.plan_perawat)
                FROM soap_pasien_rj
                            RIGHT JOIN daftar_ulang_irj on daftar_ulang_irj.no_register = soap_pasien_rj.no_register
                            WHERE daftar_ulang_irj.id_poli = 'BA00' AND
                dyn_user_dokter.userid = soap_pasien_rj.id_pemeriksa::integer
                            $where1
        ) as plan_rd,

        (SELECT COUNT(soap_pasien_ri.plan)
                FROM soap_pasien_ri
                            INNER JOIN pasien_iri on pasien_iri.no_ipd = soap_pasien_ri.no_ipd
                WHERE dyn_user_dokter.userid = soap_pasien_ri.id_pemeriksa::integer
                            AND pasien_iri.idrg != '0404'
                            $where2
                            ) as plan_ri,
                            (SELECT COUNT(soap_pasien_ri.plan)
                FROM soap_pasien_ri
                            INNER JOIN pasien_iri on pasien_iri.no_ipd = soap_pasien_ri.no_ipd
                WHERE dyn_user_dokter.userid = soap_pasien_ri.id_pemeriksa::integer
                            AND pasien_iri.idrg = '0404'
                            $where2
                            ) as plan_icu,
        (
        SELECT count(assesment_medik_igd.formjson->>'table_konsultasi')
                FROM assesment_medik_igd
                WHERE dyn_user_dokter.id_dokter = assesment_medik_igd.id_dokter
                            $where5
        ) as tebak_igd,
        (
        SELECT COUNT(soap_pasien_ri.konsul_dokter)
                FROM soap_pasien_ri
                            INNER JOIN pasien_iri on pasien_iri.no_ipd = soap_pasien_ri.no_ipd
                WHERE dyn_user_dokter.userid = soap_pasien_ri.id_pemeriksa
                            AND pasien_iri.idrg !='0404'
                            $where2
        ) as tebak_ri,
        (
        SELECT COUNT(soap_pasien_ri.konsul_dokter)
                FROM soap_pasien_ri
                            INNER JOIN pasien_iri on pasien_iri.no_ipd = soap_pasien_ri.no_ipd
                WHERE dyn_user_dokter.userid = soap_pasien_ri.id_pemeriksa
                            AND pasien_iri.idrg ='0404'
                            $where2
        ) as tebak_icu,
        (SELECT count(assesment_medik_igd.formjson->>'respon_rujukan')
                FROM assesment_medik_igd
                WHERE dyn_user_dokter.id_dokter = assesment_medik_igd.id_dokter
                            $where5
        ) as sisrute_igd,
        0 as sisrute_ri,
        0 as sisrute_icu

                            
        from dyn_user_dokter 
        inner join dyn_role_user on dyn_role_user.userid = dyn_user_dokter.userid 
        INNER join hmis_users on hmis_users.userid = dyn_user_dokter.userid
        where roleid=1009;

        ");
    }

    function get_ruang_realisasi_potensi($no_ipd)
    {
        return $this->db->query("SELECT DISTINCT 
            A.*,
            b.nmruang,
            c.tarif_bpjs,
            (SELECT x.tarif_bpjs FROM tarif_tindakan AS x, pasien_iri AS y WHERE a.idrg = b.idrg AND x.id_tindakan = concat ( '1A', a.idrg ) AND x.kelas = y.jatahklsiri AND y.no_ipd = a.no_ipd AND a.no_ipd = '$no_ipd' LIMIT 1) AS tarif_jatah_bpjs,
            d.tgl_keluar_resume,
            d.titip
        FROM
            ruang_iri A,
            ruang b,
            tarif_tindakan C,
            pasien_iri AS d
        WHERE
            A.idrg = b.idrg 
            AND C.id_tindakan = concat ( '1A', A.idrg ) 
            AND C.kelas = A.kelas 
            AND a.no_ipd = '$no_ipd'
            AND a.no_ipd = d.no_ipd");
    }

    function get_noreg_pendapatan_perhari_bpjs($date1, $date2)
    {
        // $month = explode("-", $date)[1];
        // $tahun = explode("-", $date)[0];
        // return $this->db->query("SELECT 
        //     b.no_register 
        // FROM 
        //     umbal_pasien AS a 
        //     LEFT OUTER JOIN bpjs_sep AS b ON a.no_sep = b.no_sep 
        // WHERE 
        //     A.bln_klaim = '$month' 
        //     AND A.tahun = '$tahun'");

        return $this->db->query("SELECT 
            b.no_ipd AS no_register
        FROM 
            umbal_pasien AS a 
            LEFT OUTER JOIN pasien_iri AS b ON a.no_sep = b.no_sep 
        WHERE 
            to_char(tgl_keluar_resume, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'");
    }

    function get_tarif_rill_lab($no_register)
    {
        if (substr($no_register, 0, 2) == 'RJ') {
            return $this->db->query("SELECT 
                CASE 
                    WHEN (c.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                    WHEN (c.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                    ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                END AS tarif
            FROM 
                pemeriksaan_laboratorium AS a,
                daftar_ulang_irj AS c
            WHERE 
                a.no_register = '$no_register'
                AND a.no_register = c.no_register
            GROUP BY 
                c.cara_bayar");
        } else {
            return $this->db->query("SELECT 
                CASE 
                    WHEN (c.carabayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                    WHEN (c.carabayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                    ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                END AS tarif
            FROM 
                pemeriksaan_laboratorium AS a,
                pasien_iri AS c
            WHERE 
                a.no_register = '$no_register'
                AND a.no_register = c.no_ipd
            GROUP BY 
                c.carabayar");
        }
    }

    function get_tarif_rill_rad($no_register)
    {
        if (substr($no_register, 0, 2) == 'RJ') {
            return $this->db->query("SELECT 
                CASE 
                    WHEN (c.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                    WHEN (c.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                    ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                END AS tarif
            FROM 
                pemeriksaan_radiologi AS a,
                daftar_ulang_irj AS c
            WHERE 
                a.no_register = '$no_register'
                AND a.no_register = c.no_register
            GROUP BY 
                c.cara_bayar");
        } else {
            return $this->db->query("SELECT 
                CASE 
                    WHEN (c.carabayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                    WHEN (c.carabayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                    ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                END AS tarif
            FROM 
                pemeriksaan_radiologi AS a,
                pasien_iri AS c
            WHERE 
                a.no_register = '$no_register'
                AND a.no_register = c.no_ipd
            GROUP BY 
                c.carabayar");
        }
    }

    function get_tarif_rill_em($no_register)
    {
        if (substr($no_register, 0, 2) == 'RJ') {
            return $this->db->query("SELECT 
                CASE 
                    WHEN (c.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                    WHEN (c.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                    ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                END AS tarif
            FROM 
                pemeriksaan_elektromedik AS a,
                daftar_ulang_irj AS c
            WHERE 
                a.no_register = '$no_register'
                AND a.no_register = c.no_register
            GROUP BY 
                c.cara_bayar");
        } else {
            return $this->db->query("SELECT 
                CASE 
                    WHEN (c.carabayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                    WHEN (c.carabayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                    ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                END AS tarif
            FROM 
                pemeriksaan_elektromedik AS a,
                pasien_iri AS c
            WHERE 
                a.no_register = '$no_register'
                AND a.no_register = c.no_ipd
            GROUP BY 
                c.carabayar");
        }
    }

    function get_tarif_rill_ok($no_register)
    {
        if (substr($no_register, 0, 2) == 'RJ') {
            return $this->db->query("SELECT 
                CASE 
                    WHEN (c.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                    WHEN (c.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                    ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND a.id_tindakan = id_tindakan LIMIT 1))
                END AS tarif
            FROM 
                pemeriksaan_operasi AS a,
                daftar_ulang_irj AS c
            WHERE 
                a.no_register = '$no_register'
                AND a.no_register = c.no_register
            GROUP BY 
                c.cara_bayar");
        } else {
            return $this->db->query("SELECT 
                CASE 
                    WHEN (c.carabayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                    WHEN (c.carabayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                    ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.klsiri AND a.id_tindakan = id_tindakan LIMIT 1))
                END AS tarif
            FROM 
                pemeriksaan_operasi AS a,
                pasien_iri AS c
            WHERE 
                a.no_register = '$no_register'
                AND a.no_register = c.no_ipd
            GROUP BY 
                c.carabayar");
        }
    }

    function get_tarif_rill_lab_noregasal($no_ipd)
    {
        return $this->db->query("SELECT 
            CASE 
                WHEN(b.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
                WHEN(b.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
                ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
            END AS tarif
        FROM 
            pemeriksaan_laboratorium AS a,
            pasien_iri AS c,
            daftar_ulang_irj AS b
        WHERE 
            a.no_register = c.noregasal
            AND c.noregasal = b.no_register
            AND c.no_ipd = '$no_ipd'
        GROUP BY 
            b.cara_bayar");
    }

    function get_tarif_rill_rad_noregasal($no_ipd)
    {
        return $this->db->query("SELECT 
            CASE 
                WHEN(b.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
                WHEN(b.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
                ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
            END AS tarif
        FROM 
            pemeriksaan_radiologi AS a,
            pasien_iri AS c,
            daftar_ulang_irj AS b
        WHERE 
            a.no_register = c.noregasal
            AND c.noregasal = b.no_register
            AND c.no_ipd = '$no_ipd'
        GROUP BY 
            b.cara_bayar");
    }

    function get_tarif_rill_em_noregasal($no_ipd)
    {
        return $this->db->query("SELECT 
            CASE 
                WHEN(b.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
                WHEN(b.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
                ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
            END AS tarif
        FROM 
            pemeriksaan_elektromedik AS a,
            pasien_iri AS c,
            daftar_ulang_irj AS b
        WHERE 
            a.no_register = c.noregasal
            AND c.noregasal = b.no_register
            AND c.no_ipd = '$no_ipd'
        GROUP BY 
            b.cara_bayar");
    }

    function get_tarif_rill_ok_noregasal($no_ipd)
    {
        return $this->db->query("SELECT 
            CASE 
                WHEN(b.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
                WHEN(b.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
                ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.id_tindakan LIMIT 1))
            END AS tarif
        FROM 
            pemeriksaan_operasi AS a,
            pasien_iri AS c,
            daftar_ulang_irj AS b
        WHERE 
            a.no_register = c.noregasal
            AND c.noregasal = b.no_register
            AND c.no_ipd = '$no_ipd'
        GROUP BY 
            b.cara_bayar");
    }

    function get_tarif_rill_all_tindakan_rj($no_register)
    {
        return $this->db->query("SELECT
                CASE 
                    WHEN(c.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND id_tindakan = a.idtindakan LIMIT 1) * a.qtyind)
                    WHEN(c.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND id_tindakan = a.idtindakan LIMIT 1) * a.qtyind)
                    ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.kelas_pasien AND id_tindakan = a.idtindakan LIMIT 1) * a.qtyind)
                END AS tarif
            FROM 
                pelayanan_poli AS a,
                daftar_ulang_irj AS c
            WHERE
                a.no_register = '$no_register'
                AND a.no_register = c.no_register
            GROUP BY 
                c.cara_bayar");
    }

    function get_tarif_rill_all_tindakan_noregasal($no_ipd)
    {
        return $this->db->query("SELECT 
            CASE 
                WHEN(b.cara_bayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.idtindakan LIMIT 1) * a.qtyind)
                WHEN(b.cara_bayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.idtindakan LIMIT 1) * a.qtyind)
                ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = b.kelas_pasien AND id_tindakan = a.idtindakan LIMIT 1) * a.qtyind)
            END AS tarif
        FROM 
            pelayanan_poli AS a,
            pasien_iri AS c,
            daftar_ulang_irj AS b
        WHERE 
            a.no_register = c.noregasal
            AND c.noregasal = b.no_register
            AND c.no_ipd = '$no_ipd'
        GROUP BY 
            b.cara_bayar");
    }

    function get_tarif_rill_all_tindakan_ri($no_ipd)
    {
        return $this->db->query("SELECT 
            CASE 
                WHEN(c.carabayar = 'UMUM') THEN SUM((SELECT total_tarif FROM tarif_tindakan WHERE kelas = c.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) * a.qtyyanri)
                WHEN(c.carabayar = 'BPJS') THEN SUM((SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = c.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) * a.qtyyanri)
                ELSE SUM((SELECT tarif_iks FROM tarif_tindakan WHERE kelas = c.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) * a.qtyyanri)
            END AS tarif
        FROM 
            pelayanan_iri AS a,
            pasien_iri AS c
        WHERE 
            a.no_ipd = c.no_ipd
            AND a.no_ipd = '$no_ipd'
        GROUP BY 
            c.carabayar");
    }

    function get_realisasi_potensi_pendapatan_bpjs($object, $month)
    {
        $yearClaim = explode("-", $month)[0];
        $monthClaim = explode("-", $month)[1];

        return $this->db->query("SELECT
            periode_umbal,
            SUM ( ril_rs :: INT ) FILTER (WHERE ril_rs ~* '[0-9]') AS rupiah_rilrs,
            SUM ( diajukan :: INT ) FILTER (WHERE diajukan ~* '[0-9]') AS rupiah_diajukan,
            SUM ( disetujui :: INT ) FILTER (WHERE disetujui ~* '[0-9]') AS rupiah_disetujui,
            COUNT(no_sep) AS vol_kasus_umbal
        FROM
            umbal_pasien
        WHERE 
            tahun = '$yearClaim'
            AND bln_klaim = '$monthClaim'
            AND objek = '$object'
        GROUP BY 
            periode_umbal");
    }

    function get_nosep_umbal($periode_umbal, $objek)
    {
        return $this->db->query("SELECT
            no_sep
        FROM 
            umbal_pasien
        WHERE 
            periode_umbal = '$periode_umbal'
            AND objek = '$objek'");
    }

    function get_nosep_from_bpjsep($no_sep)
    {
        return $this->db->query("SELECT no_register FROM bpjs_sep WHERE no_sep = '$no_sep'");
    }

    function get_noreg_sep_belum_claim($month, $object)
    {
        // return $this->db->query("SELECT 
        //     c.no_register,
        //     a.no_sep
        // FROM 
        //     bpjs_sep AS c
        //     LEFT OUTER JOIN umbal_pasien AS a ON c.no_sep = a.no_sep
        // WHERE 
        //     to_char(c.tgl_sep,'YYYY-MM') = '$month'
        //     AND SUBSTRING(c.no_register,1,2) = '$object'
        //     AND a.no_sep IS NULL");

        if ($object == 'RJ') {
            return $this->db->query("SELECT 
                c.no_register,
                a.no_sep
            FROM 
                daftar_ulang_irj AS c
                LEFT OUTER JOIN umbal_pasien AS a ON c.no_sep = a.no_sep
            WHERE 
                to_char(c.tgl_kunjungan,'YYYY-MM') = '$month'
                AND c.cara_bayar = 'BPJS'
                AND (c.ket_pulang != 'BATAL_PELAYANAN_POLI' OR c.ket_pulang IS NULL)
                AND a.no_sep IS NULL");
        } else {
            return $this->db->query("SELECT 
                c.no_ipd AS no_register,
                a.no_sep
            FROM 
                pasien_iri AS c
                LEFT OUTER JOIN umbal_pasien AS a ON c.no_sep = a.no_sep
            WHERE 
                to_char( C.tgl_keluar_resume, 'YYYY-MM' ) = '$month' 
                AND c.carabayar = 'BPJS'
                --AND (c.ket_pulang != 'BATAL_PELAYANAN_POLI' OR c.ket_pulang IS NULL)
                AND A.no_sep IS NULL");
        }
    }

    function get_count_sep($month, $object)
    {
        // return $this->db->query("SELECT 
        //     COUNT(c.no_sep) AS count
        // FROM
        //     bpjs_sep
        //     AS C LEFT OUTER JOIN umbal_pasien AS A ON C.no_sep = A.no_sep 
        // WHERE
        //     to_char( C.tgl_sep, 'YYYY-MM' ) = '$month' 
        //     AND SUBSTRING ( C.no_register, 1, 2 ) = '$object' 
        //     AND A.no_sep IS NULL");

        if ($object == 'RJ') {
            return $this->db->query("SELECT 
                COUNT(c.*) AS count
            FROM
                daftar_ulang_irj
                AS C LEFT OUTER JOIN umbal_pasien AS A ON C.no_sep = A.no_sep 
            WHERE
                to_char( C.tgl_kunjungan, 'YYYY-MM' ) = '$month' 
                AND c.cara_bayar = 'BPJS'
                AND (c.ket_pulang != 'BATAL_PELAYANAN_POLI' OR c.ket_pulang IS NULL)
                AND A.no_sep IS NULL");
        } else {
            return $this->db->query("SELECT 
                COUNT(c.*) AS count
            FROM
                pasien_iri
                AS C LEFT OUTER JOIN umbal_pasien AS A ON C.no_sep = A.no_sep 
            WHERE
                to_char( C.tgl_keluar_resume, 'YYYY-MM' ) = '$month' 
                AND c.carabayar = 'BPJS'
                --AND (c.ket_pulang != 'BATAL_PELAYANAN_POLI' OR c.ket_pulang IS NULL)
                AND A.no_sep IS NULL");
        }
    }

    function get_vtot_iri_blm_claim($no_register)
    {
        return $this->db->query("SELECT SUM(tarif) AS tarif FROM sep_belum_claim_mri WHERE no_register = '$no_register'");
    }

    function get_vtot_noregasal_blm_claim($no_register)
    {
        return $this->db->query("SELECT 
            SUM(a.tarif) AS tarif 
        FROM 
            sep_belum_claim_mrj AS a,
            pasien_iri AS b
        WHERE 
            a.no_register = b.noregasal
            AND b.no_ipd = '$no_register'");
    }

    function get_vtot_irj_blm_claim($no_register)
    {
        return $this->db->query("SELECT SUM(tarif) AS tarif FROM sep_belum_claim_mrj WHERE no_register = '$no_register'");
    }

    function get_rill_rs_blm_claim_ri($month, $object)
    {
        // return $this->db->query("SELECT 
        //     SUM(a.tarif) AS tarif 
        // FROM
        //     bpjs_sep AS b
        //     LEFT OUTER JOIN umbal_pasien AS c ON c.no_sep = b.no_sep
        //     LEFT JOIN sep_belum_claim_mri AS a ON a.no_register = b.no_register
        // WHERE
        //     to_char( b.tgl_sep, 'YYYY-MM' ) = '$month' 
        //     AND SUBSTRING ( b.no_register, 1, 2 ) = '$object' 
        //     AND c.no_sep IS NULL");

        return $this->db->query("SELECT 
            SUM( A.tarif ) AS tarif 
        FROM
            pasien_iri AS b
            LEFT OUTER JOIN umbal_pasien AS C ON C.no_sep = b.no_sep
            LEFT JOIN sep_belum_claim_mri AS A ON A.no_register = b.no_ipd
        WHERE
            to_char( b.tgl_keluar_resume, 'YYYY-MM' ) = '$month'
            AND b.carabayar = 'BPJS'
            AND C.no_sep IS NULL");
    }

    function get_rill_rs_blm_claim_noregasal($month, $object)
    {
        // return $this->db->query("SELECT 
        //     SUM( d.tarif ) AS tarif
        // FROM
        //     bpjs_sep AS a 
        //     LEFT OUTER JOIN umbal_pasien AS b ON a.no_sep = b.no_sep
        //     LEFT JOIN pasien_iri AS c ON a.no_register = c.no_ipd 
        //     LEFT JOIN sep_belum_claim_mrj AS d ON d.no_register = c.noregasal
        // WHERE
        //     to_char( a.tgl_sep, 'YYYY-MM' ) = '$month' 
        //     AND SUBSTRING ( a.no_register, 1, 2 ) = '$object' 
        //     AND b.no_sep IS NULL");

        return $this->db->query("SELECT 
            SUM( A.tarif ) AS tarif 
        FROM
            pasien_iri AS b
            LEFT OUTER JOIN umbal_pasien AS C ON C.no_sep = b.no_sep
            LEFT JOIN sep_belum_claim_mri AS A ON A.no_register = b.noregasal
        WHERE
            to_char( b.tgl_keluar_resume, 'YYYY-MM' ) = '$month'
            AND b.carabayar = 'BPJS'
            AND C.no_sep IS NULL");
    }

    function get_rill_rs_blm_claim_rj($month, $object)
    {
        // return $this->db->query("SELECT 
        //     SUM(c.tarif) AS tarif 
        // FROM
        //     bpjs_sep AS A
        //     LEFT OUTER JOIN umbal_pasien AS b ON a.no_sep = b.no_sep 
        //     LEFT JOIN sep_belum_claim_mrj AS c ON a.no_register = c.no_register
        // WHERE
        //     to_char( a.tgl_sep, 'YYYY-MM' ) = '$month' 
        //     AND SUBSTRING ( a.no_register, 1, 2 ) = '$object' 
        //     AND b.no_sep IS NULL");

        return $this->db->query("SELECT 
            SUM(c.tarif) AS tarif 
        FROM
            daftar_ulang_irj AS A
            LEFT OUTER JOIN umbal_pasien AS b ON a.no_sep = b.no_sep 
            LEFT JOIN sep_belum_claim_mrj AS c ON a.no_register = c.no_register
        WHERE
            to_char( a.tgl_kunjungan, 'YYYY-MM' ) = '$month' 
            AND a.cara_bayar = 'BPJS'
            AND (a.ket_pulang != 'BATAL_PELAYANAN_POLI' OR a.ket_pulang IS NULL)
            AND b.no_sep IS NULL");
    }

    function get_noipd_realisasi_tindakan($date1, $date2)
    {
        return $this->db->query("SELECT 
            no_register 
        FROM 
            no_kwitansi 
        WHERE 
            to_char(tgl_cetak, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
            AND jenis_kwitansi = 'RI' UNION 
        SELECT 
            b.no_register 
        FROM 
            umbal_pasien AS a
            LEFT JOIN bpjs_sep AS b ON a.no_sep = b.no_sep 
            LEFT JOIN pasien_iri AS c ON b.no_register = c.no_ipd
        WHERE
            to_char(tgl_cetak, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'");
    }

    function check_data_umbal($bulan, $periode, $objek, $thn)
    {
        return $this->db->query("SELECT no_sep FROM umbal_pasien WHERE bulan = '$bulan' AND periode = '$periode' AND objek = '$objek' AND tahun = '$thn'");
    }

    function update_umbal($data, $bulan, $periode, $objek, $thn)
    {
        $this->db->where('bulan', $bulan);
        $this->db->where('periode', $periode);
        $this->db->where('objek', $objek);
        $this->db->where('tahun', $thn);
        $this->db->update('umbal_pasien', $data);
        return true;
    }

    function get_datatable_rencana_pulang_pasien_h_1($bulan)
    {
        $this->db->select("json_build_object('jml_krg12',(count(x) FILTER (WHERE jam_keluar::TIME<='12:00:00' AND kondisi IS NULL)),'jml_h_1',(count(x) FILTER (WHERE kondisi IS NULL)),'vdata',JSON_AGG(x))as res");
        $this->db->from("(
                        SELECT 
                            ROW_NUMBER() OVER (ORDER BY pi.tgl_keluar DESC) as no_row,
                            pi.nama as nm_pasien,
                            pi.no_medrec,
                            r.nmruang,
                            vm1.nama_user as nm_user_verif,
                            (vm1.created_at)::DATE as tgl_vm1,
                            (vm1.created_at)::TIME as time_vm1,
                            pi.tgl_keluar,
                            (pi.jam_keluar)::TIME,
                            CASE 
                                WHEN (vm1.kondisi IS NOT NULL) THEN vm1.kondisi
                                WHEN (pi.keadaanpulang!='PULANG') THEN pi.keadaanpulang
                            END as kondisi
                        FROM 
                            pasien_iri pi 
                            LEFT JOIN verifpulangh_1 vm1 ON vm1.no_ipd=pi.no_ipd 
                            LEFT JOIN ruang r ON pi.idrg=r.idrg
                        WHERE 
                            pi.tgl_keluar IS NOT NULL
                            AND pi.jam_keluar IS NOT NULL
                            AND TO_CHAR(TO_DATE(pi.tgl_keluar,'YYYY-MM-DD'),'YYYY-MM')='$bulan'
                            AND ((vm1.nama_user IS NOT NULL) OR (pi.keadaanpulang!='PULANG'))
                        ORDER BY 
                        pi.tgl_keluar DESC
                        ) x");
        return $this->db->get();
    }
}
