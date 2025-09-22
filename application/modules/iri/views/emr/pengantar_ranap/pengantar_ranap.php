<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypengantar_ranap"></div>

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

surveyJSONpengantar_ranap = <?php echo file_get_contents("pengantar_ranap.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpengantar_ranap(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_pengantar_ranap/') ?>',
            data: {
                no_register : '<?php echo $no_ipd;?>',
                pengantar_ranap_json:JSON.stringify(survey.data),
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


    var survey_pengantar_ranap = new Survey.Model(surveyJSONpengantar_ranap);

    <?php if($pengantar_ranap){ ?>
		survey_pengantar_ranap.data = <?php echo isset($pengantar_ranap->formjson)?$pengantar_ranap->formjson:''; ?>
	<?php }else{ ?>
        survey_pengantar_ranap.data = {
        "mohon": <?= json_encode(isset($data_pengantar_igd->mohon) ? $data_pengantar_igd->mohon : '') ?>,
        "ruangan": <?= json_encode(isset($data_pengantar_igd->ruangan) ? $data_pengantar_igd->ruangan : '') ?>,
        "terapi": <?= json_encode(
    (!empty($data_igd->rencana)) ? $data_igd->rencana : (!empty($data_pengantar_igd->terapi) ? $data_pengantar_igd->terapi : '')
) ?>,
        "ttd_hormat": <?= json_encode(isset($data_pengantar_igd->ttd_hormat) ? $data_pengantar_igd->ttd_hormat : '') ?>,
        "ttd": <?= json_encode(isset($data_pengantar_igd->ttd) ? $data_pengantar_igd->ttd : '') ?>,
        "ruangan4": <?= json_encode(isset($data_pengantar_igd->ruangan4) ? $data_pengantar_igd->ruangan4 : '') ?>,
        "question3": <?= json_encode(isset($data_pengantar_igd->question3) ? $data_pengantar_igd->question3 : '') ?>,
        "question4": <?= json_encode(isset($data_pengantar_igd->question4) ? $data_pengantar_igd->question4 : '') ?>,
        "ruangan6": <?= json_encode(isset($data_pengantar_igd->ruangan6) ? $data_pengantar_igd->ruangan6 : '') ?>,
        "question2": <?= json_encode(isset($data_pengantar_igd->question2) ? $data_pengantar_igd->question2 : '') ?>,
        "question5": <?= json_encode(isset($data_pengantar_igd->question5) ? $data_pengantar_igd->question5 : '') ?>,
        "question6": <?= json_encode(
                isset($diagnosa) ? implode("\n", array_map(function($diag) {
                    return $diag->id_diagnosa . '-' . $diag->diagnosa . ' (' . $diag->klasifikasi_diagnos . ')';
                }, $diagnosa)) : ''
            ) ?>,
        "question7": <?= json_encode(
            !empty($get_data_lab) ? 
            implode("\n", array_map(function($lab) {
                return '- Lab: ' . ($lab->jenis_tindakan ?? '');
            }, $get_data_lab)) : 
            (!empty($get_data_rad) ? 
            implode("\n", array_map(function($rad) {
                return '- Rad: ' . ($rad->jenis_tindakan ?? '');
            }, $get_data_rad)) : null)
        ) ?>,


        }

    <?php } ?>
    

// survey.css = myCss;
$("#surveypengantar_ranap").Survey({
    model: survey_pengantar_ranap,
    onComplete: sendDataToServerpengantar_ranap
});
</script>