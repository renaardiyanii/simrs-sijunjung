<?php foreach($data_identitas as $value){
//    var_dump($value);
    $tahun = substr($value->tgl_lahir,0,4);
    $bulan = substr($value->tgl_lahir,5,2);
    $hari = substr($value->tgl_lahir,8,2);

    $value->tgl_lahir = $hari .'-'.$bulan.'-'.$tahun;
    // echo $kekhususan;
    // die();


    switch ($value->status) {
        case "B":
          $value->status = 'Belum Kawin';
          break;
        case "C":
            $value->status = 'Cerai';
          break;
        default:
            $value->status = 'Kawin';
          break;
      }

    
    function write_in_a_box($str, $l=28) {
        $length = strlen($str);
        $thisWordCodeVerdeeld = "";
        if ($length > $l) {
            $length = $l;
        } else {
            $length = $l;
        }
        $s = str_pad($str, $length," ");
        for ($i=0; $i<$length; $i++) {
            if ($s[$i]==" ") {$c = "&nbsp;";}
            else {$c = $s[$i];}
            $thisWordCodeVerdeeld = $thisWordCodeVerdeeld  . "<span class='kotakin'>".$c."</span>";
        }
        $result = $thisWordCodeVerdeeld;
        //echo $result;
        return $result;
    }
    function write_in_a_box_second($str) {
        // $length = strlen($str);
        $thisWordCodeVerdeeld = "";
        $length = 56;
        $s = str_pad($str, $length," ");
        for ($i=28; $i<$length; $i++) {
            if ($s[$i]==" ") {$c = "&nbsp;";}
            else {$c = $s[$i];}
            $thisWordCodeVerdeeld = $thisWordCodeVerdeeld  . "<span class='kotakin'>".$c."</span>";
        }
        $result = $thisWordCodeVerdeeld;
        //echo $result;
        return $result;
    }


    function write_jk($jk) {
        if ($jk =="L") {
            echo 'Laki-Laki';            
        } else {
            echo 'Perempuan';            
        }
    }


    function write_cb($list, $selected) {
        $retval = "";
        foreach ($list as $l)
        {
            
            if ($l == $selected) {
                $retval = $retval . "✓&nbsp;" . $l . ",&nbsp;";
            } else {
                // for($i= 0; $i<strlen())
                // print_r(strlen($l));
                $retval = $retval . "◻&nbsp;" . $l . ",&nbsp;";
            }
        }
        $retval = rtrim($retval,",&nbsp;");
        

        return $retval;
    }
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
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
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
       .margin-left-3px{
           margin-left:3px;
       }

       .margin-right-3px{
           margin-right:3px;
       }
   
       .kotak {
           float: left;
           text-align:center;
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
           padding:0px 10px;
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
   
       /* .ttd {
           display: flex;
           flex-direction: column;
           justify-content: center;
           align-items: flex-end;
           margin-right: 50px;
           font-size: 11px;
       } */
   
       /* #childttd {
           display: flex;
           flex-direction: column;
           align-items: center; */
           /* font-size: 11px; */
       /* } */
       .center{
           width:100%;
           margin:auto;
           text-align: center;
           /* background-color: aquamarine; */
       }
       td {line-height: 2; vertical-align:top;font-size:small;}
       .padding-fix-10mm {padding-top:0mm; padding-left: 10mm;padding-right: 10mm;}

       .table tr td{
           font-size:8.5pt!important;
       }

       .table2 tr td{
           font-size:6.5pt!important;
       }
       .table_nama{
            border-collapse: separate;
            border-radius:8px;
            border:2px solid black;
            background:#fff;
       }
   </style>
   <script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
   <!-- <link href="<?php //echo base_url('assets/style_print.css'); ?>" rel="stylesheet"> -->
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4" >
       <div class="A4 sheet padding-fix-10mm">
       <header style="margin-top:15px; ">
            <!-- <table style="width: 100%;" border="0">
                    <tr>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                        <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:12px">
                                <b><label for="">KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:11px">
                                <b><label for="">DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                <b><label for="">RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                            </font>    
                            <br>
                            <label for="">Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                            <label for="">Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                        </td>
                        <td width="13%">
                            <p align="center">
                                <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="3" style="text-align:right; margin-top:20px;margin-bottom:2px;">
                        No. RM: &nbsp;<?php echo write_rm($value->no_cm);?>
                    </td>
                </tr>
            </table> -->


            <table border="0" width="100%">
<tr>
    <td width="10%">
        <p align="center">
        <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80px" width="80px" style="padding-right:15px;">
        </p>
    </td>

    <td  width="0%"  align="left" style="font-size:18px;font-weight:bold;">
    <p style="margin-top:20px">
        <span>RSUD SIJUNJUNG</span><br>
    </p>
    </td>

    <td width="45%">
        <span style="font-weight:bold;font-size:12px;text-align: right;display:block;margin-right:5px">
       
        </span>

        <table class="table_nama" width="100%">
                <tr>
                </tr>
                <tr>
                    <td width="33%"  style="font-size:12px"><span>Nama</span></td>
                    <td width="2%"  style="font-size:12px"><span>:</span></td>
                    <td width="45%"  style="font-size:12px"><span><?php  echo $value->nama??""; ?></span></td>
                    <td width="20%"  style="font-size:12px"></td>
                </tr>
                <tr>
                    <td style="font-size:12px"><span>NIK</span></td>
                    <td style="font-size:12px"><span>:</span></td>
                    <td style="font-size:12px"><span><?php echo  $value->no_identitas??""; ?></span></td>
                    <td style="font-size:12px"></td>
                </tr>
                <tr>
                    <td style="font-size:12px"><span>No. RM</span></td>
                    <td style="font-size:12px"><span>:</span></td>
                    <td style="font-size:12px"><span><?php echo  $value->no_cm??""; ?></span></td>
                    <td style="font-size:12px"><span>(<?php echo  $value->sex??""; ?>)</span></td>
                </tr>
                <tr>
                    <td style="font-size:12px"><span>Tgl Lahir</span></td>
                    <td style="font-size:12px"><span>:</span></td>
                    <td style="font-size:12px"><span><?php echo date('d-m-Y',strtotime( $value->tgl_lahir))??"";//substr( $value->tgl_lahir,0,10); ?></span></td>
                    <td style="font-size:12px"><span>
                    <svg class="barcode"
                     jsbarcode-format="code128"
                     jsbarcode-height="30"
                     jsbarcode-width="1"
                     jsbarcode-displayValue="false"
                     jsbarcode-value="<?=  $value->no_cm??""; ?>"
                     jsbarcode-textmargin="0"
                     jsbarcode-margin="0"
                     jsbarcode-marginTop="5"
                     jsbarcode-marginRight="5"
                     jsbarcode-fontoptions="bold">
                     </svg>

                 <script>JsBarcode(".barcode").init();</script>
                    </span></td>
                </tr>
            <?php
               // }
            ?>
        </table> 
    </td>

    </tr>
   
    </table>
       </header>

       <div style="height:0px;border: 2px solid black;"></div>
       <div class="center">
           <p class="judul">
               FORMULIR PENDAFTARAN PASIEN BARU RAWAT JALAN/ GAWAT DARURAT
           </p>
       </div>
       <div class="content">
           <table class="table" >
               <tr>
                   <td style="line-height: 1.5;">Nama</td>
                   <td >:&nbsp;<?php echo $value->nama; ?></td>
                </tr>
                <tr>
                   <td>Jenis Kelamin</td>
                   <td>:&nbsp;<?php echo write_jk($value->sex); ?></td>
                </tr>
                <tr>
                   <td>Tempat/Tgl Lahir</td>
                   <td>:&nbsp;<?php echo $value->tmpt_lahir .'/'.$value->tgl_lahir; ?></td>
                </tr>
                <tr>
                   <td>Agama</td>
                   <td>:&nbsp;<?php echo ucwords(strtolower($value->agama)); ?></td>
                </tr>
                <tr>
                   <td>Status Perkawinan</td>
                   <td>:&nbsp;<?php echo $value->status; ?></td>
                </tr>
                <tr>
                   <td>Pekerjaan</td>
                   <td>:&nbsp;<?php echo $value->pekerjaan; ?></td>
                </tr>
                <tr>
                   <td>Pendidikan Terakhir</td>
                   <td>:&nbsp;<?php echo $value->pendidikan; ?></td>
                </tr>
                <tr>
                <td>Alamat  </td>
                <td>:&nbsp;<?php echo $value->alamat; ?></td>
                </tr>
            
            </tr>
            <tr><td></td><td>RT :&nbsp;<?php echo $value->rt; ?>, RW :&nbsp;<?php echo $value->rw; ?></td></tr>
            <tr><td></td><td>Kelurahan :&nbsp;<?php echo $value->kelurahandesa; ?></td></tr>
            <tr><td></td><td>Kecamatan :&nbsp;<?php echo $value->kecamatan; ?></td></tr>
            <tr><td></td><td>Kota/Kab &nbsp;:&nbsp;<?php echo $value->kotakabupaten; ?></td></tr>
            <tr><td></td><td>Propinsi &nbsp;:&nbsp;<?php echo $value->provinsi; ?></td></tr>
            <tr><td></td><td>No HP. &nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $value->no_hp; ?></td></tr>

            <tr>
                <td>Alamat Yang Bisa Dihubungi </td>
                <td>:&nbsp;<?php echo $value->alamat2; ?></td>
                </tr>
                <tr>
                   <td>Nama Suami / Istri Pasien</td>
                   <td>:&nbsp;<?php 
                    //if($value->suami != ""){
                        // echo $value->suami;
                        echo ucwords(strtolower($value->suami_istri));
                    // }else{
                    //     echo ucwords(strtolower($value->istri));
                    //     // echo $value->istri;
                    // }
                    // // echo ucwords(strtolower($value->su));
                     ?>
                    </td>
                </tr>
                <tr>
                   <td>Nama Ayah Pasien</td>
                   <td>:&nbsp;<?php echo ucwords(strtolower($value->nama_ayah)); ?></td>
                </tr>
                <tr>
                   <td>Nama Ibu Pasien</td>
                   <td>:&nbsp;<?php echo ucwords(strtolower($value->nama_ibu)); ?></td>
                </tr>
                <tr>
                   <td>Poliklinik Yang Dituju</td>
                   <td>:&nbsp;<?php 
                   echo ucwords(strtolower($poliklinik_mana));
                    // echo "POLIKLINIK";
                    ?></td>
                </tr>
                <tr>
                   <td>Bahasa Sehari - Hari</td>
                   <td>:&nbsp;<?php echo ucwords(strtolower($value->bahasa)); ?></td>
                </tr>
                <tr>
                   <td>Kekhususan</td>
                   <td>:
                       <?php 
                     
                       echo ucwords(strtolower($kekhususan)); 
                    // echo "KEKHUSUSAN"
                       ?>
                       </td>
                </tr>
                <tr>
                   <td>Suku Bangsa</td>
                   <td>:&nbsp;<?php echo ucwords(strtolower($value->suku_bangsa)); ?></td>
                </tr>
                
            </table>          
              
       </div>
       
       <div style="border: 1px solid; margin-top:0mm;">
           <p style="font-weight: bold;text-align: center; font-size: 8pt;">PERSETUJUAN UMUM</p>
           <ol>
               <li style="font-size: 8pt!important;">Bahwa saya akan mentaati semua peraturan yang ada di Rumah Sakit Umum Daerah Sijunjung.</li>
               <li style="font-size:  8pt!important">Bahwa saya menyetujui untuk dilakukan pemeriksaan/ tindakan yang diperlakukan
                   dalam upaya kesembuhan/ keselamatan jiwa saya/ pasien tersebut di atas.</li>
               <li style="font-size:  8pt!important">Bahwa saya memberi kuasa kepada dokter yang merawat untuk memberikan keterangan
                   medis saya kepada pihak yang bertanggung jawab atas biaya perawatan saya.</li>
               <li style="font-size:  8pt!important">Bahwa saya MENYETUJUI/MENOLAK* identitas saya diinformasikan kepada
                   ....................</li>
           </ol>
        
               <table width="100%">
                   <tr>
                       <td width="70%">
                            <span style="font-size:12px">Tanah Badantung, <?= isset($value->tgl_daftar)? date('d-m-Y',strtotime($value->tgl_daftar)):''; ?></span>
                            <table>
                            <tr>
                                    <td><img style="margin-left:3em;" width="80px" src="<?= isset($value->ttd)?$value->ttd:''; ?>" alt=""></td>
                            </tr>
                            </table>
                            <span style="font-size:12px"> (<?=isset($value->nama_pemeriksa)?' '.$value->nama_pemeriksa.' ':'' ; ?>)</span><br>
                       </td>


                        

                       <td width="30%">
                            <span style="font-size:12px">Tanah Badantung, <?= isset($value->tgl_daftar)? date('d-m-Y',strtotime($value->tgl_daftar)):''; ?></span>
                            <table>
                            <tr>
                                    <td><img style="margin-left:3em;" width="80" src="<?= isset($value->ttd_pasien)?$value->ttd_pasien:''; ?>" alt=""></td>
                            </tr>
                            </table>
                            <span style="font-size:12px">(<?= isset($value->nama)?' '.$value->nama.' ':'' ; ?>)</span><br>
                       </td>
                   </tr>
               </table>
            
          
       </div>
   
   
       </div>
       </div>
       
   
   
   </body>
   
   </html>
   <?php } ?>
   
   