<?php 
$this->load->view('layout/header_form');
// var_dump($data_dokter)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyPersetujuanTindakanMedik"></div>

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

surveyJSONpersetujuantindakanmedik = <?php echo file_get_contents("persetujuan_tindakan_medis.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPersetujuantindakanmedik(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/persetujuan_tindakan_medik/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                persetujuan_tindakan_medik_json:JSON.stringify(survey.data),
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


    var survey_persetujuan_tindakan_medik = new Survey.Model(surveyJSONpersetujuantindakanmedik);

    
    <?php if($persetujuan_tindakan_medik){ ?>
		survey_persetujuan_tindakan_medik.data = <?php echo isset($persetujuan_tindakan_medik->formjson)?$persetujuan_tindakan_medik->formjson:''; ?>
	<?php }else{ ?>
        survey_persetujuan_tindakan_medik.data = {
        "question1":{"dokter":"<?= isset($data_dokter->dokter) ? $data_dokter->dokter : '' ?>"}
         }
          <?php } ?>

// survey.css = myCss;
$("#SurveyPersetujuanTindakanMedik").Survey({
    model: survey_persetujuan_tindakan_medik,
    onComplete: sendDataToServerPersetujuantindakanmedik
});
</script>