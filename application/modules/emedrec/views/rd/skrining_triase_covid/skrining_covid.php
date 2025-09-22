<?php 
$data = (isset($skrining_covid[0]->formjson))?json_decode($skrining_covid[0]->formjson):'';
// var_dump($skrining_covid[0]);
?>

<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
            
        }

        #data tr td{
            
            font-size: 12px;
            text-align:center;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
        <body class="A4" >

            <div class="A4 sheet  padding-fix-10mm">
                <header>
                    <?php $this->load->view('emedrec/rj/header_print') ?>
                </header>

                <p align="center" style="font-weight:bold;font-size:16px">
                    <span>SKRINING TRIASE / POLIKLINIK</span><br>
                    <span>PASIEN COVID-19</span>
                </p>

                <div style="font-size:12px">
                <table width="60%">
                    <tr>
                        <td width="25%">Alamat</td>
                        <td width="5%">:</td>
                        <td width="30%"><?= isset($data->identitas->alamat)?$data->identitas->alamat:'' ?></td>
                    </tr>
                    <tr>
                        <td width="25%"><p>Tanggal Pemeriksaan</p></td>
                        <td width="5%"><p>:</p></td>
                        <td width="30%"><p><?= isset($data->identitas->tanggal)?date('d-m-Y',strtotime($data->identitas->tanggal)):'' ?></p></td>
                    </tr>
                </table>

                <table width="100%" border="1">
                    <tr>
                        <td width="10%" colspan="2" style="text-align:center;background-color:yellow">ODP</td>
                        <td width="20%" colspan="2" style="text-align:center;background-color:red">PDP</td>
                        <td width="10%" colspan="2" style="text-align:center;background-color:blue">OTG</td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->odp)?$data->table_skrining[0]->odp == 'demam'?'√':'':'') ?></td>
                        <td width="20%">Demam >38°C</td>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->pdp)?$data->table_skrining[0]->pdp == 'demam'?'√':'':'') ?></td>
                        <td width="20%">Demam >38°C</td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->odp)?$data->table_skrining[0]->odp == 'batuk'?'√':'':'') ?></td>
                        <td width="20%">Batuk</td>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->pdp)?$data->table_skrining[0]->pdp == 'batuk'?'√':'':'') ?></td>
                        <td width="20%">Batuk</td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->odp)?$data->table_skrining[0]->odp == 'pilek'?'√':'':'') ?></td>
                        <td width="20%">Pilek</td>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->pdp)?$data->table_skrining[0]->pdp == 'pilek'?'√':'':'') ?></td>
                        <td width="20%">Pilek</td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->odp)?$data->table_skrining[0]->odp == 'nyeri_tenggorokan'?'√':'':'') ?></td>
                        <td width="20%">Nyeri tenggorokan</td>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->pdp)?$data->table_skrining[0]->pdp == 'nyeri_tenggorokan'?'√':'':'') ?></td>
                        <td width="20%">Nyeri tenggorokan</td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="10%"><br></td>
                        <td width="20%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="10%"></td>
                        <td width="20%"></td>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->pdp)?$data->table_skrining[0]->pdp == 'sesak_nafas_ringan'?'√':'':'') ?></td>
                        <td width="20%">Sesak nafas ringan (SaO2 > 93%)</td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="10%"></td>
                        <td width="20%"></td>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->pdp)?$data->table_skrining[0]->pdp == 'sesak_nafas_berat'?'√':'':'') ?></td>
                        <td width="20%">Sesak nafas berat (SaO2 ≤ 93%)</td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->odp)?$data->table_skrining[0]->odp == 'kontak_erat'?'√':'':'') ?></td>
                        <td width="20%">Kontak erat pasien COVID-19</td>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->pdp)?$data->table_skrining[0]->pdp == 'kontak_erat'?'√':'':'') ?></td>
                        <td width="20%">Kontak erat pasien COVID-19</td>
                        <td width="10%" style="text-align:center"><?= (isset($data->table_skrining[0]->otg)?$data->table_skrining[0]->otg == 'kontak_erat'?'√':'':'') ?></td>
                        <td width="20%">Kontak erat pasien COVID-19</td>
                    </tr>
                    <tr>
                        <td width="10%" colspan="6" style="background-color:black"><br></td>
                    </tr>
                    <tr>
                        <td width="10%" colspan="2" style="background-color:yellow">
                            <li>Isolasi diri dirumah</li>
                            <li>Pemeriksaan Spesimen</li>
                            <li>Fasyankes pemantauan 14 hari</li>
                            <li>Perburukan periksa kembali ke RS</li>
                        </td>
                        <td width="10%" colspan="2" style="background-color:yellow">
                            <p style="text-align:center">SaO2 > 93%</p>
                            <li>Isolasi diri dirumah</li>
                            <li>Pemeriksaan Spesimen</li>
                            <li>Fasyankes pemantauan 14 hari</li>
                            <li>Perburukan periksa kembali ke RS</li>
                        </td>
                        <td width="10%" colspan="2" style="background-color:yellow">
                            <li>Isolasi diri dirumah</li>
                            <li>Pemeriksaan Spesimen</li>
                            <li>Fasyankes pemantauan 14 hari</li>
                            <li>Perburukan periksa kembali ke RS</li>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2" style="background-color:red">
                            <p style="text-align:center">SaO2 ≤ 93%</p>
                            <li>Ruang Rawat Covid 19</li>
                            <li>Pemeriksaan Spesimen</li>

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                   
                </table>

                <p>Status Vaksinasi :</p>
                <input type="checkbox" value="ya" <?= (isset($data->status_vaksinasi)?$data->status_vaksinasi == 'belum_vaksin'?'checked':'':'') ?> ><span>Belum Vaksin</span>
                <input type="checkbox" value="ya" <?= (isset($data->status_vaksinasi)?$data->status_vaksinasi == 'dosis1'?'checked':'':'') ?>><span>Dosis 1</span>
                <input type="checkbox" value="ya" <?= (isset($data->status_vaksinasi)?$data->status_vaksinasi == 'dosis2'?'checked':'':'') ?>><span>Dosis 2</span>
                <input type="checkbox" value="ya" <?= (isset($data->status_vaksinasi)?$data->status_vaksinasi == 'dosis3'?'checked':'':'') ?>><span>Dosis 3</span>
                <input type="checkbox" value="ya" <?= (isset($data->status_vaksinasi)?$data->status_vaksinasi == 'dosis4'?'checked':'':'') ?>><span>Dosis 4</span><br><br>
                   
                <table width="100%">
                    <tr>
                        <td width="10%"><p>Cat :</p></td>
                        <td>
                            <ol>
                                <li>Wajib diisi bila melakukan rapid antigen</li>
                                <li>Pengisian dengan ceklist</li>
                                <li>Wajib menulis tanggal terakhir kontak</li>
                                <li>Kontak s/d pemeriksaan dihitung dari hari terakhir riwayat kontak hingga tangal pemeriksaan saat ini.</li>
                                <li>Rapid antigen tidak perlu diulang dalam waktu 48 jam</li>
                            </ol>
                            
                        </td>
                    </tr>
                </table><br><br><br><br><br>

                <table width="100%">
                    <tr>
                        <td width="60%"></td>
                        <td>
                            <p>Bukittinggi, <?= isset($data->identitas->tanggal)?date('d-m-Y',strtotime($data->identitas->tanggal)):'' ?></p>
                            <span><img width="120px" src="<?= isset($skrining_covid[0]->ttd_pemeriksa)?$skrining_covid[0]->ttd_pemeriksa:'' ?>" alt=""></span><br>
                            <span><?= isset($skrining_covid[0]->name)?$skrining_covid[0]->name:'' ?></span>
                        </td>
                    </tr>
                </table>

                

                </div><br><br><br><br><br><br><br><br>
                <p style="text-align:left;font-size:12px">Hal 1 dari 1</p>
            </div>
        </body>
</html>