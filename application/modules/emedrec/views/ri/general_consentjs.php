<?php 
// var_dump($general_consent);
// var_dump(isset($general_consent[0]->formjson)?json_decode($general_consent[0]->formjson):'');
$data = (isset($general_consent[0]->formjson)?json_decode($general_consent[0]->formjson):'');
//  var_dump($data);
?>


<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
        .header-parent{
            display: flex;
            justify-content: space-between;

        }
        .right{
            display: flex;
            align-items: flex-end;
            flex-direction: column;
        }
        .patient-info{
            border: 1px solid black;
            padding: 1em;
            display: flex;
            border-radius: 10px;
        }
        .text_body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
       }
       .text_isi{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        font-weight: bold;
       }
       .text_judul{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
       } 
       td {line-height: 1.5; vertical-align:top;}
       .padding-fix-10mm {padding-top:0mm; padding-left: 10mm;padding-right: 10mm;}

       .table tr td{
           font-size:12px!important;
       }  
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<body class="A4" >
    <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
        
            <div style="width: 100%;font-size: 17px;">
                <p style="font-weight: bold;text-align: center;">
                    PERSETUJUAN UMUM<br>
                    (GENERAL CONSENT)
                </p>
            </div>
            
            <div style="font-size:13px">
                <p>1.<u>WAKTU PENDAFTARAN</u></p>	
                <p>
                    <table border="0" width="100%" style="margin-left:15px;font-size:13px">
                            <tr>
                                <td width="15%" ><span class="">Tanggal</span></span></td>
                                <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                                <td width="20%" ><span class=""><span class="text_isi"><?= (isset($data->question28->tgldaftarri)?$data->question28->tgldaftarri:'') ?></span></span></td>
                                <td width="10%"><span class="">Jam<span class="text_isi"></span></span></td>
                                <td width="3%" ><span class="">:</span></span></td>
                                <td width="20%"><span class=""><span class="text_isi"><?= (isset($data->question28->waktu)?$data->question28->waktu:'') ?></span></span></td>
                            </tr>
                            <tr> 
                                <td width="15%" ><span class="">Ruang Rawat</span></span></td>
                                <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                                <td width="30%">
                                    <span class="">
                                        <span class="text_isi"> 
                                            <?= (isset($data->question28->idrg)?$data->question28->idrg:'') ?>
                                            <?php
                                                if(!empty($pasien[0]['titip'])) {
                                                    echo '<b>(Titip)</b>';
                                                } 
                                            ?>
                                        </span>
                                    </span>
                                </td>
                                <td width="10%" ><span class="">Kelas</span></span></td>
                                <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                                <td width="20%">
                                    <span class="">
                                        <span class="text_isi">
                                            <?= (isset($data->question28->klsiri)?$data->question28->klsiri:'') ?>
                                            <?php
                                                if(!empty($pasien[0]['titip'])) {
                                                    echo '<b>(Titip)</b>';
                                                } 
                                            ?>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                    </table>
                </p>
                <p>2.<u>DATA UMUM</u></p>
                <p style="margin-left: 15px;">
                    <span>Penanggung Jawab Pasien</span>
                </p>
                <p style="margin-left: 15px;">
                    <table border="0" width="100%" style="margin-left:15px;font-size:13px">
                        <tr>
                            <td width="30%" ><span class="">Nama</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="75%" ><span class=""><?= (isset($data->question23->nama)?$data->question23->nama:'') ?></span></span></td>
                        </tr>
                        <tr>
                            <td width="30%" ><span class="">Tanggal Lahir</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="75%" ><span class=""><?= (isset($data->question23->tgl_lahir)?date('d-m-Y',strtotime($data->question23->tgl_lahir)):'') ?></td>
                        </tr>
                        <tr>
                            <td width="30%" ><span class="">Hubungan dengan Pasien</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="75%" ><span class=""><?= (isset($data->question23->hub)?$data->question23->hub:'') ?></td>
                        </tr>
                        <tr>
                            <td width="30%" ><span class="">Alamat Tempat Tinggal</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="75%" ><span class=""><?= (isset($data->question23->alamat)?$data->question23->alamat:'') ?></td>
                        </tr>
                        <tr>
                            <td width="30%" ><span class="">No Telepon / HP</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="75%" ><span class=""><?= (isset($data->question23->no_hp)?$data->question23->no_hp:'') ?></td>
                        </tr>
                        <tr>
                            <td width="30%" ><span class="">Cara Bayar</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="75%" ><span class=""><?= (isset($data->carabayar)?$data->carabayar:'')?></td>
                        </tr>
                    </table>
                </p>
                <p>3.<u>PENGOBATAN DAN HASIL YANG DIHARAPKAN</u></p>
                <p style="margin-left: 15px;text-align:justify;">
                    Saya mengetahui bahwa saya memiliki kondisi yang membutuhkan pemeriksaan dan tindakan  medis.<br>
                    Saya sadar dan mengakui bahwa setiap pemeriksaan dan tindakan medis yang dilakukan terhadap saya tidak akan selalu memberikan hasil sesuai yang diharapkan.
                    Saya mengizinkan dokter dan profesional lainnya untuk melakukan pemeriksaan dan tindakan medis yang meliputi : pemeriksaan radiologi, pemeriksaan laboratorium, pemasangan infus, pemasangan kateter urine, pemasangan NGT, pemberian obat oral, supposituria dan suntikan, kecuali tindakan yang memerlukan persetujuan khusus.
                </p>

                <p>4.<u>PELEPASAN INFORMASI</u></p>
                <p style="margin-left: 15px;text-align:justify;">
                A.	Saya memahami informasi yang ada di dalam diri saya, termasuk diagnosa,hasil pemeriksaan laboratorium dan hasil pemeriksaan diagnostik yang akan digunakan selama perawatan saya dan akan dijamin kerahasiaannya oleh Rumah Sakit.<br>
                B.	Saya memberi wewenang kepada Rumah Sakit untuk memberikan informasi dan data medis saya bila diperlukan untuk proses klaim  BPJS, Asuransi Kesehatan lain dan kepentingan perusahaan dan atau lembaga pemerintah lainnya sesuai aturan yang berlaku.<br>
                C.	Saya mengetahui dan menyetujui bahwa berdasarkan Peraturan Menteri Kesehatan Nomor 24 Tahun 2022 tentang Rekam Medis, fasilitas pelayanan Kesehatan wajib membuka akses dan mengirim data rekam medis kepada Kementerian Kesehatan melalui Platform SATUSEHAT” dan “ Menyetujui untuk menerima dan membuka data pasien  dari Fasilitas Pelayanan Kesehatan lainnya melalui SATUSEHAT untuk kepentingan pelayanan Kesehatan dan/atau rujukan

                </p>
                <p>5.<u>PERMINTAAN PRIVASI </u></p>
                    <p style="margin-left: 15px;"><b>A. Bila tidak ada permintaan privasi khusus</b><br>
                    Saya mengizinkan Rumah Sakit memberi akses kepada keluarga dan handai taulan serta orang-orang yang akan menemui saya selama perawatan sesuai aturan Rumah Sakit.
                    </p>

               
            </div><br><br><br><br><br><br>

            <div style="display:flex;font-size:12px;">
                <div>
                    Hal 1 dari 2
                </div>
                <div style="margin-left:480px">
                <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </div>
           </div>
    </div>
