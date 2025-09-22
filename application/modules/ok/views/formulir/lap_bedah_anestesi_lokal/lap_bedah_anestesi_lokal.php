<?php 
 $this->load->view('header_form');
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="lap_bedah_anestesi_lokal"></div>
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

surveyJSONlap_bedah_anestesi_lokal = <?php echo file_get_contents("lap_bedah_anestesi_lokal.JSON",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerlap_bedah_anestesi_lokal(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okchasil/lap_bedah_anestesi_lokal/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
                id_ok : '<?php echo $id ;?>',
                lap_bedah_anestesi_lokal_json:JSON.stringify(survey.data),
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


    var lap_bedah_anestesi_lokal = new Survey.Model(surveyJSONlap_bedah_anestesi_lokal);
    
    <?php
	if(isset($lap_bedah_anestesi_lokal_ok)){ ?>
		lap_bedah_anestesi_lokal.data = <?= $lap_bedah_anestesi_lokal_ok->formjson ?>;

	<?php } else { ?>
        lap_bedah_anestesi_lokal.data = {
            "question7": {
                "text1": <?= json_encode(isset($fisik->jenis) ? $fisik->jenis : '') ?>,
            },
            "diagnosa_pra_bedah": <?= json_encode(isset($fisik->diagnosa) ? $fisik->diagnosa : '') ?>
        }
   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#lap_bedah_anestesi_lokal").Survey({
    model: lap_bedah_anestesi_lokal,
    onComplete: sendDataToServerlap_bedah_anestesi_lokal
});
</script>