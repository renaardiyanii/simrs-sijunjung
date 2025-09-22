<?php
foreach ($pemeriksaan_elektromedik as $data) {

    if ($data->mf_hasil != null) {
        $jsonf = json_decode($data->mf_hasil, TRUE);
    }else{}
    
    if($data->mb_hasil != null){
        $jsonb = json_decode($data->mb_hasil, TRUE);
    }else{}
    
    if($data->mc_hasil != null){
        $jsonc = json_decode($data->mc_hasil, TRUE);
    }else{}
    
    if($data->md_hasil != null){
        $jsond = json_decode($data->md_hasil, TRUE);
    }else{}
    
    if($data->ma_hasil != null){
        $jsona = json_decode($data->ma_hasil, TRUE);
    }else{}
    
    if($data->me_hasil != null){
        $jsone = json_decode($data->me_hasil, TRUE);
    }else{
        $json = '';
    }  

    $kode_jenis=$this->M_emedrec->get_data_hasil_em_pertindakan($data->id_pemeriksaan_em)->row()->kode_jenis;

    if(substr($no_register, 0,2)=="PL"){
        $data_pasien_tindak=$this->M_emedrec->get_data_pasien_luar_cetak($data->no_em)->row();
        $jenkel=$data_pasien_tindak->jk;
        
    } else {
        $data_pasien_tindak=$this->M_emedrec->get_data_pasien_cetak($data->no_em)->row();
        $umur=$this->M_emedrec->get_umur($data_pasien_tindak->no_medrec)->row()->umurday;
        $jenkel=$data_pasien_tindak->sex;				
    }
    if($jenkel=='L'){
        $jenis_kelamin = 'Laki - Laki';
    }else{
        $jenis_kelamin = 'Perempuan';
    }

    $id_dokter_reading = $this->M_emedrec->get_data_hasil_em_pertindakan($data->id_pemeriksaan_em)->row()->id_dokter;	
				
    $nama_dokter_reading = $this->M_emedrec->get_nama_dokter($id_dokter_reading)->row()->nm_dokter;
        
    // var_dump($kode_jenis);
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<!-- <link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet"> -->
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

    .text_sub_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        font-weight: bold;
    }

    .text_body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
    }

    .text_isi {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
        font-weight: bold;
    }

    .text_judul {
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

    .margin-left-3px {
        margin-left: 3px;
    }

    .margin-right-3px {
        margin-right: 3px;
    }

    .kotak {
        float: left;
        text-align: center;
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
        padding: 0px 10px;
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

    .center {
        width: 100%;
        margin: auto;
        text-align: center;
        /* background-color: aquamarine; */
    }

    td {
        line-height: 1.25;
        vertical-align: top;
        font-size: small;
    }

    header td {
        line-height: 1.5;
        vertical-align: top;
        font-size: small;
    }

    .padding-fix-10mm {
        padding-top: 0mm;
        padding-left: 10mm;
        padding-right: 10mm;
    }

    .table tr td {
        font-size: 8.5pt !important;
    }

    .hr {
        height: 2px;
        background-color: black;
    }

    .row {
        display: flex;
    }

    .row .text-body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
    }

    .row .text-sub_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        font-weight: bold;
    }

    table {
        border-collapse: collapse;
    }
</style>
<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
   <script>

// By using querySelector
        JsBarcode("#barcode", "Hi world!");
   </script>
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<?php if ($kode_jenis == 'MF') { ?>
    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <br><br>
            <table style="width: 100%;" border="0">
                    <tr>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_kesehatan_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                        <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:12px">
                                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:11px">
                                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                            </font>    
                            <br>
                            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                        </td>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                    </tr>
            </table>

            <header style="margin-top:20px; font-size:1pt!important;">
                <!-- <table border="0" width="100%">
                   
                
                    <tr>
                        <td width="15%"><span>Nama</span></td>
                        <td width="2%"><span>:</span></td>
                        <td width="50%"><span><?php echo isset($pasien->nama)?$pasien->nama:''; ?></span></td>
                        <td width="33%"></td>
                    </tr>
                    <tr>
                        <td><span>NIK</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_identitas)?$pasien->no_identitas:''; ?></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span>No. RM</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?></span></td>
                        <td><span>(<?php echo isset($pasien->sex)?$pasien->sex:''; ?>)</span></td>
                    </tr>
                    <tr>
                        <td><span>Tgl Lahir</span></td>
                        <td><span>:</span></td>
                        <td><span><?= isset($pasien->tgl_lahir)? date('d-m-Y',strtotime($pasien->tgl_lahir)):''; ?></span></td>
                        <td><span>
                        <svg class="barcode"
                        jsbarcode-format="code128"
                        jsbarcode-height="30"
                        jsbarcode-width="1"
                        jsbarcode-displayValue="false"
                        jsbarcode-value="<?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-margin="0"
                        jsbarcode-marginTop="5"
                        jsbarcode-marginRight="5"
                        jsbarcode-fontoptions="bold">
                        </svg>

                    <script>JsBarcode(".barcode").init();</script>
                        </span></td>
                    </tr>
                        </table> 
                    </td>
                    </tr>
                </table> -->
            </header>

            <hr color="black">

            <p style="font-size:16px" align="center"><b>
                    EMG-Report
            </b></p>
                <p align="right" style="font-size:14px"><?php echo $kota_header.','.$tgl ?></p>
                <br/>
            
                <table style="width: 100%;font-size:12px">
                    <tr>
                        <td style="width: 25%; font-size: 14px;line-height:50px"><p>Nama Pasien</p></td>
                        <td style="width: 75%; font-size: 14px;line-height:50px"><p> : <?= isset($data_pasien_tindak->nama)?$data_pasien_tindak->nama:'' ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;line-height:50px"><p>Medical Record</p></td>
                        <td style="font-size: 14px;line-height:50px"><p> : <?= isset($data->no_em)?$data->no_em:'' ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;line-height:50px"><p>Umur</p></td>
                        <td style="font-size: 14px;line-height:50px"><p> : <?= isset($umur)?$umur:'' ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;line-height:50px"><p>Alamat</p></td>
                        <td style="font-size: 14px;line-height:50px"><p> : <?= isset($data_pasien_tindak->kotakabupaten)?$data_pasien_tindak->kotakabupaten:'' ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;line-height:50px"><p>Dokter Ruangan</p></td>
                        <td style="font-size: 14px;line-height:50px"><p> : <?= isset($dokter_ruangan->nm_dokter)?$dokter_ruangan->nm_dokter:'' ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;line-height:50px"><p>Referring MD</p></td>
                        <td style="font-size: 14px;line-height:50px"><p> : <?= isset($pasien->dokter)?$pasien->dokter:'' ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;line-height:50px"><p>Reading MD</p></td>
                        <td style="font-size: 14px;line-height:50px"><p> : <?= isset($pasien->dokter)?$pasien->dokter:'' ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;line-height:50px"><p>Data</p></td>
                        <td style="font-size: 14px;line-height:50px"><p> : <?php echo $jsonf['mf_data']; ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;line-height:50px"><p>Kesan</p></td>
                        <td style="font-size: 14px;line-height:50px"><p> : <?php echo $jsonf['mf_kesan']; ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;line-height:50px"><p>Kesimpulan</p></td>
                        <td style="font-size: 14px;line-height:50px"><p> : <?php echo $jsonf['mf_kesimpulan']; ?></p></td>
                    </tr>
                </table>

        </div>
    </body>
