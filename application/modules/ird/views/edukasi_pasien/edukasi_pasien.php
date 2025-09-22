<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyEdukasiPasien"></div>

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

surveyJSONEdukasi = <?php echo file_get_contents("formulir_edukasi_pasien.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerEdukasiPasien(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/insert_edukasi_pasien') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                edukasi_pasien_json:JSON.stringify(survey.data),
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


    var survey_edukasi_pasien = new Survey.Model(surveyJSONEdukasi);

    <?php if($edukasi_pasien){ ?>
        survey_edukasi_pasien.data = <?php  echo $edukasi_pasien->formjson; ?>
	<?php }else{ ?>
         
        <?php  } ?>

    

// survey.css = myCss;
$("#SurveyEdukasiPasien").Survey({
    model: survey_edukasi_pasien,
    onComplete: sendDataToServerEdukasiPasien
});
</script>