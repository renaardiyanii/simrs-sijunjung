<?php 
 $this->load->view('header_form');
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="tindakan_anestesi_sedasi"></div>
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

surveyJSONtindakan_anestesi_sedasi = <?php echo file_get_contents("tindakan_anestesi_sedasi.JSON",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServertindakan_anestesi_sedasi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okchasil/tindakan_anestesi_sedasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
                id_ok : '<?php echo $id ;?>',
               tindakan_anestesi_sedasi_json:JSON.stringify(survey.data),
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


    var tindakan_anestesi_sedasi = new Survey.Model(surveyJSONtindakan_anestesi_sedasi);
    
    <?php
	if(isset($tindakan_anestesi_sedasi_ok)){ ?>
		tindakan_anestesi_sedasi.data = <?= $tindakan_anestesi_sedasi_ok->formjson ?>;

	<?php } else { ?>
        tindakan_anestesi_sedasi.data = {
            "question2": {
                "text1": <?= json_encode(isset($fisik->jenis) ? $fisik->jenis : '') ?>
              
            },
            "question1": {
                "text2": <?= json_encode(isset($fisik->diagnosa) ? $fisik->diagnosa : '') ?>
              
            }
        }
   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#tindakan_anestesi_sedasi").Survey({
    model:tindakan_anestesi_sedasi,
    onComplete: sendDataToServertindakan_anestesi_sedasi
});
</script>