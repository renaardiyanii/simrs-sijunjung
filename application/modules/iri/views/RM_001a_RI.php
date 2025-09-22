<?php foreach ($data_pengantar as $row) { ?>

<!DOCTYPE html>
<html>
    <hea><title></title></hea>
    <style>
        p{
            margin-left: 5px;
        }

        .header-parent{
            display: flex;
            justify-content: space-between;

        }
        .ttd{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            margin-right: 50px;
        }
        #childttd{
            display: flex;
            flex-direction: column;
            /* align-items: center; */
        } 
        @page { margin: 0 }
body { margin: 0 }
.sheet {
  margin: 0;
  overflow: hidden;
  position: relative;
  box-sizing: border-box;
  page-break-after: always;
}

/** Paper sizes **/
body.A3               .sheet { width: 297mm; height: 419mm }
body.A3.landscape     .sheet { width: 420mm; height: 296mm }
body.A4               .sheet { width: 210mm; height: 296mm }
body.A4.landscape     .sheet { width: 297mm; height: 209mm }
body.A5               .sheet { width: 148mm; height: 209mm }
body.A5.landscape     .sheet { width: 210mm; height: 147mm }
body.letter           .sheet { width: 216mm; height: 279mm }
body.letter.landscape .sheet { width: 280mm; height: 215mm }
body.legal            .sheet { width: 216mm; height: 356mm }
body.legal.landscape  .sheet { width: 357mm; height: 215mm }

/** Padding area **/
.sheet.padding-10mm { padding: 10mm }
.sheet.padding-15mm { padding: 15mm }
.sheet.padding-20mm { padding: 20mm }
.sheet.padding-25mm { padding: 25mm }

/** For screen preview **/
@media screen {
  body { background: white }
  .sheet {
    background: white;
    box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
    margin: 5mm auto;
  }
}

/** Fix for Chrome issue #273306 **/
@media print {
           body.A3.landscape { width: 420mm }
  body.A3, body.A4.landscape { width: 297mm }
  body.A4, body.A5.landscape { width: 210mm }
  body.A5                    { width: 148mm }
  body.letter, body.legal    { width: 216mm }
  body.letter.landscape      { width: 280mm }
  body.legal.landscape       { width: 357mm }
}

    </style>
    <body class="A4">
        <header style="margin-top:20px;">
            <table border="0" style="width:100%;">
                <tr>
                    <td width="13%">
                        <p align="center">
                            <img src="<?= base_url("assets/img/kementriankesehatan.png"); ?>" alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>
                    <td  width="74%" style="font-size:13px;" align="center">
                        <font style="font-size:20px">
                            <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                        </font>
                        <font style="font-size:17px">
                            <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                            <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                        </font>    
                        <br>
                        <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                        <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                    </td>
                    <td width="13%">
                        <p align="center">
                            <img src=" <?= base_url("assets/img/logo.png"); ?>"  alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>          
                </tr>
            </table>
        </header>
        <hr style="height: 3px;background-color: black;">
        <p style = "font-weight:bold; font-size: 20px; text-align: center;"><u>
            SURAT PENGANTAR RAWAT INAP</u>
        </p> <br>
        <p>
            Mohon dilakukan Perawatan Lebih Lanjut
        </p>
        <table>
            <tr>
                <td><p> Di Ruangan</p></td>
                <td><p>:</p></td>
                <td><p><?php echo $row->nmruang ?></p></td>
            </tr>
            <tr>
                <td><p>Nama Pasien</p></td>
                <td><p>:</p></td>
                <td><p><?php echo $row->nama ?></p></td>
            </tr>
            <tr>
                <td><p>No. Rekam Medis</p></td>
                <td><p>:</p></td>
                <td><p><?php echo $row->no_cm ?></p></td>
            </tr>
            <tr>
                <td><p>Jenis Kelamin</p></td>
                <td><p>:</p></td>
                <td><p><?php echo ($row->sex=='L' ? 'Laki-Laki' : 'Perempuan') ?></p></td>
            </tr>
            <tr>
                <td><p>Alamat</p></td>
                <td><p>:</p></td>
                <td><p><?php echo ($row->alamat=='' ? '' :$row->alamat).' '.($row->kelurahandesa!='' ? 'KEL. '.$row->kelurahandesa:'').' '.($row->kecamatan!='' ? 'KEC. '.$row->kecamatan:'').' '.($row->kotakabupaten!='' ? ', '.$row->kotakabupaten:'').' '.($row->provinsi!='' ? ', '.$row->provinsi:'') ?></p></td>
            </tr>
            <tr>
                <td><p>Diagnosa</p></td>
                <td><p>:</p></td>
                <td><p><?php echo $row->nm_diagnosa ."(".$row->diagmasuk.")" ?></p></td>
            </tr>
            <tr>
                <td><p>Dikirim dari</p></td>
                <td><p>:</p></td>
                <td><p>
                <span> 
                <input type="checkbox" value="IGD" <?php echo ($row->dikirim_oleh=='IGD' ? 'checked' : 'disabled') ?> >
                <label for="IGD">IGD</label></span>
            <span> 
                <input type="checkbox" value="POLIKLINIK" <?php echo ($row->dikirim_oleh=='POLIKLINIK' ? 'checked' : 'disabled') ?>>
                <label for="POLIKLINIK">POLIKLINIK</label></span>
            <span> 
                <input type="checkbox" value="LAINNYA" <?php if($row->dikirim_oleh != 'IGD' || $row->dikirim_oleh !='POLIKLINIK'){
                                                                     echo 'checked' ;
                                                            }else{ 
                                                                echo 'disabled';
                                                            } ?> 
                                                            >
                <label for="LAINNYA">LAINNYA</label> (<?php if($row->dikirim_oleh !='IGD' || $row->dikirim_oleh !='POLIKLINIK'){ echo $row->dikirim_oleh; }else{ echo '';} ?>)</span>
                </p></td>
            </tr>
        </table>
        
        
        
        
        
    
        <br><br><br><br><br><br><br><br><br><br><br>
    <div class="ttd">
        <div id="childttd">
        <span>Bukittinggi,<?php echo date('d F Y') ?></span><br>
        <span>Dokter Pengirim,</span>
            <br><br><br>
            <span>(...........................)</span><br>
            <span><?php echo $row->dikirim_oleh_teks ?></span>
        </div>
    </body>
    <br><br><br><br><br><br>
    <footer>
        Rev.02.01.2020.RM-001a / RI
    </footer>
</html>


<?php } ?>