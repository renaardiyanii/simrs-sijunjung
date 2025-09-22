
<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveysurat_kontrol"></div>

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

surveyJSONsurat_kontrol = <?php echo file_get_contents("surat_kontrol.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServersurat_kontrol(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_surat_kontrol/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                surat_kontrol_json:JSON.stringify(survey.data),
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


    var survey_surat_kontrol = new Survey.Model(surveyJSONsurat_kontrol);

    <?php if($surat_kontrol){ ?>
		survey_surat_kontrol.data = <?php echo isset($surat_kontrol->formjson)?$surat_kontrol->formjson:''; ?>
	<?php }else{ ?>
       survey_surat_kontrol.data = {
             "question1": <?= json_encode(isset($form_resume->pemeriksaan_fisik) ? $form_resume->pemeriksaan_fisik : '') ?>,
             "question2": <?= json_encode(isset($form_resume->anjuran) ? $form_resume->anjuran : '') ?>,
             "question3": <?= json_encode(isset($form_resume->penunjang) ? $form_resume->penunjang : '') ?>,
             "question4": <?= json_encode(isset($form_resume->diagnosa) ? $form_resume->diagnosa : '') ?>,
             <?php
                $data_terapi = isset($form_resume->terapi) ? json_decode($form_resume->terapi, true) : [];
                $string_data = '';

                if ($data_terapi && is_array($data_terapi)) {
                    $rows = [];
                    foreach ($data_terapi as $item) {
                        $rows[] = implode(', ', array_values($item));
                    }
                    $string_data = implode("\n", $rows); // newline pakai \n
                }
                ?>

                "question5": <?= json_encode($string_data) ?>,


             
        }

    <?php } ?>
    

// survey.css = myCss;
$("#surveysurat_kontrol").Survey({
    model: survey_surat_kontrol,
    onComplete: sendDataToServersurat_kontrol
});
</script>