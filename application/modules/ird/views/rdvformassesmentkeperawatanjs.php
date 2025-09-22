
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>
<div id="surveyContainer"></div>

<script>
    surveyJSON = <?php echo str_replace(array("\r\n", "\n", "\r"), "", file_get_contents(__DIR__ ."/emr/rmrj06.json"));?>;
    Survey.StylesManager.applyTheme("modern");
    var surveyAssesmentKeperawatan = new Survey.Model(surveyJSON);
    // surveyAssesmentKeperawatan.completeLastPage(); // tambahanan fungsinya ada di file formgigi/carddiagnosa.php

        function sendDataToServerKeperawatan(survey) {
            var nyeri = survey.data.nyeri;
            var kualitas_nyeri = survey.data.kualitas_nyeri;
            var skala_nyeri = survey.data.skala_nyeri;
            var metode_nyeri = survey.data.metode_nyeri;
            var frekuensi_nyeri = survey.data.frekuensi_nyeri;
            var menjalar = survey.data.value_menjalar;
            var durasi_nyeri = survey.data.durasi_nyeri;
            var lokasi_nyeri = survey.data.lokasi_nyeri;
            var gizi_penurunan_bb = survey.data.gizi_penurunan_bb;
            var value_gizi_penurunan_bb = survey.data.value_gizi_penurunan_bb;
            var gizi_asupan_makan = survey.data.gizi_asupan_makan;
            var stat_sosial_keluarga = survey.data.stat_sosial_keluarga;
            var stat_psikologis = survey.data.stat_psikologis;
            var skrining_risiko_cedera = survey.data.skrining_risiko_cedera;
            var fungsional_alat_bantu = survey.data.fungsional_alat_bantu;
            var alat_bantu = survey.data.alat_bantu;
            var value_cacat_tubuh = survey.data.value_cacat_tubuh;
            var fungsional_cacat_tubuh = survey.data.fungsional_cacat_tubuh;
            var kes_keluarga_pas_edukasi = survey.data.kes_keluarga_pas_edukasi;
            var hambatan_edukasi = survey.data.hambatan_edukasi;
            var membutuhkan_penerjemah_edukasi = survey.data.membutuhkan_penerjemah_edukasi;
            var pengetahuan_edukasi = survey.data.pengetahuan_edukasi;
            var perawatan_penyakit = survey.data.perawatan_penyakit;
            var cara_minum_obat = survey.data.cara_minum_obat;
            var diet = survey.data.diet;
            //ASesment Nyeri
            var nyeri_akut = survey.data.chek_nyeri_akut;
            var ketidakseimbangan_nutrisi = survey.data.check_ketidakseimbangan_nutrisi;
            var pola_nafas_tidak_efektif = survey.data.check_pola_nafas_tidak_efektif;
            var bersihkan_jalan_nafas = survey.data.check_bersihkan_jalan_nafas;
            var hipertermia = survey.data.check_hipertermia;
            var diare = survey.data.check_diare;
            var resiko_infeksi_pembedahan = survey.data.check_resiko_infeksi_pembedahan;
            var ansietas = survey.data.check_ansietas;
            var gangguan_citra_tubuh = survey.data.check_gangguan_citra_tubuh;
            var gangguan_menelan = survey.data.check_gangguan_menelan;
            var penurunan_curah_jantung = survey.data.check_penurunan_curah_jantung;
            var intoleran_aktifitas = survey.data.check_intoleran_aktifitas;
            var gangguan_mobilitas_fisik = survey.data.check_gangguan_mobilitas_fisik;
            var hambatan_komunikasi_verbal = survey.data.check_hambatan_komunikasi_verbal;
            var diskontuinitas_jaringan = survey.data.check_diskontuinitas_jaringan;
            var ketidakstabilan_gula_darah = survey.data.check_ketidakstabilan_gula_darah;
            var lainnya = survey.data.check_lainnya;
            var fk_minum_obat = survey.data.fk_minum_obat;
            var fk_istirahat = survey.data.fk_istirahat;
            var fk_musik = survey.data.fk_musik;
            var fk_posisi_tidur = survey.data.fk_posisi_tidur;
            var alergi = survey.data.alergi;
            var riwayat_alergi = survey.data.riwayat_alergi;
            var reaksi_alergi = survey.data.reaksi_alergi;
            var value_menjalar = survey.data.value_menjalar;
            var dataresult = 'a';
            
            
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('ird/rdcpelayanan/insert_assesment/'.$no_register.'/'.$id_poli); ?>',
                data: {
                    alergi:alergi,
                    riwayat_alergi:riwayat_alergi,
                    reaksi_alergi:reaksi_alergi,
                    nyeri : nyeri,
                    kualitas_nyeri : kualitas_nyeri,
                    skala_nyeri : skala_nyeri,
                    metode_nyeri : metode_nyeri,
                    frekuensi_nyeri : frekuensi_nyeri,
                    menjalar : menjalar,
                    value_menjalar : value_menjalar,
                    durasi_nyeri : durasi_nyeri,
                    lokasi_nyeri : lokasi_nyeri,
                    fk_minum_obat : fk_minum_obat,
                    fk_istirahat : fk_istirahat,
                    fk_musik : fk_musik,
                    fk_posisi_tidur : fk_posisi_tidur,
                    value_gizi_penurunan_bb :value_gizi_penurunan_bb,
                    gizi_penurunan_bb : gizi_penurunan_bb,
                    gizi_asupan_makan : gizi_asupan_makan,
                    // penilaian_gizi : penilaian_gizi,
                    stat_sosial_keluarga : stat_sosial_keluarga,
                    stat_psikologis : stat_psikologis,
                    //stat_pernikahan_ekonomi : stat_pernikahan_ekonomi,
                    skrining_risiko_cedera : skrining_risiko_cedera,
                    fungsional_alat_bantu : fungsional_alat_bantu,
                    alat_bantu : alat_bantu,
                    fungsional_cacat_tubuh : fungsional_cacat_tubuh,
                    value_cacat_tubuh : value_cacat_tubuh,
                    kes_keluarga_pas_edukasi : kes_keluarga_pas_edukasi,
                    hambatan_edukasi : hambatan_edukasi,
                    membutuhkan_penerjemah_edukasi : membutuhkan_penerjemah_edukasi,
                    pengetahuan_edukasi : pengetahuan_edukasi,
                    perawatan_penyakit : perawatan_penyakit,
                    cara_minum_obat : cara_minum_obat,
                    diet : diet,
                    //asesment masalah keperawatan
                    nyeri_akut : nyeri_akut,
                    ketidakseimbangan_nutrisi : ketidakseimbangan_nutrisi,
                    pola_nafas_tidak_efektif : pola_nafas_tidak_efektif,
                    bersihkan_jalan_nafas : bersihkan_jalan_nafas,
                    hipertermia : hipertermia,
                    diare : diare,
                    resiko_infeksi_pembedahan : resiko_infeksi_pembedahan,
                    ansietas : ansietas,
                    gangguan_citra_tubuh : gangguan_citra_tubuh,
                    gangguan_menelan : gangguan_menelan,
                    penurunan_curah_jantung : penurunan_curah_jantung,
                    intoleran_aktifitas : intoleran_aktifitas,
                    gangguan_mobilitas_fisik : gangguan_mobilitas_fisik,
                    hambatan_komunikasi_verbal : hambatan_komunikasi_verbal,
                    diskontuinitas_jaringan : diskontuinitas_jaringan,
                    ketidakstabilan_gula_darah : ketidakstabilan_gula_darah,
                    lainnya : lainnya,
                    formjson: JSON.stringify(survey.data),
		
                },
                success: function(data){
                },
                dataType: 'json'
                });
        }

       
        <?php
            $a = $this->db->query("SELECT formjson FROM pemeriksaan_fisik WHERE no_register='$no_register'")->result();
            $b = '';
            // var_dump($a);
            foreach($a as $val){
                $b = $val->formjson;
            }
            if($b){

            
        ?>
            surveyAssesmentKeperawatan.data = <?= $b; ?>;
        <?php } ?>

        // surveyAssesmentKeperawatan.showNavigationButtons = false;
        surveyAssesmentKeperawatan.render("surveyContainer");
        surveyAssesmentKeperawatan
            .onComplete
            .add(function (result) {
                sendDataToServerKeperawatan(result);
            });

        

          
</script>