<?php }elseif($kode_jenis == 'MB'){ ?>
    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <br><br>
            <table style="width: 100%;" border="0">
                    <tr>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_kesehatan_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                        <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:12px">
                                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:11px">
                                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                            </font>    
                            <br>
                            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                        </td>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                    </tr>
            </table>

            <header style="margin-top:20px; font-size:1pt!important;">
                <!-- <table border="0" width="100%">
                    <tr>                    
                            <td>
                                <table class="table_nama" width="100%" cellspacing="1" cellpadding="0">
                                <tr>
                    </tr>
              
                    <tr>
                        <td width="35%"><span class="text_body">Nama</span></td>
                        <td width="5%"><span class="text_body">:</span></td>
                        <td width="60%"><span class="text_isi"> <?= isset($data_pasien_tindak->nama)?$data_pasien_tindak->nama:'' ?></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="35%"><span class="text_body">NIK</span></td>
                        <td width="5%"><span class="text_body">:</span></td>
                        <td width="60%"><span class="text_isi"> <?= isset($data_pasien_tindak->no_identitas)?$data_pasien_tindak->no_identitas:'' ?></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="18%"><span class="text_body">No. RM</span></td>
                        <td width="2%"><span class="text_body">:</span></td>
                        <td width="50%"><span class="text_isi"> <?= isset($data_pasien_tindak->no_cm)?$data_pasien_tindak->no_cm:'' ?></span></td>
                        <td width="30%"><span class="text_isi">( <?= isset($data_pasien_tindak->sex)?$data_pasien_tindak->sex:'' ?> )</span></td>
                    </tr>
                    <tr>
                        <td width="18%"><span class="text_body">Tgl Lahir</span></td>
                        <td width="2%"><span class="text_body">:</span></td>
                        <td width="50%"><span class="text_isi"> <?= isset($data_pasien_tindak->tgl_lahir)?$data_pasien_tindak->tgl_lahir:'' ?></span></td>
                        <td width="30%"><span class="text_isi">
                        <svg class="barcode"
                        jsbarcode-format="code128"
                        jsbarcode-height="30"
                        jsbarcode-width="1"
                        jsbarcode-displayValue="false"
                        jsbarcode-value="<?= $data_pasien_tindak->no_cm; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-margin="0"
                        jsbarcode-marginTop="5"
                        jsbarcode-marginRight="5"
                        jsbarcode-fontoptions="bold">
                        </svg>

                    <script>JsBarcode(".barcode").init();</script>
                        </span></td>
                    </tr>
               
                        </table> 
                    </td>
                    </tr>
                </table> -->
            </header>
            <hr color="black">
            
            <h3 align="center"><b>
                EEG-REPORT
            </b></h3>
            <h3 align="center"><b>
                PATIENT INFORMATION
            </b></h3>
            <br/>
           
            <table style="width: 100%;">
                <tr>
                    <td style="width: 25%;line-height: 1;"><p>Patient</p></td>
                    <td style="width: 75%;line-height: 1;"><p> : <?= $data_pasien_tindak->nama ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Date of birth</p></td>
                    <td style="line-height: 1;"><p> : <?= date('d F Y',strtotime($data_pasien_tindak->tgl_lahir)); ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>EEG-Recording</p></td>
                    <td style="line-height: 1;"><p> : <?= $data->no_em ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Date of Recording</p></td>
                    <td style="line-height: 1;"><p> : <?= date('d F Y',strtotime($data_pasien_tindak->tgl_kunjungan)); ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Alamat</p></td>
                    <td style="line-height: 1;"><p> : <?= $data_pasien_tindak->kotakabupaten ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Dokter Ruangan</p></td>
                    <td style="line-height: 1;"><p> : <?= isset($dokter_ruangan->nm_dokter)?$dokter_ruangan->nm_dokter:'' ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Referring MD</p></td>
                    <td style="line-height: 1;"><p> : <?= $nama_dokter_reading ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Reading MD</p></td>
                    <td style="line-height: 1;"><p> : <?= $nama_dokter_reading ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Previous EEG</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $jsonb['mb_pre_eeg']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>History</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $jsonb['mb_history']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>HV Effort</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $jsonb['mb_hve']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Photic Diving Response</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $jsonb['mb_pdr']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Tech Comments</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $jsonb['mb_tech_comment']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Technologist</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $jsonb['mb_technologist']; ?> </p></td>
                </tr>
            </table>

            <h3 align="center"><b>
                INTERPRETATION
            </b></h3>
            <p style="line-height: 1;color:#525c95;"><?php echo $jsonb['mb_interpretation']; ?></p>
            <p style="line-height: 1;color:#525c95;">KESAN : <?php echo $jsonb['mb_kesan']; ?></p>

            <table style="width: 100%;">
                <tr>
                    <td style="width: 25%;line-height: 1;"><p>Physician Signature</p></td>
                    <td style="width: 75%;line-height: 1;"><p> : <?= $nama_dokter_reading ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Date Dictated</p></td>
                    <td style="line-height: 1;"><p> : <?= $data->tanggal_isi ?></p></td>
                </tr>
            </table>
            
        </div>    
    </body>
<?php }elseif($kode_jenis == 'MC'){ ?>
    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <br><br>
            <table style="width: 100%;" border="0">
                    <tr>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_kesehatan_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                        <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:12px">
                                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:11px">
                                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                            </font>    
                            <br>
                            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                        </td>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                    </tr>
            </table>

            <header style="margin-top:20px; font-size:1pt!important;">
                <!-- <table border="0" width="100%">
                   
                
                    <tr>
                        <td width="15%"><span>Nama</span></td>
                        <td width="2%"><span>:</span></td>
                        <td width="50%"><span><?php echo isset($pasien->nama)?$pasien->nama:''; ?></span></td>
                        <td width="33%"></td>
                    </tr>
                    <tr>
                        <td><span>NIK</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_identitas)?$pasien->no_identitas:''; ?></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span>No. RM</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?></span></td>
                        <td><span>(<?php echo isset($pasien->sex)?$pasien->sex:''; ?>)</span></td>
                    </tr>
                    <tr>
                        <td><span>Tgl Lahir</span></td>
                        <td><span>:</span></td>
                        <td><span><?= isset($pasien->tgl_lahir)? date('d-m-Y',strtotime($pasien->tgl_lahir)):''; ?></span></td>
                        <td><span>
                        <svg class="barcode"
                        jsbarcode-format="code128"
                        jsbarcode-height="30"
                        jsbarcode-width="1"
                        jsbarcode-displayValue="false"
                        jsbarcode-value="<?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-margin="0"
                        jsbarcode-marginTop="5"
                        jsbarcode-marginRight="5"
                        jsbarcode-fontoptions="bold">
                        </svg>

                    <script>JsBarcode(".barcode").init();</script>
                        </span></td>
                    </tr>
                        </table> 
                    </td>
                    </tr>
                </table> -->
            </header>

            <hr color="black">
            
            <table style="width: 100%;">
                <tr>
                    <td align="left" style="width: 50%;line-height: 1;"><b><p>Patient : <?php echo isset($pasien->nama)?$pasien->nama:''; ?></p></b><br></td>
                    <td align="right" style="width: 50%;line-height: 1;"><b>
                        <p>Referred by : <?php echo isset($pasien->dokter)?$pasien->dokter:''; ?></p>
                        <p>Dokter Ruangan : <?php echo isset($dokter_ruangan->nm_dokter)?$dokter_ruangan->nm_dokter:''; ?></p>
                    </b></td>
                </tr>
                <tr>
                    <td align="left" style="line-height: 1;"><b><p>Examinated by :<?php echo isset($pasien->dokter)?$pasien->dokter:''; ?></p></b></td>
                    <td align="right" style="line-height: 1;"><p><b><?= ($pemeriksaan_elektromedik)?$pemeriksaan_elektromedik[0]->tgl_kunjungan?date('d-m-Y',strtotime($pemeriksaan_elektromedik[0]->tgl_kunjungan)):'-':'-' ?></b></p><br></td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="line-height: 1;"><p><b>Protocol name : <?= $data->jenis_tindakan ?></b></p></td>
                </tr>
            </table><br>
            
                <p style="font-size:13px;font-weight:bold">Deskripsi : </p>
                <p style="line-height: 1;margin-left: 15px;font-size:13px"><?php echo $jsonc['mc_deskripsi']; ?></p>
            
                <p style="font-size:13px;font-weight:bold">Note : </p>
                <p style="line-height: 1;margin-left: 15px;font-size:13px"><?php echo $jsonc['mc_note']; ?></p>
            
                <p style="font-size:13px;font-weight:bold">Kesimpulan : </p>
                <p style="line-height: 1;margin-left: 15px;font-size:13px"><?php echo $jsonc['mc_kesimpulan']; ?></p>
            
        </div>    
    </body>
