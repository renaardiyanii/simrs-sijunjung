<?php  //var_dump($transfer_ruangan);
// var_dump();
$this->load->view('layout/header_form');
?>
<style>

</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>

<div id="SurveyRaslan"></div>
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

var surveyJSONRaslan = <?php echo file_get_contents(__DIR__ ."/raslan.json");?>;



function sendDataToServerRaslan(survey) {

        $.ajax({
            type: "POST",
            url: '<?php echo base_url('irj/rjcpelayanan/raslan/') ?>',
            data: {
                no_reg : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                raslan_json:JSON.stringify(survey.data),
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


    var survey_raslan = new Survey.Model(surveyJSONRaslan);
    

    <?php
	if(isset($raslan)){ ?>
		survey_raslan.data = <?= isset($raslan->formjson)?$raslan->formjson:'' ?>;

	<?php } else { ?>
       
   <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyRaslan").Survey({
    model: survey_raslan,
    onComplete: sendDataToServerRaslan
});
</script>