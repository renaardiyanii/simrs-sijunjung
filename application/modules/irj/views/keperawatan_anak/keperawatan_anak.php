<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyProgramKeperawatanAnak"></div>

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

surveyJSONKeperawatanAnak = <?php echo file_get_contents("keperawatan_anak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerKeperawatanAnak(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/insert_keperawatan_anak/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                keperawatan_anak_json:JSON.stringify(survey.data),
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


    var survey_keperawatan_anak = new Survey.Model(surveyJSONKeperawatanAnak);

    <?php if($keperawatan_anak){ ?>
		survey_keperawatan_anak.data = <?php echo isset($keperawatan_anak->formjson)?$keperawatan_anak->formjson:''; ?>
	<?php }else{ ?>
        survey_keperawatan_anak.data = {"question5":"<?= isset($data_pasien->alamat)?$data_pasien->alamat:'' ?>",
            "question2":"<?= isset($diagnosa->diagnosa)?$diagnosa->diagnosa.'('.$diagnosa->id_diagnosa.')':'' ?>",
            "question6":"<?= isset($soap_pasien_rj->subjective_perawat)?$soap_pasien_rj->subjective_perawat:'' ?>",
            "question7":{"bb":"<?= isset($pemeriksaan_fisik->bb)?$pemeriksaan_fisik->bb:'' ?>",
                "tekanan":"<?= isset($pemeriksaan_fisik->sitolic)?$pemeriksaan_fisik->bb.'/'.$pemeriksaan_fisik->diatolic:'' ?>",
                "suhu":"<?= isset($pemeriksaan_fisik->suhu)?$pemeriksaan_fisik->suhu:'' ?>",
                "nadi":"<?= isset($pemeriksaan_fisik->nadi)?$pemeriksaan_fisik->nadi:'' ?>",
                "pernapasan":"<?= isset($pemeriksaan_fisik->frekuensi_nafas)?$pemeriksaan_fisik->frekuensi_nafas:'' ?>",
                "lk":"d<?= isset($pemeriksaan_fisik->lingkar_kepala)?$pemeriksaan_fisik->lingkar_kepala:'' ?>sf"}}

    <?php } ?>
    

// survey.css = myCss;
$("#SurveyProgramKeperawatanAnak").Survey({
    model: survey_keperawatan_anak,
    onComplete: sendDataToServerKeperawatanAnak
});
</script>