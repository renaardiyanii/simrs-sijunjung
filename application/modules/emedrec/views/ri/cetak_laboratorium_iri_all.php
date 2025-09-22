<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <?php 
    foreach ($medrec as $kol) {
        $register = $this->M_emedrec_iri->get_nolab_pemeriksaan_lab($kol->no_register)->result();
        foreach ($register as $row) { 
            $data_pasien=$this->labmdaftar->get_data_pasien_cetak($row->no_lab)->row();
            $data_kategori_lab = $this->labmdaftar->get_data_kategori_lab($row->no_lab)->result();
			$data_jenis_lab=$this->labmdaftar->get_data_jenis_lab($row->no_lab)->result();
    ?>

    <div class="A4 sheet  padding-fix-10mm">
        <header style="margin-top:20px; font-size:1pt!important;">
                <table border="0" width="100%">
                    <tr>
                        <td width="13%">
                            <p align="center">
                            <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                        <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:8pt!important">
                                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:8pt">
                                <b><label>PEMERINTAHAN KABUPATEN SIJUNJUNG</label></b><br>
                                <b><label>RSUD AHMAD SYAFII MAARIF</label></b>
                            </font>    
                            <br>
                            <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                            <label>Email : rsudsijunjung1@gmail.com</label>
                        </td>
                        <td width="13%">
                            <p align="center">
                                <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                    </tr>
                </table>
        </header>
        <div style="height:0px;border: 2px solid black;"></div>
        <p align="center"><b>
        HASIL PEMERIKSAAN LABORATORIUM
        </b></p><br/>
        
            <table  border="0" cellpadding="0" cellspacing="1" width="100%">
                        <tr>
                            <td width="18%">No. Lab</td>
                            <td width="2%">:</td>
                            <td width="30%"><?= $data_pasien->no_lab ?></td>
                            <td width="18%">No Reg</td>
                            <td width="2%"> : </td>
                            <td width="30%"><?= $data_pasien->no_register?></td>
                        </tr>
                        <tr>
                            <td>No MR</td>
                            <td> : </td>
                            <td><?= $data_pasien->no_cm ?></td>
                            <td>Dokter</td>
                            <td> : </td>
                            <td><?php  
                                $nama_dokter=$this->labmdaftar->getnm_dokter($data_pasien->no_register)->row()->nm_dokter;
                                echo $nama_dokter ;
                            ?></td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td> : </td>
                            <td><b><?= $data_pasien->nama ?></b></td>
                            <td>Dr. PJ. Lab</td>
                            <td> : </td>
                            <td><?= $data_pasien->nm_dokter?></td>
                        </tr>
                        <tr>
                            
                            <td>Kelamin</td>
                            <td> : </td>
                            <td><?php
                                if($data_pasien->sex=="L"){
                                    echo "Laki-laki";
                                } else {
                                    echo "Perempuan";
                                } 
                            ?></td>
                            <td>Usia</td>
                            <td> : </td>
                            <?php
								// $age = date_diff(date_create($usia), date_create('now'))->y;
								// $age1 = date_diff(date_create($usia), date_create('now'))->m;
									?>
							<td><?= $usia->y.' '.'Tahun'.' '.$usia->m.' '.'Bulan'?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td> : </td>
                            <td><?= date("d F Y",strtotime($data_pasien->tgl_kunjungan))?></td>
                            <td>Status</td>
                            <td> : </td>
                            <td><?php
                                if($data_pasien->cara_bayar=='KERJASAMA'){
                                    // $a=$this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
                                    // echo $a->a - $a->b;
                                    echo $data_pasien->cara_bayar;
                                } else {
                                    echo $data_pasien->cara_bayar;
                                }
                            ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> : </td>
                            <td>
                                <?php 
                                    $almt = $data_pasien->alamat;
                                    if($data_pasien->rt!=""){
                                        $almt = $almt."RT". $data_pasien->rt ;
                                    }
                                    if($data_pasien->rw!=""){
                                        $almt = $almt."RW:". $data_pasien->rw;
                                    }
                                    if($data_pasien->kelurahandesa!=""){
                                        $almt = $almt.$data_pasien->kelurahandesa;
                                    }
                                    if($data_pasien->kecamatan!=""){
                                        $almt = $almt.$data_pasien->kecamatan;
                                    }
                                    if($data_pasien->kotakabupaten!=""){
                                        $almt = $almt."<br>".$data_pasien->kotakabupaten;
                                    }
                    
                                    echo $almt;
                                ?>
                            </td>
                            <td>Asal / Lokasi</td>
                            <td> : </td>
                            <td><?= 'Rawat Inap - '.$data_pasien->idrg; ?></td>
                        </tr>
            </table>
        
                <br>
                    <table width="100%" border="1">
                        <tr>
                            <th style="font-size:11px;text-align:center"  width="30%"><p align="center"><b>Jenis Pemeriksaan</b></p></th>
                            <th  style="font-size:11px;text-align:center"  width="30%"><p align="center"><b>Hasil</b></p></th>
                            <th style="font-size:11px;text-align:center"  width="15%"><p align="center"><b>Satuan</b></p></th>
                            <th style="font-size:11px;text-align:center"  width="25%"><p align="center"><b>Nilai Rujukan</b></p></th>
                        </tr>
                        <?php foreach ($data_kategori_lab as $rw) {
                        $tindakan=strtoupper($rw->nama_jenis); ?>
                        
                            <tr>
                                <th colspan="5"><p align="left" style="font-size:11px">
                                    <br/><b>Jenis Pemeriksaan : <i><?= $tindakan ?></i></b></p>
                                </th>
                            </tr>

                        <?php foreach($data_jenis_lab as $row){
                            if ($rw->kode_jenis == substr($row->id_tindakan,0,2)) { ?>
                            
                                    <tr>
                                        <th colspan="5"><p align="left" style="font-size:11px"><b>&nbsp;&nbsp;<?= $row->nmtindakan ?></b></p></th>
                                    </tr>

                                <?php $data_hasil_lab=$this->labmdaftar->get_data_hasil_lab($row->id_tindakan,$row->no_lab)->result();
                                foreach($data_hasil_lab as $row1){
                                    $kadar_normal = str_replace('<','&lt;',$row1->kadar_normal);
                                    $kadar_normal = str_replace('>','&gt;',$kadar_normal); ?>
                                <tr>
                                    <td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $row1->jenis_hasil ?></td>
                                    <td width="30%"><center><?= $row1->hasil_lab ?></center></td>
                                    <td width="15%"><?= $row1->satuan ?></td>
                                    <td width="25%"><?= $row1->kadar_normal ?></td>
                                </tr>


                            <?php 	}
                            }
                        }
                    } ?>
                    </table>

                    
                    <br/>
                    <table style="width:100%;" style="padding-bottom:5px;">
                        <tr>
                            <td width="65%" ></td>
                            <td width="35%"  style="text-align: center;">
                                <p  >
                        <br/>
                                <?= $kota_header.','.' '.date("d-m-Y",strtotime($data_pasien->tgl_kunjungan))	?>							
                                <?php 
                                    if($data_pasien->id_dokter != null){
                                        $cekeestttd = $this->labmdaftar->ttd_haisl($data_pasien->id_dokter)->row();
                                    }else{
                                        $cekeestttd = null;
                                    }
                                    
                                    if ($cekeestttd != null) {
                                ?>
                                    <img src="<?php echo $cekeestttd->ttd ?>" alt="">
                                <?php }else{} ?>
                                <br><br><br><?= $data_pasien->nm_dokter ?>
                                </p>
                            </td>
                        </tr>	
                    </table>
                    <br><p style="font-size:11px">*Penafsiran Makna hasil pemeriksaan laboratorium ini hanya dapat diberikan oleh dokter</p>
    
    </div>
    
    <?php } ?>
    <?php } ?>
    
</body>

</html>