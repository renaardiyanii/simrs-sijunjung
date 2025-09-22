<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyLembarKonsul"></div>

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

surveyJSONLembarKonsul = <?php echo file_get_contents("konsul_dokter.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerLembarKonsul(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/lembar_konsultasi/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                lembar_konsul_json:JSON.stringify(survey.data),
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


    var survey_lembar_konsul = new Survey.Model(surveyJSONLembarKonsul);

   
    <?php if($lembar_konsul){ ?>
        survey_lembar_konsul.data = <?php  echo $lembar_konsul->formjson; ?>
	<?php }else{ ?>
         
        <?php  } ?>

    
    
// survey.css = myCss;
$("#SurveyLembarKonsul").Survey({
    model: survey_lembar_konsul,
    onComplete: sendDataToServerLembarKonsul
});
</script>