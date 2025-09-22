<?php 
$test = isset($persiapan_operasi[0]->formjson)?json_decode($persiapan_operasi[0]->formjson):'';
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="SurveyPembedahanAnestesiLokal"></div>
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

surveyJSONAnestesiLokal = <?php echo file_get_contents("pembedahan_anestesi_lokal.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerAnestesiLokal(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/pembedahan_anestesi_lokal/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                pembedahan_json:JSON.stringify(survey.data),
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


    var survey_anestesi_lokal = new Survey.Model(surveyJSONAnestesiLokal);
    

    <?php if($laporan_pembedahan->num_rows()){ ?>
		survey_anestesi_lokal.data = <?= $laporan_pembedahan->row()->formjson; ?>
	<?php }else{ ?>
        survey_anestesi_lokal.data = {"question1":{"ahli_bedah":"<?= isset($test->operasi->dokter_bedah)?$test->operasi->dokter_bedah:'' ?>"}}
        <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyPembedahanAnestesiLokal").Survey({
    model: survey_anestesi_lokal,
    onComplete: sendDataToServerAnestesiLokal
});
</script>