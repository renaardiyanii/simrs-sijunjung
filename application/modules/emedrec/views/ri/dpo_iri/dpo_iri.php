<?php
$data = (isset($dpo_resep) ? $dpo_resep : '');
// var_dump($data_pasien[0]);
// $result = array_chunk($kio_resep, 1);
// var_dump($result);
?>

<head>
    <title></title>
</head>

<style type='text/css'>
    #data {
        margin-top: 20px;
        /* border-collapse: collapse;
            border: 1px solid black;     */
        width: 100%;
        font-size: 11px;
        position: relative;
    }

    #data tr td {

        font-size: 12px;

    }
</style>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">



    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/header_print') ?>
        </header><br>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div>

        <center>
            <h4>DAFTAR PEMBERIAN OBAT</h4>
        </center>

        <div style="font-size:12px;">

            <table width="100%" id="data" border=1>
                <tr>
                    <td width="15%">Alergi terhadap obat : </td>
                    <td width="15%">Jenis Pasien : <?= $data_pasien[0]->carabayar ?></td>
                </tr>

                <tr>
                    <td width="15%">Obat Sebelumnya : </td>
                    <td width="15%">Ruangan : <?= $data_pasien[0]->nm_ruang ?></td>
                </tr>

            </table>


            <table width="100%" id="data" border=1>
                <tr>
                    <th width="2%" rowspan="2">No</th>
                    <th width="13%" rowspan="2">Tgl Diberikan</th>
                    <th width="20%" rowspan="2">Nama Obat</th>
                    <th width="5%" rowspan="2">Frekuensi/ Rute</th>
                    <th width="10%" rowspan="2">Paraf Dokter</th>
                    <th width="10%" rowspan="2">Paraf Farmasi</th>
                    <th width="10%" rowspan="2">Paraf Perawat</th>
                    <th width="20%" colspan="4">Waktu Pemberian</th>
                </tr>

                <tr>
                    <th>P</th>
                    <th>S</th>
                    <th>S</th>
                    <th>M</th>
                </tr>

                <?php
                $u = 1;
                foreach ($dpo_resep as $obat) {
                ?>



                    <tr>
                        <td style="text-align:center"><?= $u++ ?></td>
                        <td><?= $obat->tgl_dpo ?></td>
                        <td><?= $obat->nm_obat ?></td>
                        <td style="text-align:center"><?= $obat->frekuensi ?></td>
                        <td>
                            <?php
                            // $id = isset($obat->dokter)?$obat->dokter : null;
                            $id_dok = isset($obat->dokter)? $obat->dokter != '' ?Explode('-',$obat->dokter)[1]:'':'';
                            // var_dump($id);die();                                     
                            $query = $id_dok ? $this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id_dok")->row() : null;
                            if (isset($query->ttd)) {
                            ?>

                                <img width="50px" style="text-align:center" src="<?= $query->ttd ?>" alt=""><br>
                            <?php
                            }  ?>
                        </td>
                        <td>
                            <?php
                            
                            $id_far = isset($obat->farmasi)? $obat->farmasi != '' ?Explode('-',$obat->farmasi)[1]:'':'';
                                                             
                            $query =  $id_far ? $this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid =  $id_far")->row() : null;
                            if (isset($query->ttd)) {
                            ?>

                                <img width="50px" style="text-align:center" src="<?= $query->ttd ?>" alt=""><br>
                            <?php
                            }  ?>
                        </td>
                        <td>
                            <?php
                            // $id_per = isset($obat->perawat)?Explode('-',$obat->perawat)[1]:(isset($obat->perawat)?Explode('-',$obat->perawat)[1]:'');
                            $id_per = isset($obat->perawat) ? $obat->perawat : null;
                            //  var_dump($id);                                     
                            $query = $id_per ? $this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id_per")->row() : null;
                            if (isset($query->ttd)) {
                            ?>

                                <img width="50px" style="text-align:center" src="<?= $query->ttd ?>" alt=""><br>
                            <?php
                            }  ?>
                        </td>
                        <td style="text-align:center"><?php echo isset($obat->jam_pagi)?$obat->jam_pagi  : '' ?></td>
                        <td style="text-align:center"><?php echo isset($obat->jam_siang) ? $obat->jam_siang  : '' ?></td>
                        <td style="text-align:center"><?php echo isset($obat->jam_sore) ? $obat->jam_sore  : '' ?></td>
                        <td style="text-align:center"><?php echo isset($obat->jam_malam) ? $obat->jam_malam  : '' ?></td>
                    </tr>

                <?php } ?>
            </table>






        </div>
    </div>




</body>

</html>