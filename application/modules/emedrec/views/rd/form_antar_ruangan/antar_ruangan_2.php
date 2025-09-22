<table id="data" border="1" cellspacing="0" cellpadding="0" >
    <tr style="height: 10px;">
        <th style="width: 25%;">Status Kemandirian</th>
        <th style="width: 45%;">Mandiri</th>
        <th style="width: 15%;">Butuh Bantuan</th>
        <th style="width: 15%;">Tidak dapat melakukan</th>
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
<br>
<label for="" style="font-weight:bold;font-size:11pt;">Terapi Saat Pindah</label>
<table id="data" border="1" cellspacing="0" cellpadding="0">
    <tr style="height: 10px;">
        <th>Nama Obat</th>
        <th>Jumlah Frekwensi</th>
        <th>  Dosis   </th>
        <th>Cara Pemberian</th>
    </tr>
            <?php
                // var_dump($data->question5);die();
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
            <div style="float: left;text-align: center;">
                
                <p>Dokter  yang mengirim</p>
                <?php
                if(isset($data_rawat_darurat[0]->ttd) ){
                ?>
                <img width="100px" src="<?= $data_rawat_darurat[0]->ttd ?>" alt=""><br>
                <?php }else{ ?>
                    <br><br><br>
                <?php } ?>
                    <span>(<?= isset($data_rawat_darurat[0]->dokter)?$data_rawat_darurat[0]->dokter:'.....................' ?>)</span>
                <p>Nama jelas & tanda tangan</p>
            </div>
    
            <div style="float: right;text-align: center;">
                <p>Bukittinggi,<?= isset($data->tgl_menerima)?date('d-m-Y',strtotime($data->tgl_menerima)):'' ?> Jam : <?= isset($data->tgl_menerima)?date('H:i',strtotime($data->tgl_menerima)):'' ?> </p>
                <p>Dokter  yang menerima</p><br><br>
                <?php
                $id = explode('-',isset($data->question7)?$data->question7:null)[1]??null;
                // var_dump($id);                                     
                $query = $id?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where id_dokter = $id")->row():null;
                if(isset($query->ttd)){
                ?>

                    <img width="80px" src="<?= $query->ttd ?>" alt=""><br>
                <?php
                    } ?>
                <span>(<?= isset($data->question7)? Explode('-',$data->question7)[0]:'.....................' ?>)</span>
                <p>Nama jelas & tanda tangan</p>    
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <p>Seluruh proses pemindahan pasien telah selesai dan dilakukan sesuai standard operasional prosedur yang diterapkan</p>
            <div style="float: left;text-align: center;margin-left: 35%;">
            <?php
              
                     $nama = isset($data->question8)?$data->question8:null;                                      
                $val = $id?$this->db->query("select ttd from hmis_users where name = '$nama'")->row():null;
                if(isset($val->ttd)){
                ?>

                    <img width="80px" src="<?= $val->ttd ?>" alt=""><br>
                <?php
                    } ?>
            <span>(<?= isset($data->question8)?$data->question8:'.....................' ?>)</span>
            <p>Nama jelas & tanda tangan</p>    
        </td>
    </tr>
</table><br><br><br><br><br><br><br><br><br><br><br>
<p style="text-align:right;font-size:12px">3</p>
