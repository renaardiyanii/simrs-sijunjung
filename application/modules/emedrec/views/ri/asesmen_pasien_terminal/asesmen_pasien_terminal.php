<?php 
// var_dump($assesment_awal_keperawatan_iri[0]);
//   var_dump(isset($assesment_awal_keperawatan_iri[0]->formjson)?json_decode($assesment_awal_keperawatan_iri[0]->formjson):'');
$data = (isset($asesmen_pasien_terminal[0]->formjson)?json_decode($asesmen_pasien_terminal[0]->formjson):'');
// $jsonf = json_decode($data->question885, TRUE);
//   var_dump($data);
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<style>
#data {
    /* margin-top: 10px; */
    /* border-collapse: collapse; */
    /* border: 1px solid black;     */
    width: 100%;
    font-size: 12px;
    position: relative;


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
            <?php $this->load->view('emedrec/header_print') ?>
        </header>
        <div style="height:0px;border: 2px solid black;"></div>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN AWAL DAN ULANG PASIEN TERMINAL DAN KELUARGA
        </p>
        <div style="font-size:12px">
            <div style="margin-left:25px">
                <table border="0" width="100%">
                    <br>
                    <tr>
                        <td width="30%"><span class="text_sub_judul">Asesmen Awal / Ulang Tanggal :
                                <?= isset($asesmen_pasien_terminal->tgl_input)?($asesmen_pasien_terminal->tgl_input != null)? date("d-m-Y",strtotime($soap_pasien_rj->tgl_input)): '-':'-' ;?>
                            </span></td>
                        <td width="20%"><span class="text_sub_judul">Pukul :
                                <?= isset($asesmen_pasien_terminal->tgl_input)?($asesmen_pasien_terminal->tgl_input != null)? date("H:i",strtotime($soap_pasien_rj->tgl_input)): '-':'-' ;?>
                                WIB</span></td>
                    </tr>
                </table>

                <div style="font-size:12px">
                    <p>1. Gejala seperti mau muntah dan kesulitan bernafas </p>
                    <div style="margin-left:25px">
                        <p>1.1. Kegawatan pernafasan : </p>
                        <div style="margin-left:25px">
                            <input type="checkbox" value="dyspnoe">
                            <span>Dyspnoe</span>
                            <input type="checkbox" value="nafas tak teratur">
                            <span>Nafas tak teratur</span>
                            <input type="checkbox" value="ada sekret">
                            <span>Ada sekret</span>
                            <input type="checkbox" value="nafas cepat dan dangkal">
                            <span>Nafafas cepat dan dangkal</span>
                            <input type="checkbox" value="nafas melalui mulut">
                            <span>Nafas melalui mulut</span>
                            <input type="checkbox" value="SpO2 < normal ">
                            <span>SpO2 < normal </span>
                                    <input type="checkbox" value="nafas lambat">
                                    <span>Nafas lambat</span>
                                    <input type="checkbox" value="mukosa oral kering ">
                                    <span>Mukosa oral kering</span>
                                    <input type="checkbox" value="T.A.K">
                                    <span>T.A.K<?=' '.(isset($data->check_kegawatan_pernafasan)?$data->check_kegawatan_pernafasan:'')?></span>
                        </div>
                        <p>1.2. Kehilangan Tonus otot : </p>
                        <div style="margin-left:25px">
                            <input type="checkbox" value="mual">
                            <span>Mual</span>
                            <input type="checkbox" value="sulit menelanr">
                            <span>Sulit menelan</span>
                            <input type="checkbox" value="inkontinensia alvi">
                            <span>Inkontinensia alvi</span>
                            <input type="checkbox" value="penurunan pergerakan tubuh">
                            <span>Penurunan pergerakan tubuh</span>
                            <input type="checkbox" value="distensi abdomen">
                            <span>Nafas melalui mulut</span>
                            <input type="checkbox" value="T.A.K">
                            <span>T.A.K</span>
                            <input type="checkbox" value="sulit berbicara">
                            <span>Sulit berbicara</span>
                            <input type="checkbox" value="inkontinensia urine">
                            <span>Inkontinensia
                                Urine<?=' '.(isset($data->check_kehilangan_tonos_otot)?$data->check_kehilangan_tonos_otot:'')?></span>
                        </div>
                        <p>1.3. Nyeri : </p>
                        <div style="margin-left:25px">
                            <input type="checkbox" value="tidak">
                            <span>Tidak</span>
                            <input type="checkbox" value="ya">
                            <span>Ya<?=' '.(isset($data->check_nyeri)?$data->check_nyeri:'')?></span>
                            <input type="input" value="">
                            <span></span>
                        </div>
                        <p>1.4. Perlambatan Sirkulasi : </p>
                        <div style="margin-left:25px">
                            <input type="checkbox" value="bercak dan sianosis pada ekstremitas">
                            <span>Bercak dan sianosis pada ekstemitas</span>
                            <input type="checkbox" value="gelisah">
                            <span>Gelisah</span>
                            <input type="checkbox" value="lemas">
                            <span>Lemas</span>
                            <input type="checkbox" value="kulit dingin dan berkeringat">
                            <span>Kulit dingin dan berkeringat</span>
                            <input type="checkbox" value="tekanan darah menurun">
                            <span>Tekanan Darah menurun</span>
                            <input type="checkbox" value="Nadi lambat dan lemah">
                            <span>Nadi lambat dan lemah</span>
                            <input type="checkbox" value="T.A.K">
                            <span>T.A.K<?=' '.(isset($data->check_perlambatan_sirkulasi)?$data->check_perlambatan_sirkulasi:'')?></span>
                        </div>
                    </div>
                </div>
                <div style="font-size:12px">
                    <p>2. Faktor-faktor yang meningkatkan dan membangkitkan gejala fisik :</p>
                    <div style="margin-left:25px">
                        <input type="checkbox" value="melakukan aktivitas fisik">
                        <span>melakukan aktivitas fisik</span>
                        <input type="checkbox" value="pindah posisi">
                        <span>Pindah posisi</span>
                        <input type="checkbox" value="lainnya">
                        <span></span>
                        <input type="lainnya" value="">
                        <span><?=' '.(isset($data->faktor_meningkatkan_dan_membangkitkan)?$data->faktor_meningkatkan_dan_membangkitkan:'')?></span>
                    </div>
                    <div style="font-size:12px">
                        <p>3. Manajemen gejala saat ini ada respon pasien : </p>
                        <p> &nbsp; &nbsp;Masalah keperawatan *</p>
                        <div style="margin-left:25px">

                            <input type="checkbox" value="mual">
                            <span>Mual</span>
                            <input type="checkbox" value="perubahan persepsi sensori">
                            <span>Perubahan persepsi sensori</span>
                            <input type="checkbox" value="nyeri akut">
                            <span>Nyeri akut</span>
                            <input type="checkbox" value="pola nafas tidak efektif">
                            <span>Pola Nafas tidak efektif</span>
                            <input type="checkbox" value="konstipasi">
                            <span>Konstipasi</span>
                            <input type="checkbox" value="nyeri kronis">
                            <span>Nyeri Kronis</span>
                            <input type="checkbox" value="bersihan jalan nafas tidak efektif">
                            <span>Bersihan jalan nafas tidak efektif</span>
                            <input type="checkbox" value="defisit perawatan diri">
                            <span>Defisiit perawatan
                                diri<?=' '.(isset($data->check_manajemen_gejala)?$data->check_manajemen_gejala:'')?></span>
                        </div>
                    </div>
                    <div style="font-size:12px">
                        <p>4. Orientasi spiritual pasien dan keluarga : </p>
                        <p> &nbsp; &nbsp;Apakah perlu pelayanan spiritual ?</p>
                        <div style="margin-left:25px">

                            <input type="checkbox" value="tidak">
                            <span>Tidak</span>
                            <input type="checkbox" value="ya">
                            <span>Ya, oleh:</span>
                            <input type="other" value="">
                            <span><?=' '.(isset($data->check_orientasi_spiritual)?$data->check_orientasi_spiritual:'')?></span>
                        </div>
                    </div>
                    <div style="font-size:12px">
                        <p>5. Urusan dan kebutuhan spiritual pasien dan keluarga seperti putus asa, penderitaan, rasa
                            bersalah atau pengampunan : </p>
                        <div style="margin-left:25px">
                            <p>Perlu didoakan :</p>
                            <input type="checkbox" value="tidak">
                            <span>Tidak</span>
                            <input type="checkbox" value="ya">
                            <span>Ya</span>
                            <p>Perlu bimbingan rohani : </p>
                            <input type="checkbox" value="tidak">
                            <span>Tidak</span>
                            <input type="checkbox" value="ya">
                            <span>Ya</span>
                            <p>Perlu pendampingan rohani :</p>
                            <input type="checkbox" value="tidak">
                            <span>Tidak</span>
                            <input type="checkbox" value="ya">
                            <span>Ya<?=' '.(isset($data->check_urusan_dan_kebutuhan)?$data->check_urusan_dan_kebutuhan:'')?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p style="text-align:left;font-size:12px">Hal 1 - 3</p>
        <p style="text-align:right;font-size:12px"> Rev.08.02.2021.RM-006i / RI</p>
    </div>

    <!-- halaman 2 -->
    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/header_print_ganjil') ?>
        </header>
        <div style="height:0px;border: 2px solid black;"></div>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN AWAL DAN ULANG PASIEN TERMINAL DAN KELUARGA
        </p>
        <div style="font-size:12px">
            <p>6. Status psikososial dan keluarga </p>
            <div style="margin-left:25px">
                <p>6.1. Apakah ada orang yang ingin dihubungi saat ini? </p>
                <div style="margin-left:25px">
                    <input type="checkbox" value="tidak">
                    <span>Dyspnoe</span>
                    <input type="checkbox" value="ya">
                    <span>Ya, siapa</span>
                    <input type="other" value="">
                    <span></span>
                    <p>Dimana</p>
                    <input type="other" value="">
                    <span></span>
                    <p>Hubungan dengan pasien sebagai</p>
                    <input type="other" value="">
                    <span></span>
                    <p>No. Telpon/HP</p>
                    <input type="number" value="">
                    <span><?=' '.(isset($data->check_apakah_ada_orang_yang_ingin_dihubungi)?$data->check_apakah_ada_orang_yang_ingin_dihubungi:'')?></span>

                </div>
                <p>6.2. Bagaimana rencana perawatan selanjutnya? </p>
                <div style="margin-left:25px">
                    <input type="checkbox" value="tetap dirawat di rs">
                    <span>Tetap dirwat di RS</span>
                    <input type="checkbox" value="dirawat dirumah">
                    <span>Dirawat dirumah</span>
                    <p>Apakah lingkungan rumah sudah disiapkan ?</p>
                    <input type="checkbox" value="ya">
                    <span>Ya</span>
                    <input type="checkbox" value="tidak">
                    <span>Tidak</span>
                    <p>Jika Ya, apakah ada yang mampu merawat pasien di rumah ?
                        <input type="checkbox" value="ya">
                        <span>Ya, oleh</span>
                        <input type="other" value="">
                        <span></span>
                        <input type="checkbox" value="tidak">
                        <span>Tidak</span>
                    <p>Jika tidak, apakah perlu difasilitasi RS (Home Care)?
                        <input type="checkbox" value="ya">
                        <span>Ya</span>
                        <input type="checkbox" value="tidak">
                        <span>Tidak<?=' '.(isset($data->check_bagaimana_cara_perawatan)?$data->check_bagaimana_cara_perawatan:'')?></span>
                </div>
                <p>6.3. Reaksi pasien atas penyakitnya </p>
                <div style="margin-left:25px">
                    <p>&nbsp;Asesmen informasi</p>
                    <input type="checkbox" value="menyangkal">
                    <span>Menyangkal</span>
                    <input type="checkbox" value="marah">
                    <span>Marah</span>
                    <input type="checkbox" value="takut">
                    <span>Takut</span>
                    <input type="checkbox" value="sedih / menangis">
                    <span>Sedih / menangis</span>
                    <input type="checkbox" value="rasa bersalah">
                    <span>Rasa bersalah</span>
                    <input type="checkbox" value="ketidak berdayaan">
                    <span>Ketidak berdayaan</span>
                    <p><b>Masalah keperawatan *</b>
                    <p>
                        <input type="checkbox" value="axietas">
                        <span>Axietas</span>
                        <input type="checkbox" value="distress spiritual">
                        <span>Distress
                            Spiritual<?=' '.(isset($data->check_reaksi_pasien_atas_penyakitnya)?$data->check_reaksi_pasien_atas_penyakitnya:'')?></span>


                </div>
                <p>6.4. Reaksi keluarga atas penyakit pasien : </p>
                <div style="margin-left:25px">
                    <p>&nbsp;Asesmen informasi</p>
                    <input type="checkbox" value="marah">
                    <span>Marah</span>
                    <input type="checkbox" value="gangguan tidur">
                    <span>Gangguan tidur</span>
                    <input type="checkbox" value="penurunan konsentrasi">
                    <span>Penurunan Konsentrasi</span>
                    <input type="checkbox" value="ketidakmampuan memenuhi peran yang diharapkan">
                    <span>Ketidakmampuan memenuhi peran yang diharapkan</span>
                    <input type="checkbox" value="keluarga kurang berkomunikasi dengan pasien">
                    <span>Keluarga kurang berkomunikasi dengan pasien</span>
                    <input type="checkbox" value="letih/lelah">
                    <span>Letih/lelah</span>
                    <input type="checkbox" value="rasa bersalah">
                    <span>Rasa bersalah</span>
                    <input type="checkbox" value="perubahan kebiasaan pola komunikasi">
                    <span>Perubahan kebiasaan pola komunikasi</span>
                    <input type="checkbox"
                        value="keluarga kurang berpartisipasi membuat keputusan dalam perawatan pasien">
                    <span>Keluarga kurang berpartisipasi membuat keputusan dalam perawatan pasien</span>
                    <p><b>Masalah keperawatan *</b>
                    <p>
                        <input type="checkbox" value="kopling individu tidak efektif">
                        <span>kopling individu tidak efektif</span>
                        <input type="checkbox" value="distress spiritual">
                        <span>Distress
                            Spiritual<?=' '.(isset($data->check_reaksi_keluarga_atas_penyakit_pasien)?$data->check_reaksi_keluarga_atas_penyakit_pasien:'')?></span>
                </div>
            </div>
        </div>
        <div style="font-size:12px">
            <p>7. Kebutuhan dukungan atau kelonggaran pelayanan bagi pasien, keluarga dan pemberi pelayanan lain :</p>
            <div style="margin-left:25px">
                <input type="checkbox" value="pasien perlu didampingi keluarga">
                <span>Pasien perlu didampingi keluarga</span>
                <input type="checkbox" value="keluarga dapat mengujungi pasien di luar waktu berkunjung">
                <span>Keluarga dapat mengunjungi pasien di luar waktu berkunjung</span>
                <input type="checkbox" value="sahabat dapat mengujungi pasien di luar waktu berkunjung">
                <span>Sahabat dapat mengunjungi pasien di luar waktu berkunjung</span><br>
                <input type="checkbox" value="lainnya">
                <span></span>
                <input type="other" value="">
                <span><?=' '.(isset($data->kebutuhan_dukungan_atau_kelonggaran)?$data->kebutuhan_dukungan_atau_kelonggaran:'')?></span>
            </div>

            <p style="text-align:left;font-size:12px"> Hal 2 - 3</p>
            <p style="text-align:right;font-size:12px"> Rev.08.02.2021.RM-006i / RI</p>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>


    <!-- halaman 3 -->

    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/header_print_ganjil') ?>
        </header>
        <div style="height:0px;border: 2px solid black;"></div>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN AWAL DAN ULANG PASIEN TERMINAL DAN KELUARGA
        </p>

        <div style="font-size:12px">
            <div style="margin-left:25px">
                <div style="font-size:12px">
                    <p>8. Apakah ada kebutuhan akan alternatif atau tingkat pelayanan lain :</p>
                    <div style="margin-left:25px">
                        <input type="checkbox" value="tidak">
                        <span>Tidak</span>
                        <input type="checkbox" value="autopsi">
                        <span>Autopsi</span><br>
                        <input type="checkbox" value="donasi organ">
                        <span>Donasi Organ</span><br>
                        <input type="other" value="">
                        <span></span><br>
                        <input type="checkbox" value="lainnya">
                        <span></span>
                        <input type="other" value="">
                        <span><?=' '.(isset($data->apakah_ada_kebutuhan)?$data->check_apakah_ada_kebutuhan:'')?></span>
                    </div>
                    <p>9. Faktor resiko bagi keluarga yang ditinggalkan : </p>
                    <div style="margin-left:25px">
                        <p>&nbsp;Asesmen informasi</p>
                        <input type="checkbox" value="marah">
                        <span>Marah</span>
                        <input type="checkbox" value="depresi">
                        <span>Depresi</span>
                        <input type="checkbox" value="rasa bersalah">
                        <span>Rasa bersalah</span>
                        <input type="checkbox" value="perubahan kebiasaan pola komunikasi">
                        <span>Perubahan kebiasaan pola komunikasi</span>
                        <input type="checkbox" value="ketidak mampuan memenuhi peran yang diharapkan">
                        <span>Ketidak mampuan memenuhi peran yang diharapkan</span>
                        <input type="checkbox" value="letih/lelah">
                        <span>Letih/lelah</span>
                        <input type="checkbox" value="gangguan tidur">
                        <span>Gangguan tidur</span>
                        <input type="checkbox" value="sedih/menangis">
                        <span>Sedih/menangis</span>
                        <input type="checkbox" value="penurunan konsentrasi">
                        <span>Penurunan konsentrasi</span>
                        <p><b>Masalah keperawatan *</b>
                        <p>
                            <input type="checkbox" value="kopling individu tidak efektif">
                            <span>kopling individu tidak efektif</span>
                            <input type="checkbox" value="distress spiritual">
                            <span>Distress
                                Spiritual<?=' '.(isset($data->check_faktor_resiko_bagi_keluarga_yang_ditinggalkan)?$data->check_faktor_resiko_bagi_keluarga_yang_ditinggalkan:'')?></span>
                    </div><br><br><br><br><br><br><br><br><br>
                    <div style="display: inline; position: relative;">
                        <div style="float: left;">
                            <br><br>
                            <p>
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Perawat
                            </p></span>
                            <?php
                        $name_one = $data->nm_pemeriksa_1??null;
                                                            
                        $result = $name_one?$this->db->query("SELECT ttd FROM hmis_users  where name = '$name_one'")->row():null;
                        if(isset($result->ttd)){
                    ?>
                            <img width="120px" height="130px" src="<?= $result->ttd ?>" alt=""><br>
                            <?php }?>
                            <span><?= isset($data->nm_pemeriksa_1)?$data->nm_pemeriksa_1:'' ?></span><br><br><br><br><br>

                            <p>( Nama jelas & tanda tangan )</p>

                        </div>
                        <div style="float: right;">
                            <p>
                                <span>Tanggal
                                    <?= isset($data->question1112)? date('d-m-Y',strtotime($data->question1112)):''; ?></span><span>
                                    ,Jam

                                    <?= isset($data->question1112)? date('H:i:s',strtotime($data->question1112)):''; ?>

                            </p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokter</p>
                            <?php
                        $name_two = $data->nm_pemeriksa_2??null;
                                                            
                        $result_two = $name_two?$this->db->query("SELECT ttd FROM hmis_users  where name = '$name_two'")->row():null;
                        if(isset($result_two->ttd)){
                    ?>
                            <img width="120px" height="130px" src="<?= $result_two->ttd ?>" alt=""><br>
                            <?php }?>
                            <span><?= isset($data->nm_pemeriksa_2)?$data->nm_pemeriksa_2:'' ?></span><br><br><br><br>
                            <br>
                            <p>( Nama jelas & tanda tangan )</p>
                        </div>






                    </div>
                    <br><br><br><br><br><br><br><br><br><br><br><br>
                    <p style="text-align:left;font-size:12px">Hal 3 - 3</p>
                    <p style="text-align:right;font-size:12px"> Rev.08.02.2021.RM-006i / RI</p>
                    </br></br></br>



                </div>
            </div>
        </div>
    </div>
    </div>





</body>

</html>