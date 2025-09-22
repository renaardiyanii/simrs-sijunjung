<?php 
$this->load->view('layout/header_form');
// var_dump($tindakan_hemodialisa);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyrencana_askep_hcu"></div>
<!-- Tombol simpan -->
<div class="btn-simpan-wrapper">
        <button id="btnSimpan" class="btn btn-success">Complete</button>
        </div>
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

surveyJSONrencana_askep_hcu = <?php echo file_get_contents("rencana_askep_hcu.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer_rencana_askep_hcu(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_rencana_askep_hcu/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                rencana_askep_hcu_json:JSON.stringify(survey.data),
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


    var survey_rencana_askep_hcu = new Survey.Model(surveyJSONrencana_askep_hcu);

    <?php if($rencana_askep_hcu){ ?>
		survey_rencana_askep_hcu.data = <?php echo isset($rencana_askep_hcu->formjson)?$rencana_askep_hcu->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyrencana_askep_hcu").Survey({
    model: survey_rencana_askep_hcu,
    onComplete: sendDataToServer_rencana_askep_hcu
});
document.getElementById("btnSimpan").addEventListener("click", function () {
    // Panggil fungsi sendDataToServercaperperioperatif dengan model survey yang benar
    sendDataToServer_rencana_askep_hcu(survey_rencana_askep_hcu);
});
</script>