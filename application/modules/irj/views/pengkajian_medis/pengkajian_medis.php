<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyPengkajianMedis"></div>

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

surveyJSONpengkajianmedisrajal = <?php echo file_get_contents("pengkajian_medik.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPengkajianMedis(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/pengkajian_medis_rawat_jalan/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                pengkajian_medis_json:JSON.stringify(survey.data),
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


    var survey_pengkajian_medis = new Survey.Model(surveyJSONpengkajianmedisrajal);

   
    <?php if($pengkajian_medis_rj){ ?>
        survey_pengkajian_medis.data = <?= $pengkajian_medis_rj->formjson; ?>
	<?php }else{ ?>
        survey_pengkajian_medis.data =  {"question1":{"kel_utama":{"anamnesis1": <?= json_encode(isset($soap_pasien_rj->subjective_dokter) ? ($soap_pasien_rj->subjective_dokter) : '') ?> }},
        "question2":{"td":"<?= isset($pemeriksaan_fisik->sitolic)?$pemeriksaan_fisik->sitolic.'/'.$pemeriksaan_fisik->diatolic:'' ?>","nadi":"<?= isset($pemeriksaan_fisik->nadi)?$pemeriksaan_fisik->nadi:''?>","pernafasan":"<?= isset($pemeriksaan_fisik->frekuensi_nafas)?$pemeriksaan_fisik->frekuensi_nafas:''?>","suhu":"<?= isset($pemeriksaan_fisik->suhu)?$pemeriksaan_fisik->suhu:''?>"},
        "question3":"<?php 
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
        "question4":"<?php 
            if(isset($diagnosa)){
                foreach($diagnosa as $diag){ 
                   echo  $diag->id_diagnosa.'-'.$diag->diagnosa.'('.$diag->klasifikasi_diagnos.')\n';
                }
            } ?>",
        "question5":"<?php 
            if(isset($resep)){
                foreach($resep as $obat){ 
                   echo  $obat->nm_obat.'('.$obat->signa.')\n';
                }
            } ?>"}
        <?php } ?>

    
    
// survey.css = myCss;
$("#SurveyPengkajianMedis").Survey({
    model: survey_pengkajian_medis,
    onComplete: sendDataToServerPengkajianMedis
});
</script>