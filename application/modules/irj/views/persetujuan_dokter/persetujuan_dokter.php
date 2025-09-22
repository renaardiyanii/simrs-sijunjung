<?php 

?>
<style>

</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>

<div id="SurveyPersetujuanDokterIRJ"></div>
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

var surveyJSONPersetujuanDokterRJ = <?php echo file_get_contents(__DIR__ ."/persetujuan_dokter.json");?>;



function sendDataToServerPersetujuanDokterRJ(survey) {

        $.ajax({
            type: "POST",
            url: '<?php echo base_url('iri/rictindakan/persetujuan_dokter/') ?>',
            data: {
                no_ipd : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                persetujuan_json:JSON.stringify(survey.data),
            },
            success: function(data)
            {
            
                location.reload();
                

            },
            error: function(data)
            {
                
            }
        }); 
             console.log(JSON.stringify(survey.data));
        
        }


    var survey_persetujuan_dokter_rj = new Survey.Model(surveyJSONPersetujuanDokterRJ);
    



	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyPersetujuanDokterIRJ").Survey({
    model: survey_persetujuan_dokter_rj,
    onComplete: sendDataToServerPersetujuanDokterRJ
});
</script>