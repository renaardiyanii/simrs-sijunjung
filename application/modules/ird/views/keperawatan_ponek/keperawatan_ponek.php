<?php  //var_dump($transfer_ruangan);
// var_dump();
$this->load->view('layout/header_form');
?>
<style>

</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>

<div id="SurveyKeperawatanPonek"></div>
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

var surveyJSONKeperawatanPonek = <?php echo file_get_contents(__DIR__ ."/catatan_ponek.json");?>;



function sendDataToServerKeperawatanPonek(survey) {

        $.ajax({
            type: "POST",
            url: '<?php echo base_url('ird/rdcpelayanan/insert_keperawatan_ponek/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                catatan_ponek_json:JSON.stringify(survey.data),
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


    var survey_kep_ponek = new Survey.Model(surveyJSONKeperawatanPonek);
    

    <?php
	if(isset($keperawatan_ponek)){ ?>
		survey_kep_ponek.data = <?= isset($keperawatan_ponek->formjson)?$keperawatan_ponek->formjson:'' ?>;

	<?php } else { ?>
        survey_kep_ponek.data = {
        "question3":"<?php 
            if(isset($diagnosa)){
                foreach($diagnosa as $diag){ 
                   echo  $diag->id_diagnosa.'-'.$diag->diagnosa.'('.$diag->klasifikasi_diagnos.')\n';
                }
            } 
            ?>",
        }
   <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyKeperawatanPonek").Survey({
    model: survey_kep_ponek,
    onComplete: sendDataToServerKeperawatanPonek
});
</script>