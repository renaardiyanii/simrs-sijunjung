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
    <div id="Surveytriaserd"></div>

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

surveyJSONTriaseIgd = <?php echo file_get_contents("formulir_triase.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerTriaseIgd(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/triase_igd/') ?>',
            data: {
                no_ipd : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                triase_igd_json:JSON.stringify(survey.data),
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


    var survey_triase_igd = new Survey.Model(surveyJSONTriaseIgd);
    


    <?php if($triase){ ?>
		survey_triase_igd.data = <?= $triase->formjson; ?>
	<?php }else{ ?>
        survey_triase_igd.data = {  "intervensi": {
        "pernafasan1": "<?= isset($data_fisik->pernafasan) ? $data_fisik->pernafasan : '' ?>"
        },
        "pernafasan": {
            "pernafasan": {
                "tanda_vital": "Nadi: <?= isset($data_fisik->nadi) ? $data_fisik->nadi . ' x/mnt' : '' ?>\nSuhu: <?= isset($data_fisik->suhu) ? $data_fisik->suhu . ' °C' : '' ?>\nPernafasan: <?= isset($data_fisik->pernafasan) ? $data_fisik->pernafasan . ' x/mnt' : '' ?>\nSp02: <?= isset($data_fisik->spotwo) ? $data_fisik->spotwo . '' : '' ?>"
            }
            },
        "jalan_nafas": {
        "jalan_nafas": {
            "tanda_vital": "Tekanan Darah : <?= isset($data_fisik->sitolic) ? $data_fisik->sitolic . '/' . $data_fisik->diatolic . ' mmHg' : '' ?>",
             }
        }




        }
      
        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#Surveytriaserd").Survey({
    model: survey_triase_igd,
    onComplete: sendDataToServerTriaseIgd
});
</script>