</body>
        
<body class="A4">
    <div  class="A4 sheet  padding-fix-10mm"><br>
        <header>
            <?php $this->load->view('emedrec/ri/header_print_genap') ?>
        </header>
        <div style="width: 100%;font-size: 17px;">  
            <p style="font-weight: bold;text-align: center;">
                 PERSETUJUAN UMUM<br>
                (GENERAL CONSENT)
            </p>
        </div>
        <div style="margin-left: 20px;font-size:12px">
            
                <p style="text-align:justify;">
                    <span style="font-weight: bold;margin-left: 15px;">B. Bila ada permintaan privasi khusus :</span>
                    <ol>
                        <li>Saya mengizinkan  Rumah Sakit memberi akses <b>hanya </b>kepada nama-nama yang tertulis di bawah ini untuk menemui saya selama perawatan :
                        <ol>
                    <li><?= (isset($data->question10)?$data->question10:'') ?></li>
                    <li><?= (isset($data->question24)?$data->question24:'') ?></li>
                    <li><?= (isset($data->question25)?$data->question25:'') ?></li>
                </ol>
                    </li>
                    <li>Harapan lain <?= isset($data->harapan)?$data->harapan:'' ?></li>
                    </ol>
                </p>
                <div style="min-height:2px"></div>
               
                
        </div>
        <div style="font-size:12px">
                <p>6.<u>BARANG BERHARGA MILIK PRIBADI</u></p>
                <p style="margin-left: 15px;text-align:justify;">
                    Saya sudah mendapatkan informasi tentang kebijakan Rumah Sakit berkaitan barang berharga milik pasien.
                    Saya setuju untuk tidak membawa dan menyimpan barang berharga dan barang-barang lainnya diluar ketentuan 
                    Rumah Sakit selama perawatan. Saya menyetujui bahwa apabila saya membawa dan menyimpan barang-barang tersebut,
                    maka Rumah Sakit tidak bertanggung jawab terhadap kehilangan,kerusakan atau pencurian.
                </p>

                <p>7.<u>INFORMASI BIAYA</u></p>
                <p style="margin-left: 15px;text-align:justify;">
                    Saya sudah mendapatkan informasi biaya yang akan saya tanggung selama perawatan di Rumah Sakit.
                    Saya setuju baik sebagai wali/penanggung jawab atau sebagai pasien untuk membayar biaya perawata
                    saya sesuai ketentuan yang berlaku di Rumah Sakit Otak DR. Drs. M.Hatta Bukittinggi.
                </p>

                <p>8.<u>TATA TERTIB RUMAH SAKIT</u></p>
                <p style="margin-left: 15px;text-align:justify;">
                    Saya sudah mendapatkan informasi tentang tata tertib yang berlaku di Rumah Sakit Otak DR. Drs. M.Hatta Bukittinggi.
                    Saya setuju untuk mematuhi semua ketentuan yang diatur dalam tata tertib Rumah Sakit Otak DR. Drs. M.Hatta Bukittinggi selama perawatan saya.
                </p>

                <p>9.<u>HAK DAN KEWAJIBAN PASIEN</u></p>
                <p style="margin-left: 15px;text-align:justify;">
                Saya sudah mendapatkan informasi tentang hak dan kewajiban saya sebagai pasien di Rumah Sakit Otak DR. Drs. M.Hatta Bukittinggi. Saya setuju untuk mematuhi semua ketentuan yang tertuang dalam hak dan kewajiban pasien tersebut
                </p>

                <p>10.<u>KEIKUTSERTAAN PESERTA DIDIK</u></p>
                <p style="margin-left: 15px;text-align:justify;">
                    Saya sudah mendapatkan informasi tentang keikutsertaan peserta didik/mahasiswa praktek dalam pelayanan di Rumah Sakit Otak DR. Drs. M.Hatta Bukittinggi.
                    Saya setuju bila selama masa perawatan ada keterlibataan peserta didik/mahasiswa praktek
                    sesuai batas kewenangan dan ketentuan yang berlaku di Rumah Sakit.
                </p>

                <p>11.<u>PERNYATAAN</u></p>
                <p style="margin-left: 15px;text-align:justify;">
                    Saya telah memahami dan sepenuhnya setuju dengan setiap pernyataan yang terdapat 
                    dalam formulir ini dan menandatangai dengan kesadaran penuh tanpa paksaan.
                </p>

                <!-- <p>12.<u>PERNYATAAN</u></p>
                <p style="margin-left: 15px;">
                    Saya telah memahami dan sepenuhnya setuju dengan setiap pernyataan yang terdapat 
                    dalam formulir ini dan menandatangai dengan kesadaran penuh tanpa paksaan.
                </p> -->
                <div style="min-height:220px">
                    <div style="display: inline; position: relative;">
                        <div style="float: left;">
                            <p>Bukittinggi,<?= isset($general_consent[0]->tgl_input)? date('d-m-Y',strtotime($general_consent[0]->tgl_input)):''; ?></p>
                            <p>Pasien/Penanggung Pasien</p>
                            <?php 
                            if($showttd != "1"){
                            ?>
                                <img style="margin-left:5em;" src="<?= isset($data->ttd_pasien)?$data->ttd_pasien:''; ?>" width="120px" height="120px" alt=""><br>  
                                <center><span><?= (isset($data->question23->nama)?$data->question23->nama:'') ?></span></center>      
                            <?php }else{ ?>
                                <br><br><br><br><br><br><br><br>
                                <center><span><?= (isset($data->question23->nama)?$data->question23->nama:'') ?></span></center>      
                            <?php } ?>
                        </div>

                        <div style="float: right;">
                            <br><br>
                            <p>Petugas Rumah Sakit</p>
                            <img  src="<?= (isset($general_consent[0]->ttd_pemeriksa)?$general_consent[0]->ttd_pemeriksa:'')?>" width="120px"  height="120px" alt=""><br>  
                            <center><span><?= (isset($general_consent[0]->nm_pemeriksa)?$general_consent[0]->nm_pemeriksa:'') ?></span></center>           
                        </div>
                    </div> 
                </div>   
        </div>
        
            <div style="display:flex;font-size:12px;">
                <div>
                    Hal 2 dari 2
                </div>
                <div style="margin-left:480px">
                <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </div>
           </div>
    </div>
 
    </body>
   
</html>