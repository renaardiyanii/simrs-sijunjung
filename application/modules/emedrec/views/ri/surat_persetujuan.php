<?php 
$data = (isset($surat_persetujuan[0]->formjson)?json_decode($surat_persetujuan[0]->formjson):'');
// var_dump($data->ttd_1);
?>

<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
        .header-parent{
            display: flex;
            justify-content: space-between;

        }
        #identity{
            float: left;
            text-align: center;
            line-height: 8px;
            font-weight: bold;
            margin-left: 20px;
        }
        .text_body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
       }
       .text_isi{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
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
       .flex{
            display:flex;
       }    
       .justify-between{
           justify-content:space-between;
       }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   <body class="A4" >
    <div class="A4 sheet  padding-fix-10mm">
    <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
      
            <div style="font-size:14px">
                <p style="text-align: center;">
                   <center> <h3><u>SURAT PERSETUJUAN</u></h3></center>
                </p>
                <div class="flex justify-between">
                    <p>Saya yang bertanda tangan dibawah ini :</p>
                    <div style="margin-right:1em;font-size:14pt;position:absolute;right:3em;top:9em;color:#3498db; border:2px solid #3498db; padding:1em 2em;">
                        <p><?= $spri->carabayar ?> </p>
                    </div>
                </div>
                <p style="margin-left: 20px;">
                        <table border="0" width="100%" style="margin-left:15px;font-size:14px">
                            <tr>
                                <td width="30%" ><span class="">Nama</span></span></td>
                                <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                                <td width="75%" ><span class=""><span class="text_isi"><?= (isset($data->penanggung_jawab_pasien->nama)?$data->penanggung_jawab_pasien->nama:'') ?></span></span></td>
                            </tr>
                            <tr>
                                <td width="30%" ><span class="">No. KTP</span></span></td>
                                <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                                <td width="75%" ><span class=""><span class="text_isi"><?= (isset($data->penanggung_jawab_pasien->no_identitas)?$data->penanggung_jawab_pasien->no_identitas:'') ?></span></span></td>
                            </tr>
                            <tr>
                                <td width="30%" ><span class="">Umur</span></span></td>
                                <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                                <td width="75%" ><span class=""><span class="text_isi"><?= (isset($data->penanggung_jawab_pasien->umur)?$data->penanggung_jawab_pasien->umur:'') ?></span></span></td>
                            </tr>
                            <tr>
                                <td width="30%" ><span class="">Alamat</span></span></td>
                                <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                                <td width="75%" ><span class=""><span class="text_isi"><?= (isset($data->penanggung_jawab_pasien->Alamat)?$data->penanggung_jawab_pasien->Alamat:'') ?></span></span></td>
                            </tr>
                        </table>
                </p>

                <p>Adalah <b><?= (isset($data->penanggung_jawab_pasien->adalah)?$data->penanggung_jawab_pasien->adalah:'') ?></b> dari pasien :</p>

                <p style="margin-left: 20px;">
                    <table border="0" width="100%" style="margin-left:15px;font-size:14px">
                        <tr>
                            <td width="30%" ><span class="">Nama</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="75%" ><span class=""><span class="text_isi"><?= (isset($data->identitas_pasien->nama)?$data->identitas_pasien->nama:'') ?></span></span></td>
                        </tr>
                        <tr>
                            <td width="30%" ><span class="">No. KTP</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="75%" ><span class=""><span class="text_isi"><?= (isset($data->identitas_pasien->no_identitas)?$data->identitas_pasien->no_identitas:'') ?></span></span></td>
                        </tr>
                        <tr>
                            <td width="30%" ><span class="">Alamat</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="75%" ><span class=""><span class="text_isi"><?= (isset($data->identitas_pasien->alamat)?$data->identitas_pasien->alamat:'') ?></span></span></td>
                        </tr>
                    </table>
                </p>

                <p>Dengan ini menyatakan bahwa pembiayaan pengobatan terhadap pasien menggunakan :</p>

                <p>1.   Biaya Umum </p>
                <p>2.	BPJS Kesehatan </p>

                <p style = "text-align:justify;margin-left: 20px;">
                    a.Saya telah mendapatkan informasi tentang prosedur penjamin pasien rawat inap bagi
                    peserta JKN-KIS bahwa status penjaminan pasien harus dipastikan sejak awal masuk,
                    pasien / keluarga / wali pasien diberikan kesempatan dalam <b>3 hari kerja</b> sejak yang
                    bersangkutan dirawat atau sebelum pasien pulang ( bila pasien dirawat kurang dari 3 hari)
                    untuk menunjukkan nomor identitas peserta JKN-KIS sebagai syarat penerbitan Surat
                    Eligibilitas Peserta (SEP). 
                </p>

                <p  style = "text-align:justify;margin-left: 20px;">
                    b.Jika dalam waktu <b>3 hari kerja</b> saya tidak dapat melengkapi syarat administratif
                    sebagaimana poin no 1, maka pasien bersedia <b>dinyatakan sebagai pasien umum</b>.
                </p>

                <p>3.   Asuransi lainnya</p>

                <p>
                    Demikianlah surat pernyataan ini dibuat dengan sebenarnya, 
                    dalam keadaan sadar dan tanpa ada paksaan dari pihak manapun dan untuk dipergunakan sebagaimana mestinya.
                </p>

                <div style="display: inline; position: relative;">
                    <div style="float: left;margin-top: 10px;">
                        <p>Saksi/Petugas</p>
                        <img  src="<?=(isset($surat_persetujuan[0]->ttd_pemeriksa)?$surat_persetujuan[0]->ttd_pemeriksa:'') ?>" width="120px"  height="100px" alt=""><br> 
                        <span><?=(isset($surat_persetujuan[0]->nm_pemeriksa)?$surat_persetujuan[0]->nm_pemeriksa:'') ?></span>      
                    </div>
                    <div style="float: right;">
                        <span>Bukittinggi,<?=(isset($surat_persetujuan[0]->tgl_input)?date('d-m-Y',strtotime($surat_persetujuan[0]->tgl_input)):'') ?></span>
                        <p>Yang Menyatakan,</p>
                        <?php 
                        if($showttd!="1"){
                            ?>
                        <img  src="<?=(isset($data->ttd_1)?$data->ttd_1:'') ?>" width="120px"  height="100px" alt=""><br>
                        <span><?= (isset($data->penanggung_jawab_pasien->nama)?$data->penanggung_jawab_pasien->nama:'') ?></span></span></span><br> 
                        <?php }else{ ?>
                            <br><br><br><br><br>
                            <span><?= (isset($data->penanggung_jawab_pasien->nama)?$data->penanggung_jawab_pasien->nama:'') ?></span></span></span><br> 
                        <?php } ?>
                    </div>     
                </div>

            </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div>
    </div>
    </body>
</html>