<?php
$data = (isset($data_from_a->formjson)?json_decode($data_from_a->formjson):'');
//  var_dump($diagnosa_resume);
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
            
            font-size: 11px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">FORMULIR A –EVALUASI AWAL MPP</p>

            <div style="width: 100%;font-size: 12px;">
               
                <table width="100%">
                    <tr>
                        <td width="18%">Tanggal Masuk</td>
                        <td width="2%">:</td>
                        <td width="30%"><?= isset($data->tgl_masuk)?$data->tgl_masuk:'' ?></td>
                        <td width="18%">Diagnosa</td>
                        <td width="2%">:</td>
                        <td width="30%"><?php 
                        if(isset($data->diagnosa2) && $diagnosa_resume == null){
                            foreach($data->diagnosa2 as $diag){ ?>
                            - <?php echo $diag->item_diag.'('.$diag->ket.')' ?><br>
                       <?php  }
                       }else if(isset($data->diagnosa2) && $diagnosa_resume != null){
                            foreach($diagnosa_resume as $diag_resume){ ?>
                            - <?php echo $diag_resume->id_diagnosa.'-'.$diag_resume->diagnosa.'('.$diag_resume->klasifikasi_diagnos.')' ?><br>
                       <?php }}else{ 
                            echo isset($data->diagnosa)?$data->diagnosa:'';
                       }
                        
                        ?></td>
                    </tr>
                    <tr>
                        <td width="18%">Tanggal Keluar </td>
                        <td width="2%">:</td>
                        <td width="30%"><?= isset($data->tgl_keluar)?$data->tgl_keluar:'' ?></td>
                        <td width="18%"></td>
                        <td width="2%"></td>
                        <td width="30%"></td>
                    </tr>
                    <tr>
                        <td width="18%">Ruangan</td>
                        <td width="2%">:</td>
                        <td width="30%"><?= isset($data->ruangan)?$data->ruangan:'' ?></td>
                        <td width="18%">Tindakan</td>
                        <td width="2%">:</td>
                        <td width="30%"><?= isset($data->tindakan)?$data->tindakan:'' ?></td>
                    </tr>
                    <tr>
                        <td width="18%">Kelas Rawatan </td>
                        <td width="2%">:</td>
                        <td width="30%"><?= isset($data->kelas_rawatan)?$data->kelas_rawatan:'' ?></td>
                        <td width="18%"></td>
                        <td width="2%"></td>
                        <td width="30%"></td>
                    </tr>
                </table>

                <table id="data" border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan="5"><p>Nama MPP : <?= isset($data->nama_mpp)?$data->nama_mpp:'' ?></p></td>
                        <td colspan="4"><p>Tanda Tangan : </p>
                        <img  src="<?= (isset($data_from_a->ttd)?$data_from_a->ttd:'')?>" width="50px"  height="40px" alt="">
                    </td>
                    </tr>
                    <tr>
                        <th>Tanggal/Jam <br><?= isset($data->tgl_jam)? date('d-m-Y',strtotime($data->tgl_jam)):''; ?>/<?= isset($data->tgl_jam)? date('H:i',strtotime($data->tgl_jam)):''; ?></th>
                        <th colspan="8">Catatan</th>
                    </tr>
                    <tr>
                        <th colspan="9">Identifikasi /Skrining Pasien</th>
                    </tr>
                    <tr>
                        <th rowspan="14" style="width: 15%;"><p>Bila skor ditemukan 1 pada kriteria mayor dan total skor ≥ 15 pada kriteria minor, Maka dilakukan asesmen Management Pelayanan Pasien</p></th>
                        <th><p>No</p></th>
                        <th colspan="5"><p>Kriteria Penilaian</p></th>
                        <th><p>Nilai Acuan</p></th>
                        <th><p>Skor</p></th>
                    </tr>
                    <tr>
                        <td id="column01">1</td>
                        <td colspan="5">Pasien dengan Discharge Planning</td>
                        <td id="column01">0 - 1</td>
                        <td style="text-align:center"><?= isset($data->table_identitas->result->{'1'})?$data->table_identitas->result->{'1'}:'' ?></td>
                    </tr>
                    <tr>
                        <td id="column01">2</td>
                        <td colspan="5">Isu Sosial seperti terlantar, napi, tinggal sendiri, narkoba, krisis keluarga</td>
                        <td id="column01">0 - 1</td>
                        <td style="text-align:center"><?= isset($data->table_identitas->result->{'2'})?$data->table_identitas->result->{'2'}:'' ?></td>
                    </tr>
                    <tr>
                        <td id="column01">3</td>
                        <td colspan="5">Upaya bunuh diri</td>
                        <td id="column01">0 - 1</td>
                        <td style="text-align:center"><?= isset($data->table_identitas->result->{'3'})?$data->table_identitas->result->{'3'}:'' ?></td>
                    </tr>
                    <tr>
                        <td id="column01">4</td>
                        <td colspan="5">Potensi complain tinggi</td>
                        <td id="column01">0 - 1</td>
                        <td style="text-align:center"><?= isset($data->table_identitas->result->{'4'})?$data->table_identitas->result->{'4'}:'' ?></td>
                    </tr>
                    <tr>
                        <th colspan="7">TOTAL SKOR</th>
                        <th><?= isset($data->table_identitas->result->total_skor)?$data->table_identitas->result->total_skor:'' ?></th>
                    </tr>
                    <tr>
                        <th colspan="8">Identifikasi / Skrining Pasien Kategori Minor</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>KriteriaPenilaian</th>
                        <th>Nilai
                            Acuan
                            </th>
                        <th>Skor</th>
                        <th>No</th>
                        <th>KriteriaPenilaian</th>
                        <th>Nilai
                            Acuan
                            </th>
                        <th>Skor</th>
                    </tr>
                    <tr>
                        <td id="column01" style="width: 5%;">1</td>
                        <td style="width: 15%;">Usia</td>
                        <td id="column01" style="width: 5%;">0-3</td>
                        <td id="column01" style="width: 5%;text-align:center"><?= isset($data->table_kategori_minor->result->{'1'})?$data->table_kategori_minor->result->{'1'}:'' ?></td>
                        <td id="column01" style="width: 5%;">6</td>
                        <td style="width: 15%;">Riwayat gangguan mental</td>
                        <td id="column01" style="width: 5%;">0-3</td>
                        <td id="column01" style="width: 5%;text-align:center"><?= isset($data->table_kategori_minor->result->{'6'})?$data->table_kategori_minor->result->{'6'}:'' ?></td>
                    </tr>
                    <tr>
                        <td id="column01">2</td>
                        <td>Fungsi kognitif rendah</td>
                        <td id="column01">0-3</td>
                        <td id="column01" style="text-align:center"><?= isset($data->table_kategori_minor->result->{'2'})?$data->table_kategori_minor->result->{'2'}:'' ?></td>
                        <td id="column01">7</td>
                        <td>Sering masuk IGD, readmisi RS</td>
                        <td id="column01">0-3</td>
                        <td id="column01" style="text-align:center"><?= isset($data->table_kategori_minor->result->{'7'})?$data->table_kategori_minor->result->{'7'}:'' ?></td>
                    </tr>
                    <tr>
                        <td id="column01">3</td>
                        <td>penyakitkronis, katastropik, terminal, multiple DPJP</td>
                        <td id="column01">0-3</td>
                        <td id="column01" style="text-align:center"><?= isset($data->table_kategori_minor->result->{'3'})?$data->table_kategori_minor->result->{'3'}:'' ?></td>
                        <td id="column01">8</td>
                        <td>Perkiraan asuhan dengan biaya tinggi</td>
                        <td id="column01">0-3</td>
                        <td id="column01" style="text-align:center"><?= isset($data->table_kategori_minor->result->{'8'})?$data->table_kategori_minor->result->{'8'}:'' ?></td>
                    </tr>
                    <tr>
                        <td id="column01">4</td>
                        <td>Status fungsional rendah, kebutuhan ADL (activity daily living) yang tinggi</td>
                        <td id="column01">0-3</td>
                        <td id="column01" style="text-align:center"><?= isset($data->table_kategori_minor->result->{'4'})?$data->table_kategori_minor->result->{'4'}:'' ?></td>
                        <td id="column01">9</td>
                        <td>Kemungkinan system pembiayaan yang kompleks, adanya masalah finanasial</td>
                        <td id="column01">0-3</td>
                        <td id="column01" style="text-align:center"><?= isset($data->table_kategori_minor->result->{'9'})?$data->table_kategori_minor->result->{'9'}:'' ?></td>
                    </tr>
                    <tr>
                        <td id="column01">5</td>
                        <td>Riwayat penggunaan peralatan medis di masa lalu</td>
                        <td id="column01">0-3</td>
                        <td id="column01" style="text-align:center"><?= isset($data->table_kategori_minor->result->{'5'})?$data->table_kategori_minor->result->{'5'}:'' ?></td>
                        <td id="column01">10</td>
                        <td>Kasus yang melebihi rata-rata lama rawat</td>
                        <td id="column01">0-3</td>
                        <td id="column01" style="text-align:center"><?= isset($data->table_kategori_minor->result->{'10'})?$data->table_kategori_minor->result->{'10'}:'' ?></td>
                    </tr>
                    <tr>
                        <th colspan="7">TOTAL SKOR</th>
                        <th><?= isset($data->table_kategori_minor->result->total_skor)?$data->table_kategori_minor->result->total_skor:'' ?></th>
                    </tr>
                    <tr>
                        <th colspan="9">Asesmen untuk Manajemen Pelayanan Pasien</th>
                    </tr>
                    <tr style="height: 100px;">
                        <td><p></p></td>
                        <td colspan="8"><p><?= isset($data->asesment_managemen_pelayanan)?$data->asesment_managemen_pelayanan:'' ?></p></td>
                    </tr>
                    <tr>
                        <th colspan="9">Identifikasi Masalah – Resiko – Kesempatan</th>
                    </tr>
                    <tr style="height: 100px;">
                        <td><p></p></td>
                        <td colspan="8"><p><?= isset($data->identifikasi_masalah)?$data->identifikasi_masalah:'' ?></p></td>
                    </tr>
                    <tr>
                        <th colspan="9">Perencanaan Manajemen Pelayanan Pasien</th>
                    </tr>
                    <tr style="height: 100px;">
                        <td><p></p></td>
                        <td colspan="8"><p><?= isset($data->perencanaan_manajemen)?$data->perencanaan_manajemen:'' ?></p></td>
                    </tr>
                </table>
               
            
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>

             <hr color="black">

            <p align="center" style="font-weight:bold;font-size:16px">FORMULIR A –EVALUASI AWAL MPP</p>

            <table id="data" border="1" cellspacing="0" cellpadding="0">
                <tr>
                    <th colspan="2" style="width: 85%;">Kelanjutan Pelayanan Pasien</th>
                </tr>
                <tr style="height: 800px;">
                    <td style="width: 15%;"></td>
                    <td><?= isset($data->kelanjutan_pelayanan)?$data->kelanjutan_pelayanan:'' ?></td>
                </tr>
            </table>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

    </body>