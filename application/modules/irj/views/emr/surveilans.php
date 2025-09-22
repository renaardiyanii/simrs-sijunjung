<?php 
$this->load->view('layout/header_form');
$anes = isset($lap_anestesi->formjson)?json_decode($lap_anestesi->formjson):'';
$opr = isset($lap_operasi->formjson)?json_decode($lap_operasi->formjson):'';
$persiapan = isset($persiapan_opr->formjson)?json_decode($persiapan_opr->formjson):'';
// var_dump($persiapan->question10->{'Row 1'}->{'Column 8'});die();
// $sur = isset($survei_iri->formjson)?json_decode($survei_iri->formjson):'';
// var_dump($opr->question1->{'Row 1'}->{'Column 1'});die();
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
            url: '<?= base_url('irj/rjcpelayanan/surveilans/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
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

    <?php if($survei_irj){ ?>
		survey_surveilans.data = <?= $survei_irj->formjson; ?>
	<?php }else{ ?>
    survey_surveilans.data = {"question5":"<?php echo isset($persiapan->question10->{'Row 1'}->{'Column 8'})?$persiapan->question10->{'Row 1'}->{'Column 8'}:'' ?>",
        "question2":[{"asa":"<?php echo isset($anes->question34)?$anes->question34:''; ?>",
            "ahli_bedah":"<?php echo isset($opr->question1->{'Row 1'}->{'Column 1'})?$opr->question1->{'Row 1'}->{'Column 1'}:'' ?>"}]};
    <?php } ?>

    
	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveySurveilans").Survey({
    model: survey_surveilans,
    onComplete: sendDataToServerSurveilans
});
</script>