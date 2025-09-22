<?php 
$this->load->view('layout/header_form');
?>

<div class="card m-5">
    <div class="body">
        <div id="SurveyEWS"></div>

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

surveyJSONEws = <?php echo file_get_contents("form_ews.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerEws(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/lembar_ews_ri/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
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


    var survey_ews = new Survey.Model(surveyJSONEws);
    

    <?php
	if(isset($lembar_ews_iri)){ ?>
		survey_ews.data = <?= $lembar_ews_iri->formjson ?>;

	<?php } else { ?>
        survey_ews.setValue('ruangan','<?= $data_pasien[0]['nmruang'] ?>');
   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyEWS").Survey({
    model: survey_ews,
    onComplete: sendDataToServerEws
});
</script>