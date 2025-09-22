<?php
$data = isset($penolakan_tindakan->formjson)?json_decode($penolakan_tindakan->formjson):'';
?>
<style>
    .tanda-tangan {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
    }
    .tanda-tangan div {
        text-align: center;
        width: 45%;
    }
    .tanda-tangan p {
        margin-bottom: 70px;
    }
    .sheet {
        padding: 20mm;
    }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>
<body class="A4">
<div class="A4 sheet padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
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
                <h3>LAPORAN PEMBEDAHAN</h3>
            </center>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="7px">
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                    </td>
                </tr>
            </table>
        </td>
        <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td width="70%" style="font-style:italic">
                        <p>(Diisi Oleh Perawat)</p>
                    </td>
                    <td style="font-style:italic">
                        <p align="right">Halaman 1 dari 1</p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%"><p>Tanggal Pemindahan : <?= isset($data->tgl)?date('d-m-Y',strtotime($data->tgl)):'' ?></p></td>
                                <td><p>Jam : <?= isset($data->tgl)?date('h:i',strtotime($data->tgl)):'' ?></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="40%"><p>Ahli bedah</p></td>
                                <td><p>Asisten :</p></td>
                                <td><p>Instrumentator : </p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td>
                    <span>Macam Pembedahan :</span>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Kecil</label>

                    <input type="checkbox"  value="">
                    <label for="sendiri">Sedang</label>
                    
                    <input type="checkbox"  value="">
                    <label for="sendiri">Besar</label>

                    <input type="checkbox"  value="">
                    <label for="sendiri">Khusus 1</label>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Khusus 2</label>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Gawat darurat</label>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Berencana</label>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Bersih</label>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Bersih tercemar</label>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Tercemar</label>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Kotor</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Diagnosa Pra Bedah :</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Tindakan Pembedahan :</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Diagnosa Pasca bedah :</span>
                    </td>
                </tr>
            </table>
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
                 <tr>
                    <td style="border: 1px solid black; padding: 8px; ">Nama Implant</td>
                    <td style="border: 1px solid black; padding: 8px; ">Lokasi pemasangan</td>
                    <td style="border: 1px solid black; padding: 8px; ">Kode Produk / Barcode</td>
                    <td style="border: 1px solid black; padding: 8px; ">Keterangan</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
            </table>
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
                 <tr>
                    <td style="border: 1px solid black; padding: 8px; ">Ahli Bius</td>
                    <td style="border: 1px solid black; padding: 8px; ">Cara pembiusan</td>
                    <td style="border: 1px solid black; padding: 8px; ">Posisi pasien</td>
                    <td style="border: 1px solid black; padding: 8px; ">Mulai</td>
                    <td style="border: 1px solid black; padding: 8px; ">Selesai</td>
                    <td style="border: 1px solid black; padding: 8px; ">Lama pembedahan <br> Jam & Menit</td>
                    <td style="border: 1px solid black; padding: 8px; ">OK</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "> </td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
            </table>
            <br>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
                <tr>
                    <td>
                        <span>URAIAN PEMBEDAHAN :</span>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br><br>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
                <tr>
                    <td>
                        <span>KOMPLIKASI :</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>PERDARAHAAN :</span>
                    </td>
                </tr>
                <tr>
                    <td>
                    <span>Jaringan di kirim ke patologi :</span>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Tidak</label>
                    <input type="checkbox"  value="">
                    <label for="sendiri">Ya</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Asal jaringan :</span>
                    </td>
                </tr>
            </table>
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Ahli Bedah</p>
                            <br><br><br>
                            <?php 
                            $id1 =isset($transfusi_darah->id_pemeriksa)?$transfusi_darah->id_pemeriksa:null;                                    
                            $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                            ?>
                            <span>( <?=  isset($query1->name)?$query1->name:'' ?>Nama Jelas )</span><br> 
                           
                    </div>  
                </div>
    </tr>
</table>




</div>
</body>
</html>
