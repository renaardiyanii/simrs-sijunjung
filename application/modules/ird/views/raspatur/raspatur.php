<?php  //var_dump($transfer_ruangan);
// var_dump();
$this->load->view('layout/header_form');
?>
<style>

</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>

<div id="SurveyRaspatur"></div>
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

var surveyJSONRaspatur = <?php echo file_get_contents(__DIR__ ."/raspatur.json");?>;



function sendDataToServerRaspatur(survey) {

        $.ajax({
            type: "POST",
            url: '<?php echo base_url('irj/rjcpelayanan/raspatur/') ?>',
            data: {
                no_reg : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                raspatur_json:JSON.stringify(survey.data),
            },
            success: function(data)
            {
            
                location.reload();
                

            },
            error: function(data)
            {
                
            }
        }); 
             console.log(JSON.stringify(survey.data));
        
        }


    var survey_raspatur = new Survey.Model(surveyJSONRaspatur);
    

    <?php
	if(isset($raspatur)){ ?>
		survey_raspatur.data = <?= isset($raspatur->formjson)?$raspatur->formjson:'' ?>;

	<?php } else { ?>
   <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyRaspatur").Survey({
    model: survey_raspatur,
    onComplete: sendDataToServerRaspatur
});
</script>