<?php 
 $this->load->view('header_form');
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="CaperPeriOperatif"></div>
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

surveyJSONCaperPeriOperatif = <?php echo file_get_contents("caper_peri_operatif.JSON",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServercaperperioperatif(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okchasil/catatan_peri_operatif/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
                id_ok : '<?php echo $id ;?>',
                caper_peri_operatif_json:JSON.stringify(survey.data),
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


    var caper_peri_operatif = new Survey.Model(surveyJSONCaperPeriOperatif);
    
    <?php
	if(isset($caper_perioperatif)){ ?>
		caper_peri_operatif.data = <?= $caper_perioperatif->formjson ?>;

	<?php } else { ?>
        caper_peri_operatif.data = {
            "question10": {
                "text5": <?= json_encode(isset($fisik->bb) ? $fisik->bb : '') ?>,
                "text6": <?= json_encode(isset($fisik->tb) ? $fisik->tb : '') ?>,
                "text1": <?= json_encode(isset($fisik->td) ? $fisik->td : '') ?>,
                "text3": <?= json_encode(isset($fisik->suhu) ? $fisik->suhu : '') ?>,
                "text2": <?= json_encode(isset($fisik->rr) ? $fisik->rr : '') ?>,
            },
            "question2": {
                "text2": <?= json_encode(isset($fisik->jenis) ? $fisik->jenis : '') ?>
              
            },
            "question3": <?= json_encode(isset($fisik->diagnosa) ? $fisik->diagnosa : '') ?>
        }
   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#CaperPeriOperatif").Survey({
    model: caper_peri_operatif,
    onComplete: sendDataToServercaperperioperatif
});
</script>