<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4 landscape">
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
            <h3>CATATAN PEMBERIAN INFORMASI DAN EDUKASI PASIEN DAN KELUARGA TERINTEGRASI</h3>
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
            <td colspan="2"><b>INTRUKSI : beri tanda check List pada kotak yang sesuai dengan kondisi dan kebutuhan pasien , dan isi titik titik dengan hasi assesmen yang sesuai</td>
            <td >Halaman 1 dari 3</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                 <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                    <tr>
                        <td colspan="4"><center>ASESMEN KEMAMPUAN KEMAUAN BELAJAR</center></td>
                    </tr>
                    <tr>
                        <td>Pengkajian umum :
                            <br>Bahasa yang digunakan :
                            <br>Kebutuhan penerjemah :
                            <br>Agama pasien :
                            <br>Pendidikan pasien :
                            <br>kesediaan menerima INFORMASI
                            <br>kemampuan membaca
                            <br>keyakinan dan nilai nilai :
                        </td>
                        <td><br><input type="checkbox"> Indonesia&nbsp;<input type="checkbox">Daerah, sebutkan............. &nbsp;<input type="checkbox">isyarat &nbsp;<input type="checkbox"> Lain lain
                        <br><input type="checkbox">Ya &nbsp;<input type="checkbox"> Tidak
                        <br><input type="checkbox">Islam &nbsp;<input type="checkbox">kristen &nbsp;<input type="checkbox"> hindu &nbsp;<input type="checkbox">budha &nbsp;<input type="checkbox">konghucu
                        <br><input type="checkbox">SD &nbsp;<input type="checkbox">SMP &nbsp;<input type="checkbox">SMA/SMK&nbsp;<input type="checkbox">PT&nbsp;<input type="checkbox">Tidak sekolah
                        <br><input type="checkbox">Bersedia &nbsp;<input type="checkbox">tidak bersedia,(alasan nya)............
                        <br><input type="checkbox">baik&nbsp;<input type="checkbox">kurang&nbsp;<input type="checkbox">tidak bersedia
                        <br><input type="checkbox">&nbsp;<input type="checkbox">..............................
                        </td>
                        <td>Keterbatasan : <br><input type="checkbox">Tidak ada &nbsp;<input type="checkbox">Gangguan bicara &nbsp; <br><input type="checkbox">Penglihatan terganggu &nbsp;<input type="checkbox"> fisik lemah &nbsp;<br> <input type="checkbox"> pendengaran terganggung &nbsp;<input type="checkbox"> kognitif terbatas &nbsp;<br> <input type="checkbox">lain lain...
                        <br><br>Hambatan emosional dan motivasi : &nbsp;<br><input type="checkbox">tidak ada &nbsp;<input type="checkbox">motivasi kurang&nbsp; <br><input type="checkbox"> emosional terganggu&nbsp; <input type="checkbox"> lainnya..............
                        </td>
                      
                    </tr>
                    <tr>
                        <td colspan="4">ASESMEN KEBUTUHAN EDUKASI (checklist nomor sesuai kebutuhan)
                            <br><input type="checkbox">1. Asuhan medis &nbsp;<input type="checkbox">2. asuhan keperawatan &nbsp;<input type="checkbox">3. pengobatan &nbsp;<input type="checkbox">4. asuhan gizi &nbsp;<input type="checkbox">5. manajemen nyeri &nbsp;<input type="checkbox">6. rehabilitasi &nbsp;<input type="checkbox">7. penggunaan alat alat medis 
                            <br> <input type="checkbox">8. hand hygiene &nbsp;<input type="checkbox">9. rohani &nbsp;<input type="checkbox">10. pendaftaran dan admisi &nbsp;<input type="checkbox">11. prosedur dan perawatan &nbsp;<input type="checkbox">12. lainnya................................(sebutkan)
                        </td>
                    </tr>
                 </table>
                 <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                    <tr>
                          <td colspan="4">PERENCAAN EDUKASI</td>
                    </tr>
                    <tr>
                          <td>Metode</td>
                          <td>Media</td>
                          <td>Evaluasi</td>
                          <td>Penerima edukasi</td>
                    </tr>
                    <tr>
                          <td><input type="checkbox">1. diskusi</td>
                          <td><input type="checkbox">1. Leaflet</td>
                          <td><input type="checkbox">1.sudah mengerti</td>
                          <td><input type="checkbox">1. pasien</td>
                    </tr>
                    <tr>
                          <td><input type="checkbox">2. ceramah</td>
                          <td><input type="checkbox">2. lembar balik</td>
                          <td><input type="checkbox">2.re-edukasi</td>
                          <td><input type="checkbox">2. keluarga</td>
                    </tr>
                    <tr>
                          <td><input type="checkbox">3. demonstrasi</td>
                          <td><input type="checkbox">3. audio visual</td>
                          <td><input type="checkbox">3. re-demonstrasi</td>
                          <td><input type="checkbox">3. lainnya........sebutkan</td>
                    </tr>
                 </table>
                 <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                    <tr>
                        <td rowspan="2">TANGGAL/JAM</td>
                        <td rowspan="2"><CENTER>TOPIK EDUKASI</CENTER></td>
                        <td rowspan="2">METODE</td>
                        <td rowspan="2">MEDIA EDUKASI</td>
                        <td colspan="2">PENERIMA EDUKASI</td>
                        <td rowspan="2">EVALUASI</td>
                        <td colspan="2">PEMBERI EDUKASI</td>
                        <td rowspan="2">VERIFIKASI</td>
                        <td rowspan="2">EVALUASI LANJUTAN</td>
                    </tr>
                    <tr>
                        <td>NAMA</td>
                        <td>TTD</td>
                        <td>NAMA</td>
                        <td>TTD</td>

                    </tr>
                    <tr>
                         <td></td>
                        <td><b>PENDAFTARAN ADMISI</b></td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">hak hak pasien</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">aturan umum RS</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">tanggung jawab RS menjaga barang pasien</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">perkiraan biaya rawatan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">alasan penundaan pelayanan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      
                    </tr>
                 </table>
                 
                 
            </td>
       </tr>
      
    </table>
   
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
            <h3>CATATAN PEMBERIAN INFORMASI DAN EDUKASI PASIEN DAN KELUARGA TERINTEGRASI</h3>
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
            <td >Halaman 2 dari 3</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                    <tr>
                        <td rowspan="2">TANGGAL/JAM</td>
                        <td rowspan="2"><CENTER>TOPIK EDUKASI</CENTER></td>
                        <td rowspan="2">METODE</td>
                        <td rowspan="2">MEDIA EDUKASI</td>
                        <td colspan="2">PENERIMA EDUKASI</td>
                        <td rowspan="2">EVALUASI</td>
                        <td colspan="2">PEMBERI EDUKASI</td>
                        <td rowspan="2">VERIFIKASI</td>
                        <td rowspan="2">EVALUASI LANJUTAN</td>
                    </tr>
                    <tr>
                        <td>NAMA</td>
                        <td>TTD</td>
                        <td>NAMA</td>
                        <td>TTD</td>

                    </tr>
                    <tr>
                          <td></td>
                        <td><input type="checkbox">alasan keterlambatan pelayanan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">alternatif yang tersedia jika <br>pelayanan tertunda atau lambat</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">alur layanan pengaduan / komplain</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">informasi rujukan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">lain lain........................</td>
                        <td></td>
                        <td></td>
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
                        <td><b>DOKTER</b></td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">hasil asesmen</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">diagnosa dan rencana asuhan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">hasil pemeriksaan diagnostik</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">proses asuhan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">perkembanga kondisi pasien</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">hasil asuhan dan pengobatan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">hasil asuhan yang tidak diharapkan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">asuhan lanjutan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">resiko medis akibat asuhan medis yang belum lengkap (AMA dan APS)</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">manajemen nyeri</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">lain lain</td>
                        <td></td>
                        <td></td>
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
                        <td><b>PERAWAT/BIDAN</b></td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">hasil assesmen</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">diagnosa dan rencana asuhan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">pencegahan infeksi di RS <br>dengan cuci tangan yang benar</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                   
                    
                </table>
            </td>
       </tr>
    </table>
   
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
            <h3>CATATAN PEMBERIAN INFORMASI DAN EDUKASI PASIEN DAN KELUARGA TERINTEGRASI</h3>
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
            <td >Halaman 3 dari 3</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                    <tr>
                        <td rowspan="2">TANGGAL/JAM</td>
                        <td rowspan="2"><CENTER>TOPIK EDUKASI</CENTER></td>
                        <td rowspan="2">METODE</td>
                        <td rowspan="2">MEDIA EDUKASI</td>
                        <td colspan="2">PENERIMA EDUKASI</td>
                        <td rowspan="2">EVALUASI</td>
                        <td colspan="2">PEMBERI EDUKASI</td>
                        <td rowspan="2">VERIFIKASI</td>
                        <td rowspan="2">EVALUASI LANJUTAN</td>
                    </tr>
                    <tr>
                        <td>NAMA</td>
                        <td>TTD</td>
                        <td>NAMA</td>
                        <td>TTD</td>

                    </tr>
                    <tr>
                          <td></td>
                        <td><input type="checkbox">pencegahan infeksi di RS <br>dengan etika batuk</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">manajemen nyeri</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">batuk efektif</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">pencegahan resiko jatuh</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">pengawasan pasien</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">penggunaan APD (masker, sarung tangan dll)</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">personal hygiene</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">perawatan luka</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">pemenuhan kebutuhan cairan</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">perawatan kaki diabetes</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">mobilitas / ROM</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">ASI Ekklusif</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">perawatan bayi baru lahir</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">perawatan tali pusat</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">.......................</td>
                        <td></td>
                        <td></td>
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
                        <td><input type="checkbox">.....................</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </td>
       </tr>
    </table>
   
    </div>
</body>