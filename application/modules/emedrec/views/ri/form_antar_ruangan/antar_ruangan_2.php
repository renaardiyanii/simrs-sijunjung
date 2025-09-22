
<div style="min-height:870px">

    <table id="data" border="1" cellspacing="0" cellpadding="0" >
        <tr style="height: 10px;">
            <td style="width: 25%;text-align:center;font-weight:bold">Status Kemandirian</td>
            <td style="width: 45%;text-align:center;font-weight:bold">Mandiri</td>
            <td style="width: 15%;text-align:center;font-weight:bold">Butuh Bantuan</td>
            <td style="width: 15%;text-align:center;font-weight:bold">Tidak dapat melakukan</td>
        </tr>
        <tr style="height: 10px;">
            <td rowspan="2">Aktifitas di tempat tidur</td>
            <td style="padding-left:5px;">Berguling</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'1'})?in_array("1",$data->status_kemandirian->{'Butuh Bantuan'}->{'1'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'1'})?in_array("1",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'1'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td style="padding-left:5px;">Duduk</td>
            <td  style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'1'})?in_array("2",$data->status_kemandirian->{'Butuh Bantuan'}->{'1'})?"✓":"":'' ?></td>
            <td  style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'1'})?in_array("2",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'1'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td rowspan="5">Higiene Pribadi</td>
            <td style="padding-left:5px;">Wajah, rambut, tangan</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?in_array("1",$data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?in_array("1",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td style="padding-left:5px;">Batang tubuh & perinium</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?in_array("2",$data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?in_array("2",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td style="padding-left:5px;">Ekstrimitas bawah</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?in_array("3",$data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?in_array("3",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td style="padding-left:5px;">Traktus Digestivus</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?in_array("4",$data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?in_array("4",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td style="padding-left:5px;">Traktus urinarius</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?in_array("5",$data->status_kemandirian->{'Butuh Bantuan'}->{'2'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?in_array("5",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'2'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td rowspan="3">Berpakaian </td>
            <td style="padding-left:5px;">Ektrimitas atas</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'3'})?in_array("1",$data->status_kemandirian->{'Butuh Bantuan'}->{'3'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'3'})?in_array("1",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'3'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td style="padding-left:5px;">Batang tubuh & perinium</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'3'})?in_array("2",$data->status_kemandirian->{'Butuh Bantuan'}->{'3'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'3'})?in_array("2",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'3'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td style="padding-left:5px;">Ekstrimitas bawah</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'3'})?in_array("3",$data->status_kemandirian->{'Butuh Bantuan'}->{'3'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'3'})?in_array("3",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'3'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td style="padding-left:5px;">Makan</td>
            <td></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'4'})?in_array("-",$data->status_kemandirian->{'Butuh Bantuan'}->{'4'})?"-":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'4'})?in_array("-",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'4'})?"-":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td rowspan="2">Pergerakan</td>
            <td style="padding-left:5px;">Jalan kaki</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'5'})?in_array("1",$data->status_kemandirian->{'Butuh Bantuan'}->{'5'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'5'})?in_array("1",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'5'})?"✓":"":'' ?></td>
        </tr>
        <tr style="height: 10px;">
            <td style="padding-left:5px;">Kursi roda</td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Butuh Bantuan'}->{'5'})?in_array("2",$data->status_kemandirian->{'Butuh Bantuan'}->{'5'})?"✓":"":'' ?></td>
            <td style="text-align:center"><?= isset($data->status_kemandirian->{'Tidak dapat melakukan'}->{'5'})?in_array("2",$data->status_kemandirian->{'Tidak dapat melakukan'}->{'5'})?"✓":"":'' ?></td>
        </tr>        
    </table>
    <span style="font-size:12px">Terapi Saat Pindah</span>
    <table id="data" border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 25%;text-align:center;font-weight:bold">Nama Obat</td>
            <td style="width: 25%;text-align:center;font-weight:bold">Jumlah Frekwensi</td>
            <td style="width: 25%;text-align:center;font-weight:bold">  Dosis   </td>
            <td style="width: 25%;text-align:center;font-weight:bold">Cara Pemberian</td>
        </tr>
                <?php
                    
                    $jml_array = isset($data->question5)?count($data->question5):'';
                    for ($x = 0; $x < $jml_array; $x++) {
                ?>
        <tr>
            <td style="width: 25%;"><?= isset($data->question5[$x]->nama_obat)?$data->question5[$x]->nama_obat:'' ?></td>
            <td style="width: 15%;"><?= isset($data->question5[$x]->jumlah_frekwensi)?$data->question5[$x]->jumlah_frekwensi:'' ?></td>
            <td style="width: 15%;"><?= isset($data->question5[$x]->dosis)?$data->question5[$x]->dosis:'' ?></td>
        
            <td style="width: 25%;"><?= isset($data->question5[$x]->cara_pemberian)?$data->question5[$x]->cara_pemberian:'' ?></td>
        </tr>
        <?php } ?>

        
        <tr>
            <td colspan="5">
                <div style="float: left;text-align: center">
            
                    <p>Dokter  yang mengirim</p>
                    <?php
                    
                    $id_dok = isset($data->dokter_yang_merawat)?Explode('-',$data->dokter_yang_merawat)[1]:(isset($data->merawat)?Explode('-',$data->merawat)[1]:'');
                                                    
                    $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                    // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                    //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                        if(isset($query_ttd->ttd)){
                            //  var_dump($ttd_dokter_pengirim);
                ?>    <div>
                            <img width="70px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                        </div>
                    <?php } else {?>
                            <br><br><br>
                        <?php } ?>
                        <span>(<?= isset($data->dokter_yang_merawat)?Explode('-',$data->dokter_yang_merawat)[0]:(isset($data->merawat)?Explode('-',$data->merawat)[0]:'') ?>)</span><br>
                    <span>Nama jelas & tanda tangan</span>
                </div>
        
                <div style="float: right;text-align: center;">
                    <p>Bukittinggi,<?= isset($data->tgl_menerima)?date('d-m-Y',strtotime($data->tgl_menerima)):'' ?> Jam : <?= isset($data->tgl_menerima)?date('H:i',strtotime($data->tgl_menerima)):'' ?> </p>
                    <p>Dokter  yang menerima</p>
                    <?php
                    $id = explode('-',isset($data->question7)?$data->question7:null)[1]??null;
                    //  var_dump($id);                                     
                    $query = $id?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                    if(isset($query->ttd)){
                    ?>

                        <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                    <?php
                        } else {?>
                            <br><br><br>
                        <?php } ?>
                    <span>(<?= isset($data->question7)? Explode('-',$data->question7)[0]:'.....................' ?>)</span><br>
                    <span>Nama jelas & tanda tangan</span>    
                </div>
                <br><br><br><br><br><br><br><br><br><br><br>
                <p>Seluruh proses pemindahan pasien telah selesai dan dilakukan sesuai standard operasional prosedur yang diterapkan</p>
                <div style="float: left;text-align: center;margin-left: 35%;">
                <?php
                
                    $nama = isset($data->question8)?$data->question8:null;                                      
                    $val = $nama?$this->db->query("select ttd from hmis_users where name = '$nama'")->row():null;
                    if(isset($val->ttd)){
                    ?>

                        <img width="70px" src="<?= $val->ttd ?>" alt=""><br>
                    <?php
                        } ?>
                <span>(<?= isset($data->question8)?$data->question8:'.....................' ?>)</span><br>
                <span>Nama jelas & tanda tangan</span>    
            </td>
        </tr>
    </table>

</div>


<div style="display: inline; position: relative;font-size: 12px;">
    <div style="float: left;text-align: center;">
        <p>Hal 3 dari 3</p>    
    </div>
    <div style="float: right;text-align: center;">
        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
    </div>     
</div> 