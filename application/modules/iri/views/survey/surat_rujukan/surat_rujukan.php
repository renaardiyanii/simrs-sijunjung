<?php 
$this->load->view('layout/header_form');
// var_dump($data_pasien[0]);
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div class="card m-5">
    <div class="body">
    <div id="SurveySuratRujukan"></div>

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

surveyJSONSuratRujukan = <?php echo file_get_contents("surat_rujukan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerSuratRujukan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/surat_rujukan/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                surat_rujukan_json:JSON.stringify(survey.data),
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


    var survey_surat_rujukan = new Survey.Model(surveyJSONSuratRujukan);
    
   

    <?php if($surat_rujukan->num_rows()){ ?>
		survey_surat_rujukan.data = <?= $surat_rujukan->row()->formjson; ?>
	<?php }else{ ?>
        survey_surat_rujukan.data =  {"question2":[{"nama":"<?= $data_pasien[0]['nama'] ?>",
            // "no_kartu":"nhgn"
        }]};
        <?php } ?>

    
   







// survey.css = myCss;
$("#SurveySuratRujukan").Survey({
    model: survey_surat_rujukan,
    onComplete: sendDataToServerSuratRujukan
});
</script>