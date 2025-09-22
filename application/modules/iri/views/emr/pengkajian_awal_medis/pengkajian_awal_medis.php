<?php 
$this->load->view('layout/header_form');
// var_dump($keluhan);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypengkajianawalmedis"></div>

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

surveyJSONpengkajianmedis = <?php echo file_get_contents("pengkajian_awal_medis.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpengkajianawalmedis(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_pengkajain_medis/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pengkajian_awal_medis_json:JSON.stringify(survey.data),
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


    var survey_pengkajian_medis = new Survey.Model(surveyJSONpengkajianmedis);

    <?php if($pengkajian_medis){ ?>
    survey_pengkajian_medis.data = <?= $pengkajian_medis->formjson ?? '{}' ?>;
        <?php } else { 
            $keluhan = $data_irj->keluhan ?? ($data_igd->keluhan ?? '');
            $diagnosa = $data_irj->diagnosa ?? ($data_igd->diagnosa ?? '');
            $diagnosa = str_replace(['(utama)', '(tambahan)'], ["(utama)", "(tambahan)"], $diagnosa);
        ?>
            survey_pengkajian_medis.data = {
                "riwayat": <?= json_encode($keluhan) ?>,
                "question4": <?= json_encode($diagnosa) ?>,
                "td": "<?= isset($pem_fisik_last->sitolic) ? $pem_fisik_last->sitolic . '/' . $pem_fisik_last->diatolic .' '.'mmHg' : 'mmHg' ?>",
                "nadi": "<?=  isset($pem_fisik_last->nadi)?$pem_fisik_last->nadi.' '.'x/menit':'x/menit' ?>",
                "bb": "<?=  isset($pem_fisik_last->bb)?$pem_fisik_last->bb.' '.'Kg':'Kg' ?>",
                "suhu": "<?=  isset($pem_fisik_last->suhu)?$pem_fisik_last->suhu.' '.'°C':'°C' ?>",
                "pernafasan": "<?=  isset($pem_fisik_last->frekuensi_nafas)?$pem_fisik_last->frekuensi_nafas.' '.'x/menit':'x/menit' ?>",
                 "spo2": "<?= '%' ?>",
                "pemeriksaan_penunjang": <?= json_encode(isset($fisik_igd->fisik) ? $fisik_igd->fisik : '') ?>,
                "question8": <?= json_encode(isset($data_pengantar_ranap->terapi) ? $data_pengantar_ranap->terapi : '') ?>,
            };
        <?php } ?>
    

// survey.css = myCss;
$("#surveypengkajianawalmedis").Survey({
    model: survey_pengkajian_medis,
    onComplete: sendDataToServerpengkajianawalmedis
});
</script>