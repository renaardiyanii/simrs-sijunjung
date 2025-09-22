<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyUjiFungsiRehab"></div>

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

surveyJSONUjifungsirehab = <?php echo file_get_contents("hasil_uji_fungsi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerUjiFungsiRehab(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/insert_uji_fungsi_rehab/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                uji_fungsi_rehab_json:JSON.stringify(survey.data),
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


    var survey_uji_fungsi_rehab = new Survey.Model(surveyJSONUjifungsirehab);

    <?php if($uji_fungsi_rehab){ ?>
		survey_uji_fungsi_rehab.data = <?php echo isset($uji_fungsi_rehab->formjson)?$uji_fungsi_rehab->formjson:''; ?>
	<?php }else{ ?>
        survey_uji_fungsi_rehab.data = {
  "question2": {
    "item1": {
      "diagnosis_med": "<?= isset($diagnosa->diagnosa) ? $diagnosa->diagnosa . '(' . $diagnosa->id_diagnosa . ')' : '' ?>",
      "no_hp": "<?= isset($data_pasien_daftar_ulang->no_hp) ? $data_pasien_daftar_ulang->no_hp : '' ?>",
      "diagnosis_fung": "<?= isset($diagnosa->diagnosa) ? $diagnosa->diagnosa . '(' . $diagnosa->id_diagnosa . ')' : '' ?>"
    },
    
  }
}


    <?php } ?>
    

// survey.css = myCss;
$("#SurveyUjiFungsiRehab").Survey({
    model: survey_uji_fungsi_rehab,
    onComplete: sendDataToServerUjiFungsiRehab
});
</script>