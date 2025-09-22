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
    <div id="SurveyPersetujuanDokter"></div>

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

surveyJSONPersetujuanDokter = <?php echo file_get_contents("persetujuan_dokter.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPersetujuanDokter(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/persetujuan_dokter/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
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
            //  console.log(JSON.stringify(survey.data));
        
        }


    var survey_persetujuan_dokter = new Survey.Model(surveyJSONPersetujuanDokter);
    
   
        survey_persetujuan_dokter.data = {"question11":{"Row 1":
            {"Column 1":"<?= $data_pasien[0]['nama'] ?>",
            "Column 2":"<?= date('Y-m-d',strtotime($data_pasien[0]['tgl_lahir'])) ?>",
            "Column 3":"<?= $data_pasien[0]['sex'] ?>",
            "Column 4":"<?= $data_pasien[0]['alamat'] ?>"}}}
       

    
	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyPersetujuanDokter").Survey({
    model: survey_persetujuan_dokter,
    onComplete: sendDataToServerPersetujuanDokter
});
</script>