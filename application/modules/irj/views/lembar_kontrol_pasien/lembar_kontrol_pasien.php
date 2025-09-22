<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyLembarKontrol"></div>

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

surveyJSONlembarkontrol = <?php echo file_get_contents("surat_kontrol.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerLembarKontrol(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/lembar_kontrol_pasien/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                lembar_kontrol_json:JSON.stringify(survey.data),
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


    var survey_lembar_kontrol = new Survey.Model(surveyJSONlembarkontrol);

    
    <?php if($lembar_kontrol){ ?>
		survey_lembar_kontrol.data = <?php echo isset($lembar_kontrol->formjson)?$lembar_kontrol->formjson:''; ?>
	<?php }else{ ?>
        survey_lembar_kontrol.data =    {"faskes": <?= json_encode(isset($soap_pasien_rj->subjective_dokter) ? $soap_pasien_rj->subjective_dokter : '') ?>,
            "rencana": <?= json_encode(isset($soap_pasien_rj->intruksi)?$soap_pasien_rj->intruksi:'') ?>,
            "kontrol1": <?= json_encode(isset($ringkasan->tanggal) ? $ringkasan->tanggal : '') ?>}
        <?php  } ?>

// survey.css = myCss;
$("#SurveyLembarKontrol").Survey({
    model: survey_lembar_kontrol,
    onComplete: sendDataToServerLembarKontrol
});
</script>