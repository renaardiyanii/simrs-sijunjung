<?php 
    function write_rm($str) {
        $length = strlen($str);
        $thisWordCodeVerdeeld = "";
        for ($i=0; $i<$length; $i++) {
            $thisWordCodeVerdeeld = $thisWordCodeVerdeeld  . "<span class='tanpa-kotak'>".$str[$i]."</span>";
            if (($i+1)%2==0) {
                $thisWordCodeVerdeeld = $thisWordCodeVerdeeld. "-";
            }
        }
        return rtrim($thisWordCodeVerdeeld,'-');
    }
    ?>

<head>
    <title></title>
</head>

<style>
#data {
    /* margin-top: 10px; */
    /* border-collapse: collapse; */
    /* border: 1px solid black;     */
    width: 100%;
    font-size: 11px;
    /* position: relative; */


}

#data tr td {

    font-size: 12px;
    font-family: arial;

}

#data th {

    font-size: 12px;
    font-family: arial;

}

#noborder td {
    font-family: arial;
    font-size: 12px;
}
</style>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">

    <div class="A4 sheet  padding-fix-10mm">
        <header>
                <table id="data" border="2" style="margin-top:80px">
                    <tr>
                        <td width="80%">
                            <table>
                                <tr>
                                    <td width="10%">
                                        <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="80px" width="70px" style="padding-right:15px;">
                                    </td>
                                    <td><i>
                                        
                                        <span style="font-size:20px;font-weight:bold;">RSUD AHMAD SYAFII MAARIF</span><br>
                                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                                        <span>Tanah Badantung- Kabupaten Sijunjung<span>
                                        </i>
                                    </td>
                                
                                </tr>
                            </table>  
                        </td>
                        <td>
                            <center><b><p style="vertical-align:middle;"><br>
                            <span>No.Dokumen : </span><br>
                            <span>Rev.I.I/2018/RM.01/RJ-GN</span>
                            </center></b>
                            </p>

                        </td>
                      
                    </tr>
                </table>
        </header>

        <table id="data" border="2"  cellpadding="10px">
            <tr>
                <td width="50%">
                    <center><h2><i>REGISTRASI PASIEN</h2><i></center> 
                </td>
                <td><br>
                    No. RM: &nbsp;<?php echo write_rm($data_pasien->no_cm);?>
                </td>
                
            </tr>
        </table>  

        <table id="data" border="2" cellpadding="10px">
            <tr>
                <td width="35%">
                    <center>Tgl : <?= date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)) ?></center> 
                </td>
                <td width="35%">
                    <center>Jam Datang : <?= date('h:i',strtotime($data_daftar_ulang->tgl_kunjungan)) ?></center>
                </td>
                <td>
                    <?php 
                    $datetime = new DateTime($data_daftar_ulang->tgl_kunjungan, new DateTimeZone('UTC')); // asumsikan inputnya UTC
                    $datetime->setTimezone(new DateTimeZone('Asia/Jakarta')); // ubah ke zona waktu lokal
                    $tgl = $datetime->format('H:i'); // 24 jam
                    
                    ?>
                    <center>Jam Registrasi : <?= date('h:i',strtotime($data_daftar_ulang->tgl_kunjungan)) ?></center>
                </td>
                
            </tr>
        </table> 
        
        <table id="data" border="2" cellpadding="15px">
            <tr>
                <td>
                    <span>Cara Datang :</span>
                    <input type="checkbox"  value=""<?php echo isset($data_daftar_ulang->cara_dtg)?($data_daftar_ulang->cara_dtg == "sendiri" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Sendiri</label>

                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data_daftar_ulang->cara_dtg)?($data_daftar_ulang->cara_dtg == "Keluarga" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Keluarga</label>

                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data_daftar_ulang->cara_dtg)?($data_daftar_ulang->cara_dtg == "Ambulance" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Ambulance</label>

                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data_daftar_ulang->cara_dtg)?($data_daftar_ulang->cara_dtg == "Polisi" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Polisi</label>
                </td>
            </tr>

            <tr>
                <td>
                    <span>Rujukan :</span>
                    <input type="checkbox"  value=""<?php echo isset($data_daftar_ulang->cara_kunj)?($data_daftar_ulang->cara_kunj == "DATANG SENDIRI" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Tidak</label>

                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data_daftar_ulang->cara_kunj)?($data_daftar_ulang->cara_kunj != "DATANG SENDIRI" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Ya,</label>

                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data_daftar_ulang->cara_kunj)?($data_daftar_ulang->cara_kunj == "RUJUKAN RS" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">RS</label>

                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data_daftar_ulang->cara_kunj)?($data_daftar_ulang->cara_kunj == "RUJUKAN PUSKESMAS" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Puskesmas</label>

                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data_daftar_ulang->cara_kunj)?($data_daftar_ulang->cara_kunj == "DIKIRIM DOKTER" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Dokter</label>
                </td>
            </tr>
        </table>

        <table id="data"  border="2"  cellpadding="10px">
            <tr>
                <td width="2%">
                    <span>IDENTITAS</span>
                </td>
                <td>
                    <table id="data" cellpadding="5px">
                                <tr>
                                <td width="23%">Nama</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= $data_pasien->nama ?></td>
                                <td width="23%">Tempat Lahir</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= $data_pasien->tmpt_lahir ?></td> 
                                </tr>

                                <tr>
                                <td width="23%">Pekerjaan</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= $data_pasien->pekerjaan ?></td>
                                <td width="23%">Tgl Lahir</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= date('d-m-Y',strtotime($data_pasien->tgl_lahir)) ?></td> 
                                </tr>

                                <tr>
                                <td width="23%">Agama</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= $data_pasien->agama ?></td>
                                <td width="23%">Jenis Kelamin</td>
                                <td width="2%">:</td>
                                <td width="25%">
                                        <?php  
                                        if($data_pasien->sex == 'P'){
                                            echo 'Perempuan';
                                        }else{
                                            echo 'Laki-laki';
                                        }
                                        
                                        ?>
                                </td> 
                                </tr>

                                <tr>
                                <td width="23%">Pendidikan</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= $data_pasien->pendidikan ?></td>
                                <td width="23%">Status Perkawinan</td>
                                <td width="2%">:</td>
                                <td width="25%">
                                        <?php  
                                            if($data_pasien->status == 'B'){
                                                echo 'Belum Kawin';
                                            }else if($data_pasien->status == 'K'){
                                                echo 'Sudah Kawin';
                                            }else{
                                                echo 'Janda/Duda';
                                            }
                                        ?>
                                    </td> 
                                </tr>

                                <tr>
                                <td width="23%">Bahasa</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= $data_pasien->bahasa ?></td>
                                <td width="23%">Etnis</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= $data_pasien->suku_bangsa ?></td> 
                                </tr>

                                <tr>
                                <td width="23%">Alamat</td>
                                <td width="2%">:</td>
                                <td width="25%" colspan="4"><?= $data_pasien->alamat ?></td>
                                </tr>

                    </table>
                </td>
            </tr>

            <tr>
                <td width="2%">
                    <span>PENANGGUNG JAWAB</span>
                </td>
                <td>
                    <table id="data" cellpadding="5px">
                            <tr>
                                <td width="23%">Nama</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= $data_pasien->nm_penanggung_jawab ?></td>
                                <td width="23%">No. Telp / HP</td>
                                <td width="2%">:</td>
                                <td width="25%"><?= $data_pasien->no_hp_tg_jawab ?></td> 
                            </tr>

                            <tr>
                                <td>Umur</td>
                                <td>:</td>
                                <td><?= $data_pasien->umur_penanggung_jawab ?></td>
                                <td>Hubungan</td>
                                <td>:</td>
                                <td><?= $data_pasien->hub_tg_jawab ?></td> 
                            </tr>

                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><?= $data_pasien->sex_penanggung_jawab ?></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                            </tr>

                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td colspan="4"><?= $data_pasien->alamat_tg_jawab ?></td>
                            </tr>
                    </table>
                </td>
            
            </tr>

            <tr>
                <td width="2%">
                    <span>CARA BAYAR</span>
                </td>
                <td>
                    <table id="data" cellpadding="5px">
                            <tr>
                                <td width="23%">
                                    <input type="checkbox"  value=""<?php echo isset($data_daftar_ulang->cara_bayar)?($data_daftar_ulang->cara_bayar == "UMUM" ? "checked" : "disabled"):'';?>>
                                </td>
                                <td width="2%">:</td>
                                <td>  <label for="sendiri">Pasien Umum</label></td>
                            </tr>

                            <tr>
                                <td width="23%">
                                    <input type="checkbox"  value=""<?php echo isset($data_daftar_ulang->cara_bayar)?($data_daftar_ulang->cara_bayar == "BPJS" ? "checked" : "disabled"):'';?>>
                                </td>
                                <td width="2%">:</td>
                                <td>  <label for="sendiri">Pasien JKN</label></td>
                            </tr>

                            <tr>
                                <td width="23%">
                                    <input type="checkbox"  value=""<?php echo isset($data_daftar_ulang->cara_bayar)?($data_daftar_ulang->cara_bayar == "" ? "checked" : "disabled"):'';?>>
                                </td>
                                <td width="2%">:</td>
                                <td>  <label for="sendiri">Sedang dalam pengurusan JKN ( 3 x 24 jam hari kerja )</label></td>
                            </tr>

                            <tr>
                                <td width="23%">
                                    <input type="checkbox"  value=""<?php echo isset($data_daftar_ulang->cara_bayar)?($data_daftar_ulang->cara_bayar == "KERJASAMA" ? "checked" : "disabled"):'';?>>
                                </td>
                                <td width="2%">:</td>
                                <td>  <label for="sendiri">Pasien JKN Tenaga Kerja, PT.Jasa Raharja,lainnya <?= isset($data_daftar_ulang->nmkontraktor)?$data_daftar_ulang->nmkontraktor:'' ?> </label></td>
                            </tr>
                    </table>
                </td>
            
            </tr>

            <tr>
                <td colspan ="2">
                <div style="display: inline; position: relative;">
                    <div style="float: left;margin-top: 15px;">
                        <p><br></p>
                        <p>Petugas TPP</p>
                        <br><br><br>
                        <?php 
                             $id =isset($data_pasien->userid)?$data_pasien->userid:null;                                    
                             $query1 = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                            ?>
                            <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br>  
                                 
                    </div>
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
                            <p>Penanggung Jawab Pasien</p>
                            <br><br><br>
                            <span>( <?= $data_pasien->nm_penanggung_jawab ?> )</span><br> 
                           
                    </div>  
             </div>
                </td>
            </tr>

                    

                    
        </table> 

    </div>


</body>

</html>