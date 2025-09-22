<?php 
 $this->load->view('header_form');
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="edukasi_anestesi_sedasi"></div>
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

surveyJSONedukasi_anestesi_sedasi = <?php echo file_get_contents("edukasi_anestesi_sedasi.JSON",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServeredukasi_anestesi_sedasi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okchasil/edukasi_anestesi_sedasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
                id_ok : '<?php echo $id ;?>',
                edukasi_anestesi_sedasi_json:JSON.stringify(survey.data),
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


    var edukasi_anestesi_sedasi = new Survey.Model(surveyJSONedukasi_anestesi_sedasi);
    
    <?php
	if(isset($edukasi_anestesi_sedasi_ok)){ ?>
		edukasi_anestesi_sedasi.data = <?= $edukasi_anestesi_sedasi_ok->formjson ?>;

	<?php } else { ?>
        edukasi_anestesi_sedasi.data = {
            "question19": {
                "text8": <?= json_encode(isset($fisik->jenis) ? $fisik->jenis : '') ?>,
                "text6": <?= json_encode(isset($fisik->diagnosa) ? $fisik->diagnosa : '') ?>
              
            }
        }
   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#edukasi_anestesi_sedasi").Survey({
    model: edukasi_anestesi_sedasi,
    onComplete: sendDataToServeredukasi_anestesi_sedasi
});
</script>