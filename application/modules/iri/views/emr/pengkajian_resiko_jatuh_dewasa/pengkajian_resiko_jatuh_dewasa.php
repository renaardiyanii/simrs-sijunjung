<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyresikojatuhdewasa"></div>

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

surveyJSONjatuhdewasa = <?php echo file_get_contents("pengkajian_resiko_jatuh_dewasa.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerjatuhdewasa(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/assesment_resiko_jatuh_dewasa/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pengkajian_resiko_jatuh_dewasa_json:JSON.stringify(survey.data),
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


    var survey_resiko_dewasa = new Survey.Model(surveyJSONjatuhdewasa);

    <?php if($resiko_jatuh_dewasa){ ?>
		survey_resiko_dewasa.data = <?php echo isset($resiko_jatuh_dewasa->formjson)?$resiko_jatuh_dewasa->formjson:''; ?>
	<?php }else{ ?>
        survey_resiko_dewasa.data =  {"question7":"<?= isset($ruang[0]['nmruang'])?$ruang[0]['nmruang']:''?>",
            "question6": <?= json_encode(isset($data_igd->diagnosa) ? str_replace(['(utama)', '(tambahan)'], ["(utama)", "(tambahan)"], $data_igd->diagnosa) : '') ?>,
       
        }

    <?php } ?>
    

// survey.css = myCss;
$("#surveyresikojatuhdewasa").Survey({
    model: survey_resiko_dewasa,
    onComplete: sendDataToServerjatuhdewasa
});
</script>