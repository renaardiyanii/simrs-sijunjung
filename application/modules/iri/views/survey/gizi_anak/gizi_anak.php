<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->



<div class="card m-5">
    <div class="body">
    <div id="SurveyGiziAnak"></div>

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

surveyJSONGiziAnak = <?php echo file_get_contents("gizi_anak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerGiziAnak(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/gizi_anak/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                skrining_json:JSON.stringify(survey.data),
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


    var survey_gizi_anak = new Survey.Model(surveyJSONGiziAnak);
    
    


    <?php
	if(isset($gizi_anak)){ ?>
		survey_gizi_anak.data = <?= isset($gizi_anak->formjson)?$gizi_anak->formjson:'' ?>;

	<?php } else { ?>
        survey_gizi_anak.setValue('diagnosis_medis','<?= $data_pasien[0]['nm_diagmasuk'] ?>');
   <?php } ?>
	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyGiziAnak").Survey({
    model: survey_gizi_anak,
    onComplete: sendDataToServerGiziAnak
});
</script>