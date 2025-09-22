<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyFisikRehab"></div>

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

surveyJSONFisikRehab = <?php echo file_get_contents("lembar_kedokteran_fisik_rehab.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerFisikRehab(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/insert_fisik_rehab/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                fisik_rehab_json:JSON.stringify(survey.data),
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


    var survey_fisik_rehab = new Survey.Model(surveyJSONFisikRehab);

    <?php if($fisik_rehab){ ?>
		survey_fisik_rehab.data = <?php echo isset($fisik_rehab->formjson)?$fisik_rehab->formjson:''; ?>
	<?php }else{ ?>
        survey_fisik_rehab.data = {"question2":{"item1":{
            "anamnesa":"<?= isset($soap_pasien_rj->subjective_perawat)?$soap_pasien_rj->subjective_perawat:'' ?>",
            "fisik_ujifungsi":"Tekanan Darah : <?= isset($pemeriksaan_fisik->sitolic)?$pemeriksaan_fisik->sitolic.'/'.$pemeriksaan_fisik->diatolic:'' ?>\nBerat Badan : <?= isset($pemeriksaan_fisik->bb)?$pemeriksaan_fisik->bb:'' ?>\nNadi : <?= isset($pemeriksaan_fisik->nadi)?$pemeriksaan_fisik->nadi:'' ?>\nFrekuensi Nafas : <?= isset($pemeriksaan_fisik->frekuensi_nafas)?$pemeriksaan_fisik->frekuensi_nafas:'' ?>\nSuhu : <?= isset($pemeriksaan_fisik->suhu)?$pemeriksaan_fisik->suhu:'' ?>",
            "diagnosis":"<?php 
            if(isset($diagnosa)){
                foreach($diagnosa as $diag){ 
                   echo  $diag->id_diagnosa.'-'.$diag->diagnosa.'('.$diag->klasifikasi_diagnos.')\n';
                }
            } ?>",
            "penunjang":"<?php 
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
            "tata_laksana":"<?php 
            if(isset($procedure)){
                foreach($procedure as $pro){ 
                   echo  $pro->id_procedure.'-'.$pro->nm_procedure.'('.$pro->klasifikasi_procedure.')\n';
                }
            } ?>"}}}

    <?php } ?>
    

// survey.css = myCss;
$("#SurveyFisikRehab").Survey({
    model: survey_fisik_rehab,
    onComplete: sendDataToServerFisikRehab
});
</script>