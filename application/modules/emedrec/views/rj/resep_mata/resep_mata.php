<?php
$data = isset($resep_mata->formjson)?json_decode($resep_mata->formjson):'';
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet padding-fix-10mm"><br>
        <header>
            <table style="width: 100%; border: 0;">
                <tr>
                    <td style="text-align: center;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="70px" width="70px" style="padding-bottom: 4px;">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 15px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RSUD AHMAD SYAFII MAARIF</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Email : rsudsijunjung1@gmail.com</label>
                    </td>
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black; margin-top: 2px;"></div>


        <!-- Tambahkan gambar di bawah isi surat rujukan -->
        <div style="text-align: center; margin-top: 20px;">
            <img src="<?= base_url('assets/images/mata1.png'); ?>" alt="gambar tambahan" style="max-width: 100%; height: auto;">
        </div>

        
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
            <tr>  
                <td tyle="border: 1px solid black;" colspan="6" ><center> O.D </center></td> 
                <td tyle="border: 1px solid black;" colspan="8" ><center> O.S </center></td>  
            </tr> 
            <tr>  
                <td style="border: 1px solid black;"></td>  
                <td style="border: 1px solid black;">Vitrum Spher</td>  
                <td style="border: 1px solid black;">Vitrum Cylndr</td>  
                <td style="border: 1px solid black;">Axis</td>  
                <td style="border: 1px solid black;">Prisma</td>  
                <td style="border: 1px solid black;">Basis</td>   
                <td style="border: 1px solid black;">Vitrum Spher</td>  
                <td style="border: 1px solid black;">Vitrum Cylndr</td>  
                <td style="border: 1px solid black;">Axis</td>  
                <td style="border: 1px solid black;">Prisma</td>  
                <td style="border: 1px solid black;">Basis</td>  
                <td style="border: 1px solid black;">Golor Vitror</td>  
                <td style="border: 1px solid black;">Distant Pupil</td>   
            </tr>  
            <tr>  
                <td style="border: 1px solid black;">Prologin Quitat</td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prologin->vitrum)?$data->question2->prologin->vitrum:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prologin->vitrum_cy)?$data->question2->prologin->vitrum_cy:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prologin->axis)?$data->question2->prologin->axis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prologin->prisma)?$data->question2->prologin->prisma:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prologin->basis)?$data->question2->prologin->basis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prologin->vitrum)?$data->question3->prologin->vitrum:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prologin->vitrum_cy)?$data->question3->prologin->vitrum_cy:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prologin->axis)?$data->question3->prologin->axis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prologin->prisma)?$data->question3->prologin->prisma:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prologin->basis)?$data->question3->prologin->basis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prologin->golor)?$data->question3->prologin->golor:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prologin->distan)?$data->question3->prologin->distan:'' ?></td>  
            
                
            </tr>  
            <tr>  
                <td style="border: 1px solid black;">Prodomo</td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prodomo->vitrum)?$data->question2->prodomo->vitrum:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prodomo->vitrum_cy)?$data->question2->prodomo->vitrum_cy:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prodomo->axis)?$data->question2->prodomo->axis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prodomo->prisma)?$data->question2->prodomo->prisma:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->prodomo->basis)?$data->question2->prodomo->basis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prodomo->vitrum)?$data->question3->prodomo->vitrum:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prodomo->vitrum_cy)?$data->question3->prodomo->vitrum_cy:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prodomo->axis)?$data->question3->prodomo->axis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prodomo->prisma)?$data->question3->prodomo->prisma:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prodomo->basis)?$data->question3->prodomo->basis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prodomo->golor)?$data->question3->prodomo->golor:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->prodomo->distan)?$data->question3->prodomo->distan:'' ?></td> 
                
            
            </tr>  
            <tr>  
                <td style="border: 1px solid black;">Pro Propin Quitat</td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->pro_propin->vitrum)?$data->question2->pro_propin->vitrum:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->pro_propin->vitrum_cy)?$data->question2->pro_propin->vitrum_cy:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->pro_propin->axis)?$data->question2->pro_propin->axis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->pro_propin->prisma)?$data->question2->pro_propin->prisma:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question2->pro_propin->basis)?$data->question2->pro_propin->basis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->pro_propin->vitrum)?$data->question3->pro_propin->vitrum:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->pro_propin->vitrum_cy)?$data->question3->pro_propin->vitrum_cy:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->pro_propin->axis)?$data->question3->pro_propin->axis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->pro_propin->prisma)?$data->question3->pro_propin->prisma:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->pro_propin->basis)?$data->question3->pro_propin->basis:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->pro_propin->golor)?$data->question3->pro_propin->golor:'' ?></td>  
                <td style="border: 1px solid black;"><?= isset($data->question3->pro_propin->distan)?$data->question3->pro_propin->distan:'' ?></td> 
            
            </tr>  
        
    </table>
    <br><br>
    <span> RESEP KACAMATA</span><br><br>
    <span> Pro : <?= isset($data->question4->pro)?$data->question4->pro:'' ?></span><br>
    <span> Umur : <?= isset($data->question4->umur)?$data->question4->umur:'' ?></span>

            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($resep_mata->tgl_input) ? date('d-m-Y H:i:s', strtotime($resep_mata->tgl_input)) : '' ?></p>
                            <p>Yang menerangkan</p><br><br>
                            <?php 
                            // $id1 =isset($resep_mata->id_pemeriksa)?$resep_mata->id_pemeriksa:null; 
                                                             
                            $query1 = $this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = '135'")->row();
                            // var_dump($query1);die()  
                            ?>
                            <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="120px" width="120px"><br>
                            <!-- <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br>  -->
                           (dr. Putrigusti Admira, Sp. M)
                    </div>  
                </div>
    </div>
</body>

</html>
