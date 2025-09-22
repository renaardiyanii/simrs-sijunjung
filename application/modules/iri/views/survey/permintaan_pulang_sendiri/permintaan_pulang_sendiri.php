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
    <div id="SurveyPermintaanPulangSendiri"></div>

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

surveyJSONPermintaanPulangSendiri = <?php echo file_get_contents("permintaan_pulang_sendiri.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPermintaanPulangSendiri(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/permintaan_pulang_sendiri/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                pulang_sendiri_json:JSON.stringify(survey.data),
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


    var survey_permintaan_pulang_sendiri = new Survey.Model(surveyJSONPermintaanPulangSendiri);
    
   

    <?php if($permintaan_pulang_sendiri->num_rows()){ ?>
		survey_permintaan_pulang_sendiri.data = <?= $permintaan_pulang_sendiri->row()->formjson; ?>
	<?php }else{ ?>
        survey_permintaan_pulang_sendiri.data = {"identitas":{"nama":"<?= $data_pasien[0]['nama'] ?>","no_rm":"<?= $data_pasien[0]['no_cm'] ?>","dirawat":"<?= $data_pasien[0]['nmruang'] ?>"}}
        <?php } ?>

    
   







// survey.css = myCss;
$("#SurveyPermintaanPulangSendiri").Survey({
    model: survey_permintaan_pulang_sendiri,
    onComplete: sendDataToServerPermintaanPulangSendiri
});
</script>