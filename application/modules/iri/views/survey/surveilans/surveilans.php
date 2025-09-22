<?php 
$this->load->view('layout/header_form');
$anes = isset($lap_anestesi->formjson)?json_decode($lap_anestesi->formjson):'';
$opr = isset($lap_operasi->formjson)?json_decode($lap_operasi->formjson):'';
$persiapan = isset($persiapan_opr->formjson)?json_decode($persiapan_opr->formjson):'';
$keperawatan = (isset($keperawatan_igd->formjson)?json_decode($keperawatan_igd->formjson):'');
$skor = 0;
$skor = isset($keperawatan->parameter)?$keperawatan->parameter == "tidak_yakin"?$skor +2:$skor+0:$skor+0; 
if(isset($keperawatan->check_parameter)){
    switch($keperawatan->check_parameter){
        case 'item1':
            $skor+=1;
            break;
        case 'item2':
            $skor+=2;
            break;
        case 'item3':
            $skor+=3;
            break;
        case 'item4':
            $skor+=4;
            break;
        case 'item5':
            $skor+=2;
            break;
        default:
            break;
    }
}
$skor = isset($data->parameter1)?$data->parameter1 == 'ya'?$skor+1:$skor+0 :$skor + 0;
// $sur = isset($survei_iri->formjson)?json_decode($survei_iri->formjson):'';
// var_dump($sur->question4[0]->tirah_baring);die();
// var_dump($skor);die();
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div class="card m-5"> 
    <div class="body">
    <div id="SurveySurveilans"></div>

    </div>
</div>

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

Survey.StylesManager.applyTheme("modern");

surveyJSONSurveilans = <?php echo file_get_contents("surveilans.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerSurveilans(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/surveilans/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                ews_json:JSON.stringify(survey.data),
            },
            success: function(data)
            {
            
                location.reload();
                

            },
            error: function(data)
            {
                
            }
        }); 
            //  console.log(JSON.stringify(survey.data));
        
        }


    var survey_surveilans = new Survey.Model(surveyJSONSurveilans);

    <?php if($survei_irj && !$survei_iri){ ?>
		survey_surveilans.data = <?= $survei_irj->formjson; ?>
	<?php }else if(!$survei_irj && !$survei_iri){ ?>
    survey_surveilans.data = {"question5":"<?php echo isset($persiapan->question10->{'Row 1'}->{'Column 8'})?$persiapan->question10->{'Row 1'}->{'Column 8'}:'' ?>",
        "question1":{
        "ruang":"<?= $data_pasien[0]['nm_ruang'] ?>",
        "ruang1":"<?= isset($ruang_mutasi[0]['nmruang'])?$ruang_mutasi[0]['nmruang']:''?>",
        "tgl":"<?= isset($ruang_mutasi_baru[0]['tglmasukrg'])?$ruang_mutasi_baru[0]['tglmasukrg']:''?>",
        "tgl1":"<?= isset($ruang_mutasi[0]['tglmasukrg'])?$ruang_mutasi[0]['tglmasukrg']:''?>",
        "tgl_keluar":"<?= isset($data_pasien[0]['tgl_keluar_resume'])?$data_pasien[0]['tgl_keluar_resume']:'' ?>",
        "sebab_keluar":"<?= isset($data_pasien[0]['cara_pulang'])?$data_pasien[0]['cara_pulang']:'' ?>",
        "diagnosa_akhir":"<?= isset($diagnosa_iri_utama->diagnosa)?$diagnosa_iri_utama->diagnosa:'' ?>"},
        "question2":[{"asa":"<?php echo isset($anes->question34)?$anes->question34:''; ?>",
            "ahli_bedah":"<?php echo isset($opr->question1->{'Row 1'}->{'Column 1'})?$opr->question1->{'Row 1'}->{'Column 1'}:'' ?>"}],
        "pemasangan":[{"nama":"<?php
            foreach($dpo_surveilans as $r) {
                echo $r->nm_obat.',';
            } ?>",
        "status_gizi":"<?php echo $skor; ?>, Bila skor >= 2 pasien berisiko malnutrisi, konsul ke ahli gizi"}],
        "question3":[{"suhu":"<?php echo $suhu_fisik; ?>"}]};
    <?php } else if($survei_iri) { ?>
        survey_surveilans.data = <?= $survei_iri->formjson; ?>
    <?php } ?>

	// survey_ews.showNavigationButtons = false;

// survey.css = myCss;
$("#SurveySurveilans").Survey({
    model: survey_surveilans,
    onComplete: sendDataToServerSurveilans
});
</script>