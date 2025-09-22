<?php 
$data = isset($pembedahan->formjson)?json_decode($pembedahan->formjson):'';
// var_dump($data);die;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">

<div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>LAPORAN PEMBEDAHAN<br></h3>
            </center>
           
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        <tr>
            <td style="font-size:13px" colspan="2">(Diisi oleh Dokter)</td>
            <td style="font-size:13px">Halaman 1 dari 2</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       <tr>
             <td colspan="2" style="padding-bottom: 30px;">Tgl pembedahan : <?= isset($data->tgl_pembedahan)?$data->tgl_pembedahan:'' ?></td>
             <td>Jam :  <?= isset($data->jam)?$data->jam:'' ?></td>
       </tr>
       <tr>
             <td style="padding-bottom: 30px;">Ahli Bedah   :   <?= isset($data->ahli_bedah)?$data->ahli_bedah:'' ?></td>
             <td style="padding-bottom: 30px;"> Asisten  : <?= isset($data->asisten)?$data->asisten:'' ?> </td>
             <td style="padding-bottom: 30px;"> Instrumentator  :  <?= isset($data->instrumentator)?$data->instrumentator:'' ?></td>
       </tr>
       <tr>
            <td style="padding-bottom: 30px;">Macam Pembedahan :</td>
            <td colspan="2" style="padding-bottom: 30px;"><input type="checkbox"  <?= (isset($data->macam_pembedahan)?in_array("kecil", $data->macam_pembedahan)?'checked':'':'') ?>>Kecil <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("sedang", $data->macam_pembedahan)?'checked':'':'') ?>>sedang<input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("besar", $data->macam_pembedahan)?'checked':'':'') ?>>Besar<input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("khusus_1", $data->macam_pembedahan)?'checked':'':'') ?>>Khusu 1<input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("khusus_2", $data->macam_pembedahan)?'checked':'':'') ?>>Khusus 2<input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("gawat_darurat", $data->macam_pembedahan)?'checked':'':'') ?>>Gawat <br><input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("berencana", $data->macam_pembedahan)?'checked':'':'') ?>>berencana<input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("bersih", $data->macam_pembedahan)?'checked':'':'') ?>>bersih
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("bersih_tercemar", $data->macam_pembedahan)?'checked':'':'') ?>>bersih tercemar<input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("tercemar", $data->macam_pembedahan)?'checked':'':'') ?>>tercemar<input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("kotor", $data->macam_pembedahan)?'checked':'':'') ?>>kotor
        </td>
        <tr>
             <td colspan="4" style="padding-bottom: 40px;">Diagnosa pra bedah :  <?= isset($data->diagnosa_pra_bedah)?$data->diagnosa_pra_bedah:'' ?></td>
            
       </tr>
       <tr>
             <td colspan="4" style="padding-bottom: 40px;">Tindakan Pembedahan : <?= isset($data->tindakan_pembedahan)?$data->tindakan_pembedahan:'' ?></td>
            
       </tr>
       <tr>
             <td colspan="4" style="padding-bottom: 40px;">Diagnosa Pasca Bedah : <?= isset($data->diagnosa_pasca_bedah)?$data->diagnosa_pasca_bedah:'' ?></td>
       </tr>
       <tr>
            <td colspan="4">
                <table border="1" width="100%" cellpadding="2">
                   <tr>
                        <td>Nama implant</td>
                        <td>Lokasi pemasangan</td>
                        <td>Kode produk / barcode</td>
                        <td>Keterangan</td>
                   </tr>
                   <tr>
                        <td>&nbsp; <?= isset($data->nama_implant)?$data->nama_implant:'' ?></td>
                        <td>&nbsp; <?= isset($data->lokasi_pemasangan)?$data->lokasi_pemasangan:'' ?></td>
                        <td>&nbsp; <?= isset($data->kode_produk)?$data->kode_produk:'' ?></td>
                        <td>&nbsp; <?= isset($data->keterangan)?$data->keterangan:'' ?></td>
                   </tr>
                  
                </table>
                <table border="1" width="100%" cellpadding="2">
                    <tr>
                        <td rowspan="2">Ahli bius : <?= isset($data->ahli_bius)?$data->ahli_bius:'' ?></td>
                        <td>Cara Pembiusan : <?= isset($data->cara_pembiusan)?$data->cara_pembiusan:'' ?></td>
                        <td rowspan="2">Mulai : <?= isset($data->mulai)?$data->mulai:'' ?></td>
                        <td rowspan="2">Selesai : <?= isset($data->selesai)?$data->selesai:'' ?></td>
                        <td>Lama pembedahan : <?= isset($data->lama_pembedahan)?$data->lama_pembedahan:'' ?></td>
                        <td rowspan="">OK <?= isset($data->ok)?$data->ok:'' ?></td>
                     </tr>
                     <tr>
                        <td>Posisi pasien :  <?= isset($data->{'posisi_pasien:'})?$data->{'posisi_pasien:'}:'' ?></td>
                        <td>Jam.......Menit.......</td>
                     </tr>
                    
                  
                </table>
               

            </td>
       </tr>
       <tr>
             <td colspan="4"><b>URAIAN PEMBEDAHAN </b> : <br><?= nl2br(htmlspecialchars(trim($data->{'uraian_pembedahan:'} ?? ''))) ?>
             </td>
       </tr>
       <tr>
             <td colspan="4"><b>KOMPLIKASI : <?= isset($data->komplikasi)?$data->komplikasi:'' ?></b></td>
       </tr>
       <tr>
             <td colspan="2" >Jaringan dikirim ke Patologi :<input type="checkbox" <?= (isset($data->jaringan_dikirim_patologi)?in_array("tidak", $data->jaringan_dikirim_patologi)?'checked':'':'') ?>>Tidak <input type="checkbox" <?= (isset($data->jaringan_dikirim_patologi)?in_array("ya", $data->jaringan_dikirim_patologi)?'checked':'':'') ?>>Ya
            <p>Asal Jaringan   : <?= isset($data->asal_jaringan)?$data->asal_jaringan:'' ?></td>
             <td >Ahli Bedah
             <p style="margin: 10px 0;"> <img width="70px" src="<?= isset($data->question1)?$data->question1:'' ?>" alt=""></p>
             <p style="margin: 10px 0;"> <?= isset($data->ahli_bedah1)?$data->ahli_bedah1:'' ?></p>
             </td>
        </tr>
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.19.b/RI
                    </div>
               </div>
    </div>
