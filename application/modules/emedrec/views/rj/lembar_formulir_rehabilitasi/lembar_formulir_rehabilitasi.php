<?php 
$data = (isset($formulir_rehab->formjson)?json_decode($formulir_rehab->formjson):'');
// var_dump($data);
?>
<!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   <style>
        .hr{
           height:2px;
           background-color:black;
       }
       #data {
            margin-top: 5px;   
            font-size: 11px;
            position: relative;
            width:100%;
            
        }

        #data tr td{
            
            font-size: 11px;
            
        }
    </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
                <p align="center" style="font-weight:bold;">
                    <span>Lembar Formulir Rawat Jalan</span><br>
                    <span>Layanan Kedokteran Fisik dan Rehabilitasi</span>
                </p>
                <div style="font-size:12px">
                   
                    <table id="data" cellpadding="2px" border="1">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <p>
                                                <span>I. Diisi oleh Pasien / Peserta</span>
                                                <span style="margin-left:200px">No RM / Reg : <?= isset($formulir_rehab->no_register)?$formulir_rehab->no_register:'' ?></span>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                <table id="data" style="margin-left:20px">
                                    
                                    <tr>
                                        <td width="30%">Nama Pasien</td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->identitas[0]->nama)?$data->identitas[0]->nama:'' ?></td>
                                    </tr>

                                    <tr>
                                        <td width="30%"><p>Tanggal Lahir</p></td>
                                        <td width="2%"><p>:</p></td>
                                        <td><p><?= isset($data->identitas[0]->tgl)?$data->identitas[0]->tgl:'' ?></p></td>
                                    </tr>

                                    <tr>
                                        <td width="30%">Alamat</td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->identitas[0]->alamat)?$data->identitas[0]->alamat:'' ?></td>
                                    </tr>

                                    <tr>
                                        <td width="30%"><p>Telp / HP</p></td>
                                        <td width="2%"><p>:</p></td>
                                        <td><p><?= isset($data->identitas[0]->telp)?$data->identitas[0]->telp:'' ?></p></td>
                                    </tr>

                                    <tr>
                                        <td width="30%">Hubungan dengan Tertanggung</td>
                                        <td width="2%">:</td>
                                        <td>
                                            <input type="checkbox" id="islam" name="islam" value="" <?php echo isset($data->identitas[0]->hubungan)?($data->identitas[0]->hubungan == "suami_istri" ? "checked" : "disabled"):'';?>>
                                            <span>Suami / Istri</span>
                                            <input type="checkbox" id="islam" name="islam" value="" <?php echo isset($data->identitas[0]->hubungan)?($data->identitas[0]->hubungan == "anak" ? "checked" : "disabled"):'';?>>
                                            <span>Anak</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table id="data" cellpadding="2px" border="1">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <span>II. Diisi oleh Dokter SpKFR</span>
                                            <p>Tanggal Pelayanan : <?= isset($data->pelayanan_dokter[0]->tgl_pelayanan)?$data->pelayanan_dokter[0]->tgl_pelayanan:'' ?></p>
                                        </td>
                                    </tr>
                                </table>
                                <table id="data" style="margin-left:20px">
                                    <tr>
                                        <td width="35%"><li>Anamnesa</li></td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->pelayanan_dokter[0]->anamnesa)?$data->pelayanan_dokter[0]->anamnesa:'' ?></td>
                                    </tr>

                                    <tr>
                                        <td width="25%"><p><li>Pemeriksaan Fisik dan Uji Fungsi</li></p></td>
                                        <td width="2%"><p>:</p></td>
                                        <td><p><?= isset($data->pelayanan_dokter[0]->pemeriksaan_fisik)?$data->pelayanan_dokter[0]->pemeriksaan_fisik:'' ?></p></td>
                                    </tr>

                                    <tr>
                                        <td width="25%"><li>Diagnosis Medis (ICD-10)</li></td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->pelayanan_dokter[0]->diagnosis_medis)?$data->pelayanan_dokter[0]->diagnosis_medis:'' ?></td>
                                    </tr>

                                    <tr>
                                        <td width="25%"><p><li>Diagnosis Fungsi (ICD-10)</li></p></td>
                                        <td width="2%"><p>:</p></td>
                                        <td><p><?= isset($data->pelayanan_dokter[0]->diagnosis_fungsi)?$data->pelayanan_dokter[0]->diagnosis_fungsi:'' ?></p></td>
                                    </tr>

                                    <tr>
                                        <td width="25%"><li>Pemeriksaan Penunjang</li></td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->pelayanan_dokter[0]->pemeriksaan_penunjang)?$data->pelayanan_dokter[0]->pemeriksaan_penunjang:'' ?></td>
                                    </tr>

                                    <tr>
                                        <td width="25%"><p><li>Tata Laksana KFR (ICD 9 CM)</li></p></td>
                                        <td width="2%"><p>:</p></td>
                                        <td><p><?= isset($data->pelayanan_dokter[0]->tatalaksana)?$data->pelayanan_dokter[0]->tatalaksana:'' ?></p></td>
                                    </tr>

                                    <tr>
                                        <td width="25%"><li>Anjuran</li></td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->pelayanan_dokter[0]->anjuran)?$data->pelayanan_dokter[0]->anjuran:'' ?></td>
                                    </tr>

                                    <tr>
                                        <td width="25%"><p><li>Evaluasi</li></p></td>
                                        <td width="2%"><p>:</p></td>
                                        <td><p><?= isset($data->pelayanan_dokter[0]->evaluasi)?$data->pelayanan_dokter[0]->evaluasi:'' ?></p></td>
                                    </tr>

                                    <tr>
                                        <td width="25%"><li>Suspek Penyakit Akibat Kerja</li></td>
                                        <td width="2%">:</td>
                                        <td>
                                            <input type="checkbox" id="islam" name="islam" value="" <?php echo isset($data->pelayanan_dokter[0]->suspek_penyakit)?($data->pelayanan_dokter[0]->suspek_penyakit == "other" ? "checked" : "disabled"):'';?>>
                                            <span>Ya, (<?= isset($data->pelayanan_dokter[0]->{'suspek_penyakit-Comment'})?$data->pelayanan_dokter[0]->{'suspek_penyakit-Comment'}:'' ?>)</span><br>
                                            <input type="checkbox" id="islam" name="islam" value="" <?php echo isset($data->pelayanan_dokter[0]->suspek_penyakit)?($data->pelayanan_dokter[0]->suspek_penyakit == "tidak" ? "checked" : "disabled"):'';?>>
                                            <span>Tidak</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            
                        </tr>
                    </table><br>
                    <div style="min-height:350px">
                    <table id="data">
                        <tr>
                            <td width="60%">
                                <span>Tanda tangan Pasien</span>
                            </td>
                            <td>
                                <span>Tempat & Tanggal</span><br>
                                <span>Cap dan Tanda Tangan dr. SpKFR</span>
                            </td>
                        </tr>
                    </table>
                    </div>
                   
                </div>
              
            </div>
        </body>
    </html>