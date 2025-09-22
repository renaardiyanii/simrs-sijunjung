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
    <div id="SurveyPembCairan"></div>

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

surveyJSONPembCairan = <?php echo file_get_contents("pemberian_cairan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPembCairan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/pemberian_cairan/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                pemberian_cairan_json:JSON.stringify(survey.data),
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


    var survey_pem_cairan = new Survey.Model(surveyJSONPembCairan);
   

    <?php if($pemberiancairan->num_rows()){ ?>
		survey_pem_cairan.data = <?php echo $pemberiancairan->row()->formjson; ?>
	<?php } else {?>
        survey_pem_cairan.setValue('question2','<?= $data_pasien[0]['nmruang'] ?>');
    <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyPembCairan").Survey({
    model: survey_pem_cairan,
    onComplete: sendDataToServerPembCairan
});
</script>