<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>

<div id="SurveyMedikRehabAnak"></div>
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

var surveyJSONMedikRehabAnak = <?php echo file_get_contents(__DIR__ ."/medik_rehab_anak.json");?>;



function sendDataToServerMedikRehabAnak(survey) {

        $.ajax({
            type: "POST",
            url: '<?php echo base_url('irj/rjcpelayananfdokter/medik_rehab_irj/') ?>',
            data: {
                no_ipd : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                medik_rehab_json:JSON.stringify(survey.data),
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


    var survey_medik_rehab_anak = new Survey.Model(surveyJSONMedikRehabAnak);
    

    <?php if($pengkajian_rehab_medik->num_rows()){ ?>
		survey_medik_rehab_anak.data = <?= $pengkajian_rehab_medik->row()->formjson; ?>
	<?php }else{ ?>
        survey_medik_rehab_anak.data =
        {"question1":{"text1":"<?= $data_pasien_daftar_ulang->no_cm ?>",
            "text2":"<?= $data_pasien_daftar_ulang->nama ?>",
            "text3":"<?= date('d-m-Y',strtotime($data_pasien_daftar_ulang->tgl_lahir))?>",
           }};
        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyMedikRehabAnak").Survey({
    model: survey_medik_rehab_anak,
    onComplete: sendDataToServerMedikRehabAnak
});
</script>