<?php 
$this->load->view('layout/header_form');
// var_dump($diagnosa->diagnosa)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyProgramTerapiRehab"></div>

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

surveyJSONProgramTerapiRehab = <?php echo file_get_contents("program_terapi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerProgramTerapiRehab(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/insert_program_terapi_rehab/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                program_terapi_json:JSON.stringify(survey.data),
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


    var survey_program_terapi_rehab = new Survey.Model(surveyJSONProgramTerapiRehab);
    <?php if($program_terapi_rehab){ ?>
        survey_program_terapi_rehab.data = <?= $program_terapi_rehab->formjson; ?>
	<?php }else{ ?>
        survey_program_terapi_rehab.data = {
  "question1": {
      "diagnosa": "<?= isset($diagnosa->diagnosa) ? $diagnosa->diagnosa . '(' . $diagnosa->id_diagnosa . ')' : '' ?>",
   },
    
  }
           
        <?php } ?>
    

// survey.css = myCss;
$("#SurveyProgramTerapiRehab").Survey({
    model: survey_program_terapi_rehab,
    onComplete: sendDataToServerProgramTerapiRehab
});
</script>