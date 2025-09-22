<?php 
// $data = isset($konsul->formjson)?json_decode($konsul->formjson):'';
$data = isset($konsul->formjson)?json_decode($konsul->formjson):'';
// var_dump($konsul);die();

?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
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
                <h3>LEMBAR KONSULTASI</h3>
            </center>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="7px">
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
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
    </tr>
</table>
       
        <table style="width: 100%; border-collapse: collapse; margin: 4px auto; border: 1px solid black;">
        <tr>
            <td style="border: 1px solid black; padding: 8px; text-align: center;">Yth : Dr <?= isset($data->yth)?$data->yth:'' ?><br><br> (Konsulen yang diminta)</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;">Bagian / Sub yang diminta <p><?= isset($data->bagian_sub)?$data->bagian_sub:'' ?></p></td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;">Tanggal : <p><?= isset($data->tanggal)?date('d-m-Y',strtotime($data->tanggal)):'' ?></p></td>
        </tr>
      </table>
      <table border="1" width="100%" cellpadding="10px" style="margin-top:10px">
            <td>
                <p style="font-size:14px;">PENDERITA KAMI RAWAT DENGAN : <?= isset($data->penderita->penderita1)?$data->penderita->penderita1:'' ?></p>

                <p style="font-size:14px;">DIAGNOSIS KERJA : <?= isset($data->penderita->diagnosis)?$data->penderita->diagnosis:'' ?> </p>

                <p style="font-size:14px;">TANDA PEMERIKSAAN KAMI TEMUKAN : </p>
                <div style="font-size:14px;min-height:80px">(Ikhitisar) :
                    <p><?= isset($konsul->ikhtisar)?$konsul->ikhtisar:'' ?></p>
                </div>


                <div style="font-size:14px;min-height:80px">Kesimpulan :
                    <p><?= isset($konsul->kesimpulan)?$konsul->kesimpulan:'' ?></p>
                </div>


                <div style="font-size:14px;min-height:80px">Konsul yang diminta :
                    <p><?= isset($konsul->konsul_diminta)?$konsul->konsul_diminta:'' ?></p>
                </div>
           

                <p><span style="font-size:14px;">KONSULEN DIHARAPKAN </span></p>
                        <div>
                            <input type="checkbox" <?php echo isset($konsul->pendapat)? $konsul->pendapat == "memberikan_pendapat_dibidang_ts" ? "checked":'':'' ?>>MEMBERIKAN PENDAPAT DIBIDANG TS<br><br>
                            <input type="checkbox" <?php echo isset($konsul->pengobatan)? $konsul->pengobatan == "memberikan_advis_pengobatan" ? "checked":'':'' ?>>MEMBERIKAN ADVIS PENGOBATAN<br><br>
                            <input type="checkbox" <?php echo isset($konsul->alih_pengobatan)? $konsul->alih_pengobatan == "alih_pengobatan" ? "checked":'':'' ?>>MEMGAMBIL ALIH PENGOBATAN<br><br>
                            <input type="checkbox" <?php echo isset($konsul->raber)? $konsul->raber == "raber" ? "checked":'':'' ?>>RAWAT BERSAMA<br><br>
                           
                        </div><br>
                <p><span style="font-size:14px;">DEMIKIAN HARAPAN KAMI, SEMOGA TS MAKLUM</span><BR>
                <p><span style="font-size:14px;">ATAS PERHATIAN DAN KERJA SAMA DIUCAPKAN TERIMA KASIH</span><br></p><br><br><br>
                <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($konsul->tgl_input)?date('d-m-Y',strtotime($konsul->tgl_input)):'' ?></p>
                           
                            
                            <?php 
                            $id1 =isset($konsul->id_pemeriksa)?$konsul->id_pemeriksa:null;                                    
                            $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                            ?>
                             <img src="<?= $query1->ttd ?>" alt="img" height="50px" width="50px"><br>
                            <span>( <?= isset($query1->name)?$query1->name:'' ?> )</span><br> 
                           
                    </div>  
            </div>
            </td>
        </table>
    </div>

    
    </body>
</html>