<?php 
// var_dump($assesment_medis_iri-);die();
// $assesment_medis_iri = isset($assesment_medis_iri)?$assesment_medis_iri:null;
$soap_pasien_rj_old = isset($soap_pasien_rj_old)?$soap_pasien_rj_old:'';
$assesment_keperawatan_ird = isset($assesment_keperawatan_ird->formjson)?json_decode($assesment_keperawatan_ird->formjson):'';
$assesment_medis_igd = isset($assesment_medis_igd->formjson)?json_decode($assesment_medis_igd->formjson):'';
// var_dump($assesment_medis_igd);
// var_dump($soap_pasien_rj_old);
// var_dump($assesment_keperawatan_ird);
?>

<hr>
<div class="pl-4 pt-2">
    <a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/catatan_medis_awal_rawat_inap/'.$no_ipd.'/'.sprintf("%08d", $data_pasien[0]['no_medrec']).'/'.$data_pasien[0]['no_medrec']) ?>" class="btn btn-primary">Lihat Catatan Medis Pasien</a>
</div>
<hr>

<div id="surveyAssesmentMedis"></div>
<script>
    Survey.StylesManager.applyTheme("modern");
    surveyAssesmentMedisjson = <?php echo file_get_contents("form_assesment_medis.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyAssesmentMedis = new Survey.Model(surveyAssesmentMedisjson);


    function sendDataToAssesmentMedis(survey) {
        
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/insert_assesment_awal_medis/')?>",
            type : 'POST',
            data : {
                no_ipd:'<?php echo $no_ipd ;?>',
                formjson_dewasa: JSON.stringify(survey.data),
            },
            datatype:'json',
        
            beforeSend:function()
            {
            },      
            complete:function()
            {
            //stopPreloader();
            },
            success:function(data)
            {
                new swal('Berhasil!','Data Berhasil Disimpan','success');
                // location.reload();
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }

    <?php
    if($assesment_medis_iri->num_rows()){
    ?>
    surveyAssesmentMedis.data = <?php echo $assesment_medis_iri->row()->formjson_dewasa ?>;
    <?php }else{ ?>
    <?php
    $kunya = '';
    if(isset($pemeriksaan_fisik_old->ku)){
        switch($pemeriksaan_fisik_old->ku){
            case 'TAMPAK BAIK':
                $kunya = 'baik';
                break;
            case 'TAMPAK SEDANG':
                $kunya = 'sedang';
                break;
            default:
                $kunya = 'buruk';
                break;
        }
    }
    ?>
    surveyAssesmentMedis.data = {
//    "anamnesa":"ANAMNESA TESTING ",
   "keluhan":"<?= isset($soap_pasien_rj_old->subjective_perawat)?str_replace(["\r","\n","<br>"],'\n',$soap_pasien_rj_old->subjective_perawat):'' ?>",
   "riwayat":"<?= isset($soap_pasien_rj_old->subjective_perawat)?str_replace(["\r","\n","<br>"],'\n',$soap_pasien_rj_old->subjective_perawat):'' ?>",
   "riwayat_penyakit_dahulu":"<?= isset($assesment_keperawatan_ird->riwayat_kesehatan_dulu)?str_replace([PHP_EOL,"\r","\n","<br>"],'\n',$assesment_keperawatan_ird->riwayat_kesehatan_dulu):NULL ?>",
   "keadaan_umum":"<?= $kunya ?>",
   "suhu":"<?= isset($pemeriksaan_fisik_old->suhu)?$pemeriksaan_fisik_old->suhu:'' ?>",
   "kesadaran":"<?= isset($pemeriksaan_fisik_old->kesadaran)?$pemeriksaan_fisik_old->kesadaran:''; ?>",
   "gcs":"<?= isset($pemeriksaan_fisik_old->e_gcs) && isset($pemeriksaan_fisik_old->m_gcs) && isset($pemeriksaan_fisik_old->v_gcs)?'E: '.$pemeriksaan_fisik_old->e_gcs.' M: '.$pemeriksaan_fisik_old->m_gcs.' V: '.$pemeriksaan_fisik_old->v_gcs:'' ?>",
   "td":"<?= isset($pemeriksaan_fisik_old->sitolic) && isset($pemeriksaan_fisik_old->diatolic)?$pemeriksaan_fisik_old->sitolic.'/'.$pemeriksaan_fisik_old->diatolic:''; ?>",
   "nadi":"<?= isset($assesment_medis_igd->nadi)?$assesment_medis_igd->nadi:'' ?>",
//    "keadaan_gizi":"", ongoing
   "pernafasan":"<?= isset($pemeriksaan_fisik_old->pernafasan)?$pemeriksaan_fisik_old->pernafasan:'' ?>",
   "skor_nyeri":"<?= isset($assesment_keperawatan_ird->skala_nyeri)?$assesment_keperawatan_ird->skala_nyeri:NULL ?>",
//    "table":{
//       "kepala":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "mata":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "tht":{
//          "normal":false,
//          "jelaskan":"asfd"
//       },
//       "mulut":{
//          "normal":false,
//          "jelaskan":"asf"
//       },
//       "leher":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "jantung":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "paru":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "dada":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "perut":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "urogenital":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "anggota":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "status":{
//          "normal":false,
//          "jelaskan":"asdf"
//       },
//       "muskulosksletas":{
//          "normal":false,
//          "jelaskan":"asdf"
//       }
//    },
   "pemeriksaan_penunjang":"<?= isset($assesment_medis_igd->pemeriksaan_penunjang_dokter)?str_replace('<br>','\n',$assesment_medis_igd->pemeriksaan_penunjang_dokter):NULL ?>",
   "diagnosis_kerja":"<?= isset($soap_pasien_rj_old->diagnosis_kerja_dokter)?str_replace([PHP_EOL,"\r","\n","<br>"],'\n',$soap_pasien_rj_old->diagnosis_kerja_dokter):'' ?>",
    "pengobatan":"<?= isset($soap_pasien_rj_old->diagnosis_banding_dokter)?str_replace([PHP_EOL,"\r","\n","<br>"],'\n',$soap_pasien_rj_old->diagnosis_banding_dokter):'' ?>",
   
                                                                                                                                              


//    "rencana":"RENCANA TINDAKAN TESTING",
//    "riwayat_kebiasaan-Comment":"MABUK"
};
<?php } ?>
    surveyAssesmentMedis.render("surveyAssesmentMedis");
    surveyAssesmentMedis
        .onComplete
        .add(function (result) {
            sendDataToAssesmentMedis(result);
        });
</script>