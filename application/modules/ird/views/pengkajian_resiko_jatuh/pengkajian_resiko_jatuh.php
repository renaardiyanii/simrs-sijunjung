<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div class="card m-5">
    <div class="body">
    <div id="Surveyresiko_jatuh_ponek"></div>

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

surveyJSONresiko_jatuh_ponek = <?php echo file_get_contents("pengkajian_resiko_jatuh.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerresiko_jatuh_ponek(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/pengkajian_resiko_jatuh/') ?>',
            data: {
                no_ipd : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                pengkajian_resiko_jatuh_json:JSON.stringify(survey.data),
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


    var survey_resiko_jatuh_ponek = new Survey.Model(surveyJSONresiko_jatuh_ponek);
    


    <?php if($resiko_jatuh_ponek){ ?>
		survey_resiko_jatuh_ponek.data = <?= $resiko_jatuh_ponek->formjson; ?>
	<?php }else{ ?>
        
      
        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#Surveyresiko_jatuh_ponek").Survey({
    model: survey_resiko_jatuh_ponek,
    onComplete: sendDataToServerresiko_jatuh_ponek
});
</script>