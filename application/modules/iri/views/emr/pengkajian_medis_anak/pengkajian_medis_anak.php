<?php 
$this->load->view('layout/header_form');
// var_dump($keperawatan_general)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveymedikanak"></div>

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

surveyJSONmedikanak = <?php echo file_get_contents("pengkajian_medis_anak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServermedikanak(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_pengkajian_medis_anak/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pengkajian_medis_anak_json:JSON.stringify(survey.data),
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


    var survey_medik_anak = new Survey.Model(surveyJSONmedikanak);

    <?php if($pengkajian_medis_anak){ ?>
        survey_medik_anak.data = <?= $pengkajian_medis_anak->formjson ?? '{}' ?>;
        <?php } else { 
            $keluhan = $data_irj->keluhan ?? ($data_igd->keluhan ?? '');
            $diagnosa = $data_irj->diagnosa ?? ($data_igd->diagnosa ?? '');
            $diagnosa = str_replace(['(utama)', '(tambahan)'], ["(utama)", "(tambahan)"], $diagnosa);
        ?>
            survey_medik_anak.data = {
                "riwayat_penyakit_sekarang": <?= json_encode($keluhan) ?>,
                "question18": <?= json_encode($diagnosa) ?>
               
            };
        <?php } ?>
    

// survey.css = myCss;
$("#surveymedikanak").Survey({
    model: survey_medik_anak,
    onComplete: sendDataToServermedikanak
});
</script>