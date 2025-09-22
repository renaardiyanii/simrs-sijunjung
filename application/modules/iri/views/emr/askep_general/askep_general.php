<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyaskepgeneral"></div>
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

surveyJSONaskepgeneral = <?php echo file_get_contents("askep_general_new.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServeraskepgeneral(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_askep_general/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                askep_general_new_json:JSON.stringify(survey.data),
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


    var survey_askep_general = new Survey.Model(surveyJSONaskepgeneral);

    <?php if($askep_general){ ?>
		survey_askep_general.data = <?php echo isset($askep_general->formjson)?$askep_general->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyaskepgeneral").Survey({
    model: survey_askep_general,
    onComplete: sendDataToServeraskepgeneral
});
document.getElementById("btnSimpan").addEventListener("click", function () {
    // Panggil fungsi sendDataToServercaperperioperatif dengan model survey yang benar
    sendDataToServeraskepgeneral(survey_askep_general);
});
</script>