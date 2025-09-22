<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm"><br>
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <center>
                <p style="font-weight:bold;font-size:14px">
                    <span>Lembar Formulir Rawat Jalan</span><br>
                    <span>Layanan Kedokteran Fisik dan Rehabilitasi</span>
                </p>   
            </center>

            <div style="font-size:12px">
                <table width="100%" style="border:1px solid black" cellpadding="3px">
                    <tr>
                        <td colspan="2">
                            <span>I. Diisi oleh Pasien / Peserta</span>
                        </td>
                        <td>
                            <center><span>No RM / Reg : </span></center>
                        </td>
                    </tr>
                    <tr>
                        <td width="38%"><p style="margin-left:25px">Nama Pasien</p></td>
                        <td width="2%"><p>:</p></td>
                        <td><p></p></td>
                    </tr>
                    <tr>
                        <td><span style="margin-left:25px">Tanggal Lahir</span></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p style="margin-left:25px">Alamat</p></td>
                        <td><p>:</p></td>
                        <td><p></p></td>
                    </tr>
                    <tr>
                        <td><span style="margin-left:25px">Telp / HP</span></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p style="margin-left:25px">Hubungan dengan tertanggung</p></td>
                        <td><p>:</p></td>
                        <td><p>
                            <input type="checkbox"  value="suami" >
                            <span>Suami / Istri</span>

                            <input type="checkbox"  value="anak" style="margin-left:40px">
                            <span>Anak</span>
                        </p></td>
                    </tr>

                </table><br>

                <table width="100%" style="border:1px solid black" cellpadding="3px">
                    <tr>
                        <td colspan="3">II. Diisi oleh Dokter SpK.FR</td>
                    </tr>
                    <tr>
                        <td width="43%"><p>Tanggal Pelayanan</p></td>
                        <td width="2%"><p>:</p></td>
                        <td><p></p></td>
                    </tr>
                    <tr>
                        <td><li style="margin-left:25px">Anamnesa</li></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p><li style="margin-left:25px">Pemeriksaan Fisik dan Uji Fungsi</li></p></td>
                        <td><p>:</p></td>
                        <td><p></p></td>
                    </tr>
                    <tr>
                        <td><li style="margin-left:25px">Diagnosis Medis (ICD-10)</li></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p><li style="margin-left:25px">Diagnosis Fungsi (ICD-10)</li></p></td>
                        <td><p>:</p></td>
                        <td><p></p></td>
                    </tr>
                    <tr>
                        <td><li style="margin-left:25px">Pemeriksaan Penunjang</li></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p><li style="margin-left:25px">Tata Laksana KFR (ICD 9 CM)</li></p></td>
                        <td><p>:</p></td>
                        <td><p></p></td>
                    </tr>
                    <tr>
                        <td><li style="margin-left:25px">Anjuran</li></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p><li style="margin-left:25px">Evaluasi</li></p></td>
                        <td><p>:</p></td>
                        <td><p></p></td>
                    </tr>
                    <tr>
                        <td><li style="margin-left:25px">Suspek Penyakit Akibat Kerja</li></td>
                        <td>:</td>
                        <td>
                            <input type="checkbox"  value="ya" >
                            <span>Ya (.....)</span><br>

                            <input type="checkbox"  value="tidak" >
                            <span>Tidak</span>
                        </td>
                    </tr>
                </table><br>
                <div style="min-height:200px">
                <table width="100%">
                    <tr>
                        <td width="60%">
                            <p>
                                <span></span><br>
                                <span>Tanda Tangan Pasien</span>
                            </p>
                        </td>
                        <td width="40%">
                            <p>
                                <span>Tempat & Tanggal</span><br>
                                <span>Cap dan Tanda Tangan dr.SpKFR</span>
                            </p>
                        </td>
                    </tr>
  
                </table>
                </div>
                <p style="text-align:right;font-size:12px">1</p>
                
               
            </div>
           
        </div>

        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print_ganjil') ?>
            </header>
            <hr color="black">
            <center>
                <p style="font-weight:bold;font-size:14px">
                    <span>LEMBAR PROGRAM TERAPI</span>
                </p>   
            </center>
            <div style="font-size:12px">
                <table width="100%" style="border:1px solid black" cellpadding="3px">
                    <tr>
                        <td width="18%"><span>NO RM</span></td>
                        <td width="2%">:</td>
                        <td><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                    </tr>
                    <tr>
                        <td width="18%"><p>NAMA PASIEN</p></td>
                        <td width="2%"><p>:</p></td>
                        <td><p><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></p></td>
                    </tr>
                    <tr>
                        <td width="18%"><span>DIAGNOSIS</span></td>
                        <td width="2%">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="18%" colspan="3"><div style="min-height:100px"><p>PROGRAM TERAPI :</p></div></td>
                    </tr>
                

                </table>

                <table width="100%" border="1">
                    <tr>
                       
                        <th width="30%" rowspan="2" colspan="2">PROGRAM</th>
                        <th width="20%" rowspan="2">TANGGAL</th>
                        <th width="50%" colspan="3">TANDA TANGAN</th>   
                    </tr>
                    <tr>
                        <th>PASIEN</th>
                        <th>DOKTER</th>
                        <th>TERAPIS</th>   
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5%">2</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5%">3</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5%">4</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5%">5</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5%">6</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5%">7</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5%">8</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5%">9</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5%">10</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div style="min-height:400px">
                    <table width=100%>
                        <tr>
                            <td width="70%"></td>
                            <td>
                                <p>
                                    <span>Bukittinggi,</span><br>
                                    <span>DPJP</span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <p style="text-align:right;font-size:12px">2</p>

               
            </div>

            
           
        </div>

    </body>

</html>