<?php }elseif($kode_jenis == 'MD'){ ?>
    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <br><br>
            <table style="width: 100%;" border="0">
                    <tr>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_kesehatan_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                        <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:12px">
                                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:11px">
                                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                            </font>    
                            <br>
                            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                        </td>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                    </tr>
            </table>

            <header style="margin-top:20px; font-size:1pt!important;">
                <!-- <table border="0" width="100%">
                   
                
                    <tr>
                        <td width="15%"><span>Nama</span></td>
                        <td width="2%"><span>:</span></td>
                        <td width="50%"><span><?php echo isset($pasien->nama)?$pasien->nama:''; ?></span></td>
                        <td width="33%"></td>
                    </tr>
                    <tr>
                        <td><span>NIK</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_identitas)?$pasien->no_identitas:''; ?></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span>No. RM</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?></span></td>
                        <td><span>(<?php echo isset($pasien->sex)?$pasien->sex:''; ?>)</span></td>
                    </tr>
                    <tr>
                        <td><span>Tgl Lahir</span></td>
                        <td><span>:</span></td>
                        <td><span><?= isset($pasien->tgl_lahir)? date('d-m-Y',strtotime($pasien->tgl_lahir)):''; ?></span></td>
                        <td><span>
                        <svg class="barcode"
                        jsbarcode-format="code128"
                        jsbarcode-height="30"
                        jsbarcode-width="1"
                        jsbarcode-displayValue="false"
                        jsbarcode-value="<?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-margin="0"
                        jsbarcode-marginTop="5"
                        jsbarcode-marginRight="5"
                        jsbarcode-fontoptions="bold">
                        </svg>

                    <script>JsBarcode(".barcode").init();</script>
                        </span></td>
                    </tr>
                        </table> 
                    </td>
                    </tr>
                </table> -->
            </header>
            <hr color="black">
            
            <h3 align="center"><b>
                PEMERIKSAAN ECHOCARDIOGRAPHY
            </b></h3>
            <!-- <p style="font-size:12px">Dokter Ruangan : <?php //isset($dokter_ruangan->nm_dokter)?$dokter_ruangan->nm_dokter:'' ?></p> -->
            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td colspan="2"><b>IDENTIFICATION</b></td>
                </tr>
                <tr>
                    <td style="width: 25%;">Name</td>
                    <td style="width: 40%;"><?= $data_pasien_tindak->nama ?></td>
                    <td style="width: 35%;">Ruang : <?php echo isset($pasien->idrg)?$pasien->idrg:''; ?></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><?= 'mk' ?></td>
                    <td>Jaminan : <?php echo isset($pasien->nmkontraktor)?$pasien->nmkontraktor:''; ?></td>
                </tr>
                <tr>
                    <td>Medical Record No.</td>
                    <td><?= $data->no_em ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>No Echo Video</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Date of Investigation</td>
                    <td><?= isset($data->tgl_kunjungan)?date('d F Y',strtotime($data->tgl_kunjungan)):'' ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>CLINICAL DIAGNOSIS</td>
                    <td><?= isset($pasien->nm_diagmasuk)?$pasien->nm_diagmasuk:'' ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td colspan="4"><b>MEASUREMENTS</b></td>
                </tr>
                <tr>
                    <td style="width: 25%;">Aorta</td>
                    <td style="width: 25%;"> <?php echo $jsond['md_aorta']; ?></td>
                    <td style="width: 25%;">LV EDD</td>
                    <td style="width: 25%;"> <?php echo $jsond['md_lv_edd']; ?></td>
                </tr>
                <tr>
                    <td>Left Atrium</td>
                    <td> <?php echo $jsond['md_left_atrium']; ?></td>
                    <td>LV ESD</td>
                    <td> <?php echo $jsond['md_lv_esd']; ?></td>
                </tr>
                <tr>
                    <td>Ejection Fraction</td>
                    <td> <?php echo $jsond['md_ejection_fraction']; ?></td>
                    <td>IVSD</td>
                    <td> <?php echo $jsond['md_ivsd']; ?></td>
                </tr>
                <tr>
                    <td>EPSS</td>
                    <td> <?php echo $jsond['md_epss']; ?></td>
                    <td>IVSS</td>
                    <td> <?php echo $jsond['md_ivss']; ?></td>
                </tr>
                <tr>
                    <td>RV Dimension</td>
                    <td> <?php echo $jsond['md_rv_dimension']; ?></td>
                    <td>LVPW Diastolic</td>
                    <td> <?php echo $jsond['md_lvpw_diastolic']; ?></td>
                </tr>
                <tr>
                    <td>LAVI</td>
                    <td> <?php echo $jsond['md_lavi']; ?></td>
                    <td>TAPSE</td>
                    <td> <?php echo $jsond['md_tapse']; ?></td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td colspan="2"><b>DESCRIPTION</b></td>
                </tr>
                <tr>
                    <td style="width: 25%;">Dimensi Ruang Jantung</td>
                    <td style="width: 75%;"> <?php echo $jsond['md_dimensi_r_jantung']; ?></td>
                </tr>
                <tr>
                    <td>LVH</td>
                    <td> <?php echo $jsond['md_lvh']; ?></td>
                </tr>
                <tr>
                    <td>Kontaraktilitas LV</td>
                    <td> <?php echo $jsond['md_kontraktilitas_lv']; ?></td>
                </tr>
                <tr>
                    <td>Kontaraktilitas RV</td>
                    <td> <?php echo $jsond['md_kontraktilitas_rv']; ?></td>
                </tr>
                <tr>
                    <td>Analisis Segmental</td>
                    <td> <?php echo $jsond['md_analisis_segmental']; ?></td>
                </tr>
                <tr>
                    <td>K. Aorta</td>
                    <td> <?php echo $jsond['md_k_aorta']; ?></td>
                </tr>
                <tr>
                    <td>K. Mitral</td>
                    <td> <?php echo $jsond['md_k_mitral']; ?></td>
                </tr>
                <tr>
                    <td>K. Trikuspid</td>
                    <td> <?php echo $jsond['md_k_trikuspid']; ?></td>
                </tr>
                <tr>
                    <td>K. Pulmonal</td>
                    <td> <?php echo $jsond['md_k_pulmonal']; ?></td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td rowspan="2">Doppler</td>
                    <td>E/A : <?php echo $jsond['md_dop_ea']; ?></td>
                    <td>DT : <?php echo $jsond['md_dop_dt']; ?></td>
                    <td>E/e : <?php echo $jsond['md_dop_ee']; ?></td>
                </tr>
                <tr>
                    <td>Ao Vmax : <?php echo $jsond['md_dop_ao_vmax']; ?></td>
                    <td>MPAP : <?php echo $jsond['md_dop_mpap']; ?></td>
                    <td> <?php echo $jsond['md_dop']; ?></td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td>Other :  <?php echo $jsond['md_other']; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td><b>CONCLUSION</b></td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li>Dimensi Ruang Jantung <u><?php echo $jsond['md_dimensi_r_jantung']; ?></u></li>
                            <li>Kontaraktilitas LV  <u><?php echo $jsond['md_kontraktilitas_lv']; ?></u></li>
                            <li>Normakinetik Global  <u><?php echo $jsond['md_normakinetik_global']; ?></u></li>
                            <li>Katup - katup struktur dan fungsi  <u><?php echo $jsond['md_katup_struk_func']; ?></u></li>
                            <li>Droppler E/A  <u><?php echo $jsond['md_dop_ea']; ?></u></li>
                            <li>Regugitasi  <u><?php echo $jsond['md_regugitasi']; ?></u></li>
                        </ul>
                        Final Conclusion :  <?php echo $jsond['md_final_conclusion']; ?>
                    </td>
                </tr>
            </table>
            
        </div>    
    </body>
