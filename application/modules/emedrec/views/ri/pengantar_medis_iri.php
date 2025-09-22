<?php 
// var_dump($data_pasien_irj);

?>
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   <!-- <style>
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
   </style> -->
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4" >
       <div class="A4 sheet  padding-fix-10mm">
       
        <?php $this->load->view('emedrec/header_print') ?>
        <hr color="black">
        <p align="center" class="text_judul" style="font-weight:bold;">RESUME MEDIS PASIEN PULANG</p>
        <table border="1" width="100%">
            <tr>
                <td width="60%"><span class="text_body">Tanggal Masuk: </span></td>
                <td width="40%"><span class="text_body">Tanggal Keluar: </span></td>
            </tr>
            <tr>
                <td width="60%"><span class="text_body">Diagnosis/Alasan Waktu Masuk: </span></td>
                <td width="40%"><span class="text_body">Ruang Rawat: </span></td>
            </tr>
        </table>

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">1. </span></td>
                <td width="95%"><span class="text_body">Riwayat Penyakit:</span></td>
            </tr>
        </table>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">.........................</span>
        </div>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">.........................</span>
        </div>

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">2. </span></td>
                <td width="95%"><span class="text_body">Pemeriksaan Fisik:</span></td>
            </tr>
        </table>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">.........................</span>
        </div>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">.........................</span>
        </div>
        
        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">3. </span></td>
                <td width="95%"><span class="text_body">Penemuan Klinik (Lab, Ro, Ct Scan, MRI):</span></td>
            </tr>
        </table>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">.........................</span>
        </div>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">.........................</span>
        </div>
        
        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">4. </span></td>
                <td width="60%"><span class="text_body">Diagnosa Utama : </span></td>
                <td width="35%"><span class="text_body">ICD 10 : </span></td>
            </tr>
            <tr>
                <td width="5%"><span class="text_body"></span></td>
                <td width="60%"><span class="text_body">Diagnosa Sekunder : </span></td>
                <td width="35%"><span class="text_body">ICD 10 : </span></td>
            </tr>
            <tr>
                <td width="5%"><span class="text_body"></span></td>
                <td width="60%"><span class="text_body">Diagnosa Sekunder : </span></td>
                <td width="35%"><span class="text_body">ICD 10 : </span></td>
            </tr>
        </table>

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">5. </span></td>
                <td width="60%"><span class="text_body">Tindakan/Prosedur/Operasi </span></td>
            </tr>
            <tr>
                <td width="5%"><span class="text_body"></span></td>
                <td width="60%"><span class="text_body"></span></td>
                <td width="35%"><span class="text_body">ICD 9 CM : </span></td>
            </tr>
            <tr>
                <td width="5%"><span class="text_body"></span></td>
                <td width="60%"><span class="text_body"></span></td>
                <td width="35%"><span class="text_body">ICD 9 CM : </span></td>
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
            <span class="text_body">.........................</span>
        </div>
        <div class="row">
            <div style="margin-right:40px"><span class="text-body"></span></div>
            <span class="text_body">.........................</span>
        </div>
            

        <table border="0" width="100%">
            <tr>
                <td width="5%"><span class="text_body">7. </span></td>
                <td width="95%"><span class="text_body">Kondisi Saat Pulang : 
                    <input type="checkbox" class="text-body" value="perbaikan"><label class="text-body" for="perbaikan">Perbaikan</label>
                    <input type="checkbox" class="text-body" value="sembuh"><label class="text-body" for="sembuh">Sembuh</label>
                    <input type="checkbox" class="text-body" value="blm_sembuh"><label class="text-body" for="blm_sembuh">Belum Sembuh</label>
                    <input type="checkbox" class="text-body" value="meninggal_krg_48"><label class="text-body" for="meniggal_krg_48">Meninggal<48Jam</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <input type="checkbox" class="text-body" value="meninggal_lbh_48"><label class="text-body" for="meniggal_lbh_48">Meninggal>=48Jam</label>
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
            <tr>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
            </tr>
            <tr>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
            </tr>
            <tr>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
            </tr>
            <tr>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
            </tr>
            <tr>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
                <td><span class="text_body">a</span></td>
            </tr>
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
                <td width="60%"><span class="text_body">(..................)</span></td>
                <td width="40%"><span class="text_body">(..................)</span></td>
            <tr>
            <tr>
                <td width="60%"><span class="text_body">Nama jelas & tanda tangan</span></td>
                <td width="40%"><span class="text_body">Nama jelas & tanda tangan</span></td>
            <tr>
        </table>
   </body>
   
   </html>
   
   