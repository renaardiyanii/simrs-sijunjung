<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyPengantarRawatInap"></div>

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

surveyJSONPengantarranap = <?php echo file_get_contents("pengantar_rawat_inap.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPengantarRawatInap(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/pengantar_ranap/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                pengantar_ranap_json:JSON.stringify(survey.data),
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


    var survey_pengantar_ranap = new Survey.Model(surveyJSONPengantarranap);

    <?php if($pengantar_ranap){ ?>
		survey_pengantar_ranap.data = <?php echo isset($pengantar_ranap->formjson)?$pengantar_ranap->formjson:''; ?>
	<?php }else{ ?>
        survey_pengantar_ranap.data = {

        "terapi": <?= json_encode(isset($rencana_kerja->rencana) ? $rencana_kerja->rencana : '') ?>

        }
        
    <?php } ?>
    

// survey.css = myCss;
$("#SurveyPengantarRawatInap").Survey({
    model: survey_pengantar_ranap,
    onComplete: sendDataToServerPengantarRawatInap
});
</script>