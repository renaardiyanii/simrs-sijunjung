<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<div class="card m-5">
    <div class="body">
    <div id="SurveySuratPernyataanDNR"></div>

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

surveyJSONSuratPernyataanDNR = <?php echo file_get_contents("pernyataan_dnr.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerSuratPernyataanDNR(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/Surat_pernyataan_dnr/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                pernyataan_dnr_json:JSON.stringify(survey.data),
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


    var survey_surat_pernyataan_dnr = new Survey.Model(surveyJSONSuratPernyataanDNR);
    
   

   
        survey_surat_pernyataan_dnr.data =  {"question10":{"nama":"<?= $data_pasien[0]['nama'] ?>","tgl":"<?= date('d-m-Y',strtotime($data_pasien[0]['tgl_lahir'])) ?>"}}
      

    
   







// survey.css = myCss;
$("#SurveySuratPernyataanDNR").Survey({
    model: survey_surat_pernyataan_dnr,
    onComplete: sendDataToServerSuratPernyataanDNR
});
</script>