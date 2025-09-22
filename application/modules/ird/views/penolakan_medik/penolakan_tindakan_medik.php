<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyPenolakanTindakanMedik"></div>

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

surveyJSONpenolakantindakanmedik = <?php echo file_get_contents("penolakan_tindakan_medis.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPenolakantindakanmedik(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/penolakan_tindakan_medik/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                penolakan_tindakan_medik_json:JSON.stringify(survey.data),
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


    var survey_penolakan_tindakan_medik = new Survey.Model(surveyJSONpenolakantindakanmedik);

    
    <?php if($penolakan_tindakan_medik){ ?>
		survey_penolakan_tindakan_medik.data = <?php echo isset($penolakan_tindakan_medik->formjson)?$penolakan_tindakan_medik->formjson:''; ?>
	<?php }else{ ?>
        
        <?php } ?>

// survey.css = myCss;
$("#SurveyPenolakanTindakanMedik").Survey({
    model: survey_penolakan_tindakan_medik,
    onComplete: sendDataToServerPenolakantindakanmedik
});
</script>