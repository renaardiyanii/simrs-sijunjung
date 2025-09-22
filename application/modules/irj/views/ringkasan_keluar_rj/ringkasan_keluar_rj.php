<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyRingkasanKeluar"></div>

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

surveyJSONringkasankeluar = <?php echo file_get_contents("ringkasan_keluar_rj.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerRingkasanKeluarRJ(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/ringkasan_keluar_pasien_rj/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                ringkasan_keluar_json:JSON.stringify(survey.data),
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


    var survey_ringkasan_keluar = new Survey.Model(surveyJSONringkasankeluar);

    
    <?php if($ringkasan_keluar){ ?>
		survey_ringkasan_keluar.data = <?php echo isset($ringkasan_keluar->formjson)?$ringkasan_keluar->formjson:''; ?>
	<?php }else{ ?>
        survey_ringkasan_keluar.data = {
            "question2": "<?= isset($soap_pasien_rj->subjective_dokter) ? str_replace(["\r", "\n"], ["", "\\n"], $soap_pasien_rj->subjective_dokter) : '' ?>",
            "anjuran":<?= json_encode(isset($soap_pasien_rj->intruksi) ? $soap_pasien_rj->intruksi : '') ?>,
            "tindakan":"<?php 
            if(isset($procedure)){
                foreach($procedure as $tind){ 
                    echo  '-'.$tind->nm_procedure.'\n';
                }
            } ?>",
            "question3":"<?php 
            if(isset($resep)){
                foreach($resep as $obat){ 
                    echo  '-'.$obat->nama_obat.'('.$obat->signa.')'.'\n';
                }
            } ?>",
             "diagnosa":"<?php 
            if(isset($diagnosa)){
                foreach($diagnosa as $diag){ 
                    if($diag->klasifikasi_diagnos == 'utama'){
                     echo  '-'.$diag->diagnosa;
                     }
                }
            } ?>",
             "diagnosa_sekunder":"<?php 
            if(isset($diagnosa)){
                foreach($diagnosa as $diag){ 
                    if($diag->klasifikasi_diagnos == 'tambahan'){
                     echo  '-'.$diag->diagnosa.'\n';
                     }
                }
            } ?>" 
            }
        <?php } ?>

// survey.css = myCss;
$("#SurveyRingkasanKeluar").Survey({
    model: survey_ringkasan_keluar,
    onComplete: sendDataToServerRingkasanKeluarRJ
});
</script>