<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyDP"></div>

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

surveyJSONDP = <?php echo file_get_contents("dischard_planning.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerDP(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_dischard_planing/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                dischard_planing_json:JSON.stringify(survey.data),
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


    var survey_DPT = new Survey.Model(surveyJSONDP);

    <?php if($dischard_planing){ ?>
		survey_DPT.data = <?php echo isset($dischard_planing->formjson)?$dischard_planing->formjson:''; ?>
	<?php }else{ ?>
       
        survey_DPT.data = {"question13":"<?= isset($ruang[0]['nmruang'])?$ruang[0]['nmruang']:''?>",
            "question11": <?= json_encode(isset($pem_fisik_last->keluhan) ? $pem_fisik_last->keluhan : '') ?>,
            "question12": <?= json_encode(isset($data_igd->diagnosa) ? str_replace(['(utama)', '(tambahan)'], ["(utama)", "(tambahan)"], $data_igd->diagnosa) : '') ?>
        }
    <?php } ?>
    

// survey.css = myCss;
$("#surveyDP").Survey({
    model: survey_DPT,
    onComplete: sendDataToServerDP
});
</script>