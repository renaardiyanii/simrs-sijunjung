<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyProgramMedikAnak"></div>

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

surveyJSONMedikAnak = <?php echo file_get_contents("pengkajian_medis_anak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerMedisAnak(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/insert_medik_anak/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                medis_anak_json:JSON.stringify(survey.data),
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


    var survey_medis_anak = new Survey.Model(surveyJSONMedikAnak);

    <?php if($medik_anak){ ?>
		survey_medis_anak.data = <?php echo isset($medik_anak->formjson)?$medik_anak->formjson:''; ?>
	<?php }else{ ?>
        survey_medis_anak.data =  {"question3":"<?= isset($soap_pasien_rj->subjective_perawat)?$soap_pasien_rj->subjective_perawat:'' ?>",
            "question5":"<?= isset($soap_pasien_rj->objective_perawat)?str_replace('-','\n',$soap_pasien_rj->objective_perawat):'' ?>",
            "question8":"<?php 
                if(isset($lab)){
                    foreach($lab as $val){ 
                    echo  $val->jenis_tindakan.'(L)'.'\n';
                    }
                } 
                if(isset($rad)){
                    foreach($rad as $value){ 
                    echo  $value->jenis_tindakan.'(R)'.'\n';
                    }
                }
                ?>",
            "question9":"<?php 
            if(isset($diagnosa)){
                foreach($diagnosa as $diag){ 
                   echo  $diag->id_diagnosa.'-'.$diag->diagnosa.'('.$diag->klasifikasi_diagnos.')\n';
                }
            } ?>"}

    <?php } ?>
    

// survey.css = myCss;
$("#SurveyProgramMedikAnak").Survey({
    model: survey_medis_anak,
    onComplete: sendDataToServerMedisAnak
});
</script>