<?php }elseif($kode_jenis == 'MA'){ ?>
    <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
            <br><br>
            <table style="width: 100%;" border="0">
                    <tr>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_kesehatan_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                        <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:12px">
                                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:11px">
                                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                            </font>    
                            <br>
                            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                        </td>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                    </tr>
            </table>

            <header style="margin-top:20px; font-size:1pt!important;">
                <!-- <table border="0" width="100%">
                   
                
                    <tr>
                        <td width="15%"><span>Nama</span></td>
                        <td width="2%"><span>:</span></td>
                        <td width="50%"><span><?php echo isset($pasien->nama)?$pasien->nama:''; ?></span></td>
                        <td width="33%"></td>
                    </tr>
                    <tr>
                        <td><span>NIK</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_identitas)?$pasien->no_identitas:''; ?></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span>No. RM</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?></span></td>
                        <td><span>(<?php echo isset($pasien->sex)?$pasien->sex:''; ?>)</span></td>
                    </tr>
                    <tr>
                        <td><span>Tgl Lahir</span></td>
                        <td><span>:</span></td>
                        <td><span><?= isset($pasien->tgl_lahir)? date('d-m-Y',strtotime($pasien->tgl_lahir)):''; ?></span></td>
                        <td><span>
                        <svg class="barcode"
                        jsbarcode-format="code128"
                        jsbarcode-height="30"
                        jsbarcode-width="1"
                        jsbarcode-displayValue="false"
                        jsbarcode-value="<?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-margin="0"
                        jsbarcode-marginTop="5"
                        jsbarcode-marginRight="5"
                        jsbarcode-fontoptions="bold">
                        </svg>

                    <script>JsBarcode(".barcode").init();</script>
                        </span></td>
                    </tr>
                        </table> 
                    </td>
                    </tr>
                </table> -->
            </header>
            <hr color="black">
            
            <h3 align="center" style="font-size:13px"><b>
                INSTALASI RAWAT JALAN
            </b></h3>
            <h3 align="center" style="font-size:13px"><b>
                UDT
            </b></h3>
            <h3 align="center" style="font-size:13px"><b>
                HASIL USG
            </b></h3><br>
            <table border="0" width="100%">
                            <tr>
                                <td width="40%">
                                     <table border ="0" width ="100%">
                                         <tr >
                                             <td width="2%"></td>
                                             <td width="30%"><span>No. RM</td>
                                             <td width="3%"><span>:</td>
                                             <td width="65%"><span> <?php echo $data_pasien_tindak->no_cm; ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span>Nama</td>
                                             <td width="3%"><span>:</td>
                                             <td width="65%"><span><?php echo $data_pasien_tindak->nama; ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span>Tgl. Lahir </td>
                                             <td width="3%"><span>:</td>
                                             <td width="65%"><span><?php echo date('d F Y',strtotime($data_pasien_tindak->tgl_lahir)) ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span>Jenis Kelamin</td>
                                             <td width="3%"><span>:</td>
                                             <td width="65%"><span><?php echo $jenis_kelamin; ?></span></td>
                                         </tr>
                                     </table>
                                 </td>
                                 <td width="60%">
                                     <table border ="0" width ="100%">
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span>Ruang</span></td>
                                             <td width="3%"><span>:</span></td>
                                             <td width="65%"><span><?= isset($pasien->idrg)?$pasien->idrg:'' ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span>Tgl. Periksa</span></td>
                                             <td width="3%"><span>:</span></td>
                                             <td width="65%"><span><?= ($pemeriksaan_elektromedik)?$pemeriksaan_elektromedik[0]->tgl_kunjungan?date('d-m-Y',strtotime($pemeriksaan_elektromedik[0]->tgl_kunjungan)):'-':'-' ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span>Tgl. Hasil</span></td>
                                             <td width="3%"><span>:</span></td>
                                             <td width="65%"><span><?= $data->tanggal_isi ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span>Dokter Pengirim</span></td>
                                             <td width="3%"><span>:</span></td>
                                             <td width="65%"><span><?php echo isset($pasien->dokter)?$pasien->dokter:''; ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span>Dokter Ruangan</span></td>
                                             <td width="3%"><span>:</span></td>
                                             <td width="65%"><span><?php echo isset($dokter_ruangan->nm_dokter)?$dokter_ruangan->nm_dokter:''; ?></span></td>
                                         </tr>
                                     </table>
                                 </td>
                            </tr>
            </table><br><br>
            <p style="font-size:13px;font-weight:bold">Klinis :  <?php echo isset($pasien->nm_diagnosa)?$pasien->nm_diagnosa:''; ?></p>

            <p style="font-size:13px;font-weight:bold">
                <span>TS Yth</span><br>
                <span>Pemeriksaan Ultrasonografi Abdomen atas dengan transduser kurve.</span>
            </p>

            <p style="margin-left: 20px;font-size:13px">
                <?php echo $jsona['ma_isi']; ?> 
            </p>

            <p style="font-size:13px;font-weight:bold">Kesan : </p>
            
            <p style="margin-left: 20px;font-size:13px">
                <?php echo $jsona['ma_kesan']; ?> 
            </p> 
            
        </div>    
    </body>
