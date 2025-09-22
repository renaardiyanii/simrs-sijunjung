<?php 
var_dump($diagnosa_pasien);

?>
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   <style>
       #div1 {
           position: relative;
       }
   
       .header-parent {
           display: flex;
           justify-content: space-between;
   
       }
   
       .right {
           display: flex;
           align-items: flex-end;
           flex-direction: column;
           /* font-size: 12px; */
       }
       .text_body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
       }
       .text_judul{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
       }   
       .patient-info {
           border: 1px solid black;
           padding: 1em;
           display: flex;
           border-radius: 10px;
       }
   
       #date {
           display: flex;
           justify-content: space-between;
       }
   
       .nomr {
           font-weight: bold;
           display: inline;
   
       }
       .margin-left-3px{
           margin-left:3px;
       }

       .margin-right-3px{
           margin-right:3px;
       }
   
       .kotak {
           float: left;
           text-align:center;
           /* margin-top:10px; */
           width: 20px;
           height: 25px;
           /* margin-left:px; */

           border: 1px solid black;
       }

       .tanpa-kotak {
           border: 1px solid black;
           padding: 5px;
       }
       .kotakin {
           /* border: 1px solid black; */
           padding: 5px;
       }
       
       .judul {
           font-weight: bold;
           /* border: 1px solid black; */
           /* width: 400px; */
           /* height: 50px; */
           padding:0px 10px;
           font-size: 12px;
           text-align: center;
           
       }
   
       .content {
           border: 1px solid black;
           padding-left: 15px;
           padding-top: 15px;
           padding-bottom: 15px;
           /* font-size: 6pt!important; */
       }
   
       .ttd {
           display: flex;
           flex-direction: column;
           justify-content: center;
           align-items: flex-end;
           margin-right: 50px;
           font-size: 11px;
       }
   
       #childttd {
           display: flex;
           flex-direction: column;
           align-items: center;
           /* font-size: 11px; */
       }
       .center{
           width:100%;
           margin:auto;
           text-align: center;
           /* background-color: aquamarine; */
       }
       td {line-height: 1.5; vertical-align:top;font-size:small;}
       .padding-fix-10mm {padding-top:0mm; padding-left: 10mm;padding-right: 10mm;}

       .table tr td{
           font-size:8.5pt!important;
       }
       .hr{
           height:2px;
           background-color:black;
       }
       .row{
           display:flex;
       }
       .row .text-body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
       }
       table{
        border-collapse: collapse;
       }
   </style>
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4" >
       <div class="A4 sheet  padding-fix-10mm">
       <header style="margin-top:20px; font-size:1pt!important;">

        <table border="0" width="100%">
        <tr>
            <td width="13%">
            <p align="center">
            <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
            </p>
            </td>
            <td  width="74%" style="font-size:9px;" align="center">
            <font style="font-size:8pt!important">
                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
            </font>
            <font style="font-size:8pt">
                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
            </font>    
            <br>
            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
            </td>
            <td width="13%">
            <p align="center">
                <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
            </p>
            </td>
        
            </tr>
           
            </table>
        </header>
        <div class="hr">
        </div>
        <p align="center" class="text_judul" style="font-weight:bold;">RESUME MEDIS PASIEN PULANG</p>

        <!--START FOREACH PASIEN-->
        <?php foreach ($pasien as $row) {
         ?>   
        
        <table border="1" width="100%">
            <tr>
                <td width="60%"><span class="text_body">Tanggal Masuk: <?php echo $row->tgl_masuk;?></span></td>
                <td width="40%"><span class="text_body">Tanggal Keluar: <?php echo $row->tgl_keluar;?></span></td>
            </tr>
            <tr>
                <td width="60%"><span class="text_body">Diagnosis/Alasan Waktu Masuk: <?php echo $row->nm_diagmasuk;?></span></td>
                <td width="40%"><span class="text_body">Ruang Rawat: <?php echo $row->nmruang;?></span></td>
            </tr>
        </table>

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">1. </span></td>
                <td width="95%"><span class="text_body">Riwayat Penyakit:</span></td>
            </tr>
        </table>
        <!--START FOREACH NOTE IRI-->
        <?php foreach ($note_iri as $row_note) { ?>

        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body"><?php echo $row_note->history_now ?></span>
        </div>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body"></span>
        </div>

        

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">2. </span></td>
                <td width="95%"><span class="text_body">Pemeriksaan Fisik:</span></td>
            </tr>
        </table>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body"><?php echo $row->pemfisik;?></span>
        </div>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body"></span>
        </div>

        <?php } ?>
        <!--END FOREACH NOTE IRI-->
        
        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">3. </span></td>
                <td width="95%"><span class="text_body">Penemuan Klinik (Lab, Ro, Ct Scan, MRI):</span></td>
            </tr>
        </table>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">....................................................................................................................................................</span>
        </div>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">...................................................................................................................................................</span>
        </div>
        
        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">4. </span></td>
                <td width="60%"><span class="text_body">Diagnosa Utama : <?php echo $row->nm_diagnosa; ?></span></td>
                <td width="35%"><span class="text_body">ICD 10 : <?php echo $row->diagnosa1; ?></span></td>
            </tr>
            <?php
            foreach($diagnosa_pasien as $val):
            ?>
            <tr>
                <td width="5%"><span class="text_body"></span></td>
                <td width="60%"><span class="text_body">Diagnosa Sekunder : <?= $val['diagnosa'] ?></span></td>
                <td width="35%"><span class="text_body">ICD 10 : <?= $val['diagnosa'] ?></span></td>
            </tr>
            <?php endforeach; ?>
           
        </table>

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">5. </span></td>
                <td width="60%"><span class="text_body">Tindakan/Prosedur/Operasi </span></td>
            </tr>
            <tr>
                <td width="5%"><span class="text_body"></span></td>
                <td width="60%"><span class="text_body">........................................................................................................</span></td>
                <td width="35%"><span class="text_body">ICD 9 CM : ............................</span></td>
            </tr>
            <tr>
                <td width="5%"><span class="text_body"></span></td>
                <td width="60%"><span class="text_body">........................................................................................................</span></td>
                <td width="35%"><span class="text_body">ICD 9 CM : ............................</span></td>
            </tr>
        </table>

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">6. </span></td>
                <td width="95%"><span class="text_body">Terapi/Pengobatan Selama Perawatan</span></td>
            </tr>
        </table>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">...................................................................................................................................................</span>
        </div>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">...................................................................................................................................................</span>
        </div>
            

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">7. </span></td>
                <td width="95%"><span class="text_body">Kondisi Saat Pulang : 
                    <input type="checkbox" class="text-body" value="perbaikan" <?php echo ($row->keadaanpulang=='PERBAIKAN' ? 'checked' : 'disabled') ?>><label class="text-body" for="perbaikan">Perbaikan</label>
                    <input type="checkbox" class="text-body" value="sembuh" <?php echo ($row->keadaanpulang=='PULANG' ? 'checked' : 'disabled') ?>><label class="text-body" for="sembuh">Sembuh</label>
                    <input type="checkbox" class="text-body" value="blm_sembuh" <?php echo ($row->keadaanpulang=='BELUM SEMBUH' ? 'checked' : 'disabled') ?>><label class="text-body" for="blm_sembuh">Belum Sembuh</label>
                    <input type="checkbox" class="text-body" value="meninggal_krg_48" <?php echo ($row->keadaanpulang=='MENINGGALKRG48' ? 'checked' : 'disabled') ?>><label class="text-body" for="meniggal_krg_48">Meninggal<48Jam</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <input type="checkbox" class="text-body" value="meninggal_lbh_48" <?php echo ($row->keadaanpulang=='MENINGGALLBH48' ? 'checked' : 'disabled') ?>><label class="text-body" for="meniggal_lbh_48">Meninggal>=48Jam</label>
                </span></td>
            </tr>
        </table>

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">8. </span></td>
                <td width="95%"><span class="text_body">Cara Pulang : 
                    <input type="checkbox" class="text-body" value="izin_dktr"><label class="text-body" for="izin_dktr">Izin Dokter</label>
                    <input type="checkbox" class="text-body" value="rujuk"><label class="text-body" for="rujuk">Rujuk</label>
                    <input type="checkbox" class="text-body" value="aps"><label class="text-body" for="aps">APS</label>
                    <input type="checkbox" class="text-body" value="pindah"><label class="text-body" for="pindah">Pindah RS</label>
                </span></td>
            </tr>
        </table>
        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">9. </span></td>
                <td width="95%"><span class="text_body">Anjuran/Rencana/Kontrol</span></td>
            </tr>
            <tr>
                <td width="5%"><span class="text_body"></span></td>
                <td width="95%"><span class="text_body">Selanjutnya:</span></td>
            </tr>
        </table>

        
        
        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">10. </span></td>
                <td width="95%"><span class="text_body">Terapi Pulang:</span></td>
            </tr>
        </table>
        <table border="1" width="100%">
            <tr height="10px">
                <td width="20%"><span class="text_body">Nama Obat</span></td>
                <td width="10%"><span class="text_body">Jumlah</span></td>
                <td width="10%"><span class="text_body">Dosis</span></td>
                <td width="10%"><span class="text_body">Frekuensi</span></td>
                <td width="20%"><span class="text_body">Cara Pemberian</span></td>
                <td width="20%"><span class="text_body">Petunjuk Khusus</span></td>
            </tr>
            <?php foreach ($obat as $row_obat) { ?>
                <tr>
                    <td><?php echo $row_obat->nama_obat;?></td>
                    <td><?php echo $row_obat->qty;?></td>
                    <td><?php echo $row_obat->signa;?></td>
                    <td><?php echo '-';?></td>
                    <td><?php echo '-';?></td>
                    <td><?php echo '-';?></td>
                </tr>
            <?php } ?>
        </table>

        <table border="0" width="100%">
            <tr>
                <td width="60%"><span class="text_body"></span></td>
                <td width="40%"><span class="text_body">Bukittinggi</span></td>
            <tr>
            <tr>
                <td width="60%"><span class="text_body">Pasien/Keluarga</span></td>
                <td width="40%"><span class="text_body">Dokter Penanggung Jawab Pelayanan</span></td>
            <tr>
            <tr height="80px">
                <td width="60%"><span class="text_body"></span></td>
                <td width="40%"><span class="text_body"></span></td>
            <tr>
            <tr>
                <td width="60%"><span class="text_body">(.......................................)</span></td>
                <td width="40%"><span class="text_body">( <?php echo $row->dokter; ?> )</span></td>
            <tr>
            <tr>
                <td width="60%"><span class="text_body">Nama jelas & tanda tangan</span></td>
                <td width="40%"><span class="text_body">Nama jelas & tanda tangan</span></td>
            <tr>
        </table>
        <?php }?>
        <!--END FOREACH PASIEN-->
   </body>
   
   </html>
   
   