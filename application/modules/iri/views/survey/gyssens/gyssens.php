<?php  //var_dump($transfer_ruangan);
// var_dump();
$this->load->view('layout/header_form');
?>
<style>

</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>

<div id="SurveyGyssens"></div>
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

var surveyJSONGyssens = <?php echo file_get_contents(__DIR__ ."/gyssens.json");?>;



function sendDataToServerGyssens(survey) {

        $.ajax({
            type: "POST",
            url: '<?php echo base_url('irj/rjcpelayanan/gyssens/') ?>',
            data: {
                no_reg : '<?php echo $no_ipd ;?>',
                gyssens_json:JSON.stringify(survey.data),
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


    var survey_gyssens = new Survey.Model(surveyJSONGyssens);
    

    <?php
	if(isset($gyssens)){ ?>
		survey_gyssens.data = <?= isset($gyssens->formjson)?$gyssens->formjson:'' ?>;

	<?php } else { ?>
   <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyGyssens").Survey({
    model: survey_gyssens,
    onComplete: sendDataToServerGyssens
});
</script>