<?php }elseif($kode_jenis == 'ME'){ ?>
    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <br><br>
            <table style="width: 100%;" border="0">
                    <tr>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_kesehatan_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                        <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:12px">
                                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:11px">
                                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                            </font>    
                            <br>
                            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                        </td>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                    </tr>
            </table>

            <header style="margin-top:20px; font-size:1pt!important;">
                <!-- <table border="0" width="100%">
                   
                
                    <tr>
                        <td width="15%"><span>Nama</span></td>
                        <td width="2%"><span>:</span></td>
                        <td width="50%"><span><?php echo isset($pasien->nama)?$pasien->nama:''; ?></span></td>
                        <td width="33%"></td>
                    </tr>
                    <tr>
                        <td><span>NIK</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_identitas)?$pasien->no_identitas:''; ?></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span>No. RM</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?></span></td>
                        <td><span>(<?php echo isset($pasien->sex)?$pasien->sex:''; ?>)</span></td>
                    </tr>
                    <tr>
                        <td><span>Tgl Lahir</span></td>
                        <td><span>:</span></td>
                        <td><span><?= isset($pasien->tgl_lahir)? date('d-m-Y',strtotime($pasien->tgl_lahir)):''; ?></span></td>
                        <td><span>
                        <svg class="barcode"
                        jsbarcode-format="code128"
                        jsbarcode-height="30"
                        jsbarcode-width="1"
                        jsbarcode-displayValue="false"
                        jsbarcode-value="<?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-margin="0"
                        jsbarcode-marginTop="5"
                        jsbarcode-marginRight="5"
                        jsbarcode-fontoptions="bold">
                        </svg>

                    <script>JsBarcode(".barcode").init();</script>
                        </span></td>
                    </tr>
                        </table> 
                    </td>
                    </tr>
                </table> -->
            </header>

            <hr color="black">
            
            <center><h4>CAROTID ULTRASOUND</h4></center>
            <table border="1" width="100%">
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="20%">
                                     <span>Nama</span>
                                 </td>
                                 <td width="2%"><span>:</span></td>
                                 <td>
                                     <span> <?= isset($data_pasien_tindak->nama)?$data_pasien_tindak->nama:'' ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="20%">
                                     <span>Alamat</span>
                                 </td>
                                 <td width="2%"><span>:</span></td>
                                 <td>
                                     <span><?= isset($pasien->alamat)?$pasien->alamat:'' ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="20%">
                                     <span>Tanggal</span>
                                 </td>
                                 <td width="2%"><span>:</span></td>
                                 <td>
                                 <span><?= date('d F Y',strtotime($data->tgl_kunjungan)) ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="20%">
                                     <span>Diagnosis</span>
                                 </td>
                                 <td width="2%"><span>:</span></td>
                                 <td>
                                 <span><?= isset($pasien->nm_diagmasuk)?$pasien->nm_diagmasuk:'' ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="20%">
                                     <span>Faktor Resiko</span>
                                 </td>
                                 <td width="2%"><span>:</span></td>
                                 <td>
                                 <span><?= $jsone['me_faktor_resiko'] ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="20%">
                                     <span>Dokter Pengirim</span>
                                 </td>
                                 <td width="2%"><span>:</span></td>
                                 <td>
                                 <span><?= isset($pasien->dokter)?$pasien->dokter:'' ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>  
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="20%">
                                     <span>Dokter Ruangan</span>
                                 </td>
                                 <td width="2%"><span>:</span></td>
                                 <td>
                                 <span><?= isset($dokter_ruangan->nm_dokter)?$dokter_ruangan->nm_dokter:'' ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>  
            </table>

            <p style="font-size:14px;line-height:50pxfont-weight:bold">DESKRIPSI</p>

            <div class="grid-container">
                <div class="item2">
                    <p style="font-size:12px">Left</p>
                    <table width= "100%" style="text-align:center;font-size:11px" border=1>
                        <tr>
                            <th  width= "40%">Segment</th>
                            <th  width= "30%">PSV</th>
                            <th  width= "30%">EDV</th>
                        </tr>
                        <tr>
                            <td  width= "40%">CCA</td>
                            <td  width= "30%"><?= $jsone['me_l_cca_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_l_cca_edv'] ?></td>
                        </tr>
                        <tr>
                            <td  width= "40%">Bulb</td>
                            <td  width= "30%"><?= $jsone['me_l_bulb_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_l_bulb_edv'] ?></td>
                        </tr>
                        <tr>
                            <td  width= "40%">ICA</td>
                            <td  width= "30%"><?= $jsone['me_l_ica_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_l_ica_edv'] ?></td>
                        </tr>
                        <tr>
                            <td  width= "40%">ECA</td>
                            <td  width= "30%"><?= $jsone['me_l_eca_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_l_eca_edv'] ?></td>
                        </tr>
                        <tr>
                            <td  width= "40%">ICA:CCA</td>
                            <td  width= "30%" colspan = 2><?= $jsone['me_l_ica_eca_psv_edv'] ?> </td>
                        </tr>
                        <tr>
                            <td  width= "40%">Vertebral</td>
                            <td  width= "30%"><?= $jsone['me_l_veterbal_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_l_veterbal_edv'] ?></td>
                        </tr>

                    </table>                
                </div>
                <div class="item3">
                    <p style="font-size:12px">Right</p>
                    <table width= "100%" style="text-align:center;font-size:12px" border=1>
                    <tr>
                            <th  width= "40%">Segment</th>
                            <th  width= "30%">PSV</th>
                            <th  width= "30%">EDV</th>
                        </tr>
                        <tr>
                            <td  width= "40%">CCA</td>
                            <td  width= "30%"><?= $jsone['me_r_cca_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_r_cca_edv'] ?></td>
                        </tr>
                        <tr>
                            <td  width= "40%">Bulb</td>
                            <td  width= "30%"><?= $jsone['me_r_bulb_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_r_bulb_edv'] ?></td>
                        </tr>
                        <tr>
                            <td  width= "40%">ICA</td>
                            <td  width= "30%"><?= $jsone['me_r_ica_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_r_ica_edv'] ?></td>
                        </tr>
                        <tr>
                            <td  width= "40%">ECA</td>
                            <td  width= "30%"><?= $jsone['me_r_eca_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_r_eca_edv'] ?></td>
                        </tr>
                        <tr>
                            <td  width= "40%">ICA:CCA</td>
                            <td  width= "30%" colspan = 2><?= $jsone['me_r_ica_eca_psv_edv'] ?> </td>
                        </tr>
                        <tr>
                            <td  width= "40%">Vertebral</td>
                            <td  width= "30%"><?= $jsone['me_r_veterbal_psv'] ?></td>
                            <td  width= "30%"><?= $jsone['me_r_veterbal_edv'] ?></td>
                        </tr>
                    </table>
                </div>  
            </div>

            <p style="font-size:12px">
                Kesimpulan :
            </p>
            <p style="margin-left: 15px;font-size:12px">
                <?= $jsone['me_kesimpulan'] ?>
            </p>

        </div>    
    </body>
