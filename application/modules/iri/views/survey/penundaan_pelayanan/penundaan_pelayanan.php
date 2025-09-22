<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<div class="card m-5">
    <div class="body">
    <div id="SurveyPenundaanPelayanan"></div>

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

surveyJSONPenundaanPelayanan = <?php echo file_get_contents("penundaan_pelayanan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPenundaanPelayanan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/formulir_penundaan_pelayanan/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                penundaan_json:JSON.stringify(survey.data),
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


    var survey_penundaan_pelayanan = new Survey.Model(surveyJSONPenundaanPelayanan);
    
   

    <?php if($penundaan_pelayanan->num_rows()){ ?>
		survey_penundaan_pelayanan.data = <?= $penundaan_pelayanan->row()->formjson; ?>
	<?php }else{ ?>
        survey_penundaan_pelayanan.data =  {"question1":{"nama":"<?= $data_pasien[0]['nama'] ?>","poli":"<?= $data_pasien[0]['nm_ruang'] ?>"}},
        <?php } ?>

    
   







// survey.css = myCss;
$("#SurveyPenundaanPelayanan").Survey({
    model: survey_penundaan_pelayanan,
    onComplete: sendDataToServerPenundaanPelayanan
});
</script>