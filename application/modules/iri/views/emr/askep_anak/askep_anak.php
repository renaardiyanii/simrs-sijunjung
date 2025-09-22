<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyaskepanak"></div>
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

surveyJSONaskepanak = <?php echo file_get_contents("askep_anak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServeraskep_anak(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_askep_anak/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                askep_anak_json:JSON.stringify(survey.data),
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


    var survey_askep_anak = new Survey.Model(surveyJSONaskepanak);

    <?php if($askep_anak){ ?>
		survey_askep_anak.data = <?php echo isset($askep_anak->formjson)?$askep_anak->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyaskepanak").Survey({
    model: survey_askep_anak,
    onComplete: sendDataToServeraskep_anak
});
document.getElementById("btnSimpan").addEventListener("click", function () {
    // Panggil fungsi sendDataToServercaperperioperatif dengan model survey yang benar
    sendDataToServeraskep_anak(survey_askep_anak);
});
</script>