<?php }else{ ?>
    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <br><br>
            <table style="width: 100%;" border="0">
                    <tr>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_kesehatan_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                        <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:12px">
                                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:11px">
                                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                            </font>    
                            <br>
                            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                        </td>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url('assets/img/').$logo_header; ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                    </tr>
            </table>

            <header style="margin-top:20px; font-size:1pt!important;">
                <!-- <table border="0" width="100%">
                   
                
                    <tr>
                        <td width="15%"><span>Nama</span></td>
                        <td width="2%"><span>:</span></td>
                        <td width="50%"><span><?php echo isset($pasien->nama)?$pasien->nama:''; ?></span></td>
                        <td width="33%"></td>
                    </tr>
                    <tr>
                        <td><span>NIK</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_identitas)?$pasien->no_identitas:''; ?></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><span>No. RM</span></td>
                        <td><span>:</span></td>
                        <td><span><?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?></span></td>
                        <td><span>(<?php echo isset($pasien->sex)?$pasien->sex:''; ?>)</span></td>
                    </tr>
                    <tr>
                        <td><span>Tgl Lahir</span></td>
                        <td><span>:</span></td>
                        <td><span><?= isset($pasien->tgl_lahir)? date('d-m-Y',strtotime($pasien->tgl_lahir)):''; ?></span></td>
                        <td><span>
                        <svg class="barcode"
                        jsbarcode-format="code128"
                        jsbarcode-height="30"
                        jsbarcode-width="1"
                        jsbarcode-displayValue="false"
                        jsbarcode-value="<?php echo isset($pasien->no_cm)?$pasien->no_cm:''; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-margin="0"
                        jsbarcode-marginTop="5"
                        jsbarcode-marginRight="5"
                        jsbarcode-fontoptions="bold">
                        </svg>

                    <script>JsBarcode(".barcode").init();</script>
                        </span></td>
                    </tr>
                        </table> 
                    </td>
                    </tr>
                </table> -->
            </header>
            <hr color="black">
            
            <p align="center" style="font-weight:bold;font-size:14px"><u>SURAT ELEKTROMEDIK</u></p>



        

            <tr>
                <td>
                    <table border="1" width="100%">
                        <tr>
                            <td>
                                <br>
                                <table border="0" width="100%">
                                   
                                    <td width="20%">
                                        <span class="text_sub_judul">
                                            Ruang  : <?php echo isset($pasien->idrg)?$pasien->idrg:''; ?>
                                        </span>
                                    </td>
                                    <td width="40%">
                                        <span class="text_sub_judul">
                                            Dokter Pengirim : <?php echo isset($pasien->dokter)?$pasien->dokter:''; ?>
                                        </span>
                                    </td>
                                    <td width="40%">
                                        <span class="text_sub_judul">
                                            Dokter Ruangan : <?php echo isset($dokter_ruangan->nm_dokter)?$dokter_ruangan->nm_dokter:''; ?>
                                        </span>
                                    </td>
                                </table>
                                <br>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <br>
                                <table border="0" width="100%">
                                    <td width="50%"><span class="text_sub_judul">
                                            Tanggal Daftar : <?= ($pemeriksaan_elektromedik)?$pemeriksaan_elektromedik[0]->tgl_kunjungan?date('d-m-Y',strtotime($pemeriksaan_elektromedik[0]->tgl_kunjungan)):'-':'-' ?>
                                        </span></td>
                                    <td width="50%"><span class="text_sub_judul">
                                            Tanggal Hasil : <?= ($pemeriksaan_elektromedik)?$pemeriksaan_elektromedik[0]->tanggal_isi?date('d-m-Y',strtotime($pemeriksaan_elektromedik[0]->tanggal_isi)):'-':'-' ?>
                                        </span></td>
                                </table>
                                <br>
                            </td>
                        </tr>

                        <tr>
                            <td width="100%">
                                <table border="0" width="100%">
                                    <br>
                                    <tr>
                                        <td width="2%"> </td>
                                        <td width="11%">
                                            <span class="text_sub_judul">Hasil</span>
                                        </td>
                                        <td width="2%"><span class="text_sub_judul">:</span></td>
                                        <td>
                                            <span class="text_sub_judul"><?= isset($data->hasil)?$data->hasil:'-' ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <table border="0" width="100%">
                                    <br>
                                    <tr>
                                        <td width="2%"> </td>
                                        <td width="11%">
                                            <span class="text_sub_judul">Saran</span>
                                        </td>
                                        <td width="2%"><span class="text_sub_judul">:</span></td>
                                        <td>
                                            <span class="text_sub_judul"><?= isset($data->saran)?$data->saran:'-' ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <table border="0" width="100%">
                                    <br>
                                    <tr>
                                        <td width="2%"> </td>
                                        <td width="11%">
                                            <span class="text_sub_judul">Btk</span>
                                        </td>
                                        <td width="2%"><span class="text_sub_judul">:</span></td>
                                        <td>
                                            <span class="text_sub_judul"><?= isset($data->btk)?$data->btk:'-' ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <table border="0" width="100%">
                                    <br>
                                    <tr>
                                        <td width="2%"> </td>
                                        <td width="11%">
                                            <span class="text_sub_judul">Rekam Elektromedik</span>
                                        </td>
                                        <td width="2%"><span class="text_sub_judul">:</span></td>
                                        <td>
                                            <span class="text_sub_judul"><?= isset($data->rekam_elektromedik)?$data->rekam_elektromedik:'-' ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <table border="0" width="100%" style="margin-top:2em;">
                <tr>
                    <td>
                        <br>
                        <table border="0" width="100%">
                            <tr>
                                <td width="70%">
                                </td>

                                <td> 
                                    <div>
                                    <span class="text_sub_judul">Yang Bertandatangan</span>
                                    </div>
                                    <div style="width:150px;height:120px; display:flex;justify-content:center;align-items:center;">
                                        <img  width="160px" src="<?= ($pemeriksaan_elektromedik)?$pemeriksaan_elektromedik[0]->ttd_dokter?$pemeriksaan_elektromedik[0]->ttd_dokter:'-':'-' ?>" alt="">
                                    
                                    </div>
                                
                                </td>
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>
                                <td width="70%">
                                </td>

                                <td> <span class="text_isi"><?= ($pemeriksaan_elektromedik)?$pemeriksaan_elektromedik[0]->nm_dokter?$pemeriksaan_elektromedik[0]->nm_dokter:'-':'-' ?></span>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </td>
                </tr>
        
            </table>
            
        </div>
    
    </body>
<?php } ?>
</html>

<?php } ?>