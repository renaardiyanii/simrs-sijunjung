<?php 
$data = isset($pengantar_ranap->formjson)?json_decode($pengantar_ranap->formjson):'';
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
                <h3>PERNYATAAN TINDAKAN HEMODIALISA</h3>
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
            <td colspan="2">(Diisi oleh Petugas)</td>
            <td >Halaman 1 dari 2</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
            <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td width="30%" >Ruang </td>
                    <td width="20%" > :</td>
                    <td width="30%" > </td>
                    <td width="20%" > </td>
                </tr>
                <tr>
                    <td width="30%" >Diagnosa Klinis  </td>
                    <td width="20%" >:</td>
                    <td width="30%" >Dokter DPJP</td>
                    <td width="20%" >:</td>
                </tr>
                <tr>
                    <td width="30%" >Tgl / HD Ke - </td>
                    <td width="20%" >:</td>
                    <td width="30%" ></td>
                    <td width="20%" ></td>
                </tr>
                
            </table>
            <p style="font-size: 14px;"><strong>Informasi Tindakan Hemodialisis</strong></p>
            <p style="font-size: 14px;">Pemberan Informasi : </p>
            <p style="font-size: 14px;">Penerima Informasi : </p>
            <table border="1" width="100%" cellpadding="2">
                <tr>
                    <td ><b><center>NO</center></b></td>
                    <td ><b><center>JENIS INFORMASI</center></b></td>
                    <td ><b><center>ISI INFORMASI</center></b></td>
                    <td ><b><center>JELAS </center></b></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Diagnosa & dasar diagnosa</td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>2</td>
                    <td>Tindakan kedokteran</td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>3</td>
                    <td>Indikasi Tindakan</td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>4</td>
                    <td>Tujuan</td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>5</td>
                    <td>Prognosis</td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>6</td>
                    <td>Kemungkinan komplikasi / Risiko</td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>7</td>
                    <td>Transfusi</td>
                    <td></td>
                    <td></td>
                   
                </tr>
                <tr>
                    <td>8</td>
                    <td>Reused filter</td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>9</td>
                    <td>Biaya</td>
                    <td></td>
                    <td></td>
                   
                </tr>
               
            </table>
            <p style="font-size: 12px;">Yang bertanda tangan dibawah ini saya sebagai WALI <input type="checkbox">Anak <input type="checkbox"> Istri <input type="checkbox"> Suami <input type="checkbox"> Lainnya :.......................dari nama pasien tersebut diatas</p>
            <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td width="40%" >1. Nama :</td>
                    <td width="60%" >3. Pekerjaan </td>
                </tr>
                <tr>
                    <td width="40%" >2. No KTP :</td>
                    <td width="60%"><input type="checkbox"> Laki laki <input type="checkbox"> Perempuan</td>
                </tr>
                <tr>
                    <td width="40%" >4. Alamat :</td>
                </tr>
            </table>
            <p style="font-size: 14px;"><strong><center>PERNYATAAN</center></strong></p>
            <p style="font-size: 12px; line-height: 1.6; margin-bottom: 10px;">
                Saya <input type="checkbox"><b>Menyetujui</b><input type="checkbox"><b>Menolak</b> tindakan hemodialisis dan <input type="checkbox"><b> Menyetujui </b> <input type="checkbox"><b> Menolak </b> dilakukan reuse ( pencucian ulang ) terhadap dialyzer ( ginjal buatan ) sebanyak ..... x, setelah menerima penjelasan dan diberi kesempatan untuk berdiskusi.</b>
            </p>
            <div style="display: flex; justify-content: space-between; width: 100%; text-align: center; margin-top: 20px;">
                <!-- Kolom Dokter -->
                <div style="width: 33%;">
                    <p>Dokter</p>
                    <p>...............................</p>
                    <p>Nama lengkap</p>
                </div>

                <!-- Kolom Petugas Saksi -->
                <div style="width: 33%;">
                    <p>Petugas Saksi</p>
                    <p>...............................</p>
                    <p>Nama lengkap</p>
                </div>

                <!-- Kolom Pasien/Keluarga -->
                <div style="width: 33%;">
                    <p>Tanah Badantuang, ..........................</p>
                    <p>Pasien/Keluarga</p>
                    <p>...............................</p>
                    <p>Nama lengkap</p>
                </div>
            </div>
                       
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.17.b4/RI-GN
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
                <h3>PERNYATAAN TINDAKAN HEMODIALISA</h3>
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
            <td colspan="2">(Diisi oleh Petugas)</td>
            <td >Halaman 2 dari 2</td>
            
        </tr>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
        <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="2">
                    <p style="font-size: 14px;"><strong><center>PERNYATAAN LANJUTAN HEMODIALISI</center></strong></p>
                    <tr>
                        <td width="30%" >Ruang </td>
                        <td width="70%" > :</td>
                    </tr>
                    <table border="1" width="100%" cellpadding="8">
                        <tr>
                            <td rowspan="2"><b><center>TANGGAL</center></b></td>
                            <td rowspan="2"><b><center>DIAGNOSA KLINIK</center></b></td>
                            <td rowspan="2"><b><center>ALASAN DATA</center></b></td>
                            <td rowspan="2"><b><center>PAKAI DIALYZER <br> REUSED(R) </center></b></td>
                            <td colspan="2"><b><center>TANDA TANGAN & NAMA </center></b></td>
                            <td rowspan="2"><b><center>KETERANGAN</center></b></td>
                        </tr>
                        <tr>
                            <td><b><center>PEMBERI <br> INFORMASI</center></b></td>
                            <td><b><center>SETUJU <br> MENOLAK PASIEN KEL....</center></b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </table>
                </tr>
                </table>
            </td>
        </tr>
    </table>
    <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.17.b4/RI-GN
                    </div>
               </div>
</div>
</body>

</html>