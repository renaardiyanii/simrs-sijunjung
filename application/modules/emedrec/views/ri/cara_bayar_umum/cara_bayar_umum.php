<?php
$data = (isset($cara_bayar_umum->formjson)?json_decode($cara_bayar_umum->formjson):'');
// var_dump($data);
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
            /* border: 1px solid black;     */
            width: 100%;
            font-size: 12px;
            position: relative;
            
        }

        #data tr td{
            
            font-size: 12px;
            font-family:arial;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:14px;font-family:arial">SURAT PERNYATAAN CARA BAYAR UMUM</p>
            <div style="font-size:12px;font-family:arial;line-height:180%">
                <p style="font-family:arial">
                Saya yang bertanda tangan di bawah ini :
                </p>

                <table id="data" width="100%" cellpadding="5px">
                    <tr>
                        <td width="15%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->{'Saya yang bertanda tangan di bawah ini :'}->Nama)?$data->{'Saya yang bertanda tangan di bawah ini :'}->Nama:'' ?></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td><?= isset($data->{'Saya yang bertanda tangan di bawah ini :'}->NIK)?$data->{'Saya yang bertanda tangan di bawah ini :'}->NIK:'' ?></td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td>:</td>
                        <td><?= isset($data->{'Saya yang bertanda tangan di bawah ini :'}->Umur)?$data->{'Saya yang bertanda tangan di bawah ini :'}->Umur:'' ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= isset($data->{'Saya yang bertanda tangan di bawah ini :'}->Alamat)?$data->{'Saya yang bertanda tangan di bawah ini :'}->Alamat:'' ?></td>
                    </tr>
                    <tr>
                        <td>No.HP</td>
                        <td>:</td>
                        <td><?= isset($data->{'Saya yang bertanda tangan di bawah ini :'}->{'No.HP'})?$data->{'Saya yang bertanda tangan di bawah ini :'}->{'No.HP'}:'' ?></td>
                    </tr>
                </table>
                <p style="font-family:arial">
                    Adalah <?= isset($data->question8->text1)?$data->question8->text1:'......' ?> <i style="font-family:arial">(sebutkan hubungan dengan pasien)</i> dari pasien yang nama tertera didalam label atas :<br>
                    Sehubungan dengan pembiayaan rawatan atas nama pasien <i style="font-family:arial">(sebutkan nama pasien)</i> diatas, dengan ini saya menyatakan bahwa :
                </p>

                <ol style="font-family:arial">
                    <li style="font-family:arial">Saya telah mendengar dan memahami dengan baik penjelasan yang disampaikan oleh petugas admisi rumah sakit</li>
                    <li style="font-family:arial">Pasien adalah pemegang kartu kepesertaan BPJS kesehatan No <?= isset($data->{'dari pasien yang nama tertera didalam label atas :'})?$data->{'dari pasien yang nama tertera didalam label atas :'}:'......' ?> (tuliskan nomor kartu BPJS pasien), namun saya tidak memanfaatkan kepesertaan BPJS kesehatan yang bersangkutan dengan alasan <?=isset($data->{'namun saya tidak memanfaatkan kepesertaan BPJS kesehatan yang bersangkutan dengan alasan'})?$data->{'namun saya tidak memanfaatkan kepesertaan BPJS kesehatan yang bersangkutan dengan alasan'}:'....' ?></li>
                    <li style="font-family:arial">Sehubungan dengan tindakan yang saya ambil sebagaimana disebutkan pada poin 2 diatas maka sebagai konsekuensinya saya bersedia menanggung dan membayarkan seluruh biaya rawatan pasien secara pribadi (menggunakan cara bayar umum) sesuai dengan perhitungan tarif RS yang berlaku. </li>
                    <li style="font-family:arial">Saya bersedia dan menyetujui tindakan pihak rumah sakit untuk menempatkan pasien dikelas rawatan yang tersedia apabila kelas rawatan yang diinginkan pada saat pasien masuk penuh atau tidak tersedia.</li>
                    <li style="font-family:arial">Saya bersedia melapor ke Admisi rumah sakit apabila ingin memindahkan pasien ke kelas rawatan yang diinginkan (lebih tinggi atau yang lebih rendah dari kelas perawatan awal).</li>
                    <li style="font-family:arial">Saya bersedia dan menyetujui untuk tetap menempatkan pasien sesuai dengan kelas perawatan pada saat pasien masuk pertama kali, apabila saya tidak melapor ke admisi untuk memindahkan pasien.</li>
                    <li style="font-family:arial">Saya menyadari dan mengetahui segala resiko yang akan terjadi dengan diterbitkannya surat pernyataan ini dan apabila dikemudian hari saya mengingkari ketentuan yang telah saya sampaikan dalam surat pernyataan ini maka saya bersedia mempertanggung jawabkan sesuai ketentuan yang berlaku </li>
                </ol>

                <p style="font-family:arial">Demikianlah surat pernyataan ini dibuat dengan sebenarnya, dalam keadaan sadar dan tanpa ada paksaan dari pihak manapun untuk dipergunakan sebagaimana mestinya.</p>
              

                <div style="float: left">
                    <span style="font-family:arial">Bukittinggi,</span><br>
                    <center><span style="font-family:arial;">Pasien/Penanggung Jawab Pasien</span></center>
                    <center><img width="80px" src="<?= isset($data->question2)?$data->question2:'' ?>" alt=""> </center><br>
                    <center><span style="font-family:arial;">(<?= isset($data->{'Saya yang bertanda tangan di bawah ini :'}->Nama)?$data->{'Saya yang bertanda tangan di bawah ini :'}->Nama:'....' ?>)</span><center>
                    <center><span style="font-family:arial;">Nama jelas & tanda tangan</span></center>
                </div>

                <div style="float: right;margin-top:50px">
                    
                    <span style="font-family:arial">Petugas Rumah Sakit</span>
                    <br><br><br>
                    <center><span style="font-family:arial;">(.....................)</span><center>
                    <center><span style="font-family:arial;">Nama jelas & tanda tangan</span></center> 
                </div>
            </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

            <div style="display:flex;font-size:12px;font-family:arial">
                <div style="font-family:arial">
                    Hal 1 dari 1
                </div>
                <div style="margin-left:525px;font-family:arial">
                <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </div>
           </div>
          
        </div>



    </body>
</html>