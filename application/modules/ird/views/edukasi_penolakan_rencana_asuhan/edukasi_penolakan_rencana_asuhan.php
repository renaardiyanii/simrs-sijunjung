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
    <div id="SurveyEdukasiPenolakanRencanaAsuhan"></div>

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

surveyJSONEdukasiPenolakanRencanaAsuhan = <?php echo file_get_contents("edukasi_penolakan_rencana_asuhan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerEdukasiPenolakanRencanaAsuhan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayanan/edukasi_penolakan_rencana_asuhan/') ?>',
            data: {
                no_ipd : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                edukasi_penolakan_rencana_asuhan_json:JSON.stringify(survey.data),
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


    var survey_edukasi_penolakan_rencana_asuhan = new Survey.Model(surveyJSONEdukasiPenolakanRencanaAsuhan);
    


    <?php if($edukasi_penolakan_rencana_asuhan){ ?>
		survey_edukasi_penolakan_rencana_asuhan.data = <?= $edukasi_penolakan_rencana_asuhan->formjson; ?>
	<?php }else{ ?>
        
      
        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyEdukasiPenolakanRencanaAsuhan").Survey({
    model: survey_edukasi_penolakan_rencana_asuhan,
    onComplete: sendDataToServerEdukasiPenolakanRencanaAsuhan
});
</script>