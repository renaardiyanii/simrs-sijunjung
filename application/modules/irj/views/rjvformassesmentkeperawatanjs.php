<?php 
$this->load->view('layout/header_form');
// var_dump($user_info->name);
$data_fisik_json = isset($data_fisik->masalah_keperawatan_json)?json_decode($data_fisik->masalah_keperawatan_json):null;
// var_dump($data_fisik_json);
?>

<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" /> -->
<!-- <script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div id="surveyContainer"></div>

<script>

    
var widget = {
    name: "emptyRadio",
    isFit : function(question) {  
        return question.getType() === 'radiogroup'; 
    },
    isDefaultRender: true,
    afterRender: function(question, el) {
      var $el = $(el);
      $el.find("input:radio").click(function(event){
           var UnCheck = "UnCheck",
                  $clickedbox = $(this),
                  radioname = $clickedbox.prop("name"),
                  $group = $('input[name|="'+ radioname + '"]'),
                  doUncheck = $clickedbox.hasClass(UnCheck),
                  isChecked = $clickedbox.is(':checked');
              if(doUncheck){
                  $group.removeClass(UnCheck);
                  $clickedbox.prop('checked', false);
                  question.value = null;
              }
              else if(isChecked){
                  $group.removeClass(UnCheck);
                  $clickedbox.addClass(UnCheck);
              }
      });    
    },
    willUnmount: function(question, el) {
    }
};

    Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");
    surveyJSON = <?php echo file_get_contents(__DIR__ ."/emr/rmrj06.json");?>;
    Survey.StylesManager.applyTheme("modern");
    var surveyAssesmentKeperawatan = new Survey.Model(surveyJSON);

        function sendDataToServerKeperawatan(survey) {
            // console.log(JSON.stringify(survey.data));
          
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('irj/rjcpelayanan/insert_assesment_keperawatan_rj/'.$no_register); ?>',
                data: {
                    formjson: JSON.stringify(survey.data),
                },
                success: function(data){
                    new swal({
											title: "Selesai",
											text: "Data berhasil disimpan",
											type: "success",
											showCancelButton: false,
											closeOnConfirm: false,
											showLoaderOnConfirm: true,
												willClose: () => {
													window.location.reload();
												}
										},
										function () {
											// window.location.reload();
										});
                },
                dataType: 'json'
                });
        }

       
        <?php
        if($assesment_keperawatan){
        ?>
        surveyAssesmentKeperawatan.data = <?= $assesment_keperawatan->formjson; ?>;
        <?php }else{
        ?>
            surveyAssesmentKeperawatan.data ={"kebutuhan_edukasi":["<?= (isset($data_fisik_json->kebutuhan_edukasi)?in_array("pengetahuan tentang penyakit", $data_fisik_json->kebutuhan_edukasi)?'pengetahuan tentang penyakit':'':'') ?>",
                "<?= (isset($data_fisik_json->kebutuhan_edukasi)?in_array("perawatan dirumah tentang penyakit", $data_fisik_json->kebutuhan_edukasi)?'perawatan dirumah tentang penyakit':'':'') ?>",
                "<?= (isset($data_fisik_json->kebutuhan_edukasi)?in_array("cara minum obat", $data_fisik_json->kebutuhan_edukasi)?'cara minum obat':'':'') ?>",
                "<?= (isset($data_fisik_json->kebutuhan_edukasi)?in_array("diet", $data_fisik_json->kebutuhan_edukasi)?'diet':'':'') ?>"],
                // "nyeri_akut":["<?= (isset($data_fisik_json->nyeri_akut)?in_array("nyeri akut", $data_fisik_json->nyeri_akut)?'nyeri akut':'':'') ?>"],"chek_nyeri_akut":"<?= isset($data_fisik_json->chek_nyeri_akut)?$data_fisik_json->chek_nyeri_akut:'' ?> ",
                // "ketidakseimbangan_nutrisi":["<?= (isset($data_fisik_json->ketidakseimbangan_nutrisi)?in_array("ketidakseimbangan nutrisi kurang dari kebutuhan tubuh", $data_fisik_json->ketidakseimbangan_nutrisi)?'ketidakseimbangan nutrisi kurang dari kebutuhan tubuh':'':'') ?>"],"check_ketidakseimbangan_nutrisi":"<?= isset($data_fisik_json->check_ketidakseimbangan_nutrisi)?$data_fisik_json->check_ketidakseimbangan_nutrisi:'' ?>",
                // "pola_nafas_tidak_efektif":["<?= (isset($data_fisik_json->pola_nafas_tidak_efektif)?in_array("pola nafas tidak efektif", $data_fisik_json->pola_nafas_tidak_efektif)?'pola nafas tidak efektif':'':'') ?>"],"check_pola_nafas_tidak_efektif":"<?= isset($data_fisik_json->check_pola_nafas_tidak_efektif)?$data_fisik_json->check_pola_nafas_tidak_efektif:'' ?>",
                // "bersihkan_jalan_nafas":["<?= (isset($data_fisik_json->bersihkan_jalan_nafas)?in_array("bersihkan jalan nafas", $data_fisik_json->bersihkan_jalan_nafas)?'bersihkan jalan nafas':'':'') ?>"],"check_bersihkan_jalan_nafas":"<?= isset($data_fisik_json->check_bersihkan_jalan_nafas)?$data_fisik_json->check_bersihkan_jalan_nafas:'' ?>",
                // "hipertermia":["<?= (isset($data_fisik_json->hipertermia)?in_array("hipertermia", $data_fisik_json->hipertermia)?'hipertermia':'':'') ?>"],"check_hipertermia":"<?= isset($data_fisik_json->check_hipertermia)?$data_fisik_json->check_hipertermia:'' ?>",
                // "diare":["<?= (isset($data_fisik_json->diare)?in_array("diare", $data_fisik_json->diare)?'diare':'':'') ?>"],"check_diare":"<?= isset($data_fisik_json->check_diare)?$data_fisik_json->check_diare:'' ?>",
                // "resiko_infeksi_pembedahan":["<?= (isset($data_fisik_json->resiko_infeksi_pembedahan)?in_array("resiko infeksi pembedahan", $data_fisik_json->resiko_infeksi_pembedahan)?'resiko infeksi pembedahan':'':'') ?>"],"check_resiko_infeksi_pembedahan":"<?= isset($data_fisik_json->check_resiko_infeksi_pembedahan)?$data_fisik_json->check_resiko_infeksi_pembedahan:'' ?>",
                // "ansietas":["<?= (isset($data_fisik_json->ansietas)?in_array("ansietas", $data_fisik_json->ansietas)?'ansietas':'':'') ?>"],"check_ansietas":"<?= isset($data_fisik_json->check_ansietas)?$data_fisik_json->check_ansietas:'' ?>",
                // "gangguan_citra_tubuh":["<?= (isset($data_fisik_json->gangguan_citra_tubuh)?in_array("gangguan citra tubuh", $data_fisik_json->gangguan_citra_tubuh)?'gangguan citra tubuh':'':'') ?>"],"check_gangguan_citra_tubuh":"<?= isset($data_fisik_json->check_gangguan_citra_tubuh)?$data_fisik_json->check_gangguan_citra_tubuh:'' ?>",
                // "gangguan_menelan":["<?= (isset($data_fisik_json->gangguan_menelan)?in_array("gangguan menelan", $data_fisik_json->gangguan_menelan)?'gangguan menelan':'':'') ?>"],"check_gangguan_menelan":"<?= isset($data_fisik_json->check_gangguan_menelan)?$data_fisik_json->check_gangguan_menelan:'' ?>",
                // "penurunan_curah_jantung":["<?= (isset($data_fisik_json->penurunan_curah_jantung)?in_array("penurunan curah jantung", $data_fisik_json->penurunan_curah_jantung)?'penurunan curah jantung':'':'') ?>"],"check_penurunan_curah_jantung":"<?= isset($data_fisik_json->check_penurunan_curah_jantung)?$data_fisik_json->check_penurunan_curah_jantung:'' ?>",
                // "intoleran_aktifitas":["<?= (isset($data_fisik_json->intoleran_aktifitas)?in_array("intoleran aktifitas", $data_fisik_json->intoleran_aktifitas)?'intoleran aktifitas':'':'') ?>"],"check_intoleran_aktifitas":"<?= isset($data_fisik_json->check_intoleran_aktifitas)?$data_fisik_json->check_intoleran_aktifitas:'' ?>",
                // "gangguan_mobilitas_fisik":["<?= (isset($data_fisik_json->gangguan_mobilitas_fisik)?in_array("gangguan mobilitas fisik", $data_fisik_json->gangguan_mobilitas_fisik)?'gangguan mobilitas fisik':'':'') ?>"],"check_gangguan_mobilitas_fisik":"<?= isset($data_fisik_json->check_gangguan_mobilitas_fisik)?$data_fisik_json->check_gangguan_mobilitas_fisik:'' ?>",
                // "hambatan_komunikasi_verbal":["<?= (isset($data_fisik_json->hambatan_komunikasi_verbal)?in_array("hambatan komunikasi verbal", $data_fisik_json->hambatan_komunikasi_verbal)?'hambatan komunikasi verbal':'':'') ?>"],"check_hambatan_komunikasi_verbal":"<?= isset($data_fisik_json->check_hambatan_komunikasi_verbal)?$data_fisik_json->check_hambatan_komunikasi_verbal:'' ?>",
                // "diskontuinitas_jaringan":["<?= (isset($data_fisik_json->diskontuinitas_jaringan)?in_array("diskontiunitas jaringan", $data_fisik_json->diskontuinitas_jaringan)?'diskontiunitas jaringan':'':'') ?>"],"check_diskontuinitas_jaringan":"<?= isset($data_fisik_json->check_diskontuinitas_jaringan)?$data_fisik_json->check_diskontuinitas_jaringan:'' ?>",
                // "ketidakstabilan_gula_darah":["<?= (isset($data_fisik_json->ketidakstabilan_gula_darah)?in_array("ketidakstablian kadar gula darah", $data_fisik_json->ketidakstabilan_gula_darah)?'ketidakstablian kadar gula darah':'':'') ?>"],"check_ketidakstabilan_gula_darah":"<?= isset($data_fisik_json->check_ketidakstabilan_gula_darah)?$data_fisik_json->check_ketidakstabilan_gula_darah:'' ?>",
                // "lainnya":["<?= (isset($data_fisik_json->lainnya)?in_array("lainnya", $data_fisik_json->lainnya)?'lainnya':'':'') ?>"],"check_lainnya":"<?= isset($data_fisik_json->check_lainnya)?$data_fisik_json->check_lainnya:'' ?>","check_lainnya2":"<?= isset($data_fisik_json->check_lainnya2)?$data_fisik_json->check_lainnya2:'' ?>",
                // "lainnya1":["<?= (isset($data_fisik_json->lainnya1)?in_array("lainnya", $data_fisik_json->lainnya1)?'lainnya':'':'') ?>"],"check_lainnya1":"<?= isset($data_fisik_json->check_lainnya1)?$data_fisik_json->check_lainnya1:'' ?>","check_lainnya3":"<?= isset($data_fisik_json->check_lainnya3)?$data_fisik_json->check_lainnya3:'' ?>"
            };

            
        <?php }
        ?>
        surveyAssesmentKeperawatan.render("surveyContainer");
        surveyAssesmentKeperawatan
            .onComplete
            .add(function (result) {
                sendDataToServerKeperawatan(result);
            });

        

          
</script>