</div>
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>LAPORAN PEMBEDAHAN</h3>
            </center>
           
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        <tr>
            <td style="font-size:13px" colspan="2">(Diisi oleh DOkter)</td>
            <td style="font-size:13px">Halaman 2 dari 2</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
                <p style="padding-bottom: 200px;"><b>LANJUTKAN PEMBEDAHAN : </b><br>  <?= nl2br(htmlspecialchars(trim($data->lanjutan_uraian_pembedahan ?? ''))) ?></p>
                <p style="padding-bottom: 60px;"><b>KOMPLIKASI</b> <br><?= nl2br(htmlspecialchars(trim($data->komplikasi2 ?? ''))) ?></p>
                <p style="padding-bottom: 60px;"><b>PERDARAHAN</b><br><?= nl2br(htmlspecialchars(trim($data->perdarahan2 ?? ''))) ?></p>
                <tr>
                <td colspan="2" style="padding-bottom: 40px;">Jaringan dikirim ke Patologi :<input type="checkbox" <?= (isset($data->question2)?in_array("tidak", $data->question2)?'checked':'':'') ?>>Tidak <input type="checkbox" <?= (isset($data->jaringan_dikirim_patologi)?in_array("ya", $data->jaringan_dikirim_patologi)?'checked':'':'') ?>>Ya
                <br><p>Asal Jaringan   :</td>
                <td style="padding-bottom: 40px;">Ahli Bedah
                    <p style="margin: 10px 0;"> <img width="70px" src="<?= isset($data->question4)?$data->question4:'' ?>" alt=""><br></p>
                    <p style="margin: 10px 0;"> <?= isset($data->question5)?$data->question5:'' ?><br></p>
                    
                </tr>
               
            </td>
       </tr>
    </table>
                <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.19.b/RI
                    </div>
               </div>
    </div>


</div>
</body>

</html>