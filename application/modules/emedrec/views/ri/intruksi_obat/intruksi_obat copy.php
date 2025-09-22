<?php 
// $intruksi_obat_data = (isset()?json_decode($intruksi_obat->formjson):'');
$result = array_chunk($intruksi_obat, 2);
//  $data = json_decode($intruksi_obat[0]->formjson);
//  var_dump($data->matriks_telaah_resep[0]->telaah_resep1);
 
?>

<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
 
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 10px;
            
        }
       
        table tr td{
            
            font-size: 10px;
            
        }
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >
        <?php
        if(count($result)>0){
            // foreach($result as $val){
                for($i=0;$i<count($result);$i++){
                
                ?>
                <?php
                foreach($result[$i] as $val){
                    $data = json_decode($val->formjson);
                    
                ?>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            
            <hr color="black">

            <div style="width: 100%;font-size: 10px;">
                <center><h3>KARTU INTRUKSI OBAT</h3></center>
                <table id="data">
                    <tr>
                        <td width="18%">Bulan</td>
                        <td width="2%">:</td>
                        <td width="30%"></td>
                        <td width="18%">Dokter DPJP</td>
                        <td width="2%">:</td>
                        <td width="30%"></td>
                    </tr>

                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td></td>
                        <td>Diagnosa Awal</td>
                        <td>:</td>
                        <td ></td>
                    </tr>

                    <tr>
                        <td>Tgl Lahir / Umur</td>
                        <td>:</td>
                        <td></td>
                        <td>Diagnosa Akhir</td>
                        <td>:</td>
                        <td ></td>
                    </tr>

                    <tr>
                        <td>No MR</td>
                        <td>:</td>
                        <td></td>
                        <td>Tgl Masuk RS</td>
                        <td>:</td>
                        <td ></td>
                    </tr>

                    <tr>
                        <td>Status Pasien</td>
                        <td>:</td>
                        <td></td>
                        <td>Tgl Keluar RS</td>
                        <td>:</td>
                        <td ></td>
                    </tr>

                    <tr>
                        <td>Ruang Rawat</td>
                        <td>:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td ></td>
                    </tr>

                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td ></td>
                    </tr>
                </table><br>

                
                <?php
                    $no=1; 
                    $jml_array = isset($data->matriks_resep_obat[0]->question2)?count($data->matriks_resep_obat[0]->question2):'';
                    for ($x = 0; $x < $jml_array; $x++) {
                       
                ?>

                <table id="data" border ="1">
                    <tr>
                        <th  width="5%">No</th>
                        <th  width="35%">Nama Obat</th>
                        <th  width="10%">Dosis</th>
                        <th  width="10%">Frek</th>
                        <th  width="10%">Rute</th>
                        <th  width="10%">Mulai tgl</th>
                        <th  width="20%">Paraf dr</th>
                    </tr>
                      
                    <tr>
                        <td  width="5%"><?= $no++ ?></td>
                        <td  width="35%"><?= isset($data->matriks_resep_obat[0]->question2[$x]->nama_obat)?$data->matriks_resep_obat[0]->question2[$x]->nama_obat:'' ?></td>
                        <td  width="10%"><?= isset($data->matriks_resep_obat[0]->question2[$x]->dosis)?$data->matriks_resep_obat[0]->question2[$x]->dosis:'' ?></td>
                        <td  width="10%"><?= isset($data->matriks_resep_obat[0]->question2[$x]->frekuensi)?$data->matriks_resep_obat[0]->question2[$x]->frekuensi:'' ?></td>
                        <td  width="10%"><?= isset($data->matriks_resep_obat[0]->question2[$x]->rute)?$data->matriks_resep_obat[0]->question2[$x]->rute:'' ?></td>
                        <td  width="10%"><?= isset($data->matriks_resep_obat[0]->tgl)?$data->matriks_resep_obat[0]->tgl:'' ?></td>
                        <td  width="20%"></td>
                    </tr>
                    <?php if (isset($data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)) { ?>
                    <tr>
                        <td colspan="7">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="30%">
                                        <table border="1" width="100%">
                                                <tr>
                                                    <td width="5%">No</td>
                                                    <td width="15%">Telaah Obat</td>
                                                    <td width="5%"></td>
                                                </tr>

                                                <tr>
                                                    <td>1.</td>
                                                    <td>Identifikasi Pasien</td>
                                                    <td style="text-align:center"><?= (isset($data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?in_array("identifikasi_pasien", $data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?' √ ':'':'') ?></td>  
                                                </tr>

                                                <tr>
                                                    <td>2.</td>
                                                    <td>Nama Obat</td>
                                                    <td style="text-align:center"><?= (isset($data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?in_array("nama_obat", $data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?' √ ':'':'') ?></td>
                                                </tr>

                                                <tr>
                                                    <td>3.</td>
                                                    <td>Dosis</td>
                                                    <td style="text-align:center"><?= (isset($data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?in_array("dosis", $data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?' √ ':'':'') ?></td>
                                                </tr>

                                                <tr>
                                                    <td>4.</td>
                                                    <td>Waktu Pemberian</td>
                                                    <td style="text-align:center"><?= (isset($data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?in_array("waktu_pemberian", $data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?' √ ':'':'') ?></td>
                                                </tr>

                                                <tr>
                                                    <td>5.</td>
                                                    <td>Cara Pakai</td>
                                                    <td style="text-align:center"><?= (isset($data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?in_array("cara_pakai", $data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?' √ ':'':'') ?></td>
                                                </tr>

                                                <tr>
                                                    <td>5.</td>
                                                    <td>Dokumentasi</td>
                                                    <td style="text-align:center"><?= (isset($data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?in_array("dokumentasi", $data->matriks_resep_obat[0]->question2[$x]->matriks_pemberian_obat[0]->telaah_5_benar)?' √ ':'':'') ?></td>
                                                </tr>
                                        </table>
                                    </td>
                                    <td width="25%">
                                        <p>Disiapkan Oleh </p>
                                    </td>
                                    <td width="45%">
                                        <p>Diterima Oleh </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                   
                </table>
                <br>

                <?php } ?>
                       
                <table width="30%" border="1">
                    <tr>
                        <th width="5%" style="font-size:11px">No</th>
                        <th width="15%" style="font-size:11px">TELAAH RESEP</th>
                        <th width="8%" style="font-size:11px"></th>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>Nama DPJP</td>
                        <td style="text-align:center"><?= (isset($data->matriks_telaah_resep[0]->telaah_resep1)?in_array("nama_dpjp", $data->matriks_telaah_resep[0]->telaah_resep1)?' √ ':'':'') ?></td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Nomor SIP</td>
                        <td style="text-align:center"><?= (isset($data->matriks_telaah_resep[0]->telaah_resep1)?in_array("nomor_sip", $data->matriks_telaah_resep[0]->telaah_resep1)?' √ ':'':'') ?></td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Tanggal Resep</td>
                        <td style="text-align:center"><?= (isset($data->matriks_telaah_resep[0]->telaah_resep1)?in_array("tanggal_resep", $data->matriks_telaah_resep[0]->telaah_resep1)?' √ ':'':'') ?></td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Paraf Dokter</td>
                        <td style="text-align:center"><?= (isset($data->matriks_telaah_resep[0]->telaah_resep1)?in_array("paraf_dokter", $data->matriks_telaah_resep[0]->telaah_resep1)?' √ ':'':'') ?></td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>Nama Obat</td>
                        <td style="text-align:center"><?= (isset($data->matriks_telaah_resep[0]->telaah_resep1)?in_array("nama_obat", $data->matriks_telaah_resep[0]->telaah_resep1)?' √ ':'':'') ?></td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>Aturan Pakai</td>
                        <td style="text-align:center"><?= (isset($data->matriks_telaah_resep[0]->telaah_resep1)?in_array("aturan_pakai", $data->matriks_telaah_resep[0]->telaah_resep1)?' √ ':'':'') ?></td>
                    </tr>

                    <tr>
                        <td>7</td>
                        <td>Duplikasi Pengobatan</td>
                        <td style="text-align:center"><?= (isset($data->matriks_telaah_resep[0]->telaah_resep1)?in_array("duplikasi", $data->matriks_telaah_resep[0]->telaah_resep1)?' √ ':'':'') ?></td>
                    </tr>

                    <tr>
                        <td>8</td>
                        <td>Interaksi Obat</td>
                        <td style="text-align:center"><?= (isset($data->matriks_telaah_resep[0]->telaah_resep1)?in_array("", $data->matriks_telaah_resep[0]->telaah_resep1)?' √ ':'':'') ?></td>
                    </tr>

                    <tr>
                        <td>9</td>
                        <td>Berat Badan</td>
                        <td style="text-align:center"><?= (isset($data->matriks_telaah_resep[0]->telaah_resep1)?in_array("berat_badan", $data->matriks_telaah_resep[0]->telaah_resep1)?' √ ':'':'') ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>Nama Petugas</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>Paraf Petugas</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

        <?php 
            }} 
    } ?>
    </body>
</html>