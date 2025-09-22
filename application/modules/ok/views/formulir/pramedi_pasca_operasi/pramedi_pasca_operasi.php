<?php 
 $this->load->view('header_form');
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="pramedi_pasca_operasi"></div>
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

surveyJSONpramedi_pasca_operasi = <?php echo file_get_contents("pramedi_pasca_operasi.JSON",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpramedi_pasca_operasi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okchasil/pramedi_pasca_operasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
                id_ok : '<?php echo $id ;?>',
                pramedi_pasca_operasi_json:JSON.stringify(survey.data),
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


    var pramedi_pasca_operasi = new Survey.Model(surveyJSONpramedi_pasca_operasi);
    
    <?php
	if(isset($pramedi_pasca_operasi_ok)){ ?>
		pramedi_pasca_operasi.data = <?= $pramedi_pasca_operasi_ok->formjson ?>;

	<?php } else { ?>
       
   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#pramedi_pasca_operasi").Survey({
    model: pramedi_pasca_operasi,
    onComplete: sendDataToServerpramedi_pasca_operasi
});
</script>