<?php 
// $this->load->view('layout/header_form');
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div class="card m-5">
    <div class="body">
    <div id="SurveyPernyataanUmum"></div>

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

surveyJSONPernyataanUmum = <?php echo file_get_contents("pernyataan_cara_bayar_umum.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPernyataanUmum(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/pernyataan_cara_bayar_umum/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                cara_bayar_umum_json:JSON.stringify(survey.data),
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


    var survey_pernyataan_cara_bayar_umum = new Survey.Model(surveyJSONPernyataanUmum);
    


    <?php if($pernyataan_cara_bayar_umum){ ?>
		survey_pernyataan_cara_bayar_umum.data = <?= $pernyataan_cara_bayar_umum->formjson; ?>
	<?php }else{ ?>
        // {"dari pasien yang nama tertera didalam label atas :":23424234}
        survey_pernyataan_cara_bayar_umum.data =  {"dari pasien yang nama tertera didalam label atas :":<?= isset($data_pasien[0]['no_kartu'])?$data_pasien[0]['no_kartu']:'' ;?>};
        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyPernyataanUmum").Survey({
    model: survey_pernyataan_cara_bayar_umum,
    onComplete: sendDataToServerPernyataanUmum
});
</script>